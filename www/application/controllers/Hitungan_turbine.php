<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class hitungan_turbine extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Tambahkan logika keamanan di sini jika diperlukan
		$this->load->model('m_hitung_turbine'); // Sesuaikan dengan nama model Anda
	    $this->load->helper('number');
    }

	public function index()
	{
        $energy_list = $this->m_hitung_turbine->get_all_data();
        
        // Ambil detail data untuk setiap energy
        $energy_details = array();
        foreach ($energy_list as $e) {
            $energy_details[$e->id_energy] = $this->m_hitung_turbine->get_detail_by_energy_id($e->id_energy);
        }
        
        $data=array(
            'judul'=>'Hitung Turbine',
			'energy'=> $energy_list,
			'energy_details' => $energy_details,
			'page'=>'v_hitungan',
        );
		$this->load->view('v_template',$data,false);
		
	}

    
public function tambah_hitungan() {
    // $this->load->library('form_validation');
    // $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|callback_valid_date');

    // if ($this->form_validation->run() === FALSE) {
    //     // Jika validasi gagal, kembalikan pesan error
    //     $this->output->set_status_header(400);
    //     echo validation_errors();
    //     return;
    // }

    $tanggal = $this->input->post('tanggal');
    // Validasi apakah tanggal sudah diisi
    if (empty($tanggal)) {
        // Return appropriate HTTP status code for validation failure
        $this->output->set_status_header(400);
        echo json_encode(array('success' => false, 'error' => 'Tanggal harus diisi'));
        return;
    }

    // Validasi apakah tanggal sudah ada di database
    if ($this->m_hitung_turbine->cek_tanggal_ada($tanggal)) {
        // Jika tanggal sudah ada, return error
        $this->output->set_status_header(400);
        echo json_encode(array('success' => false, 'error' => 'Tanggal yang sama sudah ada di database. Silakan pilih tanggal lain.'));
        return;
    }

    // Memanggil fungsi add_hitungan dengan data_jam yang sesuai
    $data_jam = array(
        'id_jam_15' => 0,  // Ganti dengan nilai yang sesuai
        'id_jam_23' => 0,  // Ganti dengan nilai yang sesuai
        'id_jam_07' => 0,  // Ganti dengan nilai yang sesuai
        // ... tambahkan kolom-kolom lainnya jika diperlukan
    );

    $id_energy = $this->m_hitung_turbine->add_hitungan($tanggal, $data_jam);
    echo json_encode(array('success' => true, 'id_energy' => $id_energy));
}

// public function tambah_hitungan(){
//     $tanggal = $this->input->post('tanggal');
    
//     // Validasi apakah tanggal sudah diisi
//     if (empty($tanggal)) {
//         // Return appropriate HTTP status code for validation failure
//         $this->output->set_status_header(400);
//         echo json_encode(array('error' => 'Tanggal harus diisi'));
//         return;
//     }

//     // Memanggil fungsi add_hitungan dengan data_jam yang sesuai
//     $data_jam = array(
//         'id_jam_15' => 0,  // Ganti dengan nilai yang sesuai
//         'id_jam_23' => 0,  // Ganti dengan nilai yang sesuai
//         'id_jam_07' => 0,  // Ganti dengan nilai yang sesuai
//         // ... tambahkan kolom-kolom lainnya jika diperlukan
//     );
//     $id_energy = $this->m_hitung_turbine->add_hitungan($tanggal, $data_jam);

//     // Return success message if needed
//     echo json_encode(array('success' => true, 'id_energy' => $id_energy));
// }



public function mulai_hitung($id_energy = NULL) {
    $energies = $this->m_hitung_turbine->detail_hitung($id_energy);
    if (!$energies) {
        show_error("Data dengan ID $id_energy tidak ditemukan.", 404, 'Kesalahan Data');
        return;
    }

    // Cari ID energy sebelumnya yang masih ada di database
    $previous_id = $this->m_hitung_turbine->get_previous_id_energy($id_energy);
    
    // Jika tidak ada data sebelumnya, set ke NULL
    if (!$previous_id) {
        $previous_id = NULL;
    }

    $combined_data = $this->m_hitung_turbine->get_combined_energy_data($id_energy, $previous_id);

      if (empty($combined_data)) {
            show_error("Data tidak ditemukan untuk ID $id_energy", 404, 'Kesalahan Data');
            return;
        }
// var_dump($combined_data);
    $data = array(
        'judul' => 'Hitung Turbine',
        'energies' => $energies,
         'combined_data' => $combined_data,
        'page' => 'v_turbine'
        
    );
    $this->load->view('v_template', $data, false);
    
}



public function delete($id_energy) {
    // Check if ID Energy is provided
    if ($id_energy) {
        // Call model function to delete energy data
        $result = $this->m_hitung_turbine->delete_energy($id_energy);
        if ($result) {
            // If deletion is successful
            // Set flash message or any other logic here
            redirect('hitungan_turbine'); // Redirect to energy list page
        } else {
            // If deletion fails
            // Set flash message or any other logic here
            echo "Failed to delete energy data!";
        }
    } else {
        // If ID Energy is not provided
        // Set flash message or any other logic here
        echo "ID Energy is required!";
    }
}


public function simpan()
{
    // ===========================================================
    // LANGKAH 1: TERIMA DATA DARI JAVASCRIPT (AJAX)
    // ===========================================================
    
    // Ambil data mentah yang dikirim
    $json_masuk = file_get_contents('php://input');
    // Ubah JSON menjadi Array PHP agar bisa dibaca
    $data_dari_js = json_decode($json_masuk, true);

    // Cek: Kalau tidak ada data, stop di sini.
    if (!$data_dari_js) {
        echo json_encode(['status' => false, 'message' => 'Tidak ada data dikirim']);
        return;
    }

    $id_energy = $data_dari_js['id_energy'];

    // ===========================================================
    // LANGKAH 2: SIAPKAN DATABASE (TRANSAKSI)
    // ===========================================================
    // Kita pakai 'trans_start' agar jika ada error di tengah jalan,
    // semua perubahan dibatalkan (Rollback). Data jadi aman.
    $this->db->trans_start();

    // Kita butuh data energy saat ini untuk mengecek:
    // "Apakah jam 15 sudah pernah diisi sebelumnya atau belum?"
    $data_energy_sekarang = $this->db->get_where('energy', ['id_energy' => $id_energy])->row();

    // Daftar tabel jam yang akan kita proses
    $daftar_shift = ['jam_15', 'jam_23', 'jam_07', 'jam_19'];

    // ===========================================================
    // LANGKAH 3: PROSES SETIAP SHIFT (LOOPING)
    // ===========================================================
    
    foreach ($daftar_shift as $nama_tabel_jam) {
        
        // Cek 1: Apakah JavaScript mengirim data untuk jam ini?
        // (Contoh: Hari biasa tidak mengirim jam_19, jadi kita lewati)
        if (isset($data_dari_js[$nama_tabel_jam])) {
            
            $data_input = $data_dari_js[$nama_tabel_jam];

            // Cek 2: Pastikan data tidak kosong (Minimal kwh turbine/pln terisi)
            if ($data_input["kwh_turbine"] === "" && $data_input["kwh_pln"] === "") {
                continue; // Lewati shift ini, lanjut ke shift berikutnya
            }

            // --- PERSIAPAN DATA ---
            // Ambil angka belakangnya (contoh: dari 'jam_15' ambil '15')
            $kode_angka = substr($nama_tabel_jam, 4); 

            // Masukkan data ke array sesuai nama kolom di database Anda
            $data_siap_simpan = [
                "kwh_synchro_$kode_angka"   => $data_input['kwh_synchro'],
                "kwh_turbine_$kode_angka"   => $data_input['kwh_turbine'],
                "kwh_pln_$kode_angka"       => $data_input['kwh_pln'],
                "hasil_turbine_$kode_angka" => $data_input['hasil_turbine'],
                "hasil_pln_$kode_angka"     => $data_input['hasil_pln'],
            ];

            // --- CEK APAKAH HARUS INSERT (BARU) ATAU UPDATE (EDIT) ---
            
            // Nama kolom ID di tabel energy, misal: id_jam_15
            $nama_kolom_id = "id_" . $nama_tabel_jam; 
            
            // Ambil ID yang tersimpan di tabel energy saat ini
            $id_jam_sudah_ada = $data_energy_sekarang->$nama_kolom_id;

            if (!empty($id_jam_sudah_ada)) {
                // KONDISI A: SUDAH ADA DATA (UPDATE)
                // Panggil Model untuk update data lama
                $this->m_hitung_turbine->update_jam($nama_tabel_jam, $id_jam_sudah_ada, $data_siap_simpan);
            } else {
                // KONDISI B: BELUM ADA DATA (INSERT BARU)
                // 1. Simpan ke tabel jam (misal jam_15), lalu ambil ID barunya
                $id_baru = $this->m_hitung_turbine->insert_jam($nama_tabel_jam, $data_siap_simpan);
                
                // 2. Sambungkan ID baru tersebut ke tabel energy
                $this->m_hitung_turbine->update_energy_link($id_energy, $nama_kolom_id, $id_baru);
            }
        }
    }

    // 2. TAMBAHAN: Proses Simpan ke Tabel Hours & Hasil
    if (isset($data_dari_js['ringkasan']) && isset($data_dari_js['jam_operasi'])) {
        $this->m_hitung_turbine->simpan_ringkasan_hasil(
            $id_energy, 
            $data_dari_js['jam_operasi'], 
            $data_dari_js['ringkasan']
        );
    }
    // ===========================================================
    // LANGKAH 4: SELESAI & KIRIM JAWABAN
    // ===========================================================
    
    $this->db->trans_complete(); // Tutup transaksi database

    if ($this->db->trans_status() === FALSE) {
        // Jika ada error database
        echo json_encode(['status' => false, 'message' => 'Gagal menyimpan ke database.']);
    } else {
        // Jika sukses
        echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan!']);
    }
}


}
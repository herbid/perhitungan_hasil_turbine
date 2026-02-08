<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class M_hitung_turbine extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_data(){
      
        $this->db->select('*');
        
        $this->db->from('energy');
  
        $this->db->order_by('time', 'desc');
        return $this->db->get()->result();
     
    }
    
    public function add_hitungan($tanggal, $data_jam = array()){
        // Insert data 'time' into the 'energy' table
        $this->db->insert('energy', array('time' => $tanggal));
    
        // Get the ID of the last inserted row
        $id_energy = $this->db->insert_id();
    
        // Check if $data_jam is not empty before updating
        if (!empty($data_jam)) {
            // Add additional data (id_jam_15, id_jam_23, id_jam_07) with the obtained ID
            $data_jam['id_energy'] = $id_energy;
            $this->db->update('energy', $data_jam, array('id_energy' => $id_energy));
        }
    
        // Return the ID of the newly inserted energy
        return $id_energy;
    }
        // TAMBAHKAN FUNGSI INI
        public function cek_tanggal_ada($tanggal) {
            $this->db->where('time', $tanggal);
            $query = $this->db->get('energy');
            return ($query->num_rows() > 0); // Mengembalikan true jika sudah ada
        }
    
  
    public function detail_hitung($id_energy) {
        $this->db->select('energy.id_energy, energy.time, 
            jam_15.kwh_synchro_15, jam_15.kwh_turbine_15, jam_15.kwh_pln_15, jam_15.hasil_turbine_15, jam_15.hasil_pln_15,
            jam_23.kwh_synchro_23, jam_23.kwh_turbine_23, jam_23.kwh_pln_23, jam_23.hasil_turbine_23, jam_23.hasil_pln_23,
            jam_19.kwh_synchro_19, jam_19.kwh_turbine_19, jam_19.kwh_pln_19, jam_19.hasil_turbine_19, jam_19.hasil_pln_19,
            jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, jam_07.hasil_turbine_07, jam_07.hasil_pln_07');
        $this->db->from('energy');
        $this->db->where('energy.id_energy', $id_energy);
        $this->db->join('jam_15', 'energy.id_jam_15 = jam_15.id_jam_15', 'left');
        $this->db->join('jam_23', 'energy.id_jam_23 = jam_23.id_jam_23', 'left');
        $this->db->join('jam_19', 'energy.id_jam_19 = jam_19.id_jam_19', 'left');
        $this->db->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left');
       
        return $this->db->get()->row();
    }
    
    public function get_combined_energy_data($current_id, $previous_id) {
    // --- QUERY 1 (Data Sekarang) ---
    $query1 = $this->db->select('energy.id_energy, energy.time, 
                jam_15.kwh_synchro_15, jam_15.kwh_turbine_15, jam_15.kwh_pln_15, 
                jam_15.hasil_turbine_15, jam_15.hasil_pln_15,
                jam_23.kwh_synchro_23, jam_23.kwh_turbine_23, jam_23.kwh_pln_23, 
                jam_23.hasil_turbine_23, jam_23.hasil_pln_23,
                jam_19.kwh_synchro_19, jam_19.kwh_turbine_19, jam_19.kwh_pln_19, 
                jam_19.hasil_turbine_19, jam_19.hasil_pln_19,
                jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, 
                jam_07.hasil_turbine_07, jam_07.hasil_pln_07,
                hasil.avg_turbine, hasil.avg_synchro, hasil.avg_pln,
                hasil.day_turbine, hasil.day_synchro, hasil.day_pln,
                hasil.month_turbine, hasil.month_synchro, hasil.month_pln,
                hours.turbine_jam, hours.synchro_jam, hours.pln_jam'
                )
            ->from('energy')
            ->join('jam_15', 'energy.id_jam_15 = jam_15.id_jam_15', 'left')
            ->join('jam_23', 'energy.id_jam_23 = jam_23.id_jam_23', 'left')
            ->join('jam_19', 'energy.id_jam_19 = jam_19.id_jam_19', 'left')
            ->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left')
            ->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
            ->join('hours', 'hasil.id_hours = hours.id_hours', 'left')
            ->where('energy.id_energy', $current_id)
            ->get_compiled_select();

    // --- QUERY 2 (Data Sebelumnya) ---
    $query2 = $this->db->select('energy.id_energy, energy.time, 
                jam_15.kwh_synchro_15, jam_15.kwh_turbine_15, jam_15.kwh_pln_15, 
                jam_15.hasil_turbine_15, jam_15.hasil_pln_15,
                jam_23.kwh_synchro_23, jam_23.kwh_turbine_23, jam_23.kwh_pln_23, 
                jam_23.hasil_turbine_23, jam_23.hasil_pln_23,
                jam_19.kwh_synchro_19, jam_19.kwh_turbine_19, jam_19.kwh_pln_19, 
                jam_19.hasil_turbine_19, jam_19.hasil_pln_19,
                jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, 
                jam_07.hasil_turbine_07, jam_07.hasil_pln_07,
                hasil.avg_turbine, hasil.avg_synchro, hasil.avg_pln,
                hasil.day_turbine, hasil.day_synchro, hasil.day_pln,
                hasil.month_turbine, hasil.month_synchro, hasil.month_pln,
                hours.turbine_jam, hours.synchro_jam, hours.pln_jam'
                )
            ->from('energy')
            ->join('jam_15', 'energy.id_jam_15 = jam_15.id_jam_15', 'left')
            ->join('jam_23', 'energy.id_jam_23 = jam_23.id_jam_23', 'left')
            ->join('jam_19', 'energy.id_jam_19 = jam_19.id_jam_19', 'left')
            ->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left')
            ->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
            ->join('hours', 'hasil.id_hours = hours.id_hours', 'left')
            ->where('energy.id_energy', $previous_id)
            ->get_compiled_select();

    return $this->db->query("$query1 UNION ALL $query2")->result();
}
    
public function simpan_ringkasan_hasil($id_energy, $jam_op, $ringkasan) {
    // Cek apakah data di tabel 'hasil' sudah ada untuk id_energy ini
    $cek_hasil = $this->db->get_where('hasil', ['id_energy' => $id_energy])->row();

    $data_hours = [
        'turbine_jam' => $jam_op['turbine'],
        'synchro_jam' => $jam_op['synchro'],
        'pln_jam'     => $jam_op['pln']
    ];

    $data_hasil = [
        'id_energy'     => $id_energy,
        'avg_turbine'   => $ringkasan['avg_turbine'],
        'avg_synchro'   => $ringkasan['avg_synchro'],
        'avg_pln'       => $ringkasan['avg_pln'],
        'day_turbine'   => $ringkasan['day_turbine'],
        'day_synchro'   => $ringkasan['day_synchro'],
        'day_pln'       => $ringkasan['day_pln'],
        'month_turbine' => $ringkasan['month_turbine'] ?? 0, // Bisa disesuaikan nanti
        'month_synchro' => $ringkasan['month_synchro'] ?? 0,
        'month_pln'     => $ringkasan['month_pln'] ?? 0
    ];

    if ($cek_hasil) {
        // --- PROSES EDIT (UPDATE) ---
        // Update jam operasi
        $this->db->where('id_hours', $cek_hasil->id_hours);
        $this->db->update('hours', $data_hours);

        // Update hasil summary
        $this->db->where('id_hasil', $cek_hasil->id_hasil);
        $this->db->update('hasil', $data_hasil);
    } else {
        // --- PROSES BARU (INSERT) ---
        // 1. Simpan ke tabel hours
        $this->db->insert('hours', $data_hours);
        $id_hours_baru = $this->db->insert_id();

        // 2. Simpan ke tabel hasil
        $data_hasil['id_hours'] = $id_hours_baru;
        $this->db->insert('hasil', $data_hasil);
    }
}
   
    
    public function delete_energy($id_energy) {
        // Check if ID Energy exists
        $this->db->where('id_energy', $id_energy);
        $query = $this->db->get('energy');
        if ($query->num_rows() > 0) {
            // Get energy data to find related jam and hasil records
            $energy_data = $query->row();
            
            // Get hasil data to find related hours records
            $this->db->where('id_energy', $id_energy);
            $hasil_query = $this->db->get('hasil');
            $hasil_data = $hasil_query->result();
            
            // Delete from hasil table first (has foreign key to hours)
            $this->db->where('id_energy', $id_energy);
            $this->db->delete('hasil');
            
            // Delete hours records
            foreach ($hasil_data as $hasil) {
                if (!empty($hasil->id_hours)) {
                    $this->db->where('id_hours', $hasil->id_hours);
                    $this->db->delete('hours');
                }
            }
            
            // Delete jam records that are no longer referenced
            if (!empty($energy_data->id_jam_15)) {
                $this->db->where('id_jam_15', $energy_data->id_jam_15);
                $this->db->delete('jam_15');
            }
            if (!empty($energy_data->id_jam_23)) {
                $this->db->where('id_jam_23', $energy_data->id_jam_23);
                $this->db->delete('jam_23');
            }
            if (!empty($energy_data->id_jam_19)) {
                $this->db->where('id_jam_19', $energy_data->id_jam_19);
                $this->db->delete('jam_19');
            }
            if (!empty($energy_data->id_jam_07)) {
                $this->db->where('id_jam_07', $energy_data->id_jam_07);
                $this->db->delete('jam_07');
            }
            
            // Finally delete from energy table
            $this->db->where('id_energy', $id_energy);
            $this->db->delete('energy');
            return true; // Return true if deletion is successful
        } else {
            return false; // Return false if ID Energy does not exist
        }
    }

    public function get_previous_id_energy($id_energy) {
        // Mencari ID energy sebelumnya yang masih ada di database
        // Query mencari id_energy terbesar yang lebih kecil dari parameter $id_energy
        $this->db->select('id_energy');
        $this->db->from('energy');
        $this->db->where('id_energy <', $id_energy);
        $this->db->order_by('id_energy', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->id_energy;
        }
        return NULL;
    }

// Insert data baru ke tabel jam (15, 23, 07, 19)
public function insert_jam($table, $data) {
    $this->db->insert($table, $data);
    return $this->db->insert_id(); // Mengembalikan ID yang baru dibuat
}

// Update data yang sudah ada
public function update_jam($table, $id, $data) {
    // Tentukan nama kolom primary key, misal id_jam_15
    $pk = "id_" . $table; 
    $this->db->where($pk, $id);
    $this->db->update($table, $data);
}

// Update tabel energy untuk menyambungkan Foreign Key
public function update_energy_link($id_energy, $col_jam, $id_jam_baru) {
    $this->db->where('id_energy', $id_energy);
    $this->db->update('energy', array($col_jam => $id_jam_baru));
}

// Ambil detail data per energy untuk ditampilkan di modal
public function get_detail_by_energy_id($id_energy) {
    $this->db->select('energy.id_energy, energy.time,
        jam_15.kwh_synchro_15, jam_15.kwh_turbine_15, jam_15.kwh_pln_15, jam_15.hasil_turbine_15, jam_15.hasil_pln_15,
        jam_23.kwh_synchro_23, jam_23.kwh_turbine_23, jam_23.kwh_pln_23, jam_23.hasil_turbine_23, jam_23.hasil_pln_23,
        jam_19.kwh_synchro_19, jam_19.kwh_turbine_19, jam_19.kwh_pln_19, jam_19.hasil_turbine_19, jam_19.hasil_pln_19,
        jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, jam_07.hasil_turbine_07, jam_07.hasil_pln_07,
        hasil.avg_turbine, hasil.avg_synchro, hasil.avg_pln,
        hasil.day_turbine, hasil.day_synchro, hasil.day_pln,
        hasil.month_turbine, hasil.month_synchro, hasil.month_pln,
        hours.turbine_jam, hours.synchro_jam, hours.pln_jam');
    $this->db->from('energy');
    $this->db->where('energy.id_energy', $id_energy);
    $this->db->join('jam_15', 'energy.id_jam_15 = jam_15.id_jam_15', 'left');
    $this->db->join('jam_23', 'energy.id_jam_23 = jam_23.id_jam_23', 'left');
    $this->db->join('jam_19', 'energy.id_jam_19 = jam_19.id_jam_19', 'left');
    $this->db->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left');
    $this->db->join('hasil', 'hasil.id_energy = energy.id_energy', 'left');
    $this->db->join('hours', 'hasil.id_hours = hours.id_hours', 'left');
    
    return $this->db->get()->row();
}

}
?>

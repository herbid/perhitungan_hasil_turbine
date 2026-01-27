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
        $query1 = $this->db->select('energy.id_energy, energy.time, 
                jam_15.kwh_synchro_15, jam_15.kwh_turbine_15, jam_15.kwh_pln_15, 
                jam_15.hasil_turbine_15, jam_15.hasil_pln_15,
                jam_23.kwh_synchro_23, jam_23.kwh_turbine_23, jam_23.kwh_pln_23, 
                jam_23.hasil_turbine_23, jam_23.hasil_pln_23,
                jam_19.kwh_synchro_19, jam_19.kwh_turbine_19, jam_19.kwh_pln_19, 
                jam_19.hasil_turbine_19, jam_19.hasil_pln_19,
                jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, 
                jam_07.hasil_turbine_07, jam_07.hasil_pln_07'
                )
            ->from('energy')
            ->join('jam_15', 'energy.id_jam_15 = jam_15.id_jam_15', 'left')
            ->join('jam_23', 'energy.id_jam_23 = jam_23.id_jam_23', 'left')
            ->join('jam_19', 'energy.id_jam_19 = jam_19.id_jam_19', 'left')
            ->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left')
            
            ->where('energy.id_energy', $current_id)
            ->get_compiled_select();

        $query2 = $this->db->select('energy.id_energy, energy.time, 
                NULL AS kwh_synchro_15, NULL AS kwh_turbine_15, NULL AS kwh_pln_15, 
                NULL AS hasil_turbine_15, NULL AS hasil_pln_15,
                NULL AS kwh_synchro_23, NULL AS kwh_turbine_23, NULL AS kwh_pln_23, 
                NULL AS hasil_turbine_23, NULL AS hasil_pln_23,
                NULL AS kwh_synchro_19, NULL AS kwh_turbine_19, NULL AS kwh_pln_19, 
                NULL AS hasil_turbine_19, NULL AS hasil_pln_19,
                jam_07.kwh_synchro_07, jam_07.kwh_turbine_07, jam_07.kwh_pln_07, 
                jam_07.hasil_turbine_07, jam_07.hasil_pln_07')
            ->from('energy')
            ->join('jam_07', 'energy.id_jam_07 = jam_07.id_jam_07', 'left')
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
        'month_turbine' => 0, // Bisa disesuaikan nanti
        'month_synchro' => 0,
        'month_pln'     => 0
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
            // If ID Energy exists, perform deletion
            $this->db->where('id_energy', $id_energy);
            $this->db->delete('energy');
            return true; // Return true if deletion is successful
        } else {
            return false; // Return false if ID Energy does not exist
        }
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


}
?>

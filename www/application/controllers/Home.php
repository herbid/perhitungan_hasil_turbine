<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Tambahkan logika keamanan di sini jika diperlukan
    }

	public function index()
	{
		$this->load->model('M_hitung_turbine');
		
		// Get latest energy data dengan hasil (day_turbine) yang sudah terisi
		$latest_data_day_turbine = $this->db->select('energy.id_energy, energy.time, hasil.day_turbine')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->where('hasil.day_turbine !=', 0)
			->order_by('energy.id_energy', 'desc')
			->limit(1)
			->get()
			->row();

			$latest_data_day_pln = $this->db->select('energy.id_energy, energy.time, hasil.day_pln')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->where('hasil.day_pln !=', 0)
			->order_by('energy.id_energy', 'desc')
			->limit(1)
			->get()
			->row();

			$latest_data_jam_operasi_turbine = $this->db->select('energy.id_energy, energy.time, hours.turbine_jam')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->join('hours', 'hasil.id_hours = hours.id_hours', 'left')
			->where('hours.turbine_jam !=', 0)
			->order_by('energy.id_energy', 'desc')
			->limit(1)
			->get()
			->row();

			$latest_data_avg_operasi_turbine = $this->db->select('energy.id_energy, hasil.avg_turbine')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->where('hasil.avg_turbine !=', 0)
			->order_by('energy.id_energy', 'desc')
			->limit(1)
			->get()
			->row();
		
        $data=array(
            'judul'=>'Home',
			'subjudul'=>'',
			'page'=>'v_dashboard',
			'day_turbine' => $latest_data_day_turbine ? $latest_data_day_turbine->day_turbine : '0',
			'day_pln' => $latest_data_day_pln ? $latest_data_day_pln->day_pln : '0',
			'jam_operasi_turbine' => $latest_data_jam_operasi_turbine ? $latest_data_jam_operasi_turbine->turbine_jam : '0',
			'avg_operasi_turbine' => $latest_data_avg_operasi_turbine ? $latest_data_avg_operasi_turbine->avg_turbine : '0',
			
        );
		$this->load->view('v_template',$data,false);
		
	}
}

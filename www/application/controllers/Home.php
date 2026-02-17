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
		
		// Get last 5 day_turbine records with dates for bar chart
		$chart_data_results = $this->db->select('energy.time, hasil.day_turbine')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->where('hasil.day_turbine !=', 0)
			->order_by('energy.time', 'desc')
			->limit(7)
			->get()
			->result();
		
		// Reverse to show chronological order (oldest to newest)
		$chart_data_results = array_reverse($chart_data_results);
		
		// Format data for chart
		$chart_data = array();
		foreach ($chart_data_results as $row) {
			$date = date('d/m/Y', strtotime($row->time));
			$chart_data[] = array($date, floatval($row->day_turbine));
		}
		
		// Get last 5 day_pln records with dates for line chart
		$line_chart_data_results = $this->db->select('energy.time, hasil.day_pln')
			->from('energy')
			->join('hasil', 'hasil.id_energy = energy.id_energy', 'left')
			->where('hasil.day_pln !=', 0)
			->order_by('energy.time', 'desc')
			->limit(7)
			->get()
			->result();
		
		// Reverse to show chronological order (oldest to newest)
		$line_chart_data_results = array_reverse($line_chart_data_results);
		
		// Format data for line chart
		$line_chart_data = array();
		foreach ($line_chart_data_results as $row) {
			$date = date('d/m/Y', strtotime($row->time));
			$line_chart_data[] = array($date, floatval($row->day_pln));
		}
		
        $data=array(
            'judul'=>'Home',
			'subjudul'=>'',
			'page'=>'v_dashboard',
			'day_turbine' => $latest_data_day_turbine ? $latest_data_day_turbine->day_turbine : '0',
			'day_pln' => $latest_data_day_pln ? $latest_data_day_pln->day_pln : '0',
			'jam_operasi_turbine' => $latest_data_jam_operasi_turbine ? $latest_data_jam_operasi_turbine->turbine_jam : '0',
			'avg_operasi_turbine' => $latest_data_avg_operasi_turbine ? $latest_data_avg_operasi_turbine->avg_turbine : '0',
			'chart_data' => json_encode($chart_data),
			'line_chart_data' => json_encode($line_chart_data)
        );
		$this->load->view('v_template',$data,false);
		
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {
	public function __construct() {
        parent::__construct();
        // Tambahkan logika keamanan di sini jika diperlukan
    }

	public function index()
	{
        $data=array(
            'judul'=>'Home',
			'subjudul'=>'',
			'page'=>'v_dashboard',
        );
		$this->load->view('v_template',$data,false);
		
	}
}

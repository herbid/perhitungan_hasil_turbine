<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

	public function index()
	{
        $data=array(
            'judul'=>'User',
			'subjudul'=>'',
			'page' =>'v_user',
        );
		$this->load->view('v_template',$data,false);
		
	}
}

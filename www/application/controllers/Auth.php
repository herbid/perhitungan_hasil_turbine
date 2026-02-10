<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_auth');
    }

    public function login() {
        $data['error'] = $this->session->flashdata('error'); // Mendapatkan pesan kesalahan dari session
        $this->load->view('v_login');
    }

    public function process_login() {

        
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            // Jika username atau password kosong, set pesan kesalahan
            $this->session->set_flashdata('warning', 'Username dan Password harus diisi.');
            redirect('auth/login');
        }

        if ($this->m_auth->check_login($username, $password)) {
            // Jika login berhasil, set pesan sukses dan redirect ke halaman home
            $this->session->set_flashdata('success', 'Login berhasil.');
            redirect('home');
        } else {
            // Jika login gagal, set pesan kesalahan
            $this->session->set_flashdata('error', 'Username atau Password salah.');
            redirect('auth/login');
        }
    }

        public function logout_user(){
        // Hapus data sesi atau lakukan operasi logout lainnya
        $this->session->sess_destroy();
        // Redirect ke halaman login
        redirect('auth/login');}
        }

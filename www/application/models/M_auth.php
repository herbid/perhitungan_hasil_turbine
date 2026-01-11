<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class M_auth extends CI_Model {

    public function check_login($username, $password) {
        $query = $this->db->get_where('user', array('username' => $username, 'password' => $password));

        return $query->num_rows() > 0;
    }
}
?>
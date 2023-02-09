<?php
class General {
	var $ci;

	function __construct() {
        $this->ci = &get_instance();
//        $this->isLogin();
    }
    
	function isLogin() {
        if ($this->ci->session->userdata('is_login') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	function cekUserLogin() {
        if ($this->isLogin() != TRUE) {
            $this->ci->session->set_flashdata('message', 'Silahkan Login');
            redirect('users/login');
        }
    }

    function cekAdminLogin() {
        if ($this->isLogin() == TRUE) {
            if ($this->ci->session->userdata('level') != 'superuser') {
                $this->ci->session->set_flashdata('message', 'Akses Ditolak demi alasan keamanan');
                redirect('stminlog/log_view_st21');
            }
        } else {
            $this->ci->session->set_flashdata('message', 'Anda tidak memiliki hak akses halaman Administrator');
            redirect('users/login');
        }
    }
}
?>
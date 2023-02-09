<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_authentication extends CI_Controller
{
    function __construct() {
        parent::__construct();
    $this->load->library('encrypt');
        // Load facebook library
        $this->load->library('facebook');

        //Load user model
        $this->load->model('users');
        $get_data_set = toko_libur();
        if($get_data_set['aktif'] == "on"){
            redirect(base_url('toko-libur'));
        }
    }

    public function index(){
        $userData = array();

        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            // Get user facebook profile details
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

            // Preparing data for database insertion //
            $userData['provider_login'] = 'facebook';
            //$userData['oauth_uid'] = $userProfile['id'];
            $userData['email']          = $userProfile['email'];
            $spasi = " ";
            $userData['nama_lengkap']   = $userProfile['first_name'].$spasi.$userProfile['last_name'];
            // if male = pria, female = perempuan
            $gen = $userProfile['gender'];
            if($gen == 'male'){
                $jk = 'pria';
            }else{
                $jk = 'wanita';
            }
            $userData['gender']         = $jk;
            //$userData['locale'] = $userProfile['locale'];
            //$userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
            $userData['gb_user']        = $userProfile['picture']['data']['url'];
            $userData['status']         = 'a@kti76f0'; // langsung aktif tanpa ribet
            $userData['level']          = 'regcusok4*##@!9))921';
            $userData['akses']          = '9x4$58&(3*+';
            $userData['created']        = date('Y-m-d H:i:s');
            $userData['ip_register_first'] = $this->input->ip_address();

            // Insert or update user data
            $userID = $this->users->checkUser($userData);

           if($userID == "blockingaccessreportacountcustomer"){
                // beri peringatan lalu redirect ke index
                $this->session->set_flashdata('error', 'Akun anda kami non aktifkan, Hubungi kami sekarang.');
                redirect(base_url('login-pelanggan'));
            }else if($userID == "okaccessallowedjosss"){
                // get id, last_login, dan log_access dari insertan tadi
                // primary  = email
                $mailf = $userData['email'];
                $get_d = $this->users->getMaillinsertantadi($mailf);
                foreach($get_d->result() as $data){
                    $sess_data['id']            = $data->id;
                    $sess_data['provider']      = $data->provider_login;
                    $sess_data['last_login']    = $data->last_login;
                    $sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

                    $this->session->set_userdata($sess_data);
                }
                // Load login & profile view
                $this->load->view('dashfb',$data);
            }else if($userID == "cumabutuhloginotomatismaringunu"){
                // get id, last_login, dan log_access dari insertan tadi
                // primary  = email
                $mailf = $userData['email'];
                $img = $userData['gb_user'];
                $get_d = $this->users->getMaillinsertantadi($mailf);
                foreach($get_d->result() as $data){
                    $sess_data['id']            = $data->id;
                    $sess_data['last_login']    = $data->last_login;
                    $sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

                    $this->session->set_userdata($sess_data);
                    $this->users->updateLastloginCustomer($data->id,$img);
                    $this->users->saving_ipdevicebrowser_from_login_fb($data->id,$mailf);
                }
                // Load login & profile view
                $this->session->set_flashdata('error', 'lengkapi informasi akun anda.');
                redirect(base_url('customer/informasi-akun'));
            }

            // Get logout URL
            //$data['logoutUrl'] = $this->facebook->logout_url();
        }else{
            $fbuser = '';

            // Get login URL
            $data['authUrl'] =  $this->facebook->login_url();
        }

        // Load login & profile view
        $this->load->view('dashfb',$data);
    }

    public function logoutfbresetdefault() { // tidak digunakan
        // Remove local Facebook session
        $this->facebook->destroy_session();

        // Remove user data from session
        $this->session->unset_userdata('userData');

        // Redirect to login page
        redirect('/user_authentication');
    }
}
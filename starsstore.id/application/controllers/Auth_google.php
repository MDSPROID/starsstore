<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_google extends CI_Controller
{
	 function __construct(){
        parent::__construct();
        
        //load google login library
        $this->load->library('google');
        
        //load user model
        $this->load->model('users');
        $get_data_set = toko_libur();
        if($get_data_set['aktif'] == "on"){
            redirect(base_url('toko-libur'));
        }
    }
    
    public function index(){
        //redirect to profile page if user already logged in
        if($this->session->userdata('log_access') == 'CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS'){
            redirect(base_url('customer'));
        }
        
        if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            
            //get user info from google
            $gpInfo = $this->google->getUserInfo();
            
            //preparing data for database insertion
            $userData['provider_login'] = 'google';
            //$userData['oauth_uid']      = $gpInfo['id'];
            $userData['email']          = $gpInfo['email'];
            $spasi = " ";
            $userData['nama_lengkap']     = $gpInfo['given_name'].$spasi.$gpInfo['family_name'];
            $gen = !empty($gpInfo['gender'])?$gpInfo['gender']:'';
            if($gen == 'male'){
                $jk = 'pria';
            }else{
                $jk = 'wanita';
            }
             $userData['gender']         = $jk;
            //$userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:'';
            //$userData['profile_url']    = !empty($gpInfo['link'])?$gpInfo['link']:'';
            $userData['gb_user'] 	    = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
            $userData['status']         = 'a@kti76f0'; // langsung aktif tanpa ribet
            $userData['level']          = 'regcusok4*##@!9))921';
            $userData['akses']          = '9x4$58&(3*+';
            $userData['created']        = date('Y-m-d H:i:s');
            $userData['ip_register_first'] = $this->input->ip_address();
            //insert or update user data to the database
            $userID = $this->users->checkUsergoogle($userData);

            if($userID == "blockingaccessreportacountcustomergoogle"){
                // beri peringatan lalu redirect ke index
                $this->session->set_flashdata('error', 'Akun anda kami non aktifkan, hubungi kami sekarang.');
                redirect(base_url('login-pelanggan')); 

            }else if($userID == "okaccessallowedjosssgoogle"){
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

            }else if($userID == "cumabutuhloginotomatismarigoogle"){
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
            
            //store status & user info in session
            //$this->session->set_userdata('loggedIn', true);
            //$this->session->set_userdata('userData', $userData);
            
            //redirect to profile page
			//redirect('user_authentication/profile/');
        }
        
        //google login url
        $data['authUrl'] = $this->google->loginURL();
        
        //load google login view
       $this->load->view('dashfb',$data);
    }
    
    public function profile(){
        //redirect to login page if user not logged in
        if(!$this->session->userdata('loggedIn')){
            redirect('/user_authentication/');
        }
        
        //get user info from session
        $data['userData'] = $this->session->userdata('userData');
        
        //load user profile view
        $this->load->view('user_authentication/profile',$data);
    }
    
    public function logoutfbresetdefault(){ // tidak digunakan
        //delete login status & user info from session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        
        //redirect to login page
        redirect('/user_authentication/');
    }
}
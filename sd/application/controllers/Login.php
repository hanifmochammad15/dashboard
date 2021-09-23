<?php 
 
class Login extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('m_login');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
 
	}
 
	function index(){
		$this->load->view('v_login');
		
	}
 
	function aksi_login(){
		$nik = $this->input->post('nik');
		$password = $this->input->post('password', true);
		 $rules = array(
                array(
                    'field' => 'nik',
                    'label' => 'NIK',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'password',
                    'label' => 'PASSWORD',
                    'rules' => 'required|trim|callback_validate_password['.$nik.']'
                ),
        );
     $this->form_validation->set_rules($rules);
     if($this->form_validation->run() == FALSE){
             $data['status']=100;
             $data['nik'] = form_error('nik');           
             $data['password'] = form_error('password');
             $data['message'] ='<p>Nik dan password salah!</p>';
        }else{
            $data_user = $this->m_login->get_user($nik)->row();
        	$data_session = array(
				'id_pegawai'=>$this->encrypt->encode($data_user->id_pegawai),
				'nik' => $data_user->nik,
				'nama' => $data_user->nama,
				'status' => "login"
				);
			$this->session->set_userdata($data_session);
			$data['status']=200;
        }

       echo json_encode($data);
		
	}

	  function validate_password($str,$nik){
       $data = $this->m_login->cek_login($nik)->row();
       if(empty($data->password)){
       	$pass=0;
       }else{
       	$pass=$data->password;
       }
       if(password_verify($str,$pass)){
         return TRUE;
        }else{
        $this->form_validation->set_message('validate_password', 'Wrong NIK or Password');
         return FALSE;
       }
}
 
	function logout(){
		$this->session->sess_destroy();
		redirect(site_url('login'));
	}
}
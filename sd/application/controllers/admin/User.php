<?php

class User extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	    $this->load->model('m_user');
	    $this->load->library('encrypt');
      $this->load->library('form_validation');
		if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
	}
 
	
	function index(){
		$data['atasan'] = $this->m_user->get_atasan()->result();
		$data['department'] = $this->m_user->get_department()->result();
		$data['divisi'] = $this->m_user->get_all_divisi()->result();
		$data['roles'] = $this->m_user->get_roles()->result();
		$this->load->view("admin/user",$data);
	}

	function get_dept(){
        $id_divisi = $this->input->post('id_divisi',TRUE);
        $data = $this->m_user->get_department_by_id($id_divisi)->result();
        echo json_encode($data);
    }

    function get_atasan(){
        $id_divisi = $this->input->post('id_divisi',TRUE);
        $data = $this->m_user->get_atasan_by_id($id_divisi)->result();
        echo json_encode($data);
    }


	public function userList(){
    // POST data
    $postData = $this->input->post();

    // Get data
    $data = $this->m_user->getUserList($postData);

    echo json_encode($data);
  }

  public function add(){
    // POST data
    if( $this->input->post()){ 
    	$data['nik']= $this->input->post('nik');
    	$password = $this->input->post('password');
        $data ['password']= password_hash($password, PASSWORD_BCRYPT);
    	$data['nama']=$this->input->post('nama');
    	$data['email']=$this->input->post('email');
    	$data['active']=1;
    	if(empty($this->input->post('role'))){
            $data['id_role'] = 0;
        }else{
            $data['id_role']=$this->input->post('role');
        }

        if(empty($this->input->post('divisi'))){
            $data['divisi'] = 0;
        }else{
            $data['divisi']=$this->input->post('divisi');
        }
        if(empty($this->input->post('department'))){
            $data['department'] = 0;
        }else{
            $data['department']=$this->input->post('department');
        }
        if(empty($this->input->post('atasan'))){
            $data['id_atasan'] = 0;
        }else{
            $data['id_atasan']=$this->input->post('atasan');
        }
    	$data['jabatan']=$this->input->post('jabatan');
    	$data['keterangan']=$this->input->post('keterangan');
        $insert = $this->db->query("INSERT INTO pegawai (nik, password, nama, id_atasan, email,active,id_role,divisi,department,jabatan,keterangan) VALUES
            ('".$data['nik']."',
             '".$data['password']."', 
             '".$data['nama']."',
             '".$data['id_atasan']."',
             '".$data['email']."', 
             '".$data['active']."',
             '".$data['id_role']."',
             '".$data['divisi']."',
             '".$data['department']."',
             '".$data['jabatan']."',
             '".$data['keterangan']."'
            )");
    	//$insert = $this->db->insert('pegawai',$data);
    	if($insert){
    		$data['status']=200;
    		echo json_encode($data);
    	}
    }
  }

  public function edit(){
    if( $this->input->post('idpegawai')){ 
    	$idpegawai=$this->input->post('idpegawai');
    	$all_divisi=$this->input->post('idpegawai');
    	
    	$data = $this->m_user->get_pegawai($idpegawai)->row();
    	echo json_encode($data);
    }
  }

    public function update(){
    // POST data
    if( $this->input->post('idpegawai')){
        $idpegawai=$this->input->post('idpegawai'); 
    	$dec_idpegawai=$this->encrypt->decode($idpegawai);
    	$data['nik']=$this->input->post('nik');
    	$data['nama']=$this->input->post('nama');

    	$data['email']=$this->input->post('email');
    	$data['active']=1;
        if(empty($this->input->post('role'))){
            $data['id_role'] = 0;
        }else{
            $data['id_role']=$this->input->post('role');
        }

        if(empty($this->input->post('divisi'))){
            $data['divisi'] = 0;
        }else{
            $data['divisi']=$this->input->post('divisi');
        }
        if(empty($this->input->post('department'))){
            $data['department'] = 0;
        }else{
            $data['department']=$this->input->post('department');
        }
        if(empty($this->input->post('atasan'))){
            $data['id_atasan'] = 0;
        }else{
            $data['id_atasan']=$this->input->post('atasan');
        }
    	$data['jabatan']=$this->input->post('jabatan');
    	$data['keterangan']=$this->input->post('keterangan');
        $update = $this->db->query("UPDATE pegawai SET nik = '".$data['nik']."', 
            nama = '".$data['nama']."', 
            id_atasan = ".$data['id_atasan'].", 
            email = '".$data['email']."', 
            id_role = '".$data['id_role']."', 
            divisi = '".$data['divisi']."', 
            department = '".$data['department']."',
            jabatan = '".$data['jabatan']."', 
            keterangan = '".$data['keterangan']."' 
            WHERE id_pegawai ='".$dec_idpegawai."' ");
        if($update){
            $data['status']=200;
            echo json_encode($data);
        }
    }
  }

   public function delete(){
   		$idpegawai=$this->input->post('idpegawai');
    	$dec_idpegawai=$this->encrypt->decode($idpegawai);
        $delete = $this->db->query("DELETE FROM pegawai
        WHERE id_pegawai =".$dec_idpegawai."");
        if($delete){
    		$data['status']=200;
    		 echo json_encode($data);
    	}

   }

   public function change_password(){
    $data['id_pegawai']=$this->session->userdata('id_pegawai');
    $this->load->view("admin/change_password",$data);
   }

   public function updatePassword(){
    $id_pegawai=$this->input->post('id_pegawai');
    $dec_idpegawai=$this->encrypt->decode($id_pegawai);
    $curret_password=$this->input->post('curret_password');
    $new_password=$this->input->post('new_password');
    $confirm_new_password=$this->input->post('confirm_new_password');
    $datapegawai = $this->m_user->get_pegawai($id_pegawai)->row();
    $oldpassword = $datapegawai->password;
    $rules = array(
                array(
                    'field' => 'id_pegawai',
                    'label' => '',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'curret_password',
                    'label' => 'Curret Password:',
                    'rules' => 'required|trim|callback_validate_password['.$id_pegawai.']'
                ),
                array(
                    'field' => 'new_password',
                    'label' => 'New Password:',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'confirm_new_password',
                    'label' => 'Confirm New Password:',
                    'rules' => 'required|matches[new_password]'
                ),
        );
    $this->form_validation->set_rules($rules);
          if($this->form_validation->run() == FALSE){
             $data['new_password']= $new_password;
             $data['confirm_new_password']= $confirm_new_password;
             $data['status']=100;
             $data['curret_password'] = form_error('curret_password');           
             $data['new_password'] = form_error('new_password');
             $data['confirm_new_password'] = form_error('confirm_new_password');
             $data['message'] ='<p>Update Failed</p>';
        }else{

             $encrypt_password = password_hash($confirm_new_password, PASSWORD_BCRYPT);
             $update = $this->db->query("UPDATE pegawai SET password = '".$encrypt_password."' 
            WHERE id_pegawai ='".$dec_idpegawai."' ");
             if($update ){
                     $data['new_password']= $new_password;
                     $data['confirm_new_password']= $confirm_new_password;
                     $data['status']=200;
                     $data['message'] ='<p>Password Update</p>';
            }else{
                $data['status']=100;
                $data['message'] ='<p>Update Failed</p>';
            }
        }
   echo json_encode($data);
    }

    function validate_password($str,$idpegawai){
       $data = $this->m_user->get_pegawai($idpegawai)->row();
       if(password_verify($str,$data->password)){
         return TRUE;
        }else{
        $this->form_validation->set_message('validate_password', 'Wrong Password');
         return FALSE;
       }
}


}
<?php

class Organization extends CI_Controller{
 
	function __construct(){
		parent::__construct();
        $this->load->model('m_organization');
	    $this->load->library('encrypt');
		if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
	}
 
	
	function index(){
    $data['divisi'] = $this->m_organization->get_divisi()->result();
		$this->load->view("admin/organization",$data);
	}

    public function departmentList(){
    $postData = $this->input->post();
    $data = $this->m_organization->getDeptList($postData);
    echo json_encode($data);
  }

  public function divisiList(){
    $postData = $this->input->post();
    $data = $this->m_organization->getDivisiList($postData);
    echo json_encode($data);
  }


  public function addDepartment(){
    // POST data
    if( $this->input->post()){ 
    	$data['nama_department']=$this->input->post('nama_department');
       if(empty($this->input->post('divisi'))){
            $data['id_divisi'] = 0;
        }else{
            $data['id_divisi']=$this->input->post('divisi');
        }
    	$data['initial_department']=$this->input->post('initial_department');
 
    	$data['active']=$this->input->post('active');
        $insert = $this->db->query("INSERT INTO department (nama_department,id_divisi, initial_department, active) VALUES
            ('".$data['nama_department']."',
            '".$data['id_divisi']."',
             '".$data['initial_department']."', 
             '".$data['active']."'
            )");
    	//$insert = $this->db->insert('pegawai',$data);
    	if($insert){
    		$data['status']=200;
    		echo json_encode($data);
    	}
    }
  }

  public function addDivisi(){
    // POST data
    if( $this->input->post()){ 
    	$data['nama_divisi']=$this->input->post('nama_divisi');
    	$data['initial_divisi']=$this->input->post('initial_divisi');
    	$data['active']=$this->input->post('active');
        $insert = $this->db->query("INSERT INTO divisi (nama_divisi, initial_divisi, active) VALUES
            ('".$data['nama_divisi']."',
             '".$data['initial_divisi']."', 
             '".$data['active']."'
            )");
    	//$insert = $this->db->insert('pegawai',$data);
    	if($insert){
    		$data['status']=200;
    		echo json_encode($data);
    	}
    }
  }

    public function editDepartment(){
    if( $this->input->post('idDepartment')){ 
    	$id_department=$this->input->post('idDepartment');
    	$dec_department=$this->encrypt->decode($id_department);
    	$data = $this->m_organization->get_department_by_id($dec_department)->row();
    	echo json_encode($data);
    }
  }

  public function editDivisi(){
    if( $this->input->post('idDivisi')){ 
    	$id_divisi=$this->input->post('idDivisi');
    	$dec_divisi=$this->encrypt->decode($id_divisi);
    	$data = $this->m_organization->get_divisi_by_id($dec_divisi)->row();
    	echo json_encode($data);
    }
  }

  function get_divisi(){
  	if( $this->input->post()){
		    $query=$this->db->query("select * from divisi where active=1 order by nama_divisi asc");
		    $data = $query->result();
		    echo json_encode($data);
		}
  }

  function updateDepartment(){
  	 if( $this->input->post('id_department')){
        $id_department=$this->input->post('id_department'); 
    	$dec_department=$this->encrypt->decode($id_department);
    	$data['nama_department']=$this->input->post('nama_department');
        if(empty($this->input->post('divisi'))){
            $data['id_ddivisi'] = 0;
        }else{
            $data['id_divisi']=$this->input->post('divisi');
        }
    	$data['initial_department']=$this->input->post('initial_department');
        $data['active']=$this->input->post('active');
        $update = $this->db->query("UPDATE department SET 
        	nama_department = '".$data['nama_department']."', 
          id_divisi = '".$data['id_divisi']."',
          initial_department = '".$data['initial_department']."', 
          active = ".$data['active']."
          WHERE id_department ='".$dec_department."' ");
        if($update){
            $data['status']=200;
            echo json_encode($data);
        }
    }
  }

  function updateDivisi(){
  	 if( $this->input->post('id_divisi')){
        $id_divisi=$this->input->post('id_divisi'); 
    	$dec_divisi=$this->encrypt->decode($id_divisi);
    	$data['nama_divisi']=$this->input->post('nama_divisi');
    	$data['initial_divisi']=$this->input->post('initial_divisi');
        $data['active']=$this->input->post('active');
        $update = $this->db->query("UPDATE divisi SET 
        	nama_divisi = '".$data['nama_divisi']."',  
            initial_divisi = '".$data['initial_divisi']."', 
            active = ".$data['active']."
            WHERE id_divisi ='".$dec_divisi."' ");
        if($update){
            $data['status']=200;
            echo json_encode($data);
        }
    }
  }

  public function deleteDepartment(){
      $id_department=$this->input->post('id_department');
      $dec_department=$this->encrypt->decode($id_department);
        $delete = $this->db->query("DELETE FROM department
        WHERE id_department =".$dec_department."");
        if($delete){
        $data['status']=200;
         echo json_encode($data);
      }

   }

   public function deleteDivisi(){
      $id_divisi=$this->input->post('id_divisi');
      $dec_divisi=$this->encrypt->decode($id_divisi);
        $delete = $this->db->query("DELETE FROM divisi
        WHERE id_divisi =".$dec_divisi."");
        if($delete){
        $data['status']=200;
         echo json_encode($data);
      }

   }




}
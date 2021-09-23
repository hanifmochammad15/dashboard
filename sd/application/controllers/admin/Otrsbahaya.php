<?php

class Otrsbahaya extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	    $this->load->model('m_otrsbahaya');
		// if($this->session->userdata('status') != "login"){
		// 	redirect(site_url("login"));
		// }
	}
 
	function index(){
		// /echo 'hanif';
		//print_r($data_session);
		$tglawal='2019-01-01';
		$tglakhir=date("Y-m-d");
		$total_team= $this->m_otrsbahaya->m_total_team()->row();
		$data['total_team'] = $total_team->count;
		for($i=1;$i<=$data['total_team'];$i++){
		//$data['list_team_'.$i] = $this->m_otrsbahaya->m_team($i)->result();
		$data['list_team_'.$i] = $this->m_otrsbahaya->m_team_bahaya($tglawal,$tglakhir,$i)->result();
		}
		$this->load->view("admin/otrsbahaya",$data);
	}

	function list_team($team=''){
		if(empty($team)){
		$team=1;
		}
		$data['list'] = $this->m_otrsbahaya->m_team($team)->result();
		if($data['list']){
			$data['status']=200;
		}else{
			$data['status']=100;
		}
		  header('Content-Type: application/json');
		  echo json_encode($data);
	}

	function list_table($tglawal='',$tglakhir='',$team=''){
		if(empty($tglawal)){
		$tglawal='2019-01-01';
		}
		if(empty($tglakhir)){
		$tglakhir=date("Y-m-d");
		}
		if(empty($team)){
		$team=1;
		}

		$data['list'] = $this->m_otrsbahaya->m_sla($tglawal,$tglakhir,$team)->result();
		if($data['list']){
			$data['status']=200;
		}else{
			$data['status']=100;
		}
		  header('Content-Type: application/json');
		  echo json_encode($data);

	}


	function list_table_post(){
		if(empty($this->input->post('tglawal'))){
		$tglawal='2019-01-01';
		}
		if(empty($this->input->post('tglakhir'))){
		$tglakhir=date("Y-m-d");
		}
		if(empty($this->input->post('user_login'))){
		$user_login=1;
		}else{
		$user_login=$this->input->post('user_login');
		}
		if(empty($this->input->post('team_id'))){
		$team_id=1;
		}else{
		$team_id=$this->input->post('team_id');
		}

		$data['list'] = $this->m_otrsbahaya->m_sla_post($tglawal,$tglakhir,$team_id,$user_login)->result();
		if($data['list']){
			$data['status']=200;
		}else{
			$data['status']=100;
		}
		  header('Content-Type: application/json');
		  echo json_encode($data);

	}


	function ticket_detail(){
		$tn=$this->input->post('tn');
		$user_id=$this->input->post('user_id');
		$data['list'] = $this->m_otrsbahaya->m_ticket_detail($tn,$user_id)->row();
		if($data['list']){
			$data['status']=200;
		}else{
			$data['status']=100;
		}
		  header('Content-Type: application/json');
		  echo json_encode($data);

	}


	function total_ticket(){
		$tglawal='2019-01-01';
		$tglakhir=date("Y-m-d");
		$team_id=$this->input->post('team_id');
		$list = $this->m_otrsbahaya->m_ticket_total($tglawal,$tglakhir,$team_id)->row();
		$data['total_uw']=$list->total_uw;
		$data['total_reas']=$list->total_reas;
		$data['total_maker']=$list->total_maker;
		$total_all = $this->m_otrsbahaya->m_ticket_total_all($tglawal,$tglakhir,$team_id)->row();
		if($total_all->total <> 0){
		$data['total_all'] =$total_all->total;
		}else{
		$data['total_all'] =0;	
		}
		if($data['total_all']){
			$data['status']=200;
		}else{
			$data['status']=100;
		}
		  header('Content-Type: application/json');
		  echo json_encode($data);

	}


	
}
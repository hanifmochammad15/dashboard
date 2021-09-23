<?php

class Dashboard extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		 $this->load->model('m_dashboard');
		 $this->load->model('m_otrsbahaya');
		// if($this->session->userdata('status') != "login"){
		// 	redirect(site_url("login"));
		// }
	}
 



		function index(){
			if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
		//print_r($data_session);
		$data['tglawal']='2020-01-01';
		$data['tglakhir']=date("Y-m-d");
		$data['team']=1;
		$data['total_team']=3;
		$tanggal_update_que=$this->db->query("select  to_char(tanggal, 'yyyy-mm-dd HH24:MI:SS')as tanggal from batch_dashboard_cp order by tanggal desc limit 1")->row();
		$data['tanggal_update']=$tanggal_update_que->tanggal;
		$query_year=$this->db->query("
		select (extract('year' from current_date)) as year_now ,(extract('year' from current_date)-1) as year_prev")->row();
		$data['year_now']=$query_year->year_now;
		$data['year_prev']=$query_year->year_prev;
        $fullname=explode(' ', $this->session->userdata("nama"));
        $data['firstname']=$fullname[0];
        $data['lastname']=$fullname[1];
        $total_team= $this->m_otrsbahaya->m_total_team()->row();
		$data['total_team'] = $total_team->count;
		for($i=1;$i<=$data['total_team'];$i++){
		//$data['list_team_'.$i] = $this->m_otrsbahaya->m_team($i)->result();
		$data['list_team_'.$i] = $this->m_otrsbahaya->m_team_bahaya($data['tglawal'],$data['tglakhir'],$i)->result();
		}

		$data['branch'] = $this->m_dashboard->branch()->result();
		$this->load->view("admin/dashboard",$data);
	}


	// 	function test(){
	// 	if($this->session->userdata('status') != "login"){
	// 		redirect(site_url("login"));
	// 	}
	// 	//print_r($data_session);
	// 	$data['tglawal']='2020-01-01';
	// 	$data['tglakhir']=date("Y-m-d");
	// 	$data['team']=1;
	// 	$data['total_team']=3;
	// 	$tanggal_update_que=$this->db->query("select  to_char(tanggal, 'yyyy-mm-dd HH24:MI:SS')as tanggal from batch_dashboard_cp order by tanggal desc limit 1")->row();
	// 	$data['tanggal_update']=$tanggal_update_que->tanggal;
	// 	$query_year=$this->db->query("
	// 	select (extract('year' from current_date)) as year_now ,(extract('year' from current_date)-1) as year_prev")->row();
	// 	$data['year_now']=$query_year->year_now;
	// 	$data['year_prev']=$query_year->year_prev;
 //        $fullname=explode(' ', $this->session->userdata("nama"));
 //        $data['firstname']=$fullname[0];
 //        $data['lastname']=$fullname[1];
 //        $total_team= $this->m_otrsbahaya->m_total_team()->row();
	// 	$data['total_team'] = $total_team->count;
	// 	for($i=1;$i<=$data['total_team'];$i++){
	// 	//$data['list_team_'.$i] = $this->m_otrsbahaya->m_team($i)->result();
	// 	$data['list_team_'.$i] = $this->m_otrsbahaya->m_team_bahaya($data['tglawal'],$data['tglakhir'],$i)->result();
	// 	}

	// 	$this->load->view("admin/dashboard_testing",$data);
	// 	//echo'hanif';
	// }

	function batch_cp(){
		$query=$this->m_dashboard->get_cp()->result();
		$date=date("Y_m_d");
		$batch='batch_'.$date;
		$insert_batch=$this->db->query("INSERT INTO batch_dashboard_cp (batch_name) values ('$batch')");
		$id_batch_query=$this->db->query("select  id_batch from batch_dashboard_cp order by tanggal desc limit 1")->row();
		$id_batch=$id_batch_query->id_batch;
		if($insert_batch){
			foreach ($query as $key => $value) {
				$tahun=trim($value->tahun);
				$bulan=trim($value->bulan);
				$jum_polis=$value->jum_polis;
				$insert_query=$this->db->query("INSERT INTO dashboard_cp (id_batch,tahun,bulan,jum_polis) values ('$id_batch','$tahun','$bulan','$jum_polis')");
				if($insert_query){
					echo 'insert sukses<br/>';
					echo $id_batch.'<br/>';
					echo $tahun.'<br/>';
					echo $bulan.'<br/>';
					echo $jum_polis.'<br/>';
					echo '<hr>';
				}
			}
		}
		
	}
}
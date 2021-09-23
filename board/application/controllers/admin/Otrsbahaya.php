<?php

class Otrsbahaya extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	    $this->load->model('m_otrsbahaya');
		if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
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
		$fullname=explode(' ', $this->session->userdata("nama"));
        $data['firstname']=$fullname[0];
        $data['lastname']=$fullname[1];
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
		$data['user_id']=$this->input->post('user_id');;
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

		function table_excel(){
			    include APPPATH.'third_party/phpexcel/PHPExcel.php';

			$tglawal='2019-01-01';
		    $tglakhir=date("Y-m-d");
			$total_team_que = $this->m_otrsbahaya->m_total_team()->row();
			$total_team = $total_team_que->count;
			for($i=1;$i<=$total_team;$i++){
			${'list_team_'.$i} = $this->m_otrsbahaya->m_team_bahaya($tglawal,$tglakhir,$i)->result();
			}
			 // echo'<table border="1px">';
    //                   echo'<tr>';
    //                       echo'<th>Responsible_user</th>';
    //                       echo'<th>Ticket Number</th>';
    //                       echo'<th>Follow Up Maker</th>';
    //                       echo'<th>Follow Up UW</th>';
    //                       echo'<th>Follow Up Reinsurer</th>';
    //                   echo'</tr>';
			$x=0;
                      for($i=1;$i<=$total_team;$i++){
	                      foreach (${'list_team_'.$i} as $key => $value) {
	                      	$list_ticket = $this->m_otrsbahaya->m_sla_post($tglawal,$tglakhir,$i,$value->user_login)->result();
	                      	 foreach ($list_ticket as $keys => $row) {
								$ticket_detail=$this->m_otrsbahaya->m_ticket_detail($row->tn,$value->id_user)->row();
								//menyimpan ke dalam array multi dimensi
								$arr[$x]['user_login']=$value->user_login;
								$arr[$x]['tn']=$row->tn;
								$arr[$x]['title']=$ticket_detail->title;
								$arr[$x]['maker']=$ticket_detail->maker;
								$arr[$x]['uw']=$ticket_detail->uw;
								$arr[$x]['reas']=$ticket_detail->reas;
			                      	// echo'<tr>';
			                      	// echo'<td>'. $value->user_login.'</td>';
			                      	// echo'<td>'. $row->tn.'</td>';
			                      	// echo'<td>'. $ticket_detail->maker.'</td>';
			                      	// echo'<td>'. $ticket_detail->uw.'</td>';
			                      	// echo'<td>'. $ticket_detail->reas.'</td>';
			                      	// echo'</tr>';
								$x++;
		                      }
	                      }
                      }
                 // echo'</table>';


                      //looping array multi dimensi
                     //   $x=0;
                     //    foreach ($arr as $keyz => $rows) {\
	                    //   	echo $arr[$x]['user_login'].'<br/>';
	                    //   	echo $arr[$x]['tn'].'<br/>';
	                    //   	echo $arr[$x]['maker'].'<br/>';
	                    //   	echo $arr[$x]['uw'].'<br/>';
	                    //   	echo $arr[$x]['reas'].'<br/>';
	                    //   	echo '<hr>';
	                     
	                    //   $x++;
                     // }

                     //   echo'<pre>';
                     //  print_r($list_ticket);
                     //  echo'</pre>';
                     //  echo'<pre>';
                     //  print_r($arr);
                     //  echo'</pre>';
                    

          $object = new PHPExcel();
	      $object->setActiveSheetIndex(0);
	      $table_columns = array("Responsible User", "Ticket Number","Subject Otrs", "Follow Up Maker", "Follow Up UW", "Follow Up Reinsurer");
	      $column = 0;
	      foreach($table_columns as $field)
		      {
		       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
		       $column++;
		      }
		  $excel_row = 2;
		  $x=0;
		  foreach ($arr as $keys => $rows) {
           //$nik_text="'".$rows->nik;
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $arr[$x]['user_login']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $arr[$x]['tn']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $arr[$x]['title']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $arr[$x]['maker']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $arr[$x]['uw']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $arr[$x]['reas']);
            $x++;
            $excel_row++;
       		}
       $nama_file='Data_Ticket_'.$tglakhir.'.xls';
      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$nama_file.'"');
      $object_writer->save('php://output');


		}



	
}
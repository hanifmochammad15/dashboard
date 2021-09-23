<?php

class Dashboard extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	      $this->load->model('m_ticket');
		if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
	}
 
	function index(){
		//print_r($data_session);
		$datenow=date("Y-m-d");
		$year = date('Y', strtotime($datenow));
		$month = date('m', strtotime($datenow));
		$data['tglawal']=$year.'-'.$month.'-01';
		$data['tglakhir']=$datenow;
		$data['team']=1;
		$data['total_team']=3;
        $fullname=explode(' ', $this->session->userdata("nama"));
        $query_year=$this->db->query("
		select (extract('year' from current_date)) as year_now ,(extract('year' from current_date)-1) as year_prev")->row();
		$data['year_now']=$query_year->year_now;
		$data['year_prev']=$query_year->year_prev;
        $data['firstname']=$fullname[0];
        $data['lastname']=$fullname[1];
		$this->load->view("admin/dashboard",$data);
		//echo'hanif';
	}


  function ticketList(){
    $postData = $this->input->post();
    $data = $this->m_ticket->getTicketList($postData);
    echo json_encode($data);
  }

	function test(){
		//print_r($data_session);
		$data['tglawal']='2020-01-01';
		$data['tglakhir']=date("Y-m-d");
		$data['team']=1;
		$data['total_team']=3;
        $fullname=explode(' ', $this->session->userdata("nama"));
        $data['firstname']=$fullname[0];
        $data['lastname']=$fullname[1];
		$this->load->view("admin/dashboard_testing",$data);
		//echo'hanif';
	}

	function testajax(){
		$data['test']='bogiant';
		$this->load->view("admin/belajarajax",$data);
		//echo'hanif';
	}

	function download_excel_ticket(){
		$username = $this->session->userdata("nama");
		$datenow = $this->db->query("select now() as now");
		$daterow = $datenow->row();
		$data=[];
		if( $this->input->post('closed_ticket')=='1'){
		$closed = "'2',";
		}else{
		$closed = "";
		}
		$tglawal = $this->input->post('tglawal');
   		$tglakhir = $this->input->post('tglakhir');
     	// $tglawal = '2021-03-01';
   		// $tglakhir = '2021-03-16';
   		$dataTicket = $this->m_ticket->getTicketDownload($tglawal,$tglakhir,$closed)->result();

		include APPPATH.'third_party/phpexcel/PHPExcel.php';
		$object = new PHPExcel();
		$object->getProperties()
		   ->setCreator($username)
		   ->setLastModifiedBy($username)
		   ->setTitle("Excel list ticket OTRS SD")
		   ->setSubject("list ticket OTRS SD")
		   ->setDescription("List Ticket OTRS team SD")
		   ->setKeywords("list ticket OTRS SD");
        $object->setActiveSheetIndex(0);
 

        if( $this->input->post('closed_ticket')=='1'){
		$table_columns = array("Ticket", "Create Time", "Response Time","Closed Time", "User Request", "Responsible By","Priority","Ticket Categories","Desc","Status","Condition");
		}else{
		$table_columns = array("Ticket", "Create Time", "Response Time", "User Request", "Responsible By","Priority","Ticket Categories","Desc","Status","Condition");
		}

        
      	$column = 0;
	    foreach($table_columns as $field)
	      {
	       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	       $column++;
	      }
	      $excel_row=2;
	    foreach ($dataTicket as $keys => $rows) {
           //$nik_text="'".$rows->nik;
           
           if( $this->input->post('closed_ticket')=='1'){
           $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $excel_row, $rows->tn,PHPExcel_Cell_DataType::TYPE_STRING);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $rows->create_time);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $rows->change_time);
		   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $rows->closed_time);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $rows->customer_id);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,$rows->uname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $rows->priority_name_mod); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $rows->type_name);
           $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $rows->title); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $rows->state_name); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $rows->kondisi);
			}else{
			$object->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $excel_row, $rows->tn,PHPExcel_Cell_DataType::TYPE_STRING);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $rows->create_time);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $rows->change_time);
		   
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $rows->customer_id);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,$rows->uname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $rows->priority_name_mod); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $rows->type_name);
           $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $rows->title); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $rows->state_name); 
           $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $rows->kondisi);
			}
            
          $excel_row++;
      	}
	    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	    //header('Content-Type: application/vnd.ms-excel');
	    //header('Content-Disposition: attachment;filename="Report Ticket.xls"');
	    //$succes=$object_writer->save('php://output');
	    $fullname = $daterow->now;
	    $fullname_encrypt=md5($fullname);
	    $filename = FCPATH.'/create_excel/report_ticket_'.$fullname_encrypt.'.xls';
		$succes = $object_writer->save($filename);
	    if($succes){
	    	$data['code']=200;
	    	$data['name']=$fullname;
	    }else{
	    	$data['code']=100;
	    }

	    try {
	    $object_writer->save($filename);
	    $data['code']=200;
	    $data['name']='report_ticket_'.$fullname_encrypt.'.xls';
	    $data['message']="download succes !";
	    echo json_encode($data);
		} catch (Exception $e) {
		   // echo 'ERROR: ', $e->getMessage();
		    //die();
		    $data['code']=100;
		    $data['message'] ='ERROR: '. $e->getMessage();
		    echo json_encode($data);
		}

	}

	function lemparan_ajax(){
		$res =1;
		// $usia=$_POST['usia'];
		// $nama=$_POST['nama'];
		// $alamat=$_POST['alamat'];
		// $data_array=[];
		// $data_array['nama']=$nama;
		// $data_array['usia']=$usia;
		// $data_array['alamat']=$alamat;
	 //    $data_array['jenis_kelamin']='laki - laki';
	    echo json_encode ($res);


	}
}
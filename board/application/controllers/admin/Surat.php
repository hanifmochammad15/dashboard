<?php

class Surat extends CI_Controller{
 
	function __construct(){
		parent::__construct();

        $this->load->model('m_surat');
	    $this->load->library('encrypt');
	    $this->load->library('mypdf');
	    $this->load->library('myqrcode');
	     $this->load->library('form_validation');
		if($this->session->userdata('status') != "login"){
			redirect(site_url("login"));
		}
	}
 
	function index(){
		//print_r($data_session);
		$this->load->view("admin/surat");
	}


    public function suratList(){
    $postData = $this->input->post();
    $data = $this->m_surat->getSuratList($postData);
    echo json_encode($data);
  }

function checkno_surat($str,$nosurat){
       $data = $this->m_surat->countSuratbyNosurat($nosurat)->row();
       if($data->count < 1){
         return TRUE;
	        }else{
	        $this->form_validation->set_message('checkno_surat', 'No Surat Already Exists');
	         return FALSE;
	       }
}

  public function addSurat(){
    // POST data
    if( $this->input->post()){ 
    	$data['no_surat']=strtolower($this->input->post('no_surat'));
    	$data['nama']=strtolower($this->input->post('nama'));
    	$data['nik']=$this->input->post('nik');
    	$data['unit']=$this->input->post('unit');
    	$data['perihal']=strtolower($this->input->post('perihal'));
    	$data['tanggal_keluar']=$this->input->post('tanggal_keluar');
    	$data['tipe_surat']='surat tugas';
    	 $rules = array(
                array(
                    'field' => 'no_surat',
                    'label' => 'Curret Password:',
                    'rules' => 'required|trim|callback_checkno_surat['.$data['no_surat'].']'
                ),
                array(
                    'field' => 'nama',
                    'label' => 'nama',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'nik',
                    'label' => 'nik',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'unit',
                    'label' => 'unit',
                    'rules' => 'required'
                ),
                
               /*
                array(
                    'field' => 'perihal',
                    'label' => 'perihal',
                    'rules' => 'required'
                ),
                */
                array(
                    'field' => 'tanggal_keluar',
                    'label' => 'tanggal_keluar',
                    'rules' => 'required'
                ),

        );

    	 $this->form_validation->set_rules($rules);
         if($this->form_validation->run() == FALSE){
             $data['status']=100;
             $data['no_surat'] = form_error('no_surat');  
             $data['nama'] = form_error('nama');         
             $data['nik'] = form_error('nik');
             $data['unit'] = form_error('unit');
             $data['perihal'] = form_error('perihal');
             $data['tanggal_keluar'] = form_error('tanggal_keluar');
             $data['message'] ='<p>Insert Failed</p>';
	    	 $data['status']=500;
	    	 echo json_encode($data);
         }else{
		        $insert = $this->db->query("INSERT INTO form_request (no_surat, nama, nik,unit,perihal,tanggal_keluar,tipe_surat) VALUES
		            ('".$data['no_surat']."',
		             '".$data['nama']."', 
		             '".$data['nik']."',
		             '".$data['unit']."',
		             '".$data['perihal']."',
		             '".$data['tanggal_keluar']."',
		             '".$data['tipe_surat']."'
		            )");
		    	//$insert = $this->db->insert('pegawai',$data);
		    	//$createPdf = $this->_createPdf($data);
		    	//if($createPdf==true){
		    		if($insert){
			    		$data['status']=200;
			    		echo json_encode($data);
		    		}
		    	//}
		    }
      }
  }

   public function UpdateSurat(){
    // POST data
    if( $this->input->post()){ 
    	$data['idSurat']=$this->input->post('idSurat');
    	$decId = $this->encrypt->decode($data['idSurat']);
    	$data['nama']=strtolower($this->input->post('nama'));
    	$data['nik']=$this->input->post('nik');
    	$data['unit']=$this->input->post('unit');
    	$data['perihal']=strtolower($this->input->post('perihal'));
    	$data['tanggal_keluar']=$this->input->post('tanggal_keluar');
    	$data['tipe_surat']='surat tugas';
    	 $rules = array(
    	 		array(
                    'field' => 'idSurat',
                    'label' => 'idSurat',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'nama',
                    'label' => 'nama',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'nik',
                    'label' => 'nik',
                    'rules' => 'required'
                ),
                
                array(
                    'field' => 'unit',
                    'label' => 'unit',
                    'rules' => 'required'
                ),
                /*
                array(
                    'field' => 'perihal',
                    'label' => 'perihal',
                    'rules' => 'required'
                ),

                */
                array(
                    'field' => 'tanggal_keluar',
                    'label' => 'tanggal_keluar',
                    'rules' => 'required'
                ),

        );

    	 $this->form_validation->set_rules($rules);
         if($this->form_validation->run() == FALSE){
             $data['status']=100;
             $data['idSurat'] = form_error('idSurat');  
             $data['nama'] = form_error('nama');         
             $data['nik'] = form_error('nik');
             $data['unit'] = form_error('unit');
             $data['perihal'] = form_error('perihal');
             $data['tanggal_keluar'] = form_error('tanggal_keluar');
             $data['message'] ='<p>Insert Failed</p>';
             $data['status']=500;
	    	 echo json_encode($data);
         }else{
		        $update = $this->db->query("UPDATE form_request SET 
		        	nama = '".$data['nama']."', 
		            nik = '".$data['nik']."', 
		            unit = '".$data['unit']."', 
		            perihal = '".$data['perihal']."', 
		            tanggal_keluar = '".$data['tanggal_keluar']."'
		             WHERE id ='".$decId."' ");
		    	//$insert = $this->db->insert('pegawai',$data);
		    	//$createPdf = $this->_createPdf($data);
		    	//if($createPdf==true){
		    		if($update){
			    		$data['status']=200;
			    		echo json_encode($data);
		    		}
		    	//}
		    }
      }
  }

   public function editSurat(){
    if( $this->input->post('id')){ 
    	$id_surat=$this->input->post('id');
    	$dec_surat=$this->encrypt->decode($id_surat);
    	$data = $this->m_surat->get_surat_by_id($dec_surat)->row();
    	echo json_encode($data);
    }
  }

   public function deleteSurat(){
   	 if( $this->input->post()){ 
	   		$idSurat=$this->input->post('idSurat');
	    	$decIdSurat=$this->encrypt->decode($idSurat);
        	$dataSurat = $this->m_surat->get_surat_by_id($decIdSurat)->row();
        	$namafile = md5($dataSurat->no_surat);
        	$fullpath = FCPATH.'pdf/'.$namafile.'.pdf'; 
    	    //deletefromlocalserver
    	    $deletefilelocal=unlink($fullpath);
		    //deletefrompublicserver
    	    $deletefileServer=$this->_deletefileServer($namafile);

	        if($deletefilelocal AND $deletefileServer==true){
		        $delete = $this->db->query("DELETE FROM form_request WHERE id =".$decIdSurat."");
		        	if($delete){
			    		$data['status']=200;
			    		echo json_encode($data);
			    	}
	    	}
    	}

   }

  	function createPdf(){
  	if($this->input->post()){ 
  	$idsurat=$this->input->post('id');
  	$decSurat = $this->encrypt->decode($idsurat);
  	$dataSurat = $this->m_surat->get_surat_by_id($decSurat)->row();	
  	$nosurat = $dataSurat->no_surat;
  	$nama =ucwords($dataSurat->nama);
  	$nik =$dataSurat->nik;
  	$encnosurat =md5($nosurat);
  	$unitkerja =$dataSurat->unit;
  	$perihal ='Surat Tugas Operasional '.strtoupper ($dataSurat->perihal) ;
  	$tanggal = 'Jakarta, '.$dataSurat->tanggal_keluar;
  	$this->_createqrcode($encnosurat);
  	$pathqrcode = base_url('assets/qrcode/temp/'.$encnosurat.'.png');
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//set Password PDF
	//$pdf->SetProtection(array(‘modify’,'copy',’print’), $nik, "hanif123", 0, null);
    //$pdf->setPrintFooter(false);
    //$pdf->setPrintHeader(false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Mochammad Hanif');
	$pdf->SetTitle('Surat Tugas');
	$pdf->SetSubject('Surat Tugas Asuransi Bintang');
	//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	    require_once(dirname(__FILE__).'/lang/eng.php');
	    $pdf->setLanguageArray($l);
	}

	// add a page
	$pdf->AddPage('');

	// ---------------------------------------------------------
	 // Logo
    //$pdf->Image(base_url('assets/image/logo.png'), 15, 2, 40, 20, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);
    //$pdf->Ln(15);
    // Set font
    $cambria_bold = TCPDF_FONTS::addTTFfont(base_url('assets/fonts/cambria_bold.ttf'), 'TrueTypeUnicode', '', 96);
    
    $pdf->SetFont($cambria_bold , 'B', 12);
    if(!empty($dataSurat->perihal)){
    $pdf->Multicell(0,2,"\nNo. ".strtoupper($nosurat)."\n\nKepada Yth.\nBapak/Ibu\n".$nama."/".$nik."\nUnit kerja : ".$unitkerja."\n\nPerihal       :  ".$perihal."\n\n"); 
	}else{
	$pdf->Multicell(0,2,"\nNo. ".strtoupper($nosurat)."\n\nKepada Yth.\nBapak/Ibu\n".$nama."/".$nik."\nUnit kerja : ".$unitkerja."\n\nPerihal       :  Surat Tugas Operasional\n\n"); 
	}

    // create some HTML content
	$htmlmain = 
		'<span style="text-align:justify;">Merujuk Peraturan Menteri Kesehatan Republik Indonesia Nomor 09 Tahun 2020 pasal 13 ayat 3 dan Lampirannya Tentang Pedoman Pembatasan Sosial Berksala Besar Dalam Rangka Percepatan Penaganan Corona Virus Disease 2019 (Covid-19) Huruf (D) angka (2) tentang Peliburan Tempat Kerja pengecualian pada bagian huruf (b) point 2b berbunyi "Bank, <b>kantor asuransi</b>, penyelenggara sistem pembayaran, dan ATM, termasuk vendor pengisian ATM dan vendor IT untuk operasi perbankan, call center perbankan dan operasi ATM ",sehingga perusahaan masih dapat beroperasi. 
		</span>
		<br />
		<br />
		<span style="text-align:justify;">Menimbang pentingnya pelayanan terhadap nasabah, melalui surat ini kami sampaikan bahwa saudara dapat bertugas sesuai kebutuhan, jika diperlukan, dengan tetap menjalankan prosedur pencegahan penyebaran virus sesuai dengan kebijakan perusahaan. Harus memakai masker, menjaga jarak serta mencuci tangan dengan sabun cair dan air mengalir secara periodik. 
		</span>
		<br />
		<br />
		<span style="text-align:justify;">Dalam pelaksanaan ini agar juga mematuhi semua ketentuan yang disampaikan Pemerintah Pusat maupun Pemerintah Daerah setempat sehubungan dengan upaya pencegahan penyebaran pandemi Covid-19 
		</span>
		<br />
		<br />
		<span style="text-align:justify;">Demikian surat tugas ini kami sampaikan. Terima kasih.
		</span>
		'
		;
		$calibri = TCPDF_FONTS::addTTFfont(base_url('assets/fonts/calibri.ttf'), 'TrueTypeUnicode', '', 96);
		//$pdf->SetFont($calibri, '', 12);
		$pdf->SetFont('helvetica', '', 11);
		// output the HTML content
		$pdf->writeHTML($htmlmain, true, 0, true, true);
		$pdf->Ln(10);
		$pdf->SetFont($cambria_bold , 'B', 12);
		
		$pdf->Cell(0, 0, $tanggal, 0, 1, 'L', 0, '', 0);
		$pdf->Image($pathqrcode,142,'',25,25);
		$pdf->Ln(25);
		$pdf->SetFont('times', 'B', 12);
		$pdf->Cell(0, 0, 'Jenry Cardo Manurung', 0, 1, 'L', 0, '', 0);
		$pdf->SetFont('helvetica', 'I', 10);
		$pdf->Cell(0, 0, '  Director', 0, 1, 'L', 0, '', 0);
		$pdf->Ln(5);
		$pdf->SetFont('helvetica', 'I', 9);
		$pdf->Cell(0, 0, '  CC', 0, 1, 'L', 0, '', 0);
		$pdf->Cell(0, 0, '  -  Direksi', 0, 1, 'L', 0, '', 0);
		$pdf->Cell(0, 0, '  -  Divisi terkait', 0, 1, 'L', 0, '', 0);
		
        //Save File on server
        $pdf->Output(FCPATH.'pdf/'.$encnosurat.'.pdf', 'F');

		$this->_copyfile($encnosurat);

		// Clean any content of the output buffer
	    ob_end_clean();

        //show file
        //$pdf->Output($encnosurat.'.pdf', 'I');
        //Download File
        //$pdf->Output(FCPATH.'pdf/'.$encnosurat.'.pdf', 'F');
        $data['namafile']=$encnosurat.'.pdf';
        $data['status']=200;
         echo json_encode($data);
    }



  	}

  	function _copyfile($encnosurat ){
  		$milliseconds = round(microtime(true) * 1000);
  		$key=base64_encode('hanif`'.$milliseconds);
	    // persiapkan curl
	    $ch = curl_init(); 

	    // set url 
	    curl_setopt($ch, CURLOPT_URL, "https://asuransibintang.com/pdf_download/copyfile.php?param=".$encnosurat."&key=".$key);

	    // return the transfer as a string 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    // $output contains the output string 
	    $output = curl_exec($ch); 

	    // tutup curl 
	    curl_close($ch);      

	    // menampilkan hasil curl
	    //echo $output;
	     //return true;

		
  	}

  	function _deletefileServer($encnosurat ){
  		$milliseconds = round(microtime(true) * 1000);
  		$key=base64_encode('hanif`'.$milliseconds);
	    // persiapkan curl
	    $ch = curl_init(); 

	    // set url 
	    curl_setopt($ch, CURLOPT_URL, "https://asuransibintang.com/pdf_download/deletefile.php?param=".$encnosurat."&key=".$key);

	    // return the transfer as a string 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    // $output contains the output string 
	    $output = curl_exec($ch); 

	    // tutup curl 
	    curl_close($ch);      

	    // menampilkan hasil curl
	    //echo $output;
	    return true;

		
  	}



  	function _createqrcode($link){
  		 //$PNG_TEMP_DIR = base_url('assets/qrcode/temp/');
	    $PNG_TEMP_DIR =FCPATH.'assets/qrcode/temp/';
	    
	    //html PNG location prefix
	    $PNG_WEB_DIR =  base_url('assets/qrcode/temp/');
	     //ofcourse we need rights to create temp dir
	    if (!file_exists($PNG_TEMP_DIR))
	        mkdir($PNG_TEMP_DIR);

	    $filename = $PNG_TEMP_DIR.$link.'.png';
	    $errorCorrectionLevel = 'M';
	    $matrixPointSize = 5;
	    $linkdownload='https://asuransibintang.com/pdf_download/'.$link.'.pdf';
	    QRcode::png($linkdownload, $filename, $errorCorrectionLevel, $matrixPointSize, 2);


  	}


/*---------------------------------------------------------------------------------*/
	function testqrcode(){

		echo "<h1>PHP QR Code</h1><hr/>";
	    
	    //set it to writable location, a place for temp generated PNG files
	     //$PNG_TEMP_DIR = base_url('assets/qrcode/temp/');
	    $PNG_TEMP_DIR =FCPATH.'assets/qrcode/temp/';
	    
	    //html PNG location prefix
	    $PNG_WEB_DIR =  base_url('assets/qrcode/temp/');


	    
	    //ofcourse we need rights to create temp dir
	    if (!file_exists($PNG_TEMP_DIR))
	        mkdir($PNG_TEMP_DIR);
	    
	    
	    $filename = $PNG_TEMP_DIR.'test.png';
	    
	    //processing form input
	    //remember to sanitize user input in real-life solution !!!
	    $errorCorrectionLevel = 'L';
	    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
	        $errorCorrectionLevel = $_REQUEST['level'];    

	    $matrixPointSize = 4;
	    if (isset($_REQUEST['size']))
	        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


	    if (isset($_REQUEST['data'])) { 
	    
	        //it's very important!
	        if (trim($_REQUEST['data']) == '')
	            die('data cannot be empty! <a href="?">back</a>');
	            
	        // user data
	        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
	        
	    } else {    
	    
	        //default data
	        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
	        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
	        
	    }    
	        
	    //display generated file
	    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
	    
	    //config form
	    $linkaction=$_SERVER['PHP_SELF'];
	    echo '<form action='.$linkaction.' method="post">
	        Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
	        ECC:&nbsp;<select name="level">
	            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
	            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
	            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
	            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
	        </select>&nbsp;
	        Size:&nbsp;<select name="size">';
	        
	    for($i=1;$i<=10;$i++)
	        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
	        
	    echo '</select>&nbsp;
	        <input type="submit" value="GENERATE"></form><hr/>';
	        
	    // benchmark
	    QRtools::timeBenchmark();  
	}


    function SamplecreatePdf(){
 
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage('');
        $pdf->Write(0, 'Simpan ke PDF - Jaranguda.com', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetFont('');
 
       $html = 
       <<<MH
<!-- EXAMPLE OF CSS STYLE -->
<style>
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-decoration: underline;
    }
    p.first {
        color: #003300;
        font-family: helvetica;
        font-size: 12pt;
    }
    p.first span {
        color: #006600;
        font-style: italic;
    }
    p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
    p#second > span {
        background-color: #FFFFAA;
    }
    table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border-left: 3px solid red;
        border-right: 3px solid #FF00FF;
        border-top: 3px solid green;
        border-bottom: 3px solid blue;
        background-color: #ccffcc;
    }
    td {
        border: 2px solid blue;
        background-color: #ffffee;
    }
    td.second {
        border: 2px dashed green;
    }
    div.test {
        color: #CC0000;
        background-color: #FFFF66;
        font-family: helvetica;
        font-size: 10pt;
        border-style: solid solid solid solid;
        border-width: 2px 2px 2px 2px;
        border-color: green #FF00FF blue red;
        text-align: center;
    }
    .lowercase {
        text-transform: lowercase;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .capitalize {
        text-transform: capitalize;
    }
</style>

<h1 class="title">Example of <i style="color:#990000">XHTML + CSS</i></h1>

<p class="first">Example of paragraph with class selector. <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed imperdiet lectus. Phasellus quis velit velit, non condimentum quam. Sed neque urna, ultrices ac volutpat vel, laoreet vitae augue. Sed vel velit erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras eget velit nulla, eu sagittis elit. Nunc ac arcu est, in lobortis tellus. Praesent condimentum rhoncus sodales. In hac habitasse platea dictumst. Proin porta eros pharetra enim tincidunt dignissim nec vel dolor. Cras sapien elit, ornare ac dignissim eu, ultricies ac eros. Maecenas augue magna, ultrices a congue in, mollis eu nulla. Nunc venenatis massa at est eleifend faucibus. Vivamus sed risus lectus, nec interdum nunc.</span></p>

<p id="second">Example of paragraph with ID selector. <span>Fusce et felis vitae diam lobortis sollicitudin. Aenean tincidunt accumsan nisi, id vehicula quam laoreet elementum. Phasellus egestas interdum erat, et viverra ipsum ultricies ac. Praesent sagittis augue at augue volutpat eleifend. Cras nec orci neque. Mauris bibendum posuere blandit. Donec feugiat mollis dui sit amet pellentesque. Sed a enim justo. Donec tincidunt, nisl eget elementum aliquam, odio ipsum ultrices quam, eu porttitor ligula urna at lorem. Donec varius, eros et convallis laoreet, ligula tellus consequat felis, ut ornare metus tellus sodales velit. Duis sed diam ante. Ut rutrum malesuada massa, vitae consectetur ipsum rhoncus sed. Suspendisse potenti. Pellentesque a congue massa.</span></p>

<div class="test">example of DIV with border and fill.
<br />Lorem ipsum dolor sit amet, consectetur adipiscing elit.
<br /><span class="lowercase">text-transform <b>LOWERCASE</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
<br /><span class="uppercase">text-transform <b>uppercase</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
<br /><span class="capitalize">text-transform <b>cAPITALIZE</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
</div>

<br />

<table class="first" cellpadding="4" cellspacing="6">
 <tr>
  <td width="30" align="center"><b>No.</b></td>
  <td width="140" align="center" bgcolor="#FFFF00"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
 <tr>
  <td width="30" align="center">1.</td>
  <td width="140" rowspan="6" class="second">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center" rowspan="3">2.</td>
  <td width="140" rowspan="3">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80" rowspan="2" >XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">3.</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr bgcolor="#FFFF80">
  <td width="30" align="center">4.</td>
  <td width="140" bgcolor="#00CC00" color="#FFFF00">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>
MH;
        $pdf->writeHTML($html);
        //show file
        $pdf->Output('file-pdf-codeigniter.pdf', 'I');
        //Download File
        //$pdf->Output('file-pdf-codeigniter.pdf', 'D');
        //Save File on server
        //$pdf->Output('/var/www/html/DEV/hanif/hr-request/pdf/file-pdf-codeigniter.pdf', 'F');
    }




}
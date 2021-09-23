<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_surat extends CI_Model {

  function __construct(){
    parent::__construct();    
    $this->load->library('encrypt');
 
  }

  function getSuratList($postData=null){
      $response = array();

      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length'];// Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      
      ## Search 
      //$searchQuery = "";
      
      ## Total number of records without filtering
      $records = $this->db->query("
      select count(*) as allcount  from form_request")->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
       if($searchValue != ''){
      $records = $this->db->query("
      select count(*) as allcount  from form_request where no_surat ilike'%".$searchValue."%' or nama ilike'%".$searchValue."%' or nik ilike'%".$searchValue."%' or unit ilike'%".$searchValue."%' or perihal ilike'%".$searchValue."%' ")->result();}
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $records = $this->db->query(
      "select id, no_surat, nama,nik,unit,perihal,tanggal_keluar from form_request order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
      if($searchValue != ''){
      $records = $this->db->query(
     "select id, no_surat, nama,nik,unit,perihal,tanggal_keluar from form_request where no_surat ilike'%".$searchValue."%' or nama ilike'%".$searchValue."%' or nik ilike'%".$searchValue."%' or unit ilike'%".$searchValue."%' or perihal ilike'%".$searchValue."%' order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
    }

      $data = array();

      foreach($records as $record ){
        $filename=md5($record->no_surat).'.pdf';
          $data[] = array( 
              "no_surat"=>$record->no_surat,
              "nama"=>$record->nama,
              "nik"=>$record->nik,
              "unit"=>$record->unit,
              "perihal"=>$record->perihal,
              "tanggal_keluar"=>$record->tanggal_keluar,
              "button"=>'<a href="edit" data-toggle="modal" class="editSurat" data-target="#suratModal" data-id="'.$this->encrypt->encode($record->id).'"><i class="fa fa-edit"></i></a> 
              <a href="delete" data-toggle="modal" class="deleteSurat"  data-target="#deleteModalSurat" data-id="'.$this->encrypt->encode($record->id).'"><i class="fa fa-trash"></i></a>
              
              <a href="download" data-toggle="modal" class="downloadSurat"  data-id="'.$this->encrypt->encode($record->id).'"><i class="fa fa-download"></i></a>'
            ); 
          
      }

      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );

      return $response; 
  }


  function get_surat_by_id($id_surat){
    $query=$this->db->query("select * from form_request where id='".$id_surat."' limit 1");
    return $query;
  }


  function countSuratbyNosurat($no_surat){
    $query=$this->db->query("select count(*) from form_request where no_surat='".$no_surat."' ");
    return $query;
  }


}
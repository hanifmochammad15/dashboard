<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_organization extends CI_Model {

  function __construct(){
    parent::__construct();    
    $this->load->library('encrypt');
 
  }

  function getDivisiList($postData=null){
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
      select count(*) as allcount  from divisi")->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
       if($searchValue != ''){
      $records = $this->db->query("
      select count(*) as allcount  from divisi where nama_divisi ilike'%".$searchValue."%' or initial_divisi ilike'%".$searchValue."%' ")->result();}
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $records = $this->db->query(
      "select id_divisi, nama_divisi,initial_divisi,active from divisi order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
      if($searchValue != ''){
      $records = $this->db->query(
     "select id_divisi, nama_divisi,initial_divisi,active from divisi where nama_divisi ilike'%".$searchValue."%' or initial_divisi ilike'%".$searchValue."%' order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
    }

      $data = array();

      foreach($records as $record ){
        if($record->active==1){$status='active';}else{$status='not active';}
          $data[] = array( 
              "nama_divisi"=>$record->nama_divisi,
              "initial_divisi"=>$record->initial_divisi,
              "active"=>$status,
              "button"=>'<a href="edit" data-toggle="modal" class="editDivisi" data-target="#divisiModal" data-id="'.$this->encrypt->encode($record->id_divisi).'"><i class="fa fa-edit"></i></a> <a href="delete" data-toggle="modal" class="deleteDivisi"  data-target="#deleteModalDivisi" data-id="'.$this->encrypt->encode($record->id_divisi).'"><i class="fa fa-trash"></i></a>'
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


  function getDeptList($postData=null){
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
      select count(*) as allcount from department as a left join divisi as b on a.id_divisi=b.id_divisi")->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
       if($searchValue != ''){
      $records = $this->db->query("
      select count(*) as allcount from department as a left join divisi as b on a.id_divisi=b.id_divisi where nama_department ilike'%".$searchValue."%' or b.nama_divisi ilike'%".$searchValue."%' or initial_department ilike'%".$searchValue."%'")->result();}
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $records = $this->db->query(
      "select id_department,nama_department, b.nama_divisi,initial_department,a.active from department as a left join divisi as b on a.id_divisi=b.id_divisi order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
      if($searchValue != ''){
      $records = $this->db->query(
     "select id_department,nama_department,b.nama_divisi,initial_department,a.active from department as a left join divisi as b on a.id_divisi=b.id_divisi where nama_department ilike'%".$searchValue."%' or b.nama_divisi ilike'%".$searchValue."%' or initial_department ilike'%".$searchValue."%' order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
    }

      $data = array();

      foreach($records as $record ){
        if($record->active==1){$status='active';}else{$status='not active';}
          $data[] = array( 
              "nama_department"=>$record->nama_department,
              "nama_divisi"=>$record->nama_divisi,
              "initial_department"=>$record->initial_department,
              "active"=>$status,
              "button"=>'<a href="edit" data-toggle="modal" class="editDepartment" data-target="#departmentModal" data-id="'.$this->encrypt->encode($record->id_department).'"><i class="fa fa-edit"></i></a> <a href="delete" data-toggle="modal" class="deleteDepartment"  data-target="#deleteModalDepartment" data-id="'.$this->encrypt->encode($record->id_department).'"><i class="fa fa-trash"></i></a>'
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

  function get_divisi(){
    $query=$this->db->query("select * from divisi where active=1 order by nama_divisi asc");
    return $query;
  }

  function get_department_by_id($id_department){
    $query=$this->db->query("select * from department where id_department='".$id_department."' limit 1");
    return $query;
  }

  function get_divisi_by_id($id_divisi){
    $query=$this->db->query("select * from divisi where id_divisi='".$id_divisi."' limit 1");
    return $query;
  }

  

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_user extends CI_Model {

  function __construct(){
    parent::__construct();    
    $this->load->library('encrypt');
 
  }
  function getUserList($postData=null){
      $response = array();

      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length'];// Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      $startlinkedit='<a href="edit/';
      $startlinkdelete='<a href="delete/';
      $endlinkedit='"class="edit-users"><i class="fa fa-edit"></i></a>';
      $endlinkdelete='"class="delete-users"><i class="fa fa-trash"></i></a>';

      ## Search 
      //$searchQuery = "";
      
      ## Total number of records without filtering
      $records = $this->db->query("
      select count(*) as allcount  from pegawai as a
      left join department as b on a.department=b.id_department
      left join divisi as c on a.divisi=c.id_divisi left join roles as d on a.id_role=d.id_role left join pegawai AS f ON A .id_atasan = f.id_pegawai where a.active=1")->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
       if($searchValue != ''){
      $records = $this->db->query("
      select count(*) as allcount  from pegawai as a
      left join department as b on a.department=b.id_department
      left join divisi as c on a.divisi=c.id_divisi left join roles as d on a.id_role=d.id_role left join pegawai AS f ON A .id_atasan = f.id_pegawai where  a.active=1 and a.nik ilike'%".$searchValue."%' or a.active=1 and a.nama ilike'%".$searchValue."%' or a.active=1 and a.email ilike'%".$searchValue."%' or a.active=1 and b.nama_department ilike'%".$searchValue."%' or a.active=1 and c.nama_divisi ilike'%".$searchValue."%' or a.active=1 and d.nama_role ilike'%".$searchValue."%' or a.active=1 and f.nama ilike'%".$searchValue."%'")->result();}
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $records = $this->db->query(/*"
      select '".$startlinkedit."'||a.id_pegawai||'".$endlinkedit." ".$startlinkdelete."'||a.id_pegawai||'".$endlinkdelete."' as   button,*/ 
      "select a.id_pegawai, 
      a.nik,a.nama,a.email,c.nama_divisi,b.nama_department,f.nama as atasan,d.nama_role  from pegawai as a LEFT JOIN department AS b ON A .department = b.id_department LEFT JOIN divisi AS C ON A .divisi = C .id_divisi left join roles as d on a.id_role=d.id_role left join pegawai AS f ON A .id_atasan = f.id_pegawai where  a.active=1 order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
      if($searchValue != ''){
      $records = $this->db->query(/*"
      select '".$startlinkedit."'||a.id_pegawai||'".$endlinkedit." ".$startlinkdelete."'||a.id_pegawai||'".$endlinkdelete."' as   button,*/ 
      "select a.id_pegawai, 
      a.nik,a.nama,a.email,c.nama_divisi,b.nama_department,f.nama as atasan,d.nama_role  from pegawai as a left join department as b on a.department=b.id_department left join divisi as c on a.divisi=c.id_divisi left join roles as d on a.id_role=d.id_role left join pegawai AS f ON A .id_atasan = f.id_pegawai where a.active=1 and a.nik ilike'%".$searchValue."%' or a.active=1 and a.nama ilike'%".$searchValue."%' or a.active=1 and a.email ilike'%".$searchValue."%' or a.active=1 and b.nama_department ilike'%".$searchValue."%' or a.active=1 and c.nama_divisi ilike'%".$searchValue."%' or a.active=1 and d.nama_role ilike'%".$searchValue."%' or a.active=1 and f.nama ilike'%".$searchValue."%' order by ".$columnName." ". $columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
    }

      $data = array();

      foreach($records as $record ){
         
          $data[] = array( 
              "nik"=>$record->nik,
              "nama"=>$record->nama,
              "email"=>$record->email,
              "nama_divisi"=>$record->nama_divisi,
              "nama_department"=>$record->nama_department,
              "atasan"=>$record->atasan,
              "button"=>'<a href="edit" data-toggle="modal" class="editPegawai" data-target="#userModal" data-id="'.$this->encrypt->encode($record->id_pegawai).'"><i class="fa fa-edit"></i></a> <a href="delete" data-toggle="modal" class="deletePegawai"  data-target="#deleteModal" data-id="'.$this->encrypt->encode($record->id_pegawai).'"><i class="fa fa-trash"></i></a>'
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

  function get_atasan(){
      $query=$this->db->query("select id_pegawai as id_atasan, nama as nama_atasan from pegawai where active=1 and id_role > 1 order by nama asc");
      return $query;
    }
  function get_department(){
    $query=$this->db->query("select * from department where active=1 order by nama_department asc");
    return $query;
  }
  function get_all_divisi(){
        $query = $this->db->query("select * from divisi where active=1  order by nama_divisi asc");
        return $query;
    }
   function get_department_by_id($id_divisi){
        $query = $this->db->query("select * from department where active=1 and id_divisi=".$id_divisi." order by nama_department asc");
        return $query;
    }

     function get_atasan_by_id($id_divisi){
        $query = $this->db->query("select * from pegawai where active=1 and divisi=".$id_divisi." and id_role > 1 order by nama asc");
        return $query;
    }
      function get_roles(){
    $query=$this->db->query("select * from roles where active=1 order by nama_role asc");
    return $query;
  }

   function get_pegawai($idpegawai){
    $dec_idpegawai=$this->encrypt->decode($idpegawai);
    $query=$this->db->query("select *  from pegawai  where  id_pegawai=".$dec_idpegawai."limit 1");
    return $query;
  }


}
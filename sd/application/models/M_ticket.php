<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ticket extends CI_Model {

  function __construct(){
    parent::__construct();    
    $this->load->library('encrypt');
 
  }

  function queryTicket($tglawal=null, $tglakhir=null,$closed='',$excel=null){
    if (!empty($closed)and $excel ==1){
      $closed_time="case when ts. NAME  = 'closed success' then (select create_time from ticket_history where ticket_id=T.id and state_id='2'  ORDER BY create_time desc limit 1)::TEXT else '--'::TEXT end as closed_time,";
    }else{
      $closed_time="";
    }
     $query ="select 
case when state_name = 'closed success' then '--'
when left_hours_aman > 0 then left_hours_aman::text ||' jam menuju wanti_wanti'
when left_hours_wanti_wanti > 0 then left_hours_wanti_wanti::text ||' jam menuju bahaya'
else left_hours_wanti_wanti::text||' jam sudah bahaya'
end as left_hours,  
* from (
select 
case when priority_name ='1 very low' then 'very low' 
when priority_name ='2 low' then 'low'
when priority_name ='3 normal' then 'normal' 
when priority_name ='4 high' then 'high'
when priority_name ='5 very high' then 'very high'
else 'undefined' end as priority_name_mod,
case when (hours - pemulih) <= param_aman and state_name <> 'closed success' and state_name ='follow up' then 'follow_up'
when (hours - pemulih) <= param_aman and state_name <> 'closed success' then 'aman'
when (hours - pemulih) > param_aman and (hours - pemulih) <= param_wanti_wanti and state_name <> 'closed success'then 'wanti_wanti'
when (hours - pemulih) > param_wanti_wanti and state_name <> 'closed success' then 'bahaya' 
else '--' end as kondisi,
param_wanti_wanti-(hours - pemulih) as left_hours_wanti_wanti,param_aman-(hours - pemulih) as left_hours_aman,(hours - pemulih) as total_hours ,* from( 
SELECT
$closed_time
(SELECT count (*) FROM daging_tgl  where tgl >= (T.create_time::date)::text AND tgl <= (now()::date)::text)*24
 as pemulih,
case when (select count(*) from ticket_history where ticket_id=T.id and state_id =13) > 0 then 8
when tx.name ='1 very low' then 6 
when tx.name ='2 low' then 4 
when tx.name ='3 normal' then 2 
when tx.name ='4 high' then 1 
when tx.name ='5 very high' then 0
else 0
end as param_aman,
case when (select count(*) from ticket_history where ticket_id=T.id and state_id =13) > 0 then 12
when tx.name ='1 very low' then 10 
when tx.name ='2 low' then 6
when tx.name ='3 normal' then 4 
when tx.name ='4 high' then 2 
when tx.name ='5 very high' then  0
else  0
end as param_wanti_wanti,
FLOOR((EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM T.create_time))/3600)
 as hours, 
FLOOR(((EXTRACT(EPOCH FROM now())-EXTRACT(EPOCH FROM T.create_time))/3600)/24) 
 as days,
    T . ID,
    T .tn,
    T .title,
    T .queue_id,
    T .ticket_lock_id,
    T .ticket_answered,
    T .type_id,
    tt. NAME AS type_name,
    T .ticket_state_id,
    ts. NAME AS state_name,
    T .valid_id,
    T .archive_flag,
    T .create_time_unix,
    T .create_time,
    T .create_by,
    T .change_time,
    T .change_by,
    T .user_id,
    T .customer_id,
    tx.name as priority_name,
    (((u.first_name) :: TEXT || ' ' :: TEXT) || (u.last_name) :: TEXT) AS uname
FROM ticket T JOIN ticket_type tt ON T .type_id = tt. ID
            JOIN ticket_state ts ON T .ticket_state_id = ts. ID
            JOIN ticket_priority tx ON T .ticket_priority_id = tx. ID

        LEFT JOIN users u ON T .user_id = u. ID


WHERE T.create_time::date >='$tglawal'
and T.create_time::date <='$tglakhir' 
AND T.ticket_state_id in($closed'1','4','6','13')
AND T.user_id in('1','18','22','27','30','38','40','34')
)as t1)as t2";

return $query;

  }
  function getTicketDownload(  $tglawal=null, $tglakhir =null, $closed=''){
     $excel=1;
      if (!empty($closed)){
             $excel=1;
           }else{
             $excel=0;
           }
     $otrs_sd = $this->load->database('otrs_sd', TRUE);
     $query = $this->queryTicket( $tglawal, $tglakhir,$closed, $excel);
     $records = $otrs_sd->query("$query");
      return $records;
  
  }

  function getTicketList($postData=null){

      $otrs_sd = $this->load->database('otrs_sd', TRUE);

      $response = array();
      //$closed="'2',";
      $closed="";
      $excel=0;
      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length'];// Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      $tglawal = $postData['tglawal'];
      $tglakhir = $postData['tglakhir'];
      $closed_ticket = $postData['closed_ticket'];

      if($closed_ticket=='1'){
        $closed="'2',";
      }

      
      ## Search 
      //$searchQuery = "";

      $query =$this->queryTicket( $tglawal, $tglakhir,$closed,$excel);
      
      ## Total number of records without filtering
      $records = $otrs_sd->query("
      select count(*) as allcount  from (".$query.") as t3")->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
       if($searchValue != ''){
      $records = $otrs_sd->query("
      select count(*) as allcount  from (".$query.") as t3 where tn ilike'%".$searchValue."%' or uname ilike'%".$searchValue."%' or customer_id ilike'%".$searchValue."%' ")->result();}
      $totalRecordwithFilter = $records[0]->allcount;

      
      ## Fetch records
      $records = $otrs_sd->query(
      "select tn, create_time,change_time,customer_id,uname,priority_name_mod,type_name,title,state_name,kondisi,left_hours from (".$query.") as t3 order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
      if($searchValue != ''){
      $records = $otrs_sd->query(
     "select tn, create_time,change_time,customer_id,uname,priority_name_mod,type_name,title,state_name,kondisi,left_hours from (".$query.") as t3 where tn ilike'%".$searchValue."%' or uname ilike'%".$searchValue."%' or customer_id ilike'%".$searchValue."%' order by ".$columnName." ".$columnSortOrder." limit ".$rowperpage." offset ".$start."")->result();
    }

      $data = array();

      foreach($records as $record ){
        if($record->kondisi=='bahaya'){$kondisi="<p style='color:red'><b>".$record->kondisi."</b></p>";}elseif($record->kondisi=='wanti_wanti'){$kondisi="<p style='color:orange'><b>".$record->kondisi."</b></p>";}elseif($record->kondisi=='aman'){$kondisi="<p style='color:green'><b>".$record->kondisi."</b></p>";}elseif($record->kondisi=='follow_up'){$kondisi="<p style='color:purple'><b>".$record->kondisi."</b></p>";}else{$kondisi="<p style='color:black'><b>".$record->kondisi."</b></p>";}
        $customer_idExp = explode("@",$record->customer_id);
        $customer_id=str_replace("."," ",$customer_idExp[0]);
          $data[] = array( 
              "tn"=>ucwords($record->tn),
              "create_time"=>$record->create_time,
              "change_time"=>$record->change_time,
              "customer_id"=>ucwords($customer_id),
              "uname"=>ucwords($record->uname),
              "priority_name_mod"=>$record->priority_name_mod,
              "type_name"=>$record->type_name,
              "title"=>$record->title,
              "state_name"=>$record->state_name,
              "kondisi"=>$kondisi,
              "left_hours"=>$record->left_hours

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



  

}
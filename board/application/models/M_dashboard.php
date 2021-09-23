<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model {

  function __construct(){
    parent::__construct();    
    $this->load->library('encrypt');
 
  }

  function get_cp(){
    $nextg_dei3 = $this->load->database('nextg_dei3', TRUE);
    $query=$nextg_dei3->query("select tahun,to_char(to_timestamp(bulan,'MM'),'Month') as bulan, sum(jum_polis) as jum_polis from (
      select substring(period,1,4) as tahun, case when substring(period,6,2) = '13' then '12' else substring(period,6,2) end as bulan, count(distinct d.sales_number||d.revision_number) as jum_polis from(
      select distinct sales_number,revision_number from tbl_so_sales_tracker
      where dbaction in ('INSERT','UPDATE') and actiontime between ('01-01-'||(extract('year' from current_date)-1)::varchar)::date and current_date
      and substring(sales_number,4,3) not in ('463','469') and userid in (select distinct userid from adm_userrole_rel2 where rolename = 'mr_ps')
      ) as a 
      join view_daily_production as d using(sales_number,revision_number)
      group by tahun,bulan
      ) as a where tahun in ((extract('year' from current_date)-1)::varchar,(extract('year' from current_date))::varchar) and bulan::integer <= extract('month' from current_date)
      group by tahun,bulan;");
    return $query;  

  }

   function branch(){
        $nextg_dei3 = $this->load->database('nextg_dei3', TRUE);
        $query = $nextg_dei3->query("SELECT code,name from adm_back_office WHERE code not in('XX','---','11') ORDER BY name asc");
        return $query;  
    }


}
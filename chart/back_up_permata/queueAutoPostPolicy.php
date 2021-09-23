<?php // vim:ts=4:
/* 
 * Web Main Index File
 * 
 * This is where site setup and control will be held, before
 * proceeding to action.
 *
 * Copyright (C) 2005, 2006 - Prosoft Computer System
 * All Rights Reserved.
 *
 */

define('SQL_LOGIN',<<<EOS
SELECT userid, username, sex, back_office_code, front_office_code, back_office_name, front_office_name FROM pl_checklogin(?, ?, ?);
EOS
);

define('SQL_QUERY',<<<EOS
SELECT sales_number || ';' || revision as policy_number FROM tbl_so_containter_polis_posting WHERE status = 'ok' ORDER BY date_posting ASC LIMIT 1
EOS
);
			//rachman sugaler CAR 1622017 bug fixing
 define("ISEXTRAEXIST",<<<VYAN
select
extra_account
from
tbl_pd_insurance_products
where
insurance_product_code = ?
VYAN
);
define("GETEXTRAINSPROD",<<<VYAN
select insurance_product_code
from tbl_so_sales_details
where sales_number = ? and revision_number = ?
VYAN
); 
			//end rachman sugaler CAR 1622017 bug fixing

/* ###### Application Setups ###### */
require_once 'applib/setup.php';	// run our setup machines
$s_action  = 'Login';	 			// default actions
$s_module  = 'Default';	 			// default module
	
  $go_db->debug=1;
 // error_reporting(E_ALL);

if ($debug_timer) { $starttime = getmicrotime(); }

function black($pe) {
	$px = array();
	while(list($k,$i)=each($pe)) {
		if(is_array($i)) {
			$px[$k]=black($i);
		} else {
			$px[$k]=is_numeric(trim(ereg_replace(',','',$i))) ? trim(ereg_replace(',','',$i)) : $i;
		}
	}
	return $px;
}

$go_db->StartTrans();

$_POST=black($_POST);
$_REQUEST=black($_REQUEST);

$argv = $go_db->GetOne(SQL_QUERY);

$nilai = explode(";", $argv);
$datanya['sales_number']=$nilai[0];
$datanya['revision_number']=(string)$nilai[1];

$sls_number = $datanya['sales_number'];
$rev_number = $datanya['revision_number'];

	include_once('applib/Accounting.php');
	include_once('applib/SalesIntegration.php');
	include_once('SQL/sql_general.php');	
	 $go_db->debug=1;
 error_reporting(E_ALL);
    $ay = $go_db->getCol("select distinct sales_number||';'||revision_number from tbl_so_sales_details where sales_number = '".$sls_number."' and revision_number = '".$rev_number."'");
		
	foreach($ay as $aa){
		$intFail = 0;
		$plFail = 0;
		$intSuccess = 0;
		$go_db->debug=1;				
		$a_bind = array($sls_number, $rev_number);
		$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = 'proccessing' where sales_number= ? and revision = ?", array($sls_number, $rev_number)); //kasih flag biar gak numpuk
		$go_db->CompleteTrans();

		$go_db->StartTrans();
		if(strlen($sls_number) != 12){			
			$go_errors[]='Sales number must be 12 char';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			$intFail = $intFail + 1;
			continue;
		}

		if(strlen($rev_number) != 3){			
			$go_errors[]='Revision number must be 3 char';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			$intFail = $intFail + 1;
			continue;
		}
		
		if(substr($sls_number,0,1) =='Q'){
			$go_errors[]='#'.$sls_number.' seems like quotation';
			$go_errors[]='integration abort';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			$intFail = $intFail + 1;
			continue;
		}
		
		if (substr($sls_number,0,1) !='Q'){
			if(file_exists('../polislock/'.$sls_number.$rev_number)){
				//unlink('../polislock/'.$sls_number.$rev_number);		
				$go_errors[]= $sls_number.$rev_number." posted by other user";
				printr($go_errors);
				$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
				$intFail = $intFail + 1;
				continue;
			}
		}
	
		$cekposted=$go_db->GetOne("
			select count(*) from public.tbl_fn_apar_details
			where refid1 =? and refid2 =?", array($sls_number,$rev_number));
		echo '<pre>';print_r($cekposted);echo '</pre>';
		if($cekposted){
			echo "galer";
			$go_errors[]='Policy already posted';
			$go_errors[]='Please contact system administrator';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			$intFail = $intFail + 1;
			continue;
		}

		$cekCurOknum = $go_db->GetOne("
			select commission_currency from tbl_so_sales_oknums
			where sales_number = ? and revision_number = ?", array($sls_number,$rev_number));

		if($cekCurOknum == "---"){
			$go_errors[]='Currency oknum must be filled';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));			
			$intFail = $intFail + 1;
			continue;
		}
		
		//MH cek validasi =< 25
		if(    substr($sls_number,3,3) == '327'//UPDATEMH
			OR substr($sls_number,3,3) == '388' 
			OR substr($sls_number,3,3) == '395'
			OR substr($sls_number,3,3) == '396'
			OR substr($sls_number,3,3) == '397'
			OR substr($sls_number,3,3) == '399'){
			$limit = 25;
			$jmlOknum = $go_db->GetOne("select sum(commission_amount) as commission_amount from tbl_so_sales_oknums where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    $jmlDisComm = $go_db->GetAll("select discount,commission from tbl_so_sales_details where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    $jmlPremium = $go_db->GetOne("select sum(premium) as premium from tbl_so_sales_objects where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    foreach ($jmlDisComm as $dc) {
			$jmlDisc = $dc['discount'];
			$jmlCommission = $dc['commission'];
			}
			$premiNetGVz = $jmlPremium * $jmlDisc/100;
			$premiNetGVP = $jmlPremium - $premiNetGVz;
			$jmlOknumGVP = $jmlOknum/$jmlPremium*100;
			$total = $jmlDisc+$jmlCommission+$jmlOknumGVP;
			if($total > $limit){
				$go_errors[]='- Premium Rates : '.$jmlPremium." - Oknum : ".$jmlOknumGVP."% - Diskon : ".$jmlDisc."% - Komisi : ".$jmlCommission."% - Total :".$total."%";
				$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));			
				$intFail = $intFail + 1;
				continue;
				}
			
		}
		//END

		
		//MH cek validasi properti =< 15
		if(    substr($sls_number,3,3) == '187'
			OR substr($sls_number,3,3) == '417' 
			OR substr($sls_number,3,3) == '135'){
			$limit = 15;
			$jmlOknum = $go_db->GetOne("select sum(commission_amount) as commission_amount from tbl_so_sales_oknums where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    $jmlDisComm = $go_db->GetAll("select discount,commission from tbl_so_sales_details where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    $jmlPremium = $go_db->GetOne("select sum(premium) as premium from tbl_so_sales_objects where sales_number = ? and revision_number = ?", array($sls_number, $rev_number));
		    foreach ($jmlDisComm as $dc) {
			$jmlDisc = $dc['discount'];
			$jmlCommission = $dc['commission'];
			}
			$premiNetGVz = $jmlPremium * $jmlDisc/100;
			$premiNetGVP = $jmlPremium - $premiNetGVz;
			$jmlOknumGVP = $jmlOknum/$jmlPremium*100;
			$total = $jmlDisc+$jmlCommission+$jmlOknumGVP;
			if($total > $limit){
				$go_errors[]='- Premium Rates : '.$jmlPremium." - Oknum : ".$jmlOknumGVP."% - Diskon : ".$jmlDisc."% - Komisi : ".$jmlCommission."% - Total :".$total."%";
				$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));			
				$intFail = $intFail + 1;
				continue;
				}
			
		}
		//END

$cekPeriodPolis = $go_db->GetOne("
			select (insurance_period_to - split_part(get_insurance_period_from (sales_number || ';' || revision_number),
				';',3) :: DATE):: NUMERIC as period_polis from tbl_so_sales_details where sales_number = ? and revision_number = ?", array($sls_number,$rev_number));

		if($cekPeriodPolis == '0'){
			$go_errors[]='Period policy must be greater than 0';
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));			
			$intFail = $intFail + 1;
			continue;
		}
		
		if (substr($sls_number ,0,1) !='Q'){
			touch('../polislock/'.$sls_number.$rev_number);
		}						
		
		if(!sales_integration($sls_number,$rev_number)){
		    $plFail = $plFail + 1;
		    $go_errors[] = 'Accounting Integration failed for '.$sls_number.'-'.$rev_number.'.';
		    $go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			unlink('../polislock/'.$sls_number.$rev_number);
			continue;
		} 

			$v = array();			
			$v['sales_status'] = 'Printed';

			if($go_db->GetOne("select case when term_of_payment_code_premium='cash_basis' then 't' else  coalesce(cash_basis,'f') end as cash_basis from
				tbl_pd_insurance_products pd,
				tbl_so_sales_details sd
				where
				pd.insurance_product_code=sd.insurance_product_code and sales_number=? and revision_number=?
				and sd.sales_type='Policy'
				", array($sls_number, $rev_number) )=='t') $v['sales_status']='Paid fully';
			
			$v['userid'] = $go_user['attr']['userid'];
			$go_db->AutoExecute('tbl_so_sales_details', $v, 'UPDATE', 
					'sales_number=\''.$sls_number.'\' AND revision_number=\''.$rev_number.'\'');
					
			$pl_sales_type=$go_db->GetOne("SELECT sales_type FROM tbl_so_sales_details where sales_number='".$sls_number."' AND revision_number='".$rev_number."'");

			if($pl_sales_type == 'Policy'){			
				if(!profit_and_loss_check($sls_number.';'.$rev_number)){
					$go_errors[] = "Profit and Loss Check Occurs !";					
					$plFail = $plFail + 1;
				}
			}			
			
			
		
		   foreach($go_db->GetCol("select apar_number from tbl_fn_apar_details where refid1=? and refid2=? and journal_entry='' and transaction_type not in ('Reinsurance outward treaty proportional premium','Reinsurance outward treaty non proportional premium')  ", array($sls_number,$rev_number)) as $apar_to_post){
				if(!post_apar_to_gl(substr($apar_to_post,0,2), $apar_to_post)){
					$plFail = $plFail + 1;					
				} else {					
					$intSuccess = $intSuccess + 1;							
				}
		   }

		   	$reportData = $go_db->GetRow("SELECT * FROM tbl_so_sales_details WHERE sales_number = ? and revision_number = ? ", array($sls_number, $rev_number));
			if(substr($sls_number ,0,1) !="Q"){				
				if ($reportData['revision_number'] != '000' && $reportData['reason_code'] != '') {					
					$fixa = "% of Sum Insured";
					$fixrate = $go_db->GetOne("select count(*) from tbl_so_sales_objects
					where sales_number = ? and revision_number = ? and  rate <> '% of Sum Insured'", $a_bind);
					if($fixrate){
						//update endors FLAG
						$o_dbres = $go_db->Execute("UPDATE tbl_so_sales_details SET revision_flag='E' WHERE sales_number='".$sls_number."' AND revision_number='".$rev_number."'");
						printr("ICT Tools");
						$o_dbres = $go_db->Execute("UPDATE tbl_so_sales_tracker SET revision_flag='E' 
						WHERE sales_number='".$sls_number."' AND revision_number='".$rev_number."'");
						
						$dt = $go_db->GetOne("select * from tbl_so_sales_details
							where sales_number = ? and revision_number = ? ",  array($sls_number,$rev_number));
						$eprint =0;

					
					}
				}
			}

			$int_type = $go_db->GetOne("SELECT intermediary_type FROM tbl_so_sales_details WHERE sales_number = ? and revision_number = ? ", array($sls_number, $rev_number));
			//virtual account logic start
			if(substr($sls_number,3,3) != '201' && substr($sls_number,3,3) != '202' && substr($sls_number,3,3) != '203' &&  substr($sls_number,3,3) != '204' && substr($sls_number,3,3) != '205' && substr($sls_number,3,3) != '121'){				
				if(($int_type == 'AGENT' || $int_type == '---' || $int_type == 'INSTITUTIONAL AGENT')){        
                    foreach ($go_db->GetCol("select transaction_currency from tbl_fn_apar_details where reference=? and transaction_type='Insurance premium'", array($sls_number . ';' . $rev_number)) as $cucur) {
                    	$curr=$cucur;
                    };

                    $hasil=vaGenerator($sls_number, $rev_number,$curr);
                    if($curr != "IDR") vaGenerator($sls_number, $rev_number,"IDR");
                }                
			}
            //virtual account logic end

            $polnum = 0;
			if($intSuccess != 0 && $intFail == 0){
				if($polnum == 0){
					unlink('../polislock/'.$sls_number.$rev_number);
					$usernya = $go_db->GetOne("SELECT userid FROM tbl_so_containter_polis_posting WHERE sales_number= ? and revision = ?",array($sls_number, $rev_number));
					$go_db->Execute("UPDATE tbl_post_queue_log SET status = '1' WHERE sales_number= ? and revision_number = ?",array($sls_number, $rev_number));
					$go_db->Execute("UPDATE tbl_so_sales_details SET userid = '".$usernya."' WHERE sales_number= ? and revision_number = ?",array($sls_number, $rev_number));
					$go_db->Execute("UPDATE tbl_so_sales_tracker SET userid = '".$usernya."' WHERE sales_number= ? and revision_number = ? and dbaction = 'UPDATE' and sales_status = 'Invoiced'",array($sls_number, $rev_number));
					$go_db->Execute("DELETE FROM tbl_so_containter_polis_posting WHERE sales_number= ? and revision = ?",array($sls_number, $rev_number));

					$polnum = 1;
					// finpay by Rachmat Rizkihadi
					require 'finpay.integration.php';
				}
			}else{
				echo "disini";
				$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ?", array($go_errors[0], $sls_number, $rev_number));
			}
			
			
			//rachman sugaler CAR 1622017 bug fixing
			       $getCampaignCode = $go_db->GetOne("select campaign_code from tbl_so_sales_details where sales_number = ? and revision_number = ? limit 1",array($sls_number,$rev_number));
        		  $getExtraProd = $go_db->GetOne(GETEXTRAINSPROD,array($sls_number,$rev_number));

        		  if($getCampaignCode == "MC0000012" || $getCampaignCode == "MC0000026" || $getExtraProd == "465") {

        		  	$isExtraExist = $go_db->GetOne(ISEXTRAEXIST,array($getExtraProd));

        		  	if($isExtraExist == 't'){
        				$rslt = extraAccountGenerator($sls_number,$rev_number,$getExtraProd);
        				if(!$rslt)
        					echo "krik krik";
        				else
        					echo "Pancen Oye";
        		  	} else {
        				echo "krik krik";
        		  	}

        		  } 
			//end rachman sugaler CAR 1622017 bug fixing
			
			
	} 
	
	if($plFail > 0){
		touch('posting_polis_fail/'.$sls_number.$rev_number.'~'.$go_errors[0]);
		$go_db->FailTrans();
		
		if(file_exists('/var/www/html/nextg_v2/posting_polis_fail/'.$sls_number.$rev_number)){
			$errors= $sls_number.$rev_number.'~'.$go_errors[0];
			// printr($go_errors);
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ? and userid = ?", array($errors, $sls_number, $rev_number, $usernya));
			// $intFail = $intFail + 1;
			// continue;
		}else{
			$errors= "processing".";"."cek kembali";
			$go_db->Execute("UPDATE tbl_so_containter_polis_posting SET status = ? where sales_number= ? and revision = ? and userid = ?", array($errors, $sls_number, $rev_number, $usernya));
		}

	}else{
		$o_dbres = $go_db->CompleteTrans();
			if (!$o_dbres) {
				printr($o_dbres);
				$s_errmsg = $go_db->ErrorMsg();
				if (!empty($s_errmsg)) {
					$go_errors[] = $s_errmsg;
					$go_db->FailTrans();
			}
		}
	}

?>

<?php
/*
list function SalesIntegration withtimer

intermediary_commission_ap
oknum_commission_ap
coins_member_ap
coins_leader_direct_ap
coins_leader_through_ap
insurance_premium_ar
coins_member_ar
coins_leader_ar
reins_inward_prop_premium_ar
reins_outfac_prop_premium_ap
get_unixtime -- tidak dipasangi
calculate_difference
reins_outtreaty_prop_premium_ap
sales_integration
excess_loss_treaty_integration
*/



define('SQL_EPOLICY_CHECK', <<<EOS
SELECT
	count(*)
FROM adm_mail_detail amd
INNER JOIN adm_mail_attachment maa on maa.adm_attachment_id=amd.adm_mail_id
WHERE account_id='ACC01'and substring(maa.adm_attachment_file,1,15)=?
EOS
);

define('SQL_GET_CUSTOMER_CODE', <<<EOS
SELECT customer_code_orig FROM tbl_so_sales_details WHERE sales_number=? AND revision_number=?
EOS
);

define('SQL_GET_CUSTOMER_NAME', <<<EOS
SELECT cco_name FROM tbl_so_sales_details WHERE sales_number=? AND revision_number=?
EOS
);

define('SQL_GET_CUSTOMER_ADDRESS', <<<EOS
SELECT 
	street_address
FROM tbl_mstr_business_partner WHERE code=?
EOS
);

define('SQL_GET_CUSTOMER_EMAIL_ADDRESS', <<<EOS
SELECT email FROM tbl_mstr_business_partner WHERE code=?
EOS
);

define('ITUNG_AP_DETAIL', <<<EOS
select * from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_details.refid1 = ? and tbl_fn_apar_details.refid2 = ? 
and tbl_fn_apar_lines.transaction_origin like '%AP'
EOS
);

define('ITUNG_AR_DETAIL', <<<EOS
select * from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_details.refid1 = ? and tbl_fn_apar_details.refid2 = ? 
and tbl_fn_apar_lines.transaction_origin like '%AR'
EOS
);

function electronicPolicyIntegration($salesNumber, $revisionNumber){
	global $go_db;
	$mailId="";
	$customer_code=$go_db->GetOne(SQL_GET_CUSTOMER_CODE,array($salesNumber,$revisionNumber));
	$customer_name=$go_db->GetOne(SQL_GET_CUSTOMER_NAME,array($salesNumber,$revisionNumber));
	$customer_email=$go_db->GetOne(SQL_GET_CUSTOMER_EMAIL_ADDRESS,array($customer_code));
	$customer_address=$go_db->GetOne(SQL_GET_CUSTOMER_ADDRESS,array($customer_code));

	$mailSubject="Emailing ".$salesNumber.$revisionNumber;
	
	//update notelp,almtemail,callcenter24jam -->6nov14
	$mailContent="Kepada Pelanggan Yth. Bapak/Ibu ".$customer_name."\n\n";
	$mailContent.="Alamat : ".$customer_address." \n\n\n";
	$mailContent.="Dengan Hormat,\n\n";
	$mailContent.="Terima kasih atas kepercayaan yang telah Anda berikan kepada PT. Asuransi Bintang, Tbk.\n";
	$mailContent.="Kami informasikan bahwa e-Policy No. ".$salesNumber.";".$revisionNumber." terlampir adalah sebagai bukti dari kepersertaan Anda yang memuat syarat dan ketentuan dari program jaminan sesuai ketentuan Polis tersebut.\n\n";
	$mailContent.="Mohon untuk mempelajari isi dan menyimpan Polis tersebut dengan baik.\n\n";
	$mailContent.="Untuk pertanyaan lebih lanjut mengenai layanan kami, silakan menghubungi  Bintang Call Center : 021 1500 481, e-mail : cs@asuransibintang.com, Call Center Officer kami siap melayani Anda 24 Jam.\n\n\n";
	$mailContent.="Salam Hangat,\n\n";
	$mailContent.="asuransiBintang\n";
	$mailContent.="www.asuransibintang.com";

	$mailRecipient=array();
	if(isset($customer_email) && !empty($customer_email) && $customer_email != null && $customer_email != ""){
		$mailRecipient[]=$customer_email;
	}
	$mailCC=array();
	$mailCC[]="miswanty.azwin@asuransibintang.com";
	$mailAttachment=array();
	$mailAttachment[]=$salesNumber.$revisionNumber."merged-we.pdf";
	
	if($go_db->GetOne(SQL_EPOLICY_CHECK,array($salesNumber.$revisionNumber)) == 0){
		if(count($mailRecipient) > 0){
			//0. Start the transaction block
			$go_db->StartTrans();
			
			//1. Generate the mail ID
			$mailId=$go_db->GetOne("SELECT nextval('mail_sequence')");
			
			//2. Insert into adm_mail_controls
			$go_db->Execute("INSERT INTO adm_mail_control VALUES('".$mailId."','".date("Y-m-d")."','not send')");
			
			//3. Insert into adm_mail_detail
			$go_db->Execute("INSERT INTO adm_mail_detail VALUES('".$mailContent."','".$mailId."','".$mailSubject."','ACC01')");
			
			//4. Insert into adm_mail_receipt
			foreach($mailRecipient as $receipt){
				$go_db->Execute("INSERT INTO adm_mail_receipt VALUES('".$receipt."','".$mailId."')");
			}
			
			//5. Insert into adm_mail_cc
			foreach($mailCC as $cc){
				$go_db->Execute("INSERT INTO adm_mail_cc VALUES('".$cc."','".$mailId."')");
			}
			
			//6. Insert into adm_mail_attachment
			foreach($mailAttachment as $attachment){
				$go_db->Execute("INSERT INTO adm_mail_attachment VALUES('".$attachment."','".$mailId."')");
			}
						
			//7. Complete the transaction
			$go_db->CompleteTrans();
		}
	}
}

if (!function_exists('json_encode')){

	function json_encode($a=false){
	 
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar($a))
		{
			if (is_float($a))
			{
				// Always use "." for floats.
				return floatval(str_replace(",", ".", strval($a)));
			}
			 
			if (is_string($a)){
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			} else
				return $a;
		}
		$isList = true;
		for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
			if (key($a) !== $i){
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList) {
			foreach ($a as $v) $result[] = json_encode($v);
			return '[' . join(',', $result) . ']';
		} else {
			foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}

}

if ( !function_exists('json_decode') ){ //for php < 5.2
	function json_decode($content, $assoc=false){
		require_once('JSON.php');
		if ($assoc){ $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE); }
		else { $json = new Services_JSON; }
		return $json->decode($content);
	}
}

function XMLwrite(XMLWriter $xml, $data){
	foreach($data as $key => $value){
		if(is_array($value)){
			$xml->startElement($key);
			XMLwrite($xml, $value);
			$xml->endElement();
			continue;
		}
		$xml->writeElement($key, $value);
	}
}
	
function GenerateSignature($snum,$rnum,$uid){
	global $go_db;
		// $go_db->debug=1;

	//Build the XML skeleton
	$frmData = array();
	
	$frmData["details"] = $go_db->GetRow("SELECT * FROM tbl_so_sales_details WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["coverage"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coverage WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["locations"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_locations WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["attributes"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_attributes WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["deductibles"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_deductibles WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["objects"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_objects WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["objattrs"] = $go_db->GetAll("SELECT * FROM tbl_so_object_attributes WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["coinsurance"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coinsurance WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["oknums"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["extensions"] = $go_db->GetAll("SELECT * FROM tbl_so_extension_clause_values WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["extension-clause-values"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
		
	//appending the user id
	$frmData["whois-assess"] = $uid;

	$var_esign = array();
	$var_esign["sales_number"] = $snum;
	$var_esign["revision_number"] = $rnum;
	$var_esign["userid"] = $uid;
	$var_esign["time"] = "now()";
			
	//get the asses number
	$asses_num = $go_db->GetOne("SELECT coalesce(max(number),0) FROM tbl_so_asses_logger WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	
	/***** XML Generation Start *****/
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('policy');
			
	XMLwrite($xml, $frmData);
	$xml->endElement();
	$xmldoc = $xml->outputMemory(true);
	/***** End XML Generation *****/

	$var_esign["number"] = $asses_num+1;
	$var_esign["information_hash"] = md5($xmldoc);
	$var_esign["signature"] = substr($var_esign["information_hash"],0,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],4,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],8,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],12,4);
	$var_esign["signature"] = strtoupper($var_esign["signature"]);
	$var_esign["information_orig"] = $xmldoc;
			
			
	$go_db->AutoExecute("tbl_so_asses_logger",$var_esign,"INSERT");
			
}

function GenerateSignatureClaim($cnum,$uid){
	// $go_db->debug=1;
	// error_reporting(E_ALL);
	
	global $go_db;
	
	//Build the XML skeleton
	$frmData = array();
	
	// $frmData["details"] = $go_db->GetRow("select a.claim_number,b.cco_name,a.policy_number,b.insurance_period_from||' to '||insurance_period_to as policy_period,a.event_date,(select category from tbl_cl_event_category where code=a.event_category)as event_category,c.currency||' '||to_char(c.amount,'999,999,999,999.99') as claim_amount,to_char(d."time",'YYYY-MM-DD')::date as submitted_date,d.userid from tbl_cl_register_event a join tbl_so_sales_details b on a.policy_number=b.sales_number join tbl_cl_claim_amount c on c.claim_number=a.claim_number join tbl_cl_log d on d.claim_number=a.claim_number where a.claim_number=? and b.revision_number='000'and d.event='print PLA'",array($cnum));
	
$frmData["details"] = $go_db->GetRow("select a.claim_number,b.cco_name,a.policy_number,b.insurance_period_from||' to '||insurance_period_to as policy_period, a.event_date,
(select category from tbl_cl_event_category 
where code=a.event_category)as event_category,c.currency||' '||to_char(c.amount,'999,999,999,999.99') as claim_amount,
to_char(d.time,'YYYY-MM-DD')::date as submitted_date, d.userid 
from tbl_cl_register_event a 
join tbl_so_sales_details b on a.policy_number = b.sales_number 
join tbl_cl_claim_amount c on c.claim_number = a.claim_number 
join tbl_cl_log d on d.claim_number = a.claim_number 
where a.claim_number = ? and b.revision_number = '000' and d.event='print PLA'", $cnum);

// printr($frmData["details"]);
// echo '<pre>';print_r($frmData["details"]);echo '</pre>';
// echo "<br>polis : ".$frmData["details"]["policy_number"]."<br>";
	
	// $frmData["coverage"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coverage WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["locations"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_locations WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["attributes"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_attributes WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["deductibles"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_deductibles WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["objects"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_objects WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["objattrs"] = $go_db->GetAll("SELECT * FROM tbl_so_object_attributes WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["coinsurance"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coinsurance WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["oknums"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["extensions"] = $go_db->GetAll("SELECT * FROM tbl_so_extension_clause_values WHERE sales_number=? AND revision_number=?",array($cnum));
	// $frmData["extension-clause-values"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($cnum));
		
	//appending the user id
	$frmData["whois-assess"] = $uid;

	$var_esign = array();
	$var_esign["claim_number"] = $cnum;
	$var_esign["policy_number"] = $frmData["details"]["policy_number"];
	$var_esign["revision_number"] = "000";
	$var_esign["userid"] = $uid;
	//$var_esign["time"] = "now()";
	$var_esign["time"] = date("Y-m-d H:i:s");
			
	//get the asses number
	$submit_num = $go_db->GetOne("SELECT coalesce(max(number),0) FROM tbl_pla_dla_logger WHERE claim_number=?",array($cnum));
	
	/***** XML Generation Start *****/
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('policy');
			
	XMLwrite($xml, $frmData);
	$xml->endElement();
	$xmldoc = $xml->outputMemory(true);
	/***** End XML Generation *****/

	$var_esign["information_hash"] = md5($xmldoc);
	$var_esign["signature"] = substr($var_esign["information_hash"],0,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],4,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],8,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],12,4);
	$var_esign["signature"] = strtoupper($var_esign["signature"]);
	$var_esign["information_orig"] = $xmldoc;
	$var_esign["number"] = $submit_num + 1;
	
	//$go_db->AutoExecute("tbl_electornic_stamp", $stamp['policy'], 'INSERT');
	$go_db->AutoExecute("tbl_pla_dla_logger", $var_esign, 'INSERT');

	// printr($var_esign);
}
function GenerateSignatureKuitansi($snum,$rnum,$uid){
	global $go_db;
	
	//Build the XML skeleton
	$frmData = array();
	
	$frmData["details"] = $go_db->GetRow("SELECT * FROM tbl_so_sales_details WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["coverage"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coverage WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["locations"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_locations WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["attributes"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_attributes WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["deductibles"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_deductibles WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["objects"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_objects WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["objattrs"] = $go_db->GetAll("SELECT * FROM tbl_so_object_attributes WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["coinsurance"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_coinsurance WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["oknums"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["extensions"] = $go_db->GetAll("SELECT * FROM tbl_so_extension_clause_values WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	$frmData["extension-clause-values"] = $go_db->GetAll("SELECT * FROM tbl_so_sales_oknums WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
		
	//appending the user id
	$frmData["whois-assess"] = $uid;

	$var_esign = array();
	$var_esign["sales_number"] = $snum;
	$var_esign["revision_number"] = $rnum;
	$var_esign["userid"] = $uid;
	$var_esign["time"] = "now()";
			
	//get the asses number
	$asses_num = $go_db->GetOne("SELECT coalesce(max(number),0) FROM tbl_so_asses_logger_kuitansi WHERE sales_number=? AND revision_number=?",array($snum,$rnum));
	
	/***** XML Generation Start *****/
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('policy');
			
	XMLwrite($xml, $frmData);
	$xml->endElement();
	$xmldoc = $xml->outputMemory(true);
	/***** End XML Generation *****/

	$var_esign["number"] = $asses_num+1;
	$var_esign["information_hash"] = md5($xmldoc);
	$var_esign["signature"] = substr($var_esign["information_hash"],0,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],4,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],8,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],12,4);
	$var_esign["signature"] = strtoupper($var_esign["signature"]);
	$var_esign["information_orig"] = $xmldoc;
			
			
	$go_db->AutoExecute("tbl_so_asses_logger_kuitansi",$var_esign,"INSERT");
			
}

function GenerateSignatureOFSLIP($ofslip,$uid){
	// $go_db->debug=1;
	// error_reporting(E_ALL);
	
	global $go_db;
	
	//Build the XML skeleton
	$frmData = array();
	
	$frmData["details"] = $go_db->GetRow("select a.of_contract,c.cco_name,b.sales_coverage_number as policy_number,b.sales_coverage_rev_number as revision_number,c.insurance_period_from||' to '||c.insurance_period_to as policy_period,a.tanggal_order,
b.currency||' '||to_char((((b.premium*b.commission)/100)-premium)*-1,'999,999,999,999.99') as slip_amount,
to_char(a.tanggal_approve,'YYYY-MM-DD')::date as submitted_date, a.approval 
from tbl_esign_of_order a join tbl_ra_outward_facultative b on a.of_contract=b.outward_facultative_contract
join tbl_so_sales_details c on c.sales_number=b.sales_coverage_number and c.revision_number=b.sales_coverage_rev_number
where a.of_contract = ? and a.status='Approved'", $ofslip);

// printr($frmData["details"]);
// echo '<pre>';print_r($frmData["details"]);echo '</pre>';
// echo "<br>polis : ".$frmData["details"]["policy_number"]."<br>";

	//appending the user id
	$frmData["whois-assess"] = $uid;

	$var_esign = array();
	$var_esign["of_contract"] = $ofslip;
	$var_esign["policy_number"] = $frmData["details"]["policy_number"];
	$var_esign["revision_number"] = $frmData["details"]["revision_number"];
	$var_esign["userid"] = $uid;
	//$var_esign["time"] = "now()";
	$var_esign["time"] = date("Y-m-d H:i:s");
			
	//get the asses number
	$submit_num = $go_db->GetOne("SELECT coalesce(max(number),0) FROM tbl_esign_of_logger WHERE of_contract=?",array($ofslip));
	
	/***** XML Generation Start *****/
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('policy');
			
	XMLwrite($xml, $frmData);
	$xml->endElement();
	$xmldoc = $xml->outputMemory(true);
	/***** End XML Generation *****/

	$var_esign["information_hash"] = md5($xmldoc);
	$var_esign["signature"] = substr($var_esign["information_hash"],0,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],4,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],8,4)."-";
	$var_esign["signature"] .= substr($var_esign["information_hash"],12,4);
	$var_esign["signature"] = strtoupper($var_esign["signature"]);
	$var_esign["information_orig"] = $xmldoc;
	$var_esign["number"] = $submit_num + 1;
	
	//$go_db->AutoExecute("tbl_electornic_stamp", $stamp['policy'], 'INSERT');
	$go_db->AutoExecute("tbl_esign_of_logger", $var_esign, 'INSERT');

	// printr($var_esign);
}

define("GETJIWAKODE",<<<VYAN
select
product_attribute_code||';'||product_attribute_option_code as ref
from
tbl_so_sales_attributes
where sales_number = ? and revision_number = ?
and product_attribute_code = 'LFPART' limit 1
VYAN
);

define("GETEXTRAACCOUNT",<<<VYAN
select
*
from
tbl_extra_accounts
where "group" in (select extra_account_group from tbl_pd_insurance_products where insurance_product_code = ?)
and reference = ?
VYAN
);

define("GETEXTRAPERIODE",<<<VYAN
select
period_year,
period_index
from tbl_fn_apar_details a
where transaction_type in ('Insurance premium','Co-insurance in premium') and reference = ?
VYAN
);

define("GETEXTRAJIWA",<<<VYAN
insert into tbl_jiwa_details
select
a.sales_number, a.revision_number,
a.object_number, a.interest_name, a.currency_code,a.declared_value, a.premium,
b.attribute_value as tgl_lahir,
c.attribute_value::numeric as premi_total,
c.attribute_value::numeric - a.premium as premium_jiwa
--into tbl_jiwa_details
from
tbl_so_sales_objects a
left join tbl_so_object_attributes b on 
	a.sales_number = b.sales_number and a.revision_number = b.revision_number and a.object_number = b.object_number and b.attribute_code = 'PA+6'
left join tbl_so_object_attributes c on 
	a.sales_number = c.sales_number and a.revision_number = c.revision_number and a.object_number = c.object_number and c.attribute_code = 'PHK10'
where
a.sales_number = ? and a.revision_number = ?
VYAN
);

define("GETEXTRAAMOUNT",<<<VYAN
select
sales_number||';'||revision_number as policynumber,
sum(life_premium) as extraAmount
from 
tbl_extra_details
where
sales_number = ? and revision_number =  trim(to_char(?::int,'000'))
group by sales_number||';'||revision_number
VYAN
);

define('INSERTEXTRADETAILS',<<<VYAN
insert into tbl_extra_details
select 
a.sales_number, a.revision_number, object_number,
interest_name, declared_value as tsi,non_marine as own_rate,
premium as own_premi,
b.product_attribute_option_code::numeric(10,4) as life_rate,
c.product_attribute_option_code::numeric(10,4) as gross_rate,
case when premium = 0 then declared_value else declared_value end * b.product_attribute_option_code::numeric(10,4)/100 as life_premium,
case when premium = 0 then declared_value else declared_value end * c.product_attribute_option_code::numeric(10,4)/100 as total_premium,
premium as own_premi_os,
case when premium = 0 then declared_value else declared_value end * b.product_attribute_option_code::numeric(10,4)/100 as life_premium_os,
case when premium = 0 then declared_value else declared_value end * c.product_attribute_option_code::numeric(10,4)/100 as total_premium_os
from tbl_so_sales_objects a
join tbl_so_sales_attributes b on a.sales_number = b.sales_number and a.revision_number = b.revision_number and b.product_attribute_code = 'LFRATE'
join tbl_so_sales_attributes c on a.sales_number = c.sales_number and a.revision_number = c.revision_number and c.product_attribute_code = 'RTGRSS'
where a.sales_number = ? and a.revision_number =  trim(to_char(?::int,'000'))
VYAN
);

define('INSERTEXTRADETAILSJP',<<<VYAN
insert into tbl_extra_details
select 
a.sales_number, a.revision_number, object_number,
interest_name, 
case when (select revision_flag from tbl_so_sales_details where sales_number = a.sales_number and revision_number = b.revision_number) = 'E' then declared_value - coalesce((select sum(declared_value) from tbl_so_sales_objects where sales_number = a.sales_number and revision_number = (select max(revision_number) from tbl_so_sales_details where sales_number = a.sales_number and revision_number::int < b.revision_number::int and sales_status = 'Master JP') and object_number = a.object_number),0)
	else declared_value 
end as tsi,
non_marine as own_rate,
premium as own_premi,
b.product_attribute_option_code::numeric(10,4) as life_rate,
c.product_attribute_option_code::numeric(10,4) as gross_rate,
case when premium = 0 then 0 
	else case when (select revision_flag from tbl_so_sales_details where sales_number = a.sales_number and revision_number = b.revision_number) = 'E' then declared_value - coalesce((select sum(declared_value) from tbl_so_sales_objects where sales_number = a.sales_number and revision_number = (select max(revision_number) from tbl_so_sales_details where sales_number = a.sales_number and revision_number::int < b.revision_number::int and sales_status = 'Master JP') and object_number = a.object_number),0)
			else declared_value 
	        end 
end * b.product_attribute_option_code::numeric(10,4)/100 as life_premium,
case when premium = 0 then 0 
	else case when (select revision_flag from tbl_so_sales_details where sales_number = a.sales_number and revision_number = b.revision_number) = 'E' then declared_value - coalesce((select sum(declared_value) from tbl_so_sales_objects where sales_number = a.sales_number and revision_number = (select max(revision_number) from tbl_so_sales_details where sales_number = a.sales_number and revision_number::int < b.revision_number::int and sales_status = 'Master JP') and object_number = a.object_number),0)
		        else declared_value 
	       end 
end * c.product_attribute_option_code::numeric(10,4)/100 as total_premium,
premium as own_premi_os,
case when premium = 0 then 0 
	else case when (select revision_flag from tbl_so_sales_details where sales_number = a.sales_number and revision_number = b.revision_number) = 'E' then declared_value - coalesce((select sum(declared_value) from tbl_so_sales_objects where sales_number = a.sales_number and revision_number = (select max(revision_number) from tbl_so_sales_details where sales_number = a.sales_number and revision_number::int < b.revision_number::int and sales_status = 'Master JP') and object_number = a.object_number),0)
			else declared_value 
               end 
end * b.product_attribute_option_code::numeric(10,4)/100 as life_premium_os,
case when premium = 0 then 0 
	else case when (select revision_flag from tbl_so_sales_details where sales_number = a.sales_number and revision_number = b.revision_number) = 'E' then declared_value - coalesce((select sum(declared_value) from tbl_so_sales_objects where sales_number = a.sales_number and revision_number = (select max(revision_number) from tbl_so_sales_details where sales_number = a.sales_number and revision_number::int < b.revision_number::int and sales_status = 'Master JP') and object_number = a.object_number),0)
			else declared_value 
                end 
end * c.product_attribute_option_code::numeric(10,4)/100 as total_premium_os
from tbl_so_sales_objects a
join tbl_so_sales_attributes b on a.sales_number = b.sales_number and a.revision_number = b.revision_number and b.product_attribute_code = 'LFRATE'
join tbl_so_sales_attributes c on a.sales_number = c.sales_number and a.revision_number = c.revision_number and c.product_attribute_code = 'RTGRSS'
where a.sales_number = ? and a.revision_number =  trim(to_char(?::int,'000'))
VYAN
);

define('INSERTEXTRADETAILSNONJP',<<<VYAN
insert into tbl_extra_details
select 
a.sales_number, a.revision_number, object_number,
interest_name, 
case when d.revision_flag='E' then declared_value - (select sum(declared_value) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else declared_value end as tsi,
non_marine as own_rate,
case when d.revision_flag='E' then premium - (select sum(premium) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else premium end * ?  as own_premi,
b.product_attribute_option_code::numeric(10,4) as life_rate,
c.product_attribute_option_code::numeric(10,4) as gross_rate,
case when d.revision_flag='E' then declared_value - (select sum(declared_value) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else declared_value end * b.product_attribute_option_code::numeric(10,4)/100 * ? as life_premium,
case when d.revision_flag='E' then declared_value - (select sum(declared_value) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else declared_value end * c.product_attribute_option_code::numeric(10,4)/100 * ? as total_premium,
case when d.revision_flag='E' then premium - (select sum(premium) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else premium end * 1 as own_premi_os,
case when d.revision_flag='E' then declared_value - (select sum(declared_value) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else declared_value end * b.product_attribute_option_code::numeric(10,4)/100 * ? as life_premium_os,
case when d.revision_flag='E' then declared_value - (select sum(declared_value) from "tbl_so_sales_objects" where sales_number = a.sales_number and revision_number::int = a.revision_number::int-1 and object_number = a.object_number ) else declared_value end * c.product_attribute_option_code::numeric(10,4)/100 * ? as total_premium_os
from tbl_so_sales_objects a
join tbl_so_sales_attributes b on a.sales_number = b.sales_number and a.revision_number = b.revision_number and b.product_attribute_code = 'LFRATE'
join tbl_so_sales_attributes c on a.sales_number = c.sales_number and a.revision_number = c.revision_number and c.product_attribute_code = 'RTGRSS'
join tbl_so_sales_details d on a.sales_number = d.sales_number and a.revision_number = d.revision_number
where a.sales_number = ? and a.revision_number =  trim(to_char(?::int,'000'))
VYAN
);

function extraAccountGenerator($snum,$rnum,$prod){

	global $go_user;
	global $go_db;

	$cekJP = $go_db->GetOne("select count(*) from tbl_so_sales_details where sales_number = ? and revision_number::int = (?)::int-1 and sales_status = 'Master JP'",array($snum,$rnum));
	$revJP = "";
	if($cekJP >= 1){
		$revJP = $go_db->GetOne("select revision_number from tbl_so_sales_details where sales_number = ? and revision_number::int = (?)::int-1 and sales_status = 'Master JP'",array($snum,$rnum));
	}
	//echo "OYOYOYOYOYO".$revJP;	

	if($prod == '465')
		$getJiwaKode = "LFPART;RELIFE";
	else
		$getJiwaKode = $go_db->GetOne(GETJIWAKODE,array($snum,$rnum));

	$getExtraAccount = $go_db->GetRow(GETEXTRAACCOUNT,array($prod,$getJiwaKode));
	$getExtraPeriod = $go_db->GetRow(GETEXTRAPERIODE,array($snum.';'.$rnum));

	if($prod == '465'){

		// prorate calculation
		// first get insurance period from and to from sales number and revision number minus 1
		// second get insurance period from and to from proceed sales number and revision number
		// third calculate the prorate using the same logic with prorate calculation on sales integration
		// end

		$getFlag = $go_db->GetOne("select revision_flag from tbl_so_sales_details where sales_number = ? and revision_number = ?", array($snum,$rnum));

		if($getFlag == 'E'){

			$proc_period = $go_db->GetRow("select insurance_period_from, insurance_period_to from tbl_so_sales_details where sales_number = ? and revision_number = ?",array($snum,$rnum));
			$prev_period = $go_db->GetRow("select insurance_period_from, insurance_period_to from tbl_so_sales_details where sales_number = ? and revision_number = ?",array($snum,sprintf("%03s", $rnum -= 1)));

			$old_to   = unixtimegetter($prev_period['insurance_period_to']); 
			$old_from  = unixtimegetter($prev_period['insurance_period_from']);
	
			$now_to   = unixtimegetter($proc_period['insurance_period_to']);
			$now_from = unixtimegetter($proc_period['insurance_period_from']);	

			$percent = ($now_to-$now_from)/($old_to-$old_from);	

		} else {

			$percent = 1;		

		}

		$svDataDetail = $go_db->Execute(INSERTEXTRADETAILSNONJP,array($percent,$percent,$percent,$percent,$percent,$snum,$rnum));
		$getExtraAmount = $go_db->GetRow(GETEXTRAAMOUNT,array($snum,$rnum));

	} else {
	 if($revJP != ""){
		$svDataDetail = $go_db->Execute(INSERTEXTRADETAILSJP,array($snum,$revJP));
		//$saveJiwa = $go_db->execute(GETEXTRAJIWA,array($snum,$revJP));
		$getExtraAmount = $go_db->GetRow(GETEXTRAAMOUNT,array($snum,$revJP));
	 } else {
		$svDataDetail = $go_db->Execute(INSERTEXTRADETAILS,array($snum,$rnum));
		//$saveJiwa = $go_db->execute(GETEXTRAJIWA,array($snum,$rnum));
		$getExtraAmount = $go_db->GetRow(GETEXTRAAMOUNT,array($snum,$rnum));
	 }
	}

	//printr($getExtraAmount);

	$extraAmount['account'] = $getExtraAccount['account'];
	$extraAmount['period_year'] = $getExtraPeriod['period_year'];
	$extraAmount['period_index'] = $getExtraPeriod['period_index'];
	$extraAmount['amount'] = $getExtraAmount['extraamount'];
	$extraAmount['policy_number'] = $getExtraAmount['policynumber'];
	$extraAmount['reference'] = "";
	$extraAmount['status'] = "Registered";
	$extraAmount['tracking_time'] = date("Y-m-d");
	$extraAmount['amount_os'] = $getExtraAmount['extraamount'];

	$svData = $go_db->AutoExecute("tbl_extra_amounts",$extraAmount,"INSERT");
	
	if(!$svData)
		return false;
	else 
		return true;

}


function unixtimegetter($day){
		$a_day = explode('-', $day);
		return mktime(0,0,0, (int) $a_day[1], (int) $a_day[2], (int) $a_day[0]);
}


// VA PATCH by noyan.

define('GETARNUMBERs_old',<<<VYAN
select count(*)as apnum,back_office_code||replace(apar_number,'AR','') as apar_number
from tbl_fn_apar_details 
where reference = ?
and transaction_type in ('Insurance premium','Co-insurance in premium')
group by back_office_code,apar_number
VYAN
);

//<<Muh, penghapusan boffice impact penambahan jumlah digit AR, 3-Maret-2016
define('GETARNUMBERs',<<<MUH
select count(*)as apnum,'0'||replace(apar_number,'AR','') as apar_number
from tbl_fn_apar_details 
where reference = ?
and transaction_type in ('Insurance premium','Co-insurance in premium')
group by apar_number
MUH
);
//>>

define('GETARNUMBERMDR',<<<rL
select count(*)as apnum,replace(apar_number,'AR','') as apar_number
from tbl_fn_apar_details 
where reference = ?
and transaction_type in ('Insurance premium','Co-insurance in premium')
group by apar_number
rL
);

define('GETPREPIX',<<<VTR
select prefix from tbl_mstr_va_prefix where bank_code = ? and cid = ?        
VTR
);
        
function vaGenerator($snum, $rnum, $curr){
    global $go_db;
    $ar_number = $go_db->GetRow(GETARNUMBERs, array($snum.';'.$rnum));

    $bca_code='014';
    $nga_code='022';
    $qnb_code ='023';
	
    $prepix_bca = $go_db->GetOne(GETPREPIX, array($bca_code,$curr));
    foreach($prepix_bca as $r1){
        $prepix_bca=$r1[0];
    }

    $prepix_nga = $go_db->GetOne(GETPREPIX, array($nga_code,$curr));
    foreach($prepix_nga as $r2){
        $prepix_nga=$r2[0];
    }

	$prepix_qnb = $go_db->GetOne(GETPREPIX, array($qnb_code,$curr));
    foreach($prepix_qnb as $r3){
        $prepix_qnb=$r3[0];
    }
	
    if($ar_number['apnum'] > 0){

	if($curr=="USD")
		$bca_va = $prepix_bca."3".$ar_number['apar_number'];
	else
		$bca_va = $prepix_bca.$ar_number['apar_number'];
    	
	$nga_va = $prepix_nga.$ar_number['apar_number'];
	$qnb_va = $prepix_qnb.$ar_number['apar_number'];
	
	//$go_db->Execute("delete from tbl_so_sales_va where sales_number = ? and revision_number = ?",array($snum,$rnum));
	
        $res = $go_db->Execute("insert into tbl_so_sales_va values ('".$snum."','".$rnum."','Bank BCA','".$bca_va."',now(),'".$curr."')");
		if(!$res) return false;
		$res = $go_db->Execute("insert into tbl_so_sales_va values ('".$snum."','".$rnum."','Bank Niaga','".$nga_va."',now(),'".$curr."')");
		if(!$res) return false;
	    $res = $go_db->Execute("insert into tbl_so_sales_va values ('".$snum."','".$rnum."','Bank QNB','".$qnb_va."',now(),'".$curr."')");
	    if(!$res) return false;
		
		$ar_number_mdr = $go_db->GetRow(GETARNUMBERMDR, array($snum.';'.$rnum));
		$mdr_code ='8932301';
		$mdr_va = $mdr_code.$ar_number_mdr['apar_number'];
	
		$cekVAMDR = $go_db->GetOne("select count(*) from tbl_so_sales_va where sales_number = ? and revision_number = ? and bank_code='Bank Mandiri'", array($snum,$rnum));
		if($cekVAMDR == 0){
			$res = $go_db->Execute("insert into tbl_so_sales_va values ('".$snum."','".$rnum."','Bank Mandiri','".$mdr_va."',now(),'".$curr."')");
			if(!$res) return false;
		}
		
    return true;
   }
}


// end patch of VA



//move profit and lost check into here
define('ITUNG_AP', <<<EOS
select sum(transaction_home_amount) from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_details.refid1 = ? and tbl_fn_apar_details.refid2 = ? 
and tbl_fn_apar_lines.transaction_origin LIKE '%AP'
EOS
);

define('ITUNG_AR', <<<EOS
select sum(transaction_home_amount) from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_details.refid1 = ? and tbl_fn_apar_details.refid2 = ? 
and tbl_fn_apar_lines.transaction_origin like '%AR'
EOS
);

define('BY_PAS_PROFIT_AND_CHECK',<<<vyan
select
count(*)
from
"tbl_fn_by_pass_profit_loss_check"
where
sales_number = ?
vyan
);

define('LIST_AP', <<<EOS
select tbl_fn_apar_details.reference, transaction_type, payment_client_name, transaction_origin, transaction_amount from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_lines.transaction_origin like '%AP' and
tbl_fn_apar_details.reference like ?
EOS
);

define('LIST_AR', <<<EOS
select tbl_fn_apar_details.reference, transaction_type, payment_client_name, transaction_origin, transaction_amount from tbl_fn_apar_lines inner join tbl_fn_apar_details on tbl_fn_apar_details.apar_number=tbl_fn_apar_lines.apar_number 
where 
tbl_fn_apar_lines.transaction_origin like '%AR' and
tbl_fn_apar_details.reference like ?
EOS
);


function profit_and_loss_check($policy_number, $sales_number, $revision_number){

	global $go_user;
	global $go_db;
	
	$sales_number2 = substr($policy_number, 0,12);
	$revision_number2 = substr($policy_number, 13,3);

	$is_by_pas = $go_db->GetOne(BY_PAS_PROFIT_AND_CHECK,array($policy_number));
	if($is_by_pas == 0) {

		// $total_ap = $go_db->GetOne(ITUNG_AP,array($policy_number."%"));
		// $total_ar = $go_db->GetOne(ITUNG_AR,array($policy_number."%"));

		$total_ap = $go_db->GetOne(ITUNG_AP,array($sales_number2,$revision_number2));
		$total_ar = $go_db->GetOne(ITUNG_AR,array($sales_number2,$revision_number2));

		echo "zz1";
			printr($total_ap);
		echo "zz2";
		printr($total_ar);

		
		// $total_ap_det = $go_db->GetAll(ITUNG_AP_DETAIL,array($policy_number."%"));
		// $total_ap_det = $go_db->GetAll(ITUNG_AP_DETAIL,array($policy_number."%"));
		// $total_ar_det = $go_db->GetAll(ITUNG_AR_DETAIL,array($policy_number."%"));

		$total_ap_det = $go_db->GetAll(ITUNG_AP_DETAIL,array($sales_number2,$revision_number2));
		$total_ap_det = $go_db->GetAll(ITUNG_AP_DETAIL,array($sales_number2,$revision_number2));
		$total_ar_det = $go_db->GetAll(ITUNG_AR_DETAIL,array($sales_number2,$revision_number2));
		
		printr($total_ap_det);
				printr($total_ar_det);
				
		
		if($total_ap == "") $total_ap =0;
		if($total_ar == "") $total_ar =0;
	

		//here's the rule
		//if the AR amount is positive, then the AP shouldn't be larger than the AR value
		//but in case the AR amount is negative, the AP shold be larger than AR
	
		//modified again at 09 march 2010
		//only check the positive AR amount
		//1092019 GS
		if($total_ar > 0)
		{
			if($total_ar - $total_ap >= 0)
				return true;
			else
				return false;
			}
		else
		{
        // salah kalo nilai refund sementara ar pastinya negatif  1092019 GS
        //return true;
			if((-1*$total_ar) - (-1*$total_ap)>= 0)
				return true;
			else
                return false;
		}
//1092019 GS
	} else {
		return true;
	}

	/*	
	if($total_ar > 0){
		if($total_ar > $total_ap)
			return true;
		else
			return false;
	}elseif($total_ar==0 && $total_ap==0){
		return true;
	}elseif($total_ar==0 && $total_ap<$total_ar){
		return true;
	}else{

		if($total_ar < $total_ap)
			return true;
		else
			return false;
	}
	*/
}




/*
  function to get main URL of nextg
  added by GLG
*/
function mainURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 //if ($_SERVER["HTTP_HOST"] == "10.11.12.32") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $temp=explode("/",$_SERVER["REQUEST_URI"]);
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/".$temp[1];
 } else {
  $temp=explode("/",$_SERVER["REQUEST_URI"]);
  //$pageURL .= $_SERVER["SERVER_NAME"]."/".$temp[1];
  $pageURL .= $_SERVER["HTTP_HOST"]."/".$temp[1]; 
  //$pageURL .= $temp[1]; 
 }
 return $pageURL;
}

function mainURL2() {
 //$pageURL = 'http';
 $pageURL = '';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 //if ($_SERVER["HTTP_HOST"] == "10.11.12.32") {$pageURL .= "s";}
 //$pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $temp=explode("/",$_SERVER["REQUEST_URI"]);
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/".$temp[1];
 } else {
  $temp=explode("/",$_SERVER["REQUEST_URI"]);
  //$pageURL .= $_SERVER["SERVER_NAME"]."/".$temp[1];
  //$pageURL .= $_SERVER["HTTP_HOST"]."/".$temp[1]; 
  $pageURL .= $temp[1]; 
 }
 return $pageURL;
}

function get_insurance_period_from($sales_number, $revision_number){
	global $go_db;
	$data=$go_db->GetRow("select * from tbl_so_sales_details where sales_number=? and revision_number=?", array($sales_number, $revision_number));
	if($data['revision_flag']=='E') {
		$previous_revision = sprintf("%03s", $revision_number -= 1);
		$data=get_insurance_period_from($sales_number, $previous_revision);
	} 
		return $data;//['insurance_period_from'];
	
}

	function SendPDF($fname) 
	{
		$buffer = file_get_contents($fname);
		Header('Content-Type: application/pdf');
		if(headers_sent())
			$this->Error('Some data has already been output to browser, can\'t send PDF file');
		Header('Content-Length: '.strlen($this->buffer));
		Header('Content-disposition: inline; filename='.basename($fname));
		echo $buffer;
	}

function send_mail($emailaddress, $fromaddress, $emailsubject, $body)
{
  $eol="\r\n";
  $mime_boundary=md5(time());
      
   # Common Headers
  $headers .= 'From: '.$fromaddress.$eol;
  //$headers .= 'Reply-To: MyName<'.$fromaddress.'>'.$eol;
//  $headers .= 'Return-Path: MyName<'.$fromaddress.'>'.$eol;    // these two to set reply address
  //$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  //$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
  # Boundry for marking the split & Multitype Headers
  
  $headers .= "Content-Type: text/html; charset=ISO-8859-1 ";
  $headers .= 'MIME-Version: 1.0'.$eol;
    
	        
  # HTML Version
//  $msg .= "--".$mime_boundary."<br><br>";
  $msg.="<em></em>";
  $msg .= $body."<br><br>";
			    
  # Finished
  //$msg .= "--".$mime_boundary."--"."<br><br>";  // finish with two eol's for better security. see Injection.
  $msg.="<em></em>";    
  # SEND THE EMAIL
 //ini_set(sendmail_from,$fromaddress);  // the INI lines are to force the From Address to be used !
 $mail_sent=mail($emailaddress, $emailsubject, $msg, $headers);
 //ini_restore(sendmail_from);
 return $mail_sent?"Mail sent":"Mail failed";
}

					        
    function copy_array_indexes(&$dest, $src, $indexes)
    {
        foreach ($indexes as $idx) {
            $dest[$idx] = $src[$idx];
        }
    }

    function pec($pe, $separated=false) {
        $rv ='';

        $newline = $separated ? "\n" : "";

        foreach ($pe as $k => $i) {
            if (!is_array($i)) {
                // securely handle passwords
                if ($k === 'frmPassword') $i = 'XXXXXXXXXXXXXXXXXXX';
                $rv .= "$k -> $i;$newline";
                continue;
            }
            // skip menus and privs, though it may be need later
            if ($k === 'menus' || $i === 'menus') continue;
            if ($k === 'privs' || $i === 'privs') continue;
            
            $rv .= "$k =>$newline";
            $rv .= pec($i, $separated);
        }
        return $rv;
    }

    // for timing needs
    // Usage:
    //      -- at start point: 
    //      $f_timestart = getmicrotime();
    //      .....
    //      -- at end point
    //      $f_timetaken = getmicrotime() - $f_timestart;
    //      print('Total time for abc() =.$f_timetaken);
    function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float)$sec);
    }

function printr($p){
	echo "<pre>";
	print_r($p);
	echo "</pre>";
}
function stripslashess  ($pe) {

	if(!is_array($pe)) return stripslashes($pe);


        foreach ($pe as $k => $i) {
            if (!is_array($i)) {
                // securely handle passwords
                $rv[stripslashes($k)] = stripslashes($i);
            } else {
		$rv[stripslashes($k)] = stripslashess ($i);
	    }
        }
        return $rv;
    }

function getJavaScript($state,$param1,$param2)
{
    global $go_db;
    $recordSet = $go_db->GetAll("select script from tbl_auto_rule_map  inner join tbl_auto_rule on rule_code=scriptcode where process_state=".$state." and param1='".$param1."' and param2='".$param2."' order by code_seq");
    $scr="";
    foreach($recordSet as $r) 
    {
         $scr=$scr."   ".$r['script'];
    }
    return $scr;
}

function get_uw_AuthorizationScript($userid)
{
    global $go_db;
    
    $uwScript = $go_db->GetOne("select uw_authorization_script from adm_users where userid='".$userid."'");
    $recordSet = $go_db->GetAll("select script from tbl_auto_rule where scriptcode='".$uwScript."'");    
    $scr="";
    foreach($recordSet as $r) 
    {
         $scr=$scr."   ".$r['script'];
    }

    $exclude_rule_script = array();
    $exception_script = $go_db->GetAll("select reference_description from tbl_mstr_reference where reference_type = 'uw_comm_limit_exclude'");
    foreach($exception_script as $a)
    {
	$exclude_rule_script[] = $a['reference_description'];
    }  
   
    //if ($scr != "" && $uwScript != 'UWYES') {
    if($scr != "" && !in_array($uwScript,$exclude_rule_script)){
       $recordSet = $go_db->GetAll("select script from tbl_auto_rule where scriptcode='UWGUIDE'");
       foreach($recordSet as $r) 
       {
           $scr=$scr."   ".$r['script'];
       }
    }

    /*
    $recordSet = $go_db->GetAll("select script from tbl_auto_rule inner join adm_users on uw_authorization_script = scriptcode where userid='".$userid."'");
    $scr="";
    foreach($recordSet as $r) 
    {
         $scr=$scr."   ".$r['script'];
    }
    */
    return $scr;
}

function get_cl_AuthorizationScript($userid)
{
    global $go_db;	
	// $go_db->debug=1; 
    $recordSet = $go_db->GetOne("select script from tbl_auto_rule inner join adm_users on cl_authorization_script = scriptcode where userid='".$userid."'"); 
    return $recordSet;
}

function get_AutoUnderwriterScript($product_code)
{
    global $go_db;
    $recordSet = $go_db->GetOne("select script from tbl_auto_rule where scriptcode ='AU".$product_code."'");    	
    return $recordSet;
}

function floating_stock($sn, $rn){
	global $go_db;
	$fs_detected=false;
	$fs_ec=$go_db->GetCol("select extension_clause_code from tbl_pd_extension_clauses  where floating_stock = 't'  ");
	$ec_a=$go_db->GetCol("select extension_clause_code from tbl_so_sales_extensions where sales_number=? and revision_number=?", array($sn, $rn));
	//scan the polis extension clause array
	foreach($ec_a as $eca){
		if(in_array($eca, $fs_ec)) {
			$fs_detected=true;
			break;
		}
	}

	if(!$fs_detected) return false;

	$ta=array(
	'tbl_so_sales_details',
	'tbl_so_sales_coverage',
	'tbl_so_sales_locations',
	'tbl_so_sales_objects',
	'tbl_so_object_attributes',
	'tbl_so_extension_clause_values',
	'tbl_so_policy_wording_values',
	'tbl_so_sales_attributes',
	'tbl_so_sales_extensions',
	'tbl_so_sales_oknums',
	'tbl_so_sales_coinsurance',
	'tbl_so_sales_deductibles'
	);

	$reserved_policy_number_s=$go_db->GetOne("select reserved_policy_number from tbl_so_sales_details where sales_number=? and revision_number=?", array($sn, $rn));
	list($nsn, $temp_nrn)=explode(';', $reserved_policy_number_s);
	$nrn = $temp_nrn+1;
	$nrn = sprintf("%03s", $nrn);

	//copy polis
	foreach($ta as $polis_table){
		$data=$go_db->GetAll("select * from $polis_table where sales_number=? and revision_number=?", array($nsn, $temp_nrn));
		foreach($data as $data2){
			$data2['revision_number']=$nrn;
			if($polis_table=='tbl_so_sales_details') $data2['sales_status']='reserved';
			$go_db->AutoExecute($polis_table, $data2, 'INSERT');
		}

	}
	return true;
}

function rodya_non_ascii_remover($par){
    $c='';
        for($a=0;$a<=strlen($par);$a++){
                $b = substr($par,$a,1);
                if(ord($b)>31 and ord($b)<127 ) $c .= $b;
                //echo $b." ".ord($b);
                //echo "\n";

        }

        return $c;
}

//add by hadi 1 Juni 2016
function akuisisi_basedon_ojk_valid($a_bind, $branc_code)
                {
 
                                                global $go_db;
                                                $s_returns = true;
                                               
                                                //$go_db->StartTrans();
                                               
                                                //<<MUH rule engine php 8-Feb-2015 merujuk MI no. 001/MI/DIR-JCM/I/2015 perihal Mekanisme pengeluaran biaya akuisisi
                                                $jmlOknum = 0;
                                                $jmlOknum = $go_db->GetOne("select coalesce(sum(commission_amount),0) as commission_amount from tbl_so_sales_oknums where sales_number = ? and revision_number = ?", $a_bind);
                                                if (empty($jmlOknum))
                                                                $jmlOknum = 0;
                                               
                                                echo "nilai oknum ";
                                                printr($jmlOknum);
                                                                                               
                                                $jmlPremium = 0;
                                               
                                                $jmlDisComm = $go_db->GetAll("select discount,commission from tbl_so_sales_details where sales_number = ? and revision_number = ?", $a_bind);
                                                $jmlPremium = $go_db->GetOne("select coalesce(sum(premium),0) as premium from tbl_so_sales_objects where sales_number = ? and revision_number = ?", $a_bind);
                                               
                                                //if (empty($jmlPremium))
                                                //            $jmlPremium = 0;
                                               
                                                echo "nilai Premium ";
                                                printr($jmlPremium);
                                               
                                                $jmlDisc = 0;
                                                $jmlCommission = 0;
                                                if (!empty($jmlDisComm))
                                                {
                                                                foreach ($jmlDisComm as $dc) {
                                                                                $jmlDisc = $dc['discount'];
                                                                                $jmlCommission = $dc['commission'];
                                                                }
                                                }
                                                // with premi nett
                                                if ($jmlDisc==0)
                                                {
                                                                $premiNetGVz = 0;
                                                } else {
                                                                $premiNetGVz = $jmlPremium * $jmlDisc/100;               
                                                }
                                                $premiNetGVP = $jmlPremium - $premiNetGVz;
                                                // $jmlOknumGVP = $jmlOknum/$premiNetGVP*100;
 
                                                // with premi gross                        
                                                if ($jmlOknum == 0 )
                                                {
                                                                $jmlOknumGVP = 0; //Muh 7 Sept'15, with premi gross
                                                } else
                                                {
                                                                $jmlOknumGVP = $jmlOknum/$jmlPremium*100; //Muh 7 Sept'15, with premi gross 
                                                }
                                               
 
                                                $total = $jmlDisc+$jmlCommission+$jmlOknumGVP;
                                                if ($branc_code  == '300' or
                                                                $branc_code  == '307' or
                                                                $branc_code  == '310' or
                                                                $branc_code  == '315' or
                                                                $branc_code  == '330' or
                                                                $branc_code  == '391' or
                                                                $branc_code  == '396' or
                                                                $branc_code  == '397' or
                                                                $branc_code  == '398' or
                                                                $branc_code  == '399')
                                                {                             
                                                                if ($jmlDisc > 25)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Discount must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($jmlCommission > 25)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Commission must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($jmlOknumGVP > 25)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Overiding Commission must not greater than 25% from premium rates';
                                                                }
                                                               
                                                                if (($jmlCommission+$jmlOknumGVP) > 25)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Commission and Overiding Commission costs must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($total > 25) //35
                                                                {             
                                                                                $s_returns = false;
                                                                                $s_formRes=$s_formRes.'<BR>- Acquisition costs must not greater than 25% from premium rates';                                                                              
                                                                                                               
                                                                }
                                                } else if ($branc_code == "101" ||
                                                                                $branc_code== "107" ||
                                                                                $branc_code== "108" ||
                                                                                $branc_code== "113" ||
                                                                                $branc_code== "115" ||
                                                                                $branc_code== "121" ||
                                                                                $branc_code== "123" ||
                                                                                $branc_code== "125" ||
                                                                                $branc_code== "188" ||
                                                                                $branc_code== "195" ||
                                                                                $branc_code== "199" ||
                                                                                $branc_code== "411" ||
                                                                                $branc_code== "429" ||
                                                                                $branc_code== "193")
                               
                                                {
                                                                if ($jmlDisc > 15)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Discount must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($jmlCommission > 15)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Commission must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($jmlOknumGVP > 15)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Overiding Commission must not greater than 25% from premium rates';
                                                                }
                                                               
                                                                if (($jmlCommission+$jmlOknumGVP) > 15)
                                                                {
                                                                                $s_returns = false;                                                                                                                                                         
                                                                                $s_formRes=$s_formRes.'<BR>- Commission and Overiding Commission costs must not greater than 25% from premium rates';
                                                                }
 
                                                                if ($total > 15) //35
                                                                {             
                                                                                $s_returns = false;
                                                                                $s_formRes=$s_formRes.'<BR>- Acquisition costs must not greater than 25% from premium rates';                                                                              
                                                                                                               
                                                                }
                                                }
                                                /*
                                                $o_dbres = $go_db->CompleteTrans();
                                                if (!$o_dbres) {
                                                                $s_errmsg = $go_db->ErrorMsg();
                                                                if (!empty($s_errmsg)) {
                                                                                $go_errors[] = $s_errmsg;
                                                                                printr($go_errors[0]);                                                                   
                                                                                $s_returns=false;
                                                                }
                                                }
                                                */
                                //$s_returns=true;
                                return $s_returns;          
                                //return $s_returns === true ? true : false;
}
?>

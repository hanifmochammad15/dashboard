<?php
if($go_user['attr']['userid'] == 'galih' || $go_user['attr']['userid'] == 'Ades' || $go_user['attr']['userid'] == 'deky' || $go_user['attr']['userid'] == 'setiawan.galih' || $go_user['attr']['userid'] == 'yanuardi.faisal' || $go_user['attr']['userid'] == 'rachman.lubis' || $go_user['attr']['userid'] == 'muh.asmadi' || $go_user['attr']['userid'] == 'mochammad.hanif') {
 // 
  $go_db->debug=1;error_reporting(E_ALL);
 // printr($a_data['userid']);
 // printr($tpl_inv);echo "disinini";
}
	function write_report_template($report_filename, $report_template)
	{
		global $go_errors;
		global $_APPDIR;
		
		$rhname = $report_filename.'.html';

		if (!$f = fopen($_APPDIR.'/cache/reports/'.$rhname, "w")) {
			$go_errors[] = "Failed to create file for report $report_filename";
			return false;
		}
		if (fwrite($f, $report_template) === FALSE) {
			$go_errors[] = "Failed to write file for report $report_filename";
			return false;
		}
		fclose($f);
		return true;
	}
	
	function generate_report($report_filename, $report_dir='/', $paper_size='A4', $logo='')
	{
		global $_APPDIR;
		if (!empty($logo)) $logo = $_APPDIR.'/'.$logo;

		$pdfCmd = "/usr/bin/htmldoc -t pdf --no-embedfonts --compression=9 --textfont Arial --no-pscommands --quiet ";
		$pdfCmd.= "--no-xrxcomments --size $paper_size --logoimage $logo --jpeg --top 50mm --bottom 40mm --webpage -f ";

		$report_filename = $report_filename;
		
		$rhname = $report_filename.'.html';
		$rpname = $report_filename.'.pdf';
		
		putenv("HTMLDOC_NOCGI=1");
		exec($pdfCmd." $_APPDIR/reports/$report_dir/$rpname $_APPDIR/cache/reports/$rhname");
		// FIXME: No errors ???
		return true;
	}

		

define('SQL_CHECK_OKNUM', <<<GLG
SELECT invoice_client_code from view_fn_apar_details_all
WHERE 
apar_number = ?
GLG
);

define('SQL_APAR_OKNUM', <<<GLG
SELECT sales_person,d.*, split_part(d.reference, ';', 1) AS sales_number, split_part(d.reference, ';', 2) AS rev_number,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT p.insurance_product_name 
  FROM tbl_pd_insurance_products AS p 
  WHERE p.insurance_product_code = s.insurance_product_code
  LIMIT 1
 )
ELSE ''
END AS prd_name,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT q.product_group_name 
  FROM tbl_pd_insurance_products AS p, tbl_pd_product_groups AS q 
  WHERE p.insurance_product_code = s.insurance_product_code
  AND p.product_group_code = q.product_group_code
  LIMIT 1
 )
ELSE ''
END AS product_group,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT t.terms_of_payment_name
  FROM tbl_cs_terms_payment AS t 
  WHERE t.terms_of_payment_code = s.term_of_payment_code_premium
  LIMIT 1
 )
ELSE ''
END AS top,
s.insurance_period_from,
s.insurance_period_to,
s.own_share,
s.commission,
s.discount,
s.revision_flag,
s.esign,
s.product_alias_code,
(select oknum_name from tbl_so_sales_oknums where sales_number=split_part(d.reference, ';', 1) and revision_number=split_part(d.reference, ';', 2) and oknum_name = d.invoice_client_name and commission_currency = d.transaction_currency)as ccbname
FROM 
 view_fn_apar_details_all d LEFT OUTER JOIN tbl_so_sales_details s 
	ON (s.sales_number = split_part(d.reference, ';', 1) AND s.revision_number = split_part(d.reference, ';', 2)) 
WHERE 
apar_number = ?
GLG
);





/*define('SQL_APAR_DETAILS', <<<EOS
SELECT d.*, split_part(d.reference, ';', 1) AS sales_number, split_part(d.reference, ';', 2) AS rev_number,

CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 CASE WHEN ((select code from "tbl_pd_alias" where code=s.insurance_product_code)= null) 
	THEN
		(SELECT p.insurance_product_name 
 			 FROM tbl_pd_insurance_products AS p 
 			 WHERE p.insurance_product_code = (SELECT insurance_product_code FROM tbl_pd_alias where code =  s.insurance_product_code )
 	 		LIMIT 1
 		)
	ELSE
		(SELECT p.name 
 		 FROM tbl_pd_alias AS p 
 		 WHERE p.insurance_product_code = (SELECT insurance_product_code from tbl_pd_alias where code=s.insurance_product_code)
 	 	LIMIT 1
 		)
	END
ELSE ''
END AS prd_name,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 CASE WHEN ((select code from "tbl_pd_alias" where code=s.insurance_product_code)= null) 
	THEN
		 (SELECT q.product_group_name 
  			FROM tbl_pd_insurance_products AS p, tbl_pd_product_groups AS q 
  			WHERE p.insurance_product_code = s.insurance_product_code
  			AND p.product_group_code = q.product_group_code
  			LIMIT 1
 		)

	ELSE
		 (SELECT q.product_group_name 
  			FROM tbl_pd_insurance_products AS p, tbl_pd_product_groups AS q 
  			WHERE p.insurance_product_code = (SELECT insurance_product_code FROM tbl_pd_alias where code =  s.insurance_product_code)
  			AND p.product_group_code = q.product_group_code
  			LIMIT 1
 		)
	END
ELSE ''
END AS product_group,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT t.terms_of_payment_name
  FROM tbl_cs_terms_payment AS t 
  WHERE t.terms_of_payment_code = s.term_of_payment_code_premium
  LIMIT 1
 )
ELSE ''
END AS top,
s.insurance_period_from,
s.insurance_period_to,
d.invoice_client_code,
replace(
replace(
(
SELECT
COALESCE(l.street_address,'') || '<br>' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.kelurahan_code)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.kecamatan_code)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.kabupaten_kotamadya_code)||'. ','') ||
'<br>' || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.state_province_code)||'. ','') ||
'<br>' || 
COALESCE(l.postal_code||'. ','') || '<br>' || 
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.country_code)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE
code = d.invoice_client_code
),
 
  'NO KABUPATEN NAME', '') ,
  '. .', '. ') AS client_address,


COALESCE(p.telephone_fixed, p.telephone_mobile) AS client_telp,
p.facsimile AS client_fax,
p.email AS client_email,
(SELECT mname FROM tbl_gl_manual_ap_ar_accounts WHERE mcode = manual_apar_type LIMIT 1) AS mapar_type,s.cco_name as cconame,
case when trim(both ' ' from ccb_name) = '' then ''
else ' QQ '||ccb_name
end as ccbname,
s.own_share,
s.commission,
s.leader_fee,
s.co_insurance_code,
s.discount,
s.revision_flag
FROM 
tbl_mstr_business_partner p, view_fn_apar_details_all d LEFT OUTER JOIN tbl_so_sales_details s 
	ON (s.sales_number = split_part(d.reference, ';', 1) AND s.revision_number = split_part(d.reference, ';', 2)) 
WHERE 
apar_number = ?
AND
p.code = d.invoice_client_code
EOS
);
*/

define('SQL_APAR_DETAILS', <<<EOS
SELECT sales_person,d.*, split_part(d.reference, ';', 1) AS sales_number, split_part(d.reference, ';', 2) AS rev_number,

CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 CASE WHEN ((select code from "tbl_pd_alias" where code=s.insurance_product_code)= null) 
  THEN
    (SELECT p.insurance_product_name 
       FROM tbl_pd_insurance_products AS p 
       WHERE p.insurance_product_code = (SELECT insurance_product_code FROM tbl_pd_alias where code =  s.insurance_product_code )
      LIMIT 1
    )
  ELSE
    (SELECT p.name 
     FROM tbl_pd_alias AS p 
     WHERE p.insurance_product_code = (SELECT insurance_product_code from tbl_pd_alias where code=s.insurance_product_code)
    LIMIT 1
    )
  END
ELSE ''
END AS prd_name,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT q.product_group_name 
  FROM tbl_pd_insurance_products AS p, tbl_pd_product_groups AS q 
  WHERE p.insurance_product_code = s.insurance_product_code
  AND p.product_group_code = q.product_group_code
  LIMIT 1
 )
ELSE ''
END AS product_group,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT t.terms_of_payment_name
  FROM tbl_cs_terms_payment AS t 
  WHERE t.terms_of_payment_code = s.term_of_payment_code_premium
  LIMIT 1
 )
ELSE ''
END AS top,
s.insurance_product_code,
s.insurance_period_from,
s.insurance_period_to,
replace(to_char(s.insurance_period_to::date, 'DD-Month-YYYY'),' ','') as insurance_period_to2, --Muh, bug php
s.term_of_payment_code_premium,
d.invoice_client_code,
replace(
replace(
(
SELECT
COALESCE(l.street_address,'') || '<br>' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.kelurahan_code)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.kecamatan_code)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.kabupaten_kotamadya_code)||'. ','') ||
'<br>' || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.state_province_code)||'. ','') ||
'<br>' || 
COALESCE(l.postal_code||'. ','') || '<br>' || 
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.country_code)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE
code = d.invoice_client_code
),
 
  'NO KABUPATEN NAME', '') ,
  '. .', '. ') AS client_address,
replace(
replace(
(
SELECT
COALESCE(l.crd_street_address,'') || '<br>' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.crd_kelurahan_code LIMIT 1)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.crd_kecamatan_code LIMIT 1)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.crd_kabupaten_kotamadya_code LIMIT 1)||'. ','') ||
'<br>' || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.crd_state_province_code LIMIT 1)||'. ','') ||
'<br>' || 
COALESCE(l.crd_postal_code||'. ','') || '<br>' || 
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.crd_country_code LIMIT 1)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE
code = d.invoice_client_code
),
 
  'NO KABUPATEN NAME', '') ,
  '. .', '. ') AS crd_address,



COALESCE(p.telephone_fixed, p.telephone_mobile) AS client_telp,
p.facsimile AS client_fax,
p.email AS client_email,
(SELECT mname FROM tbl_gl_manual_ap_ar_accounts WHERE mcode = manual_apar_type LIMIT 1) AS mapar_type,s.cco_name as cconame,
case 
when (s.int_name ilike '%BNI%' and s.intermediary_type = 'BANK') then 'YES' 
when (s.int_name ilike '%bank%negara%indonesia%' and s.intermediary_type = 'BANK') then 'YES' 
else 'NO' end as note
,s.policy_wording_code as wording_code,
case when trim(both ' ' from ccb_name || on_behalf_others) = '' then ''
else case when trim(ccb_name) = '' then '' else ' ' ||connecting_word|| ' ' ||ccb_name 
end || case when trim(on_behalf_others) = '' then '' else ' ' || on_behalf_others end 
--else case when trim(ccb_name) = '' then '' else '  '||ccb_name end || case when trim(on_behalf_others) = '' then '' else ' ' || on_behalf_others end 
end as ccbname,
s.own_share,
s.commission,
s.leader_fee,
s.userid,
s.intermediary_type,
d.transaction_currency,
s.term_of_payment_code_premium,
s.co_insurance_code,
s.discount,
s.revision_flag,
s.esign as es,
s.product_alias_code,
(case when lower(substring(cco_name, 1,26))='pt cimb niaga auto finance' and substring(s.sales_number,4,3)='398' then  true else false end) as is_cnaf,
campaign_code,
--CASE WHEN s.intermediary_type='AGENT' AND s.front_office_code_handling = '10' AND s.insurance_product_code not in ('121','200','201','202','203','204','205') AND s.co_insurance_code <> 1 AND s.print_welcome_letter = 't' THEN
CASE WHEN s.intermediary_type IN  ('AGENT','---','INSTITUTIONAL AGENT') AND s.insurance_product_code not in ('121','200','201','202','203','204','205') AND s.co_insurance_code <> '1' AND (SELECT DATE_PART('day', (select insurance_period_to FROM tbl_so_sales_details where sales_number ||';'|| revision_number = s.sales_number||';'||s.revision_number)::timestamp - (select insurance_period_from FROM tbl_so_sales_details where sales_number ||';'|| revision_number = s.sales_number||';'||s.revision_number)::TIMESTAMP)<= '366' ) AND ((SELECT count(*) from tbl_ra_outward_facultative where sales_coverage_number||';'||sales_coverage_rev_number = s.sales_number||';'||s.revision_number) = 0) AND ((SELECT COUNT(*) FROM tbl_so_sales_details where sales_number = s.sales_number and sales_status = 'Master JP') = 0)   THEN
  TRUE
ELSE  
  FALSE
END as is_agent

FROM 
tbl_mstr_business_partner p, view_fn_apar_details_all d LEFT OUTER JOIN tbl_so_sales_details s 
  ON (s.sales_number = split_part(d.reference, ';', 1) AND s.revision_number = split_part(d.reference, ';', 2)) 
WHERE 
apar_number = ?
AND
p.code = d.invoice_client_code
EOS
);

define('SQL_APAR_NIAGA', <<<LEO
SELECT sales_person,d.*, split_part(d.reference, ';', 1) AS sales_number, split_part(d.reference, ';', 2) AS rev_number,

CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 CASE WHEN ((select code from "tbl_pd_alias" where code=s.insurance_product_code)= null) 
   THEN
      (SELECT p.insurance_product_name 
          FROM tbl_pd_insurance_products AS p 
          WHERE p.insurance_product_code = (SELECT insurance_product_code FROM tbl_pd_alias where code =  s.insurance_product_code )
         LIMIT 1
      )
   ELSE
      (SELECT p.name 
       FROM tbl_pd_alias AS p 
       WHERE p.insurance_product_code = (SELECT insurance_product_code from tbl_pd_alias where code=s.insurance_product_code)
      LIMIT 1
      )
   END
ELSE ''
END AS prd_name,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT q.product_group_name 
  FROM tbl_pd_insurance_products AS p, tbl_pd_product_groups AS q 
  WHERE p.insurance_product_code = s.insurance_product_code
  AND p.product_group_code = q.product_group_code
  LIMIT 1
 )
ELSE ''
END AS product_group,
CASE WHEN (d.transaction_type !~ '.*Manual.*') 
THEN
 (SELECT t.terms_of_payment_name
  FROM tbl_cs_terms_payment AS t 
  WHERE t.terms_of_payment_code = s.term_of_payment_code_premium
  LIMIT 1
 )
ELSE ''
END AS top,
s.insurance_product_code,
s.insurance_period_from,
s.insurance_period_to,
replace(to_char(s.insurance_period_to::date, 'DD-Month-YYYY'),' ','') as insurance_period_to2, --Muh, bug php
s.term_of_payment_code_premium,
d.invoice_client_code,
replace(
replace(
(
SELECT
COALESCE(l.street_address,'') || '<br>' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.kelurahan_code)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.kecamatan_code)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.kabupaten_kotamadya_code)||'. ','') ||
'<br>' || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.state_province_code)||'. ','') ||
'<br>' || 
COALESCE(l.postal_code||'. ','') || '<br>' || 
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.country_code)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE
code = d.invoice_client_code
),
 
  'NO KABUPATEN NAME', '') ,
  '. .', '. ') AS client_address,
replace(
replace(
(
SELECT
COALESCE(l.crd_street_address,'') || '<br>' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.crd_kelurahan_code LIMIT 1)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.crd_kecamatan_code LIMIT 1)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.crd_kabupaten_kotamadya_code LIMIT 1)||'. ','') ||
'<br>' || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.crd_state_province_code LIMIT 1)||'. ','') ||
'<br>' || 
COALESCE(l.crd_postal_code||'. ','') || '<br>' || 
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.crd_country_code LIMIT 1)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE
code = d.invoice_client_code
),
 
  'NO KABUPATEN NAME', '') ,
  '. .', '. ') AS crd_address,



COALESCE(p.telephone_fixed, p.telephone_mobile) AS client_telp,
p.facsimile AS client_fax,
p.email AS client_email,
(SELECT mname FROM tbl_gl_manual_ap_ar_accounts WHERE mcode = manual_apar_type LIMIT 1) AS mapar_type,s.cco_name as cconame,s.policy_wording_code as wording_code,
CASE WHEN (s.customer_code_on_behalf IS NOT NULL AND on_behalf_others != '' AND s.cco_name ILIKE '%CIMB%') THEN 
(SELECT (title || ' ' || name || ' ')|| '(' ||on_behalf_others ||') and/or subsidiary and/or associated and/or related companies for their respective rights an interested and  PT. Bank CIMB Niaga Tbk., as MORTGAGEE' FROM tbl_mstr_business_partner WHERE code = s.customer_code_on_behalf)
ELSE ''
||
CASE WHEN (s.customer_code_on_behalf IS NOT NULL AND s.cco_name ILIKE '%CIMB%' ) THEN 
(SELECT (title || ' ' || name || ' ') || 'and/or subsidiary and/or associated and/or related companies for their respective rights an interested and  PT. Bank CIMB Niaga Tbk., as MORTGAGEE' FROM tbl_mstr_business_partner WHERE code = customer_code_on_behalf)
 ELSE ''
||
 CASE WHEN (s.customer_code_on_behalf IS NOT NULL AND s.customer_code_on_behalf <> '') THEN 
 (SELECT ' QQ ' || (title || ' ' || name || ' ') FROM tbl_mstr_business_partner WHERE code = s.customer_code_on_behalf)
 ELSE ''
 END 
 END
 END  as ccbname,
s.own_share,
s.commission,
s.leader_fee,
s.userid,
s.intermediary_type,
d.transaction_currency,
s.term_of_payment_code_premium,
s.co_insurance_code,
s.discount,
s.revision_flag,
s.esign as es,
s.product_alias_code,
(case when lower(substring(cco_name, 1,26))='pt cimb niaga auto finance' and substring(s.sales_number,4,3)='398' then  true else false end) as is_cnaf,
campaign_code,
--CASE WHEN s.intermediary_type='AGENT' AND s.front_office_code_handling = '10' AND s.insurance_product_code not in ('121','200','201','202','203','204','205') AND s.co_insurance_code <> 1 AND s.print_welcome_letter = 't' THEN
CASE WHEN s.intermediary_type IN  ('AGENT','---','INSTITUTIONAL AGENT') AND s.insurance_product_code not in ('121','200','201','202','203','204','205') AND s.co_insurance_code <> '1' AND (SELECT DATE_PART('day', (select insurance_period_to FROM tbl_so_sales_details where sales_number ||';'|| revision_number = s.sales_number||';'||s.revision_number)::timestamp - (select insurance_period_from FROM tbl_so_sales_details where sales_number ||';'|| revision_number = s.sales_number||';'||s.revision_number)::TIMESTAMP)<= '366' ) AND ((SELECT count(*) from tbl_ra_outward_facultative where sales_coverage_number||';'||sales_coverage_rev_number = s.sales_number||';'||s.revision_number) = 0) AND ((SELECT COUNT(*) FROM tbl_so_sales_details where sales_number = s.sales_number and sales_status = 'Master JP') = 0)   THEN
  TRUE
ELSE  
  FALSE
END as is_agent

FROM 
tbl_mstr_business_partner p, view_fn_apar_details_all d LEFT OUTER JOIN tbl_so_sales_details s 
   ON (s.sales_number = split_part(d.reference, ';', 1) AND s.revision_number = split_part(d.reference, ';', 2)) 
WHERE 
apar_number = ?
AND
p.code = d.invoice_client_code
LEO
);

define('SQL_QUERY_TAX', <<<EOS
SELECT
"public"."tbl_fn_taxes"."percentage"
FROM
"public"."tbl_so_sales_details"
Inner Join "public"."tbl_fn_taxes" ON "public"."tbl_so_sales_details"."int_sales_tax" = "public"."tbl_fn_taxes"."tax_code"
WHERE
"public"."tbl_so_sales_details"."sales_number" = ? AND
"public"."tbl_so_sales_details"."revision_number" = ?
EOS
);

define('SQL_QUERY_PPH', <<<EOS
SELECT
"public"."tbl_fn_taxes"."percentage"
FROM
"public"."tbl_so_sales_details"
Inner Join "public"."tbl_fn_taxes" ON "public"."tbl_so_sales_details"."tax_witholding_income" = "public"."tbl_fn_taxes"."tax_code"
WHERE
"public"."tbl_so_sales_details"."sales_number" = ? AND
"public"."tbl_so_sales_details"."revision_number" = ?
EOS
);

define('SQL_APAR_LINES_BACKUP', <<<EOS
SELECT 
replace(replace(l.transaction_origin, 'AR', ''), 'AP', '') AS transaction_origin,
transaction_amount, transaction_home_amount
FROM view_fn_apar_lines_all l
WHERE 
apar_number = ?
AND
-- transaction_origin ~ '.*Receivable.*|.*Payable.*|.*AP.*|.*AR.*|Withholding income tax payable'
balance_type = 'credit'
AND
transaction_home_amount <> 0
ORDER BY lines_id
EOS
);

define('SQL_APAR_LINES', <<<EOS
SELECT 
replace(replace(l.transaction_origin, 'AR', ''), 'AP', '') AS transaction_origin,transaction_origin as origin,
transaction_amount, transaction_home_amount
FROM view_fn_apar_lines_all l
WHERE 
apar_number = ?
AND
transaction_home_amount <> 0
ORDER BY lines_id
EOS
);

define('SQL_GET_AP_REFERENCE', <<<EOS
SELECT reference
FROM view_fn_apar_details_all
WHERE 
apar_number = ?
EOS
);

define('SQL_COUNTING_AR_NUMBER', <<<VYAN
SELECT count(*) as jml
FROM view_fn_apar_details_all
WHERE 
reference = ? AND
transaction_currency=? AND
substring(apar_number,1,2)='AR'
VYAN
);

define('SQL_GET_AR_NUMBER', <<<EOS
SELECT apar_number
FROM view_fn_apar_details_all
WHERE 
reference = ? AND
transaction_currency=? AND
substring(apar_number,1,2)='AR'
EOS
);

define('SQL_GET_AR_NUMBER2', <<<VYAN
SELECT apar_number
FROM view_fn_apar_details_all
WHERE 
reference = ? AND
transaction_currency=? AND
substring(apar_number,1,2)='AR'
and coalesce(period_year,'') = coalesce(?,'')
and coalesce(period_index,'') = coalesce(?,'')
VYAN
);

define('SQL_AR_LINES', <<<EOS
SELECT 
replace(replace(l.transaction_origin, 'AR', ''), 'AP', '') AS transaction_origin,transaction_origin as origin,
transaction_amount, transaction_home_amount
FROM view_fn_apar_lines_all l
WHERE 
l.apar_number=?
AND
transaction_home_amount <> 0
ORDER BY lines_id
EOS
);

define('SQL_AR_CASE', <<<EOS
SELECT 
transaction_amount
FROM view_fn_apar_lines_all l
WHERE 
l.apar_number=?
AND
transaction_home_amount <> 0
and transaction_origin ILIKE '%Sales tax payable%'
ORDER BY lines_id
EOS
);

define('SQL_APAR_TOTALS', <<<EOS
SELECT SUM(transaction_amount) AS total
FROM view_fn_apar_lines_all l
WHERE 
apar_number = ?
AND
transaction_origin ~ '.*Receivable.*|.*Payable.*|.*AP.*|.*AR.*'
EOS
);

define('SQL_APAR_HOME_TOTALS', <<<EOS
SELECT SUM(transaction_home_amount) AS total
FROM view_fn_apar_lines_all l
WHERE 
apar_number = ?
AND
transaction_origin ~ '.*Receivable.*|.*Payable.*|.*AP.*|.*AR.*'
EOS
);

define('SQL_APAR_INSTALMENTS', <<<EOS
SELECT *
FROM view_fn_apar_instalments_all 
WHERE 
apar_number = ?
ORDER BY instalment_id
EOS
);


define('SQL_CHECK_INSTALMENTS', <<<ADE
SELECT COUNT(*)
FROM view_fn_apar_instalments_all 
WHERE 
apar_number = ?
ADE
);


define('SQL_CHECK_MV',<<<ADE
SELECT COUNT(*) FROM tbl_pd_insurance_products WHERE product_group_code = 'GV01' AND insurance_product_code = ?
ADE
);

define('SQL_APAR_OBJECTS', <<<EOS
SELECT coverage_name, liability_limit,currency_code,declared_value 
FROM tbl_so_sales_objects o
WHERE o.sales_number = ? AND o.revision_number = ? AND o.liability_limit > 0
EOS
);


define('SQL_SALES_COUNT', <<<aisyah
SELECT
COUNT(sales_number)
FROM tbl_so_sales_details
WHERE
customer_code_orig = ?
aisyah
);

define('SQL_PRODUCT_COUNT', <<<aisyah
SELECT
COUNT(sales_number) 
FROM tbl_so_sales_details
WHERE
insurance_product_code = substring(? from 4 for 3)
AND
customer_code_orig = ?
aisyah
);

define('SQL_FAKTUR',<<<GLG
SELECT DISTINCT
"public"."tbl_mstr_business_partner"."name",
"public"."tbl_so_sales_coinsurance"."share_percentage",
"public"."tbl_so_sales_details"."cco_name",
"public"."tbl_so_sales_details"."intermediary_code",
"public"."tbl_so_sales_details"."discount"
FROM
"public"."tbl_so_sales_coinsurance"
Inner Join "public"."tbl_mstr_business_partner" ON "public"."tbl_so_sales_coinsurance"."coinsurance_code" = "public"."tbl_mstr_business_partner"."code"
Inner Join "public"."tbl_so_sales_details" ON "public"."tbl_so_sales_coinsurance"."sales_number" = "public"."tbl_so_sales_details"."sales_number"
--case ticket Ticket#2019082010000635 menjadi double
and "public"."tbl_so_sales_coinsurance"."revision_number" = "public"."tbl_so_sales_details"."revision_number"
--case ticket Ticket#2019082010000635 menjadi double
WHERE
"public"."tbl_so_sales_coinsurance"."sales_number" = ? and "public"."tbl_so_sales_coinsurance".revision_number= ?
GLG
);

define('SQL_BACKOFFICE',<<<GLG
select name,address,telephone,fax,email from adm_back_office where code=?
GLG
);

define('SQL_REKENING',<<<GLG
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true
GLG
);

/*add By Piman for Bank woori 13 Des 2017*/
define('SQL_REKENING_WOORI',<<<GLG
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true
union all
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts where  cbcode ='1221228'
GLG
);
/*end*/

define('SQL_REKENING2',<<<NYN
SELECT cbcode,cbname,ccode,acode,bocode,norek
FROM tbl_gl_cash_bank_accounts WHERE 
(bocode=? and 
acode not in('1221672','1221677','1221673','1221490','1221162','1221151','1221675','1221674','1221850'))
or
(bocode ='12' and acode in ('case2017121210000799_1222040', '1222020'))
NYN
);

define('SQL_REKENING3',<<<GLG
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode='80' and 
acode not in('1221672','1221677','1221673','1221490','1221162','1221151','1221675','1221671','1221676')
and
(cbname ilike ?
or cbname ilike '%bca%')
GLG
);

define('SQL_REKENING_JAKARTA',<<<GLG
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true
UNION ALL
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE cbcode = 'case2017121210000799_1222040'
UNION ALL
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE cbcode = '1221530'
GLG
);

define('SQL_REKENING_BSD',<<<ARS
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true
UNION ALL
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE cbcode in ('1221521', '1222020')
ARS
);

define('SQL_REFERENCE',<<<GLG
SELECT 
split_part(reference,'~~',2) as leader_number, 
split_part(split_part(reference,'~~',3),'Quotation',1) as reference_number 
FROM 
"tbl_so_sales_details" 
WHERE 
sales_number=? AND 
revision_number=?
GLG
);

/*
define('SQL_QUERY_ADDRESS', <<<EOS
SELECT
"public"."tbl_mstr_business_partner"."name",
"public"."tbl_mstr_business_partner"."street_address",
"public"."tbl_mstr_business_partner"."telephone_fixed",
"public"."tbl_mstr_business_partner"."facsimile",
"public"."tbl_mstr_business_partner"."email"
FROM
"public"."tbl_so_sales_details"
Inner Join "public"."tbl_mstr_business_partner" ON "public"."tbl_so_sales_details"."intermediary_code" = "public"."tbl_mstr_business_partner"."code"
WHERE
"public"."tbl_so_sales_details".sales_number=? AND
"public"."tbl_so_sales_details".revision_number=?
EOS
);
*/

define('SQL_QUERY_ADDRESS', <<<EOS
SELECT
	name,
	street_address,
	telephone_fixed,
	telephone_mobile,
	facsimile,
	email
FROM
	tbl_mstr_business_partner
WHERE
	code = ?
EOS
);

/*
define('SQL_QUERY_ADDRESS_OKNUM', <<<EOS
SELECT
oknum_name as name,
'-' as street_address,
'-' as telephone_fixed,
'-' as facsimile,
'-' as email,
commission_currency,
commission_amount
FROM
"public"."tbl_so_sales_oknums"
WHERE
"public"."tbl_so_sales_oknums".sales_number=? AND
"public"."tbl_so_sales_oknums".revision_number=?
EOS
);
*/

define('SQL_QUERY_ADDRESS_OKNUM', <<<EOS
SELECT
invoice_client_name as name,
'-' as street_address,
'-' as telephone_fixed,
'-' as telephone_mobile,
'-' as facsimile,
'-' as email
FROM
view_fn_apar_details_all
WHERE
apar_number=?
EOS
);

define('SQL_REFERENCE_NUMBER', <<<GLG
SELECT attribute_value FROM tbl_so_object_attributes o,tbl_pd_attribute_per_insurance AS a,tbl_so_sales_details AS s
  WHERE 
    o.sales_number = ? AND o.revision_number = ? AND attribute_code='AC46'
  AND
    s.sales_number = o.sales_number AND s.revision_number = o.revision_number
  AND
    a.insurance_product_code = s.insurance_product_code
  AND
   o.attribute_code = a.product_attribute_code
  AND
   a.print_on_policy = 't'
GLG
);

define('GETPHKPATNER',<<<VYAN
select
product_attribute_option_code as partnerCode
FROM
tbl_so_sales_attributes
where sales_number = ? and revision_number = ?
and product_attribute_code = 'LFPART' 
VYAN
);

//buat dapetin polis polis produksi CS aja
/*define('GETGRPUSER',<<<EOS
	select a.deptname,a.userid from adm_users a join tbl_so_sales_tracker t on t.userid=a.userid 
and t.sales_number = ? and t.revision_number = ? and t.sales_status in ('Created','Renewal','Endorsing','Invoiced')
ORDER BY actiontime 
ASC limit 1
EOS
);
*/

//modified by GLG at 04-Jan-2012 to mediate CNAF business process. 
define('GETGRPUSER',<<<EOS
select 	
	(case when lower((select substring(cco_name,1,26) from tbl_so_sales_details where sales_number=t.sales_number and revision_number=t.revision_number))='pt cimb niaga auto finance' and substring(t.sales_number,4,3)='398' then 'CS' else a.deptname end) as deptname,
	a.userid 
from adm_users a join tbl_so_sales_tracker t on t.userid=a.userid 
and t.sales_number = ? and t.revision_number = ? and t.sales_status in ('Created','Renewal','Endorsing','Risk Accepted','Invoiced')
ORDER BY actiontime 
DESC limit 1
EOS
);

define('GETDEPT',<<<EOS
SELECT userid, deptname from adm_users where userid = ?
EOS
);

define('SQL_GET_TOP_CALCMETHOD2', <<<EOS
SELECT calculation_method FROM tbl_cs_terms_payment WHERE terms_of_payment_code = ?
EOS
);

define('SQL_GET_TOP_PERIODS2', <<<EOS
SELECT instalment_number, payment_period, payment_percentage FROM tbl_cs_instalment_schedule WHERE terms_of_payment_code = ?
EOS
);

define('GET_VIRTUAL_ACCOUNT',<<<vyan
select bank_code,cur,substr(va_number, 0 ,5) as va_1, substr(va_number, 5 ,5) as va_2,substr(va_number, 10 ,7) as va_3 from tbl_so_sales_va where sales_number = ? and revision_number = ? and duplicate = 'f'  order by bank_code,cur
vyan
);

define('GET_VIRTUAL_ACCOUNT2',<<<vyan
select count(*) as va_count from tbl_so_sales_va where sales_number = ? and revision_number = ? and duplicate = 'f' and va_number not in ('00322','5819','')
vyan
);

define('SQL_REKENING11',<<<GLG
SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true and ccode!='IDR'
GLG
);

define('SQL_GET_REFERENCE', <<<VTR
SELECT reference
FROM view_fn_apar_details_all
WHERE 
apar_number = ? 
VTR
);

define('SQL_COUNT_OKNUM', <<<VTR
SELECT 
COUNT(*)
FROM view_fn_apar_details_all
WHERE 
transaction_type = 'Insurance commission oknum' 
AND
reference = ?
VTR
);

define('SQL_QUERY_OBJECTS_OJK', <<<VTR
SELECT 
o.revision_number, coverage_name, object_number, location_id, interest_name, non_marine, currency_code, premium_base, adjustment, premium, declared_value,liability_limit,
rate AS ratedesc, COALESCE(marine,0) + COALESCE(non_marine,0) + COALESCE(cat_nat,0) + COALESCE(cat_soc,0) AS rate, description, '' as stat,
split_part(description, '#', 1) as si,
split_part(description, '#', 2) as penumpang,
split_part(description, '#', 3) as tsi_pro,
date_part('year',age(p.insurance_period_to, p.insurance_period_from)) as tahun,  
date_part('month',age(p.insurance_period_to, p.insurance_period_from)) as bulan
FROM 
tbl_so_sales_objects AS o join tbl_so_sales_details p on p.sales_number = o.sales_number AND p.revision_number = o.revision_number
WHERE 
o.sales_number = ?
AND
o.print_on_policy = 't'
ORDER BY object_number ASC, coverage_name ASC, currency_code ASC
VTR
);

define('get_perluasan',<<<vtr
SELECT code,rate from tbl_so_sales_object_additional_premium 
where 
sales_number = ? and rate <> 0
vtr
);

define('KODE_PRODUK_ALL',<<<vtr
SELECT substr(sales_number, 4, 3) AS kode_produk 
FROM tbl_so_sales_details 
WHERE 
sales_number = ? 
AND 
revision_number = ?
AND
reference = 'SPPA-ALL'
vtr
);

define('SQL_QUERY_DETAILS', <<<EOS
SELECT substring(sales_number,2,2) as office_code,sales_number,revision_number,substring(sales_number,4,3) as kode_polis,sales_number || revision_number AS sales_numbers, sales_type,
(SELECT b.name FROM adm_back_office AS b, adm_front_office AS f WHERE f.code = front_office_code_handling AND b.code = f.back_office_code) AS office_name,
(SELECT b.name FROM adm_back_office AS b, adm_front_office AS f WHERE f.code = front_office_code_handling AND b.code = f.back_office_code) AS back_office_name,

(SELECT b.address || ' PH :'||b.telephone||', FAX :'||b.fax  FROM adm_back_office AS b, adm_front_office AS f WHERE f.code = front_office_code_handling AND b.code = f.back_office_code) AS office_address,

(SELECT b.back_office_head_name FROM adm_back_office AS b, adm_front_office AS f WHERE f.code = front_office_code_handling AND b.code = f.back_office_code) AS head_name,
(SELECT b.back_office_head FROM adm_back_office AS b, adm_front_office AS f WHERE f.code = front_office_code_handling AND b.code = f.back_office_code) AS headid,
CURRENT_DATE as print_date,
(
 SELECT insurance_product_name FROM
 tbl_pd_insurance_products 
 WHERE
 insurance_product_code = s.insurance_product_code
) AS insurance_product_name,

(
 SELECT (title || ' ' || name) 
 FROM tbl_mstr_business_partner
 WHERE code = s.customer_code_orig
)
|| 
 CASE WHEN s.customer_code_on_behalf IS NOT NULL and s.customer_code_on_behalf <> '' THEN 
 (SELECT ' QQ ' || (title || ' ' || name || ' ') FROM tbl_mstr_business_partner WHERE code = s.customer_code_on_behalf)
 ELSE ''
 END 
||
 COALESCE(' QQ ' || s.on_behalf_others, '')

|| 
 CASE WHEN extend_customer_definition = 't' THEN 
 ' and/or subsidiary and/or affiliated and/or associated for their respective right/interests.' 
 ELSE ''
 END 
AS customer_name,
(
 SELECT (title || ' ' || name) 
 FROM tbl_mstr_business_partner
 WHERE code = s.customer_code_orig
) as cco_name,
(
SELECT 
COALESCE(l.street_address,'') || ' ' ||
COALESCE((SELECT str_kelurahan_name FROM tbl_mstr_kelurahan WHERE num_kelurahan_id = l.kelurahan_code)||'. ' ,'') ||
COALESCE((SELECT str_city_name FROM tbl_mstr_city WHERE num_city_id = l.kecamatan_code)||'. ','') ||
COALESCE((SELECT str_kabupaten_name FROM tbl_mstr_kabupaten WHERE num_kabupaten_id = l.kabupaten_kotamadya_code)||'. ','') || 
COALESCE((SELECT str_province_name FROM tbl_mstr_province WHERE num_province_id = l.state_province_code)||'. ','') ||
COALESCE(l.postal_code||'. ','') ||
COALESCE((SELECT str_country_name FROM tbl_mstr_country WHERE str_country_code = l.country_code)||'.','')
FROM
tbl_mstr_business_partner AS l
WHERE 
code = s.customer_code_orig
) AS customer_address,
inward_customer_orig, reference, own_share, discount,
policy_cost_currency_code,
policy_cost_amount,
stamp_duty_currency_code,
stamp_duty_amount,
intermediary_type,
insurance_period_from AS period_from, insurance_period_to AS period_to,
print_cover,
print_schedule,
print_policy_wording,
print_extension_clauses,
insurance_product_code,
product_alias_code,
own_share,
(case when lower(substring(cco_name, 1,26))='pt cimb niaga auto finance' and substring(sales_number,4,3)='398' then  true else false end) as is_cnaf,
campaign_code
FROM
tbl_so_sales_details AS s
WHERE
s.sales_number = ? AND s.revision_number = ?
EOS
);

define('GET_CAMPAIGN_CODE',<<<CLO
select campaign_code from tbl_so_sales_details where sales_number = ? and revision_number = ?
CLO
);

define('GET_KODE_CABANG',<<<CLO
select substr(sales_number,2,2) as kode_cabang from tbl_so_sales_details where sales_number = ? and revision_number = ?
CLO
);

define('GET_INT_CODE',<<<MH
select intermediary_code from  tbl_so_sales_details where  sales_number=? and revision_number= ?
MH
);

define('GET_INT_TYPE',<<<MH
select intermediary_type from tbl_so_sales_details where sales_number = ? and revision_number= ?
MH
);

define('GET_BANK_ACCOUNT',<<<MH
select  case 
when int_name ilike '%cimb%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110005')
when int_name ilike '%mandiri%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='2110007')
when int_name ilike '%bni%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221530')
when int_name ilike '%bank negara indonesia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221530')
when int_name ilike '%qnb%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221706')
when int_name ilike '%permata%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221515')
when int_name ilike '%ocbc%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221803')
when int_name ilike '%sampoerna%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221804')
when int_name ilike '%bri%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221216')
when int_name ilike '%bank rakyat indonesia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221216')
when int_name ilike '%bca%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110006')
when int_name ilike '%bank central asia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110006')
--when int_name ilike '%maybank%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221706')
when int_name ilike '%maybank%' then 'Maybank - Panglima Polim, Jakarta a/c 1021908017 (IDR)'
when int_name ilike '%bukopin%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221860')
when int_name ilike '%mega%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221970')
when int_name ilike '%shinhan%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221805')
end as info_bank
FROM tbl_so_sales_details where sales_number= ? and revision_number = ?
UNION
select 
case
when int_name ilike '%cimb%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110008')
when int_name ilike '%mandiri%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='2110009')
end as info_bank
FROM tbl_so_sales_details where sales_number= ? and revision_number= ?
MH
);

define('GET_BANK_ACCOUNT_CHECK',<<<MH
select  count(case 
when int_name ilike '%cimb%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110005')
when int_name ilike '%mandiri%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='2110007')
when int_name ilike '%bni%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221530')
when int_name ilike '%bank negara indonesia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221530')
when int_name ilike '%qnb%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221706')
when int_name ilike '%permata%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221515')
when int_name ilike '%ocbc%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')') FROM tbl_gl_cash_bank_accounts where cbcode='1221803')
when int_name ilike '%sampoerna%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221804')
when int_name ilike '%bri%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221216')
when int_name ilike '%bank rakyat indonesia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221216')
when int_name ilike '%bca%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110006')
when int_name ilike '%bank central asia%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='2110006')
--when int_name ilike '%maybank%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221706')
when int_name ilike '%maybank%' then 'Maybank - Panglima Polim, Jakarta a/c 1021908017 (IDR)'
when int_name ilike '%bukopin%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221860')
when int_name ilike '%mega%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221970')
when int_name ilike '%shinhan%' then (select Concat (cbname,' a/c ',norek,' (',ccode,')')  FROM tbl_gl_cash_bank_accounts where cbcode='1221805')
end )
FROM tbl_so_sales_details where sales_number=? and revision_number=?
MH
);

define('GET_PRODUCT_GVGP',<<<MUH
SELECT product_group_code as groups FROM tbl_pd_insurance_products 
WHERE product_group_code in ('GV01','GP01','GA01') AND insurance_product_code = (select insurance_product_code from tbl_so_sales_details where sales_number = ? and revision_number = ?)
UNION
SELECT 'GVGP' FROM tbl_pd_alias WHERE insurance_product_code in (select DISTINCT accstate_group_code from tbl_pd_insurance_products 
where product_group_code in ('GV01','GP01','GA01')) AND code = (select insurance_product_code from tbl_so_sales_details where sales_number = ? and revision_number = ?)
ORDER BY groups
MUH
);

//buat CIMB Intermediary
define('GETINTERM',<<<KID
select count(sales_number) as total from tbl_so_sales_details t WHERE t.sales_number = ? and t.revision_number = ?
and int_name ilike '%CIMB Niaga%'
limit 1
KID
);

define('SQL_QUERY_NIAGA',<<<Leo
SELECT * FROM tbl_so_sales_extensions 
WHERE sales_number = ? AND revision_number = ? AND extension_clause_code IN (
SELECT extension_clause_code FROM tbl_pd_extension_clauses WHERE extension_clause_name = 'Bankers Clause')
AND extension_clause_remarks ILIKE '%CIMB%';
Leo
);		
	function print_apar($apar_type, $apar_number,$bcoffcode)
	{
		global $go_db;
		global $go_user;
		global $go_tpl;
		global $go_errors;
		
		// error_reporting(E_ALL);
		// $go_db->debug=1;
 
		// External invoice list
		$extInvs = array(
				 'Insurance premium',
				 'Reinsurance inward facultative proportional premium',
				 'Co-insurance in premium',
				 'Co-insurance out premium'
				);

		// $go_db->debug=1;
		$niaga= $go_db->GetAll(SQL_APAR_NIAGA, $apar_number);
                if (count($niaga)>0){
                	$cimb_niaga = 'YES'; 
                }
				else {
					$cimb_niaga = 'NO';
				} 
		$is_oknum= $go_db->GetRow(SQL_CHECK_OKNUM, $apar_number);
	if ($cimb_niaga == 'YES') {
		if($is_oknum["invoice_client_code"] == "Oknum" && substr($apar_number,0,2) == "AP"){
			$a_data                = $go_db->GetRow(SQL_APAR_OKNUM, $apar_number);
		}else{
			$a_data                = $go_db->GetRow(SQL_APAR_DETAILS, $apar_number);
		}
	} else {
		if($is_oknum["invoice_client_code"] == "Oknum" && substr($apar_number,0,2) == "AP"){
			$a_data                = $go_db->GetRow(SQL_APAR_OKNUM, $apar_number);
		}else{
			$a_data                = $go_db->GetRow(SQL_APAR_NIAGA, $apar_number);	
		}
	}
		 //$go_db->debug=1;
		// $go_db->debug=1;error_reporting(E_ALL);
		// printr($a_data);
		
		$nm_cabang_jkt = array("Broker Service Department","Kediri","Bandar Lampung","Makassar");
		if (in_array($a_data['back_office_name'],$nm_cabang_jkt)){
			$a_data['back_office_name'] = 'Jakarta';
		}
		
		// <<vtr (print symbol for oknum)
		$vtr_reference = $go_db->GetOne(SQL_GET_REFERENCE, Array($apar_number));	
		$vtr_jml_oknum = $go_db->GetOne(SQL_COUNT_OKNUM, Array($vtr_reference));		
		if($vtr_jml_oknum > 0) {
		$a_data['vtr_k'] = "K";		
		}else{
		$a_data['vtr_k'] = '';		
		}
		// vtr>>
	
		// two type of Invoice: Internal and External, for Externals, we
		//                      don't like to put 'internal' word in the invoice
		// Put it this way, we can have generic template
		if (!in_array($a_data['transaction_type'], $extInvs)) {
			$a_data['transaction_type'] .= '';
		}
		
		//
		// classify invoice format based on their relations to sales data
		// we need to default to manual type for other kinds of invoices
		// 
		$s_type = $a_data['transaction_type'];
		$a_data['inv_type'] = 'manual';
		
		if (stristr($s_type, 'claim')) {
			$a_data['inv_type'] = 'claim';
		} else if (stristr($s_type, 'premium')) {
			$a_data['inv_type'] = 'premium';
			if (stristr($a_data['prdname'], 'marine')) {
				$a_data['inv_type'] = 'marine';
			} else if (stristr($s_type, 'treaty non proportional')) {
				$a_data['inv_type'] = 'excess';
			}
		}
		
		$rvnNumber = $a_data['rev_number'];
		//if(substr($a_data['sales_number'],3,3) == '397' or substr($a_data['sales_number'],3,3) == '501' or substr($a_data['sales_number'],3,3) == '199'){
			$jum = $go_db->GetOne("select count(*) from tbl_so_sales_details where sales_number = ? and revision_number::int = ?::int-1 and sales_status = 'Master JP'", array($a_data['sales_number'],$a_data[rev_number]));
			if ($jum == 1){
				$rvnNumber = $a_data[rev_number]-1;
				$rvnNumber = sprintf("%03s",$rvnNumber);
			} else {
				$rvnNumber = $a_data[rev_number];
			}
		//}
//$go_db->debug=1;
//printr($go_user);

		$a_data['dept'] = $go_user['attr']['departmentName'];
		$get_group = $go_db->GetRow(GETGRPUSER, array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['group'] = $get_group[deptname];
		
		//printr ($a_data['group']);	
		//printr ($a_data['dept'] );

		$a_data['sub_ao'] = substr($a_data['sales_person'],0,-2);
		$a_data['sub_sales'] = substr($a_data['sales_number'],3,3);

		$esSlsNumber = $a_data['sales_number'];$esRevNumber = $rvnNumber;
		//if (substr($a_data['sales_number'],3,3) == '315'){
			$jumLog = $go_db->GetOne("select count(*) from tbl_so_sales_logger where sales_number_to = ? and revision_number_to = ?", array($a_data['sales_number'],$rvnNumber));
			if ($jumLog == 1){
				$tempSlsNumber = $go_db->GetRow("select sales_number_from, revision_number_from from tbl_so_sales_logger where sales_number_to = ? and revision_number_to = ?",array($a_data['sales_number'],$rvnNumber));
				$esSlsNumber = $tempSlsNumber['sales_number_from'];
				$esRevNumber = $tempSlsNumber['revision_number_from'];
			}	
		//}
		
		// echo "hanif: ".$esSlsNumber."<pre>";
		// echo "hanif2: ".$esRevNumber."<pre>";
		
		$Snum = $a_data['sales_number'];
		$Rnum = $a_data['rev_number'];
		// if($esSlsNumber == "P10411101990" && $esRevNumber == "005"){
			// $a_data['esign'] = $go_db->GetRow("SELECT signature,'hanif'as userid, 'hanif'as  FROM tbl_so_asses_logger sl join adm_users aa on aa.userid = sl.userid WHERE sales_number=? AND revision_number=? ORDER BY number DESC limit 1", array($a_data['sales_number'],$a_data['rev_number']));
		// }else{

		// $a_data['esign'] = $go_db->GetRow("SELECT signature,sl.userid, aa.username FROM tbl_so_asses_logger sl join adm_users aa on aa.userid = sl.userid WHERE sales_number=? AND revision_number=? ORDER BY number DESC limit 1", array($Snum,$Rnum));

    $a_data['esign'] = $go_db->GetRow("SELECT signature,sl.userid, aa.username FROM tbl_so_asses_logger sl join adm_users aa on aa.userid = sl.userid WHERE sales_number=? AND case when substr(sales_number,4 ,3) in ('187','417') then revision_number ='000' else revision_number=? end ORDER BY number DESC limit 1", array($Snum,$Rnum));
		// }
		
		// print_r($a_data['esign']);
		
		$a_data['lifeInsurancePartnerCode'] = $go_db->GetOne(GETPHKPATNER, array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['apar_totals'] = $go_db->GetOne(SQL_APAR_TOTALS,  $apar_number);
		$a_data['apar_home_totals'] = $go_db->GetOne(SQL_APAR_HOME_TOTALS,  $apar_number);
		$a_data['apar_type']   = $apar_type;
		
		$a_data['lines']       = $go_db->GetAll(SQL_APAR_LINES,$apar_number);

		$aparAsd = $go_db->getOne("select apar_number from view_fn_apar_details_all where reference = '".$a_data['sales_number'].";".$a_data['rev_number']."' and transaction_type = 'Admin & stamp duty' and transaction_currency = '".$a_data['transaction_currency']."' limit 1");
		//echo $aparAsd;exit;
		if ($a_data['transaction_type'] == 'Insurance premium' or $a_data['transaction_type'] == 'Co-insurance in premium')
		$a_data['linesasd']       = $go_db->GetAll(SQL_APAR_LINES,array($aparAsd));
		
		$a_data['objects']     = $go_db->GetAll(SQL_APAR_OBJECTS,array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['instalments'] = $go_db->GetAll(SQL_APAR_INSTALMENTS, $apar_number);

		//WELCOME LETTER START
		echo "apar num ".$apar_number;
		$a_data['count_instalments'] = $go_db->GetOne(SQL_CHECK_INSTALMENTS, $apar_number);


		if($a_data['count_instalments'] <= 1){
			
					
			$a_data['is_instalments'] = 0;
			// get our instalments
				$startdate  = $a_data['insurance_period_from'];
				$calcmethod = $go_db->GetOne(SQL_GET_TOP_CALCMETHOD2, $a_data['term_of_payment_code_premium']);
				$a_periods  = $go_db->GetAll(SQL_GET_TOP_PERIODS2, $a_data['term_of_payment_code_premium']);
				$check_mv = $go_db->GetOne(SQL_CHECK_MV,$a_data['insurance_product_code']);
				//echo "waaaaa";printr($a_periods);
				foreach ($a_periods as $p) {
					$pay_period = $p['payment_period'];
		
					//$a_data['welcome_due_date'] = get_due_date($startdate, $calcmethod, $pay_period, $add_inception);
					if($check_mv > 0)
						$a_data['welcome_due_date'] = date("Y-m-d", strtotime($a_data['insurance_period_from'] . " +14 days"));
					else
						$a_data['welcome_due_date'] = date("Y-m-d", strtotime($a_data['insurance_period_from'] . " +30 days"));


				}
			
		}else{
			$a_data['is_instalments'] = 1;
			$a_data['welcome_due_date'] = $a_data['instalments'][0]['due_date'];

		}


		//welcome VA
		
		if($a_data['transaction_currency'] == "IDR"){
			$va_acc = $go_db->GetAll("SELECT * FROM tbl_so_sales_va WHERE sales_number = '".$a_data['sales_number']."' AND revision_number = '".$a_data['rev_number']."' and cur = 'IDR' and duplicate = 'f' ORDER BY bank_code");
		}else{
			$va_acc = $go_db->GetAll("SELECT * FROM tbl_so_sales_va WHERE sales_number = '".$a_data['sales_number']."' AND revision_number = '".$a_data['rev_number']."'  and duplicate = 'f'  ORDER BY bank_code,cur");
		}
		
		//printr($va_acc);
		
		$go_tpl->assign('va_acc',$va_acc);



		//WELCOME LETTER END		


		//VA PATCH START
		
		$marine_array = array("200","201","202","203","204","205");
		if(in_array($a_data['insurance_product_code'],$marine_aray))
			$a_data['is_marine'] = 1;
		else
			$a_data['is_marine'] = 0;

		
		// Virtual Account Patch
		// Show Virtual Account if intemediary Agent or Direct
		//if($go_user['attr']['userid'] == 'Ades'||$go_user['attr']['userid'] == 'ades')$go_db->debug=1;
		$a_data['virtual_account'] = $go_db->GetAll(GET_VIRTUAL_ACCOUNT, array($a_data['sales_number'],$a_data['rev_number']));
		$va_count = $go_db->GetRow(GET_VIRTUAL_ACCOUNT2, array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['va_count'] = $va_count['va_count'];
		$a_data['rek_val']=$go_db->GetAll(SQL_REKENING11,$a_data['back_office_code']);
		$a_data['rek_val_ho']=$go_db->GetAll(SQL_REKENING11,'12');
		$a_data['campaign'] = $go_db->GetAll(GET_CAMPAIGN_CODE, array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['kode_cabang'] = $go_db->GetOne(GET_KODE_CABANG, array($a_data['sales_number'],$a_data['rev_number']));
    $a_data['intermediary_type']=$go_db->GetOne(GET_INT_TYPE, array($a_data['sales_number'],$a_data['rev_number']));
    $a_data['intermediary_code']=$go_db->GetOne(GET_INT_CODE, array($a_data['sales_number'],$a_data['rev_number']));
    
  $a_data['info_bank'] = $go_db->GetAll(GET_BANK_ACCOUNT,array($a_data['sales_number'],$a_data['rev_number'],$a_data['sales_number'],$a_data['rev_number']));
   $a_data['checking_bank'] = $go_db->GetOne(GET_BANK_ACCOUNT_CHECK,array($a_data['sales_number'],$a_data['rev_number']));
	
		//if($a_data['is_agent'] == 't' && ($a_data['intermediary_type'] == 'AGENT'||$a_data['intermediary_type'] == '---'||$a_data['intermediary_type'] == 'INSTITUTIONAL AGENT') )                         
		//$a_data['is_agent'] == 't';


		//if($go_user['attr']['userid'] == 'ades'||$go_user['attr']['userid'] == 'miswanty')
		//printr($a_data);exit;
		//END VA

		/*--------Add By Piman for woori-------*/
		$params = $a_data['invoice_client_name'];
		/*----------------END-----------------*/
		
		
		/*********************Code For Additional Information On Invoice****************************/
		$a_data['faktur'] = $go_db->GetAll(SQL_FAKTUR,array($a_data['sales_number'],$a_data[rev_number]));
		$a_data['boffice'] = $go_db->GetAll(SQL_BACKOFFICE,$a_data['back_office_code']);
		//$go_db->debug=1;
		if ($bcoffcode == "70" or $bcoffcode == "50"){
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING2,$a_data['back_office_code']);
		} else if ($bcoffcode == "21" ) {
			if ($bcoffcode == "80") {$br = '%yogya%';} else if ($bcoffcode == "21") {$br = '%solo%';} //else {$br = '%purwokerto%';}
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING3,array($br)); 
		} else if ($bcoffcode == "19") {
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING,array('10'));
		} else if ($bcoffcode == "31") {
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING,array('12'));
		} else if ($bcoffcode == "14") {
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING,array('12'));
		} else if ($bcoffcode == "10"){
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING_JAKARTA,$a_data['back_office_code']);
		} else if ($bcoffcode == "15"){
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING_BSD,$a_data['back_office_code']);
		} else if ($bcoffcode == "32"){
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING,array('30'));

		} else {
			$a_data['rekening'] = $go_db->GetAll("SELECT cbcode,cbname,ccode,acode,bocode,norek FROM tbl_gl_cash_bank_accounts WHERE bocode=? and isvisible=true",$a_data['back_office_code']);
		}
		//$go_db->debug=1; 

		/*-------------------------------Add By Piman for Woori 13 Des 2017---------------------------*/	
		if ($params == "PT Bank Woori Saudara Indonesia 1906, Tbk" || $params =="PT Bank Woori Indonesia"){
			$a_data['rekening'] = $go_db->GetAll(SQL_REKENING_WOORI,$a_data['back_office_code']);

		}
		/*----------------------------------------------END--------------------------------------------*/
		
		
		// printr($a_data);exit;
		
		$a_data['tax']    = $go_db->GetAll(SQL_QUERY_TAX, Array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['pph']    = $go_db->GetAll(SQL_QUERY_PPH, Array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['p_code']    = $go_db->GetOne(SQL_QUERY_PRODUCT_CODE, Array($a_data['sales_number'],$a_data['rev_number']));
		$a_data['attr_code']    = $go_db->GetOne(SQL_QUERY_ATTR, Array($a_data['sales_number'],$a_data['rev_number']));

		//$go_db->debug=1;
		$a_data['ap_ref']= $go_db->GetAll(SQL_GET_AP_REFERENCE,$apar_number);
		// patch by vyan.. on Des 4, 2009
		// this patch is for counting AR Number if there are double AR Number
		$jml = $go_db->GetOne(SQL_COUNTING_AR_NUMBER,Array($a_data['reference'],$a_data['transaction_currency']));
		if ($jml > 1){
			$a_data['ar_number']= $go_db->GetAll(SQL_GET_AR_NUMBER2,Array($a_data['reference'],$a_data['transaction_currency'],$a_data['period_year'],$a_data['period_index']));
		} else {
			$a_data['ar_number']= $go_db->GetAll(SQL_GET_AR_NUMBER,Array($a_data['reference'],$a_data['transaction_currency']));
		}
		//$a_data['ar_number']= $go_db->GetAll(SQL_GET_AR_NUMBER,Array($a_data['reference'],$a_data['transaction_currency']));
		$a_data['ar_lines']= $go_db->GetAll(SQL_AR_LINES,$a_data['ar_number'][0]['apar_number']);
		// echo "arnum ".$a_data['ar_number'][0]['apar_number'];

		if($is_oknum["invoice_client_code"] == "Oknum" && substr($apar_number,0,2) == "AP")		
			$a_data['int_address']= $go_db->GetAll(SQL_QUERY_ADDRESS_OKNUM, Array($apar_number));
		else
			$a_data['int_address']= $go_db->GetAll(SQL_QUERY_ADDRESS, Array($a_data['invoice_client_code']));
		$a_data['reference_number']= $go_db->GetAll(SQL_REFERENCE_NUMBER, Array($a_data['sales_number'],$a_data['rev_number']));

define('TTL_APAR', <<<EOS
select sum(transaction_amount) from view_fn_apar_lines_all inner join view_fn_apar_details_all on view_fn_apar_details_all.apar_number=view_fn_apar_lines_all.apar_number 
where 
(view_fn_apar_lines_all.transaction_origin like '% AR'
or view_fn_apar_lines_all.transaction_origin like '% AP' 
or view_fn_apar_lines_all.transaction_origin = 'Account Receivable/Payable' 
or view_fn_apar_lines_all.transaction_origin like 'Advance receipt'
)
and view_fn_apar_details_all.apar_number= ?
EOS
);

//$go_db->debug = 1;
		$a_data['total_apar'] = $go_db->GetOne(TTL_APAR, Array($apar_number));
		$a_data['total_aparasd'] = $go_db->GetOne(TTL_APAR, array($aparAsd));
    $a_data['case_ar'] = $go_db->GetOne(SQL_AR_CASE, array($apar_number));

		if($go_user['attr']['userid'] == 'noyan' or $go_user['attr']['userid'] == 'vico' or $go_user['attr']['userid'] == 'deky' or $go_user['attr']['userid'] == 'ariskypratama')//printr($a_data);
		//$go_db->debug=0;
				$param=array();
		$param[]=$a_data['sales_number'];
		$param[]=$a_data['rev_number'];
		$a_data['leader'] = $go_db->GetAll(SQL_REFERENCE,$param);
		unset($param);
		
		//error_reporting(E_ALL);
		/***********************************End Code**********************************************/
		$business_partner = '';

if($go_user['attr']['userid'] == 'noyan' or $go_user['attr']['userid'] == 'ades' or $go_user['attr']['userid'] == 'Ades' or $go_user['attr']['userid'] == 'ariskypratama')//printr($a_data);

//--------------
		if($a_data['rev_number'] >= 1){
			$business_partner = 'Repeat business';	
		} else {
			$val = $go_db->GetOne(SQL_SALES_COUNT, $a_data['invoice_client_code']);
			if($val == 1){
				$business_partner = 'New customer';
			} else {
//				$val_per_product = $go_db->GetOne(SQL_PRODUCT_COUNT, array($a_data['sales_number'], $a_data['invoice_client_code']));
//				if($val_per_product == 1)
					$business_partner = 'New business';
			}
		}
//--------------

		$a_data['business_status'] = $business_partner; 
		if($go_user['attr']['userid'] == 'ades' or $go_user['attr']['userid'] == 'Ades'  or $go_user['attr']['userid'] == 'vico' or $go_user['attr']['userid'] == 'noyan' or $go_user['attr']['userid'] == 'ariskypratama') //printr($a_data);

		//digital signature image link
		$ismorethanone = $go_db->GetOne("select count(*) from tbl_so_sales_details where sales_number = ? and revision_number::int = (?::int-1) and sales_status = 'Master JP'",array($a_data['sales_number'],$a_data['rev_number']));
		$rev_num = $a_data['rev_number'];
		if ($ismorethanone == 1)
			$rev_num = $go_db->GetOne("select revision_number from tbl_so_sales_details where sales_number = ? and revision_number::int = (?::int-1) and sales_status = 'Master JP'",array($a_data['sales_number'],$a_data['rev_number'])); 

		// $location = "'https://nextg.asuransibintang.com/nextg_v2/index.php?module=Policy&action=ReprintPostAssessPolicy&status=2&reprint=2&flag=yes&sales_number=".$a_data['sales_number']."&rev_number=".$rev_num."&sales_type=Policy'";
		$salt = "Vmn34aAciYK00Hen26nT01";
		$location = "https://nextg.asuransibintang.com/p/?".sha1($sales_number.$salt.$revision_number);
		
    	//generate digital signature image
   	 	QRcode::png($location, 'images/esign/esign-'.$a_data['sales_number'].$rev_num.'.png', 'L', 4, 2);
		
		$QRLink = "http://nextg.asuransibintang.com/nextg_v2/images/esign/esign-".$a_data['sales_number'].$rev_num.".png";
		// $QRLink = "http://staging.asuransibintang.com/nextg_v2/images/esign/esign-".$a_data['sales_number'].$rev_num.".png";
		$go_tpl->assign_by_ref('qr_link',$QRLink);		
		
		if($go_user['attr']['userid']=='rachman.lubis'){
			$go_db->debug=1;
			error_reporting(E_ALL);
			echo "<br>".$QRLink; 
			//echo "alert();";
		}
		//printr($a_data);exit;
		
		// << vtr for sppa all
		$a_bind2 = array($a_data['sales_number'], $a_data['rev_number']);
		$kode_produk_all  =& $go_db->GetOne(KODE_PRODUK_ALL, $a_bind2);
		if ($kode_produk_all=='399') {
			$a_data = $go_db->GetRow(SQL_QUERY_DETAILS, $a_bind2);
			$sn = $a_data['sales_number'];
			$a_data['objects']     = $go_db->GetAll(SQL_QUERY_OBJECTS_OJK, array($sn));
			$a_data['perluasan']   = $go_db->GetAll(get_perluasan, array($sn));				
			$a_data['kode_produk'] = $kode_produk_all;	
			$a_data['esign'] = $go_db->GetRow("SELECT signature,sl.userid, aa.username FROM tbl_so_asses_logger sl join adm_users aa on aa.userid = sl.userid WHERE sales_number=? AND revision_number=? ORDER BY number DESC limit 1", $a_bind2);
			$a_data['cek_esign']=$go_db->GetRow("SELECT esign, estamp, product_alias_code FROM tbl_so_sales_details WHERE sales_number=? AND revision_number=? ", $a_bind2);
		}
		// vtr >>
		
		$a_bind4 = array($a_data['sales_number'], $a_data['rev_number'], $a_data['sales_number'], $a_data['rev_number']);
		$kode_gvgp = $go_db->GetOne(GET_PRODUCT_GVGP, $a_bind4);
		
		// finpay integration By RR 21062017
		$finpayParam = $a_data['sales_number'].$a_data['rev_number'];
		$a_data['finpay_paymentcode'] = $go_db->GetOne("select payment_code from tbl_finpay_api_status 
														WHERE result_code = '04' AND 
															  result_desc = 'Unpaid' AND 
															  log_no = '---' AND
															  payment_source = '---' AND
															  invoice = ?", array($finpayParam));
		
		// finpay integration By RR 25072017
		$a_data['finpay_expired_date'] = $go_db->GetOne("select request_date + total_expired_day::int AS expired_date from
														(select invoice, payment_code, date(a.timestamp) AS request_date, (b.timeout/2)/(60*24) AS total_expired_day
														from tbl_finpay_api_tracker a join tbl_finpay_api_status b USING (invoice, payment_code) 
														WHERE a.result_code = '88' AND invoice = ?) w", array($finpayParam));

		// printr($a_data);
		// $a_data['insurance_period_to'] = date("d-F-Y", strtotime($a_data['insurance_period_to'])); 
		echo "disini ".$a_data['insurance_period_to']."<br>";

		$go_tpl->assign_by_ref('gvgp', $kode_gvgp);
		$go_tpl->assign_by_ref('tpl_inv', $a_data);
		$go_tpl->assign_by_ref('departmentName', $go_user["attr"]["departmentName"]);

    $logo = $_GET['requester'];
    $go_tpl->assign_by_ref('logo', $logo);
		
		//KID 29 Juli 2016
		$cimb_inter = $go_db->GetOne(GETINTERM, array($a_data['sales_number'], $a_data['rev_number']));
		//KID
		$go_tpl->assign_by_ref('cimb_inter', $cimb_inter);
		
		if($_SESSION["s_type_invoice"] == "internal"){
			$strTemplateHTML = $go_tpl->fetch('reports/accounting/apar_manual_inv_internal.tpl');
		}else{
			$strTemplateHTML = $go_tpl->fetch('reports/accounting/apar_manual_inv2.tpl');
		}
		
		// <<vtr for sppa all
		if ($kode_produk_all=='399') {
			$strTemplateHTML = $go_tpl->fetch('reports/accounting/apar_JP_all.tpl');
		}
		// vtr>>
		
		$report_filename = 'apar-'.$apar_number;

		if (!write_report_template($report_filename, $strTemplateHTML)) {
			return false;
		}
		//echo "super pancen OYEEE";
		if($go_user['attr']['userid'] == 'rachman.lubis') $go_db->debug=1;
    echo "disini ".$strTemplateHTML;
			// exit;
		generate_report($report_filename, 'accounting');
		
		// start add by Rachmat Rizkihadi - finpay method 25072017
			if (!empty($a_data['finpay_paymentcode']) OR $a_data['finpay_paymentcode'] != '') {
				$dir_finpay = "/var/www/html/nextg_v2";
				exec("pdftk  ".$dir_finpay."/reports/accounting/".$report_filename.".pdf ".$dir_finpay."/images/finpay-guide/finpay.payment-guide.pdf output ".$dir_finpay."/reports/accounting/".$report_filename."-new.pdf");
			}
		// end
		
		return true;
	}


function get_due_date($sdate, $cmethod, $period, $inception)
{

	
	$s_datefmt = 'Y-m-d';
	$a_date   = explode("-", $sdate); // 0=year, 1= month, 2=day
	$y = $a_date[0]; $m = $a_date['1']; $d = $a_date['2'];

    //check wheter posting date is less than start date or after start date
    //in case posting date is older than start date then the date used is the insurance period from 
    //otherwise due date will be count based on posting date (current date)
	// current date (posting date) - start date     dei was moved this logic to salels integration
//        $who_is_older = mktime(0,0,0, date('m'), date('d'), date('Y')) - mktime(0,0,0, $m, $d, $y);
//        if($who_is_older > 0){ $y = date('Y');  $m = date('m'); $d = date('d'); } 

	$due_date = $sdate;

	if (stristr($cmethod, 'day')) {
		//$due_date = date($s_datefmt, mktime(0,0,0, $m, $d+$period, $y));
		$due_date = date($s_datefmt, mktime(0,0,0, $m, $d+inception, $y));

	} else if (stristr($cmethod, 'month')) {
		if (stristr($cmethod, 'beginning')) {
			// unlikely, but we handled anyway
			$due_date = date($s_datefmt, mktime(0,0,0, $m+$period, 1, $y));
		} else if (stristr($cmethod, 'end')) {
			$due_date = date($s_datefmt, mktime(0,0,0, $m+$period+1, (1-1), $y));
		}
	} else if (stristr($cmethod, 'quarter')) {
		$period *= 3;
		if (stristr($cmethod, 'beginning')) {
			$due_date = date($s_datefmt, mktime(0,0,0, $m+$period, 1, $y));
		} else if (stristr($cmethod, 'end')) {
			$due_date = date($s_datefmt, mktime(0,0,0, $m+$period+3, (1-1), $y));
		}
	}

	return $due_date;
}



?>

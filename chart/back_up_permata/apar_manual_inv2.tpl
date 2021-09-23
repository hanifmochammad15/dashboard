<!-- MEDIA TOP 40mm -->
<!-- MEDIA BOTTOM 20mm -->
<!-- MEDIA RIGHT 25mm -->
<!-- MEDIA LEFT 25mm -->
{assign var="total_setelah_discount" value=0}
{assign var="manual_AP" value=0}

{assign var="hrlines" value="_______________________________"}
<html>
<body>

{if $logo  eq 'true'}
<table width="120%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td align=left colspan=2><img src="../../../../images/bintang_logo.gif">
    </td>
  </tr>
</table> 
{/if}

{*Welcome Letter Sections Start*}
{if $tpl_inv.is_agent eq "t" and $tpl_inv.is_instalments eq "0"}
    {*include file="reports/accounting/welcome_letter.tpl*} 
{/if}
{*Welcome Letter Sections Finish*}

<table border="0" width="100%" cellpadding="0" cellspacing="0">

<!-- header of the invoice starts here --> 
{if $tpl_inv.sales_number eq "P14121100178" or $tpl_inv.sales_number eq "P13307100119" or $tpl_inv.sales_number eq "P12123100075" or $tpl_inv.sales_number eq "P14104100018"
or $tpl_inv.sales_number eq "P13115100528" or $tpl_inv.sales_number eq "P13301101084" or $tpl_inv.sales_number eq "P31301100180" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P13101100381" or $tpl_inv.sales_number eq "P13411100419"}

{else}

{*}<tr><td>&nbsp;</td></tr>{*}
<!-- <tr><td align=left colspan=2><img src="../../../../images/bintang_logo.gif"> --> <!-- clo -->
<tr><td colspan=2><font size="1"><b>PT. Asuransi Bintang Tbk.</b></font>
<tr><td colspan=2><font size="1">Cabang {$tpl_inv.boffice.0.name}</font>
<tr><td colspan=2><font size="1">{$tpl_inv.boffice.0.address}</font>
{if $tpl_inv.userid eq 'ades'}
{if $tpl_inv.intermediary_type neq '---' and $tpl_inv.intermediary_type neq 'AGENT'}
<tr><td colspan=2><font size="1">Phone: {$tpl_inv.boffice.0.telephone}  Fax: {$tpl_inv.boffice.0.fax}</font>
<tr><td colspan=2><font size="1">Email: {$tpl_inv.boffice.0.email}</font>
{/if}
{/if}
{/if}


<tr><td colspan="2">&nbsp;
<tr><th colspan="2">
<h3>{foreach from=$tpl_inv.campaign item=camp}{assign var=camp value=$camp}{/foreach}{if $camp.campaign_code eq "MC0000026"}{$tpl_inv.transaction_type|replace:"Insurance commission reseller":"Insurance commission"}{else}{$tpl_inv.transaction_type|replace:"oknum":"agent"}{/if} invoice</h3>
<h4>{$tpl_inv.journal_entry} - {$tpl_inv.apar_number}</h4>
</table>					{if $tpl_inv.sales_number eq "P50115100726" or $tpl_inv.sales_number eq "P14104100019"  or $tpl_inv.sales_number eq "P14104100018" or $tpl_inv.sales_number eq "P14115100072" or $tpl_inv.sales_number eq "P14121100133" or $tpl_inv.sales_number eq "P31301100180" or $tpl_inv.sales_number eq "P31411100053" or $tpl_inv.sales_number eq "P31411100045" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P13101100381" or $tpl_inv.sales_number eq "P13411100419"}{else}
<br>						{/if}
<font size="2">
<!-- the invoice addresses and references -->
{if $tpl_inv.apar_type eq 'AP'}
{$tpl_inv.business_status}
{if $tpl_inv.is_agent neq "t"  }
<!--<div align="right"><font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code}({$tpl_inv.payment_client_name - {$tpl_inv.payment_client_code}){elseif $tpl_inv.transaction_type eq "Insurance commission agent"} ({$tpl_inv.payment_client_code}) {/if}</b></font></div>-->
<!--<div align="right"><font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code}AO : {$tpl_inv.sales_person|capitalize} {/if} </b></font></div><br />-->
{else}
<br/>
{/if}
<table border="1" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td valign="top" width="57%">
{* ---------------- Client Details BOX ---------------- *}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td colspan="3">To:.
<tr><th colspan="3" align="left"><u>
{if $tpl_inv.invoice_client_code eq "Oknum"}
 {foreach from=$tpl_inv.int_address item=aa}
   {if $aa.name eq $tpl_inv.invoice_client_name}
	{$aa.name|nl2br}
   {/if}
 {/foreach}
{else}
{$tpl_inv.int_address.0.name|nl2br}
{/if}
</u>
<tr><td width="15%">Alamat<td width="3%">:<td align="left" valign="top" width="82%">{$tpl_inv.int_address.0.street_address|nl2br|default:"-"}
<tr><td>Telephone / Hp<td>:<td align="left" valign="top">{$tpl_inv.int_address.0.telephone_fixed|default:"-"} / {$tpl_inv.int_address.0.telephone_mobile|default:"-"}
<tr><td>Fax<td>:<td align="left" valign="top">{$tpl_inv.int_address.0.facsimile|default:"-"}
<tr><td>Email<td>:<td align="left" valign="top">{$tpl_inv.int_address.0.email|default:"-"}
</table>


{else}

{$tpl_inv.business_status}
{if $tpl_inv.is_agent neq "t" and $tpl_inv.intermediary_type neq 'AGENT'}
<div align="right">
  <font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code} ({$tpl_inv.payment_client_name} - {$tpl_inv.payment_client_code}) {else} ({$tpl_inv.payment_client_name} - {$tpl_inv.payment_client_code}) {/if}</b>
<div align="right"><font size="1"><b>{* if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code *}AO : {$tpl_inv.sales_person|capitalize} {* /if *}</b></font></div><br />
    {if !empty($tpl_inv.reference_number.0.attribute_value)}
    {if $tpl_inv.product_code eq "201" or $tpl_inv.product_code eq "205"}
	<b>- ({$tpl_inv.reference_number.0.attribute_value})</b>
    {/if}
    {/if}
  </font>
</div>
{/if}
<table border="1" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td valign="top" width="57%">
{* ---------------- Client Details BOX ---------------- *}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td colspan="3">
To':<br>																			{if $tpl_inv.sales_number eq "P14306100005"}<b><u>Dana Unico Finance</u></b><tr><td colspan="3">Gedung Danapaint Lt. 2, Jl. Pemuda Jakarta Timur. <br>Dki Jakarta. <br>INDONESIA. <tr valign="top"><td>Nama Tertanggung<td>:&nbsp;<td>Dana Unico Finance{else}
{if $tpl_inv.insurance_product_code eq "436" and $tpl_inv.wording_code eq "PASOPATI"}
<b><u>PT. Pasopati Guardian</u></b>
{else}
<b><u>{$tpl_inv.invoice_client_name} </u></b>
{/if}
<tr><td colspan="3">
{if $tpl_inv.insurance_product_code eq "436" and $tpl_inv.wording_code eq "PASOPATI"}
Istana Pasteur Regency CBR 97<br />
Jl. Sukaraja, Gunung Batu &ndash; Pasteur<br />
Bandung
{else}
{$tpl_inv.client_address|nl2br}
{/if}
<tr valign="top"><td>Nama Tertanggung.<td>:&nbsp;
{if $tpl_inv.is_cnaf eq "t"}
	<td>{$tpl_inv.cconame} 			 
 {else}
	<td>{$tpl_inv.cconame} {$tpl_inv.ccbname}									{/if}
{/if}
<tr><td>Telephone / Hp<td>:&nbsp;<td>{$tpl_inv.int_address.0.telephone_fixed|default:"-"} / {$tpl_inv.int_address.0.telephone_mobile|default:"-"}
<tr><td>Fax<td>:&nbsp;<td>{$tpl_inv.client_fax|default:"-"}
<tr><td>Email<td>:&nbsp;<td>{$tpl_inv.client_email|default:"-"}
</table>
{/if}

<td valign="top" width="43%">
{* ---------------- Reference Details BOX ---------------- *}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td colspan="2">
{* <b>{$tpl_inv.prd_name|default:$tpl_inv.mapar_type}</b> *}
<br>
{* ({$tpl_inv.product_group}) *}
<br>&nbsp;<br>
{if $tpl_inv.inv_type eq 'manual' }
<tr><td colspan="2">
Reference:<br>
{$tpl_inv.reference}
{elseif $tpl_inv.inv_type eq 'premium'}
<tr><td>Policy number:<td>{$tpl_inv.sales_number}
<tr><td>Revision number:<td>{$tpl_inv.rev_number}
<tr><td>Period from:<td>{$tpl_inv.insurance_period_from|date_format:"%d-%B-%Y"}
<tr><td>Period to:<td>
{if $tpl_inv.sales_number eq "P15199100136"}31-July-2038
{elseif $tpl_inv.sales_number eq "P15199100148"}26-July-2038
{elseif $tpl_inv.sales_number eq "P15199100149"}30-July-2043
{elseif $tpl_inv.sales_number eq "P15199100182"}16-August-2038
{elseif $tpl_inv.sales_number eq "P15199100183"}16-August-2038
{elseif $tpl_inv.sales_number eq "P15199100185"}16-August-2038
{elseif $tpl_inv.sales_number eq "P15199100207"}30-August-2039
{else}{$tpl_inv.insurance_period_to2}
{*}{$tpl_inv.insurance_period_to|date_format:"%d-%B-%Y"}{*}
{/if}
<tr><td>Total Sum Insured:
{assign var="flag" value="true"}
{foreach from=$tpl_inv.objects item=o name=objects}
{if $o.currency_code eq $tpl_inv.transaction_currency}
 	{if $flag eq "true"}
		{assign var="sum_insured" value=$o.declared_value}
		{assign var="flag" value="false"}
	{else}
		{assign var="sum_insured" value=$sum_insured+$o.declared_value}
	{/if}
{/if}
{/foreach}
<td>{$sum_insured|number_format:"2"}



{elseif $tpl_inv.inv_type eq 'marine' }
{elseif $tpl_inv.inv_type eq 'excess' }
{/if}
</table>
</td>
</tr>
</table>

<table>
<tr><td>Policy number of leader<td>:<td>{$tpl_inv.leader.0.leader_number|default:"-"}
{if $tpl_inv.campaign_code eq 'MC0000010'}
<tr><td>Reference No.<td>:<td>{$tpl_inv.attr_code|default:"-"}
{else}
<tr><td>Reference No.<td>:<td>{$tpl_inv.leader.0.reference_number|default:"-"}
{/if}
</table>

<!-- the Accounts -->
<table border="1" width="100%">
<tr bgcolor="#dedede"><th width="57%">&nbsp;<th width="43%">Amount ({$tpl_inv.transaction_currency}) <!-- <th>Home Amount ({$tpl_inv.home_currency}) -->
{assign var="wTax" value="false"}

{assign var="preprinted" value="true"}
{foreach from=$tpl_inv.lines item=l name=invlines}
{if $l.transaction_origin eq 'Account Receivable/Payable'}
	{if $tpl_inv.apar_type eq 'AR'}
		{assign var="tr_orig" value="Account Receivable"}
	{else}
		{assign var="tr_orig" value="Account Payable"}
	{/if}
{/if}

{* Check whether AP or AR *}

{if $tpl_inv.apar_type eq 'AR'}

{if $preprinted eq "true"}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.transaction_origin eq "Premium revenue"}	
	{if $printed eq "true"}
		<tr><td>
		Insurance Premium<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total_setelah_discount" value=$total_setelah_discount+$l.transaction_amount}
		{assign var="total" value=$total+$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}	

	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.transaction_origin eq "Premium discount"}	
	{if $printed eq "true"}
		<tr><td>
		Discount<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total_setelah_discount" value=$total_setelah_discount-$l.transaction_amount}
		{assign var="total" value=$total-$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}

	{assign var="printed" value="true"}{assign var="polcost" value=0}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.transaction_origin eq "Admin revenue"}	
	{if $printed eq "true"}
		<tr><td>
		Policy Cost<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total" value=$total+$l.transaction_amount}{assign var="polcost" value=$polcost+$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}	

	{if $polcost eq 0}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.linesasd item=l name=invlines}
	{if $l.transaction_origin eq "Admin revenue"}	
	{if $printed eq "true"}
		<tr><td>
		Policy Cost<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total" value=$total+$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}
	{/if}		

	{assign var="printed" value="true"}{assign var="stampcost" value=0}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.transaction_origin eq "Stamp inventory"}	
	{if $printed eq "true"}
		<tr><td>
		Stamp Duty<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total" value=$total+$l.transaction_amount}{assign var="stampcost" value=$stampcost+$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}
	
	{if $stampcost eq 0}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.linesasd item=l name=invlines}
	{if $l.transaction_origin eq "Stamp inventory"}	
	{if $printed eq "true"}
		<tr><td>
		Stamp Duty<td align="right">{$l.transaction_amount|number_format:"2"}  
		{assign var="total" value=$total+$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}
	{/if}
	
     {assign var="printed" value="true"}
  	 {foreach from=$tpl_inv.lines item=l name=invlines}
  	    {if $l.transaction_origin eq "Account Receivable/Payable"}
  	      {if $printed eq "true"}
  	           <tr><td>
  	           Account Receiveable<td align="right">{$l.transaction_amount|number_format:"2"}
  	           {assign var="total" value=$total+$l.transaction_amount}
  	           {assign var="printed" value="false"}
  	      {/if}
  	     {/if}
  	 {/foreach}

{assign var="preprinted" value="false"}
{/if}

{else}
{assign var="tax" value=0}
{assign var="pph" value=0}
{assign var="total" value=0}

{if $preprinted eq "true"}
 {assign var="printed" value="true"}
  {foreach from=$tpl_inv.lines item=l name=invlines}
     {if $l.transaction_origin eq "Account Receivable/Payable"}
      {if $printed eq "true"}
          <tr><td>
            Account Payable<td align="right">{$l.transaction_amount|number_format:"2"}
			{assign var="manual_AP" value=$manual_AP+$l.transaction_amount}
            {assign var="total" value=$total+$l.transaction_amount}
            {assign var="printed" value="false"}
      {/if}
     {/if}
  {/foreach}

 {if $tpl_inv.leader_fee eq 0}
  {if $tpl_inv.revision_flag eq "C"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	  {if $l.transaction_origin eq "Commission expense"}
		{assign var="commission" value=$l.transaction_amount}
		<tr><td>Commission <td align="right">{$l.transaction_amount|number_format:"2"}  
	  {/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{assign var="pph" value=$tpl_inv.pph.0.percentage*$commission/100}

	{if !empty($tpl_inv.tax.0.percentage)}
		{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$commission+$tax-$pph|number_format:"2"|default:"0.00"}

  {elseif  $tpl_inv.invoice_client_code eq "Oknum"}
	{assign var="commission" value=$tpl_inv.lines.0.transaction_amount}	
	<tr><td>Commission <td align="right">{$tpl_inv.lines.0.transaction_amount|number_format:"2"}

	<tr><td><b>Total</b><td align="right">{$commission|number_format:"2"|default:"0.00"}

  {else}{*case PRS *}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.origin eq "Commission expense"}	
	{if $printed eq "true"}
	
		<tr><td>
		{assign var="reverse_tax" value=$tpl_inv.tax.0.percentage/100}
		{assign var="reverse_tax" value=$reverse_tax+1}		
		{assign var="commission" value=$l.transaction_amount/$reverse_tax}
		{if $tpl_inv.own_share neq "100"}
		  Commission (own share {$tpl_inv.own_share}%)<td align="right">{$commission|number_format:"2"}  
		{else}		  
		  Commission <td align="right">{$commission|number_format:"2"}  
		{/if}
		{assign var="total" value=$l.transaction_amount}
		{assign var="printed" value="false"}
		{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{/if}	
	{/if}
	{if $l.origin eq "Withholding income tax payable"}
		{assign var="pph" value=$l.transaction_amount}
	{/if}
	{if $l.origin eq "Commission AP"}
		{assign var="total" value=$l.transaction_amount}
	{/if}
	{/foreach}

	
	
	{if !empty($tpl_inv.tax.0.percentage)}
	   {* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}
<!-- vico -->
	<tr><td><b>Total</b><td align="right">{$total|number_format:"2"|default:"0.00"}{*$manual_AP+$commission+$tax-$pph|number_format:"2"|default:"0.00"*}

  {/if}
{elseif $tpl_inv.leader_fee gt 0 and $tpl_inv.transaction_type eq "Insurance commission broker"}
   {if $tpl_inv.revision_flag eq "C"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	  {if $l.transaction_origin eq "Commission expense"}
		{assign var="commission" value=$l.transaction_amount}
		<tr><td>Commission <td align="right">{$l.transaction_amount|number_format:"2"}  
	  {/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{assign var="pph" value=$tpl_inv.pph.0.percentage*$commission/100}

	{if !empty($tpl_inv.tax.0.percentage)}
	   {* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$commission+$tax-$pph|number_format:"2"|default:"0.00"}

  {elseif  $tpl_inv.invoice_client_code eq "Oknum"}
	{assign var="commission" value=$tpl_inv.int_address.0.commission_amount}	
	<tr><td>Commission <td align="right">{$tpl_inv.int_address.0.commission_amount|number_format:"2"}
	<tr><td><b>Total5</b><td align="right">{$commission|number_format:"2"|default:"0.00"}

  {else}	
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.origin eq "Commission expense"}	
	{if $printed eq "true"}
		<tr><td>
		{assign var="reverse_tax" value=$tpl_inv.tax.0.percentage/100}
		{assign var="reverse_tax" value=$reverse_tax+1}
		{assign var="commission" value=$l.transaction_amount/$reverse_tax}
		{if $tpl_inv.own_share neq "100"}		  
		  Commission (own share {$tpl_inv.own_share}%)<td align="right">{$commission|number_format:"2"}  
		{else}
		  Commission <td align="right">{$commission|number_format:"2"}  
		{/if}
		{assign var="total" value=$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}
	{/if}
	{if $l.origin eq "Withholding income tax payable"}
		{assign var="pph" value=$l.transaction_amount}
	{/if}
	{if $l.origin eq "Commission AP"}
		{assign var="total" value=$l.transaction_amount}
	{/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}

	{if !empty($tpl_inv.tax.0.percentage)}
	 {* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$total|number_format:"2"|default:"0.00"}{*$manual_AP+$commission+$tax-$pph|number_format:"2"|default:"0.00"*}

  {/if}
{elseif $tpl_inv.leader_fee gt 0 and $tpl_inv.transaction_type eq "Insurance commission agent"}

<!-- vico -->
  {if $tpl_inv.revision_flag eq "C"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	  {if $l.transaction_origin eq "Commission expense"}
		{assign var="commission" value=$l.transaction_amount}
		<tr><td>Commission <td align="right">{$l.transaction_amount|number_format:"2"}  
	  {/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{assign var="pph" value=$tpl_inv.pph.0.percentage*$commission/100}

	{if !empty($tpl_inv.tax.0.percentage)}
{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$commission+$tax-$pph|number_format:"2"|default:"0.00"}

  {elseif  $tpl_inv.invoice_client_code eq "Oknum"}
	{assign var="commission" value=$tpl_inv.int_address.0.commission_amount}	
	<tr><td>Commission <td align="right">{$tpl_inv.int_address.0.commission_amount|number_format:"2"}  

	<tr><td><b>Total</b><td align="right">{$commission|number_format:"2"|default:"0.00"}

  {else}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.origin eq "Commission expense"}	
	{if $printed eq "true"}
		<tr><td>
		{assign var="reverse_tax" value=$tpl_inv.tax.0.percentage/100}
		{assign var="reverse_tax" value=$reverse_tax+1}
		{assign var="commission" value=$l.transaction_amount/$reverse_tax}
		{if $tpl_inv.own_share neq "100"}
		  Commission (own share {$tpl_inv.own_share}%)<td align="right">{$commission|number_format:"2"}  
		{else}
		  Commission <td align="right">{$commission|number_format:"2"}  
		{/if}
		{assign var="total" value=$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}	
	{/if}
	{if $l.origin eq "Withholding income tax payable"}
		{assign var="pph" value=$l.transaction_amount}
	{/if}
	{if $l.origin eq "Commission AP"}
		{assign var="total" value=$l.transaction_amount}
	{/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	
	{if !empty($tpl_inv.tax.0.percentage)}
	{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$total|number_format:"2"|default:"0.00"}{*$manual_AP+$commission+$tax-$pph|number_format:"2"|default:"0.00"*}

  {/if}
{elseif $tpl_inv.leader_fee gt 0 and $tpl_inv.transaction_type eq "Insurance commission reseller"}    
    {if $tpl_inv.revision_flag eq "C"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	  {if $l.transaction_origin eq "Commission expense"}
		{assign var="commission" value=$l.transaction_amount}
		<tr><td>Commission <td align="right">{$l.transaction_amount|number_format:"2"}  
	  {/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{assign var="pph" value=$tpl_inv.pph.0.percentage*$commission/100}

	{if !empty($tpl_inv.tax.0.percentage)}
	{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$commission+$tax-$pph|number_format:"2"|default:"0.00"}

  {elseif  $tpl_inv.invoice_client_code eq "Oknum"}
	{assign var="commission" value=$tpl_inv.int_address.0.commission_amount}	
	<tr><td>Commission <td align="right">{$tpl_inv.int_address.0.commission_amount|number_format:"2"}  

	<tr><td><b>Total</b><td align="right">{$commission|number_format:"2"|default:"0.00"}

  {else}
	{assign var="printed" value="true"}
	{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.origin eq "Commission expense"}	
	{if $printed eq "true"}
		<tr><td>
		{assign var="reverse_tax" value=$tpl_inv.tax.0.percentage/100}
		{assign var="reverse_tax" value=$reverse_tax+1}
		{assign var="commission" value=$l.transaction_amount/$reverse_tax}
		{if $tpl_inv.own_share neq "100"}
		  Commission (own share {$tpl_inv.own_share}%)<td align="right">{$commission|number_format:"2"}  
		{else}
		  Commission <td align="right">{$commission|number_format:"2"}  
		{/if}
		{assign var="total" value=$l.transaction_amount}
		{assign var="printed" value="false"}
	{/if}	
	{/if}
	{if $l.origin eq "Withholding income tax payable"}
		{assign var="pph" value=$l.transaction_amount}
	{/if}
	{if $l.origin eq "Commission AP"}
		{assign var="total" value=$l.transaction_amount}
	{/if}
	{/foreach}

	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	
	{if !empty($tpl_inv.tax.0.percentage)}
	{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	<tr><td><b>Total</b><td align="right">{$total|number_format:"2"|default:"0.00"}{*$manual_AP+$commission+$tax-$pph|number_format:"2"|default:"0.00"*}

  {/if}

{elseif $tpl_inv.leader_fee gt 0 and $tpl_inv.transaction_type eq "Co-insurance in commission broker"}
	{foreach from=$tpl_inv.ar_lines item=rl name=invarlines}
	{if $rl.origin eq "Premium AR"}
	{assign var="commission" value=$rl.transaction_amount*$tpl_inv.commission/100}
		<tr>
		  <td>Commision Broker <td align="right">{$commission|number_format:"2"}
	{/if}
	{/foreach}
	
	{assign var="tax" value=$commission*$tpl_inv.tax.0.percentage/100}
	{assign var="pph" value=$tpl_inv.pph.0.percentage*$commission/100}

	{if !empty($tpl_inv.tax.0.percentage)}
	{* add by Hadi 29 Juli 2016 *}
		         {if $tpl_inv.apar_type eq 'AP'}
		            {if ($cimb_inter)}
		                <tr>
		             <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}PPN {/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		            {else}
		                <tr>
		                <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		             {/if}
				{else}
					<tr>
					  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
					  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		         {/if}
		        
	    {*} 
		<tr>
		  <td>{if $tpl_inv.product_code eq "120"}PPH 23{else}Sales Tax{/if} ({$tpl_inv.tax.0.percentage|default:"0.00"} %)
		  <td align="right">{$tax|number_format:"2"|default:"0.00"}
		{*}
		 {* end add by Hadi 29 Juli 2016 *}
	{/if}
	{if !empty($tpl_inv.pph.0.percentage)}
		<tr>
  		  <td>PPH 23 ({$tpl_inv.pph.0.percentage|default:"0.00"} %)
 		  <td align="right">{$pph|number_format:"2"|default:"0.00"}
	{/if}

	
	<tr><td><b>Total</b><td align="right">{$commission+$tax-$pph|number_format:"2"|default:"0.00"}  

{else}
   {if $preprinted eq "true"}
       {assign var="printed" value="true"} 
    {foreach from=$tpl_inv.lines item=l name=invlines}
	{*if $l.origin eq "Premium revenue"*}
	{if $l.origin eq "Commission expense"}	
	{if $printed eq "true"}
		<tr>
		  <td>Leader Fee <td align="right">{$l.transaction_amount|number_format:"2"}{*$l.transaction_amount*$tpl_inv.leader_fee/100|number_format:"2"*}  
		  {*assign var="total" value=$l.transaction_amount*$tpl_inv.leader_fee/100*}
		  {assign var="total" value=$l.transaction_amount}
		  {assign var="printed" value="false"}
	{/if}
	{/if}
	{/foreach}
	<tr><td><b>Total</b><td align="right">{$total|number_format:"2"|default:"0.00"}
   {/if}
{/if} <!-- end leader fee check -->

{assign var="preprinted" value="false"}
{/if}
{/if}

{/foreach}
<!-- asd -->
	{if $tpl_inv.apar_type eq 'AR'}
	<tr><td><b>Total </b><td align="right">
		{if $stampcost eq 0 and ($tpl_inv.transaction_type eq 'Insurance premium' or $tpl_inv.transaction_type eq 'Co-insurance in premium')}
						{if $tpl_inv.sales_number eq "P13202100831"}16.32{else}
							{if $tpl_inv.sales_number eq "P30101012706" and $tpl_inv.rev_number eq "025" or $tpl_inv.sales_number eq "P30101012707" and $tpl_inv.rev_number eq "024"}
								{assign var="tot_indo3" value=$tpl_inv.total_apar+$tpl_inv.total_aparasd}
								{assign var="tot_indo4" value=$tot_indo3-$tpl_inv.case_ar}
									{$tot_indo4|number_format:"2"}
							{else}
								{$tpl_inv.total_apar+$tpl_inv.total_aparasd|number_format:"2"}
							{/if}
						{/if}
						{assign var="tot_indo" value=$tpl_inv.total_apar+$tpl_inv.total_aparasd}
		{else}{$tpl_inv.total_apar|number_format:"2"}{assign var="tot_indo" value=$tpl_inv.total_apar}
		{/if}{assign var="total" value=""}<!--{$tpl_inv.apar_totals|number_format:"2"}--> <!-- <td align="right">{$tpl_inv.apar_home_totals|number_format:"2"} -->
	{/if}		
</table>
</font>

<font size="2">
<table border="0" width="100%">
{assign var="i" value="0"}
{assign var="same" value=""}
{assign var="instalment_exist" value=0}

<!-- used to check instalment exist or not -->
{foreach from=$tpl_inv.instalments item=v name=invinst}
{if $same neq $v.due_date}
{assign var="same" value=$v.due_date}

{assign var="instalment_exist" value=$instalment_exist+1}
{/if}
{/foreach}


{assign var="same" value=""}
{assign var="satu" value="true"}
{if $tpl_inv.sales_number eq "P40436100001" or $tpl_inv.sales_number eq "P40436100002" or $tpl_inv.sales_number eq "P40436100003" or $tpl_inv.sales_number eq "P40436100004"}
	{assign var="pp_date" value=$pp_date}
	{assign var="my_time" value="-2 months"|strtotime|date_format:"%d-%B-%Y"}
{else}
	{assign var="pp_date" value=0}
{/if}
{if $instalment_exist gt 1}

{foreach from=$tpl_inv.instalments item=v name=invinst}
{if $same neq $v.due_date}
{assign var="same" value=$v.due_date}
<tr>
   <td>Payment schedule:
   <td align="right" width="60%">{$v.due_date|date_format:"%d-%B-%Y"} = {$tpl_inv.transaction_currency}. {if $satu eq "true" and $tpl_inv.apar_type eq 'AR'}{$v.transaction_full_amount+$tpl_inv.total_aparasd|number_format:"2"}{assign var="satu" value="false"}{else}{$v.transaction_full_amount|number_format:"2"}{/if}
{/if}
{/foreach}
{/if}
<tr><td>&nbsp;
</table>{* top most table for these *}
</font>

<!-- vico 30/06/2011 add blank space to E-sign move next page -->
{if $tpl_inv.sales_number eq "P13117100012" 
or $tpl_inv.sales_number eq "P13117100013" 
or $tpl_inv.sales_number eq "P13411100419" 
or $tpl_inv.sales_numbers eq "P14330100006001" 
or $tpl_inv.sales_numbers eq "P14330100008001" 
or $tpl_inv.sales_numbers eq "P14330100009001" 
or $tpl_inv.sales_numbers eq "P14330100008001" 
or $tpl_inv.sales_numbers eq "P14330100009001" 
or $tpl_inv.sales_numbers eq "P92411100044" 
or $tpl_inv.sales_numbers eq "P40101102525" 
or $tpl_inv.sales_numbers eq "P13411101125" 
or $tpl_inv.sales_numbers eq "P13115100727" 
or $tpl_inv.sales_number eq "P13411101133" 
or $tpl_inv.sales_number eq "P13115100749" 
or $tpl_inv.sales_number eq "P13411101134"

or $tpl_inv.sales_number eq "P13115100729"
or $tpl_inv.sales_number eq "P13411101135"
or $tpl_inv.sales_number eq "P13115100730"
or $tpl_inv.sales_number eq "P13411101136"
or $tpl_inv.sales_number eq "P13411101137"
or $tpl_inv.sales_number eq "P13115100731"

or $tpl_inv.sales_number eq "P13411101140"
or $tpl_inv.sales_number eq "P13411101168"
or $tpl_inv.sales_number eq "P13115100744"
or $tpl_inv.sales_number eq "P13411101166"
or $tpl_inv.sales_number eq "P13115100762"
or $tpl_inv.sales_number eq "P13115100770"
or $tpl_inv.sales_number eq "P13411101169"
or $tpl_inv.sales_number eq "P13115100771"

or $tpl_inv.sales_number eq "P13411101131"
or $tpl_inv.sales_number eq "P13115100751"
or $tpl_inv.sales_number eq "P13411101147"
or $tpl_inv.sales_number eq "P13115100752"
or $tpl_inv.sales_number eq "P13411101149"
or $tpl_inv.sales_number eq "P13115100753"

or $tpl_inv.sales_number eq "P13411101167"
or $tpl_inv.sales_number eq "P13115100764"

or $tpl_inv.sales_number eq "P13411101145"
or $tpl_inv.sales_number eq "P13411101146"
or $tpl_inv.sales_number eq "P13115100733"
or $tpl_inv.sales_number eq "P13115100734"

or $tpl_inv.sales_number eq "P13411101130"
or $tpl_inv.sales_number eq "P13115100728"
or $tpl_inv.sales_number eq "P13411101150"
or $tpl_inv.sales_number eq "P13115100736"
or $tpl_inv.sales_number eq "P13117100100"
or $tpl_inv.sales_number eq "P13117100101"
or $tpl_inv.sales_number eq "P13117100102"
or $tpl_inv.sales_number eq "P13117100103"
or $tpl_inv.sales_number eq "P13117100104"
or $tpl_inv.sales_number eq "P13117100105"
or $tpl_inv.sales_number eq "P13117100106"

or $tpl_inv.sales_number eq "P13411101138"
or $tpl_inv.sales_number eq "P13115100732"
or $tpl_inv.sales_number eq "P13117100078"
or $tpl_inv.sales_number eq "P13117100080"
or $tpl_inv.sales_number eq "P13117100079"
or $tpl_inv.sales_number eq "P13117100081"
or $tpl_inv.sales_number eq "P13117100082"
or $tpl_inv.sales_number eq "P13117100084"

or $tpl_inv.sales_number eq "P13411101151"
or $tpl_inv.sales_number eq "P13115100737"
or $tpl_inv.sales_number eq "P13411101152"
or $tpl_inv.sales_number eq "P13115100738"
or $tpl_inv.sales_number eq "P13411101154"
or $tpl_inv.sales_number eq "P13115100739"
or $tpl_inv.sales_number eq "P13411101153"
or $tpl_inv.sales_number eq "P13115100740"
or $tpl_inv.sales_number eq "P13411101155"
or $tpl_inv.sales_number eq "P13115100741"
or $tpl_inv.sales_number eq "P13115100750"

or $tpl_inv.sales_number eq "P13117100098"
or $tpl_inv.sales_number eq "P13117100097"
or $tpl_inv.sales_number eq "P13117100096"
or $tpl_inv.sales_number eq "P13117100095"
or $tpl_inv.sales_number eq "P13117100094"

or $tpl_inv.sales_number eq "P13411101177"

or $tpl_inv.sales_number eq "P13117100093"
or $tpl_inv.sales_number eq "P13117100092"
or $tpl_inv.sales_number eq "P13117100086"
or $tpl_inv.sales_number eq "P13115100778"


}
<!-- PAGE BREAK -->
{/if}
<!-- end -->

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
  <td width="60%">
  {*if $tpl_inv.back_office_code eq 11*}
    <font size="1">
    <table border="0" width="110%">


<!-- generate va number -->
{* if $tpl_inv.userid eq 'ades' or $tpl_inv.userid eq 'Ades' *}
{if $tpl_inv.sales_number eq "P10438100011"}{/if}
{if ($tpl_inv.intermediary_type eq '---' or $tpl_inv.intermediary_type eq 'AGENT' or $tpl_inv.intermediary_type eq 'INSTITUTIONAL AGENT') and $tpl_inv.va_count neq 0}


	{if $tpl_inv.transaction_currency eq 'IDR' or $tpl_inv.transaction_currency eq 'USD'}	
		<tr>
		//RRH
		{if $tpl_inv.apar_type eq 'AR'}
			<td colspan="3"><table border='1' cellpadding='10'> <tr> <td> <font size="3"><b>Pilihan Pembayaran Premi.</b></font> </td> </tr> </table> <br> <b>Virtual Account Number.</b>
		     	{if $tpl_inv.insurance_product_code eq "436" and $tpl_inv.wording_code eq "PASOPATI"}
					<tr><td valign="top" width="70%"><font size="3">Bank BCA (IDR)</font><td valign="top" width="5%"><font size="3">:&nbsp;</font><td valign="top" width="78%"><font size="3"><b>0032 24047 87085</b></font>
					<tr><td valign="top" width="70%"><font size="3">Bank BCA (IDR)</font><td valign="top" width="5%"><font size="3">:&nbsp;</font><td valign="top" width="78%"><font size="3"><b>0032 24047 86923</b></font>
				{else}
					{foreach from=$tpl_inv.virtual_account item=o}
						<tr><td valign="top" width="70%"><font size="3">{$o.bank_code} ({$o.cur})</font><td valign="top" width="5%"><font size="3">:&nbsp;</font><td valign="top" width="78%"><font size="3"><b>{$o.va_1}&nbsp;{$o.va_2}&nbsp;{$o.va_3}</b></font>
					{/foreach}
				{/if}
				
				
		<!-- Rachmat Rizkihadi, update indomaret -->
			{if $tot_indo lt 5000000 and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
				<tr><td>&nbsp;
				<tr>
					<td valign="top" width="70%"> <font size="3"> Pembayaran di INDOMARET </font> <td valign="top" width="5%"> <font size="3"> : </font> <td valign="top" width="78%"> <font size="3"> No. Polis <b>{$tpl_inv.sales_number}{$tpl_inv.rev_number}</b></font>
					<tr><td colspan="3"><font size="2"> (Pembayaran Maksimal Rp. 5 Juta) </font>
			{/if}
		<!-- Rachmat Rizkihadi, update indomaret -->
		
		<!-- RR - update finpay 19062017 -->
		{if $tpl_inv.finpay_paymentcode neq '' and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
			<tr><td>&nbsp;
			<table border="0" width='380px'>
			<tr><td valign="top"> 
				
				<font size="3"><b>Pembayaran via FinPay</b></font> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; Kode Bayar <font size="3"> <b> {if $tpl_inv.finpay_paymentcode eq ''} 021XXXXXXXXX {else} {$tpl_inv.finpay_paymentcode} {/if} </b></font><br>
				<font size="2">Metode pembayaran melalui semua menu TELKOM</font><br>
				<font size="2">Kode Bayar aktif sampai dengan tanggal {$tpl_inv.finpay_expired_date|date_format:"%d-%B-%Y"}</font> 
				
			</td></tr>
			</table>
			{/if}
		<!-- RR - update finpay -->
		
				
		{/if}
	{else}
		<tr>
		//RRH
		{if $tpl_inv.apar_type eq 'AR'}
			<td colspan="3"><table border='1' cellpadding='10'> <tr> <td> <font size="3"><b>Pilihan Pembayaran Premi,</b></font> </td> </tr> </table> <br> <b>Bank Account Number</b> 
		     	{foreach from=$tpl_inv.rekening item=o}
			       	{if $o.ccode neq 'IDR' and $o.norek neq ''}
  	  					<tr><td valign="top" width="70%">{$o.cbname} ({$o.ccode})<td valign="top" width="5%">:&nbsp;<td valign="top" width="78%">{$o.norek}	  
						{assign var=countval value=$countval+1}
					{/if}
     			{/foreach}
			{if $countval neq 0}
				{foreach from=$tpl_inv.rek_val_ho item=rek}
					{if $rek.norek neq ''}
  	  					<tr><td valign="top" width="70%">{$rek.cbname} ({$rek.ccode})<td valign="top" width="5%">:&nbsp;<td valign="top" width="78%">{$rek.norek}	  
					{/if}
     			{/foreach}
			{else}
				{foreach from=$tpl_inv.rekening item=o}
		  	 		<tr><td valign="top" width="70%">{$o.cbname}<td valign="top" width="5%">:&nbsp;{$o.ccode}<td valign="top" width="78%">{$o.norek}
	  				{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
				{/foreach}
			{/if}
		
		<!-- Rachmat Rizkihadi, update indomaret -->
			{if $tot_indo lt 5000000 and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
				<tr><td>&nbsp;
				<tr>
					<td valign="top" width="70%"> <font size="3"> Pembayaran di INDOMARET </font> <td valign="top" width="5%" colspan='2'> <font size="3"> : No. Polis <b>{$tpl_inv.sales_number}{$tpl_inv.rev_number}</b></font>
					<tr><td colspan="3"><font size="2"> (Pembayaran Maksimal Rp. 5 Juta) </font>
			{/if}
		<!-- Rachmat Rizkihadi, update indomaret -->
		
		<!-- RR - update finpay 19062017 -->
		{if $tpl_inv.finpay_paymentcode neq '' and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
			<tr><td>&nbsp;
			<table border="0" width='380px'>
			<tr><td valign="top"> 
				
				<font size="3"><b>Pembayaran via FinPay</b></font> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; Kode Bayar <font size="3"> <b> {if $tpl_inv.finpay_paymentcode eq ''} 021XXXXXXXXX {else} {$tpl_inv.finpay_paymentcode} {/if} </b></font><br>
				<font size="2">Metode pembayaran melalui semua menu TELKOM</font><br>
				<font size="2">Kode Bayar aktif sampai dengan tanggal {$tpl_inv.finpay_expired_date|date_format:"%d-%B-%Y"}</font> 
				
			</td></tr>
			</table>
			{/if}
		<!-- RR - update finpay -->

	 	{/if}
	 {/if}

{else}
	{foreach from=$tpl_inv.campaign item=camp}
		{assign var=camp value=$camp}
	{/foreach}
	{if $camp.campaign_code eq "MC0000026"}	
		&nbsp;
	{else}								
      <tr>
	  //RRH
	  {if $tpl_inv.apar_type eq 'AR'}
	  <td colspan="3"><table border='1' cellpadding='10'> <tr> <td> <font size="3"><b>Pilihan Pembayaran Premi:</b></font> </td> </tr> </table> <br> <b>Bank Account Number</b>	
		{if $tpl_inv.sales_number eq "P14115100086" or $tpl_inv.sales_number eq "P14201100030" or $tpl_inv.sales_number eq "P92101100016" or $tpl_inv.sales_number eq "P12123100071"
			or $tpl_inv.back_office_code eq "14" or $tpl_inv.back_office_code eq "92"}
			{*}<tr><td valign="top" width="70%">Bank BNI Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">01-77004162<br>{*}
			{*}<tr><td valign="top" width="70%">Mandiri (Exim)<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">127-0099025890<br>{*}
			{*}<tr><td valign="top" width="70%">Mandiri (BBD) USD Pusat<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">103-0000027595<br>{*}
			{*}<tr><td valign="top" width="70%">Bank Niaga Gajah Mada<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">001-01-89201-00-7<br>{*}
			{*}<tr><td valign="top" width="70%">Bank Niaga (USD) Pusat<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">001-02-09304-002<br>{*}
			{*}<tr><td valign="top" width="70%">BCA Rasuna Said <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">217-302-3553<br>{*}
			{*}<tr><td valign="top" width="70%">City Bank <td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">300-016-6046<br>{*}
			{*}<tr><td valign="top" width="70%">City Bank <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">300-016-6030<br>{*}
 
			{if $camp.campaign_code eq "MC0000067"}
			 	<tr><td valign="top" width="70%">Mandiri Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">1270099025890<br>
			 	<tr><td valign="top" width="70%">BCA Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">2173023553<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Jakarta <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">800000481500<br>
			{elseif $tpl_inv.sales_number eq "P14204100223" or $tpl_inv.back_office_code eq "14"}
			 	<tr><td valign="top" width="70%">CIMB Niaga- Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">800000481500<br>
			 	<tr><td valign="top" width="70%">BCA – Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">217-3023553<br>
			 	<tr><td valign="top" width="70%">Mandiri -  Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">127009902589<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Jakarta<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">800000529840<br>
			 	<tr><td valign="top" width="70%">Mandiri -  Jakarta<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">103-0000027595<br>
			{elseif $tpl_inv.sales_number eq "P92199100139"}
				<tr><td valign="top" width="70%">Mandiri (Bapindo) Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">142-0090000281<br>
			 	<tr><td valign="top" width="70%">BCA Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">788-080064-1<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">800005063600<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">800005292340<br>
			 	<tr><td valign="top" width="70%">Bank Bukopin <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">1021908017<br>
				<tr><td valign="top" width="70%">Bank BNI Jakarta<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">01-77004162<br>
			{elseif $tpl_inv.note eq "YES"}
				{if $tpl_inv.back_office_code eq "51"}			
		  	  		<tr><td valign="top" width="70%">Bank BNI - Pekanbaru<td valign="top" width="5%">:&nbsp;{$tpl_inv.home_currency}<td valign="top" width="78%">799506437
		  			{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
		  	  	{else}
		  	  		<tr><td valign="top" width="70%">Bank BNI Jakarta<td valign="top" width="5%">:&nbsp;{$tpl_inv.home_currency}<td valign="top" width="78%">01-77004162
		  			{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
		  	  	{/if}
				
			{elseif $tpl_inv.cconame eq "PT Bank Shinhan Indonesia Cabang Jember"}
			
				<tr><td valign="top" width="70%">Mandiri (Bapindo) Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">142-0090000281<br>
			 	<tr><td valign="top" width="70%">BCA Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">788-080064-1<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">800005063600<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">800005292340<br>
			 	<tr><td valign="top" width="70%">Bank Bukopin <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">1021908017<br>
				<tr><td valign="top" width="70%">Bank Shinhan <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">701000053769<br>
				
				
			{else}
			 	<tr><td valign="top" width="70%">Mandiri (Bapindo) Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">142-0090000281<br>
			 	<tr><td valign="top" width="70%">BCA Surabaya<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">788-080064-1<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">800005063600<br>
			 	<tr><td valign="top" width="70%">CIMB Niaga - Tunjungan, Surabaya <td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">800005292340<br>
			 	<tr><td valign="top" width="70%">Bank Bukopin <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">1021908017<br>
			{/if}
	{elseif $tpl_inv.apar_type eq 'AR' and $tpl_inv.cconame eq "PT Bank Woori Saudara Indonesia 1906, Tbk" or $tpl_inv.cconame eq "PT Bank Woori Indonesia" }
			{foreach from=$tpl_inv.rekening item=o}					
		  	  	<tr><td valign="top" width="70%">{$o.cbname|replace:"Bank BNI Jakarta":"Bank BNI 46 Fatmawati"}<td valign="top" width="5%">:&nbsp;{$o.ccode}<td valign="top" width="78%">{$o.norek}
			{/foreach}		 
	
	{elseif $tpl_inv.apar_type eq 'AR' and $tpl_inv.note eq "YES"}
				{if $tpl_inv.back_office_code eq "51"}			
		  	  		<tr><td valign="top" width="70%">Bank BNI - Pekanbaru<td valign="top" width="5%">:&nbsp;{$tpl_inv.home_currency}<td valign="top" width="78%">799506437
		  			{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
		  	  	{else}
		  	  		<tr><td valign="top" width="70%">Bank BNI Jakarta<td valign="top" width="5%">:&nbsp;{$tpl_inv.home_currency}<td valign="top" width="78%">01-77004162
		  			{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
		  	  	{/if}

	{elseif $tpl_inv.apar_type eq 'AR' and $tpl_inv.intermediary_type eq "BANK" and $tpl_inv.checking_bank neq "0" OR
	 $tpl_inv.apar_type eq 'AR' and $tpl_inv.intermediary_code eq "INT90142826" and $tpl_inv.checking_bank neq "0"}
			{foreach from=$tpl_inv.info_bank item=o}					
		  	  		<tr><td>{$o.info_bank}</td>
				{/foreach}
	
	{else}			
     		{foreach from=$tpl_inv.rekening item=o}					
		  	  	<tr><td valign="top" width="70%">{$o.cbname|replace:"Bank BNI Jakarta":"Bank BNI 46 Fatmawati"}<td valign="top" width="5%">:&nbsp;{$o.ccode}<td valign="top" width="78%">{$o.norek}
	  			{* <tr><td valign="top">Account<td valign="top">:<td valign="top">{$o.norek} *}
			{/foreach}
			{if $tpl_inv.sales_number eq "P1412310002XX"}
			<tr><td valign="top" width="70%">Mandiri (BBD) USD Pusat<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">103-0000027595
			<tr><td valign="top" width="70%">Bank Niaga Gajah Mada (IDR) Pusat<td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">001-01-89201-00-7
			<tr><td valign="top" width="70%">Bank Niaga (USD) Pusat<td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">001-02-09304-002
			<tr><td valign="top" width="70%">BCA Rasuna Said <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">217-302-3553<br>
			<tr><td valign="top" width="70%">City Bank <td valign="top" width="5%">:&nbsp;USD<td valign="top" width="78%">300-016-6046<br>
			<tr><td valign="top" width="70%">City Bank <td valign="top" width="5%">:&nbsp;IDR<td valign="top" width="78%">300-016-6030<br>
			{/if}
 		{/if}
		
		
		<!-- Rachmat Rizkihadi, update indomaret -->
		{if $tot_indo lt 5000000 and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
			<tr><td>&nbsp;
			<tr>
				<td valign="top" width="70%"> <font size="3"> Pembayaran di INDOMARET </font> <td valign="top" width="5%" colspan='2'> <font size="3"> : No. Polis <b>{$tpl_inv.sales_number}{$tpl_inv.rev_number}</b></font>
				<tr><td colspan="3"><font size="2"> (Pembayaran Maksimal Rp. 5 Juta) </font>
		{/if}
		<!-- Rachmat Rizkihadi, update indomaret -->
		
		<!-- RR - update finpay 19062017 -->
			{if $tpl_inv.finpay_paymentcode neq '' and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
			<tr><td>&nbsp;
			<table border="0" width='380px'>
			<tr><td valign="top"> 
				
				<font size="3"><b>Pembayaran via FinPay</b></font> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; Kode Bayar <font size="3"> <b> {if $tpl_inv.finpay_paymentcode eq ''} 021XXXXXXXXX {else} {$tpl_inv.finpay_paymentcode} {/if} </b></font><br>
				<font size="2">Metode pembayaran melalui semua menu TELKOM</font><br>
				<font size="2">Kode Bayar aktif sampai dengan tanggal {$tpl_inv.finpay_expired_date|date_format:"%d-%B-%Y"}</font> 
				
			</td></tr>
			</table>
			{/if}
		<!-- RR - update finpay -->
		
		
    {/if}
{/if}
{/if}

<!-- Muh, indomaret 
{if $tot_indo lt 5000000 and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GVGP")}
	<tr><td>&nbsp;
	<tr>
		<td><b>INDOMARET</b>
		<tr><td colspan="3"><font size="2">Pembayaran premi s.d Rp 5 juta dapat dilakukan secara tunai di seluruh outlet Indomaret dengan menyebutkan 15 digit Nomor Polis Sdr. yaitu : {$tpl_inv.sales_number}{$tpl_inv.rev_number}</font>
{/if} -->
 
{*}
{else}

	 <tr>
	 //RRH
	{if $tpl_inv.apar_type eq 'AR'}
	  <td colspan="3"><table border='1' cellpadding='10'> <tr> <td> <font size="3"><b>Pilihan Pembayaran Premi</b></font> </td> </tr> </table> <br> <b>Bank Account Number</b>
     		{foreach from=$tpl_inv.rekening item=o}
		  	  <tr><td valign="top" width="70%">{$o.cbname}<td valign="top" width="5%">:&nbsp;{$o.ccode}<td valign="top" width="78%">{$o.norek}

		{/foreach}
{/if}
{/if}
{*}
    </table>
    </font>
  {*else*}
   &nbsp;
  {*/if*}
<!-- end va number -->												
<td width="40%">
<font size="2">
{*$tpl_inv.insurance_product_code*}
<br />
{*$tpl_inv.lifeInsurancePartnerCode*}
{if $tpl_inv.insurance_product_code neq "397" and $tpl_inv.lifeInsurancePartnerCode neq "CAR" and $tpl_inv.esign eq "t" 
or $tpl_inv.sales_number eq "P51301100148"
or $tpl_inv.sales_number eq "P51101100296"}



	<table border="0" width="100%" cellspacing="2" cellpadding="2">
	 	<tr><td width="5%">&nbsp;<td>{$tpl_inv.back_office_name}, {if $tpl_inv.sales_number eq "P10202103628" or $tpl_inv.sales_number eq "P10107100111" 
		 or $tpl_inv.sales_number eq "P13302100031"} 01-November-2017  {else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
	 	<tr><td width="5%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
		 	{if $tpl_inv.insurance_product_code eq "188"}
				{if $tpl_inv.sales_number eq "P18188100447" or $tpl_inv.sales_number eq "P10193102170" or $tpl_inv.sales_number eq "P18188100388" 
				or $tpl_inv.sales_number eq "P10188101068"}
					<tr><td width="5%">&nbsp;<td><img src="{$qr_link}" width="80" height="80" />					
					<tr><td width="5%">&nbsp;<td>Electronically Signed By {$tpl_inv.esign.username}
					<tr><td width="5%">&nbsp;<td>Signature: {$tpl_inv.esign.signature}
		 		{elseif $tpl_inv.kode_cabang neq "91" and $tpl_inv.kode_cabang neq "31" and $tpl_inv.kode_cabang neq "32" }
			 		<tr><td width="35%">&nbsp;
			 		<tr><td width="35%">&nbsp;
			 		<tr><td width="35%">&nbsp;<td>{$hrlines}
			 		<tr><td width="35%">&nbsp;<td>Authorized name, signature and stamp.
			 	{else}								
			 		<tr><td width="5%">&nbsp;<td><img src="{$qr_link}" width="80" height="80" />					
					<tr><td width="5%">&nbsp;<td>Electronically Signed By {$tpl_inv.esign.username}
					<tr><td width="5%">&nbsp;<td>Signature: {$tpl_inv.esign.signature}
				{/if}
			{else}																						
				<tr><td width="5%">&nbsp;<td><img src="{$qr_link}" width="80" height="80" />					
				<tr><td width="5%">&nbsp;<td>Electronically Signed By {$tpl_inv.esign.username}
				<tr><td width="5%">&nbsp;<td>Signature: {$tpl_inv.esign.signature} 
			{/if}
	</table>
{else}
	 {if $tpl_inv.es eq 't'}



		<table border="0" width="100%" cellspacing="2" cellpadding="2">
	  	<tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name}, 
			 {if $tpl_inv.sales_number eq  "P10402100527"} 31-Januari-2018 
			{elseif $tpl_inv.sales_number eq "P13306100074"} 01-November-2017
{*}
<!-- req spesial tanggal invoiced 2017110810000996 -->					
					{elseif $tpl_inv.sales_number eq "P13115100327"} 28-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13303100113"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100037"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100039"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100040"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100053"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100054"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100055"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100056"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100120"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13307100043"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13408100051"} 28-November-2017
					{elseif $tpl_inv.sales_number eq "P13411100652"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20301100124"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20306100015"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20306100016"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20306100020"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20307100069"} 01-November-2017
					{elseif $tpl_inv.sales_number eq "P20411101501"} 01-November-2017
					{elseif $tpl_inv.sales_number eq "P20411101502"} 01-November-2017
					{elseif $tpl_inv.sales_number eq "P20411101503"} 01-November-2017
					{elseif $tpl_inv.sales_number eq "P13306100063"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100038"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100082"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100060"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100061"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100067"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100064"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100076"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100062"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100077"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100057"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100059"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13306100068"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P13301100580"} 30-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20411101510"} 28-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20115100679"} 28-Oktober-2017
					{elseif $tpl_inv.sales_number eq "P20411018234"} 01-November-2017
					{elseif $tpl_inv.sales_number eq "P13301100640"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13301100641"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13301100638"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13411100478"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13411100479"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13411100533"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13411100522"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13115100337"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13408100033"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20301100112"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20301100878"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20301100773"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20301100121"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20411101695"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13301100661"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20302100126"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20300100718"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20300100719"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20302100123"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20302100124"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20302100127"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20302100119"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20303100112"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20302100118"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20302100125"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P20302100122"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20302100121"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P20302100120"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13301100644"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13302100037"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13302100035"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13302100034"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13302100031"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13302100036"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13302100032"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13302100033"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13306100058"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13408100052"} 01-November-2017
{elseif $tpl_inv.sales_number eq "P13210100007"} 31-October-2017
{elseif $tpl_inv.sales_number eq "P13305100003"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13301100656"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13301100436"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13301100630"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13411100500"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13115100328"} 30-October-2017
			{elseif $tpl_inv.sales_number eq "P19411100038"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P19301100012"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P51301100600"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P51301100607"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13115100324"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13301100468"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20115018234"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20301012570"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13301100657"} 30-October-2017
			{elseif $tpl_inv.sales_number eq "P20302100126"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20300100718"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20300100719"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20302100123"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20302100124"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20302100127"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20302100119"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20303100112"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20302100118"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20302100125"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P20302100122"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20302100121"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P20302100120"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100047"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P10203101640"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101658"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101659"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101660"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101661"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P13306100043"} 31-October-2017
			{elseif $tpl_inv.sales_number eq "P13306100079"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100080"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100070"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100074"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100073"} 01-November-2017
			{elseif $tpl_inv.sales_number eq "P13306100072"} 01-November-2017
{*}
{*}
				{elseif $tpl_inv.sales_number eq "P10203101657"} 15-Januari-2018
				{elseif $tpl_inv.sales_number eq "P10203101640"} 16-Januari-2018	
			{elseif $tpl_inv.sales_number eq "P10402100527"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101658"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101659"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101660"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101661"} 16-Januari-2018
			
			{elseif $tpl_inv.sales_number eq "P10408100493"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10408100435"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10408100495"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10408100406"} 16-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10408100492"} 16-Januari-2018
			
			{elseif $tpl_inv.sales_number eq "P18411100149"} 12-Januari-2018
			{elseif $tpl_inv.sales_number eq "P18115100073"} 12-Januari-2018
			{elseif $tpl_inv.sales_number eq "P91301100767"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P13301101228"} 19-Januari-2018
			
			{elseif $tpl_inv.sales_number eq "P10199102783"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102798"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102799"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102802"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10411103077"} 31-Januari-2018
			
			{elseif $tpl_inv.sales_number eq "P10115101800"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10101104621"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10101104614"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10101105451"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10203101697"} 31-Januari-2018
			
			{elseif $tpl_inv.sales_number eq "P90304100004"} 25-Juli-2018
			
			{elseif $tpl_inv.sales_number eq "P13115100220"} 25-Juli-2018
			{elseif $tpl_inv.sales_number eq "P10411102573"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P91301100767"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10115101649"} 31-Januari-2018
{*}	
		{*}case2018020710000021{*}	
			{elseif $tpl_inv.sales_number eq "P10199102783"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102798"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102799"} 31-Januari-2018
			{elseif $tpl_inv.sales_number eq "P10199102802"} 31-Januari-2018
		{*}case2018020710000057{*}	
{elseif $tpl_inv.sales_number eq "P10199102809"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102810"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102838"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102839"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102841"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102856"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102857"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102800"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102801"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102803"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102804"} 6-Februari-2018
{elseif $tpl_inv.sales_number eq "P10199102805"} 6-Februari-2018
		{*}case2018020710000119{*}
			{elseif $tpl_inv.sales_number eq "P10408100483"} 30-Desember-2017
			{elseif $tpl_inv.sales_number eq "P10302100236"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10199102803"} 6-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10199102804"} 6-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10203101727"} 22-Februari-2018
			
			
			{elseif $tpl_inv.sales_number eq "P10411102670"} 01-March-2018
			{elseif $tpl_inv.sales_number eq "P10115101665"} 01-March-2018
			{elseif $tpl_inv.sales_number eq "P10302100236"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10203101740"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10203101737"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10203101739"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10203101738"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P91301100786"} 28-Februari-2018
			{elseif $tpl_inv.sales_number eq "P10204104417"} 23-Maret-2018
						{elseif $tpl_inv.sales_number eq "P10203101788"} 23-Maret-2018
						{elseif $tpl_inv.sales_number eq "P10203101787"} 23-Maret-2018
						
						{elseif $tpl_inv.sales_number eq "P10408100498"} 26-Maret-2018
						{elseif $tpl_inv.sales_number eq "P91301100802"} 27-Maret-2018
						
						{elseif $tpl_inv.sales_number eq "P10411102441"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10411102444"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10411102446"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10411102447"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10201108678"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10203101795"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10203101796"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P92402100005"} 2-April-2018
						
						{elseif $tpl_inv.sales_number eq "P40399100320"} 11-April-2018
						{elseif $tpl_inv.sales_number eq "P10201108667"} 2-April-2018
						{elseif $tpl_inv.sales_number eq "P10411103123"} 2-April-2018
						
						{elseif $tpl_inv.sales_number eq "P36388100015"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36488100014"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100109"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100179"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100252"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100284"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100306"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P36388100338"} 12-April-2018
						{elseif $tpl_inv.sales_number eq "P10408100395"} 17-April-2018
						{elseif $tpl_inv.sales_number eq "P10203101840"} 22-May-2018
						
					    {elseif $tpl_inv.sales_number eq "P10411103152"} 30-April-2018
						
						{elseif $tpl_inv.sales_number eq "P10411103012"} 26-April-2018 
		
						{elseif $tpl_inv.sales_number eq "P41317100102"} 02-Mei-2018									
					{elseif $tpl_inv.sales_number eq "P10411103164"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10115101830"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10411102791"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P13409100005"} 04-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P10199103400"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10199103402"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10199103403"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P37101100075"} 17-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P10302100227"} 24-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10199103409"} 02-Mei-2018
					{elseif $tpl_inv.sales_number eq "P91411100422"} 08-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P13411100882"} 19-Februari-2019
					{elseif $tpl_inv.sales_number eq "P10115101720"} 15-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P91115100065"} 08-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10115101598"} 07-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P10202103736"} 15-Mei-2018
						
					{elseif $tpl_inv.sales_number eq "P91317100161"} 24-Mei-2018
					
					{elseif $tpl_inv.sales_number eq "P13104100048"} 02-April-2018
					{elseif $tpl_inv.sales_number eq "P13104100047"} 27-Maret-2018
					{elseif $tpl_inv.sales_number eq "P13402100156"} 02-April-2018
					{elseif $tpl_inv.sales_number eq "P13402100157"} 27-Maret-2018
					
					{elseif $tpl_inv.sales_number eq "P30411102242"} 24-Mei-2018
					{elseif $tpl_inv.sales_number eq "P30411102245"} 24-Mei-2018
					{elseif $tpl_inv.sales_number eq "P13402100156"} 02-April-2018
					{elseif $tpl_inv.sales_number eq "P30411102246"} 24-Mei-2018
					{elseif $tpl_inv.sales_number eq "P10411103187"} 25-May-2018
					
					{elseif $tpl_inv.sales_number eq "P61301100153"} 28-May-2018
					{elseif $tpl_inv.sales_number eq "P61301100153"} 28-May-2018
					
					{elseif $tpl_inv.sales_number eq "P21411100088"} 28-May-2018
					
					{elseif $tpl_inv.sales_number eq "P13301100321"} 30-May-2018
					{elseif $tpl_inv.sales_number eq "P10399100833"} 19-Juy-2018
					
					{elseif $tpl_inv.sales_number eq "P10106100209"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10401100154"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10204104544"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10204104543"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10401100153"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10203101796"} 02-Juli-2018
					{elseif $tpl_inv.sales_number eq "P10101105701"} 02-Juli-2018
					
					{elseif $tpl_inv.sales_number eq "P90411100722"} 19-Februari-2019
					
					{elseif $tpl_inv.sales_number eq "P10101105117"} 09-July-2018
					{elseif $tpl_inv.sales_number eq "P10109103542"} 29-Juni-2018
				
					{elseif $tpl_inv.sales_number eq "P92411100024"} 04-Agustus-2020
					
					{elseif $tpl_inv.sales_number eq "P10115101874"} 24-September-2018
					{elseif $tpl_inv.sales_number eq "P10203101913"} 01-Juni-2018
					
					{elseif $tpl_inv.sales_number eq "P22303100105"} 31-May-2018
					{elseif $tpl_inv.sales_number eq "P10411103197"} 05-June-2018
		{elseif $tpl_inv.sales_number eq "P10408100483"} 30-December-2017	
		{elseif $tpl_inv.sales_number eq "P10199103605"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103593"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103588"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103591"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103592"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103593"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10199103594"} 01-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10203101924"} 08-Juni-2018
		{elseif $tpl_inv.sales_number eq "P10203101901"} 22-Juni-2018
		{elseif $tpl_inv.sales_number eq "P13117100069"} 29-June-2018
		{elseif $tpl_inv.sales_number eq "P13117100070"} 29-June-2018
		{elseif $tpl_inv.sales_number eq "P10104100754"} 17-July-2018
		{elseif $tpl_inv.sales_number eq "P10104100757"} 17-July-2018
		{elseif $tpl_inv.sales_number eq "P91411100542"} 28-August-2018
		{elseif $tpl_inv.sales_number eq "P92411100024"} 04-August-2020
		{elseif $tpl_inv.sales_number eq "P10204104675"} 05-September-2018
		{elseif $tpl_inv.sales_number eq "P10101105866"} 07-September-2018
		{elseif $tpl_inv.sales_number eq "P10101104856"} 07-September-2018
		{elseif $tpl_inv.sales_number eq "P13301101364"} 10-September-2018
		{elseif $tpl_inv.sales_number eq "P13302100091"} 10-September-2018
		{elseif $tpl_inv.sales_number eq "P13301101195"} 10-September-2018
		{elseif $tpl_inv.sales_number eq "P10411102328"} 25-September-2018

		{elseif $tpl_inv.sales_number eq "P10204104715"} 24-September-2018
{elseif $tpl_inv.sales_number eq "P10115101877"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10401100167"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10411103302"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P13115100653"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P13115100654"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P13411101004"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P13411101005"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P90115100346"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P91199100384"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104413"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104411"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104464"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104412"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10115101745"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10411102909"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P30411101151"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P30411101154"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P30411101153"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P30411101155"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P13205100251"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P13301100556"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P22115000661"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P10117100211"}  29-September-2018

{elseif $tpl_inv.sales_number eq "P92204100010"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P10113100010"}  20-Februari-2019

{elseif $tpl_inv.sales_number eq "P10101104668"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104444"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101104410"}  30-September-2018
{elseif $tpl_inv.sales_number eq "P10101105271"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P91411100170"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P10204104749"}  30-September-2018

{elseif $tpl_inv.sales_number eq "P10201109159"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10201109157"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10101105986"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P20302100126"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13300100526"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13307100043"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P10411102546"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P21411100675"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13411100488"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90411100504"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90317100202"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90411100640"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90411100641"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P61301100231"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90101103594"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90101103595"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P90101103700"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P10201109159"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10201109157"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10101105986"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P20302100126"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13300100526"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13307100043"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P90411100776"}  14-Maret-2019
{elseif $tpl_inv.sales_number eq "P80301101596"}  13-Maret-2019
{elseif $tpl_inv.sales_number eq "P80301101595"}  13-Maret-2019
{elseif $tpl_inv.sales_number eq "P20300100899"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P20302100127"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10109103005"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P50306100052"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50306100054"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P50306100042"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50306100055"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101494"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101495"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31306100005"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31306100013"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31306100025"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101134"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101131"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50307100020"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101132"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50301101250"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50307100021"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P50307100019"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31300100213"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31301100068"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31301100185"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P31301100207"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P36101100376"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P92115100015"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P18306100015"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13306100131"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13306100132"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P30300101180"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P10300101767"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P52301100285"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P20300100719"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P10199104975"}  05-November-2018
{elseif $tpl_inv.sales_number eq "P10199104977"}  05-November-2018
{elseif $tpl_inv.sales_number eq "P10199104978"}  05-November-2018
{elseif $tpl_inv.sales_number eq "P10199104979"}  05-November-2018
{elseif $tpl_inv.sales_number eq "P10199104980"}  05-November-2018

{elseif $tpl_inv.sales_number eq "P13301101126"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13300100132"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13301100630"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13301100644"}  31-Oktober-2018
{elseif $tpl_inv.sales_number eq "P13302100034"}  31-Oktober-2018

{elseif $tpl_inv.sales_number eq "P10204104843"}  06-November-2018
{elseif $tpl_inv.sales_number eq "P10204104844"}  06-November-2018

{elseif $tpl_inv.sales_number eq "P92411100044"}  29-October-2018

{elseif $tpl_inv.sales_number eq "P36109100042"}  08-November-2018

{elseif $tpl_inv.sales_number eq "P40101102480"}  16-Februari-2018
{elseif $tpl_inv.sales_number eq "P40199102320"}  16-Februari-2018
{elseif $tpl_inv.sales_number eq "P40101102481"}  16-Februari-2018
{elseif $tpl_inv.sales_number eq "P32203100359"}  16-Februari-2018

{elseif $tpl_inv.sales_number eq "P50411101032"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50411101068"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50411101076"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50115100872"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50115100871"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50115100873"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50411101041"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P50115100726"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P40411101140"}  08-November-2018
{elseif $tpl_inv.sales_number eq "P40301101684"}  08-November-2018

{elseif $tpl_inv.sales_number eq "P13301100667"}  14-November-2018

{elseif $tpl_inv.sales_number eq "P90302100086"}  08-November-2018

{elseif $tpl_inv.sales_number eq "P40101102393"}  19-November-2018

{elseif $tpl_inv.sales_number eq "P13301101524"}  16-November-2018
{elseif $tpl_inv.sales_number eq "P13307100165"}  16-November-2018
{elseif $tpl_inv.sales_number eq "P13307100180"}  13-November-2018
{elseif $tpl_inv.sales_number eq "P13307100183"}  13-November-2018
{elseif $tpl_inv.sales_number eq "P13307100182"}  13-November-2018
{elseif $tpl_inv.sales_number eq "P13307100181"}  13-November-2018
{elseif $tpl_inv.sales_number eq "P13301101500"}  29-September-2018
{elseif $tpl_inv.sales_number eq "P36101100257"}  27-November-2018
{elseif $tpl_inv.sales_number eq "P90301105052"}  28-November-2018
{elseif $tpl_inv.sales_number eq "P10411103012"}  17-January-2019

{elseif $tpl_inv.sales_number eq "P10199105123"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10199105125"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10199105131"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10199105136"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10199105146"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10199105149"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P61302100010"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P90317100219"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P90411100654"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P13301101538"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P40199102145"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10202103848"}  30-November-2018

{elseif $tpl_inv.sales_number eq "P10101106019"}  30-November-2018
{elseif $tpl_inv.sales_number eq "P10101106003"}  30-November-2018 
{elseif $tpl_inv.sales_number eq "P92109100019"}  18-Desember-2018 

{elseif $tpl_inv.sales_number eq "P10117100286"}  29-Desember-2018 
{elseif $tpl_inv.sales_number eq "P10106100129"}  29-Desember-2018 

{elseif $tpl_inv.sales_number eq "P40411100737"}  26-June-2019

{elseif $tpl_inv.sales_number eq "P41109100253"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P41199100831"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P10402100537"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P10411102961"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P10411102959"}  21-Desember-2018 
{elseif $tpl_inv.sales_number eq "P10101105725"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P10199105347"}  21-Desember-2018
{elseif $tpl_inv.sales_number eq "P91115100097"}  04-Januari-2019


{elseif $tpl_inv.sales_number eq "P90411002168"}  27-February-2019
{elseif $tpl_inv.sales_number eq "P90301105104"}  26-February-2019
{elseif $tpl_inv.sales_number eq "P13204100854"}  10-Januari-2019
{elseif $tpl_inv.sales_number eq "P13204100855"}  10-Januari-2019
{elseif $tpl_inv.sales_number eq "P13204100856"}  10-Januari-2019
{elseif $tpl_inv.sales_number eq "P13205100313"}  10-Januari-2019
{elseif $tpl_inv.sales_number eq "P13205100314"}  10-Januari-2019

{elseif $tpl_inv.sales_number eq "P10203102263"}  21-January-2019
{elseif $tpl_inv.sales_number eq "P10203102264"}  21-January-2019

{elseif $tpl_inv.sales_number eq "P90411100703"}  29-January-2019
{elseif $tpl_inv.sales_number eq "P90411100702"}  29-January-2019

{elseif $tpl_inv.sales_number eq "P90301105102"}  13-February-2019
{elseif $tpl_inv.sales_number eq "P36202100076"}  13-February-2019


{elseif $tpl_inv.sales_number eq "S91411100002"}  29-Desember-2018

{elseif $tpl_inv.sales_number eq "P10104100758"}  10-Januari-2019
{elseif $tpl_inv.sales_number eq "P2401100063"}  24-Januari-2019
{elseif $tpl_inv.sales_number eq "P12401100066"}  24-Januari-2019
{elseif $tpl_inv.sales_number eq "P12401100067"}  24-Januari-2019

{elseif $tpl_inv.sales_number eq "P10411103432"} 28-Januari-2019

{elseif $tpl_inv.sales_number eq "P30411102808"} 24-April-2019


{elseif $tpl_inv.sales_number eq "P80301101592"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P80303100139"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P40199102340"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P40199102339"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P40199102342"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P40199102343"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P40199102344"} 27-February-2019
{elseif $tpl_inv.sales_number eq "P36301100287"} 27-February-2019

{elseif $tpl_inv.sales_number eq "P15201102342"} 30-August-2018

{elseif $tpl_inv.sales_number eq "P21101100376"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P36101100176"} 28-February-2019


{elseif $tpl_inv.sales_number eq "P90411100728"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P22300100544"} 27-February-2019

{elseif $tpl_inv.sales_number eq "P40411101851"} 27-February-2019 
{elseif $tpl_inv.sales_number eq "P80188101550"} 27-February-2019 

{elseif $tpl_inv.sales_number eq "P90401100012"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100734"} 28-February-2019 
{elseif $tpl_inv.sales_number eq "P40411100319"} 28-February-2019
{elseif $tpl_inv.sales_number eq "S10205100196"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100743"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P90115100383"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P21411100714"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P21411001235"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P40399100479"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P31106100005"} 28-February-2019 
{elseif $tpl_inv.sales_number eq "P40109018577"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P40301101552"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P36101100172"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100735"} 19-February-2020
{elseif $tpl_inv.sales_number eq "P90115100379"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100738"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100740"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100742"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100744"} 28-February-2019 
{elseif $tpl_inv.sales_number eq "P32204100060"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100745"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P80301100874"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P80301100293"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P80188101288"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P40388100075"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P40109101486"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P40109101487"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100731"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100616"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90411100619"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P90115100386"} 21-February-2020
{elseif $tpl_inv.sales_number eq "P90411100736"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P36101100281"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P36101100280"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P36109100109"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P13109100127"} 11-Maret-2019

{elseif $tpl_inv.sales_number eq "P70115101001"} 20-June-2019

{elseif $tpl_inv.sales_number eq "P90115100378"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P90411100741"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P22411100134"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P40301101803"} 28-February-2019

{elseif $tpl_inv.sales_number eq "P32301100432"} 25-September-2018
{elseif $tpl_inv.sales_number eq "P32303100029"} 13-Desember-2018

{elseif $tpl_inv.sales_number eq "P13301100902"} 11-Maret-2019
{elseif $tpl_inv.sales_number eq "P13301100895"} 11-Maret-2019
{elseif $tpl_inv.sales_number eq "P13301100894"} 11-Maret-2019

{elseif $tpl_inv.sales_number eq "P90301104817"} 11-Maret-2019
{elseif $tpl_inv.sales_number eq "P80188101323"} 11-Maret-2019

{elseif $tpl_inv.sales_number eq "P40115100966"} 11-Maret-2019
{elseif $tpl_inv.sales_number eq "P80101100631"} 11-Maret-2019

{elseif $tpl_inv.sales_number eq "P40199102384"} 19-Maret-2019

{elseif $tpl_inv.sales_number eq "P13301101293"} 18-Maret-2019
{elseif $tpl_inv.sales_number eq "P13411101107"} 21-Maret-2019
{elseif $tpl_inv.sales_number eq "P80188101568"} 25-Maret-2019
{elseif $tpl_inv.sales_number eq "P30109100847"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P30109100852"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P30109100854"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P30411102735"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P30109100708"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P37301100091"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P37109100047"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P30109100861"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P13411100109"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P13101100092"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P13109100183"} 27-Maret-2019

{elseif $tpl_inv.sales_number eq "P30411102732"} 27-Maret-2019

{elseif $tpl_inv.sales_number eq "P90109100348"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P90109100351"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P10115101704"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P40199102425"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P40199102426"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P40199102427"} 28-Maret-2019

{elseif $tpl_inv.sales_number eq "P40199102425"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P40199102426"} 28-Maret-2019
{elseif $tpl_inv.sales_number eq "P40199102427"} 28-Maret-2019

{elseif $tpl_inv.sales_number eq "P10206100029"} 29-Maret-2019
{elseif $tpl_inv.sales_number eq "P10206100030"} 29-Maret-2019
{elseif $tpl_inv.sales_number eq "P10204105172"} 29-Maret-2019
{elseif $tpl_inv.sales_number eq "P10204105160"} 30-Maret-2019

{elseif $tpl_inv.sales_number eq "P30101102215"} 30-Maret-2019
{elseif $tpl_inv.sales_number eq "P30411102743"} 30-Maret-2019
{elseif $tpl_inv.sales_number eq "P13101100108"} 30-Maret-2019
{elseif $tpl_inv.sales_number eq "P37109100048"} 30-Maret-2019

{elseif $tpl_inv.sales_number eq "P30411100326"} 01-April-2019
{elseif $tpl_inv.sales_number eq "P15101100566"} 27-Maret-2019
{elseif $tpl_inv.sales_number eq "P10115101946"} 30-Maret-2019

{elseif $tpl_inv.sales_number eq "P13115100127"} 10-Mei-2019

{elseif $tpl_inv.sales_number eq "P30411102758"} 02-April-2019
{elseif $tpl_inv.sales_number eq "P90411100805"} 02-April-2019
{elseif $tpl_inv.sales_number eq "P30411102194"} 02-April-2019

{elseif $tpl_inv.sales_number eq "P10411103469"} 30-Maret-2019

{elseif $tpl_inv.sales_number eq "P13301100188"} 04-April-2019

{elseif $tpl_inv.sales_number eq "P91301100946"} 08-April-2019
{elseif $tpl_inv.sales_number eq "P41202100198"} 08-April-2019
{elseif $tpl_inv.sales_number eq "P41202100199"} 08-April-2019

{elseif $tpl_inv.sales_number eq "P30301101664"} 08-April-2019


{elseif $tpl_inv.sales_number eq "P30101102242"} 02-Mei-2019

{elseif $tpl_inv.sales_number eq "P30109016837"} 30-April-2019


{elseif $tpl_inv.sales_number eq "P10109103904"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P10109103905"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P10109103906"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P37301100093"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P30199101068"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P30199101069"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P30199101071"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P14301101544"} 12-April-2019
{elseif $tpl_inv.sales_number eq "P19199115373"} 12-April-2019

{elseif $tpl_inv.sales_number eq "P91101100385"} 30-Agustus-2019

{elseif $tpl_inv.sales_number eq "P32301100458"} 15-April-2019
{elseif $tpl_inv.sales_number eq "P30411100324"} 15-April-2019
{elseif $tpl_inv.sales_number eq "P50301101728"} 15-April-2019
{elseif $tpl_inv.sales_number eq "P80188101581"} 12-April-2019

{elseif $tpl_inv.sales_number eq "P30411102792"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30199101090"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30199101091"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30101101686"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P37301100098"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30301101900"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P19101100245"} 16-April-2019

{elseif $tpl_inv.sales_number eq "P30411102780"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30411100190"} 16-April-2019

{elseif $tpl_inv.sales_number eq "P30411102804"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P30301101901"} 18-April-2019

{elseif $tpl_inv.sales_number eq "P30115101076"} 22-April-2019
{elseif $tpl_inv.sales_number eq "P30199101092"} 22-April-2019
{elseif $tpl_inv.sales_number eq "P30199101093"} 22-April-2019
{elseif $tpl_inv.sales_number eq "P30199101094"} 22-April-2019

{elseif $tpl_inv.sales_number eq "P13411101140"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13411101168"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13115100744"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13411101166"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13115100762"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13115100770"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13411101169"} 27-April-2019
{elseif $tpl_inv.sales_number eq "P13115100771"} 27-April-2019

{elseif $tpl_inv.sales_number eq "P19109100236"} 29-April-2019

{elseif $tpl_inv.sales_number eq "P10199106698"} 29-April-2019


{elseif $tpl_inv.sales_number eq "P13115100729"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13411101135"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13115100730"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13411101136"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13411101137"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P15203109949"} 31-May-2019

{elseif $tpl_inv.sales_number eq "P13411101145"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13411101146"} 26-April-2019
{elseif $tpl_inv.sales_number eq "P13115100733"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13115100734"} 26-April-2019

{elseif $tpl_inv.sales_number eq "P80101100333"} 10-Juni-2019
{elseif $tpl_inv.sales_number eq "P13115100732"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100078"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100080"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100079"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100081"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100082"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P13117100084"} 29-April-2019

{elseif $tpl_inv.sales_number eq "P10199102222"} 06-Mei-2019
{elseif $tpl_inv.sales_number eq "P13301101295"} 06-Mei-2019
{elseif $tpl_inv.sales_number eq "P13303100058"} 06-Mei-2019
{elseif $tpl_inv.sales_number eq "P13101100985"} 06-Mei-2019
{elseif $tpl_inv.sales_number eq "P13115100782"} 06-Mei-2019

{elseif $tpl_inv.sales_number eq "P30306100055"} 30-April-2019

{elseif $tpl_inv.sales_number eq "P30303100121"} 03-Mei-2019

{elseif $tpl_inv.sales_number eq "P90301105159"} 30-April-2019


{elseif $tpl_inv.sales_number eq "P13206100007"} 28-Mei-2019


{elseif $tpl_inv.sales_number eq "P14411100379"} 13-Agustus-2019


{elseif $tpl_inv.sales_number eq "P13101100210"} 30-April-2019

{elseif $tpl_inv.sales_number eq "P13117100086"} 30-April-2019
{elseif $tpl_inv.sales_number eq "P13117100087"} 30-April-2019
{elseif $tpl_inv.sales_number eq "P13117100088"} 30-April-2019
{elseif $tpl_inv.sales_number eq "P13117100089"} 30-April-2019
{elseif $tpl_inv.sales_number eq "P10109103936"} 30-April-2019

{elseif $tpl_inv.sales_number eq "P30203103905"} 29-April-2019
{elseif $tpl_inv.sales_number eq "P21115100166"} 07-Mei-2019

{elseif $tpl_inv.sales_number eq "P30101101885"} 07-Mei-2019
{elseif $tpl_inv.sales_number eq "P30411100716"} 07-Mei-2019
{elseif $tpl_inv.sales_number eq "P30411101495"} 07-Mei-2019
{elseif $tpl_inv.sales_number eq "P70411100758"} 07-Mei-2019
{elseif $tpl_inv.sales_number eq "P70115100988"} 07-Mei-2019
{elseif $tpl_inv.sales_number eq "P10411103500"} 08-Mei-2019
{elseif $tpl_inv.sales_number eq "P41408100033"} 08-Mei-2019

{elseif $tpl_inv.sales_number eq "P15206100212"} 29-May-2019

{elseif $tpl_inv.sales_number eq "P92199100139"} 03-Mei-2019

{elseif $tpl_inv.sales_number eq "P10204105254"} 10-Mei-2019

{elseif $tpl_inv.sales_number eq "P90411100844"} 10-Mei-2019
{elseif $tpl_inv.sales_number eq "P90411100847"} 10-Mei-2019
{elseif $tpl_inv.sales_number eq "P10204105280"} 10-Mei-2019

{elseif $tpl_inv.sales_number eq "P10204105254"} 10-Mei-2019
{elseif $tpl_inv.sales_number eq "P10204105280"} 10-Mei-2019
{elseif $tpl_inv.sales_number eq "P92301100142"} 10-Mei-2019

{elseif $tpl_inv.sales_number eq "P70401100120"} 10-Mei-2019

{elseif $tpl_inv.sales_number eq "P92199100140"} 14-Mei-2019

{elseif $tpl_inv.sales_number eq "P13301101399"} 16-Mei-2019
{elseif $tpl_inv.sales_number eq "P13109100464"} 16-Mei-2019
{elseif $tpl_inv.sales_number eq "P13411100212"} 16-Mei-2019

{elseif $tpl_inv.sales_number eq "P70301100540"} 17-Mei-2019

{elseif $tpl_inv.sales_number eq "P40301101358"} 24-Mei-2019
{elseif $tpl_inv.sales_number eq "P10101106376"} 23-Mei-2019

{elseif $tpl_inv.sales_number eq "P20411100133"} 31-Mei-2019

{elseif $tpl_inv.sales_number eq "P13101100248"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13109100395"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13109100509"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13109100537"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13115100141"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13115100142"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P13411100221"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P30109100905"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P30109100909"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P70411007013"} 31-Mei-2019
{elseif $tpl_inv.sales_number eq "P10101105100"} 31-Mei-2019

{elseif $tpl_inv.sales_number eq "P10101105100"} 31-Mei-2019

{elseif $tpl_inv.sales_number eq "P15203109860"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15109100111"} 14-Juni-2019

{elseif $tpl_inv.sales_number eq "P10115101486"} 14-Juni-2019
{elseif $tpl_inv.sales_number eq "P10411102220"} 14-Juni-2019

{elseif $tpl_inv.sales_number eq "P15203109907"} 29-May-2019
{elseif $tpl_inv.sales_number eq "P15203109908"} 29-May-2019
{elseif $tpl_inv.sales_number eq "P15203109909"} 29-May-2019
{elseif $tpl_inv.sales_number eq "P15203109910"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109911"} 15-May-2019
{elseif $tpl_inv.sales_number eq "P15203109912"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109913"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109914"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109915"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109916"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109917"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109918"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109919"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109920"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109921"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109922"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109923"} 17-May-2019
{elseif $tpl_inv.sales_number eq "P15203109924"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109925"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109926"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109927"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109928"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109929"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109930"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109931"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109932"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109933"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109934"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109935"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109936"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109937"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109938"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109939"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109940"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P15203109941"} 31-May-2019
{elseif $tpl_inv.sales_number eq "P90201100014"} 20-September-2019

{elseif $tpl_inv.sales_number eq "P13408100284"} 20-March-2019
{elseif $tpl_inv.sales_number eq "P13429100001"} 05-March-2019

{elseif $tpl_inv.sales_number eq "P40109101568"} 20-September-2019
{elseif $tpl_inv.sales_number eq "P50117100353"} 20-September-2019
{elseif $tpl_inv.sales_number eq "P13429100001"} 05-March-2019


{elseif $tpl_inv.sales_number eq "P15101100640"} 20-September-2019

{elseif $tpl_inv.sales_number eq "P13408100292"} 20-March-2019
{elseif $tpl_inv.sales_number eq "P13408100284"} 20-March-2019
{elseif $tpl_inv.sales_number eq "P13204100974"} 25-February-2019
{elseif $tpl_inv.sales_number eq "P13301101631"} 11-March-2019
{elseif $tpl_inv.sales_number eq "P13302100111"} 25-January-2019
{elseif $tpl_inv.sales_number eq "P13388127308"} 14-June-2019

{elseif $tpl_inv.sales_number eq "P10408100509"} 28-January-2019
{elseif $tpl_inv.sales_number eq "P10302100262"} 05-March-2019
{elseif $tpl_inv.sales_number eq "P10411102443"} 30-March-2019
{elseif $tpl_inv.sales_number eq "P10411103469"} 05-April-2019
{elseif $tpl_inv.sales_number eq "P10411103469"} 30-Maret-2019
{elseif $tpl_inv.sales_number eq "P10411102444"} 30-Maret-2019

{elseif $tpl_inv.sales_number eq "P15203109864"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109865"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109866"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109867"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109868"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109869"} 16-April-2019
{elseif $tpl_inv.sales_number eq "P15203109870"} 16-April-2019

{elseif $tpl_inv.sales_number eq "P14300101554"} 07-February-2019

{elseif $tpl_inv.sales_number eq "P80411101211"} 19-June-2019
{elseif $tpl_inv.sales_number eq "P80115100827"} 19-June-2019
{elseif $tpl_inv.sales_number eq "P50109100685"} 19-June-2019
{elseif $tpl_inv.sales_number eq "P20411101770"} 19-June-2019

{elseif $tpl_inv.sales_number eq "P92301100171"} 16-Agustus-2019

{elseif $tpl_inv.sales_number eq "P20301101271"} 19-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15188100365"} 17-Juni-2019

{elseif $tpl_inv.sales_number eq "P13408100310"} 11-Juni-2019

{elseif $tpl_inv.sales_number eq "P40411100731"} 20-July-2019

{*}ojk req bahri 20062019{*}
{elseif $tpl_inv.sales_number eq "P15206100141"} 30-March-2019
{elseif $tpl_inv.sales_number eq "P15206100103"} 24-January-2019
{elseif $tpl_inv.sales_number eq "P15206100104"} 24-January-2019
{elseif $tpl_inv.sales_number eq "P15117100283"} 12-February-2019
{elseif $tpl_inv.sales_number eq "P15206100016"} 29-January-2019
{elseif $tpl_inv.sales_number eq "P15117101810"} 25-February-2019
{elseif $tpl_inv.sales_number eq "P15117100164"} 30-January-2019
{elseif $tpl_inv.sales_number eq "P15101100441"} 28-February-2019
{elseif $tpl_inv.sales_number eq "P15115101709"} 21-January-2019
{elseif $tpl_inv.sales_number eq "P15117101687"} 27-March-2019
{elseif $tpl_inv.sales_number eq "P15117100165"} 30-January-2019
{elseif $tpl_inv.sales_number eq "P15203109815"} 11-March-2019
{elseif $tpl_inv.sales_number eq "P70411100770"} 21-Juni-2019


{elseif $tpl_inv.sales_number eq "P40108100024"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P40411101603"} 30-Juni-2019

{elseif $tpl_inv.sales_number eq "P10204105382"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10204105383"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10204105384"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10203102568"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10205101554"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10205101553"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P60203100247"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10411103574"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10115101970"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15203109977"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P51301100862"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P51205100003"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P51388100627"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P51488128712"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P90101103837"} 30-Juni-2019

{elseif $tpl_inv.sales_number eq "P50202103676"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P92101100130"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P92411100075"} 05-Juli-2019
{elseif $tpl_inv.sales_number eq "P91411100584"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P15188100398"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P15199100905"} 05-July-2019

{elseif $tpl_inv.sales_number eq "P15199100911"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P15199100912"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P15188100398"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P15188100398"} 05-Juli-2019

{elseif $tpl_inv.sales_number eq "P91101100316"} 14-Agustus-2019

{elseif $tpl_inv.sales_number eq "P50202103675"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10115101973"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10411103578"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15115101085"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15117101547"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15106100416"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P15401100162"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15106100418"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15115101087"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P51109100300"} 30-Juni-2019
{elseif $tpl_inv.sales_number eq "P51109100301"} 30-Juni-2019

{elseif $tpl_inv.sales_number eq "P15401100161"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15106100417"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15117101548"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15411101800"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15115101088"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15106100419"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15401100163"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15117101550"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P15201102384"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10301103744"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10301103746"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10301103752"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10302100250"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10106100245"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10101106438"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10115101969"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10411103572"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P60203100242"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P60203100244"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P41301100279"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P60301101033"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10411102999"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P10115101777"} 29-Juni-2019

{elseif $tpl_inv.sales_number eq "P91411100478"} 13-September-2019

{elseif $tpl_inv.sales_number eq "P15204103368"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P15204103369"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P15204103370"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P15204103371"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P15204103372"} 28-June-2019

{elseif $tpl_inv.sales_number eq "P15199100884"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P15199100882"} 28-Juni-2019
{elseif $tpl_inv.sales_number eq "P15199100883"} 28-Juni-2019

{elseif $tpl_inv.sales_number eq "P70101100057"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70101100063"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P19306100056"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70411100748"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70115100976"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70411100747"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70106100045"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70480100008"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P70409100088"} 28-June-2019

{elseif $tpl_inv.sales_number eq "P18101100359"} 28-June-2019
{elseif $tpl_inv.sales_number eq "P18107100013"} 29-June-2019

{elseif $tpl_inv.sales_number eq "P15411101401"} 29-June-2019
{elseif $tpl_inv.sales_number eq "P15115100825"} 29-June-2019
{elseif $tpl_inv.sales_number eq "P15401100236"} 29-June-2019

{elseif $tpl_inv.sales_number eq "P15188100376"} 28-Juni-2019
{elseif $tpl_inv.sales_number eq "P90317100295"} 30-Juni-2019

{elseif $tpl_inv.sales_number eq "P15188100375"} 28-Juni-2019
{elseif $tpl_inv.sales_number eq "P51411100306"} 28-Juni-2019

{elseif $tpl_inv.sales_number eq "P51101100872"} 28-Juni-2019

{elseif $tpl_inv.sales_number eq "P80411100783"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P50301101623"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P21106100043"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P21411100653"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P40201103355"} 29-Juli-2019

{elseif $tpl_inv.sales_number eq "P18199101172"} 31-July-2019



{elseif $tpl_inv.sales_number eq "P40301102319"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P40301102322"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P13109100610"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P13101100284"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P36101100332"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P40301102320"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P90399100275"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P40301101632"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P40302100110"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P90109100307"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P20109100336"} 28-Juni-2019

{elseif $tpl_inv.sales_number eq "P80301101668"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P80301101223"} 29-Juni-2019
{elseif $tpl_inv.sales_number eq "P80301101675"} 28-Juni-2019

{elseif $tpl_inv.sales_number eq "P15188100380"} 01-Juli-2019

{elseif $tpl_inv.sales_number eq "P70411100557"} 29-Mei-2019
{elseif $tpl_inv.sales_number eq "P37317100122"} 29-Mei-2019
{elseif $tpl_inv.sales_number eq "P10411103236"} 29-Mei-2019
{elseif $tpl_inv.sales_number eq "P13402100299"} 29-Mei-2019

{elseif $tpl_inv.sales_number eq "P15199100900"} 03-Juli-2019

{elseif $tpl_inv.sales_number eq "P15188100385"} 03-Juli-2019
{elseif $tpl_inv.sales_number eq "P92199100148"} 03-Juli-2019
{elseif $tpl_inv.sales_number eq "P91301100976"} 03-Juli-2019
{elseif $tpl_inv.sales_number eq "P51199105911"} 03-Juli-2019

{elseif $tpl_inv.sales_number eq "P13202100991"} 06-Juli-2019
{elseif $tpl_inv.sales_number eq "P13204101061"} 09-Juli-2019
{elseif $tpl_inv.sales_number eq "P50301101757"} 09-Juli-2019

{elseif $tpl_inv.sales_number eq "P15188100469"} 28-Agustus-2019

{elseif $tpl_inv.sales_number eq "P36202100097"} 09-Juli-2019
{elseif $tpl_inv.sales_number eq "P20411100698"} 09-Juli-2019
{elseif $tpl_inv.sales_number eq "P20411102355"} 09-Juli-2019
{elseif $tpl_inv.sales_number eq "P10199107270"} 10-Juli-2019

{elseif $tpl_inv.sales_number eq "P92411100077"} 12-Juli-2019
{elseif $tpl_inv.sales_number eq "P70101100781"} 17-July-2019

{*}ojk req bahri 20062019{*}

{elseif $tpl_inv.sales_number eq "P15101100418"} 12-Juli-2019
{elseif $tpl_inv.sales_number eq "P41115100022"} 12-Juli-2019

{elseif $tpl_inv.sales_number eq "P40205100580"} 19-Juli-2019

{elseif $tpl_inv.sales_number eq "P80411100783"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P50301101623"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P21106100043"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P21411100653"} 29-Juli-2019
{elseif $tpl_inv.sales_number eq "P40201103355"} 29-Juli-2019

{elseif $tpl_inv.sales_number eq "P10204105456"} 02-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10204105456"} 02-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10101106524"} 06-Agustus-2019

{elseif $tpl_inv.sales_number eq "P51101100886"} 02-Agustus-2019

{elseif $tpl_inv.sales_number eq "P18199101183"} 06-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10411103276"} 06-Agustus-2019
{elseif $tpl_inv.sales_number eq "P21411100881"} 09-Agustus-2019

{elseif $tpl_inv.sales_number eq "P90101003969"} 13-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100456"} 16-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15188100450"} 16-Agustus-2019
{elseif $tpl_inv.sales_number eq "P36301100314"} 15-Agustus-2019


{elseif $tpl_inv.sales_number eq "P80301101841"} 16-Agustus-2019
{elseif $tpl_inv.sales_number eq "P20411102392"} 16-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10411103624"} 16-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10115101996"} 16-Agustus-2019

{elseif $tpl_inv.sales_number eq "P90204104327"} 20-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10188101490"} 21-Agustus-2019

{elseif $tpl_inv.sales_number eq "P32101100043"} 22-Agustus-2019
{elseif $tpl_inv.sales_number eq "P40301100307"} 19-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10411103629"} 22-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15203110111"} 22-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15203110106"} 22-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15203110113"} 22-Agustus-2019

{elseif $tpl_inv.sales_number eq "P30106100061"} 26-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10204105521"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15199100994"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100464"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100465"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100467"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100468"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15188100469"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P41101100514"} 16-September-2020
{elseif $tpl_inv.sales_number eq "P51188100673"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P51199105991"} 26-Agustus-2019


{elseif $tpl_inv.sales_number eq "P13411101003"} 06-September-2019
{elseif $tpl_inv.sales_number eq "P13115100652"} 06-September-2019


{elseif $tpl_inv.sales_number eq "P10204105521"} 26-Agustus-2019

{elseif $tpl_inv.sales_number eq "P13121100144"} 20-september-2019

{elseif $tpl_inv.sales_number eq "P20411102431"} 09-September-2019

{elseif $tpl_inv.sales_number eq "P50101101590"} 26-Agustus-2019
{elseif $tpl_inv.sales_number eq "P40101102630"} 26-Agustus-2019

{elseif $tpl_inv.sales_number eq "P10115101999"} 27-Agustus-2019

{elseif $tpl_inv.sales_number eq "P70411100231"} 29-Agustus-2019
{elseif $tpl_inv.sales_number eq "P80188101647"} 29-Agustus-2019

{elseif $tpl_inv.sales_number eq "P80188101649"} 29-Agustus-2019
{elseif $tpl_inv.sales_number eq "P21429100029"} 30-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15199101001"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15199101002"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15199101003"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15199101004"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P60101100268"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10109102925"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P51199106002"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P51204100527"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P51101100706"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P51101100509"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P92199100158"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P92188100012"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10101104357"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10101104354"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P41199101205"} 30-Agustus-2019

{elseif $tpl_inv.sales_number eq "P30115101144"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P30411102418"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P30411102262"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P70411100438"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P70115100702"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P18411100158"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10109103122"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P18109100139"} 30-Agustus-2019

{elseif $tpl_inv.sales_number eq "P30115100920"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P30206100007"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P30411102975"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P70411101038"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P70115101257"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P18411100158"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P10199107746"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P18109100139"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P50115100527"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P90101002780"} 06-September-2019

{elseif $tpl_inv.sales_number eq "P13411100985"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P13115100720"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15117101970"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P15117101971"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15117101959"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P50411100470"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P20206100002"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P80301101694"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P80301101505"} 30-Agustus-2019
{elseif $tpl_inv.sales_number eq "P60301101040"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P15117102004"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P80301101128"} 31-Agustus-2019

{elseif $tpl_inv.sales_number eq "P80301100986"} 31-Agustus-2019
{elseif $tpl_inv.sales_number eq "P90101002780"} 06-September-2019

{elseif $tpl_inv.sales_number eq "P20101100254"} 10-September-2019
{elseif $tpl_inv.sales_number eq "P50301100934"} 16-September-2019

{elseif $tpl_inv.sales_number eq "P60202100023"} 11-September-2019
{elseif $tpl_inv.sales_number eq "P41411100257"} 13-September-2019

{elseif $tpl_inv.sales_number eq "P13204101125"} 16-September-2019
{elseif $tpl_inv.sales_number eq "P40301019196"} 11-September-2019

{elseif $tpl_inv.sales_number eq "P61109100016"} 21-September-2019

{elseif $tpl_inv.sales_number eq "P90411100999"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P90101007068"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P90101103685"} 23-September-2019

{elseif $tpl_inv.sales_number eq "P41101100507"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51101100722"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51101100723"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51101100724"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51109100554"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51301100886"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10204105611"} 23-September-2019

{elseif $tpl_inv.sales_number eq "P10204105612"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10204105613"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10199107922"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10199107923"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10199107924"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10199107925"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P10411102924"} 23-September-2019

{elseif $tpl_inv.sales_number eq "P91301100655"} 23-September-2019
{elseif $tpl_inv.sales_number eq "P51109100565"} 23-September-2019

{elseif $tpl_inv.sales_number eq "P90115100356"} 24-September-2019

{elseif $tpl_inv.sales_number eq "P13202101056"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P10115101542"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P13101100510"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P15117102023"} 26-September-2019
{elseif $tpl_inv.sales_number eq "P15117102041"} 26-September-2019

{elseif $tpl_inv.sales_number eq "P13101100510"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P50411101147"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P21411100887"} 28-September-2019

{elseif $tpl_inv.sales_number eq "P40411101728"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P50101102355"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P50115100751"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P22199100449"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P50411100995"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P21101100369"} 29-September-2019


{elseif $tpl_inv.sales_number eq "P80301101860"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P18188100847"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P19411100149"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P30101101059"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15411103192"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P30411101905"} 29-September-2019 
{elseif $tpl_inv.sales_number eq "P31306100039"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P15117101759"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15480100152"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117101760"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117101682"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117101247"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15411103195"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15115101990"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15411103204"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15480100164"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117100794"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117101635"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117101634"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15117100796"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10101106612"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10106100115"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10411103656"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P91101100433"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P60106100008"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P60411100215"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P60101100277"} 29-September-2019


{elseif $tpl_inv.sales_number eq "P40488233440"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P91301101001"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10204105621"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10203102757"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10204105642"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10204105643"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10204105635"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10204105635"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P20188100665"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10101106620"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10411101959"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10115101280"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10203102754"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P10204105639"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P92199100166"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P92188100019"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P92188100020"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P91101100230"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P91199100441"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P61202100267"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P30411102461"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P30411102462"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P40117100395"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P15115101994"} 29-September-2019
{elseif $tpl_inv.sales_number eq "P15411103198"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P32203100496"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P18101100390"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P90101103883"} 28-September-2019

{elseif $tpl_inv.sales_number eq "P92411100082"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P91115100103"} 20-August-2019

{elseif $tpl_inv.sales_number eq "P51115100096"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P20411101811"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P21411100101"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P20188100667"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P20188100668"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P40117100388"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P10204105640"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P41199101245"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P10117100365"} 02-October-2019
{elseif $tpl_inv.sales_number eq "P15117102057"} 25-September-2019
{elseif $tpl_inv.sales_number eq "P15117102058"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P22300100512"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P10115102006"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P15117102058"} 25-September-2019

{elseif $tpl_inv.sales_number eq "P10411103655"} 30-September-2019


{elseif $tpl_inv.sales_number eq "P60109100056"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P10203102738"} 29-September-2019

{elseif $tpl_inv.sales_number eq "P41101100520"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P91201100477"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P60204100340"} 03-Oktober-2019
{elseif $tpl_inv.sales_number eq "P36301100206"} 03-Oktober-2019

{elseif $tpl_inv.sales_number eq "P13411100416"} 26-September-2019

{elseif $tpl_inv.sales_number eq "P21106100081"} 04-Oktober-2019

{elseif $tpl_inv.sales_number eq "P20411102180"} 07-Oktober-2019

{elseif $tpl_inv.sales_number eq "P10204105650"} 07-Oktober-2019

{elseif $tpl_inv.sales_number eq "P10101105289"} 07-Oktober-2019

{elseif $tpl_inv.sales_number eq "P10411102923"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51411100322"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51115100094"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51204100547"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51204100548"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51101100916"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51101100912"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51101100914"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P10411103655"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51101100913"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P51101100915"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P10115102006"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P60199104081"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P60109100056"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P91201100477"} 30-September-2019
{elseif $tpl_inv.sales_number eq "P41101100520"} 30-September-2019

{elseif $tpl_inv.sales_number eq "P10411103657"} 07-Oktober-2019
{elseif $tpl_inv.sales_number eq "P10115102008"} 07-Oktober-2019

{elseif $tpl_inv.sales_number eq "P92188100027"} 07-Oktober-2019

{elseif $tpl_inv.sales_number eq "P90411101015"} 08-Oktober-2019
{elseif $tpl_inv.sales_number eq "P90411101014"} 08-Oktober-2019

{elseif $tpl_inv.sales_number eq "P21106100083"} 04-Oktober-2019

{elseif $tpl_inv.sales_number eq "P15117101764"} 02-October-2019

{elseif $tpl_inv.sales_number eq "P13101100511"} 09-October-2019

{elseif $tpl_inv.sales_number eq "P15109100146"} 07-Desember-2018
{elseif $tpl_inv.sales_number eq "P15101100405"} 15-Januari-2019
{elseif $tpl_inv.sales_number eq "P15109100144"} 07-Desember-2018

{elseif $tpl_inv.sales_number eq "P15117101764"} 02-October-2019

{elseif $tpl_inv.sales_number eq "P36204100168"} 14-October-2019
{elseif $tpl_inv.sales_number eq "P10109104112"} 14-October-2019
{elseif $tpl_inv.sales_number eq "P20115100235"} 16-October-2019

{elseif $tpl_inv.sales_number eq "P20101101379"} 17-October-2019

{elseif $tpl_inv.sales_number eq "P21411100907"} 17-October-2019

{elseif $tpl_inv.sales_number eq "P20411016875"} 17-October-2019

{elseif $tpl_inv.sales_number eq "P20411016875"} 17-October-2019

{elseif $tpl_inv.sales_number eq "P20411102471"} 26-October-2019

{elseif $tpl_inv.sales_number eq "P21115100246"} 26-October-2019

{elseif $tpl_inv.sales_number eq "P50202103842"} 23-October-2019

{elseif $tpl_inv.sales_number eq "P90411100799"} 24-October-2019

{elseif $tpl_inv.sales_number eq "P13115100313"} 25-October-2019

{elseif $tpl_inv.sales_number eq "P32203100522"} 29-October-2019


{elseif $tpl_inv.sales_number eq "P32203100522"} 29-October-2019

{elseif $tpl_inv.sales_number eq "P50411100745"} 29-October-2019

{elseif $tpl_inv.sales_number eq "P10203102803"} 30-October-2019

{elseif $tpl_inv.sales_number eq "P10203102803"} 30-October-2019

{elseif $tpl_inv.sales_number eq "P50411101749"} 29-October-2019

{elseif $tpl_inv.sales_number eq "P21411100063"} 31-October-2019

{elseif $tpl_inv.sales_number eq "P20303100061"} 05-November-2019


{elseif $tpl_inv.sales_number eq "P40101100938"} 31-October-2019
{elseif $tpl_inv.sales_number eq "P60301100692"} 31-October-2019

{elseif $tpl_inv.sales_number eq "P51101100555"} 05-November-2019

{elseif $tpl_inv.sales_number eq "P10411103418"} 31-October-2019

{elseif $tpl_inv.sales_number eq "P90101103715"} 08-November-2019

{elseif $tpl_inv.sales_number eq "P80411100801"} 31-October-2019

{elseif $tpl_inv.sales_number eq "P18101100415"} 13-November-2019

{elseif $tpl_inv.sales_number eq "P91301100890"} 15-November-2019

{elseif $tpl_inv.sales_number eq "P13301100640"} 31-October-2017

{elseif $tpl_inv.sales_number eq "P91201100516"} 14-November-2019

{elseif $tpl_inv.sales_number eq "P10401100154"} 14-November-2019

{elseif $tpl_inv.sales_number eq "P20411100504"} 25-November-2019

{elseif $tpl_inv.sales_number eq "P50302100093"} 25-November-2019

{elseif $tpl_inv.sales_number eq "P20411102512"} 27-November-2019

{elseif $tpl_inv.sales_number eq "P90411100091"} 29-November-2019

{elseif $tpl_inv.sales_number eq "P50203107980"} 29-November-2019

{elseif $tpl_inv.sales_number eq "P10101106798"} 29-November-2019

{elseif $tpl_inv.sales_number eq "P13303100129"} 04-Desember-2019

{elseif $tpl_inv.sales_number eq "P18115100053"} 08-December-2015

{elseif $tpl_inv.sales_number eq "P18302100100"} 11-February-2019
{elseif $tpl_inv.sales_number eq "P13101100635"} 04-Desember-2019

{elseif $tpl_inv.sales_number eq "P13109101868"} 17-Desember-2019

{elseif $tpl_inv.sales_number eq "P10188101504"} 23-Desember-2019

{elseif $tpl_inv.sales_number eq "P10104100758"} 20 December 2019
{elseif $tpl_inv.sales_number eq "P40199102721"} 31 Oktober 2019
{elseif $tpl_inv.sales_number eq "P22121100039"} 05 November 2019

{elseif $tpl_inv.sales_number eq "P50202103983"} 18 January 2020
{elseif $tpl_inv.sales_number eq "P50107100223"} 27 December 2019 


{elseif $tpl_inv.sales_number eq "P90411100733"} 20-February-2020
{elseif $tpl_inv.sales_number eq "P90115100381"} 21-February-2020
{elseif $tpl_inv.sales_number eq "P90115100380"} 20-February-2020
{elseif $tpl_inv.sales_number eq "P90115100382"} 19-February-2020
{elseif $tpl_inv.sales_number eq "P90115100384"} 20-February-2020
{elseif $tpl_inv.sales_number eq "P13201102044"} 15-July-2019
{elseif $tpl_inv.sales_number eq "P13423100101"} 29-April-2020

{elseif $tpl_inv.sales_number eq "P20101100948"} 26-February-2015

{elseif $tpl_inv.sales_number eq "P13301101991"} 26-May-2020

{elseif $tpl_inv.sales_number eq "P13417100001"} 01-Juni-2020

{elseif $tpl_inv.sales_number eq "P13201102287"} 03-Agustus-2020
{elseif $tpl_inv.sales_number eq "P13201102300"} 04-September-2020
 
{elseif $tpl_inv.sales_number eq "P13201102306"} 16 September 2020

	{else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
	 	 <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
		  <tr><td width="35%">&nbsp;
	 	  <!-- <td><img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" /> -->
		  {if $tpl_inv.sales_number eq  "P10411101990" or $tpl_inv.sales_number eq  "P144631000s03" or $tpl_inv.sales_number eq  "P1446210s0003"}{else}
		<td><img src="{$qr_link}" width="80" height="80" /> {/if}
	 	 <tr><td width="35%">&nbsp;
	 	  <td>Electronically Signed By, 
		  {if $tpl_inv.sales_number eq "P101151017772019070310000321" 
		  or $tpl_inv.sales_number eq "P10411103015"}
		  fitri.hapsari{elseif $tpl_inv.sales_number eq "P10411101990"}{$tpl_inv.esign.username}{else}{$tpl_inv.esign.username}{/if}
		  <tr><td width="35%">&nbsp;
	 	  <td>Signature: {$tpl_inv.esign.signature}
		</table>
	{else}




	 <table border="0" width="100%" cellspacing="2" cellpadding="2">
	  	<tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name}, {if $tpl_inv.sales_number eq  "P52411100099" or $tpl_inv.sales_number eq "P10408100257"} 30-October-2017  
		
			 {elseif $tpl_inv.sales_number eq "P10302100094"} 08-January-2016
			 {elseif $tpl_inv.sales_number eq "P10301103465"} 11-January-2016
			
		
		{else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
	 	 <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
		 <tr><td width="35%">&nbsp;
		  <!-- <td><img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" /> -->
		<!-- Modified by Rachmat Rizkihadi 25-02-2016 -->
		<!-- Oknum, Sebelumnya QRCode & Signature di Remark (Tidak digunakan) -->
		{if $tpl_inv.sales_number eq  "P14423100013" or $tpl_inv.sales_number eq  "P1446310000s3" or $tpl_inv.sales_number eq  "P14462100s003"}{else}
		 <td><img src="{$qr_link}" width="80" height="80" />{/if}
	 	 <tr><td width="35%">&nbsp;
		 <tr><td width="35%">&nbsp;
		 <tr><td width="35%">&nbsp;
	 	 <td>Autorized name,signature and Stamp {$tpl_inv.esign.username}
		 <tr><td width="35%">&nbsp;
	 	 <td>Signature: {$tpl_inv.esign.signature}
		</table>

	{/if}
{/if}
	{*}
    {if $tpl_inv.dept eq "CS" and $tpl_inv.insurance_product_code neq "188"}

    	<table border="0" width="100%" cellspacing="2" cellpadding="2">
 	 		<tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name}, 		
	
				{if $tpl_inv.sales_number eq "P18188100364x"
				or $tpl_inv.sales_number eq "P18188100302"
				or $tpl_inv.sales_number eq "P18188100298"
				or $tpl_inv.sales_number eq "P21411100127"
				or $tpl_inv.sales_number eq "P21411100133"
				or $tpl_inv.sales_number eq "P21411100132"
				or $tpl_inv.sales_number eq "P21411100130"
				or $tpl_inv.sales_number eq "P21115100076"
				or $tpl_inv.sales_number eq "P21115100051"
				or $tpl_inv.sales_number eq "P21115100050"
				or $tpl_inv.sales_number eq "P14109000527"
				or $tpl_inv.sales_number eq "P14109000284"
				or $tpl_inv.sales_number eq "P14109100023"
				or $tpl_inv.sales_number eq "P10399100322"}
					06-November-2014
				{elseif $tpl_inv.sales_number eq "P19101100007" or $tpl_inv.sales_number eq "P31188100113"}
					19-Mei-2014
				{elseif $tpl_inv.sales_number eq "P10188100989" or $tpl_inv.sales_number eq "P31188100115" or $tpl_inv.sales_number eq "P21301100166"}
					21-February-2012
				{elseif $tpl_inv.sales_number eq "P32188100059"}
					23 Mei 2014
				{else}
				 	{$smarty.now|date_format:"%d-%B-%Y"}
				{/if}

	 	 	<tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk./</b>
	 		 <!-- <tr><td width="35%">&nbsp;   <td>  <img src="http://10.11.12.6/DEV/nextg-repo2/chart7777.png" width="80" height="80" /> -->
	   		 <img src="{$qr_link}" width="80" height="80" />
	 		 <tr><td width="35%">&nbsp;   <td>Electronically Signed By {$tpl_inv.esign.username}
	 		 <tr><td width="35%">&nbsp;   <td>Signature: {$tpl_inv.esign.signature}
 	 	</table>
	 
	{elseif $tpl_inv.back_office_code eq "51" and $tpl_inv.insurance_product_code eq "188"}
	 	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		 	<tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name}, 		
		
				{if $tpl_inv.sales_number eq "P60401100001" or $tpl_inv.sales_number eq "P31188100115" or $tpl_inv.sales_number eq "P10195100773" or $tpl_inv.sales_number eq "P31188100115" or $tpl_inv.sales_number eq "P10195100771" or $tpl_inv.sales_number eq "P10195100772"}
					05-September-2014
				{elseif $tpl_inv.sales_number eq "P18188100298"}
					06-November-2014 
				{elseif $tpl_inv.sales_number eq "P10306100081"} 
					21-February-2012
				{elseif $tpl_inv.sales_number eq "P10203101133"}
					19-May-2014 
				{else}
					{$smarty.now|date_format:"%d-%B-%Y"}
				{/if}

			 <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
				 <!-- <tr><td width="35%">&nbsp;   <td>  <img src="http://10.11.12.6/DEV/nextg-repo2/chart7777.png" width="80" height="80" /> -->
				 <img src="{$qr_link}" width="80" height="80" />
				 <tr><td width="35%">&nbsp;   <td>Electronically Signed By {$tpl_inv.esign.username}
				 <tr><td width="35%">&nbsp;   <td>Signature: {$tpl_inv.esign.signature}
			 </table>
    {else}
		{if $tpl_inv.group eq "CS" or ($tpl_inv.sales_number neq "P18188100306" or $tpl_inv.sales_number eq "P18188100302" or $tpl_inv.sales_number eq "P18188100298" 
		or $tpl_inv.sales_number eq "P18188100278" or $tpl_inv.sales_number eq "P10501101598" or $tpl_inv.sales_number eq "P10501101615" or $tpl_inv.sales_number eq "P91188100885"
	 	or $tpl_inv.sales_number eq "P10501101603" or $tpl_inv.sales_number eq "P10501101613" or $tpl_inv.sales_number eq "P10501101614"
		or $tpl_inv.sales_number eq "P10107100102"
		or $tpl_inv.sales_number eq "P10501101612"
		or $tpl_inv.sales_number eq "P91188100885"
		or $tpl_inv.sales_number eq "P18188100s353")}
	        <table border="0" width="100%" cellspacing="2" cellpadding="2">
		 	 <tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name},{if $tpl_inv.sales_number eq  "P18188100298" or $tpl_inv.sales_number eq "P18188100301" or $tpl_inv.sales_number eq "P18188100302" or $tpl_inv.sales_number eq "P18188100278" or $tpl_inv.sales_number eq "P18188100294"} 06-November-2014  {else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
		 	 <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
	 		 <tr><td width="35%">&nbsp;   <td><img src="{$qr_link}" width="80" height="80" />
	   		 <!-- <img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" /> -->
	 		 <tr><td width="35%">&nbsp;   <td>Electronically Signed By {$tpl_inv.esign.username}
	 		 <tr><td width="35%">&nbsp;   <td>Signature: {$tpl_inv.esign.signature}
	 	 	</table>

		{elseif $tpl_inv.sales_number eq "P60104100006" and $tpl_inv.sales_number eq "P19188100031"}
			<table border="0" width="100%" cellspacing="2" cellpadding="2">
			 	 <tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name},{if $tpl_inv.sales_number eq  "P10399100322000"} 03-Oktober-2014{else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
			 	 <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
			 	 <tr><td width="35%">&nbsp;   <td><img src="{$qr_link}" width="80" height="80" />
			   	 <!-- <img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" /> -->
			 	 <tr><td width="35%">&nbsp;   <td>Electronically Signed By {$tpl_inv.esign.username}
			 	 <tr><td width="35%">&nbsp;   <td>Signature: {$tpl_inv.esign.signature}
			</table>

		{elseif $tpl_inv.campaign_code eq "MC0000026"}
			<table border="0" width="100%" cellspacing="2" cellpadding="2">
			 	 <tr><td width="5%">&nbsp;<td>{$tpl_inv.back_office_name},{if $tpl_inv.sales_number eq  "P20399100063000"} 31-March-2015{else}{$smarty.now|date_format:"%d-%B-%Y"}{/if}
			 	 <tr><td width="5%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
			 	 	{if $tpl_inv.sales_number eq "P14465100629"}
			 	 		<tr><td width="5%">&nbsp;   <td><img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" />
			 	 	{else}
			 		 <tr><td width="5%">&nbsp;   <td><img src="{$qr_link}" width="80" height="80" />
			 		{/if} 
			   		 <!-- <img src="http://10.11.12.6/DEV/nextg-repo/chart7777.png" width="80" height="80" /> -->
			 		 <tr><td width="5%">&nbsp;   <td>Electronically Signed By {$tpl_inv.esign.username}
			 		 <tr><td width="5%">&nbsp;   <td>Signature: {$tpl_inv.esign.signature}	
			</table>

		{else}
		     <table border="0" width="100%" cellspacing="2" cellpadding="2">
			  <tr><td width="35%">&nbsp;<td>{$tpl_inv.back_office_name},{if $tpl_inv.sales_number eq  "P14315100089x" or $tpl_inv.sales_number eq "P31188100144d"}  29-Oktober-2014{else} {$smarty.now|date_format:"%d-%B-%Y"}{/if}
			  <tr><td width="35%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b>
			
	 		 <tr><td width="35%">&nbsp;<td><br>
	 		 <tr><td valign="bottom" width="35%">&nbsp;<td>{$tpl_inv.office_headname}
	 		 <tr><td width="35%">&nbsp;<td>{$hrlines}
	 		 <tr><td width="35%">&nbsp;<td>Authorized name, signature and stamp.

	 		 </table>        	
	 	{/if}
    {/if}
    {*}

</font>
</table>
{if $tpl_inv.sales_number eq "P14202100011" or $tpl_inv.sales_number eq "P14203100087"}{/if}
{if $tpl_inv.apar_type eq 'AR'}

<table border=1><tr><td>
<p align="justify">



{*if ($tpl_inv.intermediary_type neq '---' or $tpl_inv.intermediary_type neq 'AGENT') and $tpl_inv.back_office_code eq 10 and $tpl_inv.va_count eq 0*}
{if $tpl_inv.va_count eq 0}		

{if $tpl_inv.sales_number eq "P13411100419" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P14104100018"}<font size="0.8">{else}<font size="1">{/if}
Nota ini bukan merupakan bukti pembayaran, setelah melakukan pembayaran agar dimintakan Kwitansi Premi sebagai bukti Pembayaran yang sah.  Setiap pembayaran mohon menyebutkan no. polis dan bukti transfer harap di fax atau hubungi kami melalui telp. atau fax seperti tertera di atas.</font></p>
<p align="justify">{if $tpl_inv.sales_number eq "P13411100419" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P14104100018"}<font size="0.8">{else}<font size="1">{/if}
The note is not showing the payment confirmation, after made the payment please ask for the Premium Receipt the legal payment confirmation.  Please refer to policy number for every settlement and fax your, transfer slip or contact us at the numbers mentioned as above.</font></p>
{else}

{if $tpl_inv.sales_number eq "P13411100419" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P13303100194" or $tpl_inv.sales_number eq "P13115100530" or $tpl_inv.sales_number eq "P31411100053" or $tpl_inv.sales_number eq "P36301100013"}<font size="0.8">{else}<font size="1">{/if}

{if $tpl_inv.finpay_paymentcode neq '' and ($tpl_inv.intermediary_type eq "AGENT" or $tpl_inv.intermediary_type eq "---" or $tpl_inv.intermediary_type eq "") and ($gvgp eq "GP01" or $gvgp eq "GV01" or $gvgp eq "GA01" or $gvgp eq "GVGP")}
			
Cara pembayaran rekening virtual account dan finpay ada pada halaman terpisah. Nota ini bukan merupakan bukti pembayaran. Setelah melakukan pembayaran agar dimintakan kuitansi premi sebagai bukti pembayaran yang sah. Mohon menyebutkan nomor polis disetiap pembayaran dan bukti transfer ke kirim melalui email di payment@asuransibintang.com atau fax di 021 769 8215. Untuk informasi lebih lanjut, hubungi Bintang Call Center di 1500 481.</font></p>
<p align="justify">			
{if $tpl_inv.sales_number eq "P36301100013" or $tpl_inv.sales_number eq "P13303100194" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P13115100530" or $tpl_inv.sales_number eq "P31411100053" or $tpl_inv.sales_number eq "P31411100045"}<font size="0.8">{else}<font size="1">{/if}
The procedure of virtual account and finpay payment are on separate pages. This note is not showing the payment confirmation. After made the payment, please ask for the premium receipt as the legal payment confirmation. Kindly mention the policy number in the transfer slip and send it by email to payment@asuransibintang.com or fax at 021 769 8215. For more information, please contact Bintang Call Center at 1500 481.</font></p>

{else}

Cara pembayaran rekening virtual account ada di balik halaman ini. Nota ini bukan merupakan bukti pembayaran. Setelah melakukan pembayaran agar dimintakan kuitansi premi sebagai bukti pembayaran yang sah. Mohon menyebutkan nomor polis disetiap pembayaran dan bukti transfer ke kirim melalui email di payment@asuransibintang.com atau fax di 021 769 8215. Untuk informasi lebih lanjut, hubungi Bintang Call Center di 1500 481.</font></p>
<p align="justify">			
{if $tpl_inv.sales_number eq "P36301100013" or $tpl_inv.sales_number eq "P13115100209" or $tpl_inv.sales_number eq "P13303100194" or $tpl_inv.sales_number eq "P13115100530" or $tpl_inv.sales_number eq "P31411100053" or $tpl_inv.sales_number eq "P31411100045"}<font size="0.8">{else}<font size="1">{/if}
The procedure of virtual account payment is at the back of this page. This note is not showing the payment confirmation. After made the payment, please ask for the premium receipt as the legal payment confirmation. Kindly mention the policy number in the transfer slip and send it by email to payment@asuransibintang.com or fax at 021 769 8215. For more information, please contact Bintang Call Center at 1500 481.</font></p>

{/if}

{/if}

</table>

{if $tpl_inv.apar_type eq 'AP'}
<!--<div align="right"><font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code}({$tpl_inv.payment_client_name - {$tpl_inv.payment_client_code}){elseif $tpl_inv.transaction_type eq "Insurance commission agent"} ({$tpl_inv.payment_client_code}) {/if}</b></font></div>-->
<div align="right"><font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code}({$tpl_inv.payment_client_code}){elseif $tpl_inv.transaction_type eq "Insurance commission agent"} ({$tpl_inv.payment_client_code}) {/if}</b></font></div>
{else}
<!--<font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code} ({$tpl_inv.payment_client_name} - {$tpl_inv.payment_client_code}) {else} ({$tpl_inv.payment_client_code}) {/if}</b>-->
<font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code} ({$tpl_inv.payment_client_code}) {else} ({$tpl_inv.payment_client_code}) {/if}</b>
{/if}
</div>
{if $tpl_inv.is_agent neq "t" and $tpl_inv.intermediary_type neq 'AGENT'}
<div align="left"><font size="1"><b>{if $tpl_inv.payment_client_code ne $tpl_inv.invoice_client_code }AO : {$tpl_inv.sales_person|capitalize} {/if}</b></font></div><br />
{/if}
{/if}

<!-- vtr komisi oknum print K-->
{if $tpl_inv.apar_type eq 'AR'}
<br/><br/><br/>
{if $tpl_inv.sales_number eq "P10411103580001" or $tpl_inv.sales_number eq "P10115101974001" }
<table border="0" width="100%">
<tr>
	<td align='right'><b>{$tpl_inv.vtr_k}</b></td>
</tr>
</table>
{else}
{/if}
{/if}

<!-- vtr>> -->

{if $tpl_inv.apar_type eq "AR"} 
{if $tpl_inv.transaction_type eq 'Insurance premium'}
<!--PAGE BREAK-->
{assign var="premium" value=""}
{foreach from=$tpl_inv.lines item=l name=invlines}
	{if $l.transaction_origin eq "Premium revenue"}
		{assign var="premium" value=$l.transaction_amount}
	{/if}
{/foreach}	

<!--print here-->
{foreach from=$tpl_inv.faktur item=o name=invfaktur}

<table border="0" width="100%" cellpadding="0" cellspacing="0">

<!-- header of the invoice starts here -->
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<!-- <tr><td align=left colspan=2><img src="../../../../images/bintang_logo.gif"> --> <!-- clo -->
<tr><td colspan=2><font size="1"><b>PT. Asuransi Bintang Tbk.</b></font> 
<tr><td colspan=2><font size="1">Cabang {$tpl_inv.back_office_name}</font>
<tr><td colspan=2><font size="1">{$tpl_inv.boffice.0.address}</font>
<tr><td colspan=2><font size="1">Phone: {$tpl_inv.boffice.0.telephone}  Fax: {$tpl_inv.boffice.0.fax}</font>
<tr><td colspan=2><font size="1">Email: {$tpl_inv.boffice.0.email}</font>
<tr><td colspan="2">&nbsp;
</table>
<font size="2">
<table border="0" width="100%" cellspacing="3" cellpadding="3">

<!-- header of the faktur starts here -->
<tr>
<td align="left" width="40%">&nbsp;
<td width="10%">TO :<td align="left" width="50%">{$o.name}
</table>

<br><br>

<table border="1" width="100%" cellpadding="3">
<tr bgcolor="#dedede">
<th align="center" width="20%">Intermediary Code
<th align="center" width="15%">Policy Number
<th align="center" width="35%">Remark
<th align="center" width="20%">Debit
<th align="center" width="20%">Credit

<tr>
<td align="center">{$o.intermediary_code} 
<td align="center">{$tpl_inv.sales_number}
<td><table width="100%">
	<tr>
	  <td colspan="3" align="justify">Premium Co. Insurance Policy in The Name of {$tpl_inv.cconame} {$tpl_inv.ccbname}
	<tr>
	  <td width="35%">Your Share
	  <td width="1%">:
	  <td width="64%" align="left">{$o.share_percentage|number_format:"2"}%</table>
<td align="right">{$tpl_inv.transaction_currency} 0.00
<td align="right" valign="bottom">{$tpl_inv.transaction_currency} {$total_setelah_discount*$o.share_percentage/100|number_format:"3"}
</table>

<br />

<table border="0" width="100%" cellpadding="3">
<tr>
<td width="50%">&nbsp;
<td width="25%">Due To You
<td width="25%" align="right">{$tpl_inv.transaction_currency} {$total_setelah_discount*$o.share_percentage/100|number_format:"3"}
</table>

<br />

{assign var="tosay" value=$premium*$o.share_percentage/100}
<table border="0" width="100%" cellpadding="3">
<tr>
<td width="5%" valign="top">SAY
<td width="1%" valign="top">:
<td width="44%" align="left">{if $premium lt 0}{numtotextid|capitalize input=$tosay*-1}{else}{numtotextid|capitalize input=$total_setelah_discount*$o.share_percentage/100}{/if}{if $tpl_inv.transaction_currency eq 'IDR'}&nbsp;Rupiah{/if}
<td width="50%">&nbsp;
</table>

<br />

<table border="0" width="100%" cellspacing="3" cellpadding="3">
<tr><td width="50%">&nbsp;<td><br><br>
<tr><td width="50%">&nbsp;<td>{$tpl_inv.back_office_name}{if $tpl_inv.sales_number eq "P10115101777" or $tpl_inv.sales_number eq "P10411102999" or $tpl_inv.sales_number eq "P51411100306"},28-Juni-2019
{elseif $tpl_inv.sales_number eq "P90411100735"} 19-February-2020
{elseif $tpl_inv.sales_number eq "P90115100386"} 21-February-2020
 {else},{$smarty.now|date_format:"%d-%B-%Y"}{/if}

<tr><td width="50%">&nbsp;<td><b>PT. Asuransi Bintang Tbk.</b> 
</table>
</font>
<!--PAGE BREAK-->
{/foreach}
{/if}{/if}

</body>
</html>


<?php if (empty($_GET["team"])){$team = 0;}else{$team = $_GET["team"];} ?>
<?php $dateto=date('m/d/Y');?>
<?php $yearnow=date('Y');?>
<?php $datefrom='01/01/'.$yearnow;?>
<?php if (empty($_GET["tglawal"])){
$tglawal=$yearnow.'-01-01';
$tglakhir=date('Y-m-d');
}else{
$tglawal=$_GET["tglawal"];
$tglakhir=$_GET["tglakhir"];

}?>
<?php if (empty($_GET["status"])){
$status='no';
}else{
$status=$_GET["status"];
}?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>DASHBOARD UW</title>
		
		<!-- stylesheets -->
		<link href="<?php echo $HomeUrl;?>assets/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeUrl;?>assets/style.css" rel="stylesheet">
		<link href="<?php echo $HomeUrl;?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- scripts -->
		
		<!--[if lt IE 9 ]> 
		<script src="/assets/js/html5shiv.min.js"></script>
		<script src="/assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!--script src="/assets/js/	"></script-->
		<script src="<?php echo $HomeUrl;?>assets/js/jquery-1.12.4.min.js"></script>
		<script src="<?php echo $HomeUrl;?>assets/js/bootstrap.min.js"></script>
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		  <link rel="stylesheet" href="/resources/demos/style.css">
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		  <script>
		  	function change_formatphp(date){
		  		  var date = date;
		  		  var initial = date.split(/\//);
				  return [ initial[2], initial[0], initial[1] ].join('-'); //=> 'mm/dd
		  	}
		  	function change_formatjs(date){
		  		  var date = date;
		  		  var initial = date.split('-');
				  return [ initial[1], initial[2], initial[0] ].join('/'); //=> 'mm/dd
		  	}
			$( document ).ready(function() {
				  var tglawal = '<?php echo $tglawal;?>';
				  var tglakhir = '<?php echo $tglakhir;?>';
				  var status = '<?php echo $status;?>';
				  var team = '<?php echo $team;?>';
				  document.getElementById("datepickerawal").value = change_formatjs(tglawal); 
				  document.getElementById("datepickerakhir").value = change_formatjs(tglakhir);  
				 
			    $("#datepickerawal").datepicker({ 
			        format: 'yyyy-mm-dd'
			    });
			    
			    $("#datepickerawal").on("change", function () {
			        var fromdate = $(this).val();
			        if(team==3){
			        var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw_team3_3.php?team='+team;
			           link +='&tglawal='+change_formatphp(fromdate)+'&tglakhir='+tglakhir+'&status='+status;
			        var win = location.replace(link);
			    	}else if(team==2){
			        var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw_team2_3.php?team='+team;
			           link +='&tglawal='+change_formatphp(fromdate)+'&tglakhir='+tglakhir+'&status='+status;
			        var win = location.replace(link);
			    	}else{
			    	var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw.php?team='+team;
			           link +='&tglawal='+change_formatphp(fromdate)+'&tglakhir='+tglakhir+'&status='+status;
			        var win = location.replace(link);
			    	}

			    });
			    $("#datepickerakhir").datepicker({ 
			        format: 'yyyy-mm-dd'
			    });
			    $("#datepickerakhir").on("change", function () {
			        var todate = $(this).val();
			        if(team==3){
			        var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw_team3_3.php?team='+team;
			           link +='&tglawal='+tglawal+'&tglakhir='+change_formatphp(todate)+'&status='+status;
			        var win = location.replace(link);
			    	}else if(team==2){
			        var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw_team2_3.php?team='+team;
			           link +='&tglawal='+tglawal+'&tglakhir='+change_formatphp(todate)+'&status='+status;
			        var win = location.replace(link);
			    	}else{
			    	var link='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/bar_chart_uw.php?team='+team;
			           link +='&tglawal='+tglawal+'&tglakhir='+change_formatphp(todate)+'&status='+status;
			        var win = location.replace(link);
			    	}
			    });
			}); 
			</script>
		
		<script>
			$(function () {
				// #sidebar-toggle-button
				$('#sidebar-toggle-button').on('click', function () {
						$('#sidebar').toggleClass('sidebar-toggle');
						$('#page-content-wrapper').toggleClass('page-content-toggle');	
						fireResize();					
				});
				
				// sidebar collapse behavior
				$('#sidebar').on('show.bs.collapse', function () {
					$('#sidebar').find('.collapse.in').collapse('hide');
				});
				
				// To make current link active
				var pageURL = $(location).attr('href');
				var URLSplits = pageURL.split('/');

				//console.log(pageURL + "; " + URLSplits.length);
				//$(".sub-menu .collapse .in").removeClass("in");

				if (URLSplits.length === 5) {
					var routeURL = '/' + URLSplits[URLSplits.length - 2] + '/' + URLSplits[URLSplits.length - 1];
					var activeNestedList = $('.sub-menu > li > a[href="' + routeURL + '"]').parent();

					if (activeNestedList.length !== 0 && !activeNestedList.hasClass('active')) {
						$('.sub-menu > li').removeClass('active');
						activeNestedList.addClass('active');
						activeNestedList.parent().addClass("in");
					}
				}

				function fireResize() {
					if (document.createEvent) { // W3C
						var ev = document.createEvent('Event');
						ev.initEvent('resize', true, true);
						window.dispatchEvent(ev);
					}
					else { // IE
						element = document.documentElement;
						var event = document.createEventObject();
						element.fireEvent("onresize", event);
					}
            	}
			})
		</script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				<style>
		a {
		  text-decoration: none;
		  display: inline-block;
		  padding: 8px 16px;
		}

		a:hover {
		  background-color: #ddd;
		  color: black;
		}

		.previous {
		  background-color: #f1f1f1;
		  color: black;
		}

		.next {
		  background-color: #4CAF50;
		  color: white;
		}

		.round {
		  border-radius: 50%;
		}
		</style>
	</head>
	
	<body>
		<!-- header -->
		<nav id="header" class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<div id="sidebar-toggle-button">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</div>
					<div class="brand">
						
						<a href="<?php echo BaseURL() ;?>link_chart_uw.php"  class="next"><span class="hidden-xs text-muted">Menu</span></a>

					</div>
					
				</div>
			</div>
		</nav> 

		<!-- /header -->         

<?php
function enclink($paramencrypt) {
    $key='hanif';
    $enckey=urlencode(base64_encode($key));
    $denc= base64_decode(urldecode($paramencrypt));
    str_replace($enckey,"",$denc);
    return str_replace($enckey,"",$denc);
}

function BaseURL() {
	$baseUrl='http://dashboard.asuransibintang.com/dashboard/chart/chart-types/';
    return $baseUrl;
}

function HomeUrl() {
	$HomeUrl='http://dashboard.asuransibintang.com/dashboard/chart/';
    return $HomeUrl;
}
?>
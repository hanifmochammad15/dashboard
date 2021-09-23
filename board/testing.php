<!DOCTYPE HTML>
<html>
<head> 
	<script src="http://dashboard.asuransibintang.com/board/plugins/jquery/jquery.min.js"></script>
</head>
<body>
	<?php $year_now=2020;?>
	<?php $year_prev=2019;?>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
<script type="text/javascript">
window.onload = function () {
	load_cp_chart();
}
function load_cp_chart(){
	//alert('hanif');
  var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json/'; ?>";
  //	alert(link);

  var year_now="<?php echo $year_now; ?>";
  var year_prev="<?php echo $year_prev; ?>";
  var dataPointscp_prev = [];
  var dataPointscp_now = [];
  var bar_cp=1;
 
  CanvasJS.addColorSet("chartContainercpColor",
                  [//colorSet Array
                  // "#38a445",
                  // "#4F81BC"   
                  '#FF8C00',
                  '#FFD700'     
                  ]);
  var chart_cp = new CanvasJS.Chart("chartContainer", {
    colorSet: "chartContainercpColor",

    animationEnabled: true,
  title:{
    text: "Comparative productivity " + year_prev +" vs "+year_now
  },  
  axisY: {
    title: "Policy/month",
    titleFontColor: "#4F81BC",
    lineColor: "#4F81BC",
    labelFontColor: "#4F81BC",
    tickColor: "#4F81BC"
  },
  axisY2: {
    title: "Policy/month",
    titleFontColor: "#468847",
    lineColor: "#468847",
    labelFontColor: "#468847",
    tickColor: "#468847"
  },  
  toolTip: {
    shared: true
  },
  legend: {
    cursor:"pointer",
    //itemclick: toggleDataSeries
  },
        data: [
    {
      type: "column",
      name: year_prev,
      legendText: year_prev,
      showInLegend: true, 
      dataPoints:dataPointscp_prev
    },
    {
      type: "column", 
      name: year_now,
      legendText: year_now,
      //axisYType: "secondary",
      showInLegend: true,
      dataPoints:dataPointscp_now
    }
    ]
});

  $.ajax({
    url : link+'json_chart_compare.php',
    method : "POST",
    data : {bar_cp: bar_cp},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){
      // alert('hanif');
             //alert(data[year_prev].length);
                for (var i = 0; i < data[year_prev].length; i++) {
                        dataPointscp_prev.push({
                          label: data[year_prev][i].label,
                          y: data[year_prev][i].y
                        });
                      }
                 for (var i = 0; i < data[year_now].length; i++) {
                        dataPointscp_now.push({
                          label: data[year_now][i].label,
                          y: data[year_now][i].y
                        });
                      }


        chart_cp.render();
          $('.canvasjs-chart-credit').html('');

      }
  });


function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart_cp.render();
}


}

</script>
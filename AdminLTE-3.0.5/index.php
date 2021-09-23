<?php include 'header.php'; ?>
<?php

$tglawal='2020-01-01';
$tglakhir='2020-09-17';
// $data = array("tglawal"=>$tglawal ,"tglakhir"=>$tglakhir);
// $send = curl("http://dashboard.asuransibintang.com/dashboard/AdminLTE-3.0.5/json_chart.php",json_encode($data));
// $dataPoints =  $send;    
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include 'navbar.php'; ?>

<?php include 'sidebar.php'; ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
      
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
             <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pilih Tanggal</h3>
              </div>
              <div class="card-body">
                <!-- Date -->
                <div class="row">
                  <div class="col-lg-6">
                   <div class="form-group">
                  <label>Tgl Awal:</label>
                    <div class="input-group date" id="tglawal" data-target-input="nearest">
                        <input type="text" id="input-tglawal" class="form-control datetimepicker-input" data-target="#tglawal"/>
                        <div class="input-group-append" data-target="#tglawal" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <!-- /.form group -->
              </div>

                  <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tgl Akhir:</label>
                      <div class="input-group date" id="tglakhir" data-target-input="nearest">
                          <input type="text" id="input-tglakhir" class="form-control datetimepicker-input" data-target="#tglakhir"/>
                          <div class="input-group-append" data-target="#tglakhir" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
                <!-- /.form group -->
              </div>

            </div>

              </div>
              <!-- /.card-body -->
            </div>
          </section>
          <section class="col-lg-6 connectedSortable">
          </section>
          <section class="col-lg-6 connectedSortable">
             <!-- DONUT CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerStatusOpp" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerStatus" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6 connectedSortable">


             <!-- DONUT CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerSla" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerStages" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>


          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!--
<script src="plugins/chart.js/Chart.min.js"></script>
-->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>



<script>
  $( document ).ready(function() {
  var tglawal = '<?php echo $tglawal;?>';
  var tglakhir = '<?php echo $tglakhir;?>';
  var status = '<?php echo $status;?>';
  var team = '<?php echo $team;?>';
  var actual_link2 ='<?php echo  $actual_link2;?>';
  //alert(actual_link2);
  document.getElementById("input-tglawal").value =change_formatjs(tglawal); 
  document.getElementById("input-tglakhir").value = change_formatjs(tglakhir);

});

$('#tglawal').datetimepicker({
    format: 'L'
});

$('#tglakhir').datetimepicker({
    format: 'L'
});


$("#tglawal").on("change.datetimepicker", function (e) {
    // if (e.oldDate !== e.date) {
    //     alert('You picked: ' + new Date(e.date).toLocaleDateString('en-US'))
    // }
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var dateawal=date_js(new Date(e.date));
    var newdate= change_formatphp(dateawal);
    var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/dashboard/AdminLTE-3.0.5/json/'; ?>";

    //sumarry OTRS Status Ticket
    var dataPoints = [];
    var summary_otrs=1;
    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      title: {
        text: "Summmary OTRS TICKET"
      },
      subtitles: [{
             text: newdate + ' -- '+ tglakhir +' (yyyy-mm-dd)'
        }],
      data: [{
        type: "pie",
        startAngle: 240,
        yValueFormatString: "##0.00\"%\"",
        indexLabel: "{label} {y}",
        dataPoints: dataPoints,
      }]
    });

    //sumarry OTRS Stage Ticket
    var dataPointsStage = [];
    var summary_otrs_stage=1;
    var chartStage = new CanvasJS.Chart("chartContainerStages", {
        animationEnabled: true,
        title: {
            text: "Summary Stages Policy"
        },
        subtitles: [{
              text: newdate + ' -- '+ tglakhir +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsStage,
        }]
    });
    //sumarry OTRS SLA
    CanvasJS.addColorSet("chartContainerColor",
                    [//colorSet Array
                    "#e73f3f",
                    "#bd3853",
                    "#38a445",
                    "#fff85b"              
                    ]);
    var dataPointsSla = [];
    var summary_otrs_sla=1;
    var chartSla = new CanvasJS.Chart("chartContainerSla", {
        colorSet: "chartContainerColor",
        animationEnabled: true,
        title: {
            text: "Summary Status SLA"
        },
        subtitles: [{
             text: newdate + ' -- '+ tglakhir +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsSla,
        }]
    });
//Summary Of Closed Tickets Not Found In OPP
    var dataPointsStatusOpp = [];
    var summary_otrs_opp=1;
    var chartStatusOpp = new CanvasJS.Chart("chartContainerStatusOpp", {
        animationEnabled: true,
        title: {
            text: "Summary Of Closed Tickets Not Found In OPP"
        },
        subtitles: [{
              text: newdate + ' -- '+ tglakhir +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsStatusOpp,
        }]
    });
    //sumarry OTRS Status Ticket
    var dataPointsStatus = [];
    var summary_otrs_status=1;
    var chartStatus = new CanvasJS.Chart("chartContainerStatus", {
      animationEnabled: true,
      title: {
        text: "Summmary OTRS Status Policy"
      },
      subtitles: [{
             text: newdate + ' -- '+ tglakhir +' (yyyy-mm-dd)'
        }],
      data: [{
        type: "pie",
        startAngle: 240,
        yValueFormatString: "##0.00\"%\"",
        indexLabel: "{label} {y}",
        dataPoints: dataPointsStatus,
      }]
    });
    if (tglawal !== dateawal) {
         // alert('You picked: ' + date_js(new Date(e.date)));
         var newdate= change_formatphp(dateawal);
         $.ajax({
            url : link + "json_chart_summary.php",
            method : "POST",
            data : {summary_otrs: summary_otrs,tglawal:newdate,tglakhir:tglakhir},
            async : true,
            dataType : 'json',
                cache: false,
            success: function(data){
                     $.each(data, function(key, value){
                     dataPoints.push({label: value.label, y: (value.y)});
                               });
                chart.render();
                  $('.canvasjs-chart-credit').html('');

              }
          });
           //
         $.ajax({
            url :link + "json_chart_summary_stage.php" ,
            method : "POST",
            data : {summary_otrs_stage: summary_otrs_stage,tglawal:newdate,tglakhir:tglakhir},
            async : true,
            dataType : 'json',
            success: function(data){
                     $.each(data, function(key, value){
                     dataPointsStage.push({label: value.label, y: (value.y)});
                               });
                chartStage.render();
                  $('.canvasjs-chart-credit').html('');

              }
          });
         //
         $.ajax({
          url : link +"json_chart_summary_sla.php",
          method : "POST",
          data : {summary_otrs_sla: summary_otrs_sla,tglawal:newdate,tglakhir:tglakhir},
          async : true,
          dataType : 'json',
          success: function(data){
                   $.each(data, function(key, value){
                   dataPointsSla.push({label: value.label, y: (value.y)});
                             });
              chartSla.render();
                $('.canvasjs-chart-credit').html('');

            }
      });
      //
      $.ajax({
        url : link +"json_chart_summary_opp.php",
        method : "POST",
        data : {summary_otrs_opp: summary_otrs_opp,tglawal:newdate,tglakhir:tglakhir},
        async : true,
        dataType : 'json',
        success: function(data){
                 $.each(data, function(key, value){
                 dataPointsStatusOpp.push({label: value.label, y: (value.y)});
                           });
            chartStatusOpp.render();
              $('.canvasjs-chart-credit').html('');

          }
      });
    //
    $.ajax({
    url : link +"json_chart_summary_status.php",
    method : "POST",
    data : {summary_otrs_status: summary_otrs_status,tglawal:newdate,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStatus.push({label: value.label, y: (value.y)});
                       });
        chartStatus.render();
          $('.canvasjs-chart-credit').html('');

      }
  });

    }
});


$("#tglakhir").on("change.datetimepicker", function (e) {
    // if (e.oldDate !== e.date) {
    //     alert('You picked: ' + new Date(e.date).toLocaleDateString('en-US'))
    // }
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var dateakhir=date_js(new Date(e.date));
    var newdate= change_formatphp(dateakhir);
    var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/dashboard/AdminLTE-3.0.5/json/'; ?>";
    //sumarry OTRS Status Ticket
    var dataPoints = [];
    var summary_otrs=1;
    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      title: {
        text: "Summmary OTRS TICKET"
      },
      subtitles: [{
             text: tglawal + ' -- '+ newdate +' (yyyy-mm-dd)'
        }],
      data: [{
        type: "pie",
        startAngle: 240,
        yValueFormatString: "##0.00\"%\"",
        indexLabel: "{label} {y}",
        dataPoints: dataPoints,
      }]
    });

    //sumarry OTRS Stage Ticket
    var dataPointsStage = [];
    var summary_otrs_stage=1;
    var chartStage = new CanvasJS.Chart("chartContainerStages", {
        animationEnabled: true,
        title: {
            text: "Summary Stages Policy"
        },
        subtitles: [{
              text: tglawal + ' -- '+ newdate +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsStage,
        }]
    });
    //sumarry OTRS SLA
    CanvasJS.addColorSet("chartContainerColor",
                    [//colorSet Array
                    "#e73f3f",
                    "#bd3853",
                    "#38a445",
                    "#fff85b"              
                    ]);
    var dataPointsSla = [];
    var summary_otrs_sla=1;
    var chartSla = new CanvasJS.Chart("chartContainerSla", {
        colorSet: "chartContainerColor",
        animationEnabled: true,
        title: {
            text: "Summary Status SLA"
        },
        subtitles: [{
             text: tglawal + ' -- '+ newdate +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsSla,
        }]
    });
    //Summary Of Closed Tickets Not Found In OPP
    var dataPointsStatusOpp = [];
    var summary_otrs_opp=1;
    var chartStatusOpp = new CanvasJS.Chart("chartContainerStatusOpp", {
        animationEnabled: true,
        title: {
            text: "Summary Of Closed Tickets Not Found In OPP"
        },
        subtitles: [{
              text: tglawal + ' -- '+ newdate +' (yyyy-mm-dd)'
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: dataPointsStatusOpp,
        }]
    });
     //sumarry OTRS Status Ticket
    var dataPointsStatus = [];
    var summary_otrs_status=1;
    var chartStatus = new CanvasJS.Chart("chartContainerStatus", {
      animationEnabled: true,
      title: {
        text: "Summmary OTRS Status Policy"
      },
      subtitles: [{
             text: tglawal + ' -- '+ newdate +' (yyyy-mm-dd)'
        }],
      data: [{
        type: "pie",
        startAngle: 240,
        yValueFormatString: "##0.00\"%\"",
        indexLabel: "{label} {y}",
        dataPoints: dataPointsStatus,
      }]
    });
    if (tglakhir !== dateakhir) {
         // alert('You picked: ' + date_js(new Date(e.date)));
         $.ajax({
            url : link + "json_chart_summary.php",
            method : "POST",
            data : {summary_otrs: summary_otrs,tglawal:tglawal,tglakhir:newdate},
            async : true,
            dataType : 'json',
                cache: false,
            success: function(data){
                     $.each(data, function(key, value){
                     dataPoints.push({label: value.label, y: (value.y)});
                               });
                chart.render();
                  $('.canvasjs-chart-credit').html('');

              }
          });
         //
         $.ajax({
            url :link + "json_chart_summary_stage.php" ,
            method : "POST",
            data : {summary_otrs_stage: summary_otrs_stage,tglawal:tglawal,tglakhir:newdate},
            async : true,
            dataType : 'json',
            success: function(data){
                     $.each(data, function(key, value){
                     dataPointsStage.push({label: value.label, y: (value.y)});
                               });
                chartStage.render();
                  $('.canvasjs-chart-credit').html('');

              }
          });
         //
        $.ajax({
        url : link +"json_chart_summary_sla.php",
        method : "POST",
        data : {summary_otrs_sla: summary_otrs_sla,tglawal:tglawal,tglakhir:newdate},
        async : true,
        dataType : 'json',
        success: function(data){
                 $.each(data, function(key, value){
                 dataPointsSla.push({label: value.label, y: (value.y)});
                           });
            chartSla.render();
              $('.canvasjs-chart-credit').html('');

          }
      });
      //
      $.ajax({
        url : link +"json_chart_summary_opp.php",
        method : "POST",
        data : {summary_otrs_opp: summary_otrs_opp,tglawal:tglawal,tglakhir:newdate},
        async : true,
        dataType : 'json',
        success: function(data){
                 $.each(data, function(key, value){
                 dataPointsStatusOpp.push({label: value.label, y: (value.y)});
                           });
            chartStatusOpp.render();
              $('.canvasjs-chart-credit').html('');

          }
      });
    //
    $.ajax({
    url : link +"json_chart_summary_status.php",
    method : "POST",
    data : {summary_otrs_status: summary_otrs_status,tglawal:tglawal,tglakhir:newdate},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStatus.push({label: value.label, y: (value.y)});
                       });
        chartStatus.render();
          $('.canvasjs-chart-credit').html('');

      }
  });

    }
});

</script>

<script>


window.onload = function() {


var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/dashboard/AdminLTE-3.0.5/json/'; ?>";
var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);

//sumarry OTRS Status Ticket
var dataPoints = [];
var summary_otrs=1;
var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  title: {
    text: "Summmary OTRS TICKET"
  },
  subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
  data: [{
    type: "pie",
    startAngle: 240,
    yValueFormatString: "##0.00\"%\"",
    indexLabel: "{label} {y}",
    dataPoints: dataPoints,
  }]
});
$.ajax({
    url : link + "json_chart_summary.php",
    method : "POST",
    data : {summary_otrs: summary_otrs,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){
             $.each(data, function(key, value){
             dataPoints.push({label: value.label, y: (value.y)});
                       });
        chart.render();
          $('.canvasjs-chart-credit').html('');

      }
  });


//sumarry OTRS STAGE
var dataPointsStage = [];
var summary_otrs_stage=1;
var chartStage = new CanvasJS.Chart("chartContainerStages", {
    animationEnabled: true,
    title: {
        text: "Summary Stages Policy"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: dataPointsStage,
    }]
});

$.ajax({
    url :link + "json_chart_summary_stage.php" ,
    method : "POST",
    data : {summary_otrs_stage: summary_otrs_stage,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStage.push({label: value.label, y: (value.y)});
                       });
        chartStage.render();
          $('.canvasjs-chart-credit').html('');

      }
  });



//sumarry OTRS SLA
CanvasJS.addColorSet("chartContainerColor",
                [//colorSet Array
                "#e73f3f",
                "#bd3853",
                "#38a445",
                "#fff85b"              
                ]);
var dataPointsSla = [];
var summary_otrs_sla=1;
var chartSla = new CanvasJS.Chart("chartContainerSla", {
    colorSet: "chartContainerColor",
    animationEnabled: true,
    title: {
        text: "Summary Status SLA"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: dataPointsSla,
    }]
});

$.ajax({
    url : link +"json_chart_summary_sla.php",
    method : "POST",
    data : {summary_otrs_sla: summary_otrs_sla,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsSla.push({label: value.label, y: (value.y)});
                       });
        chartSla.render();
          $('.canvasjs-chart-credit').html('');

      }
  });



//sumarry OTRS Status Ticket
var dataPointsStatus = [];
var summary_otrs_status=1;
var chartStatus = new CanvasJS.Chart("chartContainerStatus", {
  animationEnabled: true,
  title: {
    text: "Summmary OTRS Status Policy"
  },
  subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
  data: [{
    type: "pie",
    startAngle: 240,
    yValueFormatString: "##0.00\"%\"",
    indexLabel: "{label} {y}",
    dataPoints: dataPointsStatus,
  }]
});
$.ajax({
    url : link +"json_chart_summary_status.php",
    method : "POST",
    data : {summary_otrs_status: summary_otrs_status,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStatus.push({label: value.label, y: (value.y)});
                       });
        chartStatus.render();
          $('.canvasjs-chart-credit').html('');

      }
  });


//Summary Of Closed Tickets Not Found In OPP

var dataPointsStatusOpp = [];
var summary_otrs_opp=1;
var chartStatusOpp = new CanvasJS.Chart("chartContainerStatusOpp", {
    animationEnabled: true,
    title: {
        text: "Summary Of Closed Tickets Not Found In OPP"
    },
    subtitles: [{
         text: "<?php echo $tglawal .' -- '.$tglakhir .' (yyyy-mm-dd)';?>"
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: dataPointsStatusOpp,
    }]
});
$.ajax({
    url : link +"json_chart_summary_opp.php",
    method : "POST",
    data : {summary_otrs_opp: summary_otrs_opp,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStatusOpp.push({label: value.label, y: (value.y)});
                       });
        chartStatusOpp.render();
          $('.canvasjs-chart-credit').html('');

      }
  });
   
}

</script>

<script type="text/javascript">
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
function checkdatejs(date){
  var date = date;
  var initial = date.split(/\//);
return [ initial[2], initial[0], initial[1] ].join(''); //=> 'mm/dd
}
function checkdatephp(date){
  var date = date;
  var initial = date.split('-');
return [ initial[0], initial[1], initial[2] ].join(''); //=> 'mm/dd
}

function date_js(date){
  MyDate=date;
  MyDateString = ('0' + (MyDate.getMonth()+1)).slice(-2) + '/' + ('0' + MyDate.getDate()).slice(-2) +'/'+ MyDate.getFullYear();
  return MyDateString;
}
  </script>
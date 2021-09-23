<?php $this->load->view("admin/_partials/header.php") ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php $this->load->view("admin/_partials/navbar.php") ?>
<?php $this->load->view("admin/_partials/sidebar.php") ?>
    <!-- Main content -->

      <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

 
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
         <section class="col-lg-12 connectedSortable">
        <div class="row">
          <div class="col-sm-6">

            <div class="card card-primary" id="PlatformDaily">
              <div class="card-header">
                <h3 class="card-title">Processed Issue by Platform - Daily</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainer_dailyissue" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </div>

          <div class="col-sm-6">

          <div class="card card-primary" id="StateDaily">
              <div class="card-header">
                <h3 class="card-title">Processed Issue by State - Daily</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainer_dailyissue_pie" style="height: 300px; width: 100%;"></div>

              </div>
              <!-- /.card-body -->
            </div>
            </div>
            </div>
          </section>

          <section class="col-lg-12 connectedSortable">

                <div class="card card-primary" id="EmployeeDaily">
                <div class="card-header">
                  <h3 class="card-title">Processed Issue by Employee - Daily</h3>

                  <div class="card-tools">
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
                  </div>
                </div>
                <div class="row">
                <div class="col-sm-4">
                  <div class="card-body">
                    <div id="chart_pie_dailyissue_hatip" style="height: 250px; width: 100%;"></div>

                  </div>
                </div>
                   <div class="col-sm-4">
                  <div class="card-body">
                    <div id="chart_pie_dailyissue_agung" style="height: 250px; width: 100%;"></div>

                  </div>
                </div>
                  <div class="col-sm-4">
                  <div class="card-body">
                    <div id="chart_pie_dailyissue_hari" style="height: 250px; width: 100%;"></div>

                  </div>
                </div>
                </div>
                <!-- /.card-body -->
              </div>

          </section>

    
         <section class="col-lg-12 connectedSortable">
             <div class="card card-primary" id="tanggalteam">
              <div class="card-header">
                <h3 class="card-title">Select Date </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                   <div class="form-group">
                  <label>Start Date:</label>
                    <div class="input-group date" id="tglawal" data-target-input="nearest">
                        <input type="text" id="input-tglawal" class="form-control datetimepicker-input" data-target="#tglawal"/>
                        <div class="input-group-append" data-target="#tglawal" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-lg-3">
                  <div class="form-group">
                    <label>End Date:</label>
                      <div class="input-group date" id="tglakhir" data-target-input="nearest">
                          <input type="text" id="input-tglakhir" class="form-control datetimepicker-input" data-target="#tglakhir"/>
                          <div class="input-group-append" data-target="#tglakhir" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </section>
              

        <section class="col-lg-12 connectedSortable">
          <div class="card card-primary" id="TableTicket">
              <div class="card-header">
                <h3 class="card-title">Table OTRS Open Ticket</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" id="download_excel"><i class="fas fa-download"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
              	<div class="form-check">
				  <input class="form-check-input" type="checkbox" value="1" id="closed_ticket" >
				  <label class="form-check-label" for="flexCheckDefault">
				    Closed Ticket
				  </label>
				</div>
                <table id='TicketTable' class="table table-striped table-bordered" style="font-size: 50%;">
                <thead>
                  <tr>
                    <th>Ticket</th>
                    <th>Create Time</th>
                    <th>Response Time</th>
                    <th>User Request</th>
                    <th>Responsible By</th>
                    <th>Priority</th>
                    <th>Ticket Categories</th>
                    <th>Desc</th>
                    <th>Status</th>
                    <th>Condition</th>
                    <th>Left Hours</th>
                  </tr>
                </thead>
              </table>
                 
              </div>
            </div>
        </section>


        <section class="col-lg-12 connectedSortable">
            <div class="row">
            <div class="col-sm-6">
              <div class="card card-primary" id="SLASummary">
                <div class="card-header">
                  <h3 class="card-title">SLA Summary Open TIcket</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="chartContainerSla" style="height: 300px; width: 100%;"></div>
                   
                </div>
              </div>
        </div>
        <div class="col-sm-6">
          <div class="card card-primary" id="SLAIndividu">
          <div class="card-header">
            <h3 class="card-title">SLA Individu  Open TIcket</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div id="barchartContainerSla" style="height: 300px; width: 100%;"></div>

          </div>
          <!-- /.card-body -->
        </div>
        </div>
        </div>
      </section>

          <section class="col-lg-12 connectedSortable">
            <div class="row">
            <div class="col-sm-6">
              <div class="card card-primary" id="PlatformDefault">
                <div class="card-header">
                  <h3 class="card-title">Processed Issue by Platform - Default</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="chartContainer_defissue" style="height: 300px; width: 100%;"></div>
                   
                </div>
              </div>
        </div>
        <div class="col-sm-6">
          <div class="card card-primary" id="StateDefault">
          <div class="card-header">
            <h3 class="card-title">Processed Issue by State - Default</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div id="chartContainer_defissue_pie" style="height: 300px; width: 100%;"></div>

          </div>
          <!-- /.card-body -->
        </div>
        </div>
        </div>
      </section>

        <section class="col-lg-12 connectedSortable">
              <div class="card card-primary" id="EmployeeDefault">
                <div class="card-header">
                  <h3 class="card-title">Processed Issue by Employee - Default</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="myChart" style="height: 300px; width: 100%;"></div>     
                </div>
              </div>
        </section>

         

          <!-- Left col -->

          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->     

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php $this->load->view("admin/_partials/footer.php") ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php $this->load->view("admin/_partials/logout_modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>

</body>
</html>

<script>

$('#tglawal').datetimepicker({
    format: 'L'
});

$('#tglakhir').datetimepicker({
    format: 'L'
});
let firstName = '<?php echo $firstname ;?>';
let lastName = '<?php echo $lastname ;?>';

let intials = firstName.charAt(0) + lastName.charAt(0);
let profileImage = $('#profileImage').text(intials);


</script>

<script>
    // Get the output text


window.onload = function() {
  let tglawal = '<?php echo $tglawal;?>';
  let tglakhir = '<?php echo $tglakhir;?>';
  let closed_ticket ='';
  if($("#closed_ticket").prop("checked") == true){
     closed_ticket ='1';
	}else{
	 closed_ticket ='0';	
	}
	load_ticket_table(tglawal,tglakhir,closed_ticket);
  document.getElementById("input-tglawal").value =change_formatjs(tglawal); 
  document.getElementById("input-tglakhir").value = change_formatjs(tglakhir);
  load_sd_bar_chart_dai();
  
  load_sd_bar_chart_def(tglawal,tglakhir);
  multi_chart_employee_def(tglawal,tglakhir);
 // load_summary_chart_sla(tglawal,tglakhir);
  load_bar_chart_sla(tglawal,tglakhir);
  
}

setInterval(function(){
  // alert("Page is loaded");
  //alert(closed_ticket);
  let tglawal=change_formatphp(document.getElementById("input-tglawal").value);
  let tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
  let closed_ticket ='';
  load_sd_bar_chart_dai();
  
  load_sd_bar_chart_def(tglawal,tglakhir);
  multi_chart_employee_def(tglawal,tglakhir);
  load_ticket_table(tglawal,tglakhir);
  if($("#closed_ticket").prop("checked") == true){
     closed_ticket ='1';
	}else{
	 closed_ticket ='0';	
	}
	load_ticket_table(tglawal,tglakhir,closed_ticket);
  load_bar_chart_sla(tglawal,tglakhir);
}, 60000*5);//1 menit kali 5

$("#tglawal").on("change.datetimepicker", function (e) {
  	let closed_ticket ='';
	if($("#closed_ticket").prop("checked") == true){
     closed_ticket ='1';
	}else{
	 closed_ticket ='0';	
	}
    let tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    let tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    let dateawal=date_js(new Date(e.date));
    let newdate= change_formatphp(dateawal);

    load_sd_bar_chart_def(newdate,tglakhir);
    multi_chart_employee_def(newdate,tglakhir);
    load_ticket_table(newdate,tglakhir,closed_ticket);
    //load_summary_chart_sla(newdate,tglakhir);
    load_bar_chart_sla(newdate,tglakhir);
    
});

$("#tglakhir").on("change.datetimepicker", function (e) {
	let closed_ticket ='';
	if($("#closed_ticket").prop("checked") == true){
     closed_ticket ='1';
	}else{
	 closed_ticket ='0';	
	}
    let tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    let tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    let dateakhir=date_js(new Date(e.date));
    let newdate= change_formatphp(dateakhir);
    load_sd_bar_chart_def(tglawal,newdate);
    multi_chart_employee_def(tglawal,newdate);
    load_ticket_table(tglawal,newdate,closed_ticket);
   // load_summary_chart_sla(tglawal,newdate);
    load_bar_chart_sla(tglawal,newdate);

});

$("#closed_ticket").on("change", function () {
  let tglawal=change_formatphp(document.getElementById("input-tglawal").value);
  let tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
  let closed_ticket = this.checked ? this.value : '';
  if(closed_ticket =='1'){
	  //alert (val);
	  load_ticket_table(tglawal,tglakhir,closed_ticket);
	}else{
		closed_ticket ='0';
	  load_ticket_table(tglawal,tglakhir,closed_ticket);
	}
});


$("#download_excel").on("click", function (e) {
  const site_url = "<?php echo site_url(); ?>";
  const base_url='<?php echo base_url()?>';
  let closed_ticket ='';
  if($("#closed_ticket").prop("checked") == true){
     closed_ticket ='1';
	}else{
	 closed_ticket ='0';	
	}
  let tglawal = change_formatphp(document.getElementById("input-tglawal").value);
  let tglakhir = change_formatphp(document.getElementById("input-tglakhir").value);
  let html_wait='';
      html_wait+='<img src="'+base_url+'assets/image/Reload-1.6s-38px.gif"  alt="LOADING" style="width:50%;height:50%;"">';
  $("#download_excel").html(html_wait);
  //alert(closed_ticket);
    $.ajax({
    url : site_url+'/admin/dashboard/download_excel_ticket',
    method : "POST",
    data : {tglawal: tglawal,tglakhir:tglakhir,closed_ticket:closed_ticket},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){
      console.log(data);
      let blank="";
      $("#download_excel").html(blank);
      let iclass="";
      iclass+="<i class='fas fa-download'></i>";
      $("#download_excel").html(iclass);
      if(data['code']==200){
      //alert(data['message']);
      //download file
      let newlink = base_url+'/create_excel/'+data['name'];
      fetch(newlink)
      .then(resp => resp.blob())
      .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        // the filename you want
        a.download = data['name'];
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        alert(data['message']); // or you know, something with better UX...
      })
      .catch(() => alert('download failed!'));

      }
      else{
        alert(data['message']);
      }

    }
  });
});


function load_ticket_table(tglawal=null,tglakhir=null,closed_ticket=null){
  let dataTableTicket = $('#TicketTable').DataTable({
                'processing': true,
                'serverSide': true,
                'destroy': true,
                 'responsive': true,
            //'retrieve':true,
                'serverMethod': 'post',
                'ajax': {
                  'url':'<?=base_url()?>index.php/admin/dashboard/ticketList',
                  'data': {
                       tglawal: tglawal,
                       tglakhir: tglakhir,
                       closed_ticket : closed_ticket
                       // etc..
                    },
                },

                'columns': [
                  { data: 'tn' },
                  { data: 'create_time' },
                  { data: 'change_time' },
                  { data: 'customer_id'},
                  { data: 'uname'},
                  { data: 'priority_name_mod'},
                  { data: 'type_name'},
                  { data: 'title'},
                  { data: 'state_name'},
                  { data: 'kondisi'},
                  { data: 'left_hours'},

                  /*
                  { data: null,
                        className: "center",
                        defaultContent: '<a href="<?=base_url()?>index.php/admin/administration/edit/'+{data:nik} +' class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
                    }
                    */
                ],
            });
}

function load_sd_bar_chart_dai(){
  const link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json-sd/'; ?>";
 
  let data_new = [];
  let data_closed_success = [];
  let data_open = [];
  let data_pending_reminder = [];
  let data_follow_up = [];


  let dataPointsSum = [];
  let dataPointsHatip = [];
  let dataPointsAgung = [];
  let dataPointsHari = [];

  const bar_sd=1;



  CanvasJS.addColorSet("chartContainer_dailyissueColor",
                  [//colorSet Array
                  "#38a445",
                  "#4F81BC",
                  "#FF8C00",
                  "#468847",
                  "#8A2BE2"         
                  ]);

    let chart_sd_pie_dai = new CanvasJS.Chart("chartContainer_dailyissue_pie", {
    animationEnabled: true,
    colorSet: "chartContainer_dailyissueColor",

    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },
    subtitles: [{
         text: 'Issue Count'
    }],
    data: [{
        type: "pie",
        //yValueFormatString: "#,##0.00\"%\"",
        yValueFormatString: "#,##0",
        indexLabel: "{label} : {y}",
        dataPoints: dataPointsSum,
    }]
});

  let pie_daiHatip = new CanvasJS.Chart("chart_pie_dailyissue_hatip", {
    animationEnabled: true,
    colorSet: "chartContainer_dailyissueColor",

    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },
    subtitles: [{
         text: 'hatip baltaah'
    }],
    data: [{
        type: "pie",
        //yValueFormatString: "#,##0.00\"%\"",
        yValueFormatString: "#,##0",
        indexLabel: "{label} : {y}",
        dataPoints: dataPointsHatip,
    }]
});

    let pie_daiAgung = new CanvasJS.Chart("chart_pie_dailyissue_agung", {
    animationEnabled: true,
    colorSet: "chartContainer_dailyissueColor",

    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },
    subtitles: [{
         text: 'agung ramadhan'
    }],
    data: [{
        type: "pie",
        //yValueFormatString: "#,##0.00\"%\"",
        yValueFormatString: "#,##0",
        indexLabel: "{label} : {y}",
        dataPoints: dataPointsAgung,
    }]
});

    let pie_daiHari = new CanvasJS.Chart("chart_pie_dailyissue_hari", {
    animationEnabled: true,
    colorSet: "chartContainer_dailyissueColor",

    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },
    subtitles: [{
         text: 'hari permadi'
    }],
    data: [{
        type: "pie",
        //yValueFormatString: "#,##0.00\"%\"",
        yValueFormatString: "#,##0",
        indexLabel: "{label} : {y}",
        dataPoints: dataPointsHari,
    }]
});

  let chart_sd_dai = new CanvasJS.Chart("chartContainer_dailyissue", {
    colorSet: "chartContainer_dailyissueColor",

    animationEnabled: true,
  title:{
    text: ""
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
      name: "new",
      legendText: "new",
      showInLegend: true, 
      dataPoints:data_new
    },
    {
      type: "column", 
      name: "closed_success",
      legendText: "closed_success",
      showInLegend: true,
      dataPoints:data_closed_success
    },
    {
      type: "column", 
      name: "open",
      legendText: "open",
      showInLegend: true,
      dataPoints:data_open
    },
    {
      type: "column", 
      name: "pending_reminder",
      legendText: "pending_reminder",
      showInLegend: true,
      dataPoints:data_pending_reminder
    },
    {
      type: "column", 
      name: "follow_up",
      legendText: "follow_up",
      showInLegend: true,
      dataPoints:data_follow_up
    }
    ]
});

  $.ajax({
    url : link+'json_chart_bar_otrs_sd_dai.php',
    method : "POST",
    data : {bar_sd: bar_sd},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){

                let state = Object.keys(data[0]);
                //console.log(state);     
                let total_new =0;
                let total_closed_success =0;
                let total_open =0;
                let total_pending_reminder =0;
                let total_follow_up =0;

               for (let i = 0 ; i < state.length; i++) {
                if(state[i]=='new'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[state[i]][ind]);
                      total_new += parseInt(data[0][state[i]][ind].y);
                       data_new.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }
                }else if(state[i]=='closed_success'){

                for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[state[i]][ind]);
                      total_closed_success += data[0][state[i]][ind].y;
                       data_closed_success.push({
                          label: data[0][state[i]][ind].label,
                          y:data[0][state[i]][ind].y
                        });
                    }

                }else if(state[i]=='open'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[state[i]][ind]);
                      total_open += parseInt(data[0][state[i]][ind].y);
                       data_open.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }else if(state[i]=='pending_reminder'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[state[i]][ind]);
                      total_pending_reminder += parseInt(data[0][state[i]][ind].y);
                       data_pending_reminder.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }else if(state[i]=='follow_up'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[state[i]][ind]);
                      total_follow_up += parseInt(data[0][state[i]][ind].y);
                       data_follow_up.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }


              }


             //console.log(total_closed_success);
            if(total_new > 0){
              dataPointsSum.push({
                            label: 'new',
                            y:total_new
                          });
           }
            if(total_closed_success > 0){
              dataPointsSum.push({
                            label: 'closed_success',
                            y:total_closed_success
                          });
           }
            if(total_open > 0){
              dataPointsSum.push({
                            label: 'open',
                            y:total_open
                          });
           }
            if(total_pending_reminder > 0){
              dataPointsSum.push({
                            label: 'pending_reminder',
                            y:total_pending_reminder
                          });
           }if(total_follow_up > 0){
              dataPointsSum.push({
                            label: 'follow_up',
                            y:total_follow_up
                          });
           }

           //

           let nameGet =  Object.keys(data[1]);
           for (let i = 0; i < nameGet.length; i++) {
            let ticketStatus = Object.keys(data[1][nameGet[i]]);
              for(let x = 0; x < ticketStatus.length; x++) {
                  if(nameGet[i] == 'agung ramadhan'){
                    dataPointsAgung.push({
                                label: ticketStatus[x],
                                y:parseInt(data[1][nameGet[i]][ticketStatus[x]])
                              });
                  }else if(nameGet[i] == 'hatip baltaah'){
                    dataPointsHatip.push({
                                label: ticketStatus[x],
                                y:parseInt(data[1][nameGet[i]][ticketStatus[x]])
                              });
                  }else if(nameGet[i] == 'hari permadi'){
                    dataPointsHari.push({
                                label: ticketStatus[x],
                                y:parseInt(data[1][nameGet[i]][ticketStatus[x]])
                              });
                  }
              }
             }
             //console.log(dataPointsHatip);
           //render
            chart_sd_dai.render();
            chart_sd_pie_dai.render();
            pie_daiHari.render();
            pie_daiAgung.render();
            pie_daiHatip.render();
            $('.canvasjs-chart-credit').html('');



      }
  });

}




function load_sd_bar_chart_def(tglawal=null,tglakhir=null){

  const link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json-sd/'; ?>";
 
  let data_new = [];
  let data_closed_success = [];
  let data_open = [];
  let data_pending_reminder = [];
  let data_follow_up = [];
  let dataPointsSum =[];
  const bar_sd=1;
  CanvasJS.addColorSet("chartContainer_defissueColor",
                  [//colorSet Array
                  "#38a445",
                  "#4F81BC",
                  "#FF8C00",
                  "#468847",
                  "#8A2BE2"    
                  ]);
  let chart_sd_pie_def = new CanvasJS.Chart("chartContainer_defissue_pie", {
    animationEnabled: true,
    colorSet: "chartContainer_dailyissueColor",

    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },

    subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
    }],
    data: [{
        type: "pie",
        //yValueFormatString: "#,##0.00\"%\"",
        yValueFormatString: "#,##0",
        indexLabel: "{label} : {y}",
        dataPoints: dataPointsSum,
    }]
});

  let chart_sd_def = new CanvasJS.Chart("chartContainer_defissue", {
    colorSet: "chartContainer_defissueColor",

    animationEnabled: true,
  title:{
    text: ""
  }, 
     subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
    }], 
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
      name: "new",
      legendText: "new",
      showInLegend: true, 
      dataPoints:data_new
    },
    {
      type: "column", 
      name: "closed_success",
      legendText: "closed_success",
      showInLegend: true,
      dataPoints:data_closed_success
    },
    {
      type: "column", 
      name: "open",
      legendText: "open",
      showInLegend: true,
      dataPoints:data_open
    },
    {
      type: "column", 
      name: "pending_reminder",
      legendText: "pending_reminder",
      showInLegend: true,
      dataPoints:data_pending_reminder
    },
    {
      type: "column", 
      name: "follow_up",
      legendText: "follow_up",
      showInLegend: true,
      dataPoints:data_follow_up
    }
    ]
});

  $.ajax({
    url : link+'json_chart_bar_otrs_sd_def.php',
    method : "POST",
    data : {bar_sd: bar_sd,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){
                let state = Object.keys(data[0]);
                //console.log(state);     
                let total_new =0;
                let total_closed_success =0;
                let total_open =0;
                let total_pending_reminder =0;
                let total_follow_up =0;

               for (let i = 0 ; i < state.length; i++) {
                if(state[i]=='new'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[0][state[i]][ind]);
                       total_new += parseInt(data[0][state[i]][ind].y);
                       data_new.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }
                }else if(state[i]=='closed_success'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[0][state[i]][ind]);
                       total_closed_success += parseInt(data[0][state[i]][ind].y);
                       data_closed_success.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }else if(state[i]=='open'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[0][state[i]][ind]);
                       total_open += parseInt(data[0][state[i]][ind].y);
                       data_open.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }else if(state[i]=='pending_reminder'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[0][state[i]][ind]);
                       total_pending_reminder += parseInt(data[0][state[i]][ind].y);
                       data_pending_reminder.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }else if(state[i]=='follow_up'){
                  for (let ind = 0 ; ind < data[0][state[i]].length; ind++){
                      //console.log(data[0][state[i]][ind]);
                       total_follow_up += parseInt(data[0][state[i]][ind].y);
                       data_follow_up.push({
                          label: data[0][state[i]][ind].label,
                          y:parseInt(data[0][state[i]][ind].y)
                        });
                    }

                }

                }

               if(total_new > 0){
                  dataPointsSum.push({
                                label: 'new',
                                y:total_new
                              });
               }
                if(total_closed_success > 0){
                  dataPointsSum.push({
                                label: 'closed_success',
                                y:total_closed_success
                              });
               }
                if(total_open > 0){
                  dataPointsSum.push({
                                label: 'open',
                                y:total_open
                              });
               }
                if(total_pending_reminder > 0){
                  dataPointsSum.push({
                                label: 'pending_reminder',
                                y:total_pending_reminder
                              });
               }
               if(total_follow_up > 0){
                  dataPointsSum.push({
                                label: 'follow_up',
                                y:total_follow_up
                              });
               }
               //console.log(dataPointsSum);
              chart_sd_def.render();
              chart_sd_pie_def.render();

         $('.canvasjs-chart-credit').html('');

      }
  });

}


function load_bar_chart_sla(tglawal=null,tglakhir=null){

let link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json-sd/'; ?>";

let dataPointsAman=[] ;
let dataPointsWantiwanti=[];
let dataPointsBahaya=[]  ;
let dataPointsFollowup=[] ;
let bar_otrs_sla=1;
let dataPointsSum = [];
let summary=1;

CanvasJS.addColorSet("chartContainerColor",
                [//colorSet Array
                
                "#38a445",
                "#fff85b",              
                "#e73f3f",
                "#674EA7"
                ]);
let chartSla = new CanvasJS.Chart("chartContainerSla", {
  colorSet: "chartContainerColor",
  animationEnabled: true,
  // title: {
  //   text: "Summmary OTRS Ticket"
  // },
  subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
    }],
  data: [{
    type: "pie",
    startAngle: 240,
    yValueFormatString: "#,##0",
    indexLabel: "{label} : {y}",
    dataPoints: dataPointsSum,

  }]
});


let barChartSla = new CanvasJS.Chart("barchartContainerSla", {
    colorSet: "chartContainerColor",
    // title: {
    //     text: "Chart SLA Ticket Team " + team
    // },
     subtitles: [{
       text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
    }],
    theme: "light2",
    animationEnabled: true,
    toolTip:{
        shared: true,
        reversed: true
    },
    axisY: {
        title: "Total SLA Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "aman",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsAman
        },
         {
            type: "stackedColumn",
            name:  "wanti_wanti",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsWantiwanti
        },
        {
            type: "stackedColumn",
            name: "bahaya",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsBahaya
        },{
            type: "stackedColumn",
            name: "follow_up",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsFollowup
        },
       
    ]
});
$.ajax({
    url : link + "json_chart_otrs_sd_sla.php",
    method : "POST",
    data : {summary: summary,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){
             $.each(data['satu'], function(key, value){
             dataPointsSum.push({label: value.label, y: (value.y)});
                       });

             //console.log (data['dua'].length);

             for (let i = 0; i < data['dua'].length; i++) {

              //console.log(data['dua'][i].bahaya.label);
                     dataPointsAman.push({
                        label: data['dua'][i].aman.label,
                        y: data['dua'][i].aman.y
                      });

                      dataPointsWantiwanti.push({
                        label: data['dua'][i].wanti_wanti.label,
                        y: data['dua'][i].wanti_wanti.y
                      });
                      dataPointsBahaya.push({
                        label: data['dua'][i].bahaya.label,
                        y: data['dua'][i].bahaya.y
                      });

                      dataPointsFollowup.push({
                        label: data['dua'][i].follow_up.label,
                        y: data['dua'][i].follow_up.y
                      });
                     

                    }
             barChartSla.render();
            chartSla.render();
          $('.canvasjs-chart-credit').html('');

      }
  });
 
 }
function multi_chart_employee_def(tglawal=null,tglakhir=null){
   const link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json-sd/'; ?>";
   const bar_sd =1;
   //alert(link);
   let dataFinal=[];
   let dataPointsAll=[];
   let dataTempAsis =[];
   let dataHumanError=[];
   let dataFamiliarity=[];
   let dataTrou =[];
   let dataBug =[];
   let dataEmailAccount =[];
   let dataEnhancementRequest =[];
   let dataNet =[];
   let dataHardware =[];
   let dataSoftware =[];
   let dataInfrastructure =[];
   let dataIrrelevant =[];
   let dataMaintenance =[];
   let dataPerformance =[];
   let dataServer =[];
   let dataUnclassified =[];

  // CanvasJS.addColorSet("chartContainer_defissueColor",
  //                 [//colorSet Array
  //                 "#38a445",
  //                 "#4F81BC",
  //                 "#FF8C00",
  //                 "#468847",
  //                 "#8A2BE2"        
  //                 ]);
   let chart = new CanvasJS.Chart("myChart",
    {
          //colorSet: "chartContainer_defissueColor",

      // title:{
      // text: "Multi-Series Line Chart"  
      // },
      subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
      }],
      toolTip:{   
      content: "{name}: {y}"      
      },
     
      // data: [
      // {        
      //   type: "column",
      //   dataPoints: arr
      // }
      // ]
      data: [
      {        
        type: "column",
        name: "Temporay Asistance",
        legendText: "Temporay Asistance",
        showInLegend: true,
        dataPoints: dataTempAsis
      },
      {        
        type: "column",
        name: "Human Error",
        legendText: "Human Error",
        showInLegend: true,
        dataPoints: dataHumanError
      },
      {        
        type: "column",
        name: "Familiarity",
        legendText: "Familiarity",
        showInLegend: true,
        dataPoints: dataFamiliarity
      },
      {        
        type: "column",
        name: "Troubleshooting",
        legendText: "Troubleshooting",
        showInLegend: true,
        dataPoints: dataTrou
      },
      {        
        type: "column",
        name: "Bug",
        legendText: "Bug",
        showInLegend: true,
        dataPoints: dataBug
      },
      {        
        type: "column",
        name: "User/Email Account",
        legendText: "User/Email Account",
        showInLegend: true,
        dataPoints: dataEmailAccount
      },
      {        
        type: "column",
        name: "Enhancement Request",
        legendText: "Enhancement Request",
        showInLegend: true,
        dataPoints: dataEnhancementRequest
      },
        {        
        type: "column",
        name: "Network",
        legendText: "Network",
        showInLegend: true,
        dataPoints: dataNet
      },
        {        
        type: "column",
        name: "Hardware",
        legendText: "Hardware",
        showInLegend: true,
        dataPoints: dataHardware
      },
        {        
        type: "column",
        name: "Software",
        legendText: "Software",
        showInLegend: true,
        dataPoints: dataSoftware
      },
      {        
        type: "column",
        name: "Infrastructure",
        legendText: "Infrastructure",
        showInLegend: true,
        dataPoints: dataInfrastructure
      },
      {        
        type: "column",
        name: "Irrelevant",
        legendText: "Irrelevant",
        showInLegend: true,
        dataPoints: dataIrrelevant
      },
      {        
        type: "column",
        name: "Maintenance",
        legendText: "Maintenance",
        showInLegend: true,
        dataPoints: dataMaintenance
      },
      {        
        type: "column",
        name: "Performance",
        legendText: "Performance",
        showInLegend: true,
        dataPoints: dataPerformance
      },
      {        
        type: "column",
        name: "Server",
        legendText: "Server",
        showInLegend: true,
        dataPoints: dataServer
      },
      {        
        type: "column",
        name: "Unclassified",
        legendText: "Unclassified",
        showInLegend: true,
        dataPoints: dataUnclassified
      },
        
        
      ]
   });

          // alert(link);
    //       console.log(chart);
    // chart.render();

  $.ajax({
    url : link+'json_multi_chart_bar_otrs_sd_def.php',
    method : "POST",
    data : {bar_sd: bar_sd,tglawal:tglawal,tglakhir:tglakhir},
    async : true,
    dataType : 'json',
        cache: false,
    success: function(data){

      //console.log(data);
        let type_name = Object.keys(data);
        //console.log(type_name);
        //let indexReset =0;
              let ind = 0;
              let unameLength =0 ;
              let type_nameArr =[];
              let dataFinal =[];
        for (let i = 0; i < type_name.length; i++) {
          let uname = Object.keys(data[type_name[i]]);
           unameLength = uname.length;
          for (let ind = 0; ind < uname.length; ind++) {
            //console.log(i+'--'+indexReset);
                if(type_name[i]=='Temporary Assistance'){
                    dataTempAsis.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Human Error'){
                    dataHumanError.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Familiarity'){
                    dataFamiliarity.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Troubleshooting'){
                    dataTrou.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Bug'){
                    dataBug.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='User/Email Account'){
                    dataEmailAccount.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Enhancement Request'){
                    dataEnhancementRequest.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Network'){
                    dataNet.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Hardware'){
                    dataHardware.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Software'){
                    dataSoftware.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Infrastructure'){
                    dataInfrastructure.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Irrelevant'){
                    dataIrrelevant.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Maintenance'){
                    dataMaintenance.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Performance'){
                    dataPerformance.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Server'){
                    dataServer.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }else if(type_name[i]=='Unclassified'){
                    dataUnclassified.push(
                      { //indexLabel :type_name[i], 
                        label: uname[ind],
                        y:data[type_name[i]][uname[ind]],
                        // x:ind
                         }
                            );
                  }
              }

    }
               
    chart.render();
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
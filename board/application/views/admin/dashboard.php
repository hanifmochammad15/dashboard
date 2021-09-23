<?php $this->load->view("admin/_partials/header.php") ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php $this->load->view("admin/_partials/navbar.php") ?>
<?php $this->load->view("admin/_partials/sidebar.php") ?>
    <!-- Main content -->
    <div class="card-body">
    <div class="tab-content">
    <div class="tab-pane active" id="chartotrs">
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
      
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">

          <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="cp_card">
              <div class="card-header">
                <h3 class="card-title">Comparative Productivity</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                  <div id="wait_image_1" ></div>
                <div id="chartContainer_cp" style="height: 300px; width: 100%;"></div>
                 
              </div>
              <div class="card-footer small text-muted">Last updated <?php echo $tanggal_update;?></div>
            </div>
        </section>

          <!-- Left col -->
          <section class="col-lg-12 connectedSortable" >
            <!-- Custom tabs (Charts with tabs)-->
             <div class="card card-primary" id="tanggalteam">
              <div class="card-header">
                <h3 class="card-title">Select Date</h3>
              </div>
              <div class="card-body">
                <!-- Date -->
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
                <!-- /.form group -->
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
                <!-- /.form group -->
              </div>
              <!--
              <div class="col-lg-1">
                <label></label>
              </div>
              <div class="col-lg-1.5">
                  <div class="form-group">
                    <label></label>
                  </div>
                  <div class="input-group">
                    <label>Pilih Team :</label>
                  </div>
              </div>
              <div class="col-lg-1">
                <div class="form-group">
                    <label></label>
                </div>
                <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="team1">
                        <label class="custom-control-label" for="team1">1</label>
                      </div>
                </div>
            </div>
            <div class="col-lg-1">
               <div class="form-group">
                    <label></label>
                </div>
                <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox"  class="custom-control-input" id="team2" >
                        <label class="custom-control-label" for="team2">2</label>
                      </div>
                </div>
            </div>
            <div class="col-lg-1">
               <div class="form-group">
                    <label></label>
                </div>
                <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox"  class="custom-control-input" id="team3">
                        <label class="custom-control-label" for="team3">3</label>
                      </div>
                </div>
            </div>
          -->
            <!--
            <div class="col-lg-1">
               <div class="form-group">
                    <label></label>
                </div>
                <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox"  class="custom-control-input" id="team4">
                        <label class="custom-control-label" for="team4">4</label>
                      </div>
                </div>
            </div>
          -->
            </div>

              </div>
              <!-- /.card-body -->
            </div>
          </section>
          <section class="col-lg-6 connectedSortable">
             <!-- DONUT CHART -->
            <div class="card card-primary" id="sumsla">
              <div class="card-header">
                <h3 class="card-title">SLA Ticket</h3>

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

            <div class="card card-primary" id="sumopp">
              <div class="card-header">
                <h3 class="card-title">Ticket not found in OPP</h3>

                <div class="card-tools" >
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerStatusOpp" style="height: 300px; width: 100%;"></div>

              </div>
            </div>

            <div class="card card-primary" id="sumstatus">
              <div class="card-header">
                <h3 class="card-title">Ticket by Policy Status</h3>

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

      <!--
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#pie-chart" data-toggle="tab">Pie</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#bar-chart" data-toggle="tab">Bar</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="pie-chart"
                       style="position: relative; height: 300px;">
                <div id="chartContainerSla" style="height: 300px; width: 100%;"></div>
                   </div>
                  <div class="chart tab-pane" id="bar-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div>
            </div>
-->
             <div class="card card-primary" id="sumotrs">
              <div class="card-header">
                <h3 class="card-title">Ticket by OTRS Status</h3>

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

            <div class="card card-primary" id="sumopp_2days">
              <div class="card-header">
                <h3 class="card-title">Ticket past 2 days not printed in OPP</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="chartContainerStatusOpp_2days" style="height: 300px; width: 100%;"></div>

              </div>
            </div>

            <div class="card card-primary" id="sumstage">
              <div class="card-header">
                <h3 class="card-title">Ticket by Policy Stage</h3>

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
        <?php 
        for ($i=1; $i <= $total_team; $i++) { 
        ?>
        <section class="col-lg-12 connectedSortable">
          <!--
            <div class="card card-primary" id="barsla">
              -->
            <div class="card card-primary" id="bar_team_<?php echo $i;?>">
              <div class="card-header">
                <h3 class="card-title">SLA Ticket Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                 <div id="barchartContainerSla<?php echo $i;?>" style="height: 300px; width: 100%;"></div>

              </div>
            </div>
        </section>

        <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="barotrs">
              <div class="card-header">
                <h3 class="card-title">Ticket by OTRS Status Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerOtrs<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>


        <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="barpolicy">
              <div class="card-header">
                <h3 class="card-title">Ticket by Policy Status Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerStatus<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>

        <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="barstage">
              <div class="card-header">
                <h3 class="card-title">Ticket by Policy Stage Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerStage<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>

        <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="baropp">
              <div class="card-header">
                <h3 class="card-title">Ticket not found in OPP Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerOpp<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>

        <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="baropp_2days">
              <div class="card-header">
                <h3 class="card-title">Ticket past 2 days not printed in OPP Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerOpp_2days<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>
        <?php 
          }
        ?>
      </div>
    </div>
</section>
</div>
    <div class="tab-pane" id="apps_bahaya">
        <section class="col-lg-12 connectedSortable">
          <div class="card card-primary" id="cp_card">
          <div class="card-header">
                <h3 class="card-title">Rincian SLA Bahaya</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool">
                  <a href="<?php echo site_url('admin/otrsbahaya/table_excel'); ?>" class="nav-link"  target="_blank"> <i class="fas fa-download"></i></a>
                </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
          <div class="card-body">
            <?php for($i=1;$i<=$total_team;$i++){;?>
          <div class="col-lg-12">

            <div class="card collapsed-card" >
              <div class="card-header" style="background-color: #F8F8FF;">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                      Team <?php echo $i;?>
                </h3>
                <h5 class="card-title" id="total_<?php echo $i;?>" style="margin-left: 4rem;font-size: 1rem;">
                </h5>
                <h5 class="card-title" id="total_maker_<?php echo $i;?>" style="margin-left: 4rem;font-size: 1rem;">
                </h5>
                <h5 class="card-title" id="total_uw_<?php echo $i;?>" style="margin-left: 4rem;font-size: 1rem;">
                </h5>
                <h5 class="card-title" id="total_reas_<?php echo $i;?>" style="margin-left: 4rem;font-size: 1rem;">
                </h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus" style="color: #696969;"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
            <?php foreach ( ${'list_team_'.$i} as $key => $value) { ?>
              <div class="card-body" style="padding: 0rem;">
               <div class="card collapsed-card" style="margin-bottom: 0">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-table"></i>
                    <?php echo $value->user_login;?><input  type="hidden" id="success_<?php echo $value->id_user;?>" value=0>
                  </h3>

                  <div class="card-tools">
                    <button type="button" id="button_<?php echo $value->id_user;?>" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus" style="color: #696969;"></i>
                    </button>
                  </div>
                </div>
                  <div class="card-body" style="padding: 0rem;" >

                    <table id="table_<?php echo $value->id_user;?>" class="table table-bordered">
                      <tr>
                          <th>Ticket Number</th>
                          <th>Subject Otrs</th>
                          <th>Follow Up Maker</th>
                          <th>Follow Up UW</th>
                          <th>Follow Up Reinsurer</th>
                      </tr>
                  </table>
                  <div id="wait_<?php echo $value->id_user;?>"></div>

                 </div>
               </div>
              </div>
              <?php }?>
              <!-- /.card-body -->
            </div>
          </div>
          <?php }?>

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>

  <div class="tab-pane" id="dashboard_opp">
  	<section class="content">
  		<section class="col-lg-12 connectedSortable" >
  			<!-- Custom tabs (Charts with tabs)-->
  			<div class="card card-primary" id="dashboard_opp3">
  				<div class="card-header">
  					<h3 class="card-title">Select Branch</h3>
  				</div>
  				<div class="card-body">
  					<div class="row">
  						<select class="form-control" id="branch" name="branch" onchange="branch();">
  							<option value="-">No Selected</option>
  							<?php foreach($branch as $row):?>
  								<option value="<?php echo $row->code;?>"><?php echo $row->name;?></option>
  							<?php endforeach;?>
  						</select>
  					</div>

  				</div>
  				<!-- /.card-body -->
  			</div>
  		</section>
  		<div class="container-fluid">
  			<div class="row">
  				<!-- <section class="col-lg-6 connectedSortable">
  					<div class="card card-primary" id="sumopp">
  						<div class="card-header">
  							<h3 class="card-title">Ticket not found in OPP</h3>

  							<div class="card-tools">
  								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
  								</button>
  								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
  							</div>
  						</div>
  						<div class="card-body">
  							<div id="chartContainerStatusOpp" style="height: 300px; width: 100%;"></div>

  						</div>
  					</div>
  				</section> -->
  				<!-- /.Left col -->
  				<!-- right col (We are only adding the ID to make the widgets sortable)-->
  				<section class="col-lg-12 connectedSortable">
  					<div class="card card-primary" id="sumopp_2days">
  						<div class="card-header">
  							<h3 class="card-title">Ticket past 2 days not printed in OPP</h3>

  							<div class="card-tools">
  								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
  								</button>
  								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
  							</div>
  						</div>
  						<div class="card-body">
  							<div id="chartContainerStatusOpp_2days" style="height: 300px; width: 100%; align-content: center;"></div>

  						</div>
  					</div>
  				</section>
  			<?php 
        for ($i=1; $i <= $total_team; $i++) { 
        ?>	
  			<!-- <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="baropp">
              <div class="card-header">
                <h3 class="card-title">Ticket not found in OPP Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>baropp
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerOpp<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section> -->

        <!-- <section class="col-lg-12 connectedSortable">
            <div class="card card-primary" id="baropp_2days">
              <div class="card-header">
                <h3 class="card-title">Ticket past 2 days not printed in OPP Team <?php echo $i;?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div id="barchartContainerOpp_2days<?php echo $i;?>" style="height: 300px; width: 100%;"></div>
                 
              </div>
            </div>
        </section>
        <?php }?>-->
  		</section> 
  	</div>
</div>
</div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<
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
var firstName = '<?php echo $firstname ;?>';
var lastName = '<?php echo $lastname ;?>';

var intials = firstName.charAt(0) + lastName.charAt(0);
var profileImage = $('#profileImage').text(intials);


</script>

<script>
    // Get the output text

$("#tglakhir").on("change.datetimepicker", function (e) {
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var dateakhir=date_js(new Date(e.date));
    var newdate= change_formatphp(dateakhir);
    // var checkBox1  = document.getElementById("team1");
    // var checkBox2  = document.getElementById("team2");
    // var checkBox3  = document.getElementById("team3");
    // var checkBox4  = document.getElementById("team4");
    var total_team='<?php echo $total_team;?>';
    // if(checkBox1.checked==true){
    //   var team= 1;
    // }else if(checkBox2.checked==true){
    //   var team= 2;
    // }else if(checkBox3.checked==true){
    //   var team= 3;
    // }else if(checkBox4.checked==true){
    //   var team= 4;
    // }
    load_summary_chart(tglawal,newdate);

    for (var i = 1; i <= total_team ; i++) {
      load_bar_chart(tglawal,newdate,i);
    }
    //load_bar_chart(tglawal,newdate,team);

});


$("#tglawal").on("change.datetimepicker", function (e) {
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var dateawal=date_js(new Date(e.date));
    var newdate= change_formatphp(dateawal);
    // var checkBox1  = document.getElementById("team1");
    // var checkBox2  = document.getElementById("team2");
    // var checkBox3  = document.getElementById("team3");
    // var checkBox4  = document.getElementById("team4");
    var total_team='<?php echo $total_team;?>';
    // if(checkBox1.checked==true){
    //   var team= 1;
    // }else if(checkBox2.checked==true){
    //   var team= 2;
    // }else if(checkBox3.checked==true){
    //   var team= 3;
    // }else if(checkBox4.checked==true){
    //   var team= 4;
    // }
    load_summary_chart(newdate,tglakhir);
    
    for (var i = 1; i <= total_team ; i++) {
      load_bar_chart(newdate,tglakhir,i);
    }
    //load_bar_chart(newdate,tglakhir,team);
});

function branch() {
	var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var branch = document.getElementById("branch");
    var branch_code = branch.options[branch.selectedIndex].value;

    var total_team='<?php echo $total_team;?>';
    //alert(branch_code);
    load_summary_chart(tglawal,tglakhir,branch_code);

    for (var i = 1; i <= total_team ; i++) {
      load_bar_chart(tglawal,tglakhir,i);
    }

   }




$("#team1").on("change", function (e) {
    $('#team2').prop('checked', false);
    $('#team3').prop('checked', false);
    $('#team4').prop('checked', false);
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var team=1;
    load_bar_chart(tglawal,tglakhir,team);

});

$("#team2").on("change", function (e) {
    $('#team1').prop('checked', false);
    $('#team3').prop('checked', false);
    $('#team4').prop('checked', false);
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var team=2;
    load_bar_chart(tglawal,tglakhir,team);

});

$("#team3").on("change", function (e) {
    $('#team1').prop('checked', false);
    $('#team2').prop('checked', false);
    $('#team4').prop('checked', false);
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var team=3;
    load_bar_chart(tglawal,tglakhir,team);

});

$("#team4").on("change", function (e) {
    $('#team1').prop('checked', false);
    $('#team2').prop('checked', false);
    $('#team3').prop('checked', false);
    var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
    var team=4;
    load_bar_chart(tglawal,tglakhir,team);

});

window.onload = function() {
  load_cp_chart();
  load_summary_chart();
  var total_team='<?php echo $total_team;?>';
  for (var i = 1; i <= total_team ; i++) {
    load_bar_chart(null,null,i);
  }
  //load_bar_chart();
  var tglawal = '<?php echo $tglawal;?>';
  var tglakhir = '<?php echo $tglakhir;?>';
  var team = '<?php echo $team;?>';
  document.getElementById("input-tglawal").value =change_formatjs(tglawal); 
  document.getElementById("input-tglakhir").value = change_formatjs(tglakhir);
  var branch = document.getElementById("branch");
  var branch_code = branch.options[branch.selectedIndex].value;
  //alert(branch_code);
  // if(team==1){
  //   $('#team1').prop('checked', true);
  // }else if(team==2){
  //   $('#team2').prop('checked', true);
  // }else if(team==3){
  //   $('#team3').prop('checked', true);
  // }else if(team==4){
  //   $('#team4').prop('checked', true);
  // }

}


setInterval(function(){
  // alert("Page is loaded");
  var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
  var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);
  load_summary_chart(tglawal,tglakhir);
  var total_team='<?php echo $total_team;?>';
  for (var i = 1; i <= total_team ; i++) {
    load_bar_chart(tglawal,tglakhir,i);
  }
}, 60000*5);//1 menit kali 5



function load_cp_chart(){
  var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json/'; ?>";
  var year_now="<?php echo $year_now; ?>";
  var year_prev="<?php echo $year_prev; ?>";
  var dataPointscp_prev = [];
  var dataPointscp_now = [];
  var bar_cp=1;
  var base_url ='<?php echo base_url();?>';
  var html_wait='';
      html_wait+='<br><center><img src="'+base_url+'assets/image/103.gif"  alt="LOADING"></center>';
      html_wait+=' <br><center><strong>Loading....</strong></center>';
  $("#wait_image_1").html(html_wait);

  CanvasJS.addColorSet("chartContainercpColor",
                  [//colorSet Array
                  // "#38a445",
                  // "#4F81BC"   
                  '#FF8C00',
                  '#FFD700'     
                  ]);
  var chart_cp = new CanvasJS.Chart("chartContainer_cp", {
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

      },
        complete: function(){
            var html_wait='';
             $("#wait_image_1").html(html_wait);
        }
  });

}


function load_summary_chart(tglawal=null,tglakhir=null,branch_code=null){
  if (tglawal==null) {
    var tglawal = '<?php echo $tglawal;?>';
  }else{
    var tglawal = tglawal;
  }
  if (tglakhir==null) {
    var tglakhir = '<?php echo $tglakhir;?>';
  }else{
    var tglakhir = tglakhir;
  }
var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json/'; ?>";

var branch_1 = document.getElementById("branch");
var branch_code_1 = branch_1.options[branch_1.selectedIndex].value;

if (branch_code_1==null || branch_code_1=="") {
    var branch_code = '-';
  }else{
    var branch = document.getElementById("branch");
    var branch_code = branch.options[branch.selectedIndex].value;
  }

//sumarry OTRS Status Ticket
var dataPoints = [];
var summary_otrs=1;
var chart = new CanvasJS.Chart("chartContainer", {
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
    // title: {
    //     text: "Summary Stages Policy Ticket"
    // },
    subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
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
                "#fff85b",
                "#8a2be2"             
                ]);
var dataPointsSla = [];
var summary_otrs_sla=1;
var chartSla = new CanvasJS.Chart("chartContainerSla", {
    colorSet: "chartContainerColor",
    animationEnabled: true,
    // title: {
    //     text: "Summary SLA Ticket"
    // },
    subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
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
  // title: {
  //   text: "Summmary OTRS Status Policy Ticket"
  // },
  subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
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
    // title: {
    //     text: "Summary Of Closed Tickets Not Found In OPP"
    // },
    subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
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
    data : {summary_otrs_opp: summary_otrs_opp,tglawal:tglawal,tglakhir:tglakhir,branch_code:branch_code},
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


//Tickets past 2 days not printed OPP

var dataPointsStatusOpp_2days = [];
var summary_otrs_opp_2days=1;
var chartStatusOpp_2days = new CanvasJS.Chart("chartContainerStatusOpp_2days", {
    animationEnabled: true,
    // title: {
    //     text: "Summary Of Closed Tickets Not Found In OPP"
    // },
    subtitles: [{
         text: tglawal + ' -- ' + tglakhir +' (yyyy-mm-dd)'
    }],
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: dataPointsStatusOpp_2days,
    }]
});
$.ajax({
    url : link +"json_chart_summary_opp_2days.php",
    method : "POST",
    data : {summary_otrs_opp_2days: summary_otrs_opp_2days,tglawal:tglawal,tglakhir:tglakhir,branch_code:branch_code},
    async : true,
    dataType : 'json',
    success: function(data){
             $.each(data, function(key, value){
             dataPointsStatusOpp_2days.push({label: value.label, y: (value.y)});
                       });
            chartStatusOpp_2days.render();
          $('.canvasjs-chart-credit').html('');

      }
  });

}
function load_bar_chart(tglawal=null,tglakhir=null,team=null){
  if (tglawal==null) {
    var tglawal = '<?php echo $tglawal;?>';
  }else{
    var tglawal = tglawal;
  }
  if (tglakhir==null) {
    var tglakhir = '<?php echo $tglakhir;?>';
  }else{
    var tglakhir = tglakhir;
  }
  if (team==null) {
    var team = '<?php echo $team;?>';
  }else{
    var team = team;
  }
var link = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/json/'; ?>";

var branch_1 = document.getElementById("branch");
var branch_code_1 = branch_1.options[branch_1.selectedIndex].value;

if (branch_code_1==null || branch_code_1=="") {
    var branch_code = '-';
  }else{
    var branch = document.getElementById("branch");
    var branch_code = branch.options[branch.selectedIndex].value;
  }




var dataPointsBahaya=[]  ;
var dataPointsDocument=[] ;
var dataPointsAman=[] ;
var dataPointsWantiwanti=[];
var dataPointsFuw=[];
var bar_otrs_sla=1;
// console.log(dataPointsBahaya);

 CanvasJS.addColorSet("barchartContainerColor",
                [//colorSet Array
                "#e73f3f",
                "#bd3853",
                "#38a445",
                "#fff85b",
                "#8a2be2"                           
                  ]);

var barChartSla = new CanvasJS.Chart("barchartContainerSla"+team, {
    colorSet: "barchartContainerColor",
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
            name: "bahaya",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsBahaya
        },{
            type: "stackedColumn",
            name: "document",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsDocument
        },{
            type: "stackedColumn",
            name: "aman",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsAman
        },
        {
            type: "stackedColumn",
            name:  "wanti-wanti",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsWantiwanti
        },        {
            type: "stackedColumn",
            name:  "follow up sales",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsFuw
        }
    ]
});

$.ajax({
    url : link +"json_chart_bar_sla.php",
    method : "POST",
    data : {bar_otrs_sla: bar_otrs_sla,tglawal:tglawal,tglakhir:tglakhir,team:team},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsBahaya.push({
                        label: data[i].bahaya.label,
                        y: data[i].bahaya.y
                      });

                      dataPointsDocument.push({
                        label: data[i].document.label,
                        y: data[i].document.y
                      });
                      dataPointsAman.push({
                        label: data[i].aman.label,
                        y: data[i].aman.y
                      });
                      dataPointsWantiwanti.push({
                        label: data[i].wantiwanti.label,
                        y: data[i].wantiwanti.y
                      });
                      dataPointsFuw.push({
                        label: data[i].fuw.label,
                        y: data[i].fuw.y
                      });

                    }
           barChartSla.render();
           $('.canvasjs-chart-credit').html('');

      }
  });
 
var dataPointsPending_follow_up_sales=[]  ;
var dataPointsOn_progress=[] ;
var dataPointsAssessment=[] ;
//var dataPointsMerged=[] ;
var dataPointsPending_follow_up_uw=[];
var dataPointsPosted=[];
var dataPointsOpen=[];
var dataPointsNew=[];
var dataPointsClosed_unsuccessful=[];
var dataPointsPending_document=[];
var dataPointsPending_follow_up_reinsurer=[];
var dataPointsPending_follow_up_maker=[];
var bar_otrs=1;
var barChartOtrs = new CanvasJS.Chart("barchartContainerOtrs"+team, {
    // title: {
    //     text: "Chart OTRS Ticket Team "  + team
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
        title: "Total OTRS Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
      data: [
        {
            type: "stackedColumn",
            name: "Pending Follow Up Sales",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPending_follow_up_sales
         }
        ,{
            type: "stackedColumn",
            name: "On Progress",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsOn_progress
        },{
            type: "stackedColumn",
            name: "Assessment UW/RI",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsAssessment
        },/*
        {
            type: "stackedColumn",
            name:  "merged",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsMerged
        },*/
        {
            type: "stackedColumn",
            name: "Follow Up UW",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPending_follow_up_uw
        },{
            type: "stackedColumn",
            name: "Posted",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPosted
        },{
            type: "stackedColumn",
            name: "Open",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsOpen
        },{
            type: "stackedColumn",
            name:  "New",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsNew
        },{
            type: "stackedColumn",
            name:  "Closed Unsuccessful",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsClosed_unsuccessful
        },{
            type: "stackedColumn",
            name:  "Follow Up Reinsurer",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPending_follow_up_reinsurer
        },{
            type: "stackedColumn",
            name:  "Follow Up Maker",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPending_follow_up_maker
        }
    ]
});

$.ajax({
    url : link +"json_chart_bar_otrs.php",
    method : "POST",
    data : {bar_otrs: bar_otrs,tglawal:tglawal,tglakhir:tglakhir,team:team},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsPending_follow_up_sales.push({
                        label: data[i].pending_follow_up_sales.label,
                        y: data[i].pending_follow_up_sales.y
                      });

                      dataPointsOn_progress.push({
                        label: data[i].on_progress.label,
                        y: data[i].on_progress.y
                      });
                      dataPointsAssessment.push({
                        label: data[i].assessment.label,
                        y: data[i].assessment.y
                      });
                      // dataPointsMerged.push({
                      //   label: data[i].merged.label,
                      //   y: data[i].merged.y
                      // });
                      dataPointsPending_follow_up_uw.push({
                        label: data[i].pending_follow_up_uw.label,
                        y: data[i].pending_follow_up_uw.y
                      });
                       dataPointsPosted.push({
                        label: data[i].posted.label,
                        y: data[i].posted.y
                      });
                       dataPointsOpen.push({
                        label: data[i].open.label,
                        y: data[i].open.y
                      });
                       dataPointsNew.push({
                        label: data[i].new.label,
                        y: data[i].new.y
                      });
                       dataPointsClosed_unsuccessful.push({
                        label: data[i].closed_unsuccessful.label,
                        y: data[i].closed_unsuccessful.y
                      });
                       dataPointsPending_document.push({
                        label: data[i].pending_document.label,
                        y: data[i].pending_document.y
                      });
                       dataPointsPending_follow_up_reinsurer.push({
                        label: data[i].pending_follow_up_reinsurer.label,
                        y: data[i].pending_follow_up_reinsurer.y
                      });
                       dataPointsPending_follow_up_maker.push({
                        label: data[i].pending_follow_up_maker.label,
                        y: data[i].pending_follow_up_maker.y
                      });

                    }
           barChartOtrs.render();
           $('.canvasjs-chart-credit').html('');
      }
  });

var dataPointsRisk_accepted=[];
var dataPointsApprove=[];
var dataPointsPaid_fully=[];
var dataPointsPaid_partially=[];
var dataPointsInvoiced=[];
var dataPointsNewPolicy=[];
var bar_otrs_status=1;
var barChartStatusPolicy = new CanvasJS.Chart("barchartContainerStatus"+team, {
    // title: {
    //     text: "Chart Policy Status Ticket Team" + team 
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
        title: "Total Policy Status Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Risk Accepted",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsRisk_accepted
        },{
            type: "stackedColumn",
            name: "Approve",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsApprove
        },{
            type: "stackedColumn",
            name: "Paid fully",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPaid_fully
        },
        {
            type: "stackedColumn",
            name:  "Paid partially",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsPaid_partially
        },
        {
            type: "stackedColumn",
            name: "Invoiced",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsInvoiced
        },
        {
            type: "stackedColumn",
            name: "New", //berfore blank
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsNewPolicy
        }
    ]
});
 
$.ajax({
    url : link +"json_chart_bar_status.php",
    method : "POST",
    data : {bar_otrs_status: bar_otrs_status,tglawal:tglawal,tglakhir:tglakhir,team:team},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsRisk_accepted.push({
                        label: data[i].risk_accepted.label,
                        y: data[i].risk_accepted.y
                      });

                      dataPointsApprove.push({
                        label: data[i].approve.label,
                        y: data[i].approve.y
                      });
                      dataPointsPaid_fully.push({
                        label: data[i].paid_fully.label,
                        y: data[i].paid_fully.y
                      });
                      dataPointsPaid_partially.push({
                        label: data[i].paid_partially.label,
                        y: data[i].paid_partially.y
                      });
                       dataPointsInvoiced.push({
                        label: data[i].invoiced.label,
                        y: data[i].invoiced.y
                      });
                       dataPointsNewPolicy.push({
                        label: data[i].new.label,
                        y: data[i].new.y
                      });

                    }
           barChartStatusPolicy.render();
           $('.canvasjs-chart-credit').html('');
      }
  });

var dataPointsBranchUw=[];
var dataPointsMaker=[];
var dataPointsReinsurance=[];
var dataPointsHo_uw=[];
var bar_stage=1;

// console.log(dataPointsBranchUw);
// console.log(dataPointsMaker);
// console.log(dataPointsReinsurance);
// console.log(dataPointsHo_uw);

var barChartStage = new CanvasJS.Chart("barchartContainerStage"+team, {
    // title: {
    //     text: "Chart Stage Ticket Team " + team
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
        title: "Total Stage Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Branch U/W",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsBranchUw
        },{
            type: "stackedColumn",
            name: "Maker",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsMaker
        },{
            type: "stackedColumn",
            name: "Reinsurance",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsReinsurance
        },{
            type: "stackedColumn",
            name:  "HO U/W",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsHo_uw
        }
    ]
});


$.ajax({
    url : link +"json_chart_bar_stage.php",
    method : "POST",
    data : {bar_stage: bar_stage,tglawal:tglawal,tglakhir:tglakhir,team:team},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsBranchUw.push({
                        label: data[i].branch_uw.label,
                        y: data[i].branch_uw.y
                      });
                      dataPointsMaker.push({
                        label: data[i].maker.label,
                        y: data[i].maker.y
                      });
                      dataPointsReinsurance.push({
                        label: data[i].reinsurance.label,
                        y: data[i].reinsurance.y
                      });
                      dataPointsHo_uw.push({
                        label: data[i].ho_uw.label,
                        y: data[i].ho_uw.y
                      });

                    }
           barChartStage.render();
           $('.canvasjs-chart-credit').html('');
      }
  }); 

 CanvasJS.addColorSet("barchartContainerOpp",
                [//colorSet Array
                "#e73f3f"             
                  ]);
var dataPointsOpp=[];
var bar_opp=1;
//console.log(dataPointsOpp);
var barChartOpp = new CanvasJS.Chart("barchartContainerOpp"+team, {
  colorSet: "barchartContainerOpp",
    // title: {
    //     text: "Chart Closed Ticket of OPP Team " + team
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
        title: "Total OPP Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Ticket Closed",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsOpp
        }
    ]
});


$.ajax({
    url : link +"json_chart_bar_opp.php",
    method : "POST",
    data : {bar_opp: bar_opp,tglawal:tglawal,tglakhir:tglakhir,team:team},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsOpp.push({
                        label: data[i].opp.label,
                        y: data[i].opp.y
                      });

                    }
           barChartOpp.render();
           $('.canvasjs-chart-credit').html('');
      }
  });

CanvasJS.addColorSet("barchartContainerOpp_2days",
                [//colorSet Array
                "#e73f3f"             
                  ]);
var dataPointsOpp_2days=[];
var bar_opp_2days=1;
//console.log(dataPointsOpp);
var barChartOpp_2days = new CanvasJS.Chart("barchartContainerOpp_2days"+team, {
  colorSet: "barchartContainerOpp_2days",
    // title: {
    //     text: "Chart Closed Ticket of OPP Team " + team
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
        title: "Total OPP Ticket",
        suffix: " Ticket"
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
     data: [
        {
            type: "stackedColumn",
            name: "Ticket Closed",
            showInLegend: true,
            yValueFormatString: "#,##0 Ticket",
            dataPoints: dataPointsOpp_2days
        }
    ]
});


$.ajax({
    url : link +"json_chart_bar_opp_2days.php",
    method : "POST",
    data : {bar_opp_2days: bar_opp_2days,tglawal:tglawal,tglakhir:tglakhir,team:team,branch_code:branch_code},
    async : true,
    dataType : 'json',
    success: function(data){
              for (var i = 0; i < data.length; i++) {
                      dataPointsOpp_2days.push({
                        label: data[i].opp.label,
                        y: data[i].opp.y
                      });

                    }
           barChartOpp_2days.render();
           $('.canvasjs-chart-credit').html('');
      }
  });

//endloadchart 
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



<?php for($ix=1;$ix<=$total_team;$ix++){;?>
<script type="text/javascript">
      var team_id='<?php echo $ix;?>';

    $.ajax({
            url : "<?php echo site_url('admin/otrsbahaya/total_ticket');?>",
            method : "POST",
            data : {team_id:team_id},
            async : true,
            dataType : 'json',
            success: function(data){

            var team_id='<?php echo $ix;?>';
            var total_=[];
            var total_maker_=[];
            var total_uw_=[];
            var total_reas_=[];
            total_[team_id]='#total_'+team_id;
            total_maker_[team_id]='#total_maker_'+team_id;
            total_uw_[team_id]='#total_uw_'+team_id;
            total_reas_[team_id]='#total_reas_'+team_id;
            
            var html_total = '';
            var html_maker = '';
            var html_uw = '';
            var html_reas = '';

            html_total +='Total Ticket : ';
            html_total +=data['total_all'];
            $(total_[team_id]).html(html_total);

            html_maker +='Total Follow Up Maker : ';
            html_maker +=data['total_maker'];
            $(total_maker_[team_id]).html(html_maker);

            html_uw +='Total Follow Up UW : ';
            html_uw +=data['total_uw'];
            $(total_uw_[team_id]).html(html_uw);

            html_reas +='Total Follow Up Reinsurer : ';
            html_reas +=data['total_reas'];
            $(total_reas_[team_id]).html(html_reas);

              
              
            }
          });

</script>
<?php }?>
<script type="text/javascript">
var team_idxy=[];
var user_loginxy=[];
var user_idxy=[];
var button_=[];
var input_=[];
</script>
<?php $loop=0;?>
<?php for($i=1;$i<=$total_team;$i++){;?>
    <?php foreach ( ${'list_team_'.$i} as $key => $value) { ?>
      <script type="text/javascript">
            team_idxy['<?php echo $loop;?>']='<?php echo $i;?>';
            user_loginxy['<?php echo $loop;?>']='<?php echo $value->user_login;?>';
            user_idxy['<?php echo $loop;?>']='<?php echo $value->id_user;?>';
            button_['<?php echo $loop;?>']='#button_'+user_idxy['<?php echo $loop;?>'];
            
              $(document).on("click", button_['<?php echo $loop;?>'], function () {
                  input_['<?php echo $loop;?>']=document.getElementById("success_"+user_idxy['<?php echo $loop;?>']).value;
                if(input_['<?php echo $loop;?>']==0){
                  document.getElementById("success_"+user_idxy['<?php echo $loop;?>']).value = 1;
                 load_table(team_idxy['<?php echo $loop;?>'],user_loginxy['<?php echo $loop;?>'],user_idxy['<?php echo $loop;?>']);
                }
      });
      </script>

      <?php $loop++?>

  <?php }?>
<?php }?>

<script type="text/javascript">
$("#chartotrs2").click(function(){
	load_cp_chart();

	var tglawal=change_formatphp(document.getElementById("input-tglawal").value);
    var tglakhir=change_formatphp(document.getElementById("input-tglakhir").value);

    var total_team='<?php echo $total_team;?>';

    load_summary_chart(tglawal,tglakhir);

    for (var i = 1; i <= total_team ; i++) {
      load_bar_chart(tglawal,tglakhir,i);
    }
   });

</script>

<script type="text/javascript">
function load_table(team_id,user_login,user_id){
      var team_id=team_id;
      var user_login=user_login;
      var user_id=user_id;
      var base_url='<?php echo base_url()?>';

     // var wait_var=[];
      var wait_var='wait_'+user_id;
      //alert(wait_var);
      var html_wait='';
      html_wait+='<br><center><img src="'+base_url+'assets/image/103.gif"  alt="LOADING"></center>';
      html_wait+=' <br><center><strong>Loading....</strong></center>';
      document.getElementById(wait_var).innerHTML = html_wait;

      //$(wait_var[user_id]).html(html_wait);

       $.ajax({
                          url : "<?php echo site_url('admin/otrsbahaya/list_table_post');?>",
                          method : "POST",
                          data : {team_id:team_id,user_login: user_login,user_id:user_id},
                          //async : true,
                          dataType : 'json',
                          success: function(data){
                           
                            var user_id= data['user_id'];
                            var nama_var=[];
                            nama_var[user_id]='#table_'+user_id;
                            var wait_var=[];
                            wait_var[user_id]='#wait_'+user_id;
                            
                            // if( data['list'].length <= 1){
                            // var html_wait='';
                            // html_wait+=' <center><br><strong>No Ticket Found</strong><br></center>';
                            // $(wait_var[user_id]).html(html_wait);
                            // }

                              for (i=0;i< data['list'].length;i++) {
                                var tn=data['list'][i].tn;
                                $.ajax({
                                  url : "<?php echo site_url('admin/otrsbahaya/ticket_detail');?>",
                                  method : "POST",
                                  data : {user_id:user_id,tn: tn},
                                  //async : false,
                                  dataType : 'json',
                                  success: function(response){
                                    //console.log(response['list']);

                                    var link_otrs='http://vpn.asuransibintang.com/otrs/customer2.pl?Action=CustomerTicketZoom&TicketNumber=';


                                    var trHTML = '';

                                        // trHTML += '<tr><td><a href="' + link_otrs+response['list'].tn + '" target="popup" onclick="window.open('+"'"+link_otrs+response['list'].tn+"'"+','+"'"+'name'+"'"+','+"'"+'width=600,height=400'+"'"+')" ">'+response['list'].tn+'</a></td><td>'+ response['list'].title + '</td><td>' + response['list'].maker + '</td><td>' + response['list'].uw + '</td><td>'+response['list'].reas+'</td></tr>';
                                         trHTML += '<tr><td><a href="' + link_otrs+response['list'].tn + '" target="_blank"  ">'+response['list'].tn+'</a></td><td>'+ response['list'].title + '</td><td>' + response['list'].maker + '</td><td>' + response['list'].uw + '</td><td>'+response['list'].reas+'</td></tr>';
                                        //console.log('hanif--'+response['list'].tn);
                                         $(nama_var[user_id]).append(trHTML);  

                                  },
                                  complete: function(){
                                      $(wait_var[user_id]).html('');
                                  }
                                });

                              }
 
                          }
                        });
     }
</script>
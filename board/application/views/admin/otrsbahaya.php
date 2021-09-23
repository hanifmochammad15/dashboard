<?php $this->load->view("admin/_partials/header.php") ?>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
<?php $this->load->view("admin/_partials/navbar_top_page.php") ?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> OTRS SLA BAHAYA <small>V 1.0</small></h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div> --> 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">

          <?php for($i=1;$i<=$total_team;$i++){;?>
          <div class="col-lg-12">

            <div class="card collapsed-card" >
              <div class="card-header">
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
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
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
                    <?php echo $value->user_login;?>
                  </h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                  <div class="card-body" style="padding: 0rem;" >

                    <table id="table_<?php echo $value->id_user;?>" class="table table-bordered">
                      <tr>
                          <th>Ticket Number</th>
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
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

<?php for($i=1;$i<=$total_team;$i++){;?>
  <?php echo $i;?>'
    <?php foreach ( ${'list_team_'.$i} as $key => $value) { ?>

    <script type="text/javascript">

      var team_id='<?php echo $i;?>';
      var user_login='<?php echo $value->user_login;?>';

      var base_url='<?php echo base_url()?>';

      var user_id='<?php echo $value->id_user;?>';
      var wait_var=[];
      wait_var[user_id]='#wait_'+user_id;
      var html_wait='';
      html_wait+='<br><center><img src="'+base_url+'assets/image/103.gif"  alt="LOADING"></center>';
      html_wait+=' <br><center><strong>Loading....</strong></center>';
      $(wait_var[user_id]).html(html_wait);

       $.ajax({
                          url : "<?php echo site_url('admin/otrsbahaya/list_table_post');?>",
                          method : "POST",
                          data : {team_id:team_id,user_login: user_login},
                          //async : true,
                          dataType : 'json',
                          success: function(data){
                            
                            var user_id='<?php echo $value->id_user;?>';
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
                                    var trHTML = '';
                                        trHTML += '<tr><td>' + response['list'].tn + '</td><td>' + response['list'].maker + '</td><td>' + response['list'].uw + '</td><td>'+response['list'].reas+'</td></tr>';
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
    </script>
    <?php }?>
<?php }?>

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





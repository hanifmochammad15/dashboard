<!-- Main Sidebar Container -->
<style type="text/css">
  #profileImage {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #F0FFFF;
  font-size: 15px;
  color: #2F4F4F;
  text-align: center;
  line-height: 40px;
}
</style>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url('dist/img/logo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ASBI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!--
          <img src="<?php echo base_url('dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
        -->
        <div id="profileImage" class="img-circle elevation-2" alt="User Image"></div>

        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata("nama"); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="#" class="nav-link" id="cp_link" onclick="cp();return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p>Comparative Productivity</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="tanggalteamlink" onclick="tanggalTeamlink();return false;">
                  <i class="far fa-calendar nav-icon"></i>
                  <p>Dates</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summaryslalink" onclick="summaryslalink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Sla Ticket</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summaryotrslink" onclick="summaryotrslink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Ticket by OTRS Status</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summaryopplink" onclick="summaryopplink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Ticket not found in OPP</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summaryopplink_2days" onclick="summaryopplink_2days();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Ticket past 2 days not printed in OPP</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summarystagelink" onclick="summarystagelink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Ticket by Policy Stage</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="summarystatuslink" onclick="summarystatuslink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Ticket by Policy Status</p>
                </a>
              </li>
        <?php 
        for ($i=1; $i <= $total_team; $i++) { 
        ?>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="sidebar_team<?php echo $i;?>" onclick="team_link(<?php echo $i;?>);return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p>Team <?php echo $i;?></p>
                </a>
              </li>
        <?php 
          } 
        ?>

              <!--
              <li class="nav-item">
                 <a href="#" class="nav-link" id="barslalink" onclick="barslalink();return false;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SLA Team</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="barotrslink" onclick="barotrslink();return false;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OTRS Policy Team</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="barpolicylink" onclick="barpolicylink();return false;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status Policy Team</p>
                </a>
              </li>
             <li class="nav-item">
                 <a href="#" class="nav-link" id="barstagelink" onclick="barstagelink();return false;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stages Team</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="#" class="nav-link" id="baropplink" onclick="baropplink();return false;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OPP Team</p>
                </a>
              </li>
              -->
            </ul>
          </li>
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <script type="text/javascript">


      function tanggalTeamlink(){
        $('html,body').animate({
        scrollTop: $("#tanggalteam").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#tanggalteamlink" ).addClass( "active" );
      }
      
      function cp(){
        $('html,body').animate({
        scrollTop: $("#cp_card").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#cp_link" ).addClass( "active" );
      }
       function summaryslalink(){
        $('html,body').animate({
        scrollTop: $("#sumsla").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summaryslalink" ).addClass( "active" );
      }
      function summaryotrslink(){
        $('html,body').animate({
        scrollTop: $("#sumotrs").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summaryotrslink" ).addClass( "active" );
      }
      function summaryopplink(){
        $('html,body').animate({
        scrollTop: $("#sumopp").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summaryopplink" ).addClass( "active" );
      }
      function summaryopplink_2days(){
        $('html,body').animate({
        scrollTop: $("#sumopp_2days").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summaryopplink_2days" ).addClass( "active" );
      }
      function summarystagelink(){
        $('html,body').animate({
        scrollTop: $("#sumstage").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summarystagelink" ).addClass( "active" );
      }
      function summarystatuslink(){
        $('html,body').animate({
        scrollTop: $("#sumstatus").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#summarystatuslink" ).addClass( "active" );
      }
       function barotrslink(){
        $('html,body').animate({
        scrollTop: $("#barotrs").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#barotrslink" ).addClass( "active" );
      }

       function barslalink(){
        $('html,body').animate({
        scrollTop: $("#barsla").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#barslalink" ).addClass( "active" );
      }

      function barpolicylink(){
        $('html,body').animate({
        scrollTop: $("#barpolicy").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#barpolicylink" ).addClass( "active" );
      }
      function barstagelink(){
        $('html,body').animate({
        scrollTop: $("#barstage").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#barstagelink" ).addClass( "active" );
      }
      function baropplink(){
        $('html,body').animate({
        scrollTop: $("#baropp").offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#baropplink" ).addClass( "active" );
      }

      function team_link(team=null){
        var  team=team;
        $('html,body').animate({
        scrollTop: $("#bar_team_"+team).offset().top - ($(this).height() /8)},
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#sidebar_team"+team ).addClass( "active" );
      }
    </script>
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
                <a href="#" class="nav-link" id="PlatformDailyLink" onclick="PlatformDailyLink();return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p style="font-size: 78%;">Processed Issue by Platform - Daily</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="StateDailyLink" onclick="StateDailyLink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p style="font-size: 78%;">Processed Issue by State - Daily</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="EmployeeDailyLink" onclick="EmployeeDailyLink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p style="font-size: 78%;">Processed Issue by Employee - Daily</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="tanggalteamlink" onclick="tanggalTeamlink();return false;">
                  <i class="far fa-calendar nav-icon"></i>
                 <p style="font-size: 85%;">Dates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="TableTicketLink" onclick="TableTicketLink();return false;">
                  <i class="fa fa-table nav-icon"></i>
                  <p style="font-size: 85%;">List Ticket</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="SLASummaryLink" onclick="SLASummaryLink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p style="font-size: 85%;">SLA Summary</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="#" class="nav-link" id="SLAIndividuLink" onclick="SLAIndividuLink();return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p style="font-size: 85%;">SLA Individu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="PlatformDefaultLink" onclick="PlatformDefaultLink();return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p style="font-size: 75%;">Processed Issue by Platform - Default</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="StateDefaultLink" onclick="StateDefaultLink();return false;">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p style="font-size: 75%;">Processed Issue by State - Default</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" id="EmployeeDefaultLink" onclick="EmployeeDefaultLink();return false;">
                  <i class="far fa-bar-chart nav-icon"></i>
                  <p style="font-size: 75%;">Processed Issue by Employee - Default</p>
                </a>
              </li>
             

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

      function PlatformDailyLink(){
        $('html,body').animate({
        scrollTop: $("#PlatformDaily").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#PlatformDailyLink" ).addClass( "active" );
      } 

      function StateDailyLink(){
        $('html,body').animate({
        scrollTop: $("#StateDaily").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#StateDailyLink" ).addClass( "active" );
      } 

      function EmployeeDailyLink(){
        $('html,body').animate({
        scrollTop: $("#EmployeeDaily").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#EmployeeDailyLink" ).addClass( "active" );
      } 

      function tanggalTeamlink(){
        $('html,body').animate({
        scrollTop: $("#tanggalteam").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#tanggalteamlink" ).addClass( "active" );
      }

       function TableTicketLink(){
        $('html,body').animate({
        scrollTop: $("#TableTicket").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#TableTicketLink" ).addClass( "active" );
      } 

      function SLASummaryLink(){
        $('html,body').animate({
        scrollTop: $("#SLASummary").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#SLASummaryLink" ).addClass( "active" );
      } 

       function SLAIndividuLink(){
        $('html,body').animate({
        scrollTop: $("#SLAIndividu").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#SLAIndividuLink" ).addClass( "active" );
      } 

       function PlatformDefaultLink(){
        $('html,body').animate({
        scrollTop: $("#PlatformDefault").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#PlatformDefaultLink" ).addClass( "active" );
      } 

       function StateDefaultLink(){
        $('html,body').animate({
        scrollTop: $("#StateDefault").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#StateDefaultLink" ).addClass( "active" );
      } 
      
      function EmployeeDefaultLink(){
        $('html,body').animate({
        scrollTop: $("#EmployeeDefault").offset().top - ($(this).height() /8) },
        'slow');
        $( ".nav-link" ).removeClass( "active" );
        $( "#EmployeeDefaultLink" ).addClass( "active" );
      } 
      
    </script>
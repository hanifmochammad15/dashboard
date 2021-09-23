
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?php echo base_url('dist/img/logo.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">ASBI</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url('/index.php/admin'); ?>" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('/index.php/admin/otrsbahaya'); ?>" class="nav-link">App Bahaya</a>
          </li>
        </ul>

        <!-- SEARCH FORM -->

      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        
        <!-- Notifications Dropdown Menu -->
         <li class="nav-item">
           <a href="<?php echo site_url('admin/otrsbahaya/table_excel'); ?>" class="nav-link"> <i
              class="fas fa-download"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?php echo site_url('login/logout'); ?>" class="dropdown-item" data-toggle="modal" data-target="#logoutModal"> Sign-Out Sebagai <?php echo ucwords($firstname).' '.ucwords($lastname); ?>
            </a>
        </div>
      </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>
<body id="page-top">

<?php $this->load->view("admin/_partials/navbar.php") ?>

<div id="wrapper">

	<?php $this->load->view("admin/_partials/sidebar.php") ?>

	<div id="content-wrapper">

		<div class="container-fluid">

        <!-- 
        karena ini halaman overview (home), kita matikan partial breadcrumb.
        Jika anda ingin mengampilkan breadcrumb di halaman overview,
        silahkan hilangkan komentar (//) di tag PHP di bawah.
        -->
		<?php //$this->load->view("admin/_partials/breadcrumb.php") ?>


		<div class="row">
			<div class="col-xl-4 col-sm-6 mb-3">
			<div class="card text-white bg-warning o-hidden h-100">
				<div class="card-body">
				<form id="changePass" class="changePassForm" method="post">
				<div class="card-body-icon">
					<i class="fas fa-fw fa-key"></i>
				</div>
				<div class="mr-5">Change Your Password</div>
				<div id="message"></div>
				<hr />
		          <input type="hidden" name="id_pegawai" class="form-control" id="id_pegawai" value="<?= $id_pegawai;?>" >
				<div class="form-group">
		          <label for="curret_password">Current Password:</label>
		          <input type="Password" name="curret_password" class="form-control" id="curret_password" >
		           <span id="curret_password_err" class="text-danger"></span>
		        </div>
		        <div class="form-group">
		          <label for="new_password">New Password:</label>
		          <input type="Password" name="new_password" class="form-control" id="new_password" >
		          <span id="new_password_err" class="text-danger"></span>
		        </div>
		        <div class="form-group">
		          <label for="confirm_new_password">Confirm New Password:</label>
		          <input type="Password" name="confirm_new_password" class="form-control" id="confirm_new_password" >
		          <span id="confirm_new_password_err" class="text-danger"></span>
		        </div>
		       <button class="btn btn-secondary" onclick="ClearFunction()" type="button">Cancel</button>
        		<button class="btn btn-primary">Save changes</button>
        		</form>
        		<div id="message"></div>
				</div>
				 
			</div>
			</div>
		</div>

		</div>
		<!-- /.container-fluid -->
		<script type="text/javascript">
		 $(document).on("submit", '#changePass', function () {
		        var link ="<?php echo site_url('admin/user/updatePassword'); ?>";
		        //e.preventDefault();
		        $.post(link, 
		           $('#changePass').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		            	ClearFunction();
		            	$('#message').html('<span id="newmessage" class="text-success">'+obj['message']+'</span>');
		            }else{
		            	$('#message').html('<span id="newmessage" class="text-danger">'+obj['message']+'</span>');
		            	if(obj['curret_password'] != '')
						     {
						      $('#curret_password_err').html(obj['curret_password']);
						     }
						if(obj['new_password'] != '')
						     {
						      $('#new_password_err').html(obj['new_password']);
						     }
						 if(obj['confirm_new_password'] != '')
						     {
						      $('#confirm_new_password_err').html(obj['confirm_new_password']);
						     }
		            }
		           });
		        return false;
		      });

		  function ClearFunction() {
		  	document.getElementById("changePass").reset();
		  	$('#message').html(''); 
		  	$('#curret_password_err').html('');
		  	$('#new_password_err').html('');
		  	$('#confirm_new_password_err').html('');
		  }
		  </script>

		<!-- Sticky Footer -->
		<?php $this->load->view("admin/_partials/footer.php") ?>

	</div>
	<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->


<?php $this->load->view("admin/_partials/scrolltop.php") ?>
<?php $this->load->view("admin/_partials/modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>

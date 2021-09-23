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

		

		<!-- Area table Example-->
		<div class="row">
		  <div class="col-sm-12">
			<i class="fas fa-table"></i>
			Table User &nbsp;&nbsp;&nbsp;<a  href="<?php echo site_url('add'); ?>" data-toggle="modal" class="addPegawai"  data-target="#userModal" >Add<i class="fas fa-plus"></i></a>
			<hr />
			<!-- Table -->
				<!--<table id='empTable' class='display dataTable'>-->
				<table id='empTable' class="table table-striped table-bordered" style="width:100%">

				  <thead>
				    <tr>
				      <th>Nik</th>
				      <th>Nama</th>
				      <th>Email</th>
				      <th>Divisi</th>
				      <th>Department</th>
				       <th>Atasan</th>
				      <th>Action</th>
				    </tr>
				  </thead>

				</table>
		</div>
	</div>


		<!-- Script -->
		<script type="text/javascript">
		$(document).ready(function(){
			 show_data_pegawai() ;

				 function show_data_pegawai(){
				   	var dataTable = $('#empTable').DataTable({
				      	'processing': true,
				      	'serverSide': true,
				      	'destroy': true,
						//'retrieve':true,
				      	'serverMethod': 'post',
				      	'ajax': {
				          'url':'<?=base_url()?>index.php/admin/user/userList'
				      	},

				      	'columns': [
				         	{ data: 'nik' },
				         	{ data: 'nama' },
				         	{ data: 'email' },
				         	{ data: 'nama_divisi' },
				         	{ data: 'nama_department' },
				         	{ data: 'atasan' },
				         	{ data: 'button'}
				         	/*
				         	{ data: null,
				                className: "center",
				                defaultContent: '<a href="<?=base_url()?>index.php/admin/administration/edit/'+{data:nik} +' class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
				            }
				            */
				      	],
				   	});

				  }

		      $('#divisi').change(function(){ 
		                var id_divisi=$(this).val();
		                var id_dept=null;
		                get_dept(id_divisi,id_dept);
		                get_atasan(id_divisi,id_dept);
		            }); 
		      
		      function get_dept(id_divisi,id_dept){    	
		        var id_divisi= id_divisi;
		        var id_dept= id_dept;
		        $.ajax({
	                    url : "<?php echo site_url('admin/user/get_dept');?>",
	                    method : "POST",
	                    data : {id_divisi: id_divisi},
	                    async : true,
	                    dataType : 'json',
	                    success: function(data){
	                    	if(id_dept==null){
			                        var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                            html += '<option value='+data[i].id_department+'>'+data[i].nama_department+'</option>';
			                        }
			                        $('#department').html(html);
		                    	}else{
			                    	var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                        	if(data[i].id_department== id_dept){
			                            	html += '<option value='+data[i].id_department+' selected>'+data[i].nama_department+'</option>';
			                        	}else{
			                        		html += '<option value='+data[i].id_department+'>'+data[i].nama_department+'</option>';
			                        	}
			                        }
			                        $('#department').html(html);
			                    }
		                    }
		                });

		                return false;
		      }


		      function get_atasan(id_divisi,id_atasan){
		      var id_divisi= id_divisi;
		        var id_atasan= id_atasan;  
		         $.ajax({
	                    url : "<?php echo site_url('admin/user/get_atasan');?>",
	                    method : "POST",
	                    data : {id_divisi: id_divisi},
	                    async : true,
	                    dataType : 'json',
	                    success: function(data){
	                    	if(id_atasan==null){
			                        var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                            html += '<option value='+data[i].id_pegawai+'>'+data[i].nama+'</option>';
			                        }
			                        $('#atasan').html(html);
		                    	}else{
			                    	var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                        	if(data[i].id_pegawai== id_atasan){
			                            	html += '<option value='+data[i].id_pegawai+' selected>'+data[i].nama+'</option>';
			                        	}else{
			                        		html += '<option value='+data[i].id_pegawai+'>'+data[i].nama+'</option>';
			                        	}
			                        }
			                        $('#atasan').html(html);
		                    	}


	                    }
	                    	});
		                return false;
		            }

		      //add Form
		     $(document).on("click", ".addPegawai", function () {
		     	if(document.getElementsByClassName('UserForm')[0].id == 'editForm'){
			            		document.getElementById('editForm').id = 'addForm';
		     					clearform();
			            	}
		     });

		     function clearform(){
		     	if(document.getElementsByClassName('UserForm')[0].id == 'editForm'){
		     	document.getElementById('editForm').reset();
		     	}else{
		     	document.getElementById('addForm').reset();
		     	}
			            		var html = '<option value="">No Selected</option>';
			            		$('#department').html(html);
			            		$('#div-password').show();
		     }
		     //save add Form
		    //$('#addForm').on('submit', function(e){
		    $(document).on("submit", '#addForm', function (e) {
		        var link ="<?php echo site_url('admin/user/add'); ?>";
		        var linkdirect ="<?php echo site_url('admin/user'); ?>";
		        e.preventDefault();
		        $.post(link, 
		           $('#addForm').serialize(), 
		           function(data, status, xhr){
		            //console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='insert success';
		              $('#userModal').modal('hide');
		              show_data_pegawai() ;
		            }else{
		              message='insert failed';
		            }
		           });
		        return false;
		      });

		     //edit Form
			$(document).on("click", ".editPegawai", function () {
			     var idpegawai = $(this).data('id');
			     var link ="<?php echo site_url('admin/user/edit'); ?>";
			     $.ajax({
			            type: "POST",
			            url: link,
			            dataType: "json",
			            data: {idpegawai:idpegawai},
			            success : function(data){
			            	//console.log(data);
			            	if(document.getElementsByClassName('UserForm')[0].id == 'addForm'){
			            		document.getElementById('addForm').id = 'editForm';
			            	}
			            	$('#div-password').hide();
			            	$('[name="idpegawai"]').val(idpegawai);
			            	$('[name="nik"]').val(data['nik']);
			            	$('[name="nama"]').val(data['nama']);
			            	//$('[name="atasan"]').val(data['id_atasan']);
			            	$('[name="email"]').val(data['email']);
			            	$('[name="email"]').val(data['email']);
			            	$('[name="role"]').val(data['id_role']);
			            	//$('[name="department"]').val(data['department']);
			            	$('[name="divisi"]').val(data['divisi']);
			            	get_dept(data['divisi'],data['department']);
			            	get_atasan(data['divisi'],data['id_atasan']);
			            	$('[name="jabatan"]').val(data['jabatan']);
			            	$('[name="keterangan"]').val(data['keterangan']);

               		 }
				});
			});

			//save edit Form

			$(document).on("submit", '#editForm', function (e) {
			    var link ="<?php echo site_url('admin/user/update'); ?>";
		        var linkdirect ="<?php echo site_url('admin/user'); ?>";
		        e.preventDefault();
		        //console.log($('#editForm').serialize());
		        $.post(link, 
		           $('#editForm').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             //message ='update success';
		              $('#userModal').modal('hide');
		              show_data_pegawai() ;
		            }else{
		              message='update failed';
		            }
		           });
		        return false;
			  });

			$(document).on("click", ".deletePegawai", function () {
				var idpegawai = $(this).data('id');
				var html = '<input type="hidden" name="idpegawai" value="'+idpegawai+'">';
				$('#fieldDeletePegawai').html(html);
				 
			});
			//delete Form
			$(document).on("submit", '#deleteForm', function (e) {
				var link ="<?php echo site_url('admin/user/delete'); ?>";
				var linkdirect ="<?php echo site_url('admin/user'); ?>";
		        e.preventDefault();
		         $.post(link, 
		           $('#deleteForm').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='delete success';
		              $('#deleteModal').modal('hide');
		              show_data_pegawai() ;
		            }else{
		              message='delete failed';
		            }
		           });
		        return false; 
			});


		});

		</script>

		</div>
		<!-- /.container-fluid -->

		<!-- Sticky Footer -->
		<?php $this->load->view("admin/_partials/footer.php") ?>

	</div>
	<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->
<?php $this->load->view("admin/user_modal.php") ?>

<?php $this->load->view("admin/_partials/scrolltop.php") ?>
<?php $this->load->view("admin/_partials/modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>

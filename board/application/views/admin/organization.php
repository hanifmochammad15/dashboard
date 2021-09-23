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

		<!-- Area Division table -->
  	  <div class="col-sm-6">
			<i class="fas fa-table"></i>
			Table Divisi &nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('add'); ?>" data-toggle="modal" class="addDivisi"  data-target="#divisiModal" >Add<i class="fas fa-plus"></i></a>
			<hr />
				<!-- Table -->
				<!--<table id='DeptTable' class='display dataTable'>-->
				<table id='DivTable' class="table table-striped table-bordered" style="width:100%">

				  <thead>
				    <tr>
				      <th>Nama Divisi</th>
				      <th>Initial</th>
				       <th>Status</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				</table>
	 </div>


	<!-- Area Department table -->
  	  <div class="col-sm-6">
			<i class="fas fa-table"></i>
			Table Department &nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('add'); ?>" data-toggle="modal" class="addDepartment"  data-target="#departmentModal" >Add<i class="fas fa-plus"></i></a>
			<hr />
				<!-- Table -->
				<!--<table id='DeptTable' class='display dataTable'>-->
				<table id='DeptTable' class="table table-striped table-bordered" style="width:100%">

				  <thead>
				    <tr>
				      <th>Nama Department</th>
				      <th>Nama Divisi</th>
				      <th>Initial</th>
				       <th>Status</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				</table>
			
	 </div>

	

	</div>


		<!-- Script -->
		<script type="text/javascript">
		$(document).ready(function(){

			 show_data_department() ;
			 show_data_divisi();

				 function show_data_divisi(){
				   	var dataTable = $('#DivTable').DataTable({
				      	'processing': true,
				      	'serverSide': true,
				      	'destroy': true,
				      	 'responsive': true,
						//'retrieve':true,
				      	'serverMethod': 'post',
				      	'ajax': {
				          'url':'<?=base_url()?>index.php/admin/organization/divisiList'
				      	},

				      	'columns': [
				         	{ data: 'nama_divisi' },
				         	{ data: 'initial_divisi' },
				         	{ data: 'active' },
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

				 function show_data_department(){
				   	var dataTable = $('#DeptTable').DataTable({
				      	'processing': true,
				      	'serverSide': true,
				      	'destroy': true,
				      	 'responsive': true,
						//'retrieve':true,
				      	'serverMethod': 'post',
				      	'ajax': {
				          'url':'<?=base_url()?>index.php/admin/organization/departmentList'
				      	},

				      	'columns': [
				         	{ data: 'nama_department'},
				         	{ data: 'nama_divisi'},
				         	{ data: 'initial_department'},
				         	{ data: 'active'},
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

				  //save add Form
		    //$('#addForm').on('submit', function(e){
		    $(document).on("submit", '#addFormDepartment', function (e) {
		        var link ="<?php echo site_url('admin/organization/addDepartment'); ?>";
		        e.preventDefault();
		        $.post(link, 
		           $('#addFormDepartment').serialize(), 
		           function(data, status, xhr){
		            //console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='insert success';
		              $('#departmentModal').modal('hide');
		              show_data_department() ;
		            }else{
		              message='insert failed';
		            }
		           });
		        return false;
		      });

		    $(document).on("submit", '#addFormDivisi', function (e) {
		        var link ="<?php echo site_url('admin/organization/addDivisi'); ?>";
		        e.preventDefault();
		        $.post(link, 
		           $('#addFormDivisi').serialize(), 
		           function(data, status, xhr){
		            //console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='insert success';
		              $('#divisiModal').modal('hide');
		              show_data_divisi() ;
		            }else{
		              message='insert failed';
		            }
		           });
		        return false;
		      });

		      //add Form
		     $(document).on("click", ".addDepartment", function () {
		     	if(document.getElementsByClassName('DepartmentForm')[0].id == 'editFormDepartment'){
		     		alert('ok123');
			            document.getElementById('editFormDepartment').id = 'addFormDepartment';
		     			clearformDepartment();
			       }
		     });

		    function clearformDepartment(){
		     	if(document.getElementsByClassName('DepartmentForm')[0].id == 'editFormDepartment'){
		     	document.getElementById('editFormDepartment').reset();
		     	}else{
		     	document.getElementById('addFormDepartment').reset();
		     	}

		     	get_divisi(id_div=null);
		     }

		     //add Form
		     $(document).on("click", ".addDivisi", function () {
		     	if(document.getElementsByClassName('DivisiForm')[0].id == 'editFormDivisi'){
			            document.getElementById('editFormDivisi').id = 'addFormDivisi';
		     			clearformDivisi();
			            	}
		     });

		    function clearformDivisi(){
		     	if(document.getElementsByClassName('DivisiForm')[0].id == 'editFormDivisi'){
		     	document.getElementById('editFormDivisi').reset();
		     	}else{
		     	document.getElementById('addFormDivisi').reset();
		     	}
		     }

		    //edit Form Department
			$(document).on("click", ".editDepartment", function () {
			     var idDepartment = $(this).data('id');
			     var link ="<?php echo site_url('admin/organization/editDepartment'); ?>";
			     $.ajax({
			            type: "POST",
			            url: link,
			            dataType: "json",
			            data: {idDepartment:idDepartment},
			            success : function(data){
			            	//console.log(data);
			            	if(document.getElementsByClassName('DepartmentForm')[0].id == 'addFormDepartment'){
			            		document.getElementById('addFormDepartment').id = 'editFormDepartment';
			            	}
			            	$('[name="id_department"]').val(idDepartment);
			            	$('[name="nama_department"]').val(data['nama_department']);
			            	$('[name="initial_department"]').val(data['initial_department']);

			            	get_divisi(data['id_divisi']);
			                $(".deptactive:checked").val(data['active']);

               		 }
				});
			});

			//edit Form Divisi
			$(document).on("click", ".editDivisi", function () {
			     var idDivisi = $(this).data('id');
			     var link ="<?php echo site_url('admin/organization/editDivisi'); ?>";
			     $.ajax({
			            type: "POST",
			            url: link,
			            dataType: "json",
			            data: {idDivisi:idDivisi},
			            success : function(data){
			            	//console.log(data);
			            	if(document.getElementsByClassName('DivisiForm')[0].id == 'addFormDivisi'){
			            		document.getElementById('addFormDivisi').id = 'editFormDivisi';
			            	}
			            	$('[name="id_divisi"]').val(idDivisi);
			            	$('[name="nama_divisi"]').val(data['nama_divisi']);
			            	$('[name="initial_divisi"]').val(data['initial_divisi']);
			                $(".divactive:checked").val(data['active']);

               		 }
				});
			});

			//save edit form Department

			$(document).on("submit", '#editFormDepartment', function (e) {
			    var link ="<?php echo site_url('admin/organization/updateDepartment'); ?>";
		        e.preventDefault();
		        //console.log($('#editForm').serialize());
		        $.post(link, 
		           $('#editFormDepartment').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             //message ='update success';
		              $('#departmentModal').modal('hide');
		              show_data_department() ;
		            }else{
		              message='update failed';
		            }
		           });
		        return false;
			  });

			//save edit form Divisi

			$(document).on("submit", '#editFormDivisi', function (e) {
			    var link ="<?php echo site_url('admin/organization/updateDivisi'); ?>";
		        e.preventDefault();
		        //console.log($('#editForm').serialize());
		        $.post(link, 
		           $('#editFormDivisi').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             //message ='update success';
		              $('#divisiModal').modal('hide');
		              show_data_divisi() ;
		            }else{
		              message='update failed';
		            }
		           });
		        return false;
			  });

			//Get id delete Department
			$(document).on("click", ".deleteDepartment", function () {
				var idDepartment = $(this).data('id');
				var html = '<input type="hidden" name="id_department" value="'+idDepartment+'">';
				$('#fieldDeleteDepartment').html(html);
				 
			});

			//Get id delete Divisi
			$(document).on("click", ".deleteDivisi", function () {
				var idDivisi = $(this).data('id');
				var html = '<input type="hidden" name="id_divisi" value="'+idDivisi+'">';
				$('#fieldDeleteDivsi').html(html);
				 
			});

			//delete Form Divisi
			$(document).on("submit", '#deleteFormDivisi', function (e) {
				var link ="<?php echo site_url('admin/organization/deleteDivisi'); ?>";
		        e.preventDefault();
		         $.post(link, 
		           $('#deleteFormDivisi').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='delete success';
		              $('#deleteModalDivisi').modal('hide');
		              show_data_divisi() ;
		            }else{
		              message='delete failed';
		            }
		           });
		        return false; 
			});

			//delete Form Department
			$(document).on("submit", '#deleteFormDepartment', function (e) {
				var link ="<?php echo site_url('admin/organization/deleteDepartment'); ?>";
		        e.preventDefault();
		         $.post(link, 
		           $('#deleteFormDepartment').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='delete success';
		              $('#deleteModalDepartment').modal('hide');
		              show_data_department() ;
		            }else{
		              message='delete failed';
		            }
		           });
		        return false; 
			});

			 function get_divisi(id_div){
		        var id_div= id_div;
		        $.ajax({
	                    url : "<?php echo site_url('admin/organization/get_divisi');?>",
	                    method : "POST",
	                    data : {id_div: id_div},
	                    async : true,
	                    dataType : 'json',
	                    success: function(data){
	                    	if(id_div==null){
			                        var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                            html += '<option value='+data[i].id_divisi+'>'+data[i].nama_divisi+'</option>';
			                        }
			                        $('#divisi').html(html);
		                    	}else{
			                    	var html = '<option value="">No Selected</option>';
			                        var i;
			                        for(i=0; i<data.length; i++){
			                        	if(data[i].id_divisi == id_div){
			                            	html += '<option value='+data[i].id_divisi+' selected>'+data[i].nama_divisi+'</option>';
			                        	}else{
			                        		html += '<option value='+data[i].id_divisi+'>'+data[i].nama_divisi+'</option>';
			                        	}
			                        }
			                        $('#divisi').html(html);
			                    }
		                    }
		                });
		                return false;
		      }


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

<?php $this->load->view("admin/organization_modal.php") ?>

<?php $this->load->view("admin/_partials/scrolltop.php") ?>
<?php $this->load->view("admin/_partials/modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>

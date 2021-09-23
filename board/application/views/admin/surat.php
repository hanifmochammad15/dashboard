<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
<!--Date Picker -->
		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		  <link rel="stylesheet" href="/resources/demos/style.css">
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--End-->		  

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
  	  <div class="col-sm-12">
			<i class="fas fa-table"></i>
			Table Surat &nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('add'); ?>" data-toggle="modal" class="addSurat"  data-target="#suratModal" >Add<i class="fas fa-plus"></i></a>
			<hr />
				<!-- Table -->
				<!--<table id='DeptTable' class='display dataTable'>-->
			<table id='DivSurat' class="table table-striped table-bordered" style="width:100%">

				  <thead>
				    <tr>
				      <th>No Surat</th>
				      <th>Nama</th>
				       <th>NIK</th>
				       <th>Unit / Cabang</th>
				       <th>Perihal</th>
				       <th>tanggal keluar</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				</table>
	 </div>

	</div>

	<!-- Script -->
		<script type="text/javascript">
		$(document).ready(function(){

			//show_data_surat();

			  $("#tanggal_keluar").datepicker({ 
			        format: 'yyyy-mm-dd'
			    });


				 //function show_data_surat(){
				   	var dataTable = $('#DivSurat').DataTable({
				      	'processing': true,
				      	'serverSide': true,
				      	'destroy': true,
				      	'responsive': true,
						//'retrieve':true,
				      	'serverMethod': 'post',

				      	'ajax': {
				          'url':'<?=base_url()?>index.php/admin/surat/suratList'
				      	},

				      	'columns': [
				         	{ data: 'no_surat' },
				         	{ data: 'nama' },
				         	{ data: 'nik' },
				         	{ data: 'unit'},
				         	{ data: 'perihal'},
				         	{ data: 'tanggal_keluar'},
				         	{ data: 'button'}
				         	
				      	],
				   	});

				//  }

			// save form
		  $(document).on("submit", '#addFormSurat', function (e) {
		        var link ="<?php echo site_url('admin/surat/addSurat'); ?>";
		        e.preventDefault();
		        $.post(link, 
		           $('#addFormSurat').serialize(), 
		           function(data, status, xhr){
		            //console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            console.log(data);
		            if(obj['status']==200){
		             message ='insert success';
		              $('#suratModal').modal('hide');
		              show_data_surat();
		              $("#tanggal_keluar").datepicker({ 
					        format: 'yyyy-mm-dd'
					    });
		            }else{
		            	if(obj['no_surat'] != '')
						     {
						      $('#err_no_surat').html(obj['no_surat']);
						     }
		                if(obj['nama'] != '')
						     {
						      $('#err_nama').html(obj['nama']);
						     }
						if(obj['nik'] != '')
						     {
						      $('#err_nik').html(obj['nik']);
						     }
						if(obj['unit'] != '')
						     {
						      $('#err_unit').html(obj['unit']);
						     }
						if(obj['perihal'] != '')
						     {
						      $('#err_perihal').html(obj['perihal']);
						     }
						if(obj['tanggal_keluar'] != '')
						     {
						      $('#err_tanggal_keluar').html(obj['tanggal_keluar']);
						     }
		            }
		           });
		        return false;
		      });


		  //edit Form Department
			$(document).on("click", ".editSurat", function () {
			     var id = $(this).data('id');
			     var link ="<?php echo site_url('admin/surat/editSurat'); ?>";
			     $.ajax({
			            type: "POST",
			            url: link,
			            dataType: "json",
			            data: {id:id},
			            success : function(data){
			            	//console.log(data);
			            	if(document.getElementsByClassName('SuratForm')[0].id =='addFormSurat'){
			            		document.getElementById('addFormSurat').id = 'editFormSurat';
			            	}
			            	clearSpan();
			            	console.log(document.getElementsByClassName('SuratForm')[0].id );
			            	var tanggal_keluar=change_formatjs(data['tanggal_keluar']);
			            	$('[name="idSurat"]').val(id);
			            	$('[name="no_surat"]').val(data['no_surat']);
			            	document.getElementById("no_surat").readOnly = true; 
			            	$('[name="nama"]').val(data['nama']);
			            	$('[name="nik"]').val(data['nik']);
			            	$('[name="unit"]').val(data['unit']);
			            	$('[name="perihal"]').val(data['perihal']);
			            	$('[name="tanggal_keluar"]').val(tanggal_keluar);			            	

               		 }
				});
			});


		  //edit Form Department
			$(document).on("click", ".downloadSurat", function () {
			     var id = $(this).data('id');
			     var link ="<?php echo site_url('admin/surat/createPdf'); ?>";
			     var link2 ="<?php echo base_url('pdf/'); ?>";
			     $.ajax({
			            type: "POST",
			            url: link,
			            dataType: "json",
			            data: {id:id},
			            success : function(data){	
			            if(data['no_surat']=200){
			            	window.open(link2+data['namafile']); 
			            }
               		 }
				});
			});

			

			//Save
			$(document).on("submit", '#editFormSurat', function (e) {
			    var link ="<?php echo site_url('admin/surat/UpdateSurat'); ?>";
		        e.preventDefault();
		        //console.log($('#editForm').serialize());
		        $.post(link, 
		           $('#editFormSurat').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             //message ='update success';
		              $('#suratModal').modal('hide');
		                dataTable.ajax.reload( function ( json ) {
						    $('#editFormSurat').val( json.lastInput );
						} );
		              $("#tanggal_keluar").datepicker({ 
					        format: 'yyyy-mm-dd'
					    });
		            }else{

		            	if(obj['nama'] != '')
						     {
						      $('#err_nama').html(obj['nama']);
						     }
						if(obj['nik'] != '')
						     {
						      $('#err_nik').html(obj['nik']);
						     }
						if(obj['unit'] != '')
						     {
						      $('#err_unit').html(obj['unit']);
						     }
						if(obj['perihal'] != '')
						     {
						      $('#err_perihal').html(obj['perihal']);
						     }
						if(obj['tanggal_keluar'] != '')
						     {
						      $('#err_tanggal_keluar').html(obj['tanggal_keluar']);
						     }
		           	 }
		           });
		        return false;
			  });


			//add Form
		     $(document).on("click", ".addSurat", function () {
		     	if(document.getElementsByClassName('SuratForm')[0].id == 'editFormSurat'){
			         document.getElementById('editFormSurat').id = 'addFormSurat';
   					 document.getElementById('no_surat').removeAttribute('readonly');
		     			clearformSurat();
		     			clearSpan();
			            	}else{
			            		clearformSurat();
			            		clearSpan();
			            	}
		     });

		     //delete

		     //Get id delete Department
			$(document).on("click", ".deleteSurat", function () {
				var idSurat = $(this).data('id');
				var html = '<input type="hidden" name="idSurat" value="'+idSurat+'">';
				$('#fieldDeleteSurat').html(html);
				 
			});

			//delete Form Divisi
			$(document).on("submit", '#deleteFormSurat', function (e) {
				
				var link ="<?php echo site_url('admin/surat/deleteSurat'); ?>";
		        e.preventDefault();
		         $.post(link, 
		           $('#deleteFormSurat').serialize(), 
		           function(data, status, xhr){
		            console.log(data);
		            obj = JSON.parse(data);
		            //console.log(obj['nik']);
		            if(obj['status']==200){
		             message ='delete success';
		              $('#deleteModalSurat').modal('hide');
		              dataTable.ajax.reload( function ( json ) {
						    $('#deleteFormSurat').val( json.lastInput );
						} );
		              $("#tanggal_keluar").datepicker({ 
					        format: 'yyyy-mm-dd'
					    });
		            }else{
		              message='delete failed';
		            }
		           });
		        return false; 
			});


		    function clearformSurat(){
		    	
		     	if(document.getElementsByClassName('SuratForm')[0].id == 'editFormSurat'){
		     	document.getElementById('editFormSurat').reset();
		     	clearSpan();

		     	}else{
		     	document.getElementById('addFormSurat').reset();
		     	clearSpan();
		     	}
		     }
		     function clearSpan(){
		     	$('#err_no_surat').html(''); 
			  	$('#err_nama').html('');
			  	$('#err_nik').html('');
			  	$('#err_unit').html('');
			  	$('#err_perihal').html('');
			  	$('#err_tanggal_keluar').html('');
		     }

			function change_formatjs(date){
		  		  var date = date;
		  		  var initial = date.split('-');
				  return [ initial[1], initial[2], initial[0] ].join('/'); //=> 'mm/dd
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

<?php $this->load->view("admin/surat_modal.php") ?>

<?php $this->load->view("admin/_partials/scrolltop.php") ?>
<?php $this->load->view("admin/_partials/modal.php") ?>
<?php $this->load->view("admin/_partials/js.php") ?>
    
</body>
</html>


<!-- Surat Modal-->
<div class="modal fade" id="suratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Request Surat</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="addFormSurat" class="SuratForm" method="post">
      <div class="modal-body">
         <input type="hidden" name="idSurat" id="idSurat" >
        <div class="form-group">
          <label for="no_surat">No Surat:</label>
          <input type="text" name="no_surat" class="form-control" id="no_surat" >
           <span id="err_no_surat" class="text-danger"></span>
        </div>
        <div class="form-group">
          <label for="nama">Nama:</label>
          <input type="text" name="nama" class="form-control" id="nama" >
          <span id="err_nama" class="text-danger"></span>
        </div>
        <div class="form-group">
          <label for="nik">Nik:</label>
          <input type="text" name="nik" class="form-control" id="nik" >
           <span id="err_nik" class="text-danger"></span>
        </div>

         <div class="form-group">
          <label for="unit">Unit / Cabang:</label>
          <input type="text" name="unit" class="form-control" id="unit" >
          <span id="err_unit" class="text-danger"></span>
        </div>
    
          <div class="form-group">
          <label for="perihal">Perihal :</label>
          <input type="text" name="perihal" class="form-control" id="perihal" >
          <span id="err_perihal" class="text-danger"></span>
        </div>
        
       <div class="form-group">
        <label for="tanggal_keluar">Tanggal Keluar :</label>
        <input id="tanggal_keluar" type="text" name="tanggal_keluar" placeholder="mm/dd/yyyy">
        <i style="font-size:24px" class="fa primary">&#xf073;</i>
        <span id="err_tanggal_keluar" class="text-danger"></span>
    </div>
    </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal Department-->
<div class="modal fade" id="deleteModalSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin untuk hapus?</h5>
      </div>
      <form id="deleteFormSurat"  method="post">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <div id="fieldDeleteSurat"></div>
        <button class="btn btn-primary">Delete</button>
      </form>
       
      </div>
    </div>
  </div>
</div>


<!-- User Modal-->
<div class="modal fade bd-example-modal-lg" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Form</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      
      <form id="addForm" class="UserForm" method="post">
      <div class="modal-body">
      <div class="row">
  <!-- Area table Example-->
    <div class="col-sm-6">
        <input type="hidden" name="idpegawai" id="idpegawai" >
        <div class="form-group">
          <label for="nik">Nik:</label>
          <!--<input type="text" name="nik" class="form-control" id="nik" required>-->
          <input type="text" name="nik" class="form-control" id="nik" >
        </div>
        <div id="div-password" class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <div class="form-group">
          <label for="nama">Nama:</label>
          <input type="text" name="nama" class="form-control" id="nama" >
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" name="email" class="form-control" id="email" >
        </div>
        
        <div class="form-group">
          <label for="role">Role :</label>
          <select class="form-control" name="role" id="role" >
            <option value="">No Selected</option>
            <?php foreach($roles as $row):?>
            <option value="<?php echo $row->id_role;?>"><?php echo $row->nama_role;?></option>
            <?php endforeach;?>
        </select>
      </div>

      </div>
      <div class="col-sm-6">
      <div class="form-group">
            <label for="divisi">Divisi :</label>
             <select class="form-control" name="divisi" id="divisi" >
              <option value="">No Selected</option>
              <?php foreach($divisi as $row):?>
              <option value="<?php echo $row->id_divisi;?>"><?php echo $row->nama_divisi;?></option>
            <?php endforeach;?>
        </select>
          </div>
         <div class="form-group">
          <label for="department">Department :</label>
          <select class="form-control" name="department" id="department" >
            <option value="">No Selected</option>
            <?php foreach($department as $row):?>
            <option value="<?php echo $row->id_department;?>"><?php echo $row->nama_department;?></option>
            <?php endforeach;?>
        </select>
      </div>

        <div class="form-group">
          <label for="atasan">Atasan :</label>
          <select class="form-control" name="atasan" id="atasan" >
            <option value="">No Selected</option>
            <?php foreach($atasan as $row):?>
            <option value="<?php echo $row->id_atasan;?>"><?php echo $row->nama_atasan;?></option>
            <?php endforeach;?>
        </select>
      </div>
        <div class="form-group">
              <label for="jabatan">Jabatan:</label>
              <input type="text" name="jabatan" class="form-control" id="jabatan">
            </div>
        <div class="form-group">
          <label for="keterangan">Keterangan:</label>
          ​<textarea id="txtArea"   class="form-control" name="keterangan" rows="3" ></textarea>
        </div>
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
</div>


<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin untuk hapus?</h5>
      </div>
      <form id="deleteForm"  method="post">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <div id="fieldDeletePegawai"></div>
        <button class="btn btn-primary">Delete</button>
      </form>
       
      </div>
    </div>
  </div>
</div>



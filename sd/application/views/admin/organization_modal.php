
<!-- Divisi Modal-->
<div class="modal fade" id="divisiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Divisi Form</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="addFormDivisi" class="DivisiForm" method="post">
      <div class="modal-body">
         <input type="hidden" name="id_divisi" id="id_divisi" >
        <div class="form-group">
          <label for="nama_divisi">Nama Divisi:</label>
          <input type="text" name="nama_divisi" class="form-control" id="nama_divisi" >
        </div>
        <div class="form-group">
          <label for="initial_divisi">Initial Divisi:</label>
          <input type="text" name="initial_divisi" class="form-control" id="initial_divisi" >
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="active" id="divactive" value="1" checked>
          <label class="form-check-label" for="active">
            Active
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input class="form-check-input" type="radio" name="active" id="divactive" value="0" >
          <label class="form-check-label" for="active">
            Not Active
          </label>
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

<!-- Department Modal-->
<div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Department Form</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="addFormDepartment" class="DepartmentForm" method="post">
      <div class="modal-body">
         <input type="hidden" name="id_department" id="id_department" >
        <div class="form-group">
          <label for="nama_department">Nama Department:</label>
          <input type="text" name="nama_department" class="form-control" id="nama_department" >
        </div>

         <div class="form-group">
          <label for="department">Divisi :</label>
          <select class="form-control" name="divisi" id="divisi" >
            <option value="">No Selected</option>
            <?php foreach($divisi as $row):?>
            <option value="<?php echo $row->id_divisi;?>"><?php echo $row->nama_divisi;?></option>
            <?php endforeach;?>
        </select>
      </div>
        <div class="form-group">
          <label for="initial_department">Initial Department:</label>
          <input type="text" name="initial_department" class="form-control" id="initial_department" >
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="active" id="deptactive" value="1" checked>
          <label class="form-check-label" for="active">
            Active
          </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input class="form-check-input" type="radio" name="active" id="deptactive" value="0" >
          <label class="form-check-label" for="active">
            Not Active
          </label>
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
<div class="modal fade" id="deleteModalDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin untuk hapus?</h5>
      </div>
      <form id="deleteFormDepartment"  method="post">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <div id="fieldDeleteDepartment"></div>
        <button class="btn btn-primary">Delete</button>
      </form>
       
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal Divisi-->
<div class="modal fade" id="deleteModalDivisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin untuk hapus?</h5>
      </div>
      <form id="deleteFormDivisi"  method="post">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <div id="fieldDeleteDivsi"></div>
        <button class="btn btn-primary">Delete</button>
      </form>
       
      </div>
    </div>
  </div>
</div>

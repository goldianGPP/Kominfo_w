<? foreach ($data as $key => $value) : ?>
  <div class="modal fade" id="exampleModal<? echo $value->id_file?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form<? echo $value->id_file ?>" method="POST" action="<?php echo base_url("menu/arsip/updateFile") ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <? if (isset($_SESSION["isSuccess"])) : ?>
                  <? if ($_SESSION["isSuccess"] == TRUE) : ?>
                      <div style="background-color: #52fc03;">
                          <p class="text-center font-weight-light">berhasil</p>
                      </div>
                  <? else : ?>
                      <div style="background-color: #ff1e00;">
                          <p class="text-center font-weight-light">gagal</p>
                      </div>
                  <? endif; ?>
                  <? unset($_SESSION["isSuccess"]); ?>
              <? endif; ?>
              <div class="form-floating mb-3">
                  <input name="nama" class="form-control" id="nama" type="text" placeholder="name@example.com"  value="<? echo $value->nama ?>" />
                  <label for="nama">Nama</label>
              </div>

              <div class="form-floating mb-3">
                  <input name="tipe" class="form-control" id="tipe" type="text" placeholder="name@example.com"  value="<? echo $value->tipe ?>" />
                  <label for="tipe">Tipe</label>
              </div>

              <input type="text" name="id_file" hidden value="<? echo $value->id_file ?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <input onclick="form_submit(<? echo $value->id_file ?>)" type="button" class="btn btn-primary btn-block" type="submit" value="Simpan">
            </div>
        </div>
      </div>
    </form>
  </div>

  <div class="modal fade" id="exampleModal2<? echo $value->id_file?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form2<? echo $value->id_file ?>" method="POST" action="<?php echo base_url("menu/arsip/deleteFile") ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <div class="form-floating mb-3">
                  <h3>File akan dihapus</h3>
                  <h6>apa anda yakin ?</h6>
              </div>

              <input type="text" name="id_file" hidden value="<? echo $value->id_file ?>">
              <input type="text" name="path" hidden value="<? echo $value->path ?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <input onclick="form2_submit(<? echo $value->id_file ?>)" type="button" class="btn btn-danger btn-block" type="submit" value="Hapus">
            </div>
        </div>
      </div>
    </form>
  </div>
<?php endforeach; ?>

<script type="text/javascript">
  function form_submit(id) {
    document.getElementById("form"+id).submit();
  }    
  function form2_submit(id) {
    document.getElementById("form2"+id).submit();
  }    
</script>
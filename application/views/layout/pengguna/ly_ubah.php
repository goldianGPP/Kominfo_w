<? foreach ($data as $key => $value) : ?>
  <div class="modal fade" id="exampleModal<? echo $value->id_pengguna?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form<? echo $value->id_pengguna ?>" method="POST" action="<?php echo base_url("menu/pengguna/updatePengguna") ?>">
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
                  <input name="nip" class="form-control" id="nip" type="nip" placeholder="name@example.com" value="<? echo $value->nip ?>" />
                  <label for="nip">Nip</label>
              </div>

              <div class="form-floating mb-3">
                  <input name="nama" class="form-control" id="nama" type="text" placeholder="name@example.com"  value="<? echo $value->nama ?>" />
                  <label for="nama">Nama</label>
              </div>

              <div class="form-floating mb-3">
                  <input name="jabatan" class="form-control" id="jabatan" type="text" placeholder="name@example.com"  value="<? echo $value->jabatan ?>" />
                  <label for="jabatan">Jabatan</label>
              </div>

              <select id="golongan" type="golongan" name="golongan" class="form-select mb-3" aria-label="Default select example">
                  <? foreach ($golongan as $key => $gol): ?>
                      <option 
                        <? if($value->golongan == $gol->golongan) : echo "selected"; endif;?> 
                        value="<? echo $gol->id_golongan ?>"><? echo $gol->golongan.' '.$gol->definisi ?>
                      </option>
                  <?php endforeach; ?>
              </select>

              <input type="text" name="id_pengguna" hidden value="<? echo $value->id_pengguna ?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <input onclick="form_submit(<? echo $value->id_pengguna ?>)" type="button" class="btn btn-primary btn-block" type="submit" value="Simpan">
            </div>
        </div>
      </div>
    </form>
  </div>

  <div class="modal fade" id="exampleModal2<? echo $value->id_pengguna?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form2<? echo $value->id_pengguna ?>" method="POST" action="<?php echo base_url("menu/pengguna/deletePengguna") ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <div class="form-floating mb-3">
                  <h3>Data Pengguna akan dihapus</h3>
                  <h6>apa anda yakin ?</h6>
              </div>

              <input type="text" name="id_pengguna" hidden value="<? echo $value->id_pengguna ?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <input onclick="form2_submit(<? echo $value->id_pengguna ?>)" type="button" class="btn btn-danger btn-block" type="submit" value="Hapus">
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
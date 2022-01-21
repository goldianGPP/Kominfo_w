<? foreach ($data as $key => $value) : ?>
  <div class="modal fade" id="exampleModal<? echo $value->id_detail ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form<? echo $value->id_detail ?>" method="POST" action="<?php echo base_url("menu/libur/updateLibur") ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="form-floating mt-3">
              <input name="tgl_presensi" class="form-control" id="tgl_presensi" type="date" placeholder="name@example.com" />
              <label for="tgl_presensi">Tanggal</label>
            </div>

            <input type="text" name="id_detail" hidden value="<? echo $value->id_detail ?>">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <input onclick="form_submit(<? echo $value->id_detail ?>)" type="button" class="btn btn-primary btn-block" type="submit" value="Simpan">
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="modal fade" id="exampleModal2<? echo $value->id_detail ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form2<? echo $value->id_detail ?>" method="POST" action="<?php echo base_url("menu/libur/deleteLibur") ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-floating mb-3">
              <h3>Tanggal akan dihapus</h3>
              <h6>apa anda yakin ?</h6>
            </div>

            <input type="text" name="id_detail" hidden value="<? echo $value->id_detail ?>">
            <input type="text" name="tgl_presensi" hidden value="<? echo $value->tgl_presensi ?>">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <input onclick="form2_submit(<? echo $value->id_detail ?>)" type="button" class="btn btn-danger btn-block" type="submit" value="Hapus">
          </div>
        </div>
      </div>
    </form>
  </div>
<?php endforeach; ?>

<script type="text/javascript">
  function form_submit(id) {
    document.getElementById("form" + id).submit();
  }

  function form2_submit(id) {
    document.getElementById("form2" + id).submit();
  }
</script>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Akun</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tambah Akun</li>
            </ol>
            <div class="row">
                <div class="container">
                    <div class="row justify-content-center">
                        <div>
                            <div class="card shadow-lg border-0 rounded-lg mt-2">
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
                                <div class="card-body">
                                    <form method="POST" action="<?php echo base_url("menu/libur/postLibur") ?>">
                                        <class class="row">
                                            <div class="form-floating mt-3 col-2">
                                                <input name="tgl_presensi" class="form-control" id="tgl_presensi" type="date" placeholder="name@example.com" />
                                                <label for="tgl_presensi">Tanggal</label>
                                            </div>

                                            <div class="mt-4 col-1" style="float: left;">
                                                <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="tambah"></div>
                                            </div>
                                        </class>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Hari</th>
                                                <th>Tanggal</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Hari</th>
                                                <th>Tanggal</th>
                                                <th>aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <? foreach ($data as $key => $value) : ?>
                                                <tr>
                                                    <td><? echo $key; ?></td>
                                                    <td><? echo $value->tgl_presensi; ?></td>
                                                    <td><? echo $dayname[date('N', strtotime($value->tgl_presensi)) -1]; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<? echo $value->id_detail; ?>">Ubah</button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2<? echo $value->id_detail; ?>">Hapus</button>
                                                    </td>
                                                </tr>
                                            <? endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
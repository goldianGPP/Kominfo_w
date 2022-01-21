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
                        <div >
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
                                    <form method="POST" action="<?php echo base_url("menu/pengguna/postPengguna") ?>">
                                        <div class="form-floating mb-3">
                                            <input name="nip" class="form-control" id="nip" type="nip" placeholder="name@example.com" />
                                            <label for="nip">Nip</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input name="nama" class="form-control" id="nama" type="text" placeholder="name@example.com" />
                                            <label for="nama">Nama</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input name="jabatan" class="form-control" id="jabatan" type="text" placeholder="name@example.com" />
                                            <label for="jabatan">Jabatan</label>
                                        </div>

                                        <select id="golongan" type="golongan" name="golongan" class="form-select mb-3" aria-label="Default select example">
                                            <option selected>pilih Golongan</option>
                                            <? foreach ($golongan as $key => $value): ?>
                                                <option value="<? echo $value->id_golongan ?>"><? echo $value->golongan.' '.$value->definisi ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Tambah Pengguna"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
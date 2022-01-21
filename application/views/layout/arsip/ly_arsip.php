<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    DataTable Example
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Pengguna</th>
                                                <th>Nama File</th>
                                                <th>Tipe</th>
                                                <th>Tgl Buat</th>
                                                <th>Tgl Ubah</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Pengguna</th>
                                                <th>Nama File</th>
                                                <th>Tipe</th>
                                                <th>Tgl Buat</th>
                                                <th>Tgl Ubah</th>
                                                <th>aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <? foreach ($data as $key => $value) : ?>
                                                <tr>
                                                    <td><? echo $value->id_file; ?></td>
                                                    <td><? echo $value->pengguna; ?></td>
                                                    <td><? echo $value->nama; ?></td>
                                                    <td><? echo $value->tipe; ?></td>
                                                    <td><? echo $value->tgl_masuk; ?></td>
                                                    <td><? echo $value->tgl_ubah; ?></td>
                                                    <td>
                                                        <a type="button" class="btn btn-primary" href="<?php echo base_url($value->path.'.pdf'); ?>">Buka</a>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<? echo $value->id_file; ?>">Ubah</button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2<? echo $value->id_file; ?>">Hapu</button>
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
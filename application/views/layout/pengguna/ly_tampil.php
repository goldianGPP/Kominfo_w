<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tampil Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Tampil Pengguna</li>
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
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Golongan</th>
                                                <th>Tanda Tangan</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Golongan</th>
                                                <th>Tanda Tangan</th>
                                                <th>aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <? foreach ($data as $key => $value) : ?>
                                                <tr>
                                                    <td><? echo $value->id_pengguna; ?></td>
                                                    <td><? echo $value->nip; ?></td>
                                                    <td><? echo $value->nama; ?></td>
                                                    <td><? echo $value->jabatan; ?></td>
                                                    <td><? echo $value->golongan." ".$value->definisi; ?></td>
                                                    <td><? echo $value->tandatangan; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<? echo $value->id_pengguna; ?>">Ubah</button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2<? echo $value->id_pengguna; ?>">Hapus</button>
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
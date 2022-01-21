<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Ubah Data Absensi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Ubah Data Absensi</li>
            </ol>
            <div class="row">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="card-body col-5" style="overflow-y: scroll; height: 450px;">
                            <div class="card">
                                <form action="POST" autocomplete="off" action="<?php echo base_url("menu/home/update") ?>">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <? foreach ($penggunas as $key => $value) : ?>
                                                <tr>
                                                    <td><? echo $value->nip; ?></td>
                                                    <td><? echo $value->nama; ?></td>
                                                    <td>
                                                        <button onclick="redirect('<?php echo base_url('menu/home/update/' . $value->id_pengguna); ?>')" type="button" class="btn btn-info">Ubah</button>
                                                    </td>
                                                </tr>
                                            <? endforeach ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <? if ($id_pengguna != null) : ?>
                            <div class="card-body col-1" style="overflow-y: scroll; height: 450px;">
                                <div class="card">
                                    <? for ($i = 1; $i <= $days; $i++) : ?>
                                        <? $day = date('N', strtotime($year . '-' . $month . '-' . $i)); ?>
                                        <? if ($day < 6) : ?>
                                            <div class="card">
                                                <form class=" m-1" method="POST" action="<?php echo base_url('menu/home/change/' . $id_pengguna) ?>">
                                                    <div class="card-body">
                                                        <h6 style="float: left; margin-top: 0.5%;">
                                                            <?= $dayname[$day - 1] ?> <br>
                                                            <?= date('Y-m-d', strtotime($year . '-' . $month . '-' . $i)); ?>
                                                        </h6>
                                                        <div style="border-left: 1px solid black; height: 40px; float: left; margin: 0 5px 0 5px;"></div>
                                                        <h6 style="float: left; margin-top: 0.5%; margin-right: 5px;">
                                                            Status :
                                                        </h6>
                                                        <select onchange="this.form.submit()" style="float: left; width: 50%;" id="status" type="status" name="status" class="form-select" aria-label="Default select example">
                                                            <? $now = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i)); ?>
                                                            <? if (isset($absens[$index])) : ?>
                                                                <? if ($absens[$index]->tgl_presensi == $now && $absens[$index]->status != 'libur') : ?>
                                                                    <? $isUpdate = true; ?>
                                                                    <option <? if ($absens[$index]->status == 'masuk') echo 'selected' ?> value="aktif">masuk</option>
                                                                    <option <? if ($absens[$index]->status == 'alpa') echo 'selected' ?> value="alpa">alpa</option>
                                                                    <option <? if ($absens[$index]->status == 'izin') echo 'selected' ?> value="izin">izin</option>
                                                                    <option <? if ($absens[$index]->status == 'dldp') echo 'selected' ?> value="dldp">dinas luar / perjalanan dina</option>
                                                                    <? $index++; ?>
                                                                <? else : ?>
                                                                    <? $isUpdate = false; ?>
                                                                    <option>masuk</option>
                                                                    <option selected value="alpa">alpa</option>
                                                                    <option value="izin">izin</option>
                                                                    <option value="dldp">dinas luar / perjalanan dina</option>
                                                                <? endif; ?>
                                                            <? else : ?>
                                                                <? $isUpdate = false; ?>
                                                                <option>masuk</option>
                                                                <option selected value="alpa">alpa</option>
                                                                <option value="izin">izin</option>
                                                                <option value="dldp">dinas luar / perjalanan dina</option>
                                                            <? endif; ?>
                                                        </select>
                                                        <input type="text" name="isUpdate" hidden value="<? echo $isUpdate ?>">
                                                        <input type="text" name="tgl_presensi" hidden value="<? echo $now ?>">
                                                    </div>
                                                </form>
                                            </div>
                                        <? endif; ?>
                                    <? endfor; ?>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>

            <script>
                function redirect(url) {
                    window.location.replace(url)
                }
            </script>
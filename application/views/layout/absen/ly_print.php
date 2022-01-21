<div>
    <h5 style="text-align: center; margin-top: 5%; margin-bottom: 2%;">
        PEMERINTAHAN KABUPATEN MIMIKA <br>
        DINAS KOMUNIKASI DAN INFORMATIKA KABUPATEN MIMIKA<br>
        DAFTAR HADIR PEGAWAI<br>
        BULAN : <?= $monthname . ' ' . $year; ?>
    </h5>
    <table class="abs-table">
        <thead>
            <tr>
                <th class="abs-col-h" rowspan="2">No</th>
                <th class="abs-col-h" rowspan="2">Nama</th>
                <th class="abs-col-h" rowspan="2">Jabatan</th>
                <th colspan="<? echo $days; ?>">Tanggal</th>
            </tr>
            <tr>
                <? for ($i = 1; $i <= $days; $i++) : ?>
                    <? if ((date('N', strtotime($year . '-' . $month . '-' . $i)) >= 6)) : ?>
                        <th class="text-danger abs-col-h-danger"><? echo $i; ?></th>
                    <? else : ?>
                        <th style="border: solid;"><? echo $i; ?></th>
                    <? endif; ?>
                <? endfor; ?>
            </tr>
        </thead>
        <tbody>
            <? $i = 1;
            $temp = 0;
            foreach ($absens as $key => $value) : ?>
                <? if ($temp != $value->id_pengguna) :  $temp = $value->id_pengguna; ?>
                    <tr>
                        <td class="abs-col"><? echo $i; ?></td>
                        <td class="abs-col col-al">
                            <? echo $value->nama; ?><br>
                            <? echo $value->definisi . ' (' . $value->golongan . ')'; ?><br>
                            <? echo $value->nip; ?>
                        </td>
                        <td class="abs-col"><? echo $value->jabatan; ?></td>

                        <? $index = $i;
                        for ($j = 1; $j <= $days; $j++) : ?>
                            <? if ((date('N', strtotime($year . '-' . $month . '-' . $j)) >= 6)) : ?>
                                <td class="abs-col-tgl bg-danger" style="border: solid; border-color: black;"></td>
                            <? else : ?>
                                <? if ($absens[$index - 1]->tgl_presensi == date('Y-m-d', strtotime($year . '-' . $month . '-' . $j))) : ?>
                                    <? if ($absens[$index - 1]->status == 'masuk') : ?>
                                        <td class="abs-col-tgl">
                                            <img class="ttd" src="<? echo base_url($absens[$index - 1]->tandatangan); ?>">
                                        </td>
                                    <? elseif ($absens[$index - 1]->status == 'izin') : ?>
                                        <td class="abs-col-tgl">I</td>
                                    <? elseif ($absens[$index - 1]->status == 'sakit') : ?>
                                        <td class="abs-col-tgl">S</td>
                                    <? else : ?>
                                        <td class="abs-col-tgl">DL / DP</td>
                                    <? endif; ?>
                                <? elseif ($date > date('Y-m-d', strtotime($year . '-' . $month . '-' . $j))) : ?>
                                    <td class="abs-col-tgl">A</td>
                                <? else : ?>
                                    <td class="abs-col-tgl"></td>
                                <? endif; ?>
                                <?php if ($index < count($absens)) {
                                    if ($temp == $absens[$index]->id_pengguna) {
                                        $index++;
                                    }
                                } ?>
                            <? endif; ?>
                        <? endfor; ?>
                    </tr>
                <? endif; ?>
            <? $i++;
            endforeach; ?>
        </tbody>
    </table>

    <div style="font-weight: bold; margin-top: 5%; ">
        Keterangan :
        <table>
            <tr>
                <td>A</td>
                <td>:</td>
                <td>Alpa</td>
            </tr>
            <tr>
                <td>S</td>
                <td>:</td>
                <td>Sakit</td>
            </tr>
            <tr>
                <td>I</td>
                <td>:</td>
                <td>Izin</td>
            </tr>
            <tr>
                <td>DL / PD</td>
                <td>:</td>
                <td>Dinas Luar / Perjalanan Dina</td>
            </tr>
        </table>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
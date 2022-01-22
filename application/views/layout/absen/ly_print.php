<div>
    <h5 style="text-align: center; margin-top: 5%; margin-bottom: 2%;">
        PEMERINTAHAN KABUPATEN MIMIKA <br>
        DINAS KOMUNIKASI DAN INFORMATIKA KABUPATEN MIMIKA<br>
        DAFTAR HADIR PEGAWAI<br>
        BULAN : <?= $monthname . ' ' . $year; ?>
    </h5>
    <table id="tbl" class="abs-table">
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
            <? foreach ($absens as $key => $value) : ?>
                <tr>
                    <td class="abs-col"><?= $key + 1; ?></td>
                    <td class="abs-col col-al">
                        <?= $value->nama; ?><br>
                        <?= $value->definisi . ' (' . $value->golongan . ')'; ?><br>
                        <?= $value->nip; ?>
                    </td>
                    <td class="abs-col"><?= $value->jabatan; ?></td>

                    <? for ($i = 1; $i <= $days; $i++) :  $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i)) ?>
                        <? if ((date('N', strtotime($year . '-' . $month . '-' . $i)) < 6) && !in_array($date, $liburs)) : ?>
                            <? if ($date > date('Y-m-d')) : ?>
                                <td class="abs-col-tgl"></td>
                            <? elseif (empty($value->{$date})) : ?>
                                <td class="abs-col-tgl">A</td>
                            <? elseif ($value->{$date} == 'masuk') : ?>
                                <td class="abs-col-tgl">
                                    <img class="ttd" src="<? echo base_url("{$value->tandatangan}?v={date('mdYhisa', time())}"); ?>">
                                </td>
                            <? elseif ($value->{$date} == 'izin') : ?>
                                <td class="abs-col-tgl">I</td>
                            <? elseif ($value->{$date} == 'sakit') : ?>
                                <td class="abs-col-tgl">S</td>
                            <? else : ?>
                                <td class="abs-col-tgl">DL / DP</td>
                            <? endif; ?>
                        <? else : ?>
                            <td class="abs-col-tgl bg-danger" style="border: solid; border-color: black;"></td>
                        <? endif; ?>
                    <? endfor; ?>
                </tr>
            <? endforeach; ?>
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
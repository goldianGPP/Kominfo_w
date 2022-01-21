<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Tabel Absensi</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-item active">BULAN <?= $monthname . ' ' . $year; ?></li>
			</ol>
			<div class="row">
				<div class="card">
					<div class="card-body" style="overflow-y: scroll; height: 450px;">
						<a href="<?= base_url('menu/home/print') ?>" type="button" class="btn btn-info text-white" style="float: left; margin-right: 5px;">Print</a>
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
								<? foreach ($absens as $key => $value) :?>
									<tr>
										<td class="abs-col"><?= $key+1; ?></td>
										<td class="abs-col col-al">
											<?= $value->nama; ?><br>
											<?= $value->definisi . ' (' . $value->golongan . ')'; ?><br>
											<?= $value->nip; ?>
										</td>
										<td class="abs-col"><?= $value->jabatan; ?></td>

										<?for ($i=1; $i < $days ; $i++) :  $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i)) ?>
											<? if ((date('N', strtotime($year . '-' . $month . '-' . $i)) < 6)) : ?>
												<? if ($date > date('Y-m-d')) : ?>
													<td class="abs-col-tgl"></td>
												<? elseif (empty($value->{$date})) : ?>
													<td class="abs-col-tgl">A</td>
												<? elseif ($value->{$date} == 'masuk') : ?>
													<td class="abs-col-tgl">
														<img class="ttd" src="<? echo base_url($value->tandatangan); ?>">
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
					</div>
				</div>
			</div>
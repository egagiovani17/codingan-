<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success" role="alert">
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php endif; ?>
				<div class="page-header">
						<h4 class="page-title">Data Kas</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= site_url('home/halaman');?>">
									<i class="flaticon-home" style="font-size:20px;"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<a href="<?= site_url('home/tambah') ;?>" class="btn btn-success"><i class="fas fa-plus"></i>Pemasukan</a>
									<a href="<?= site_url('home/kurang') ;?>" class="btn btn-primary"><i class="fas fa-plus"></i>Pengeluaran</a>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>No</th>
													<th>Tanggal</th>
													<th>Kode Rekening</th>
													<th>Uraian</th>
													<th>Penerimaan</th>
													<th>Pengeluaran</th>
													<th>Saldo</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>No</th>
													<th>Tanggal</th>
													<th>Kode Rekening</th>
													<th>Uraian</th>
													<th>Penerimaan</th>
													<th>Pengeluaran</th>
													<th>Saldo</th>
													<th>Aksi</th>
												</tr>
											</tfoot>
											<tbody>
											<?php
												$no=1; 
												foreach($kas as $a) :
											?>
												<?php 
												$saldo += $a->debit - $a->kredit; 
												$saldo1 +=$a->debit;
												$saldo2 +=$a->kredit;
												?> 
												<tr>
													<td><?= $no++ ;?></td>
													<td><?= $a->tgl;?></td>
													<td><?= $a->kdrek ;?></td>
													<td><?= $a->ket ;?></td>
													<td>Rp. <?= number_format($a->debit) ;?></td>
													<td>Rp. <?= number_format($a->kredit) ;?></td>
													<td>Rp.<?= number_format($saldo) ;?></td>
													<td>
													<a href="<?= site_url('home/edit1/').$a->idkas ;?>" class="btn btn-small text-primary" width="300px" height="400px"><i class="fas fa-edit"></i></a>
													<a onclick="deleteConfirm('<?php echo site_url('home/hapus2/'.$a->idkas) ?>')" href="#!" class="btn btn-small text-danger"><i class="fas fa-trash"></i></a>
													</td>
													<?php endforeach ;?>
													<?php $total += $saldo+0 ;?>
													<?php $total1 += $saldo1+0 ;?>
													<?php $total2 += $saldo2+0 ;?>
												</tr>
											</tbody>
													<tr>
														<th colspan="4"><center><h2>Total</h2></center></th>
														<th><b><h2>Rp.<?= number_format($total1) ;?></h2></b></th>
														<th><b><h2>Rp.<?= number_format($total2) ;?></h2></b></th>
														<td colspan="2"><b><h2>Rp.<?= number_format($total) ;?></h2></b></td>
													</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
<script>
function deleteConfirm(url){
	$('#btn-delete').attr('href', url);
	$('#deleteModal').modal();
}
</script>
<!-- Logout Delete Confirmation-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
      </div>
    </div>
  </div>
</div>
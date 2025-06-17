 <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

	$id = $_SESSION['admin']['id_member'];
	$hasil = $lihat -> member_edit($id);
?>
	<h4>Keranjang Penjualan</h4>
	<br>
	<?php if(isset($_GET['success'])){?>
	<div class="alert alert-success">
		<p>Edit Data Berhasil !</p>
	</div>
	<?php }?>
	<?php if(isset($_GET['remove'])){?>
	<div class="alert alert-danger">
		<p>Hapus Data Berhasil !</p>
	</div>
	<?php }?>
	<div class="row">
		<div class="col-sm-4">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-search"></i> Cari Barang</h5>
				</div>
				<div class="card-body">
					<input type="text" id="cari" class="form-control" name="cari" placeholder="Masukan : Kode / Nama Barang  [ENTER]">
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-list"></i> Hasil Pencarian</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div id="hasil_cari"></div>
						<div id="tunggu"></div>
					</div>
				</div>
			</div>
		</div>
		

		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-shopping-cart"></i> KASIR
					<a class="btn btn-danger float-right" 
						onclick="javascript:return confirm('Apakah anda ingin reset keranjang ?');" href="fungsi/hapus/hapus.php?keranjang=jual">
						<b>RESET KERANJANG</b></a>
					</h5>
				</div>
				<div class="card-body">
					<div id="keranjang" class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td><b>Tanggal</b></td>
								<td><input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i");?>" name="tgl"></td>
							</tr>
						</table>
						<table class="table table-bordered w-100" id="example1">
							<thead>
								<tr>
									<td> No</td>
									<td> Nama Barang</td>
									<td style="width:10%;"> Jumlah</td>
									<td style="width:20%;"> Total</td>
									<td> Kasir</td>
									<td> Aksi</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$total_bayar=0; $no=1; $id = $_SESSION['admin']['id_member'];
								$hasil_penjualan = $lihat -> keranjang($id);
								?>
								<?php foreach($hasil_penjualan  as $isi){?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $isi['nama_barang'];?></td>
									<td>
										<!-- aksi ke table penjualan -->
										<form method="POST" action="fungsi/edit/edit.php?jual=jual">
												<input type="number" name="jumlah" value="<?php echo $isi['jumlah'];?>" class="form-control">
												<input type="hidden" name="id" value="<?php echo $isi['id_keranjang'];?>" class="form-control">
												<input type="hidden" name="id_barang" value="<?php echo $isi['id_barang'];?>" class="form-control">
											</td>
											<td>Rp.<?php echo number_format($isi['total']);?>,-</td>
											<td><?php echo $isi['nm_member'];?></td>
											<td>
												<button type="submit" class="btn btn-warning">Update</button>
										</form>
										<!-- aksi ke table penjualan -->
										<a href="fungsi/hapus/hapus.php?jual=jual&id=<?php echo $isi['id_keranjang'];?>&brg=<?php echo $isi['id_barang'];?>
											&jml=<?php echo $isi['jumlah']; ?>"  class="btn btn-danger"><i class="fa fa-times"></i>
										</a>
									</td>
								</tr>
								<?php $no++; $total_bayar += $isi['total'];}?>
							</tbody>
					</table>
					<br/>
					<?php $hasil = $lihat -> jumlah(); ?>
					<div id="kasirnya">
						<table class="table table-stripped">
							<?php
							// proses bayar dan ke nota
							$bayar = '';
							$hitung = '';
							if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_bayar'])) {

								$total = (int) $_POST['total'];
$bayar = (int) $_POST['bayar'];

								if(!empty($bayar))
								{
									$hitung = $bayar - $total;
									if($bayar >= $total)
									{// ambil data dari keranjang
										$sql_keranjang = "SELECT * FROM keranjang WHERE id_member = ?";
										$stmt_keranjang = $config->prepare($sql_keranjang);
										$stmt_keranjang->execute([$id]);
										$data_keranjang = $stmt_keranjang->fetchAll();
										$id_nota = 'NT' . date('YmdHis') . $id;
										foreach ($data_keranjang as $item) {
											// Insert ke tabel penjualan
											$sql_penjualan = "INSERT INTO penjualan (id_barang, id_member, jumlah, total, tanggal_input)
															VALUES (?, ?, ?, ?, ?)";
											$stmt_penjualan = $config->prepare($sql_penjualan);
											$stmt_penjualan->execute([
												$item['id_barang'],
												$item['id_member'],
												$item['jumlah'],
												$item['total'],
												$item['tanggal_input']
											]);

											// Insert ke tabel nota
											$periode = date('m-Y');
											$sql_nota = "INSERT INTO nota (id_nota, id_barang, id_member, jumlah, total, tanggal_input, periode)
            								 VALUES (?, ?, ?, ?, ?, ?, ?)";
											$stmt_nota = $config->prepare($sql_nota);
											$stmt_nota->execute([
												$id_nota,
												$item['id_barang'],
												$item['id_member'],
												$item['jumlah'],
												$item['total'],
												$item['tanggal_input'],
												$periode
											]);

											// Update stok barang
											$sql_barang = "SELECT stok FROM barang WHERE id_barang = ?";
											$stmt_barang = $config->prepare($sql_barang);
											$stmt_barang->execute([$item['id_barang']]);
											$stok = $stmt_barang->fetchColumn();
											$stok_baru = $stok - $item['jumlah'];

											$sql_update_stok = "UPDATE barang SET stok = ? WHERE id_barang = ?";
											$stmt_update_stok = $config->prepare($sql_update_stok);
											$stmt_update_stok->execute([$stok_baru, $item['id_barang']]);
										}

										// kosongkan keranjang
										$sql_clear = "DELETE FROM keranjang WHERE id_member = ?";
										$stmt_clear = $config->prepare($sql_clear);
										$stmt_clear->execute([$id]);

										 header("Location: print.php?nm_member=" . urlencode($_SESSION['admin']['nm_member']) .
               "&id_nota=$id_nota&bayar=$bayar&kembali=$hitung");
        exit;
										}
										echo '<script>alert("Belanjaan Berhasil Di Bayar !");</script>';
									}else{
										echo '<script>alert("Uang Kurang ! Rp.'.$hitung.'");</script>';
									}
								}
							?>
							<!-- aksi ke table nota -->
							<form method="POST" action="index.php?page=jual#kasirnya">
								<?php foreach($hasil_penjualan as $isi){;?>
									<input type="hidden" name="id_barang[]" value="<?php echo $isi['id_barang'];?>">
									<input type="hidden" name="id_member[]" value="<?php echo $isi['id_member'];?>">
									<input type="hidden" name="jumlah[]" value="<?php echo $isi['jumlah'];?>">
									<input type="hidden" name="total1[]" value="<?php echo $isi['total'];?>">
									<input type="hidden" name="tgl_input[]" value="<?php echo $isi['tanggal_input'];?>">
									<input type="hidden" name="periode[]" value="<?php echo date('m-Y');?>">
								<?php $no++; }?>
								<tr>
									<td>Total Semua  </td>
									<td><input type="text" class="form-control" name="total" value="<?php echo $total_bayar;?>" readonly></td>
								
									<td>Bayar  </td>
									<td><input type="number" class="form-control" name="bayar" value="<?php echo isset($bayar) ? $bayar : ''; ?>" required></td>
									<td><button type="submit" name="submit_bayar" class="btn btn-success">
<i class="fa fa-shopping-cart"></i> Bayar</button>
									<?php  if (!empty($_GET['nota']) && $_GET['nota'] == 'yes') {?>
										<a class="btn btn-danger" href="fungsi/hapus/hapus.php?keranjang=jual">
										<b>RESET</b></a></td><?php }?></td>
								</tr>
							</form>
							<!-- aksi ke table nota -->
							<tr>
								<td>Kembali</td>
								<td><input type="text" class="form-control" value="<?php echo isset($hitung) ? $hitung : '0'; ?>" readonly></td>
								<td></td>
								<td>
									<a href="print.php?nm_member=<?php echo $_SESSION['admin']['nm_member']; ?>
&id_nota=<?php echo $id_nota; ?>
&bayar=<?php echo $bayar; ?>
&kembali=<?php echo $hitung; ?>" target="_blank">

									<button class="btn btn-secondary">
										<i class="fa fa-print"></i> Print Untuk Bukti Pembayaran
									</button></a>
								</td>
							</tr>
						</table>
						<br/>
						<br/>
					</div>
				</div>
			</div>
		</div>
	</div>
	

<script>
// AJAX call for autocomplete 
$(document).ready(function(){
	$("#cari").change(function(){
		$.ajax({
			type: "POST",
			url: "fungsi/edit/edit.php?cari_barang=yes",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#hasil_cari").hide();
				$("#tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html){
				$("#tunggu").html('');
				$("#hasil_cari").show();
				$("#hasil_cari").html(html);
			}
		});
	});
});
//To select country name
</script>
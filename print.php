<?php 
	@ob_start();
	session_start();
	if(!empty($_SESSION['admin'])){ }else{
		echo '<script>window.location="login.php";</script>';
        exit;
	}
	require 'config.php';
	include $view;
	$lihat = new view($config);
	$toko = $lihat -> toko();
	$id_member = $_SESSION['admin']['id_member'];
$id_nota = isset($_GET['id_nota']) ? $_GET['id_nota'] : '';
$hsl = $lihat->penjualan_by_nota($id_nota);
?>
<html>
	<head>
		<title>print</title>
		<link rel="stylesheet" href="assets/css/bootstrap.css">
	</head>
	<body>
<style>
    @media print {
        .noprint { display: none; }
    }
    hr.split-line {
        border: 0;
        border-top: 2px dashed black;
        margin: 20px 0;
    }
</style>

<script>window.print();</script>

<div class="container">
  <!-- NOTA PELANGGAN -->
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <center>
        <p><strong><?php echo $toko['nama_toko'];?></strong></p>
        <p><?php echo $toko['alamat_toko'];?></p>
        <p>Tanggal : <?php  echo date("j F Y, G:i");?></p>
        <p>Kasir : <?php  echo htmlentities($_GET['nm_member']);?></p>
      </center>
      <p>ID Nota : <?php echo htmlentities($_GET['id_nota']); ?></p>
      <table class="table table-bordered" style="width:100%;">
        <tr>
          <td>No.</td>
          <td>Barang</td>
          <td>Jumlah</td>
          <td>Total</td>
        </tr>
        <?php $total_transaksi = 0; $no=1; foreach($hsl as $isi){
          $total_transaksi += $isi['total']; ?>
          <tr>
            <td><?php echo $no++;?></td>
            <td><?php echo $isi['nama_barang'];?></td>
            <td><?php echo $isi['jumlah'];?></td>
            <td>Rp.<?php echo number_format($isi['total']);?></td>
          </tr>
        <?php } ?>
      </table>
      <div class="pull-right">
        Total : Rp.<?php echo number_format($total_transaksi); ?>,-<br/>
        Bayar : Rp.<?php echo number_format(htmlentities($_GET['bayar']));?>,-<br/>
        Kembali : Rp.<?php echo number_format(htmlentities($_GET['kembali']));?>,-
      </div>
      <div class="clearfix"></div>
      <center>
        <p>Terima Kasih Telah berbelanja di toko kami !</p>
      </center>
    </div>
    <div class="col-sm-4"></div>
  </div>

  <!-- GARIS PEMISAH -->
  <hr class="split-line">

  <!-- NOTA KITCHEN -->
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <center>
        <p><strong><?php echo $toko['nama_toko'];?></strong></p>
        <p><?php echo $toko['alamat_toko'];?></p>
        <p>Tanggal : <?php  echo date("j F Y, G:i");?></p>
        <p>Kasir : <?php  echo htmlentities($_GET['nm_member']);?></p>
      </center>
      <p>ID Nota : <?php echo htmlentities($_GET['id_nota']); ?></p>
      <table class="table table-bordered" style="width:100%;">
        <tr>
          <td>No.</td>
          <td>Barang</td>
          <td>Jumlah</td>
        </tr>
        <?php $no=1; foreach($hsl as $isi){ ?>
          <tr>
            <td><?php echo $no++;?></td>
            <td><?php echo $isi['nama_barang'];?></td>
            <td><?php echo $isi['jumlah'];?></td>
          </tr>
        <?php } ?>
      </table>
      <center class="noprint">
        <a href="index.php?page=jual" class="btn btn-primary mt-2">Kembali ke Kasir</a>
      </center>
    </div>
    <div class="col-sm-4"></div>
  </div>
</div>
</body>

</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    if (!empty($_GET['kategori'])) {
        $nama= htmlentities(htmlentities($_POST['kategori']));
        $tgl= date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori,tgl_input) VALUES(?,?)';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
    }

    if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $merk = htmlentities($_POST['merk']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $id;
        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang,id_kategori,nama_barang,merk,harga_beli,harga_jual,satuan_barang,stok,tgl_input) 
			    VALUES (?,?,?,?,?,?,?,?,?) ';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
    }
    
    if (!empty($_GET['jual'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $id_barang = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id_barang)) {
    die("❌ ID Barang tidak ditemukan!");
}


    $sql = 'SELECT * FROM barang WHERE id_barang = ?';
    $row = $config->prepare($sql);
    $row->execute([$id_barang]);
    $barang = $row->fetch();

    if ($barang && $barang['stok'] > 0) {
        $id_member = $_SESSION['admin']['id_member'];
        $jumlah = 1;
        $total = $barang['harga_jual'];
        $tanggal = date("Y-m-d H:i:s");

        $data = [$id_barang, $id_member, $jumlah, $total, $tanggal];

        $sql = 'INSERT INTO keranjang (id_barang, id_member, jumlah, total, tanggal_input) 
                VALUES (?, ?, ?, ?, ?)';
        $stmt = $config->prepare($sql);
        $stmt->execute($data);

        echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
    } else {
        echo '<script>alert("❌ Stok habis atau barang tidak ditemukan."); 
              window.location="../../index.php?page=jual"</script>';
    }
}



}

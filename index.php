<?php 

session_start();

if (!isset($_SESSION["login"])){
	header('Location: login.php');
	exit;
}

require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerhalaman = 2;
$jumlahData = count(query("SELECT * FROM murid"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
// halaman 2, awalData = 2
// halaman 3, awalData = 4
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
// if(isset($_GET["halaman"])){
// 	$halamanAktif = $_GET["halaman"];
// } else {
// 	$halamanAktif = 1;
// }

// var_dump($halamanAktif);

$murids = query("SELECT * FROM murid LIMIT $awalData, $jumlahDataPerhalaman");

// tombol cari ditekan
if ( isset($_POST["cari"]) ){
	$murids = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
	<style type="text/css">
		.loader {
			width: 100px;
			z-index: 1;
			position: absolute;
			top: 110px;
			left: 300px;
			display: none;
		}

		@media print{
			.logout, .tambah , .form-cari{
				display: none;
			}
		}
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css"> -->
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">DATA MURID XII TKJ I</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <form class="d-flex">
        <button class="btn btn-light" type="submit"><a href="logout.php">Logout</a></button>
      </form>
    </div>
  </div>
</nav>
	<!-- END NAVBAR -->

<div class="container">
	<br>
	<button class="btn btn-primary tambah" type="submit"><a href="tambah.php" style="text-decoration: none; color: white; ">Tambah Murid</a></button>
	<br>
	<br>

	<form action="" method="POST" class="form-cari">
		<input class="form-control me-2" type="text" placeholder="Cari murid" aria-label="Search" name="keyword" autocomplete="off" autofocus style="margin-bottom: 5px;">
		<!-- <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off" id="keyword"> -->
		
		<button class="btn btn-primary" type="submit" name="cari" id="tombol-cari">Cari!</button>
		<img src="img/loader.gif" class="loader">
	</form>



	<!-- navigasi -->
	<!-- previous -->

	<!-- <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>

		<?php if($i == $halamanAktif ) : ?>
			<a href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: red;"><?php echo $i; ?></a>
		<?php else : ?>
			<a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php endif; ?>

	<?php endfor; ?> -->

	<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
    <?php if ( $halamanAktif > 1 ) : ?>
      <a class="page-link" href="?halaman=<?php echo $halamanAktif - 1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        
      </a>
    <?php endif; ?>
    </li>
    <li class="page-item" style="margin-left: 1050px">
	<?php if ( $halamanAktif < $jumlahHalaman ) : ?>
      <a class="page-link" href="?halaman=<?php echo $halamanAktif + 1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>

      </a>
    <?php endif; ?>
    </li>
  </ul>
</nav>

	<div id="container-sm">
	<table border="2" cellspacing="0" cellpadding="10" class="table table-striped table-bordered nowrap" id="example">
		<tr>
			<th>No.</th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>Absen</th>
			<th>Nama</th>
			<th>Jurusan</th>
			<th>E-Mail</th>
		</tr>

		<?php $i = 1; ?>
		<?php foreach ( $murids as $murid ) : ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td>
				<a href="ubah.php?id=<?php echo $murid["id"]; ?>">Ubah</a> | 
				<a href="hapus.php?id=<?php echo $murid["id"]; ?>" onclick="return confirm('yakin');">hapus</a>
			</td>
			<td><img src="img/<?php echo $murid["gambar"]; ?>"></td>
			<td><?php echo $murid["absen"]; ?></td>
			<td><?php echo $murid["nama"]; ?></td>
			<td><?php echo $murid["jurusan"]; ?></td>
			<td><?php echo $murid["email"]; ?></td>
		<?php $i++ ?>
		<?php endforeach; ?>
		</tr>
	</table>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
<!-- <script type="text/javascript">
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader( table );
} );
</script> -->
</html>
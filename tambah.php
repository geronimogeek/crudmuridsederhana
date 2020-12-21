<?php 

session_start();

if (!isset($_SESSION["login"])){
	header('Location: login.php');
	exit;
}

include 'functions.php';

if ( isset($_POST["submit"])){

	// var_dump($_POST);
	// var_dump($_FILES);
	// die;
	
	// cek apakah berhasil data di tambahkan atau tidak
	// var_dump(mysqli_affected_rows($conn));
	if ( tambah($_POST) > 0 ){ 
		echo "<script>
		alert('Data berhasil ditambahkan');
		document.location.href = 'index.php';
		</script>";
	} else {
		echo "<script>
		alert('Data gagal ditambahkan');
		document.location.href = 'index.php';
		</script>";
	}

}

?>


<!DOCTYPE html>
<html>	
<head>
	<title>Tambah Data</title>
</head>
<body>

	<h1>Tambah data siswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="nama">Nama :</label>
				<input type="text" name="nama" id="nama" placeholder="Masukkan nama" required>
			</li>
			<li>
				<label for="absen">Absen :</label>
				<input type="text" name="absen" id="absen" placeholder="Masukkan nomor absen" required>
			</li>
			<li>
				<label for="jurusan">Jurusan :</label>
				<input type="text" name="jurusan" id="absen" placeholder="Masukkan jurusan" required>
			</li>
			<li>
				<label for="email">E-Mail :</label>
				<input type="text" name="email" id="email" placeholder="Masukkan E-Mail" required>
			</li>
			<li>
				<label for="gambar">Gambar :</label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit">Tambah data!</button>
			</li>
		</ul>
	</form>

	<a href="index.php">Kembali!</a>

</body>
</html>
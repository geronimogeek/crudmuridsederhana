<?php 

session_start();

if (!isset($_SESSION["login"])){
	header('Location: login.php');
	exit;
}

include 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data murid berdasarkan id
$murid = query("SELECT * FROM murid WHERE id = $id")[0];

if ( isset($_POST["submit"])){
	
	// cek apakah berhasil data di tambahkan atau tidak
	// var_dump(mysqli_affected_rows($conn));
	if ( ubah($_POST) > 0 ){ 
		echo "<script>
		alert('Data berhasil diubah');
		document.location.href = 'index.php';
		</script>";
	} else {
		echo "<script>
		alert('Data gagal diubah');
		document.location.href = 'index.php';
		</script>";
	}

}

?>


<!DOCTYPE html>
<html>	
<head>
	<title>Ubah Data</title>
</head>
<body>

	<h1>Ubah data siswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $murid["id"]; ?>">
		<input type="hidden" name="gambarLama" value="<?php echo $murid["gambar"]; ?>">
		<ul>
			<li>
				<label for="nama">Nama :</label>
				<input type="text" name="nama" id="nama" placeholder="Masukkan nama" required value="<?php echo $murid["nama"]; ?>">
			</li>
			<br>
			<li>
				<label for="absen">Absen :</label>
				<input type="text" name="absen" id="absen" placeholder="Masukkan nomor absen" required value="<?php echo $murid["absen"]; ?>">
			</li>
			<br>
			<li>
				<label for="jurusan">Jurusan :</label>
				<input type="text" name="jurusan" id="absen" placeholder="Masukkan jurusan" required value="<?php echo $murid["jurusan"]; ?>">
			</li>
			<br>
			<li>
				<label for="email">E-Mail :</label>
				<input type="text" name="email" id="email" placeholder="Masukkan E-Mail" required value="<?php echo $murid["email"]; ?>">
			</li>
			<br>
			<li>
				<label for="gambar">Gambar :</label>
				<img src="<?php echo $murid["gambar"]; ?>" width="69">
				<br>
				<input type="file" name="gambar" id="gambar">
			</li>
			<br>
			<li>
				<button type="submit" name="submit">Ubah data!</button>
			</li>
		</ul>
	</form>

	<a href="index.php">Kembali!</a>

</body>
</html>
<?php 

include 'functions.php';

if ( isset($_POST["daftar"]) ){
	if ( daftar($_POST) > 0 ){
		echo "<script>alert('User baru berhasil ditambahkan')</script>";
	} else {
		echo mysqli_error($conn);
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		label {
			display: inline-block;
		}
	</style>
</head>
<body>

	<h1>Halaman Daftar</h1>

	<form action="" method="post">
		<ul>
			<li>
				<label for="username">Username :</label>
				<input type="text" name="username" placeholder="Username" id="username">
			</li>
			<li>
				<label for="password">Password :</label>
				<input type="password" name="password" placeholder="Password" id="password">
			</li>
			<li>
				<label for="password2">Konfirmasi password :</label>
				<input type="password" name="password2" placeholder="Konfirmasi Password" id="password2">
			</li>
			<li>
				<button type="submit" name="daftar">Daftar</button>
			</li>
		</ul>
	</form>

</body>
</html>
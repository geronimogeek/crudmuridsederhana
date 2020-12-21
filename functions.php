<?php 

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// ambil data murid
function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ( $row = mysqli_fetch_assoc($result) ){
		$rows[] = $row;
	}
	return $rows;
}

function tambah($data){
	global $conn;
	// ambil data tiap elemen dalam form
	$absen = htmlspecialchars($data["absen"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	// upload gambar
	$gambar = upload();
	if ( !$gambar ) {
		return false;
	}

	// query data murid
	$query = "INSERT INTO murid VALUES ('', '$absen', '$nama', '$email', '$jurusan', '$gambar')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload(){

	$namaFile = $_FILES["gambar"]["name"];
	$ukuranFile = $_FILES["gambar"]["size"];
	$error = $_FILES["gambar"]["error"];
	$tmpName = $_FILES["gambar"]["tmp_name"];

	// cek apakah tidak ada gambar yang diupload
	if ($error === 4){
		echo "<script>alert('Upload gambar terlebih dahulu!')</script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'png', 'jpeg', 'gif'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>alert('Ekstensi yang anda upload bukan gambar!')</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ( $ukuranFile > 10000000 ) {
		echo "<script>alert('Gambar yang anda masukkan terlalu besar!')</script>";
		return false;
	}

	// lolos pengecheckan gambar siap di upload
	// generate nama gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	// var_dump($namaFileBaru);
	// die;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;

}

function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM murid WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function ubah($data){
	global $conn;
	$id = $data["id"];
	// ambil data tiap elemen dalam form
	$absen = htmlspecialchars($data["absen"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// check apakah user pilih gambar baru atau tidak
	if ($_FILES['gambar']['error'] === 4){
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}

	// query data murid
	$query = "UPDATE murid SET 
				absen = '$absen',
				nama = '$nama',
				email = '$email',
				jurusan = '$jurusan',
				gambar = '$gambar' WHERE id = $id
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function cari($keyword){
	$query = "SELECT * FROM murid WHERE 
				nama LIKE '%$keyword%' OR
				absen LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword' OR
				email LIKE '%$keyword%'
			";
			return query($query);
}

function daftar($data){
	global $conn;
	$username = htmlspecialchars(strtolower(stripslashes($data["username"])));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// check username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
	if ( mysqli_fetch_assoc($result) ){
		echo "<script>alert('Username sudah di gunakan!')</script>";
		return false;
	}

	// check konfirmasi password
	if ( $password !== $password2 ){
		echo "<script>alert('Konfirmasi password tidak sesuai!')</script>";
		return false;
	}

	// enkripsi passsword
	$password = password_hash($password, PASSWORD_DEFAULT);
	// var_dump($password);
	// die;

	// tambahkan user baru ke database
	mysqli_query($conn, "INSERT INTO users VALUE('', '$username', '$password') ");
	mysqli_affected_rows($conn);

}

?>
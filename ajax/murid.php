<?php 

// sleep(1);
usleep(500000);
include '../functions.php';

$keyword = $_GET["keyword"];
$query = "SELECT * FROM murid WHERE
				nama LIKE '%$keyword%' OR
				absen LIKE '%$keyword%' OR
				email LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword'
		";
$murids = query($query);

// var_dump($murids);


?>

<table border="1" cellspacing="0" cellpadding="10">
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
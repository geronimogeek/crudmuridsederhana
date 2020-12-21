<?php 

session_start();
include 'functions.php';

// check cookie
// if( isset($_COOKIE['login']) ){
// 	if ($_COOKIE['login'] == 'true'){
// 		$_SESSION['login'] = true;
// 	}

if (isset($_COOKIE['id']) && isset($_COOKIE['id'])) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];

	// ambil username berdasarkan id
	$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
	$row = mysqli_fetch_assoc($result);

	// check cookie dan username
	if ( $key === hash('sha256', $row['username']) ){
		$_SESSION['login'] = true;
	}
}



if(isset($_SESSION["login"])){
	header('Location: index.php');
	exit;
}


if ( isset($_POST["login"])){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

	// check username
	if ( mysqli_num_rows($result) == 1 ){

		// check password
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row["password"])){
			// set session
			$_SESSION["login"] = true;

			// check remember me
			if ( isset($_POST["remember"]) ){
				// buat cookie
				setcookie('id', $row['id'], time()+60);
				setcookie('key', hash('sha256', $row['username']), time()+60);
			}

			header("Location: index.php");
			exit;
		}

	}

	// check pesan kesalahan
	$error = true;

}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>
<body>

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">	
		  <div class="container-fluid">
		    <h1 class="tkj navbar-brand" href="#">WELCOME TO WEBSITE XII TKJ I</h1>
		    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button> -->
		    <!-- <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="#">Home</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">Link</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
		        </li>
		      </ul> -->
		      <!-- <form class="d-flex">
		        <input class="form-control me-2" type="search" placeholder="Cari disini" aria-label="Search">
		        <button type="submit" class="btn btn-warning">Cari</button>
		      </form> -->
		    <!-- </div> -->
		  </div>
	</nav>
	<!-- END NAVBAR -->

	<div class="container">
     	<div class="row justify-content-center mt-5">
        	<div class="col-md-4">
         		<div class="card">
            		<div class="card-header bg-transparent mb-0"><h5 class="text-center">Login <span class="font-weight-bold text-primary">XII TKJ I</span></h5></div>
            	<div class="card-body">
					<form action="" method="post" class="row g-3 needs-validation" novalidate>
					<ul>
					<div class="mb-3">
						<label for="username" class="form-label">Username :</label>
						<input type="text" name="username" id="username" placeholder="Username" class="form-control" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Password :</label>
						<input type="password" name="password" id="password" placeholder="Password" class="form-control">
					</div>
					<div id="emailHelp" class="form-text">We'll never share your username and password with anyone else.</div>
					<div class="form-check form-switch">
						<label for="rembember" class="form-check-label">Remember me!</label>
						<input type="checkbox" name="remember" id="remember" placeholder="remember" class="form-check-input">
					</div>
					<button type="submit" name="login" class="btn btn-primary">Login</button>
					<br>
					<center>
						<?php if ( isset($error) ) : ?>
							<p>Username/Password salah!</p>
						<?php endif; ?>
					</center>
					</ul>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

</body>
</html>
<?php

session_start();

if(!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

require 'functions.php';

if(isset($_POST["submit"]))
{

	if(tambah($_POST) > 0 )
	{
		// echo "Data berhasil ditambahkan";
		echo "
			<script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'index.php';
			</script>
		";
	}
	else
	{
		// echo "Data gagal ditambahkan !!!";
		echo "
			<script>
                alert('Data gagal ditambahkan');
                document.location.href = 'index.php';
			</script>
		";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Tambah Data Mahasiswa</title>
	<style>
		h1 {
			font-weight: lighter;
			font-family: open sans;
		}

		td {
			font-weight: lighter;
			font-family: open sans;	
		}
	</style>
</head>
<body>
	<h1>Tambah Data Mahasiswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><label for="nama">Nama</label></td>
			<td><input type="text" name="nama" id="nama"></td>
		</tr>
		<tr>
			<td><label for="nim">NIM</label></td>
			<td><input type="text" name="nim" id="nim"></td>
		</tr>
		<tr>
			<td><label for="jurusan">Jurusan</label></td>
			<td><input type="text" name="jurusan" id="jurusan"></td>
		</tr>
		<tr>
			<td><label for="email">Email</label></td>
			<td><input type="text" name="email" id="email"></td>
		</tr>
		<tr>
			<td><label for="gambar">Gambar</label></td>
			<td><input type="file" name="gambar" id="gambar"></td>
		</tr>
		<tr>
			<td></td>
			<td><button type="submit" name="submit">Tambah</button></td>
		</tr>
	</table>
	</form>
</body>
</html>
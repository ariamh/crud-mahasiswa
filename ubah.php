<?php

session_start();

if(!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

require 'functions.php';

$id  = $_GET["id"];

$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if(isset($_POST["submit"]))
{
	if(ubah($_POST) > 0 )
	{
		// echo "Data berhasil diubah";
		echo "
			<script>
                alert('Data berhasil diubah');
                document.location.href = 'index.php';
			</script>
		";
	}
	else
	{
		// echo "Data gagal diubah !!!";
		echo "
			<script>
                alert('Data gagal diubah');
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
	<title>Ubah Data Mahasiswa</title>
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
	<h1>Ubah Data Mahasiswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $mhs["id"];?>">
	<input type="hidden" name="gambarLama" value="<?= $mhs["gambar"];?>">
	<table>
		<tr>
			<td><label for="nama">Nama</label></td>
			<td><input type="text" name="nama" id="nama" value="<?= $mhs["nama"]; ?>"></td>
		</tr>
		<tr>
			<td><label for="nim">NIM</label></td>
			<td><input type="text" name="nim" id="nim" value="<?= $mhs["nim"]; ?>"></td>
		</tr>
		<tr>
			<td><label for="jurusan">Jurusan</label></td>
			<td><input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>"></td>
		</tr>
		<tr>
			<td><label for="email">Email</label></td>
			<td><input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>"></td>
		</tr>
		<tr>
			<td valign="top"><label for="gambar">Gambar</label></td>
			<td><img src="gambar/<?= $mhs["gambar"]; ?>" width="65"><br>
				<input type="file" name="gambar" id="gambar"></td>
		</tr>
		<tr>
			<td></td>
			<td><button type="submit" name="submit">Ubah</button></td>
		</tr>
	</table>
	</form>
</body>
</html>
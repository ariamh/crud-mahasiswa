<?php

session_start();

if(!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

require 'functions.php';

$mahasiswa = query("SELECT * FROM mahasiswa");

// Tombol cari diklik
if(isset($_POST["cari"]))
{
	$mahasiswa = cari($_POST["keyword"]); 
}

$no        = 1;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Halaman Admin</title>
	<style>
		a {
			font-weight: lighter;
			font-family: open sans;
			text-decoration: none;
			color: blue;
		}

		h1, td {
			font-weight: lighter;
			font-family: open sans;
		}

		th {
			font-weight: normal;
			font-family: open sans;	
		}
	</style>
</head>
<body>

<a href="logout.php">Logout</a>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php">Tambah Data Mahasiswa</a>
<br>
<br>

<table border="1" cellspacing="0" cellpadding="7">
	<tr>
		<th>No</th>
		<th>NIM</th>
		<th>Nama</th>
		<th>Jurusan</th>
		<th>Email</th>
		<th>Photo</th>
		<th>Aksi</th>
	</tr>

		<?php foreach( $mahasiswa as $row ) :?>
	<tr>
		<td><?= $no++; ?></td>
		<td><?= $row['nim']; ?></td>
		<td><?= $row['nama']; ?></td>
		<td><?= $row['jurusan']; ?></td>
		<td><?= $row['email']; ?></td>
		<td><img src='gambar/<?= $row['gambar']; ?>' width='55'></td>
		<td><a href="ubah.php?id=<?= $row['id']; ?>">Ubah</a> |
			<a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Apakah anda yakin ?');">Hapus</a>
		</td>
	</tr>
		<?php endforeach; ?>
</table>
</body>
</html>
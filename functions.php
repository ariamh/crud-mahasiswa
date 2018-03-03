<?php 

// koneksi ke database
$conn = mysqli_connect("localhost","root","123456","dbstudent");

function query($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows   = [];
	while($row = mysqli_fetch_assoc($result))
	{
		$rows[] = $row;
	}

	return $rows;
}


function tambah($data)
{
	global $conn;
	// ambil dari tiap elemen dalam form
	$nama 	 = htmlspecialchars($data["nama"]);
	$nim 	 = htmlspecialchars($data["nim"]);
	$email 	 = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	// upload gambar
	$gambar  = upload();
	if(!$gambar)
	{
		return false;
	}

	// query insert data
	$query 	 = "INSERT INTO mahasiswa VALUES (null,'$nama', '$nim', '$email', '$jurusan', '$gambar')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);

}


function upload()
{
	$namaGambar   = $_FILES['gambar']['name'];
	$ukuranGambar = $_FILES['gambar']['size'];
	$tmpGambar	  = $_FILES['gambar']['tmp_name'];
	$error        = $_FILES['gambar']['error'];

	// cek apakah tidak ada gambar yang diupload
	if($error === 4)
	{
		echo "
			<script>
                alert('Pilih gambar terlebih dahulu');
			</script>";

		return false;
	}

	// cek ektensi gambar yang diupload
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar 	 = explode('.', $namaGambar);
	$ekstensiGambar 	 = strtolower(end($ekstensiGambar));

	if(!in_array($ekstensiGambar, $ekstensiGambarValid))
	{
		echo "
			<script>
                alert('Yang Anda upload bukan gambar');
			</script>
			";

		return false;
	}

	// cek ukuran gambar yang diupload
	if($ukuranGambar > 1000000 )
	{
		echo "
			<script>
                alert('Ukuran gambar terlalu besar');
			</script>
			";

		return false;		
	}

	$namaGambarBaru  = uniqid();
	$namaGambarBaru .= '.';
	$namaGambarBaru .= $ekstensiGambar; 

	move_uploaded_file($tmpGambar, 'gambar/' . $namaGambarBaru);

	return $namaGambarBaru;

}

function hapus($id)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

	return mysqli_affected_rows($conn);
}


function ubah($data)
{
	global $conn;

	$id         = $data["id"];
	$nama 	    = htmlspecialchars($data["nama"]);
	$nim 	    = htmlspecialchars($data["nim"]);
	$email 	    = htmlspecialchars($data["email"]);
	$jurusan    = htmlspecialchars($data["jurusan"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	if($_FILES['gambar']['error'] === 4)
	{
		$gambar = $gambarLama;
	}
	else
	{
		$gambar     = upload();
	}

	$query 	 = "UPDATE mahasiswa  SET
				nama    = '$nama',
				nim	    = '$nim',
				email   = '$email',
				jurusan = '$jurusan',
				gambar  = '$gambar'
				WHERE id = $id";

	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}

function cari($keyword)
{
	$query = "SELECT * FROM mahasiswa
				WHERE
				nama LIKE '%$keyword%' OR
				nim LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%'
				";

	return query($query);
}


function register($data)
{
	global $conn;

	$username  = strtolower(stripslashes($data["username"]));
	$password  = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username
	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	if(mysqli_fetch_assoc($result))
	{
		echo "<script>
		alert('Username sudah ada');
		</script>";

		return false;	
	}

	// cek konfirmasi password
	if($password !== $password2)
	{
		echo "<script>
		alert('Konfirmasi password tidak sama');
		</script>";

		return false;
	}

	// enkripsi
	$password = password_hash($password, PASSWORD_DEFAULT);

	// masukkan data ke dalam db
	mysqli_query($conn, "INSERT INTO user VALUES(null,'$username','$password')");

	return mysqli_affected_rows($conn);
}

?>
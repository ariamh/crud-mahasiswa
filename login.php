<?php

session_start();

require 'functions.php';

if(isset($_SESSION["login"]))
{
	header("Location: index.php");
	exit;
}

if(isset($_POST["login"]))
{
	$username = $_POST["username"]; 
	$password = $_POST["password"];

	$result   = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// cek username
	if(mysqli_num_rows($result) === 1)
	{
		// cek password
		$row = mysqli_fetch_assoc($result);		
		if(password_verify($password, $row["password"]))
		{
			// set session
			$_SESSION["login"] = true;

			// cek remember me
			if(isset($_POST["remember"]))
			{				
				// buat cookie				
				setcookie('id', $row['id'], time()+60);
				setcookie('key', hash('sha256', $row['username']), time()+60);
			}

			header("Location: index.php");
			exit;
		}
	}

	$error = true;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Login</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="ico/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="ico/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="ico/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="ico/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="ico/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="ico/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="ico/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="ico/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="ico/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="ico/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="&nbsp;"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
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
	
<h1>Halaman Login</h1>

<?php if(isset($error)) : ?>
	<p style="color: red; font-style: italic;">Username / Password salah</p>
<?php endif; ?>

<form action="" method="POST">
	<table>
		<tr>
			<td><label for="username">Username</label></td>
			<td><input type="text" name="username" id="username"></td>
		</tr>
		<tr>
			<td><label for="password">Password</label></td>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<td></td>
			<td><button type="submit" name="login">Login</button></td>
		</tr>
	</table>
</form>

</body>
</html>
<?php
include_once 'dbconnection.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (
		isset($_POST["Username"]) && $_POST["Username"] !== ''
		&& isset($_POST["password"]) && $_POST["password"] !== ''
	) {
		$sql = "SELECT * FROM admins WHERE Username = '" . $_POST["Username"] . "' AND password = '" . $_POST["password"] . "'";
		//$sql = "SELECT * FROM admins";
		
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$_SESSION["log"] = 1;
			header('Location: ../dashboard.php');
			// succsefully
		} else {
			$msg = 'Wrong admin name or password...';
		}

		mysqli_close($conn);
	}
} else {
	session_destroy();
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<div><?php echo isset($msg) ? $msg : ''; ?></div>
	<div class="login">
		<header class="header">
			<span class="text">LOGIN</span>
			<span class="loader"></span>
		</header>
		<form class="form" action="" method="POST">
			<input class="input" type="text" name="Username" placeholder="Username">
			<input class="input" type="password" name="password" placeholder="Password">
			<button class="btn" type="submit"></button>
		</form>

	</div>
</body>

</html>
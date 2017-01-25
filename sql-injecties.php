<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="aanmelden" method="POST">
		Gebruiker:
		<input type="text" name="email" value="naam@domain.com" /><br>
		Wachtwoord:
		<input type="text" name="password" value="wachtwoord" /><br>
		<input type="hidden" name="submit" value="true" />
		<input type="submit" id="submit" value="Aanmelden" />
	</form>
	<p>------------------------------------------------</p>
	<?php
		$db = mysqli_connect("localhost", "root", "", "gigastore") or die ("could not connect to database");

		if(isset($_POST["submit"])){
			$user = $_POST["email"];
			$wachtwoord = $_POST["password"];
			$query = "SELECT * FROM klant WHERE email ='" .	$user . "' AND postcode ='" . $wachtwoord . "'";
			$resultaat=mysqli_query($db, $query) or die(mysql_error());
			if ($row = mysqli_fetch_array($resultaat, MYSQL_ASSOC)){
				echo"
				<script>
				alert('je bent ingelogd!!');
				location.href='welkom.php';
				</script>";
			} 
			else {
				echo"
				<script>
				alert('De ingevoerde combinatie gebruikersnaam-wachtwoord komt niet in de database voor');
				</script>";
			}
		}
	?>
</body>
</html>
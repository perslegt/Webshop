<?php
	if(isset($_POST['submit'])){
		/*Set a function to sanitize inputs*/
		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		/*Set variable 'errors' so that we can display in html to warn users for errors.*/
		$error = "";
		// Set a variable to confirmate the submit.
		$conf = "";

		// Validates names.
		if (!empty($_POST['voornaam'])) {
			$voorNaam = test_input($_POST['voornaam']);
			if(!preg_match("|^[0-9\p{L}_\s-]*$|u", $voorNaam)){
				$error = "U heeft een ongeldige voornaam ingetyped.";
			}
		}
		if(!empty($_POST['achternaam'])){
			$achterNaam = test_input($_POST['achternaam']);
			if(!preg_match("|^[0-9\p{L}_\s-]*$|u", $achterNaam)){
				$error = "U heeft een ongeldige achternaam ingetyped";
			}
		}
		// Validates adresses.
		if (!empty($_POST['adres'])) {
			$adres = test_input($_POST['adres']);
			if (!preg_match("/^[a-zA-Z 0-9]*$/", $adres)) {
				$error = "U heeft een ongeldige adres ingetyped.";
			}
		}
		// Validates postcodes.
		if (!empty($_POST['postcode'])) {
			$postcode = test_input($_POST['postcode']);
			if (strlen($postcode) < 6) {
				$error = "De lengte van de postcode is te weinig";
			}
			else if (strlen($postcode) > 6) {
				$error = "De lengte van de postcode is te veel.";
			}
			else if (!preg_match("/^[a-zA-Z 0-9]*$/", $postcode)) {
				$error = "Er zijn illegale karakters in de input";
			}
		}
		// Validates woonplaats.
		if (!empty($_POST['woonplaats'])) {
			$woonplaats = test_input($_POST['woonplaats']);
			if (!preg_match("|^[0-9\p{L}_\s-]*$|u", $woonplaats)) {
				$error = "U heeft een ongeldige woonplaats ingetyped.";
			}
		}
		// Validates emails.
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		
		try {
			// Add a SQL-query.
			$sql = "UPDATE klant SET voornaam=:voornaam, achternaam=:achternaam, adres=:adres, postcode=:postcode, woonplaats=:woonplaats WHERE email=:email";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':achternaam'=>$achterNaam, ':voornaam'=>$voorNaam,':adres'=>$adres,':postcode'=>$postcode, ':woonplaats'=>$woonplaats, ':email'=>$email));
			echo "<script>alert('U hebt uw gegevens succesvol aangepast.'); location.href='index.php?page=welkom';</script>";
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
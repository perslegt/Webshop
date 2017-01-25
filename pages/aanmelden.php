<div id="page-wrapper">
	<div id="meldingen"></div>
	<form name="registreren" method="POST" onsubmit="return validate();">
		<div class="field">
			<input type="text" id="input" name="Voornaam" placeholder="Voornaam"/>
		</div>
		<div class="field">
			<input type="text" id="input" name="Achternaam" placeholder="Achternaam"/>
		</div>
		<div class="field">
			<input type="text" id="input" name="Adres" placeholder="Adres"/>
		</div>
		<div class="field">
			<input type="text" id="input" name="Postcode" placeholder="postcode"/>
		</div>
		<div class="field">
			<input type="text" id="input" name="Woonplaats" placeholder="Woonplaats"/>
		</div>
		<div class="field">
			<input type="email" id="input" name="Email" placeholder="Email"/>
		</div>
		<div class="field">
			<input type="password" id="input" name="Wachtwoord" placeholder="Wachtwoord"/>
		</div>
		<div class="field">
			<input type="password" id="input" name="CWachtwoord" placeholder="Confirm password"/>
		</div>
		<div class="g-recaptcha" data-sitekey="6LfcXwgUAAAAAPsq8ZxVLq8nFpXgBr_GZhaK60W6"></div>
		<div class="field">
			<input type="hidden" name="submit" value="true" />
        	<input type="submit" id="submit" value="inloggen" />
		</div>
	</form>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</div>
<script type="text/javascript" src="JS/validation.js"></script>
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
		if (!empty($_POST['Voornaam'])) {
			$voorNaam = test_input($_POST['Voornaam']);
			if(!preg_match("|^[0-9\p{L}_\s-]*$|u", $voorNaam)){
				$error = "U heeft een ongeldige voornaam ingetyped.";
			}
		}
		if(!empty($_POST['Achternaam'])){
			$achterNaam = test_input($_POST['Achternaam']);
			if(!preg_match("|^[0-9\p{L}_\s-]*$|u", $achterNaam)){
				$error = "U heeft een ongeldige achternaam ingetyped";
			}
		}
		// Validates adresses.
		if (!empty($_POST['Adres'])) {
			$adres = test_input($_POST['Adres']);
			if (!preg_match("/^[a-zA-Z 0-9]*$/", $adres)) {
				$error = "U heeft een ongeldige adres ingetyped.";
			}
		}
		// Validates postcodes.
		if (!empty($_POST['Postcode'])) {
			$postcode = test_input($_POST['Postcode']);
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
		if (!empty($_POST['Woonplaats'])) {
			$woonplaats = test_input($_POST['Woonplaats']);
			if (!preg_match("|^[0-9\p{L}_\s-]*$|u", $woonplaats)) {
				$error = "U heeft een ongeldige woonplaats ingetyped.";
			}
		}
		// Validates emails.
		$email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);

		// Validates passwords and confirming these.
		if (!empty($_POST['Wachtwoord'])) {
			$wachtwoord = test_input($_POST['Wachtwoord']);
			if (strlen($wachtwoord) < 8) {
				$error = "Je wachtwoord moet minstens 8 karakters bevatten<br/>";
			}
			elseif (!preg_match("#[0-9]+#", $wachtwoord)) {
				$error = "Je wachtwoord moet minstens 1 nummer bevatten<br/>";
			}
			elseif(!preg_match("#[A-Z]+#",$wachtwoord)) {
		        $error = "Je wachtwoord moet minstens 1 hoofdletter bevatten<br/>";
		    }
		    elseif(!preg_match("#[a-z]+#",$wachtwoord)) {
		        $error = "Je wachtwoord moet minstens 1 kleine letter bevatten<br/>";
		    }
		    $hashed = password_hash($wachtwoord, PASSWORD_DEFAULT);
		}
		if (!empty($_POST['CWachtwoord']) && $_POST['CWachtwoord'] == $_POST['Wachtwoord']) {
			// Also test this $_POST variable for any harmful chars that are crucial for SQL_injections and XSS.
			$cwachtwoord = test_input($_POST['CWachtwoord']);
		}
		else {
			$error = "Verifiëer uw wachtwoord met het bovenstaande.<br/>";
		}
		// grab recaptcha library
		require_once "recapchalib.php";
	 	
	 	// your secret key
		$secret = "6LfcXwgUAAAAAAv2isdioWAW_C5-TZCUzk9D2hJn";
		 
		// empty response
		$response = null;
		 
		// check secret key
		$reCaptcha = new ReCaptcha($secret);

		// if submitted check response
		if ($_POST["g-recaptcha-response"]) {
		    $response = $reCaptcha->verifyResponse(
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["g-recaptcha-response"]
		    );
		}
		if ($response != null && $response->success) {
		    $conf = "Hi " . $_POST["Voornaam"] . " (" . $_POST["Email"] . "), thanks for submitting the form!<br/>";
		} else {
			$error .= "<script>alert('Sorry, It is obligatory to check of you are not a robot.');</script>";
		}

		// Display error messages in case of any kind of error.
		if (!$error) {
			echo "<div id='melding'>" . $conf . "U bent geregistreerd</div>";
			$user_name = $achterNaam;
			$from = "noreply@powerjobs.com";
			$to = $email;

			$subject = "Uw registratie bij webshop";
			$message = "Welkom bij powerjobs";
			$headers = "From: " . $from . "\r\n" . "Reply-To: " . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}
		else{
			exit("<div id='melding'>" . $error . "</div>");
		}
		
		try {
			// Add a SQL-query.
			$sql = "INSERT INTO klant (voornaam, achternaam, adres, postcode, woonplaats, email, wachtwoord)VALUES(:achternaam, :voornaam, :adres, :postcode, :woonplaats, :email, :wachtwoord)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':achternaam'=>$achterNaam, ':voornaam'=>$voorNaam,':adres'=>$adres,':postcode'=>$postcode, ':woonplaats'=>$woonplaats, ':email'=>$email, ':wachtwoord'=>$hashed));
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
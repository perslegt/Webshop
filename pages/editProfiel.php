<?php
	if (isset($_SESSION["L_ID"]) && $_SESSION["L_STATUS"] === 1) {
		echo "<div id='page-wrapper'>";
		try {
			$sql = "SELECT * FROM klant WHERE email = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($_SESSION["L_ID"]));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
?>
	<form method="POST" action="index.php?page=updateProfiel">
		<input required type="text" name="voornaam" value="<?php echo $result['voornaam']; ?>"/>
		<input required type="text" name="achternaam" value="<?php echo $result['achternaam']; ?>"/>
		<input required type="text" name="adres" value="<?php echo $result['adres']; ?>"/>
		<input required type="text" name="postcode" value="<?php echo $result['postcode']; ?>"/>
		<input required type="text" name="woonplaats" value="<?php echo $result['woonplaats']; ?>"/>
		<input required type="email" name="email" value="<?php echo $result['email']; ?>" disabled/>
		<input required type="password" name="password" placeholder="wachtwoord" disabled/>
		<input type="hidden" name="submit" value="true" />
		<input type="submit" id="submit" value=" Update " />
		<a href="index.php?page=welkom">Annuleren</a>
	</form>
</div>
<?php 
	} 
	else {
		echo "<script>alert('U moet ingelogd zijn om deze pagina te bekijken.'); location.href='index.php?page=inloggen';</script>";
	}
?>
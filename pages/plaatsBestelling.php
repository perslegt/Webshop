<?php
	if(isset($_POST['bestel1'])) {
		$sql = "SELECT * FROM klant WHERE email = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_SESSION["L_ID"]));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$klantId = $result['ID'];
		try {
			// Add a SQL-query.
			$sql = "INSERT INTO weborder (Klant_ID, datum)VALUES(:klantid, NOW())";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':klantid'=>$klantId));
			$weborderId = $db->lastInsertId();
			$trackingId = $weborderId;
			echo "<br><br><br><br><br><br><br><p>Bestelling geplaatst</p>";

			$albumId = $_POST['album1'];
			$sql = "SELECT * FROM album WHERE ID = $albumId";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$verkoopPrijs = $result['prijs'];

			$aantal = $_POST['aantal1'];

			$sql = "INSERT INTO item (weborderID, albumID, verkoopprijs, aantal) VALUES (:weborderid, :albumid, :verkoopprijs, :aantal)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':weborderid'=>$weborderId, ':albumid'=>$albumId, ':verkoopprijs'=>$verkoopPrijs, ':aantal'=>$aantal));

			$from = "noreply@powerjobs.com";
			$to = $_SESSION["L_ID"];

			$subject = "Uw bestelling bij de Webshop";
			$message = "<p>Bekijk de status van uw bestelling <a href='http://localhost:81/Webshop2/ordertracking.php?ID=" . $trackingId . "'>hier</a>.</p>";
			$headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // To send HTML mail, the Content-type header must be set
            $headers .= "From: " . $from . "\r\n" . "Reply-To: " . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
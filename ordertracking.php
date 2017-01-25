<?php 
	session_start();
	include_once("dbconfig.php");
?>
<!DOCTYPE html>
<html lang="nl">
	<head>
		<title>WEBSHOP</title>
	</head>
	<body>
	<?php
		if (!isset($_GET['ID'])) {
			Header("Location: index.php?page=welkom");
		} 
		else {
			$trackingId = $_GET['ID'];
			$sql = "SELECT * FROM weborder WHERE ID = $trackingId";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$klantId = $result['klant_ID'];

			$sql = "SELECT * FROM klant WHERE email = '" . $_SESSION['L_ID'] . "'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$klantId2 = $result['ID'];

			if ($klantId == $klantId2) {
				$sql = "SELECT * FROM weborder WHERE ID = '" . $_GET['ID'] . "'";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$orderId = $result['ID'];
				$datum = $result['datum'];

				$sql = "SELECT * FROM klant WHERE ID = '$klantId'";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$voorNaam = $result['voornaam'];
				$achterNaam = $result['achternaam'];

				$sql = "SELECT * FROM item WHERE weborderID = '" . $_GET['ID'] . "'";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$albumId = $result['albumID'];
				$prijs = $result['verkoopprijs'];
				$aantal = $result['aantal'];

				$sql = "SELECT * FROM album WHERE ID = '$albumId'";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$titel = $result['titel'];
				$artiest = $result['artiest'];

				$prijsTotaal = $prijs * $aantal;
	?>
				<h1>Order Tracking</h1>
				<h2>Order info</h2>
				<table>
					<tbody>
						<tr>
							<td>Order nummer</td>
							<td><?php echo $orderId; ?></td>
						</tr>
						<tr>
							<td>Order datum</td>
							<td><?php echo $datum; ?></td>
						</tr>
						<tr>
							<td>Klant naam</td>
							<td><?php echo $voorNaam . " " . $achterNaam; ?></td>
						</tr>
						<tr>
							<td>Prijs</td>
							<td><?php echo $prijsTotaal; ?></td>
						</tr>
					</tbody>
				</table>
				<h2>Product info</h2>
				<p><?php echo $aantal . "x " . $titel . " - " . $artiest . "."; ?></p>
	<?php
			}
			else {
				//header("Location: index.php?page=welkom");
			}
		}
	?>
	</body>
</html>
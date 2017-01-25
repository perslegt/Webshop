<?php
	if(isset($_SESSION["L_ID"]) && $_SESSION["L_STATUS"]===1){
		echo"<h1 id='meldingen'>Welkom</h1>";
	} 
	else {
		echo "<script>
		alert('U moet ingelogd zijn om deze pagina te bekijken');
		location.href='Webshop2/index.php';
		</script>";
	}
?>
<div id="page-wrapper" >
	<form  method="post" action="index.php?page=search"  id="searchform"> 
	    <input  type="text" name="zoek"> 
	    <input  type="submit" name="submit" value="Search">
	</form>
	<form name="orderform" id="orderform" action="index.php?page=plaatsBestelling" method="post" >
	<?php
		$query = "SELECT * FROM album limit 3";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$teller = 1;
		foreach($albums as $album) {
			echo "<br>";
			echo "<img width='150px' src='img/". $album["cover"] . "' alt='' />";
			echo "<br>";
			echo "<input name='album" . $album['ID'] . "' id='album" . $album['ID'] . "' value='" . $album['ID'] . "'>";
			echo "<input type='hidden' name='titel$teller' id='titel$teller' value='". $album['titel'] . "' />";
			echo "<br>Titel:" . $album["titel"] . " Prijs: " . $album["prijs"];
			echo "<br>Voorraad: " . $album["voorraad"];
			echo "<br>Bestel:<input type='text' class='aantal' name='aantal$teller' id='aantal$teller' value='0'>";
			echo "<input type='submit' name='bestel" . $album['ID'] . "' value='Bestel'>";
			echo "<hr>";
			$teller++;
		}
	?>
	</form>
</div>
<?php include("shoppingcart.html"); ?>
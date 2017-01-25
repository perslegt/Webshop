<div id="page-wrapper">
	<form id="content" name="search" method="post">
		<select name="album-code">
			<option value="">Selecteer een rapport</option>
			<option value="orders">Totaal bestelde albums</option>
		</select>
		<input type="submit" name='submit' id="submit" value="Zoeken" />
	</form>
</div>
<?php
	if(isset($_POST['submit'])) {
?>
<div id="page-wrapper" style="margin-top:100px;width:90%;margin-left:auto;margin-right:auto">
	<table border="0" cellspacing="0">
	<caption>
	Totaal bestelde albums<br><br>
	</caption>
		<thead>
			<tr>
				<th>Klant Naam</th>
				<th>Weborder</th>
				<th>Album titel</th>
				<th>Aantal</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = "
			SELECT klant.achternaam, item.weborderID, album.titel, item.aantal
			FROM klant
			INNER JOIN (weborder
			INNER JOIN (item
			INNER JOIN album ON album.ID = item.albumID)
			ON weborder.ID = item.weborderID)
			ON klant.ID = weborder.klant_ID";
			$stmt = $db->prepare($query);
			$stmt->execute(array());
			$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$bgcolor = true;
			$weborder = $items[0]['weborderID'];
			$subtotaal = 0;
			$totaal = 0;
			$nieuwOrder = true;
			foreach($items as $item) {
				if($item['weborderID'] != $weborder){
				// print subtotaal
					$bgcolor= ($bgcolor ? false:true);
					echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
					echo "<td></td><td></td><td> Subtotaal.....</td><td align='center'>".$subtotaal."</td> </tr>";
					$totaal += $subtotaal;
					$subtotaal = 0;
					$nieuwOrder = true;
					$weborder = $item['weborderID'];
				}
				if($nieuwOrder){
					$bgcolor= ($bgcolor ? false:true);
					echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
					echo "<td>".$item['achternaam']."</td><td align='center'>".$item['weborderID']."</td>";
					echo"<td>".$item['titel']."</td><td align='center'>".$item['aantal']."</td> </tr>";
					$subtotaal += $item['aantal'];
					$nieuwOrder = false;
				}
				else {
					// anders klant en weborder niet herhalen
					$bgcolor= ($bgcolor ? false:true);
					echo ($bgcolor ? "<tr bgcolor=#9BC997>" : "<tr bgcolor=#DAD4D4>");
					echo "<td></td><td></td>";
					echo"<td>".$item['titel']."</td><td align='center'>".$item['aantal']."</td> </tr>";
					$subtotaal += $item['aantal'];
				}
			}
			// print laatste sub-totaal en eind-totaal
			echo ($bgcolor ? "<tr bgcolor=#ccc>" : "<tr>");
			echo "<td></td><td></td><td> Subtotaal.....</td><td align='center'>".$subtotaal."</td></tr>";
			echo "<tr><td> </td><td></td><td> Totaal.....</td><td align='center'>".$totaal."</td></tr>";
		?>
		</tbody>
	</table>
</div> <!-- einde page-wrapper -->
<?php
	} // einde if isset($_POST['submit'])
?>
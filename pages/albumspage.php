<?php
	if(isset($_SESSION['L_ID']) && $_SESSION['L_STATUS'] === 1){
?>
<div id="page-wrapper" >
	<table id='tabel' border="0" cellspacing="3">
		<caption>
			<b>Albums muteren</b>
		</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Titel</th>
				<th>Artiest</th>
				<th>Genre</th>
				<th>Prijs</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = "SELECT * FROM album";
			$stmt = $db->prepare($query);
			$stmt->execute(array());
			$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$bgcolor = true;
			foreach($albums as $album) {
				echo ($bgcolor ? "<tr bgcolor=#ccc>" : "<tr>");
				echo "<td>".$album['ID'].
				"</td><td>".$album['titel'].
				"</td><td>".$album['artiest'].
				"</td><td>".$album['genre'].
				"</td><td>".$album['prijs'].
				"</td><td>".
				"<a href='index.php?page=edit-dit-album&code=".
				$album['ID']."'>".
				"<img src='img/pencil.jpg' width='15px' /></a>".
				"</td><td>".
				"<a href='index.php?page=del-dit-album&code=".
				$album['ID']."'>".
				"<img src='img/del.png' width='15px' /></a>".
				"</td></tr>";
				$bgcolor= ($bgcolor ? false:true);
			}
		?>
		</tbody>
	</table>
</div>
<?php
} else {
echo "
<script>
alert('U moet ingelogd zijn om deze pagina te bekijken.');
location.href='index.php';
</script>
";
}
?>
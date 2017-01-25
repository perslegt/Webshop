<?php
if(isset($_SESSION['L_ID']) && $_SESSION['L_STATUS'] === 1){

	if(isset($_POST['submit'])){
		// Validates inputs.
		if (!empty($_POST['id'])) {
			$id = $_POST['id'];
		}
		if (!empty($_POST['titel'])) {
			$titel = $_POST['titel'];
		}
		if (!empty($_POST['artiest'])) {
			$artiest = $_POST['artiest'];
		}
		if (!empty($_POST['genre'])) {
			$genre = $_POST['genre'];
		}
		if (!empty($_POST['prijs'])) {
			$prijs = $_POST['prijs'];
		}
		try {
			// Add a SQL-query.
			$sql = "UPDATE album SET titel=:titel,artiest=:artiest,genre=:genre,prijs=:prijs WHERE id=:id";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':titel'=>$titel, ':artiest'=>$artiest,':genre'=>$genre,':prijs'=>$prijs, ':id'=>$id));

			header("Location: index.php?page=albumspage");
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

?>

<div class="page-wrapper">
<h3>Edit album</h3>

<?php
	$query = "SELECT * FROM album WHERE ID = ?";
	$stmt = $db->prepare($query);
	$stmt->execute(array($_GET['code']));
	$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($albums as $album) {
?>
<form name="edit" class="form" action="index.php?page=edit-dit-album&code=<?php echo $_GET['code']; ?>" method="POST">
	<label>ID:</label>
	<input type="text" name="id" id="id" value="<?php echo $album['ID']; ?>" />
	<label>Titel:</label>
	<input type="text" name="titel" id="titel" value="<?php echo $album['titel']; ?>" />
	<label>Artiest:</label>
	<input type="text" name="artiest" id="artiest" value="<?php echo $album['artiest']; ?>" />
	<label>Genre:</label>
	<input type="text" name="genre" id="genre" value="<?php echo $album['genre']; ?>" />
	<label>Prijs:</label>
	<input type="text" name="prijs" id="prijs" value="<?php echo $album['prijs']; ?>" />
	<br>
	<input type="hidden" name="submit" value="true" />
	<input type="submit" id="submit" value="Opslaan" />
	<a href="index.php?page=albumspage">
		<div id="cancel">
			<span>Annuleren</span>
		</div>
	</a>
</form>
</div>
<?php
}
} else {
echo "
<script>
alert('U moet ingelogd zijn om deze pagina te bekijken.');
location.href='index.php?page=inloggen';
</script>
";
}
?>
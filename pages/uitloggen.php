<?php
	if(isset($_SESSION["L_ID"]) && $_SESSION["L_STATUS"] === 1) {
	$_SESSION["L_ID"] = "";
	$_SESSION["L_NAME"] = "";
	$_SESSION["L_STATUS"] = 0;
	$_SESSION["L_ADMIN"] = "";
	# close the connection
	$db = null;
	echo "<script>location.href='index.php?page=inloggen';</script>";
}
<div id="page-wrapper">
	<form name="inloggen" method="POST" enctype="multipart/form-data" onsubmit="return checkform()">
	    <input onfocus="if(this.value == 'iemand@example.com') {this.value = '';}" onblur="if(this.value == '') {this.value = 'iemand@example.com';}" type="text" id="input" name="email" value="iemand@example.com" />
	    <input onfocus="if(this.value == 'wachtwoord') {this.value = '';} this.type='password';" onblur="if(this.value == '') {this.value = 'wachtwoord'; this.type='text;'};" type="text" id="input" name="password" value="wachtwoord" />
        <input type="hidden" name="submit" value="true" />
        <input type="submit" id="submit" value="inloggen" />  
    	<a href="index.php?page=aanmelden">Account activeren</a><br>
    	<a href="index.php?page=wachtwoordvergeten">Wachtwoord vergeten</a>
    </form>
</div>
<script>
function checkform() {
    if (document.aanmelden.email.value == "" || document.aanmelden.email.value == "example@iemand.com") { 
        alert("Vul uw e-mailadres in.");
        document.aanmelden.email.focus();
        return false;
    } else if (document.aanmelden.password.value == "" || document.aanmelden.value == "wachtwoord") {
        alert("Vul uw wachtwoord in");
        document.aanmelden.password.focus();
        return false;
    }
    return true;
}
</script>
<?php
if(isset($_POST["submit"])) {
    $error = "";
    $email = htmlspecialchars($_POST["email"]);
    $password = trim($_POST["password"]);
    if(strlen($email) < 1) {
        $error = "U heeft geen email ingevuld.<br>";
    }
    if(strlen($password) < 1) {
        $error = "U heeft geen wachtwoord ingevuld.<br>";
    }
    if(!$error) {
        try {
            $sql = "SELECT * FROM klant WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(count($result) > 0 && password_verify($password, $result['wachtwoord'])) {
            
                $_SESSION['L_ID'] = $result['email'];
                $_SESSION['L_NAME'] = $result['voornaam'];
                $_SESSION['L_STATUS'] = 1;
                echo "<script> location.href='index.php?page=welkom'; </script>";
            } else {
                $error .= "Verkeerde email of wachtwoord.<br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    echo "<div id='melding'>" . $error . "</div>"; 
}

?>
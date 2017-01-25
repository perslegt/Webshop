<div id="page-wrapper">
    <form name="inloggen" method="POST">
        <div class="field">
            <p>Voer je email en je nieuwe wachwoord in om je wachtoord te resetten</p>
            <input id="input" type="text" name="email" placeholder="E-mail">
            <input id="input" type="password" name="password" placeholder="Nieuw Wachtwoord">
            <input id="input" type="password" name="passwordconfirm" placeholder="Wachtwoord herhalen">
            <input type="hidden" name="submit" value="true"/>
            <input id="submit" type="submit" value="Reset wachtwoord">
        </div>
    </form>
</div>
<?php

$fouten = 0;

if (isset($_POST['submit'])) {
    if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["passwordconfirm"])) {
        if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["passwordconfirm"])) {
            if(($_POST["password"]) == ($_POST["passwordconfirm"])) {
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    echo "<div id='alert'>Fout Email adres.</div>";
                    $fouten++;
                }
            }
            if (strlen($_POST["password"]) < '8') {
                echo "<div id='alert'>Wachtwoord Moet minstens uit 8 karakters bestaan.</div>";
                $fouten++;
            }
            elseif(!preg_match("#[0-9]+#",$_POST["password"])) {
                echo "<div id='alert'>Wachtwoord Moet minstens uit 1 cijfer bestaan.</div>";
                $fouten++;
            }
            elseif(!preg_match("#[A-Z]+#",$_POST["password"])) {
                echo "<div id='alert'>Wachtwoord Moet minstens uit 1 Hoofdletter bestaan.</div>";
                $fouten++;
            }
            elseif(!preg_match("#[a-z]+#",$_POST["password"])) {
                echo "<div id='alert'>Wachtwoord Moet minstens uit 1 normaal karakter bestaan.</div>";
                $fouten++;
            }
            if($fouten < 1) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordconfirm = $_POST["passwordconfirm"];
                $newpassword = password_hash($password, PASSWORD_DEFAULT);
                try{
                    $sql = "UPDATE klant SET wachtwoord='$newpassword' WHERE email='$email'; ";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    header("Location: index.php?page=inloggen");
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
            $verb = null;
        }   
        else {
            echo "<div id='alert'>Wachtwoorden komen niet overeen.</div>";
        } 
    } 
    else { 
        echo "<div id='alert'>Controleer ingevoerde waarden.</div>"; 
    }
}
?>
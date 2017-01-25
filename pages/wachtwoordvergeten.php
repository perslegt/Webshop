<div id="page-wrapper">
        <form name="inloggen" method="post">
            <div class="field">
                <p>Voer je email in om de link naar de wachtwoord-reset pagina te ontvangen.</p>
                <input id="input" type="text" name="email" placeholder="E-mail">
                <input id="submit" type="submit" value="Stuur">
                <span><?php  if(isset($succes)) echo $succes ?></span>
            </div> 
        </form>
<?php
    if(isset($_POST["email"])) {
        if(!empty($_POST["email"])) {
            //$user_name = $achterNaam;
            $from = "noreply@powerjobs.com";
            $to = $_POST["email"];
            $subject = "Wachtwoord resetten";
            $message = '<a href="http://localhost:81/Webshop2/index.php?page=wachtwoordreset">Link naar wachtwoordformulier</a>.';
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // To send HTML mail, the Content-type header must be set
            $headers .= "From: " . $from . "\r\n" . "Reply-To: " . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();

            // Mail it
            mail($to, $subject, $message, $headers);
              
            $succes= "<div id='alert'>Email verzonden.</div>";
        
        } 
        else {
            $succes= "<div id='alert'>Controleer Email</div>";    
        }  
    }
?>

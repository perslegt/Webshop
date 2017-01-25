/*
* initiate checking forms.
*/

function validate() {
    
    if (document.registreren.Voornaam.value == "") {
        
        alert("Vul uw geldige Voornaam in.");
        document.registreren.Voornaam.focus();
        return false;
    } 
    else if (document.registreren.Achternaam.value == "") {
        
        alert("Vul uw geldige Achternaam in");
        document.registreren.Achternaam.focus();
        return false;
    } 
    else if (document.registreren.Adres.value == "") {
    	
    	alert("Vul uw geldige Adres");
    	document.registreren.Adres.focus();
    	return false;
    }
    else if (document.registreren.Postcode.value == "") {
    	
    	alert("Vul uw geldige Postcode");
    	document.registreren.Postcode.focus();
    	return false;
    }
    else if (document.registreren.Email.value == "") {
    	
    	alert("Vul uw geldige Email");
    	document.registreren.Email.focus();
    	return false;
    }
    else if (document.registreren.Wachtwoord.value == "") {
    	
    	alert("Vul uw geldige Wachtwoord");
    	document.registreren.Wachtwoord.focus();
    	return false;
    }
    return true;
}
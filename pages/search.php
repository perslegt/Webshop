<?php 
    echo" <br />
        <br />
        <br />
        <br />
        <br />
        <br />";
	    if(isset($_POST['submit'])){ 
    	    //do  something here in code 
            if(preg_match("/[a-zA-Z]+/", $_POST['zoek'])){ 
    	        $zoek=$_POST['zoek'];
                //connect  to the database
                $db = mysqli_connect("localhost",  "root", "") or die ('I cannot connect  to the database because: ' . mysqli_error());
                //-select  the database to use
                $db->select_db("gigastore");
                //-query  the database table 
        	    $sql="SELECT `ID`, `titel`, `artiest`, `genre`, `cover` FROM `album` WHERE  `titel` LIKE '%" . $zoek . "%' OR `artiest` LIKE '%" . $zoek  ."%' OR `genre` LIKE '%"       . $zoek  ."%'";
                //-run  the query against the mysql query function 
        	    if ( $result = $db->query($sql) ) {
                    //-create  while loop and loop through result set 
                    while($row= $result->fetch_assoc()){ 
                        $titel  =$row['titel']; 
                        $artiest=$row['artiest']; 
                        $ID=$row['ID'];
                        $genre=$row['genre'];
                        //-display the result of the array 
                        echo "<hr>";
                        echo "<ul>\n"; 
                        echo "<img width='100px' src='img/" . $row["cover"] . "'  alt=''  />";
                        echo "<li id='zoek'>" . "Titel:"   .$titel . "<br />Artiest: " . $artiest .  "<br />Genre:" . $genre . "</li>\n";
                          
                        echo "</ul>"; 
                    } 
                }
                else {
                    echo "<p>Please enter a search query</p>";
                }
         
    	    }
    
        }
	?> 
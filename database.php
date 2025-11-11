<?php 
   $db_server ="localhost";
   $db_user ="root";
   $bd_pass ="";
   $db_name ="masalagodb";
   $conn ="";


   $conn = mysqli_connect($db_server,
                         $db_user,
                         $bd_pass,
                         $db_name);
   if($conn){
      echo "you are connected!";
   }   
   else{
     echo"could not connected";
   }                   
?>
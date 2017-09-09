 <?php
 
 if (!isset($_COOKIE['visits'])){
     setcookie('visits', 1, time() +3600*24*365);
     $visits = $_COOKIE['visits'];
     echo 'Witaj pierwszy raz na naszej stronie';
     }elseif(isset($_COOKIE['visits'])){
     $visits = $_COOKIE['visits'];
     setcookie('visits', $visits +1, time() +3600*24*365);
     echo "Witaj, odwiedziłeś nas już $visits razy";
 }

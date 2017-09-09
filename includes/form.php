<?php ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <form action="pdf.php" method="post" role="form">
        Departure airport<select name="airportStart">
            <?php
            include_once('airports.php');
            foreach($airports as $key => $value){
             echo '<option value='.$value['code'].'>'.$value['name'].' '.$value['code'].'</option>';
            
            }?>
        </select>
        <br>Arrive Airport<select name="airportEnd">
            <?php
            foreach($airports as $key => $value){
             echo '<option value='.$value['code'].'>'.$value['name'].' '.$value['code'].'</option>';
            
            }?>
        </select><br>
        Date and time departure <input type="datetime-local" name="dateTime" min="0" step="1"><br>
        Duration<input type="number" name="duration"min="0" step="1"><br>
        Flight price<input type="number" name="price" min="0" step="0.01"><br>

        <input type="submit" value="send">
    </form>

</body>
</html>
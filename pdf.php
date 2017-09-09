<?php
 

$curl = curl_init();


require_once('includes/airports.php');
 
require_once 'vendor/autoload.php';
Faker\Factory::create();
$faker = Faker\Factory::create();
 
use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberPolish = $numberToWords->getCurrencyTransformer('pl');

$mpdf = new \mPDF();

 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['airportStart'] !== $_POST['airportEnd'] && isset($_POST['dateTime']) && $_POST['price'] > 0 && isset($_POST['duration'])) {
        $startAirport = $_POST['airportStart'];
        $finalAirport = $_POST['airportEnd'];
        $dateTime = $_POST['dateTime'];
        $price = $_POST['price'];
        $duration = $_POST['duration'];
        foreach ($airports as $key => $value) {
            if ($value['code'] == $startAirport) {
                $timeZoneOfStartAirport = $value['timezone'];
                $nameStartAirport = $value['name'];
            } elseif ($value['code'] == $finalAirport) {
                $timeZoneOfFinalAirport = $value['timezone'];
                $nameFinalAirport = $value['name'];
            }
        }
        $localTimeZoneOfStartAirport = new DateTimeZone($timeZoneOfStartAirport);
        $localDateOfDeparture = new DateTime($dateTime);
        $localDateOfDeparture->setTimezone($localTimeZoneOfStartAirport);
        $localDateOfDeparture->format('d.m.Y h:i:s');
 
 
        $addDurationOfFlight = $localDateOfDeparture->modify($duration . ' hours');
        $localTimeZoneOfFinalAirport = new DateTimeZone($timeZoneOfFinalAirport);
        $localDateOfArrival = new DateTime($addDurationOfFlight->format('d.m.Y h:i:s'));
        $localDateOfArrival->setTimezone($localTimeZoneOfFinalAirport);
 
        $dateFlightShow = $localDateOfDeparture->format('d.m.Y h:i:s');
        $dateArrivalShow = $localDateOfArrival->format('d.m.Y h:i:s');
    }else{
        echo 'Please insert all fields';
    }
    }else{
    echo 'Access denied';
}
$newPrice = $numberPolish->toWords($price . "00", 'PLN');
$pdf="
   <table width='400' lenght='auto' color='red' border=2px;>
   <tr><td colspan='2' align='center' valign='middle'>Coders Lab Airlines</td></tr>
   <tr><td>From</td><td>To</td></tr>
   <tr><td>$nameStartAirport ($startAirport)</td><td>$nameFinalAirport ($finalAirport)</td></tr>
   <tr><td>Departure (local time)</td><td>Arrival (local time)</td></tr>
   <tr><td>$dateFlightShow</td><td>$dateArrivalShow</td></tr>
   <tr><td colspan='2'>Flight time</td><br>
   <tr><td colspan='2'>$duration h</td><br>
   <tr><td colspan='2'>Passenger</td></tr><br>
   <tr><td colspan='2'>$faker->name</td></tr><br>  
   <tr><td colspan='2'>Price</td><br>
   <tr><td colspan='2'>$price <br>$newPrice</td><br>
   </table>
        ";
echo $pdf;
//$mpdf->WriteHTML($pdf);
//$mpdf->Output("ticket.pdf", 'D');

curl_setopt($curl, CURLOPT_POSTFIELDS, [
   $airportStart, $airportEnd, $dateTime, $price, $duration 
]);


$result =curl_exec($curl);

if($result){
    echo $result;
}else{
    echo 'błąd:' . curl_error($curl);
}
curl_close($curl);
?>
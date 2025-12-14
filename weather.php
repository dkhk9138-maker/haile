<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What's the weather like?</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.css" />
</head>

<body>
    <?php
    require_once('weather_db.php');
    db_init();
    $conn = get_conn();
    db_create($conn);

    // Use one API key everywhere
    $apiKey = "61bef1013deac2521b5182b1a67ebac0"; // replace with your real OpenWeatherMap key

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_reporting(0);
        $add_city = $_POST["city_add"];
        $del_city = $_POST["city_delete"];

        if ($add_city) {
            $string = "http://api.openweathermap.org/data/2.5/weather?q=" . $add_city . "&units=metric&appid=" . $apiKey;
            $payload = file_get_contents($string);
            if ($payload !== false) {
                db_insert($conn, $add_city);
            } else {
                echo "<script type='text/javascript'>alert('\"$add_city\" is not supported. Kindly provide another city.');</script>";
            }
        }

        if ($del_city) {
            db_delete($conn, $del_city);
        }
    }
    ?>

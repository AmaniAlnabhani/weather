<?php

$api_key="677b34a13ac6a4bd660bb74a6f52e3d6";  

$weather_data = null; // مهم جداً عشان ما يطلع warning

if(isset($_POST['city']) && !empty(trim($_POST['city'])))
{
    $city = trim($_POST['city']);

    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=$api_key&units=metric";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    $weather_data = json_decode($response, true);
 //////background
    if(isset($weather_data['weather'][0]['main']))
    {
        $weather = $weather_data['weather'][0]['main'];

        $background = "images/default.jpg";

        switch($weather)
        {
            case "Clear":
                $background = "images/sunny.jpg";
                break;

            case "Clouds":
                $background = "images/cloudy.jpg";
                break;

            case "Rain":
                $background = "images/rainy.jpg";
                break;

            case "Thunderstorm":
                $background = "images/storm.jpg";
                break;

            case "Snow":
                $background = "images/snow.jpg";
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html >
<body style="
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;">  

<form method="POST">
    <input type="text" name="city" placeholder="Enter city name">
    <button type="submit">Get Weather</button>
</form>

<?php if(!empty($_POST['city'])): ?>

    <?php if(isset($weather_data['weather'])): ?>

        <h2><?php echo $weather_data['name']; ?></h2>
        <p>Temp: <?php echo $weather_data['main']['temp']; ?> °C</p>
        <p>Humidity: <?php echo $weather_data['main']['humidity']; ?>%</p>
        <p>Wind Speed: <?php echo $weather_data['wind']['speed']; ?> m/s</p>
        <p>Weather: <?php echo $weather_data['weather'][0]['main']; ?></p>

    <?php else: ?>

        <p>City not found or API error</p>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
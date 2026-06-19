<?php
    $api_key      = "677b34a13ac6a4bd660bb74a6f52e3d6";
    $weather_data = null; // مهم جداً عشان ما يطلع warning

    if (isset($_POST['city']) && ! empty(trim($_POST['city']))) {
    $city = $_POST['city'];
    $url  = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&units=metric";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $weather_data = json_decode($response, true);
    
    // print_r($weather_data); 

    }

    //////

    if (isset($weather_data['weather'][0]['main'])) {

    switch ($weather_data['weather'][0]['main']) {

        case "Clear":
            $video = "videos/clear.mp4";
            break;

        case "Clouds":
            $video = "videos/cloud.mp4";
            break;

        case "Rain":
            $video = "videos/rain.mp4";
            break;

        case "Thunderstorm":
            $video = "videos/thunderstorm.mp4";
            break;
    }
    } else {
    $video = "videos/clear.mp4";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <body>

<video autoplay muted loop id="bg-video">
    <source src="<?php echo $video; ?>" type="video/mp4">
</video>

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="weather-card p-4">

        <h2 class="text-center mb-4">Weather App</h2>

        <form method="POST">
            <div class="input-group mb-3">
                <input
                    type="text"
                    name="city"
                    class="form-control"
                    placeholder="Enter city name"
                    required
                >
                <button class="btn btn-primary">
                    Search
                </button>
            </div>
        </form>

        <?php if (isset($weather_data['weather'])):?>
            
            <div class="text-center">

                <h3><?php echo $weather_data['name']; ?></h3>

                <h1>
                    <?php echo round($weather_data['main']['temp']); ?>°C
                </h1>

                <h5>
                    <?php echo $weather_data['weather'][0]['main']; ?>
                </h5>

                <p>
                    Humidity:
                    <?php echo $weather_data['main']['humidity']; ?>%
                </p>

                <p>
                    Wind Speed:
                    <?php echo $weather_data['wind']['speed']; ?> m/s
                </p>

            </div>



        <?php endif; ?>
        <?php if (isset($weather_data['cod']) && $weather_data['cod'] == '404'): ?>

            <p class="text-center text-danger">
                City not found or API error
            </p>
        <?php endif; ?>

    </div>

    </div>

</div>


</body>
</html>
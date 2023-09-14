<?php
$apiKey = '37cae92af4b42d8acfce79455b70c571';
$error = "";
$cityName = "N/A";
$temperature = 'N/A';
$rainProbability = 'N/A';
$weatherIcon = 'N/A';

if (isset($_GET['search'])) {
    $city = urlencode($_GET['search']);

    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey";

    $context = stream_context_create(array(
        'http' => array(
            'ignore_errors' => true,
        ),
    ));

    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        $error = "Failed to fetch weather data.";
    } else {
        $data = json_decode($response);

        if ($data !== null && isset($data->name, $data->main->temp, $data->weather[0]->description, $data->weather[0]->icon)) {
            // Extract weather data from the API response
            $cityName = $data->name;
            $temp = $data->main->temp;
            $temperature = $temp - 273;
            $rainProbability = $data->weather[0]->description;
            $weatherIcon = $data->weather[0]->icon;
            $feel = $data->main->feels_like;
            $feels_like = $feel - 273;
            $wind = $data->wind->speed . 'm/s';
            $humidity = $data->main->humidity . '%';
        } else {
            $error = "Invalid data in API response.";
        }
    }
} else {
    $error = "City not specified.";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
<div class="grid grid-rows-[auto,1fr,auto] gap-4 min-h-screen bg-gray-300 p-4">
    <header class="bg-blue-500 h-16 grid grid-cols-5 gap-2">
        <nav class="col-span-2 bg-blue-300">
            <a href="#">Home</a>
            <a href="#">Updates</a>
            <a href="#">Contact</a>
        </nav>
        <div id="search" class="col-span-3 bg-purple-100">
            <form action="/test" method="get">
                <label for="search">Search City</label>
                <input type="text" name="search" id="search">
                <button type="submit">go</button>
            </form>
            <p><?= $error; ?></p>
        </div>
    </header>
    <main class="bg-purple-300">
        <section class="grid grid-cols-7 gap-4 h-full">
            <div id="sidenav" class="bg-slate-400">
                <div><a href="#">Weather</a></div>
                <div><a href="#">My Cities</a></div>
                <div><a href="#">Settings</a></div>
            </div>
            <div class="bg-amber-200 col-span-4 p-2">
                <div id="city-info" class="bg-amber-400 grid grid-rows-3 h-full gap-4 p-2">
                    <div id="city" class="bg-blue-50 p-2">
                        <div class="grid grid-cols-3 h-full gap-2">
                            <div class="bg-blue-300 p-0.5 gap-2">
                                <div class="bg-gray-100">
                                    <p><?= $cityName; ?></p>
                                    <p><?= $rainProbability; ?></p>
                                </div>
                                <div class="bg-purple-400"><?= $temperature; ?></div>
                            </div>
                            <div class="bg-blue-200 col-span-2"><img
                                        src="http://openweathermap.org/img/wn/<?= $weatherIcon; ?>.png"
                                        alt="Weather Icon">
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50">Hourly forecast</div>
                    <div class="bg-blue-50 p-1">
                        <div id="air-conditions" class="grid grid-rows-2 grid-cols-2 gap-x-8 h-full bg-pink-300">
                            <div class="bg-gray-100">
                                <p>Feels Like</p>
                                <p><?= $feels_like; ?></p>
                            </div>
                            <div class="bg-green-100">
                                <p>Wind Speed</p>
                                <p><?= $wind; ?></p>
                            </div>
                            <div class="bg-amber-100">
                                <p>Humidity</p>
                                <p><?= $humidity; ?></p>
                            </div>
                            <div class="bg-teal-400">4</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-green-700 col-span-2">
                <div id="7day" class="grid grid-rows-8 h-full gap-1">
                    <div class="bg-amber-500">7 Day Forecast</div>
                    <div class="bg-amber-500">Today</div>
                    <div class="bg-amber-500">Tomorrow</div>
                    <div class="bg-amber-500">Day 3</div>
                    <div class="bg-amber-500">Day 4</div>
                    <div class="bg-amber-500">Day 5</div>
                    <div class="bg-amber-500">Day 6</div>
                    <div class="bg-amber-500">Day 7</div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-gray-700 h-16">
        <div class="bg-amber-700 h-full">footer</div>
    </footer>
</div>
</body>
</html>

<?php
// Replace 'YOUR_API_KEY' with your actual OpenWeatherMap API key
$apiKey = '37cae92af4b42d8acfce79455b70c571';
if (isset($_GET['search'])) {
    $city = $_GET['search']; // Assuming you are using the 'GET' method to retrieve the city name from the input field
} else {
    $city = false;
}
if (!empty($city)) {
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey";

    $response = file_get_contents($apiUrl);

    if ($response) {
        $data = json_decode($response);

        // Extract weather data from the API response
        $cityName = $data->name;
        $temp = $data->main->temp;
        $temperature = $temp - 273;
        $rainProbability = $data->weather[0]->description;
        $weatherIcon = $data->weather[0]->icon;

        // You can now use these variables to display weather data in your HTML
        // For example, you can replace the placeholders in your HTML template with these variables
    } else {
        echo "Failed to fetch weather data.";
    }
} else {
    $cityName = "N/A";
    $temperature = 'N/A';
    $rainProbability = 'N/A';
    $weatherIcon = 'N/A';
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
                    <div class="bg-blue-50">Air conditions</div>
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

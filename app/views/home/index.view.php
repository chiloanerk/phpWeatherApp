<?php
include base_path('/app/views/partials/head.php');
include base_path('/app/views/partials/nav.php');
include base_path('/app/views/partials/header.php');

// Your API key and city
$apiKey = '37cae92af4b42d8acfce79455b70c571';
$city = 'bushbuckridge';

// Build the API URL
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";

// Fetch weather data from the API
$response = file_get_contents($apiUrl);

if ($response) {
    $data = json_decode($response);

    // Extract weather information
    $temperature = $data->main->temp;
    $humidity = $data->main->humidity;
    $windSpeed = $data->wind->speed;
} else {
    // Handle the case where the API request fails
    $temperature = 'N/A';
    $humidity = 'N/A';
    $windSpeed = 'N/A';
}

// Convert temperature from Kelvin to Celsius
$temperatureCelsius = $temperature - 273.15;

// Convert temperature from Kelvin to Fahrenheit
$temperatureFahrenheit = ($temperature - 273.15) * 9 / 5 + 32;

?>

<main class="mt-2 p-4 min-h-full bg-amber-200">
    <div class="grid grid-rows-3 grid-flow-row grid-flow-col gap-4">
        <div class="bg-white row-span-3">
            <p id="temperature">Temperature (Kelvin): <?= $temperature ?></p>
            <p id="temperature-celsius">Temperature (Celsius): <?= $temperatureCelsius ?> &#8451;</p>
            <p id="temperature-fahrenheit">Temperature (Fahrenheit): <?= $temperatureFahrenheit ?> &#8457;</p>
            <p id="humidity">Humidity: <?= $humidity ?>%</p>
            <p id="wind-speed">Wind Speed: <?= $windSpeed ?> m/s</p>
        </div>
        <div class="bg-gray-200 row-span-3">
            <p id="temperature">Temperature (Kelvin): <?= $temperature ?></p>
            <p id="temperature-celsius">Temperature (Celsius): <?= $temperatureCelsius ?> &#8451;</p>
            <p id="temperature-fahrenheit">Temperature (Fahrenheit): <?= $temperatureFahrenheit ?> &#8457;</p>
            <p id="humidity">Humidity: <?= $humidity ?>%</p>
            <p id="wind-speed">Wind Speed: <?= $windSpeed ?> m/s</p>
        </div>
        <div class="bg-white row-span-3">
            <p id="temperature">Temperature (Kelvin): <?= $temperature ?></p>
            <p id="temperature-celsius">Temperature (Celsius): <?= $temperatureCelsius ?> &#8451;</p>
            <p id="temperature-fahrenheit">Temperature (Fahrenheit): <?= $temperatureFahrenheit ?> &#8457;</p>
            <p id="humidity">Humidity: <?= $humidity ?>%</p>
            <p id="wind-speed">Wind Speed: <?= $windSpeed ?> m/s</p>
        </div>
    </div>
</main>

<?php include base_path('/app/views/partials/footer.php'); ?>

<?php

require_once base_path('app/configs/config.php');

// Define default values
$defaultValues = array_fill_keys(['error', 'cityName', 'temperature', 'description', 'weatherIcon', 'feels_like', 'wind', 'humidity', 'clouds', 'latitude', 'longitude'], 'N/A');

try {
// Check if the geolocation form was submitted
if (isset($_GET['lat']) && isset($_GET['lon'])) {
$latitude = $_GET['lat'];
$longitude = $_GET['lon'];

// Make a request to OpenWeatherMap's reverse geocoding API
$geoApiUrl = "http://api.openweathermap.org/geo/1.0/reverse?lat=$latitude&lon=$longitude&limit=1&appid=$apiKey";
$geoResponse = file_get_contents($geoApiUrl);

if ($geoResponse === false) {
throw new Exception("Failed to fetch location data.");
}

$geoData = json_decode($geoResponse);

if ($geoData === null || empty($geoData)) {
throw new Exception("Invalid location data in API response.");
}

// Extract the city name from the location data
$cityname = $geoData[0]->name;

// Redirect to the weather page with the city name
header("Location: ?search=$cityname");
exit();
}

// Check if the manual city search form was submitted
if (isset($_GET['search'])) {
$city = urlencode($_GET['search']);
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=$units&appid=$apiKey";

$context = stream_context_create([
'http' => [
'ignore_errors' => true,
],
]);

$response = file_get_contents($apiUrl, false, $context);

if ($response === false) {
throw new Exception("Failed to fetch weather data.");
}

$data = json_decode($response);

if ($data === null || !isset($data->name, $data->main->temp, $data->weather[0]->description, $data->weather[0]->icon)) {
throw new Exception("Invalid data in API response.");
}

// Extract weather data from the API response
$weatherData = [
'error' => null,
'cityName' => $data->name,
'temperature' => $data->main->temp,
'description' => $data->weather[0]->description,
'weatherIcon' => $data->weather[0]->icon,
'feels_like' => $data->main->feels_like,
'wind' => $data->wind->speed . 'm/s',
'humidity' => $data->main->humidity . '%',
'clouds' => $data->clouds->all . '%',
];

view('home/index', $weatherData);
} else {
view('home/index', $defaultValues);
}
} catch (Exception $e) {
$defaultValues['error'] = $e->getMessage();
view('home/index', $defaultValues);
}

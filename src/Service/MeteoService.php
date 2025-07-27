<?php

namespace App\Service;

class MeteoService
{
    public function findByLocalWeather(): array
    {
        $url = 'https://api.open-meteo.com/v1/forecast?latitude=45.7833&longitude=3.0833&current=temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,weather_code,wind_speed_10m,wind_direction_10m&hourly=temperature_2m,relative_humidity_2m,apparent_temperature,precipitation_probability,weather_code,wind_speed_10m,uv_index&daily=weather_code,temperature_2m_max,temperature_2m_min,apparent_temperature_max,apparent_temperature_min,sunrise,sunset,uv_index_max,precipitation_sum,precipitation_hours,wind_speed_10m_max&timezone=Europe%2FParis&forecast_days=7';

        $jsonResponse = file_get_contents($url);
        return json_decode($jsonResponse, true);
    }
}

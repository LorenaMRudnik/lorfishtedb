<?php

namespace App\services;

class ApiServiceSearch
{
    public static function getSearch($parameter)
    {
        $url = $_ENV['API_URL'] . 'search/' . $parameter;

        $response = @file_get_contents($url);

        if ($response === false) {
            error_log("Error fetching data from URL: $url");
            return [];
        }

        $decodedResponse = json_decode($response, true);
        if (!is_array($decodedResponse)) {
            error_log("Invalid JSON response from URL: $url");
            return [];
        }

        return $decodedResponse;
    }

    public static function getTableByOrder($parameter1, $parameter2)
    {
        $url = $_ENV['API_URL'] . 'search/fish_table/order?' .
            'scientific_name_fish=' . urlencode($parameter1) .
            '&order_name=' . urlencode($parameter2);

        $response = @file_get_contents($url);

        if ($response === false) {
            error_log("Error fetching data from URL: $url");
            return [];
        }

        $decodedResponse = json_decode($response, true);
        if (!is_array($decodedResponse)) {
            error_log("Invalid JSON response from URL: $url");
            return [];
        }

        return $decodedResponse;
    }

    public static function getTableByClass($parameter1, $parameter2)
    {
        $url = $_ENV['API_URL'] . 'search/fish_table/class?' .
            'scientific_name_fish=' . urlencode($parameter1) .
            '&class_name=' . urlencode($parameter2);

        $response = @file_get_contents($url);

        if ($response === false) {
            error_log("Error fetching data from URL: $url");
            return [];
        }

        $decodedResponse = json_decode($response, true);
        if (!is_array($decodedResponse)) {
            error_log("Invalid JSON response from URL: $url");
            return [];
        }

        return $decodedResponse;
    }

    public static function getTableBySuperfamily($parameter1, $parameter2)
    {
        $url = $_ENV['API_URL'] . 'search/fish_table/superfamily?' .
            'scientific_name_fish=' . urlencode($parameter1) .
            '&superfamily_name=' . urlencode($parameter2);

        $response = @file_get_contents($url);

        if ($response === false) {
            error_log("Error fetching data from URL: $url");
            return [];
        }

        $decodedResponse = json_decode($response, true);
        if (!is_array($decodedResponse)) {
            error_log("Invalid JSON response from URL: $url");
            return [];
        }

        return $decodedResponse;
    }

    public static function filterResults($filter, $filtersData)
    {
        $nameFish = $filtersData['name_fish'];

        switch ($filter) {
            case 'class':
                return isset($filtersData['class_name'])
                    ? self::getTableByClass($nameFish, $filtersData['class_name'])
                    : [];
            case 'order':
                return isset($filtersData['order_name'])
                    ? self::getTableByOrder($nameFish, $filtersData['order_name'])
                    : [];
            case 'superfamily':
                return isset($filtersData['superfamily_name'])
                    ? self::getTableBySuperfamily($nameFish, $filtersData['superfamily_name'])
                    : [];
            default:
                return [];
        }
    }
}

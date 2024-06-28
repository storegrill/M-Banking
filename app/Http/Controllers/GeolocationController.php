<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Geolocation;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class GeolocationController extends Controller
{
    private $geolocationApiKey;

    public function __construct()
    {
        $this->geolocationApiKey = env('GEOLOCATION_API_KEY');
    }

    public function getCoordinates(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
        ]);

        $address = $request->input('address');
        $coordinates = $this->fetchCoordinates($address);

        if ($coordinates) {
            // Save to the database
            Geolocation::create([
                'user_id' => Auth::id(),
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lng'],
                'address' => $address,
                'requested_at' => now(),
            ]);

            return response()->json(['coordinates' => $coordinates], 200);
        } else {
            return response()->json(['message' => 'Unable to fetch coordinates'], 500);
        }
    }

    private function fetchCoordinates($address)
    {
        $client = new Client();
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        $response = $client->get($url, [
            'query' => [
                'address' => $address,
                'key' => $this->geolocationApiKey,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] == 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return ['lat' => $location['lat'], 'lng' => $location['lng']];
        }

        return null;
    }

    public function reverseGeocode(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $address = $this->fetchAddress($latitude, $longitude);

        if ($address) {
            // Save to the database
            Geolocation::create([
                'user_id' => Auth::id(),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'address' => $address,
                'requested_at' => now(),
            ]);

            return response()->json(['address' => $address], 200);
        } else {
            return response()->json(['message' => 'Unable to fetch address'], 500);
        }
    }

    private function fetchAddress($latitude, $longitude)
    {
        $client = new Client();
        $url = 'https://maps.googleapis.com/maps/api/geocode/json';

        $response = $client->get($url, [
            'query' => [
                'latlng' => $latitude . ',' . $longitude,
                'key' => $this->geolocationApiKey,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] == 'OK') {
            return $data['results'][0]['formatted_address'];
        }

        return null;
    }
}

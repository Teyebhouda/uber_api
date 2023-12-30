<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UberController extends Controller
{
    public function redirectToUberAuth()
    {
        $clientId = "xu6566j9KTpwqy4z8AauloPLk50ZKuti";
        $redirectUri = "http://127.0.0.1:8000/uber/callback";
        $scopes = "SPACE_DELIMITED_LIST_OF_SCOPES";

        $url = "https://login.uber.com/oauth/v2/authorize?response_type=code&client_id={$clientId}&scope={$scopes}&redirect_uri={$redirectUri}";

        return redirect()->away($url);
    }
    public function handleUberCallback(Request $request)
    {
        $clientId = "xu6566j9KTpwqy4z8AauloPLk50ZKuti";
        $clientSecret = "2TnCwEbaS5SOCyslUVb_Ce7OQbGtiNjmvzsavJ7P";
        $redirectUri = "http://127.0.0.1:8000/uber/profile";

        $code = $request->query('code');

        $response = Http::asForm()->post('https://login.uber.com/oauth/v2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);
dd($response);
        $accessToken = $response->json()['access_token'];

        // Store $accessToken securely (e.g., database, session, cache)

        return redirect()->route('home')->with('success', 'Successfully obtained access token.');
    }


    public function fetchDriverProfile(Request $request)
    {
        $accessToken = 'YOUR_STORED_ACCESS_TOKEN'; // Retrieve the access token securely
    
        $response = Http::withToken($accessToken)
            ->get('https://api.uber.com/v1/partners/me');
    
        if ($response->successful()) {
            $profile = $response->json();
    
            // Process the driver's profile data here
            $firstName = $profile['first_name'];
            $lastName = $profile['last_name'];
            $email = $profile['email'];
    
            // Return or use the profile data as needed
            return response()->json([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
            ]);
        } else {
            // Handle errors or failed responses
            return response()->json([
                'error' => 'Failed to fetch driver profile'
            ], $response->status());
        }
    }
    public function fetchDriverTrips(Request $request)
    {
        $accessToken = 'YOUR_STORED_ACCESS_TOKEN'; // Retrieve the access token securely
        
        $response = Http::withToken($accessToken)
            ->get('https://api.uber.com/v1/partners/trips');
    
        if ($response->successful()) {
            $trips = $response->json(); // Retrieved trips data
            // Process and handle the trips data as needed
        } else {
            // Handle the case when the API request fails
            // You can check $response->status() and $response->body() for more details
        }
    }

    public function fetchDriverPayments(Request $request)
{
    $accessToken = 'YOUR_STORED_ACCESS_TOKEN'; // Retrieve the access token securely
    
    $response = Http::withToken($accessToken)
        ->get('https://api.uber.com/v1/partners/payments');

    if ($response->successful()) {
        $payments = $response->json(); // Retrieved payments data
        // Process and handle the payments data as needed
    } else {
        // Handle the case when the API request fails
        // You can check $response->status() and $response->body() for more details
    }
}


}

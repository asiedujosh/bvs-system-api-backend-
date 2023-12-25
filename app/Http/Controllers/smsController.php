<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GuzzleHttp\Client;

class smsController extends Controller
{
    //
    use HttpResponses;

    public function sendSms(Request $request)
    {
        try {
            // Replace 'YOUR_API_KEY' with your actual API key
            $apiKey = 'RWRFa3pxenNld2hvdlNiTGh0UHU';

            // Extract parameters from the request
            $tel = $request->input('tel');
            $sms = $request->input('sms');

            // Initialize Guzzle client
            $client = new Client();

            // Make a GET request to the Arkesel SMS API
            $response = $client->request('GET', 'https://sms.arkesel.com/sms/api', [
                'query' => [
                    'action' => 'send-sms',
                    'api_key' => $apiKey,
                    'to' => $tel,
                    'from' => 'BVS',
                    'sms' => $sms,
                ],
            ]);

            // Get the response body
           // $responseData = $response->getBody()->getContents();
            return response()->json(['success' => true, 'data' => $responseData]);
            return $this->success([
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Clients;

use GuzzleHttp\Client;

class ChatGPT
{

    public static function getInstance() {
        return new self;
    }

    public function chat($message) {

        $guzzle = new Client();
        $response = $guzzle->post('https://api.openai.com/v1/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
            ],
            'json' => [
                "model" => "gpt-3.5-turbo-instruct",
                "messages" => json_decode('[{"role": "user", "content": "'.$message.'"}]', true),
                "temperature" => 0.7
            ],
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return response()->json($result['choices'][0]['message']['content']);
    }
}
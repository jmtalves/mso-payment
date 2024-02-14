<?php

namespace Libraries;

use GuzzleHttp\Client;

class Request
{
    /**
     * call Api
     * @param string $method
     * @param string $authorization
     * @param string $url
     * @param array $data
     */
    public static function callApi(string $method, string $authorization, string $url, array $data = [])
    {
        $client = new Client();
        try {
            $response = $client->request(
                $method,
                $url,
                [

                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => "" . $authorization,
                    ],
                    'json' => $data
                ]
            );
            return ["status" => $response->getStatusCode(), "body" => json_decode($response->getBody(), true)];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();var_dump($e);die();
            return [
                "status" => $response->getStatusCode(),
                "body" => json_decode($response->getBody()->getContents(), true)
            ];
        }
    }

    /**
     * getPostParams
     *
     * @return array
     */
    public static function getPostParams()
    {
        if (empty($_POST)) {
            $json = file_get_contents('php://input');
            return json_decode($json, true);
        } else {
            return $_POST;
        }
    }
}

<?php

declare(strict_types=1);

namespace app\components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;

class SmspilotSender implements SmsSenderInterface
{
    private string $apiKey;
    private string $apiUrl;
    private Client $httpClient;

    public function __construct(string $apiKey, string $apiUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client(['timeout' => 10]);
    }

    public function send(string $phone, string $message): bool
    {
        try {
            $response = $this->httpClient->get($this->apiUrl, [
                'query' => [
                    'send' => $message,
                    'to' => $phone,
                    'apikey' => $this->apiKey,
                    'format' => 'json',
                ],
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if (isset($data['error'])) {
                Yii::error('SMS API error: ' . $data['error'], __METHOD__);
                return false;
            }

            return isset($data['success']) && $data['success'] === 1;
        } catch (GuzzleException $e) {
            Yii::error('SMS sending exception: ' . $e->getMessage(), __METHOD__);
            return false;
        }
    }
}


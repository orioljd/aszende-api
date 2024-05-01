<?php

namespace App\Service\EuropeCountry;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ListEuropeCountry
{
    const API_URL = 'https://restcountries.com/v3.1/region/europe';

    public function __construct(readonly private HttpClientInterface $client)
    {
    }

    public function __invoke(): array
    {
        try {
            $api_result = $this->getApiResult();
        } catch (TransportExceptionInterface $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }

        $final_result = $this->processApiResult($api_result);

        return $final_result;
    }

    private function getApiResult(): array
    {
        $response = $this->client->request('GET', self::API_URL);

        return $response->toArray();
    }

    private function processApiResult(array $result): array
    {
        $countries = [];
        foreach ($result as $api_country) {
            $country = [];
            $country['name'] = $api_country['name']['common'];
            $country['languages'] = $api_country['languages'];
            $country['population'] = $api_country['population'];
            
            $countries[] = $country;
        }
        return $countries;
    }
}

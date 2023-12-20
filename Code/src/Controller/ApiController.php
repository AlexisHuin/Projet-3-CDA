<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api')]
class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/search', name: 'api.search', methods: ['GET'])]
    public function ApiSearch(Request $request): JsonResponse
    {
        $apiUrl = 'https://opentripmap-places-v1.p.rapidapi.com/en/places/bbox?lon_max=2.325511&lat_min=46.784633&lon_min=-1.75033&lat_max=48.199482&limit=1000';

        try {
            $response = $this->client->request('GET', $apiUrl, [
                'headers' => [
                    'X-RapidAPI-Host' => 'opentripmap-places-v1.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return new JsonResponse(['error' => 'Failed to fetch search results'], $response->getStatusCode());
            }

            $data = $response->toArray();
            $results = $this->processSearchResults($data);

            return new JsonResponse(['results' => $results]);
        } catch (\Exception $e) {
            error_log(print_r($e, TRUE));
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/details', name: 'api.details', methods: ['GET'])]
    public function ApiDetails(Request $request): JsonResponse
    {
        $apiUrl = 'https://opentripmap-places-v1.p.rapidapi.com/en/places/xid/' . $_GET["l"];

        try {
            $response = $this->client->request('GET', $apiUrl, [
                'headers' => [
                    'X-RapidAPI-Host' => 'opentripmap-places-v1.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return new JsonResponse(['error' => 'Failed to fetch'], $response->getStatusCode());
            }

            $data = $response->toArray();

            return new JsonResponse(['data' => $data]);
        } catch (\Exception $e) {
            error_log(print_r($e, TRUE));
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    private function processSearchResults(array $data): array
    {
        $results = [];

        foreach ($data['features'] as $place) {
            $name = $place['properties']['name'];
            $id = $place['properties']['xid'];
            $kinds = $place['properties']['kinds'];
            $web = $place['properties']['rate'] ?? '';
            $preview = $place['properties']['image'] ?? '';
            $info = $place['properties']['wikidata'] ?? '';
            $lat = $place['geometry']['coordinates'][1];
            $long = $place['geometry']['coordinates'][0];

            $results[] = [
                'name' => $name,
                'id' => $id,
                'kinds' => $kinds,
                'web' => $web,
                'preview' => $preview,
                'info' => $info,
                'lat' => $lat,
                'long' => $long,
            ];
        }

        return $results;
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/get_place', name: 'api.get_place', methods: ['GET'])]
    public function getPlace()
    {
        $response = $this->client->request(
            'GET',
            'https://opentripmap-places-v1.p.rapidapi.com/en/places/xid/W223828303',
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'opentripmap-places-v1.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
                ],
                'max_redirects' => 200,
            ]
        );

        $data = $response->getContent(); 
        dd ($data);
        return new JsonResponse($data , 200 , [] , true);
    }

    #[Route('/get_places', name: 'api.get_places', methods: ['GET'])]
    public function getPlaces()
    {
        $response = $this->client->request(
            'GET',
            'https://opentripmap-places-v1.p.rapidapi.com/en/places/bbox?lon_max=2.325511&lat_min=46.784633&lon_min=-1.75033&lat_max=48.199482&limit=10',
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'opentripmap-places-v1.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
                ],
                'max_redirects' => 200,
            ]
        );
        $data = json_decode($response->getContent(),true);

         return $this->render('api/index.html.twig', ['data' => $data]);
    }
    

}
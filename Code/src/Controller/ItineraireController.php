<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ItineraireController extends AbstractController
{
    #[Route('/itineraire', name: 'api.itineraire', methods: ['GET', 'POST'])]
    public function getItineraire(HttpClientInterface $client): JsonResponse
    {
        $apiUrl = 'https://trueway-directions2.p.rapidapi.com/FindDrivingRoute';

        try {
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'X-RapidAPI-Host' => 'trueway-directions2.p.rapidapi.com',
                    'X-RapidAPI-Key' => '4c73ac592bmshcc495df34d8e745p139bd8jsnaa6e612a8e8d',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return new JsonResponse(['error' => 'Failed to fetch search results'], $response->getStatusCode());
            }

            $data = $response->toArray();
            $results = $this->processSearchResults($data);

            // Renvoyer la réponse sous forme de JSON
            return new JsonResponse(['results' => $results]);
        } catch (\Exception $e) {
            error_log(print_r($e, TRUE));
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/mon_itineraire', name: 'api.mon_itineraire', methods: ['GET', 'POST'])]
    public function displayResults(array $results): Response
    {
        return $this->render('pages/itineraire/index.html.twig', [
            'results' => $results,
        ]);
    }
}


<?php

    // #[Route('/search', name: 'api.search', methods: ['GET'])]
    // public function searchApi(string $query)
    // {
    //     $apiUrl = 'https://opentripmap-places-v1.p.rapidapi.com/en/places/bbox?lon_max=2.325511&lat_min=46.784633&lon_min=-1.75033&lat_max=48.199482&limit=1000&kinds=historic';

    //     try {
    //         $response = $this->client->request('GET', $apiUrl, [
    //             'query' => [
    //                 'q' => $query,
    //             ],
    //             'headers' => [
    //                 'X-RapidAPI-Host' => 'opentripmap-places-v1.p.rapidapi.com',
    //                 'X-RapidAPI-Key' => 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
    //             ],
    //         ]);

    //         if ($response->getStatusCode() !== 200) {
    //             return new JsonResponse(['error' => 'Failed to fetch search results'], $response->getStatusCode());
    //         }

    //         // Récupérez les données JSON de la réponse
    //         $data = $response->toArray();
            
    //         foreach ($data['features'] as $place) {
    //             $name = $place['properties']['name'];
    //             $kinds = $place['properties']['kinds'];
    //             $web = $place['properties']['rate'] ?? '';
    //             $preview = $place['properties']['image'] ?? '';
    //             $info = $place['properties']['wikidata'] ?? '';

    //             echo 'Name: ' . $name . '<br>';
    //             echo 'kinds ' .  $kinds . '<br>';
    //             echo 'Web: ' . $web . '<br>';
    //             echo 'Preview: ' . $preview . '<br>';
    //             echo 'Info: ' . $info . '<br>';
    //         }

    //         return new JsonResponse(['results' => $data]);
    //     } catch (\Exception $e) {
    //         // Gérez les erreurs en fonction de vos besoins
    //         return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    //     }
    // }

?>
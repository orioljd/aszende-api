<?php

namespace App\Controller;

use App\Service\EuropeCountry\ListEuropeCountry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CountryController extends AbstractController
{  

    public function __construct(readonly private ListEuropeCountry $country_service)
    {
        
    }

    #[Route('/europe-countries', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse($this->country_service->__invoke());
    }
}

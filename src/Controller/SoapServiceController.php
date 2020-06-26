<?php

namespace App\Controller;

use App\Service\SoapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoapServiceController extends AbstractController
{
    /**
     * @Route("/soap", name="soap")
     * @param SoapService $soapService
     * @return Response
     */
    public function index(SoapService $soapService)
    {
        $soapServer = new \SoapServer('soap.wsdl');
        $soapServer->setObject($soapService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}

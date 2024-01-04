<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', format:('xml'))]
    public function index(Request $request): Response
    {
        // Nous récupérons le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();

        // On initialise un tableau pour lister les URLs
        $urls = [];

        // Adding static urls 
        //priority between 0 and 1 
        $urls[] = ['loc' => $this->generateUrl('app_home'), 'priority' => '1', 'lastmod' => '2024-01-04'];
        $urls[] = ['loc' => $this->generateUrl('app_register')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('demonsList')];
        $urls[] = ['loc' => $this->generateUrl('community')];
        $urls[] = ['loc' => $this->generateUrl('game')];
        $urls[] = ['loc' => $this->generateUrl('itemsList')];
        $urls[] = ['loc' => $this->generateUrl('skillsList')];
        $urls[] = ['loc' => $this->generateUrl('skillTablesList')];

        //adding dynamic urls 
        // ...

        // Fabrication de la réponse XML
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        // Ajout des entêtes
        $response->headers->set('Content-Type', 'text/xml');

        // On envoie la réponse
        return $response;

    }
}

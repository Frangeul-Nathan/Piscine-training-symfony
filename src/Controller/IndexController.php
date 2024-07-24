<?php
// On crée un namespace c'est à dore un chemin pour identifier la classe actuelle
namespace App\Controller;
// On appel le namespace des classes qu'on utilise pour que sqymfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// On étend la classe AbstractController qui permet d'utiliser des fonctions utilitaires pour les controllers (twig etc...)
class IndexController extends AbstractController
{
    // Annotation : permet de créer une route c'est à dire nouvelle page sur notre appli, quand l'URL est appelé ça exécute automatiquement la méthode définit sous la route
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // dump(); die;

        return $this->render('page/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
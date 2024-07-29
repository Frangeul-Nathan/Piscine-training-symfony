<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PokemonController extends AbstractController {


    #[Route('/pokemon-list-db', name: 'pokemon_list_db')]
    public function listPokemonFromDb(PokemonRepository $pokemonRepository) {

        $pokemons = $pokemonRepository->findAll();


        return $this->render('page/pokemon_list_db.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    #[Route('/pokemon-show-db/{idPokemon}', name: 'show_pokemon_db')]
    public function showPokemonFromDb(PokemonRepository $pokemonRepository, int $idPokemon) : Response
    {
        $pokemon = $pokemonRepository->find($idPokemon);

        return $this->render('page/pokemon_show_db.html.twig', [
            'pokemon' => $pokemon
        ]);

    }

    #[Route('/pokemon-db/search/title', name: 'pokemon_search')]
    public function searchPokemon(Request $request, PokemonRepository $pokemonRepository) : Response
    {
        $pokemonsFound= [];

        if ($request->request->has('title')) {

            $titleSearched = $request->request->get('title');

            $pokemonsFound = $pokemonRepository->findLikeTitle($titleSearched);

            if (count($pokemonsFound) === 0) {
                $html = $this->renderView('page/404.html.twig');
                return new Response ($html, 404);
            }
        }

        return $this->render('page/pokemon_search.html.twig', [
            'pokemons' => $pokemonsFound
        ]);

    }

    #[Route('/pokemon/delete/{idPokemon}', name: 'delete_pokemon')]
    public function deletePokemon(int $idPokemon, PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager) : Response
    {
        $pokemon = $pokemonRepository->find($idPokemon);

        if (!$pokemon) {
            $html = $this->renderView('page/404.html.twig');
            return new Response($html, 404);
        }

        // J'utilise la classe entity manager pour préparer la requête SQL de suppresion, c'est requête n'est pas exécutée de suite
        $entityManager->remove($pokemon);
        // Exécute la supression de données dans la BDD
        $entityManager->flush();

        return $this->redirectToRoute('pokemon_list_db');

    }

    #[Route('/pokemons/insert', name: 'insert_pokemon')]
    public function insertPokemon(EntityManagerInterface $entityManager, Request $request)
    {
        // j'instancie la classe de l'entité Pokemon
        // je remplis toutes ces propriétés (soit avec le constructor, qu'il faut créé, soit avec les setters)
        // $pokemon = new Pokemon(
        //     'Roucoups',
        //     'Roucoups est l évolution de Roucool au niveau 18, et il évolue en Roucarnage à partir du niveau 36',
        //     'vol',
        //     'https://www.pokepedia.fr/images/thumb/d/dc/Roucoups-RFVF.png/1200px-Roucoups-RFVF.png'
        // );


        //$error = null;

        // les try catch permettent d'executer du code, tout
        // en récupérant les erreurs potentiels
        // afin de les gérer correctement (affichage de page spécifique etc)
        //try {

        $pokemon = null;

        if ($request->getMethod() === 'POST') {

            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');
            $type = $request->request->get('type');


            $pokemon = new Pokemon();

            $pokemon->setTitle($title);
            $pokemon->setContent( $content);
            $pokemon->setImage($image);
            $pokemon->setType($type);

            // $pokemon->setTitle('Roucoups');
            // $pokemon->setContent('Roucoups est l évolution de Roucool au niveau 18, et il évolue en Roucarnage à partir du niveau 36');
            // $pokemon->setImage('https://www.pokepedia.fr/images/thumb/d/dc/Roucoups-RFVF.png/1200px-Roucoups-RFVF.png');
            // $pokemon->setType('Vol');

            $entityManager->persist($pokemon);
            $entityManager->flush();
        }

        //} catch(\Exception $errorMessage) {
        //    $error = $errorMessage;
        //}

        return $this->render('page/pokemon_insert_with_form.html.twig', [
            'pokemon' => $pokemon
        ]);

    }

    #[Route('/pokemons/insert/form-builder', name: 'insert_pokemon_form_builder')]
    public function insertPokemonFormBuilder(Request $request, EntityManagerInterface $entityManager) : Response
    {

        // je déclare ma classe Pokemon dans une variable $pokemon
        $pokemon = New Pokemon();

        // J'instancie mon gabarit de formulaire pour le lier à l'entité
        $pokemonForm = $this->createForm(PokemonType::class, $pokemon);

        // Liaison du formulaire avec la requête
        $pokemonForm->handleRequest($request);


        // Check de si le formulaire est envoyé et de si les données envoyés sont correctes selon les restrictions
        if ($pokemonForm->isSubmitted() && $pokemonForm->isValid()) {
            $entityManager->persist($pokemon);
            $entityManager->flush();
        }



        return $this->render('page/pokemon_insert_form_builder.html.twig', [
            'pokemonForm' => $pokemonForm->createView()
        ]);
    }
}
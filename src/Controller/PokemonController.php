<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonController extends AbstractController {

    private array $pokemons;

    public function __construct()
    {
        $this->pokemons = [
            [
                'id' => 1,
                'title' => 'Carapuce',
                'content' => 'Pokemon eau',
                'isPublished' => true
            ],
            [
                'id' => 2,
                'title' => 'Salamèche',
                'content' => 'Pokemon feu',
                'isPublished' => true
            ],
            [
                'id' => 3,
                'title' => 'Bulbizarre',
                'content' => 'Pokemon plante',
                'isPublished' => true
            ],
            [
                'id' => 4,
                'title' => 'Pikachu',
                'content' => 'Pokemon electrique',
                'isPublished' => true
            ],
            [
                'id' => 5,
                'title' => 'Rattata',
                'content' => 'Pokemon normal',
                'isPublished' => false
            ],
            [
                'id' => 6,
                'title' => 'Roucool',
                'content' => 'Pokemon vol',
                'isPublished' => true
            ],
            [
                'id' => 7,
                'title' => 'Aspicot',
                'content' => 'Pokemon insecte',
                'isPublished' => false
            ],
            [
                'id' => 8,
                'title' => 'Nosferapti',
                'content' => 'Pokemon poison',
                'isPublished' => false
            ],
            [
                'id' => 9,
                'title' => 'Mewtwo',
                'content' => 'Pokemon psy',
                'isPublished' => true
            ],
            [
                'id' => 10,
                'title' => 'Ronflex',
                'content' => 'Pokemon normal',
                'isPublished' => false
            ]

        ];
    }

    #[Route('/pokemon-list', name: 'pokemon_list')]
    public function pokemonList(): Response
    {

        $html = $this->renderView('page/list_pokemons.html.twig', [
            'pokemons' => $this->pokemons
        ]);

        return new Response($html, 200);

        // return $this->render('article.html.twig', [
        //     'controller_name' => 'ArticleController',
        //     'pokemons' => $pokemons
        // ]);

    }

    #[Route('/pokemon-categories', name: 'pokemon_categories')]
    public function pokemonCategories(): Response
    {

        $categories = [
            'Red', 'Green', 'Blue', 'Yellow', 'Gold', 'Silver', 'Crystal'
        ];

        $html = $this->renderView('page/list_pokemon_categories.html.twig', [
            'categories' => $categories,
        ]);
        
        return new Response($html, 200);
    
    }

    #[Route('/pokemon-show/{idPokemon}', name: 'show_pokemon')]
    public function showPokemon($idPokemon)  : Response
    {

        // $request = Request::createFromGlobals();
        // $idPokemon = $request->query->get('id');

        $pokemonFound = null;

        foreach ($this->pokemons as $pokemon) {
            if ($pokemon['id'] === (int)$idPokemon) {
                $pokemonFound = $pokemon;
            }
        }

        return $this->render('page/pokemon_show.html.twig', [
            'pokemon' => $pokemonFound
        ]);

    }

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
}
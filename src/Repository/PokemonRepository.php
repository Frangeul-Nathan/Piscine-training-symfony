<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function findLikeTitle($search)
{
    // Crée un nouveau QueryBuilder pour l'entité Pokemon, avec l'alias 'pokemon'. createQueryBuilder est une méthode qui fait partie de symfony
    $queryBuilder = $this->createQueryBuilder('pokemon');

    // Construit la requête pour sélectionner l'entité 'pokemon'.
    // La clause WHERE spécifie que le champ 'title' doit contenir la chaîne de recherche.
    // 'LIKE :search' permet de faire une recherche floue. (Pi = peut trouver pikachu, pichu...)
    // Le paramètre ':search' est défini avec des pourcentages (%) pour trouver des titres contenant la chaîne recherchée.
    $query = $queryBuilder->select('pokemon')
        ->where('pokemon.title LIKE :search')
        ->setParameter('search', '%'.$search.'%')
        ->getQuery();

    // Exécute la requête et retourne le résultat sous forme d'un tableau d'objets Pokemon.
    $pokemons = $query->getResult();

    // Retourne les Pokémon trouvés en fonction du titre recherché.
    return $pokemons;
}

    //    /**
    //     * @return Pokemon[] Returns an array of Pokemon objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pokemon
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

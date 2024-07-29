<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

// Création de la table avec php bin/console make:entity
// Génération de la requête SQL avec php bin/console doctrine:migration:diff
// Execution de la BDD avec php bin/console doctrine:migration:migrate

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    // Ajout du constructor pour pouvoir ajouté les propriétés dans mon controller
    // public function __construct($title, $content, $type, $image)
    // {
    //     $this->title = $title;
    //     $this->type = $type;
    //     $this->content = $content;
    //     $this->image = $image;
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {

        // Pour gérer les contraintes de propriétés
        // par exemple si un titre doit faire plus
        // de X caractères
        // on peut soulever une exception
        // pour gérer l'erreur correctement
        //if (strlen($title) < 3) {
        //    throw new \Exception('trop court');
        //}

        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
    $this->type = $type;

    return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}

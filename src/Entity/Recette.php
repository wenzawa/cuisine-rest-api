<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RecetteRepository::class)
 * @ORM\Table(name="recette")
 */
class Recette
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sous_titre;

    /**
     * @ORM\Column(type="text")
     */
    private $ingrediens;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSousTitre(): ?string
    {
        return $this->sous_titre;
    }

    public function setSousTitre(string $sous_titre): self
    {
        $this->sous_titre = $sous_titre;

        return $this;
    }

    public function getIngrediens(): ?string
    {
        return $this->ingrediens;
    }

    public function setIngrediens(string $ingrediens): self
    {
        $this->ingrediens = $ingrediens;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'sous_titre' => $this->getSousTitre(),
            'ingrediens' => $this->getIngrediens(),
        ];
    }
}

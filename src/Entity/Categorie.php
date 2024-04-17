<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Modulee>
     */
    #[ORM\OneToMany(targetEntity: Modulee::class, mappedBy: 'categorie')]
    private Collection $modulees;

    public function __construct()
    {
        $this->modulees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Modulee>
     */
    public function getModulees(): Collection
    {
        return $this->modulees;
    }

    public function addModulee(Modulee $modulee): static
    {
        if (!$this->modulees->contains($modulee)) {
            $this->modulees->add($modulee);
            $modulee->setCategorie($this);
        }

        return $this;
    }

    public function removeModulee(Modulee $modulee): static
    {
        if ($this->modulees->removeElement($modulee)) {
            // set the owning side to null (unless already changed)
            if ($modulee->getCategorie() === $this) {
                $modulee->setCategorie(null);
            }
        }

        return $this;
    }
}

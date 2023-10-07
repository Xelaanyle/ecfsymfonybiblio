<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[UniqueEntity(fields: ['codeIsbn'], message: 'Il existe déjà un livre avec ce code ISBN')]
#[UniqueEntity(fields: ['titre'], message: 'Il existe deja un livre avec ce titre')]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $titre = null;

    #[Assert\NotBlank]
    #[ORM\Column(nullable: true)]
    private ?int $anneeEdition = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?int $nombrePage = null;

    #[Assert\Length(min: 13, max: 13)]
    #[ORM\Column(length: 190, nullable: true)]
    private ?string $codeIsbn = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'livres')]
    private Collection $genres;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Auteur $auteur = null;
    

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneeEdition(): ?int
    {
        return $this->anneeEdition;
    }

    public function setAnneeEdition(?int $anneeEdition): static
    {
        $this->anneeEdition = $anneeEdition;

        return $this;
    }

    public function getNombrePage(): ?int
    {
        return $this->nombrePage;
    }

    public function setNombrePage(int $nombrePage): static
    {
        $this->nombrePage = $nombrePage;

        return $this;
    }

    public function getCodeIsbn(): ?string
    {
        return $this->codeIsbn;
    }

    public function setCodeIsbn(?string $codeIsbn): static
    {
        $this->codeIsbn = $codeIsbn;

        return $this;
    }

    /**
     * @return Collection<int, genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }
}

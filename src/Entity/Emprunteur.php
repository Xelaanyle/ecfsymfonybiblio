<?php

namespace App\Entity;

use App\Repository\EmprunteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmprunteurRepository::class)]
class Emprunteur
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $nom = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 190)]
    #[ORM\Column(length: 190)]
    private ?string $prenom = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 20)]
    #[ORM\Column(length: 190)]
    private ?string $tel = null;

    #[ORM\OneToMany(mappedBy: 'emprunteur', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToOne(inversedBy: 'emprunteur', cascade: ['persist', 'remove'])]
    private ?User $user = null;


    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

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
            $emprunt->setEmprunteur($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getEmprunteur() === $this) {
                $emprunt->setEmprunteur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}

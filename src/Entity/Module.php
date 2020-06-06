<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 5, minMessage = "The name that you entered is to short")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enseignement", mappedBy="module")
     */
    private $enseignements;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enseignant", inversedBy="modules")
     */
    private $enseignant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    public function __construct()
    {
        $this->enseignements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|enseignement[]
     */
    public function getEnseignements(): Collection
    {
        return $this->enseignements;
    }

    public function addEnseignement(enseignement $enseignement): self
    {
        if (!$this->enseignements->contains($enseignement)) {
            $this->enseignements[] = $enseignement;
            $enseignement->setModule($this);
        }

        return $this;
    }

    public function removeEnseignement(enseignement $enseignement): self
    {
        if ($this->enseignements->contains($enseignement)) {
            $this->enseignements->removeElement($enseignement);
            // set the owning side to null (unless already changed)
            if ($enseignement->getModule() === $this) {
                $enseignement->setModule(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }
}

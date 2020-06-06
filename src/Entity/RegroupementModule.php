<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegroupementModuleRepository")
 */
class RegroupementModule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UniteEnseignement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $uniteEnseignement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Module")
     */
    private $modules;

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
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromotion(): ?promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getUniteEnseignement(): ?uniteEnseignement
    {
        return $this->uniteEnseignement;
    }

    public function setUniteEnseignement(?uniteEnseignement $uniteEnseignement): self
    {
        $this->uniteEnseignement = $uniteEnseignement;

        return $this;
    }

    /**
     * @return Collection|module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
        }

        return $this;
    }

    public function removeModule(module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
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
}

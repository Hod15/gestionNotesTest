<?php

namespace App\Entity;

use App\Entity\Note;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Etudiant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Controle", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $controle;

    /**
     * @ORM\Column(type="smallint")
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getControle(): ?controle
    {
        return $this->controle;
    }

    public function setControle(controle $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }
}

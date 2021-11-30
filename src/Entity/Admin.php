<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin", indexes={@ORM\Index(name="gmail_2", columns={"gmail"}), @ORM\Index(name="gmail", columns={"gmail"}), @ORM\Index(name="gmail_3", columns={"gmail"})})
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_admin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdmin;

    /**
     * @var int
     *
     * @ORM\Column(name="num_poste", type="integer", nullable=false)
     */
    private $numPoste;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=250, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="gmail", type="string", length=250, nullable=false)
     */
    private $gmail;

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
    }

    public function getNumPoste(): ?int
    {
        return $this->numPoste;
    }

    public function setNumPoste(int $numPoste): self
    {
        $this->numPoste = $numPoste;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getGmail(): ?string
    {
        return $this->gmail;
    }

    public function setGmail(string $gmail): self
    {
        $this->gmail = $gmail;

        return $this;
    }


}

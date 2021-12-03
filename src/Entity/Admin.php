<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="num_poste", type="integer", nullable=true)
     */
    private $numPoste;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=250, nullable=true)
     */
    private $adresse;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getNumPoste(): ?int
    {
        return $this->numPoste;
    }

    public function setNumPoste(?int $numPoste): self
    {
        $this->numPoste = $numPoste;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


}

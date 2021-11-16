<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membre
 *
 * @ORM\Table(name="membre", indexes={@ORM\Index(name="id_list", columns={"id_list", "id_profil"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Membre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_membre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMembre;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Profession", type="string", length=100, nullable=true)
     */
    private $profession;

    /**
     * @var int
     *
     * @ORM\Column(name="id_list", type="integer", nullable=false)
     */
    private $idList;

    /**
     * @var int
     *
     * @ORM\Column(name="id_profil", type="integer", nullable=false)
     */
    private $idProfil;

    public function getIdMembre(): ?int
    {
        return $this->idMembre;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getIdList(): ?int
    {
        return $this->idList;
    }

    public function setIdList(int $idList): self
    {
        $this->idList = $idList;

        return $this;
    }

    public function getIdProfil(): ?int
    {
        return $this->idProfil;
    }

    public function setIdProfil(int $idProfil): self
    {
        $this->idProfil = $idProfil;

        return $this;
    }


}

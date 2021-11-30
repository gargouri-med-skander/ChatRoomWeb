<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membre
 *
 * @ORM\Table(name="membre")
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
     * @var string
     *
     * @ORM\Column(name="gmail", type="string", nullable=false)
     */
    private $gmail;

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

    public function getGmail(): ?string
    {
        return $this->gmail;
    }

    public function setGmail(string $gmail): self
    {
        $this->gmail = $gmail;

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

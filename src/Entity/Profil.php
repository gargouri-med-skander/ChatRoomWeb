<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity
 */
class Profil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_profil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfil;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", length=65535, nullable=false)
     */
    private $bio;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_publication", type="integer", nullable=false)
     */
    private $nbrPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_profil_path", type="string", length=250, nullable=false)
     */
    private $photoProfilPath;

    public function getIdProfil(): ?int
    {
        return $this->idProfil;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getNbrPublication(): ?int
    {
        return $this->nbrPublication;
    }

    public function setNbrPublication(int $nbrPublication): self
    {
        $this->nbrPublication = $nbrPublication;

        return $this;
    }

    public function getPhotoProfilPath(): ?string
    {
        return $this->photoProfilPath;
    }

    public function setPhotoProfilPath(string $photoProfilPath): self
    {
        $this->photoProfilPath = $photoProfilPath;

        return $this;
    }


}

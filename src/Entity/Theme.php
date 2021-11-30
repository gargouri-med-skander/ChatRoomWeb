<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Theme
 *
 * @ORM\Table(name="theme", uniqueConstraints={@ORM\UniqueConstraint(name="nomTheme", columns={"nom_theme"})})
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 * @UniqueEntity(
 *     fields ={"nomTheme"},
 *     message="le nom que vous avez  indiqué est deja utilisé"
 *     )
 */
class Theme
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_theme", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_theme", type="string", length=100, nullable=false)
     * @Assert\Length(min=2,max=30)
     */
    private $nomTheme;
    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="visibilite", type="boolean", nullable=false)
     */
    private $visibilite;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer", nullable=false)
     */
    private $capacite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbr_participant", type="integer", nullable=true)
     */
    private $nbrParticipant;

    /**
     * @var array|null
     *
     * @ORM\Column(name="list_de_participant", type="json", nullable=true)
     */
    private $listDeParticipant;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=false)
     * @Assert\NotBlank(message="please upload image")
     */
    private $image;

    public function getIdTheme(): ?int
    {
        return $this->idTheme;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getNomTheme(): ?string
    {
        return $this->nomTheme;
    }

    public function setNomTheme(string $nomTheme): self
    {
        $this->nomTheme = $nomTheme;

        return $this;
    }


    public function getVisibilite(): ?bool
    {
        return $this->visibilite;
    }

    public function setVisibilite(bool $visibilite): self
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getNbrParticipant(): ?int
    {
        return $this->nbrParticipant;
    }

    public function setNbrParticipant(?int $nbrParticipant): self
    {
        $this->nbrParticipant = $nbrParticipant;

        return $this;
    }

    public function getListDeParticipant(): ?array
    {
        return $this->listDeParticipant;
    }

    public function setListDeParticipant(?array $listDeParticipant): self
    {
        $this->listDeParticipant = $listDeParticipant;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity
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
     */
    private $nomTheme;

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

    public function getIdTheme(): ?int
    {
        return $this->idTheme;
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

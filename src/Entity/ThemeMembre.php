<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThemeMembre
 *
 * @ORM\Table(name="theme_membre")
 * @ORM\Entity
 */
class ThemeMembre
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
     * @ORM\Column(name="id_theme", type="integer", nullable=false)
     */
    private $idTheme;

    public function getIdMembre(): ?int
    {
        return $this->idMembre;
    }

    public function getIdTheme(): ?int
    {
        return $this->idTheme;
    }

    public function setIdTheme(int $idTheme): self
    {
        $this->idTheme = $idTheme;

        return $this;
    }


}

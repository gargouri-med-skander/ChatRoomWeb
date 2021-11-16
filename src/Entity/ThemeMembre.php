<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThemeMembre
 *
 * @ORM\Table(name="theme_membre", indexes={@ORM\Index(name="id_theme", columns={"id_theme", "id_user"})})
 * @ORM\Entity
 */
class ThemeMembre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_theme_membre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idThemeMembre;

    /**
     * @var int
     *
     * @ORM\Column(name="id_theme", type="integer", nullable=false)
     */
    private $idTheme;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="gmail", type="string", length=250, nullable=false)
     */
    private $gmail;

    public function getIdThemeMembre(): ?int
    {
        return $this->idThemeMembre;
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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

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

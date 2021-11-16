<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signal
 *
 * @ORM\Table(name="signal")
 * @ORM\Entity
 */
class Signal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_signal", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSignal;

    /**
     * @var int
     *
     * @ORM\Column(name="id_membre_signal_maker", type="integer", nullable=false)
     */
    private $idMembreSignalMaker;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_membre_signal_recever", type="integer", nullable=true)
     */
    private $idMembreSignalRecever;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_pub_signal", type="integer", nullable=true)
     */
    private $idPubSignal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_profil_signal", type="integer", nullable=true)
     */
    private $idProfilSignal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_theme_signal", type="integer", nullable=true)
     */
    private $idThemeSignal;

    /**
     * @var string
     *
     * @ORM\Column(name="rapport", type="text", length=65535, nullable=false)
     */
    private $rapport;

    public function getIdSignal(): ?int
    {
        return $this->idSignal;
    }

    public function getIdMembreSignalMaker(): ?int
    {
        return $this->idMembreSignalMaker;
    }

    public function setIdMembreSignalMaker(int $idMembreSignalMaker): self
    {
        $this->idMembreSignalMaker = $idMembreSignalMaker;

        return $this;
    }

    public function getIdMembreSignalRecever(): ?int
    {
        return $this->idMembreSignalRecever;
    }

    public function setIdMembreSignalRecever(?int $idMembreSignalRecever): self
    {
        $this->idMembreSignalRecever = $idMembreSignalRecever;

        return $this;
    }

    public function getIdPubSignal(): ?int
    {
        return $this->idPubSignal;
    }

    public function setIdPubSignal(?int $idPubSignal): self
    {
        $this->idPubSignal = $idPubSignal;

        return $this;
    }

    public function getIdProfilSignal(): ?int
    {
        return $this->idProfilSignal;
    }

    public function setIdProfilSignal(?int $idProfilSignal): self
    {
        $this->idProfilSignal = $idProfilSignal;

        return $this;
    }

    public function getIdThemeSignal(): ?int
    {
        return $this->idThemeSignal;
    }

    public function setIdThemeSignal(?int $idThemeSignal): self
    {
        $this->idThemeSignal = $idThemeSignal;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(string $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_message", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMessage;

    /**
     * @var int
     *
     * @ORM\Column(name="id_userSender", type="integer", nullable=false)
     */
    private $idUsersender;

    /**
     * @var int
     *
     * @ORM\Column(name="id_userRecever", type="integer", nullable=false)
     */
    private $idUserrecever;

    /**
     * @var string
     *
     * @ORM\Column(name="date_envoi", type="string", length=20, nullable=false)
     */
    private $dateEnvoi;

    /**
     * @var string
     *
     * @ORM\Column(name="contenuMessage", type="string", length=255, nullable=false)
     */
    private $contenumessage;

    public function getIdMessage(): ?int
    {
        return $this->idMessage;
    }

    public function getIdUsersender(): ?int
    {
        return $this->idUsersender;
    }

    public function setIdUsersender(int $idUsersender): self
    {
        $this->idUsersender = $idUsersender;

        return $this;
    }

    public function getIdUserrecever(): ?int
    {
        return $this->idUserrecever;
    }

    public function setIdUserrecever(int $idUserrecever): self
    {
        $this->idUserrecever = $idUserrecever;

        return $this;
    }

    public function getDateEnvoi(): ?string
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(string $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getContenumessage(): ?string
    {
        return $this->contenumessage;
    }

    public function setContenumessage(string $contenumessage): self
    {
        $this->contenumessage = $contenumessage;

        return $this;
    }


}

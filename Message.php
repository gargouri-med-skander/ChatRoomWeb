<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vangrg\ProfanityBundle\Validator\Constraints as ProfanityAssert;
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
     * @var string
     *
     * @ORM\Column(name="date_envoi", type="string", length=20, nullable=false)
     */
    private $dateEnvoi;

    /**
     * @var string
     * @Assert\NotBlank(message="Must be filled")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message="{{ value }} must be String "
     * )
     * @ORM\Column(name="contenuMessage", type="string", length=255, nullable=false)
     */
    private $contenumessage;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id_user")
     */
    private $iduserrecever;

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

    public function getIduserrecever(): ?User
    {
        return $this->iduserrecever;
    }

    public function setIduserrecever(?User $iduserrecever): self
    {
        $this->iduserrecever = $iduserrecever;

        return $this;
    }


}

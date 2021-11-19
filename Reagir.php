<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reagir
 *
 * @ORM\Table(name="reagir")
 * @ORM\Entity
 */
class Reagir
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_message", type="integer", nullable=false)
     */
    private $idMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="type_reagir", type="string", length=20, nullable=false)
     */
    private $typeReagir;

    /**
     * @param int $idMessage
     * @param string $typeReagir
     */
    public function __construct(int $idMessage, string $typeReagir)
    {
        $this->idMessage = $idMessage;
        $this->typeReagir = $typeReagir;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMessage(): ?int
    {
        return $this->idMessage;
    }

    public function setIdMessage(int $idMessage): self
    {
        $this->idMessage = $idMessage;

        return $this;
    }

    public function getTypeReagir(): ?string
    {
        return $this->typeReagir;
    }

    public function setTypeReagir(string $typeReagir): self
    {
        $this->typeReagir = $typeReagir;

        return $this;
    }


}

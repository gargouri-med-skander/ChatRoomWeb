<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="action")
 * @ORM\Entity
 */
class Action
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_action", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAction;

    /**
     * @var string
     *
     * @ORM\Column(name="list_jaime", type="string", length=100, nullable=false)
     */
    private $listJaime;

    /**
     * @var string
     *
     * @ORM\Column(name="list_partage", type="string", length=100, nullable=false)
     */
    private $listPartage;

    /**
     * @var string
     *
     * @ORM\Column(name="commenter", type="string", length=100, nullable=false)
     */
    private $commenter;

    public function getIdAction(): ?string
    {
        return $this->idAction;
    }

    public function getListJaime(): ?string
    {
        return $this->listJaime;
    }

    public function setListJaime(string $listJaime): self
    {
        $this->listJaime = $listJaime;

        return $this;
    }

    public function getListPartage(): ?string
    {
        return $this->listPartage;
    }

    public function setListPartage(string $listPartage): self
    {
        $this->listPartage = $listPartage;

        return $this;
    }

    public function getCommenter(): ?string
    {
        return $this->commenter;
    }

    public function setCommenter(string $commenter): self
    {
        $this->commenter = $commenter;

        return $this;
    }


}

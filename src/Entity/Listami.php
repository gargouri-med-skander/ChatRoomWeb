<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Listami
 *
 * @ORM\Table(name="listami")
 * @ORM\Entity
 */
class Listami
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_list", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idList;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_ami", type="integer", nullable=false)
     */
    private $nbrAmi;

    /**
     * @var string
     *
     * @ORM\Column(name="list_ami", type="text", length=65535, nullable=false)
     */
    private $listAmi;

    public function getIdList(): ?int
    {
        return $this->idList;
    }

    public function getNbrAmi(): ?int
    {
        return $this->nbrAmi;
    }

    public function setNbrAmi(int $nbrAmi): self
    {
        $this->nbrAmi = $nbrAmi;

        return $this;
    }

    public function getListAmi(): ?string
    {
        return $this->listAmi;
    }

    public function setListAmi(string $listAmi): self
    {
        $this->listAmi = $listAmi;

        return $this;
    }


}

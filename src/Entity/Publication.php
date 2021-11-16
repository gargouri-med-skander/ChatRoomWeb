<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_publication", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="date_publication", type="string", length=100, nullable=false)
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="pub_path", type="string", length=100, nullable=false)
     */
    private $pubPath;

    public function getIdPublication(): ?string
    {
        return $this->idPublication;
    }

    public function getDatePublication(): ?string
    {
        return $this->datePublication;
    }

    public function setDatePublication(string $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getPubPath(): ?string
    {
        return $this->pubPath;
    }

    public function setPubPath(string $pubPath): self
    {
        $this->pubPath = $pubPath;

        return $this;
    }


}

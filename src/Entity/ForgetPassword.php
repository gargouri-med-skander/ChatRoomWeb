<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForgetPassword
 *
 * @ORM\Table(name="forget_password")
 * @ORM\Entity
 */
class ForgetPassword
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
     * @var string|null
     *
     * @ORM\Column(name="gmail", type="string", length=200, nullable=true)
     */
    private $gmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=200, nullable=true)
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGmail(): ?string
    {
        return $this->gmail;
    }

    public function setGmail(?string $gmail): self
    {
        $this->gmail = $gmail;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }


}

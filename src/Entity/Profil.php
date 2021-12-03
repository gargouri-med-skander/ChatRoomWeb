<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Profil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_profil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProfil;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="bio", type="text", length=65535, nullable=false)
     */
    private $bio;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_publication", type="integer", nullable=false)
     */
    private $nbrPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_profil_path", type="string", length=250, nullable=false)
     */
    private $photoProfilPath;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }


    public function getIdProfil(): ?int
    {
        return $this->idProfil;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getNbrPublication(): ?int
    {
        return $this->nbrPublication;
    }

    public function setNbrPublication(int $nbrPublication): self
    {
        $this->nbrPublication = $nbrPublication;

        return $this;
    }

    public function getPhotoProfilPath(): ?string
    {
        return $this->photoProfilPath;
    }

    public function setPhotoProfilPath(string $photoProfilPath): self
    {
        $this->photoProfilPath = $photoProfilPath;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


    public function getWebpath(){


        return null === $this->photoProfilPath ? null : $this->getUploadDir().'/'.$this->photoProfilPath;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../Chat/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->photoProfilPath = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->photoProfilPath = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }


}

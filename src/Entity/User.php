<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="Un compte existe déjà avec cette adresse email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     *  /**
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le mot de passe doit faire {{ limit }} charactères au minimum",
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     * @OrderBy({"position" = "ASC"})
     */
    private $Categories;

    /**
     * @ORM\OneToMany(targetEntity=Data::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $datas;

    /**
     * @ORM\OneToMany(targetEntity=OptionUser::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $option_users;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mode;

    public function __construct()
    {
        $this->Categories = new ArrayCollection();
        $this->datas = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->option_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->Categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->Categories->contains($category)) {
            $this->Categories[] = $category;
            $category->setUser($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->Categories->contains($category)) {
            $this->Categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Data[]
     */
    public function getDatas(): Collection
    {
        return $this->datas;
    }

    public function addData(Data $data): self
    {
        if (!$this->datas->contains($data)) {
            $this->datas[] = $data;
            $data->setUser($this);
        }

        return $this;
    }

    public function removeData(Data $data): self
    {
        if ($this->datas->contains($data)) {
            $this->datas->removeElement($data);
            // set the owning side to null (unless already changed)
            if ($data->getUser() === $this) {
                $data->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OptionUser[]
     */
    public function getOptionUsers(): Collection
    {
        return $this->option_users;
    }

    public function addOptionUser(OptionUser $optionUser): self
    {
        if (!$this->option_users->contains($optionUser)) {
            $this->option_users[] = $optionUser;
            $optionUser->setUser($this);
        }

        return $this;
    }

    public function removeOptionUser(OptionUser $optionUser): self
    {
        if ($this->option_users->contains($optionUser)) {
            $this->option_users->removeElement($optionUser);
            // set the owning side to null (unless already changed)
            if ($optionUser->getUser() === $this) {
                $optionUser->setUser(null);
            }
        }

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }
}

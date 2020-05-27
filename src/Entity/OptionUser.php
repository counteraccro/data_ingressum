<?php

namespace App\Entity;

use App\Repository\OptionUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionUserRepository::class)
 */
class OptionUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="option_users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Option::class, inversedBy="option_users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $option_data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOptionData(): ?Option
    {
        return $this->option_data;
    }

    public function setOptionData(?Option $option_data): self
    {
        $this->option_data = $option_data;

        return $this;
    }
}

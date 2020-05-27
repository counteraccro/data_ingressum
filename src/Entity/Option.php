<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="text")
     */
    private $info;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $default_value;

    /**
     * @ORM\OneToMany(targetEntity=OptionUser::class, mappedBy="option_data", orphanRemoval=true, cascade={"persist"})
     */
    private $option_users;

    public function __construct()
    {
        $this->option_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

    public function setDefaultValue(string $default_value): self
    {
        $this->default_value = $default_value;

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
            $optionUser->setOptionData($this);
        }

        return $this;
    }

    public function removeOptionUser(OptionUser $optionUser): self
    {
        if ($this->option_users->contains($optionUser)) {
            $this->option_users->removeElement($optionUser);
            // set the owning side to null (unless already changed)
            if ($optionUser->getOptionData() === $this) {
                $optionUser->setOptionData(null);
            }
        }

        return $this;
    }
}

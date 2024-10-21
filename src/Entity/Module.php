<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, SessionModule>
     */
    #[ORM\OneToMany(targetEntity: SessionModule::class, mappedBy: 'module')]
    private Collection $sessionModules;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function __construct()
    {
        $this->sessionModules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SessionModule>
     */
    public function getSessionModules(): Collection
    {
        return $this->sessionModules;
    }

    public function addSessionModule(SessionModule $sessionModule): static
    {
        if (!$this->sessionModules->contains($sessionModule)) {
            $this->sessionModules->add($sessionModule);
            $sessionModule->setModule($this);
        }

        return $this;
    }

    public function removeSessionModule(SessionModule $sessionModule): static
    {
        if ($this->sessionModules->removeElement($sessionModule)) {
            // set the owning side to null (unless already changed)
            if ($sessionModule->getModule() === $this) {
                $sessionModule->setModule(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}

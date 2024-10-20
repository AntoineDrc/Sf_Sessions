<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    /**
     * @var Collection<int, SessionModule>
     */
    #[ORM\OneToMany(targetEntity: SessionModule::class, mappedBy: 'session')]
    private Collection $sessionModules;

    /**
     * @var Collection<int, Intern>
     */
    #[ORM\ManyToMany(targetEntity: Intern::class, mappedBy: 'sessions')]
    private Collection $interns;

    public function __construct()
    {
        $this->sessionModules = new ArrayCollection();
        $this->interns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

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
            $sessionModule->setSession($this);
        }

        return $this;
    }

    public function removeSessionModule(SessionModule $sessionModule): static
    {
        if ($this->sessionModules->removeElement($sessionModule)) {
            // set the owning side to null (unless already changed)
            if ($sessionModule->getSession() === $this) {
                $sessionModule->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intern>
     */
    public function getInterns(): Collection
    {
        return $this->interns;
    }

    public function addIntern(Intern $intern): static
    {
        if (!$this->interns->contains($intern)) {
            $this->interns->add($intern);
            $intern->addSession($this);
        }

        return $this;
    }

    public function removeIntern(Intern $intern): static
    {
        if ($this->interns->removeElement($intern)) {
            $intern->removeSession($this);
        }

        return $this;
    }
}

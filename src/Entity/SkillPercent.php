<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillPercentRepository")
 */
class SkillPercent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Skill", cascade={"persist", "remove"})
     */
    private $skill;

    /**
     * @ORM\Column(type="float")
     */
    private $percent = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    /**
     * @return $this
     */
    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    /**
     * @return $this
     */
    public function setPercent(float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->percent;
    }
}

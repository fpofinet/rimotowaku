<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $testOne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestOne(): ?string
    {
        return $this->testOne;
    }

    public function setTestOne(string $testOne): self
    {
        $this->testOne = $testOne;

        return $this;
    }
}

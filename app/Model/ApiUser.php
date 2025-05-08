<?php

  declare(strict_types=1);

  namespace App\Model;

  use Doctrine\ORM\Mapping as ORM;

  #[ORM\Entity]
  #[ORM\Table(name: 'api_users')]

  class ApiUser
  {
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected int $id;

    #[ORM\Column(length: 255)]
    protected string $name;

    #[ORM\Column(length: 255,unique: true)]
    protected string $apiToken;

    #[ORM\Column]
    protected bool $isActive;

    #[ORM\Column]
    protected \DateTime  $createdAt;

    #[ORM\Column(nullable: true)]
    protected \DateTime  $updatedAt;

    #[ORM\Column(nullable: true)]
    protected \DateTime  $deletedAt;

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
      $this->updatedAt = new \DateTime();
    }

    public function softDelete(): void
    {
      $this->deletedAt = new \DateTime();
      $this->isActive = false;
    }
  }
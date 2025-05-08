<?php

  declare(strict_types=1);

  namespace App\Model;

  use Doctrine\ORM\Mapping as ORM;

  #[ORM\Entity]
  #[ORM\Table(name: 'permissions')]

  class Permission
  {
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected int $id;

    #[ORM\Column(length: 255)]
    protected string $name;

    #[ORM\Column(length: 255)]
    protected string $resource ;

    #[ORM\Column(length: 255)]
    protected string $privilege;

    #[ORM\Column(type: 'text', nullable: true)]
    protected string $description;

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
    }

  }
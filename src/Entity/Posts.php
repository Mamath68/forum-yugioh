<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: "posts")]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $publication = null;

    #[ORM\Column]
    private ?DateTimeImmutable $publication_date;

    #[ORM\ManyToOne(inversedBy: "posts")]
    private ?Topic $topic = null;

    public function __construct()
    {
        $this->publication_date = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPublication(): ?string
    {
        return $this->publication;
    }

    public function setPublication(string $publication): static
    {
        $this->publication = $publication;

        return $this;
    }

    public function getPublicationDate(): ?DateTimeImmutable
    {
        return $this->publication_date;
    }

    public function setPublicationDate(DateTimeImmutable $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): static
    {
        $this->topic = $topic;

        return $this;
    }
}

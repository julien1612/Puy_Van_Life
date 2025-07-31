<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['id'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['description'])]
    private ?string $description = null;

    #[ORM\Column()]
    #[Groups(['latitude'])]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups(['longitude'])]
    private ?float $longitude = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address'])]
    private ?string $address = null;

    #[ORM\Column]
    #[Groups(['createdAt'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    #[Groups(['price'])]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Groups(['type'])]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['imagePath'])]
    private ?string $imagePath = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'location',cascade: ['remove'])]
    private Collection $picture;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'location')]
    private Collection $comments;

    /**
     * @var Collection<int, FavoriteLocation>
     */
    #[ORM\OneToMany(targetEntity: FavoriteLocation::class, mappedBy: 'location')]
    private Collection $favoriteUsers;

    public function __construct()
    {
        $this->picture = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favoriteUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
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

    /**
     * @return Collection<int, Picture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
            $picture->setLocation($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getLocation() === $this) {
                $picture->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setLocation($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getLocation() === $this) {
                $comment->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteLocation>
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function addFavoriteUser(FavoriteLocation $favoriteUser): static
    {
        if (!$this->favoriteUsers->contains($favoriteUser)) {
            $this->favoriteUsers->add($favoriteUser);
            $favoriteUser->setLocation($this);
        }

        return $this;
    }

    public function removeFavoriteUser(FavoriteLocation $favoriteUser): static
    {
        if ($this->favoriteUsers->removeElement($favoriteUser)) {
            // set the owning side to null (unless already changed)
            if ($favoriteUser->getLocation() === $this) {
                $favoriteUser->setLocation(null);
            }
        }

        return $this;
    }
}

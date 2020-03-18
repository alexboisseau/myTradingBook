<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marketType;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="booksUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trade", mappedBy="book", orphanRemoval=true)
     */
    private $bookTrades;

    public function __construct()
    {
        $this->bookTrades = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }
    
    /**
     * Permet d'initialiser le slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeBookDate(){
        if(empty($this->bookDate)) {
            $this->bookDate = new \DateTime() ;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMarketType(): ?string
    {
        return $this->marketType;
    }

    public function setMarketType(string $marketType): self
    {
        $this->marketType = $marketType;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBookDate(): ?\DateTimeInterface
    {
        return $this->bookDate;
    }

    public function setBookDate(\DateTimeInterface $bookDate): self
    {
        $this->bookDate = $bookDate;

        return $this;
    }

    /**
     * @return Collection|Trade[]
     */
    public function getBookTrades(): Collection
    {
        return $this->bookTrades;
    }

    public function getBookProfit():float 
    {
        $trades = $this->bookTrades;
        $bookProfit = 0;
        foreach($trades as $trade){
            $bookProfit += $trade->getProfit();
        }

        return $bookProfit;
    }

    public function addBookTrade(Trade $bookTrade): self
    {
        if (!$this->bookTrades->contains($bookTrade)) {
            $this->bookTrades[] = $bookTrade;
            $bookTrade->setBook($this);
        }

        return $this;
    }

    public function removeBookTrade(Trade $bookTrade): self
    {
        if ($this->bookTrades->contains($bookTrade)) {
            $this->bookTrades->removeElement($bookTrade);
            // set the owning side to null (unless already changed)
            if ($bookTrade->getBook() === $this) {
                $bookTrade->setBook(null);
            }
        }

        return $this;
    }

}

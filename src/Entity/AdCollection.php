<?php

namespace App\Entity;

use App\Repository\AdCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdCollectionRepository::class)]
class AdCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'adCollection', targetEntity: Ad::class)]
    private Collection $ads;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Ad>
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): static
    {
        if (!$this->ads->contains($ad)) {
            $this->ads->add($ad);
            $ad->setAdCollection($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): static
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getAdCollection() === $this) {
                $ad->setAdCollection(null);
            }
        }

        return $this;
    }

    public function displayOneRandomly()
    {
        $rnd = rand(0, count($this->ads)-1);

        if($this->ads[$rnd]->isDisplayable()){
            $this->ads[$rnd]->incrementView();
        } else {
            $this->displayOneRandomly();
        }

    }
    
    public function getSequence(){

        $sequence = [];
        foreach ($this->ads as $ad){
            for($i=0 ; $i<$ad->getWeight(); $i++){
                $sequence[] = $ad;
            }
        }

        return $sequence;

    }
}

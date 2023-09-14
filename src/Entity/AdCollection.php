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

    #[ORM\ManyToMany(targetEntity: Ad::class)]
    private Collection $ads;

    // #[ORM\Column]
    // private ?int $boucle = null;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        // $this->boucle = 1;
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
        }

        return $this;
    }

    public function removeAd(Ad $ad): static
    {
        $this->ads->removeElement($ad);

        return $this;
    }

    // public function getBoucle(): ?int
    // {
    //     return $this->boucle;
    // }

    // public function setBoucle(int $boucle): static
    // {
    //     $this->boucle = $boucle;

    //     return $this;
    // }

    public function displayOneRandomly()
    {

        $ad = $this->pickAdRandomly();
        // $allViews = $this->allViews();
        // $allWeight = $this->allWeight();

        
        // if($allViews == $allWeight*$this->boucle)
        // {
        //     $this->oneMoreBoucle();
        // }
        if($ad->isDisplayable(/*$this->boucle*/)){
            $ad->oneMoreView();
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

    // public function allViews(){

    //     $views = 0;
    //     foreach ($this->ads as $ad){
    //         $views+= $ad->getViews();
    //     }
    //     return $views;
    // }

    // public function allWeight(){

    //     $weight = 0;
    //     foreach ($this->ads as $ad){
    //         $weight+= $ad->getWeight();
    //     }
    //     return $weight;
    // }

    // public function oneMoreBoucle()
    // {
    //     $this->boucle++;
    // }

    //  methode n'utilisant pas la sequence

    public function pickAdRandomly()
    {
        $rnd = rand(0, count($this->ads)-1);

        return $this->ads[$rnd];
    }
}

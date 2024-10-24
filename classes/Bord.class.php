<?php

class Bord
{
    private $kaarten = [];
    private $geselecteerdeKaarten = [];
    private $verkeerdeParen = [];

    public function __construct()
    {
        // Maak een nieuw bord met kaarten en shuffle de waarden.
        $waarden = array_merge(range(1, 8), range(1, 8));
        shuffle($waarden);
        foreach ($waarden as $waarde) {
            // Maak een nieuw kaart met de geshuffelde waarde en voeg het toe aan het bord.
            $this->kaarten[] = new Kaart($waarde);
        }
    }

    public function klikOpKaart($index)
    {
        // Controleer of kaart al geselecteerd is en of het bord vol is.
        if (count($this->geselecteerdeKaarten) < 2 && !$this->kaarten[$index]->isOmgedraaid()) {
            $this->kaarten[$index]->setOmgedraaid();
            $this->geselecteerdeKaarten[] = $index;

            if (count($this->geselecteerdeKaarten) == 2) {
                $this->controleerMatch();
            }
        } elseif (count($this->geselecteerdeKaarten) == 2) {
            $this->resetVerkeerdeParen();
        }
    }

    private function controleerMatch()
    {
        // Controleer of de geselecteerde kaarten een match maken.
        [$eersteIndex, $tweedeIndex] = $this->geselecteerdeKaarten;
        if ($this->kaarten[$eersteIndex]->getWaarde() !== $this->kaarten[$tweedeIndex]->getWaarde()) {
            $this->verkeerdeParen = [$eersteIndex, $tweedeIndex];
        } else {
            $this->geselecteerdeKaarten = [];
        }
    }

    public function zijnVerkeerdeParen()
    {
        // Geef true terug als er verkeerde paren zijn, anders false.
        return !empty($this->verkeerdeParen);
    }

    public function resetVerkeerdeParen()
    {
        // Reset de omgedraaide kaarten en de verkeerde paren.
        foreach ($this->verkeerdeParen as $index) {
            $this->kaarten[$index]->reset();
        }
        $this->verkeerdeParen = [];
        $this->geselecteerdeKaarten = [];
    }

    public function getKaarten()
    {
        // Geef een array met alle kaarten terug.
        return $this->kaarten;
    }

    public function isGewonnen()
    {
        // Controleer of alle kaarten omgedraaid zijn.
        foreach ($this->kaarten as $kaart) {
            if (!$kaart->isOmgedraaid()) {
                return false;
            }
        }
        return true;
    }
}
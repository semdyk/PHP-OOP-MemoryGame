<?php

class Kaart
{
    private $waarde;
    private $omgedraaid;

    public function __construct($waarde)
    {
        $this->waarde = $waarde;
        $this->omgedraaid = false;
    }

    public function setOmgedraaid()
    {
        $this->omgedraaid = !$this->omgedraaid;
    }

    public function isOmgedraaid()
    {
        return $this->omgedraaid;
    }

    public function getWaarde()
    {
        return $this->waarde;
    }

    public function reset()
    {
        $this->omgedraaid = false;
    }
}
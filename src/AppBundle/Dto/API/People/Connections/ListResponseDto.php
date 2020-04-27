<?php


namespace AppBundle\Dto\API\People\Connections;


use Doctrine\Common\Collections\ArrayCollection;

class ListResponseDto
{
    /**
     * @var int
     */
    public $totalItems;

    /**
     * @var int
     */
    public $totalPeople;

    /**
     * @var PersonDto[]
     */
    public $connections;

    public function __construct()
    {
        $this->connections = new ArrayCollection();
    }

    /**
     * @return PersonDto[]
     */
    public function getConnections(): ArrayCollection
    {
        return $this->connections;
    }

    /**
     * @param PersonDto[] $connections
     */
    public function setConnections(ArrayCollection $connections)
    {
        $this->connections = $connections;
    }

    public function addConnection(PersonDto $person)
    {
        $this->connections->add($person);
    }

    public function removeConnection(PersonDto $person)
    {
        $this->connections->removeElement($person);
    }
}
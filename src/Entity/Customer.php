<?php

namespace App\Entity;

use App\Value\DeviceId;
use App\Value\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @var DeviceId
     * @ORM\Column(type="string")
     */
    private $deviceId;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="customer")
     */
    private $transactions;

    public function __construct(Uuid $id, DeviceId $deviceId)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->transactions = new ArrayCollection;
    }
}

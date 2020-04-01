<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post"
 *     },
 *     itemOperations={
 *     }
 * )
 * @ORM\Entity()
 */
class StufInterface
{
    /**
     * @var UuidInterface The UUID identifier of this object
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Groups({"read"})
     * @Assert\Uuid
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $destination;

    /**
     * @ORM\Column(type="array")
     */
    private $headers = [];

    /**
     * @ORM\Column(type="json")
     */
    private $data = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $requestTemplate;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $responceTemplate;

    /**
     * @ORM\Column(type="json")
     */
    private $mapping = [];

    /**
     */
    private $authentication = [];

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->dataset;
    }

    public function setData(array $dataset): self
    {
        $this->data = $data;

        return $this;
    }

    public function getRequestTemplate(): ?string
    {
    	return $this->requestTemplate;
    }

    public function setRequestTemplate(string $requestTemplate): self
    {
    	$this->requestTemplate = $requestTemplate;

        return $this;
    }

    public function getMapping(): ?array
    {
    	return $this->mapping;
    }

    public function setMapping(array $dataset): self
    {
    	$this->mapping = $mapping;

    	return $this;
    }

    public function getAuthentication(): ?array
    {
    	return $this->authentication;
    }

    public function setAuthentication(array $dataset): self
    {
    	$this->authentication = $authentication;

    	return $this;
    }
}

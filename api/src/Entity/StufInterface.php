<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

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
    private $template;

    /**
     * @ORM\Column(type="json")
     */
    private $mapping = [];

    /**
     * @ORM\Column(type="json")
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

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

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

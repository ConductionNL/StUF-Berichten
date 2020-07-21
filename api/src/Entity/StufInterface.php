<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post"
 *     },
 *     itemOperations={
 *          "get"
 *     }
 * )
 * @ORM\Entity()
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
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
    private $id;

    /**
     * @var string The destination url of the request
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     */
    private $destination;

    /**
     * @var array The headers to pass on when performing an request
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="array")
     */
    private $headers = [];

    /**
     * @var array The data to be passed on as StUF
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     */
    private $data = [];

    /**
     * @var string The template to use to create the StUF message
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $requestTemplate;

    /**
     * @var string The template to use to create the StUF message
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $responseTemplate;

    /**
     * @var array
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="json")
     */
    private $mapping = [];

    /**
     * @var array
     *
     * @Groups({"write"})
     * @ORM\Column(type="json")
     */
    private $authentication = [];

    /**
     * @var string The HTTP method to use
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $requestMethod = 'POST';

    /**
     * @var Datetime The moment this resource was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var Datetime The moment this resource last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @var string The response received from the remote destination
     *
     * @Groups({"read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $response;

    /**
     * @var string The username to login with when using auth parameters
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string The password to login with when using auth parameters
     * @Groups({"write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string The digest needed to login with when using auth parameters
     * @Groups({"write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $digest;

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
        return $this->data;
    }

    public function setData(array $data): self
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

    public function getResponseTemplate(): ?string
    {
        return $this->responseTemplate;
    }

    public function setResponseTemplate(string $responseTemplate): self
    {
        $this->responseTemplate = $responseTemplate;

        return $this;
    }

    public function getMapping(): ?array
    {
        return $this->mapping;
    }

    public function setMapping(array $mapping): self
    {
        $this->mapping = $mapping;

        return $this;
    }

    public function getAuthentication(): ?array
    {
        return $this->authentication;
    }

    public function setAuthentication(array $authentication): self
    {
        $this->authentication = $authentication;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): self
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDigest(): ?string
    {
        return $this->digest;
    }

    public function setDigest(?string $digest): self
    {
        $this->digest = $digest;

        return $this;
    }
}

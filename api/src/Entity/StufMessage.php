<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post"={
 *      		"path"="/stuf_messages",
 *              "method"="POST",
 *              "swagger_context" = {
 *              	"description" = "Converts JSON data to a StUF message based upon twig templates and a dataset",
 *                  "parameters" = {
 *                      {
 *                          "name" = "destination",
 *                          "in" = "request",
 *                          "description" = "The location the StUF message should be sent to",
 *                          "required" = true,
 *                          "type" : "string"
 *                      },
 *                      {
 *                          "name" = "headers",
 *                          "in" = "request",
 *                          "description" = "The request headers that should be passed to the destination server",
 *                          "required" = true,
 *                          "type" : "array"
 *                      },
 *                      {
 *                          "name" = "dataset",
 *                          "in" = "request",
 *                          "description" = "The dataset to be transformed to StUF",
 *                          "required" = true,
 *                          "type" : "json",
 *                      },
 *                      {
 *                          "name" = "template",
 *                          "in" = "request",
 *                          "description" = "The name of the template that should be used to form the message",
 *                          "required" = true,
 *                          "type" : "string",
 *                      }
 *                  }
 *               }
 *          }
 *          "post_stuf"={
 *      		"path"="/stuf_messages/stuf",
 *              "method"="POST",
 *              "swagger_context" = {
 *              	"description" = "Converts a StUF message to JSON",
 *                  "parameters" = {
 *                      {
 *                          "name" = "destination",
 *                          "in" = "query",
 *                          "description" = "The location the StUF message should be sent to",
 *                          "required" = true,
 *                          "type" : "string"
 *                      }
 *                  }
 *               }
 *          }
 *     },
 *     itemOperations={
 *     }
 * )
 * @ORM\Entity()
 */
class StufMessage
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

    public function getId(): ?int
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

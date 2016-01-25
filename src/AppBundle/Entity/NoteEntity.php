<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="noteEntity")
 */
class NoteEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $secret;

    /**
     * @ORM\Column(type="text")
     */
    protected $message;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $new_version = 1.1;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $version = 1;

    protected $urls = array();

    public function getId()
    {
        return $this->id;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }


    public function getVersion()
    {
        return $this->version;
    }


    public function setNewVersion($new_version)
    {
         $this->new_version = $new_version;

         return $this;
    }


    public function getNewVersion()
    {
        return $this->version;
    }

    public function addUrl($name, $url)
    {
      if(!isset($this->urls)){
        $this->urls = array();
      }
      $this->urls[$name] = $url;

      return $this;
    }

    public function getUrls()
    {
      return $this->urls;
    }

    /**
     * String representation for a note
     *
     * @return string
     */
    public function __toString()
    {
        return $this->message;
    }
}

<?php

namespace RcmMessage\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @category  Reliv
 * @package   moduleNameHere
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 *
 * @ORM\Entity (repositoryClass="RcmMessage\Repository\Message")
 * @ORM\Table (
 *     name="rcm_message_message"
 * )
 */
class Message extends MessageAbstract implements MessageInterface
{
    /**
     * @var int $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string $level
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $level = 2;

    /**
     * @var string $subject
     * @ORM\Column(type="string", length=128, nullable=false)
     */
    protected $subject = '';

    /**
     * @var string $message
     * @ORM\Column(type="string", length=512, nullable=false)
     */
    protected $message = '';

    /**
     * @var string $source
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $source = null;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated = null;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return void
     */
    public function setLevel($level)
    {
        if (empty($level)) {
            $level = self::LEVEL_DEFAULT;
        }

        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     *
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param $source
     *
     * @return void
     */
    public function setSource($source)
    {
        if (empty($source)) {
            $source = null;
        }
        $this->source = $source;
    }

    /**
     * @return \Datetime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     *
     * @return void
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * from ISO8601 string
     *
     * @param $dateCreated
     *
     * @return void
     */
    public function setDateCreatedString($dateCreated)
    {
        $date = \DateTime::createFromFormat(\DateTime::ISO8601, $dateCreated);

        $this->setDateCreated($date);
    }

    /**
     * @return null|string
     */
    public function getDateCreatedString()
    {
        if (empty($this->dateCreated)) {
            return null;
        }

        return $this->dateCreated->format(\DateTime::ISO8601);
    }

    /**
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function findProperty($key, $default = null)
    {
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        }

        return $default;
    }

    /**
     * @param array $ignore
     *
     * @return array
     */
    public function toArray($ignore = [])
    {
        $array = get_object_vars($this);

        $array['dateCreated'] = $this->getDateCreatedString();

        return $array;
    }
}

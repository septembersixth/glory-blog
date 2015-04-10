<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Post
 * @ORM\Entity(repositoryClass="Application\Repository\Post")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $text;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Application\Entity\Tag")
     *
     */
    protected $tags;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Application\Entity\Comment", mappedBy="post")
     */
    protected $comments;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \Datetime
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \Datetime
     */
    protected $updated;

    /**
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    protected $deleted = false;

    public function __construct()
    {
        $this->tags     = new ArrayCollection;
        $this->comments = new ArrayCollection;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param $updated
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param $deleted
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = (bool) $deleted;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTags(Collection $tags)
    {
        foreach($tags as $tag) {
            $this->tags->add($tag);
        }
    }

    /**
     * @param Collection $tags
     */
    public function removeTags(Collection $tags)
    {
        foreach($tags as $tag) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * @param Collection $comments
     */
    public function addComments(Collection $comments)
    {
        foreach($comments as $comment) {
            $this->comments->add($comment);
        }
    }

    /**
     * @param Collection $comments
     */
    public function removeComments(Collection $comments)
    {
        foreach($comments as $comment) {
            $this->comments->removeElement($comment);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        if (empty($image['image']['error'])) {
            $this->image = substr(strrchr($image['tmp_name'], '/'), 1);
        }
        return $this;
    }
}
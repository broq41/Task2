<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


class File
{

    protected $id;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File Contains uploaded file for further processing
     */
    protected $file;


    protected $filename;


    protected $name;

    protected $size = 0;

    protected $mimetype;


    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filename.
     *
     * @param string|null $filename
     *
     * @return File
     */
    public function setFilename($filename = null)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename.
     *
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return File
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set size.
     *
     * @param int|null $size
     *
     * @return File
     */
    public function setSize($size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return int|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set mimetype.
     *
     * @param string|null $mimetype
     *
     * @return File
     */
    public function setMimetype($mimetype = null)
    {
        $this->mimetype = $mimetype;

        return $this;
    }

    /**
     * Get mimetype.
     *
     * @return string|null
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }


}

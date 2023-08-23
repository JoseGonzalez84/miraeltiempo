<?php

class Html {
    private string $_id='';
    private string $_name='';
    private string $_element;
    private string $_class;
    private string $_style;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId(int $id)
    {
        $this->_id = $id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName(string $name)
    {
        $this->_name = $name;
    }

    public function getElement()
    {
        return $this->_element;
    }

    public function setElement(string $element)
    {
        $this->_element = $element;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function setClass(string $class, bool $keep=false)
    {
        $this->_class = ($keep === true) ? $this->_class.' '.$class : $class;
    }

    public function getStyle()
    {
        return $this->_style;
    }

    public function setStyle(string $style, bool $keep=false)
    {
        $this->_style = ($keep === true) ? $this->_style.' '.$style : $style;
    }

    public function print(bool $return=false)
    {
        if ($return === true) {
            return $this->_element;
        } else {
            echo $this->_element;
        }
    }
}
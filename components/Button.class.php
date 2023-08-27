<?php

require_once 'Html.class.php';

class Button extends Html
{
    private bool $_post=false;
    private array $_dataForSend=[];

    public function __construct(
        private string $_title='',
        private string $_type='',
        private string $_url='',
        private string $_icon='',
    ) {

    }

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setTitle(string $title)
    {
        $this->_title = $title;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setUrl(string $url)
    {
        $this->_url = $url;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setIcon(string $icon)
    {
        $this->_icon = $icon;
    }

    public function getIcon()
    {
        return $this->_icon;
    }

    public function setPost(bool $isPost)
    {
        $this->_post = $isPost;
    }

    public function isPost()
    {
        return $this->_post;
    }

    public function setDataForSend(array $dataForSend)
    {
        $this->_dataForSend = $dataForSend;
    }

    public function getDataForSend()
    {
        return $this->_dataForSend;
    }

    public function build()
    {
        if ($this->isPost() === false) {
            $output = '<a class="button is-'.$this->getType().'" href="'.$this->getUrl().'">';
        } else {
            $output = '<form method="POST" action="'.$this->getUrl().'"><input type="submit" class="button is-'.$this->getType().'">';
            foreach ($this->getDataForSend() as $key => $value) {
                $output .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
            }
        }

        if (empty($this->getIcon()) === false) {
            $output .= '<span class="icon"><i class="fa-solid fa-'.$this->getIcon().'"></i></span>';
        }

        $output .= '<span>'.$this->getTitle().'</span>';
        if ($this->isPost() === false) {
            $output .= '</a>';
        } else {
            $output .= '</button></form>';
        }

        $this->setElement($output);
    }
}

<?php

require_once 'Html.class.php';

class Select extends Html
{
    private string $_onChange='';

    public function __construct(
        private array $options=[],
    ) {

    }

    public function build(bool $print=true, bool $return=false)
    {
        $element = '<select';

        if (empty(parent::getId()) === false) {
            $element .= ' id="'.parent::getId().'"';
        }

        $element .= ' name="'.parent::getName().'"';

        if (empty($this->_onChange) === false) {
            $element .= ' onChange="'.$this->getOnChange().'"';
        }

        $element .= '>';

        foreach ($this->getOptions() as $value) {
            $element .= '<option value="'.key($value).'">'.$value[key($value)].'</option>';
        }

        $element .= '</select>';

        parent::setElement($element);

        if ($return === true) {
            return $element;
        } else {
            if ($print === true) {
                parent::print();
            }
        }
    }

    public function setOptions(array $options=[])
    {
        array_merge($this->options, $options);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOnChange(string $action)
    {
        $this->_onChange = $action;
    }

    public function getOnChange()
    {
        return $this->_onChange;
    }
}
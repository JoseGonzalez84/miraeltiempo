<?php

require_once 'Html.class.php';

class Hidden extends Html {
    public function __construct(
        private string $value='',
    ) {

    }

    public function build(bool $return=false)
    {
        $element = '<input type="hidden"';

        if (empty(parent::getId()) === false) {
            $element .= ' id="'.parent::getId().'"';
        }

        $element .= ' name="'.parent::getName().'"';
        $element .= ' value="'.$this->getValue().'"';

        $element .= ' />';

        parent::setElement($element);

        if ($return === true) {
            return $element;
        } else {
            parent::print();
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }
}
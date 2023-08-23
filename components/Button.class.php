<?php

require_once 'Html.class.php';

class Button extends Html
{
    private string $_onChange='';

    public function __construct(
        private array $options=[],
    ) {

    }
}

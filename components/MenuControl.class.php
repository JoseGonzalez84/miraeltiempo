<?php

require_once 'Html.class.php';
require_once 'Button.class.php';

class MenuControl extends Html
{
    private string $_name='';
    private string $_backgroundColor='';
    private string $_location='';
    private array $_buttons=[];

    public function __construct()
    {

    }

    public function setButton(Button $button)
    {
        $this->_buttons[] = $button;
    }

    public function getButtons()
    {
        return $this->_buttons;
    }

    public function build()
    {
        $output = <<<'EOT'
            <nav class="navbar is-transparent">
                <div class="navbar-brand">
                    <a style="display: flex;align-items: center;" title="Fabián Alexis, CC BY-SA 3.0 &lt;https://creativecommons.org/licenses/by-sa/3.0&gt;, via Wikimedia Commons" href="http://localhost/miraeltiempo">
                        <span style="font-size: 2rem;padding-left: 1rem;margin-right: -1.5rem;">Miraeltiempo</span>
                        <img width="64" alt="Antu weather-showers-day" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Antu_weather-showers-day.svg/64px-Antu_weather-showers-day.svg.png">
                    </a>
                    <div class="navbar-burger" data-target="navbarExampleTransparentExample">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="field is-grouped">
                            <p class="control">
        EOT;

        foreach ($this->getButtons() as $button) {
            $output .= $button->getElement();
        }

        $output .= <<<'EOT'
                            </p>
                        </div>
                    </div>
                </div>
            </nav>
        EOT;

        return $output;
    }
}

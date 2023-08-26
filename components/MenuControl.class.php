<?php

require_once 'Html.class.php';

class MenuControl extends Html
{
    private string $_name='';
    private string $_backgroundColor='';
    private string $_location='';
    private array $_buttons=[];

    public function __construct()
    {

    }

    public function getButtons()
    {
        return $this->_buttons;
    }

    public function printButtons()
    {
        $output = '';

        foreach ($this->getButtons() as $button) {
            $output .= $button;
        }

        return $output;
    }

    public function addButton(
        string $title,
        string $type,
        string $url,
        string $icon='',
        bool $post=false,
        array $dataForSend=[],
    ) {
        if ($post === false) {
            $output = '<a class="button is-'.$type.'" href="'.$url.'">';
        } else {
            $output = '<form method="POST" action="'.$url.'"><input type="submit" class="button is-'.$type.'">';
            foreach ($dataForSend as $key => $value) {
                $output .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
            }
        }

        if (empty($icon) === false) {
            $output .= '<span class="icon"><i class="fa-solid fa-'.$icon.'"></i></span>';
        }

        $output .= '<span>'.$title.'</span>';
        if ($post === false) {
            $output .= '</a>';
        } else {
            $output .= '</button></form>';
        }

        $this->_buttons[] = $output;
    }

    public function build()
    {
        $output = <<<'EOT'
            <nav class="navbar is-transparent">
                <div class="navbar-brand">
                    <a style="display: flex;align-items: center;" title="Fabián Alexis, CC BY-SA 3.0 &lt;https://creativecommons.org/licenses/by-sa/3.0&gt;, via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File:Antu_weather-showers-day.svg">
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

        $output .= $this->printButtons();

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

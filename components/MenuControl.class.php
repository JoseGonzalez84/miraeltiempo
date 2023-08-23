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

    public function getButtons() {
        return $this->_buttons;
    }

    public function addButton(
        string $title,
        string $type,
        string $url,
        string $icon='',
    ) {
        $output = '<a class="button is-'.$type.'" href="'.$url.'">';

        if (empty($icon) === false) {
            $output .= '<span class="icon"><i class="fab '.$icon.'"></i></span>';
        }

        $output .= '<span>'.$title.'</span>';
        $output .= '</a>';

        $this->_buttons[] = $output;
    }

    public function build() {
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
                            <a class="bd-tw-button button" data-social-network="Twitter" data-social-action="tweet" data-social-target="https://bulma.io" target="_blank" href="https://twitter.com/intent/tweet?text=Bulma: a modern CSS framework based on Flexbox&amp;hashtags=bulmaio&amp;url=https://bulma.io&amp;via=jgthms">
                                <span class="icon">
                                <i class="fab fa-twitter"></i>
                                </span>
                                <span>
                                Tweet
                                </span>
                            </a>
                            </p>
                            <p class="control">
                            <a class="button is-primary" href="https://github.com/jgthms/bulma/releases/download/0.9.4/bulma-0.9.4.zip">
                                <span class="icon">
                                <i class="fas fa-download"></i>
                                </span>
                                <span>Download</span>
                            </a>
                            </p>
                        </div>
                    </div>
                </div>
            </nav>
        EOT;

        return $output;
    }
}

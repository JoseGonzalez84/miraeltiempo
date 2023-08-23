<?php

class WebContent
{
    public function __construct(
        private string $_title,
        private array $_content=[]
    ) {

    }

    public function getContent()
    {
        return $this->_content;
    }

    public function setContent(mixed $data)
    {
        $this->_content[] = $data;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle(string $title)
    {
        $this->_title = $title;
    }

    public function print()
    {
        echo <<<'EOT'
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
            <script src="https://kit.fontawesome.com/3f787ec5e9.js" crossorigin="anonymous"></script>
        EOT;

        echo '<title>'.$this->getTitle().'</title>';
        echo <<<'EOT'
        </head>
        <body>
        <div class="container">
        EOT;

        foreach ($this->getContent() as $line) {
            print_r($line);
        }

        echo <<<'EOT'
        </div>
        </body>
        </html>
        EOT;
    }
}

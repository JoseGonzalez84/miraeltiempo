<?php

class Curl {

    private $_curlObject;
    private $_apiKey = '';

    public function __construct(
        private array $headers=[],
        private string $method='',
        private string $url='',
        private array $params=[]
        )
    {
        $this->_curlObject = curl_init();
    }

    private function retrieve() {
        switch($this->method) {
            case 'POST':
                $this->headers = array(
                    'Content-type: text/plain',
                );

                if (isset($this->params['Authorization']) === true) {
                    $this->headers[] = 'Authorization: '.$this->params['Authorization'];
                    unset($this->params['Authorization']);
                }

                curl_setopt($this->_curlObject, CURLOPT_CUSTOMREQUEST, $this->method);
                curl_setopt($this->_curlObject, CURLOPT_HTTPHEADER, $this->headers);
                curl_setopt($this->_curlObject, CURLOPT_POSTFIELDS, $this->params);
            break;

            case 'PUT':
                // At this moment, do nothing.
            break;

            default:
            case 'GET':
                $urlProcessed = '?';
                foreach($this->params as $key => $value) {
                    $urlProcessed .= '&'.$key.'='.$value;
                }
                $this->url .= $urlProcessed;

                $apiKey = $this->getApiKey();

                // Set the api key.
                if (empty($apiKey) === false) {
                    $this->url .= '&api_key='.$apiKey;
                }

                curl_setopt($this->_curlObject, CURLOPT_CUSTOMREQUEST, $this->method);
            break;
        }

        curl_setopt($this->_curlObject, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_curlObject, CURLOPT_URL, $this->url);
        $output = curl_exec($this->_curlObject);
        curl_close($this->_curlObject);

        return $output;
    }

    public function retrieveData()
    {
        return json_decode($this->retrieve());
    }

    public function getApiKey(): string {
        return $this->_apiKey;
    }

    public function setApiKey(string $key) {
        $this->_apiKey = $key;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function setUrl(string $url) {
        $this->url = $url;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function setMethod(string $method) {
        if ($method === 'POST' || $method === 'GET') {
            $this->method = $method;
        } else {
            $this->method = 'GET';
        }
    }

    public function getParams(): array {
        return $this->params;
    }

    public function setParams(...$param) {
        $this->params = array_push($this->params, $param);
    }
}

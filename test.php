<?php

require_once __DIR__.'/vendor/autoload.php';

use Ethansmart\Httpbuilder\Builder\HttpClientBuilder;

class Test
{
    protected $client ;
    function __construct()
    {
        $this->client = HttpClientBuilder::create()
            ->build();
    }

    public function get()
    {
        $data = [
            'uri'=>'https://www.baidu.com'
        ];

        return $this->client
            ->setHeaders('Content-Type:application/json')
            ->setHeaders('X-HTTP-Method-Override:GET')
            ->setHeaders('Request_id: Ethan')
            ->setTimeout(10)
            ->Get($data);
    }
};

(new Test())->get();

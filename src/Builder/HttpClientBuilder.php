<?php

namespace Ethansmart\Httpbuilder\Builder;

use Ethansmart\Httpbuilder\Http\HttpClient;
use BadMethodCallException;
use Log;

class HttpClientBuilder
{
    protected $version = null ;
    protected $headers = null ;

    public function __construct()
    {
        $this->version = "1.0";
    }

    public static function create()
    {
        return new static();
    }

    public function build()
    {
        return new HttpClient();
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        throw new BadMethodCallException("该版本中".$this->version." $name 不支持");
    }

    public function getVersion()
    {
        return $this->version;
    }


}
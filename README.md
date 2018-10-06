PHP Curl Http Client

### Usage

Http Client Support Http Method : GET, POST, PUT , DELETE

### 构建 HttpClient

```php

protected $client ;
function __construct()
{
    $this->client = HttpClientBuilder::create()->build();
}

```

### GET Request

```php

$data = [
    'uri'=>'https://www.baidu.com'
];

return $this->client
    ->setHeaders('Content-Type:application/json')
    ->setHeaders('X-HTTP-Method-Override:GET')
    ->setHeaders('Request_id: Ethan')
    ->setTimeout(10)
    ->Get($data);

```

### POST Request

```php

$data = [
    'uri'=>'https://www.baidu.com',
    'params'=> [
        'user'=>ethan
     ]
];

return $this->client
    ->setHeaders('Content-Type:application/json')
    ->Post($data);

```

### PUT 、DELETE Request

```php

$data = [
    'uri'=>'https://www.baidu.com',
    'params'=> [
        'user'=>ethan
     ]
];

return $this->client
    ->setHeaders('Content-Type:application/json')
    ->Put($data); // Delete($data)

```

<?php

namespace InstaSync\Service;

use Guzzle\Http\Client;

class Instapaper
{
    const ENDPOINT = 'https://www.instapaper.com/api';

    private $client;

    private $username;

    private $password;

    public function __construct(Client $client, $username, $password)
    {
        $this->client   = $client;
        $this->username = $username;
        $this->password = $password;
    }

    public function addUrl($url, $source = null)
    {
        $response = $this->client->post(
            sprintf('%s/add', self::ENDPOINT),
            null,
            array(
                'username'  => $this->username,
                'password'  => $this->password,
                'url'       => $url,
                'selection' => $source,
            )
        )->send();

        return 201 === $response->getStatusCode();
    }
}

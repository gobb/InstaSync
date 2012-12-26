<?php

namespace InstaSync\Service;

use Guzzle\Http\Client;

class Instapaper
{
    const ENDPOINT = 'https://www.instapaper.com/api';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param Client $client
     * @param string $username
     * @param string $password
     */
    public function __construct(Client $client, $username, $password)
    {
        $this->client   = $client;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Adds an URL to an Instapaper account. Returns true if the URL
     * has been successfully added, false otherwise.
     *
     * @param string $url    The URL to add
     * @param string $source The source of the link
     * @return boolean
     */
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

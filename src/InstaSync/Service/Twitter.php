<?php

namespace InstaSync\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class Twitter
{
    const ENDPOINT = 'https://api.twitter.com';

    private $client;

    public function __construct(Client $client, $consumerKey, $consumerSecret, $userToken, $userSecret)
    {
        $this->client = $client;
        $this->client->addSubscriber(new OauthPlugin(array(
            'consumer_key'    => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token'           => $userToken,
            'token_secret'    => $userSecret,
        )));
    }

    public function get($url)
    {
        $response = $this->client
            ->get(sprintf('%s/%s', self::ENDPOINT, $url), null)
            ->send();

        return $response->json();
    }

    public function getFavorites()
    {
        return $this->get('1.1/favorites/list.json');
    }
}

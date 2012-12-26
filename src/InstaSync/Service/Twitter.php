<?php

namespace InstaSync\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class Twitter
{
    const ENDPOINT = 'https://api.twitter.com';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param string $userToken
     * @param string $userSecret
     */
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

    /**
     * Performs a GET request to the Twitter API.
     *
     * @param  string $url
     * @return array
     */
    public function get($url)
    {
        $response = $this->client
            ->get(sprintf('%s/%s', self::ENDPOINT, $url))
            ->send();

        return $response->json();
    }

    /**
     * Returns the favorite tweets for the current user.
     *
     * @return array
     */
    public function getFavorites()
    {
        return $this->get('1.1/favorites/list.json');
    }

    /**
     * Delete a tweet in the user's favorites list.
     *
     * @param  int     $id
     * @return boolean
     */
    public function deleteFavorite($id)
    {
        $response = $this->client
            ->post(sprintf('%s/1.1/favorites/destroy.json', self::ENDPOINT), null, array(
                'id' => $id,
            ))
            ->send();

        return $response->isSuccessful();
    }
}

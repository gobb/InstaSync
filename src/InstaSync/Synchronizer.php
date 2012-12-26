<?php

namespace InstaSync;

use InstaSync\Service\Twitter;
use InstaSync\Service\Instapaper;

class Synchronizer
{
    /**
     * @var Twitter
     */
    private $twitter;

    /**
     * @var Instapaper
     */
    private $instapaper;

    /**
     * @param Twitter    $twitter
     * @param Instapaper $instapaper
     */
    public function __construct(Twitter $twitter, Instapaper $instapaper)
    {
        $this->twitter    = $twitter;
        $this->instapaper = $instapaper;
    }

    /**
     * Synchronize a Twitter account with an Instapaper account.
     *
     * @return int The number of URLs added
     */
    public function synchronize()
    {
        $count = 0;
        foreach ($this->twitter->getFavorites() as $favorite) {
            $url    = $this->extractUrl($favorite['text']);
            $source = sprintf('Original tweet: https://twitter.com/%s/status/%d',
                $favorite['user']['screen_name'],
                $favorite['id']
            );

            if (null !== $url && $this->instapaper->addUrl($url, $source)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns the first URL found in the text, null otherwise.
     *
     * @param  string $text
     * @return string
     */
    private function extractUrl($text)
    {
        preg_match('#([http[s]+:[^ ]+)#', $text, $matches);

        if (isset($matches[0])) {
            return $matches[0];
        }

        return null;
    }
}

<?php

namespace InstaSync;

use InstaSync\Service\Twitter;
use InstaSync\Service\Instapaper;

class Synchronizer
{
    private $twitter;

    private $instapaper;

    public function __construct(Twitter $twitter, Instapaper $instapaper)
    {
        $this->twitter    = $twitter;
        $this->instapaper = $instapaper;
    }

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

    private function extractUrl($url)
    {
        preg_match('#([http[s]+:[^ ]+)#', $url, $matches);

        if (isset($matches[0])) {
            return $matches[0];
        }

        return null;
    }
}

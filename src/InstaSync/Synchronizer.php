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
        if (null !== $favorites = $this->twitter->getFavorites()) {
            foreach ($favorites as $favorite) {
                $url = $this->extractUrl($favorite['text']);

                if (null === $url) {
                    continue;
                }

                if ($this->instapaper->addUrl($url)) {
                    $count++;
                }
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

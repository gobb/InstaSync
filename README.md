InstaSync
=========

InstaSync helps you synchronize your Twitter favorites with your Instapaper
account. You need to create a [Twitter
application](https://dev.twitter.com/apps), and an access token, once you've
created this application.


Usage
-----

InstaSync needs a configuration file written in YAML with the following content:

    twitter:
        consumer_key: XXXX
        consumer_secret: XXXX
        user_token: XXXX
        user_secret: XXXX

    instapaper:
        username: XXXX
        password: XXXX

The default location for this file is: `~/.instasync.yml`.

Start synchronizing your favorites by running the command below:

    php instasync.phar sync [--config-file[="..."]]


Building the PHP Archive (PHAR)
-------------------------------

You can use [Box](http://box-project.org) to build your own PHAR by running the
following command:

    php -d phar.readonly=0 box.phar build


License
-------

InstaSync is released under the MIT License. See the bundled LICENSE file for
details.

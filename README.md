InstaSync
=========

InstaSync helps you synchronize your Twitter Favorites list with your
Instapaper account. You need to create a [Twitter
application](https://dev.twitter.com/apps), and an access token, once you've
created this application. You should configure a CRON task, every five minutes
for instance.


Installation
------------

Download the executable at:
[http://williamdurand.fr/InstaSync/instasync.phar](http://williamdurand.fr/InstaSync/instasync.phar).

You need a PHP environment.


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

Start synchronizing your favorites list by running the command below:

    php instasync.phar sync [--config-file="..."] [--and-delete]

You can specify a configuration file using the `--config-file` option. Also, you
can delete the tweets once they are added to your Instapaper account by using
the `--and-delete` option.


Building the PHP Archive (PHAR)
-------------------------------

You can use [Box](http://box-project.org) to build your own PHAR by running the
following command:

    php -d phar.readonly=0 box.phar build


License
-------

InstaSync is released under the MIT License. See the bundled LICENSE file for
details.

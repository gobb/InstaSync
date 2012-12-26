<?php

namespace InstaSync;

use Guzzle\Http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SyncCommand extends Command
{
    const DEFAULT_CONFIG_FILENAME = '.instasync.yml';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('sync')
            ->setDescription('Synchronize your Twitter Favorites list with your Instapaper account.')
            ->addOption(
                'config-file',
                null,
                InputOption::VALUE_OPTIONAL,
                'The InstaSync YAML configuration file to use.',
                '~/' . self::DEFAULT_CONFIG_FILENAME
            )
            ->addOption(
                'and-delete',
                null,
                InputOption::VALUE_NONE,
                'Delete the tweets once added on Instapaper.'
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('~/' . self::DEFAULT_CONFIG_FILENAME === $configFile = $input->getOption('config-file')) {
            if (defined('PHP_WINDOWS_VERSION_MAJOR')) {
                $configFile = getenv('APPDATA') . '/' . self::DEFAULT_CONFIG_FILENAME;
            } else {
                $configFile = rtrim(getenv('HOME'), '/') . '/' . self::DEFAULT_CONFIG_FILENAME;
            }
        }

        $config = Yaml::parse($configFile);
        $client = new Client();

        $twitter = new Service\Twitter(
            $client,
            $config['twitter']['consumer_key'],
            $config['twitter']['consumer_secret'],
            $config['twitter']['user_token'],
            $config['twitter']['user_secret']
        );

        $instapaper = new Service\Instapaper(
            $client,
            $config['instapaper']['username'],
            $config['instapaper']['password']
        );

        $synchronizer = new Synchronizer($twitter, $instapaper);
        $output->writeln(sprintf(
            'Added <info>%d</info> new URLs.',
            $synchronizer->synchronize($input->getOption('and-delete'))
        ));
    }
}

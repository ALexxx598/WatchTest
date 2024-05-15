<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:list-groups',
    description: 'List all groups with their users.',
)]
class ListGroupCommand extends Command
{
    protected static $defaultName = 'app:list-groups';

    protected function configure()
    {
        $this
            ->setDescription('List all groups with their users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $httpClient = HttpClient::create();

        try {
            $response = $httpClient->request('GET', 'http://127.0.0.1:8080/api/group');

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $groupsData = $response->toArray();
                foreach ($groupsData['data'] as $group) {
                    $output->writeln('Group ID: ' . $group['id']);
                    $output->writeln('Group Name: ' . $group['name']);
                    $output->writeln('Users: ');
                    foreach ($group['users']['data'] as $user) {
                        $output->writeln(' - User ID: ' . $user['id'] . ', Name: ' . $user['name'] . ', Email: ' . $user['email']);
                    }
                    $output->writeln('');
                }
            } else {
                $output->writeln('Failed to retrieve groups. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
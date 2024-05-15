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
    name: 'app:get-user',
    description: 'get user',
    aliases: ['app:get-user'],
    hidden: false
)]
class GetUserCommand extends Command
{
    protected static $defaultName = 'app:get-user';

    protected function configure()
    {
        $this
            ->setDescription('Get user by ID.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter user ID to retrieve: ');
        $userId = $helper->ask($input, $output, $question);

        try {
            $response = $httpClient->request('GET', 'http://127.0.0.1:8080/api/user/'.$userId);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $userData = $response->toArray();
                $output->writeln('User ID: ' . $userData['data']['id']);
                $output->writeln('Name: ' . $userData['data']['name']);
                $output->writeln('Email: ' . $userData['data']['email']);
            } else {
                $output->writeln('Failed to retrieve user. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
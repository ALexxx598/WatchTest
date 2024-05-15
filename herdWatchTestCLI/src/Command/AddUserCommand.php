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
    name: 'app:create-user',
    description: 'Creates a new user.',
    aliases: ['app:add-user'],
    hidden: false
)]
class AddUserCommand extends Command
{
    protected static $defaultName = 'app:add-user';

    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Add a new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter user name: ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Enter user email: ');
        $email = $helper->ask($input, $output, $question);


        try {
            $response = $httpClient->request('POST', 'http://127.0.0.1:8080/api/user/', [
                'json' => [
                    'name' => $name,
                    'email' => $email,
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $output->writeln('User added successfully.');
            } else {
                $output->writeln('Failed to add user. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}

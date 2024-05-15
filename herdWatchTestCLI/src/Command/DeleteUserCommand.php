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
    name: 'app:delete-user',
    description: 'Delete user by ID.',
)]
class DeleteUserCommand extends Command
{
    protected static $defaultName = 'app:delete-user';

    protected function configure()
    {
        $this
            ->setDescription('Delete user by ID.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter user ID to delete: ');
        $userId = $helper->ask($input, $output, $question);

        try {
            $response = $httpClient->request('DELETE', 'http://127.0.0.1:8080/api/user/'.$userId);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $output->writeln('User deleted successfully.');
            } else {
                $output->writeln('Failed to delete user. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}

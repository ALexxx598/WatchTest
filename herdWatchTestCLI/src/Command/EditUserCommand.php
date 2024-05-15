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
    name: 'app:edit-user',
    description: 'edit user',
    aliases: ['app:edit-user'],
    hidden: false
)]
class EditUserCommand extends Command
{
    protected static $defaultName = 'app:edit-user';

    protected function configure()
    {
        $this
            ->setDescription('Edit an existing user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter user ID to edit: ');
        $userId = $helper->ask($input, $output, $question);

        $question = new Question('Enter new name (press Enter to skip): ');
        $name = $helper->ask($input, $output, $question);

        $question = new Question('Enter new email (press Enter to skip): ');
        $email = $helper->ask($input, $output, $question);

        // Build the JSON payload for the request
        $jsonData = [
            'userId' => $userId,
        ];
        if (!empty($name)) {
            $jsonData['name'] = $name;
        }
        if (!empty($email)) {
            $jsonData['email'] = $email;
        }

        try {
            $response = $httpClient->request('PATCH', 'http://127.0.0.1:8080/api/user/'.$userId, [
                'json' => $jsonData,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $output->writeln('User edited successfully.');
            } else {
                $output->writeln('Failed to edit user. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}

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
    name: 'app:add-group',
    description: 'Add a new group.',
)]
class AddGroupCommand extends Command
{
    protected static $defaultName = 'app:add-group';

    protected function configure()
    {
        $this
            ->setDescription('Add a new group.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter group name: ');
        $groupName = $helper->ask($input, $output, $question);

        try {
            $response = $httpClient->request('POST', 'http://127.0.0.1:8080/api/group/', [
                'json' => [
                    'name' => $groupName,
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $output->writeln('Group added successfully.');
            } else {
                $output->writeln('Failed to add group. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
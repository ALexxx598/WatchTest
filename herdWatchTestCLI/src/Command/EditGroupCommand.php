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
    name: 'app:edit-group',
    description: 'Edit an existing group.',
)]
class EditGroupCommand extends Command
{
    protected static $defaultName = 'app:edit-group';

    protected function configure()
    {
        $this
            ->setDescription('Edit an existing group.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $httpClient = HttpClient::create();

        $question = new Question('Enter group ID to edit: ');
        $groupId = $helper->ask($input, $output, $question);

        $question = new Question('Enter new group name (press Enter to skip): ');
        $groupName = $helper->ask($input, $output, $question);

        // Build the JSON payload for the request
        $jsonData = [
            'id' => $groupId
        ];
        if (!empty($groupName)) {
            $jsonData['name'] = $groupName;
        }

        try {
            $response = $httpClient->request('PATCH', 'http://127.0.0.1:8080/api/group/'.$groupId, [
                'json' => $jsonData,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $output->writeln('Group edited successfully.');
            } else {
                $output->writeln('Failed to edit group. Status Code: '.$statusCode);
            }
        } catch (TransportExceptionInterface $exception) {
            $output->writeln('Failed to connect to the server: '.$exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
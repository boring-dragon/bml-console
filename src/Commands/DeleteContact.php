<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DeleteContact
{
    public function handle(BML $bml, OutputInterface $output, InputInterface $input)
    {
        $question = new QuestionHelper();

        $alias = $question->ask($input, $output, (new Question("<question>Whats the Alias name of the account? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Alias cannot be empty');
                }

                return $value;
            }));

        $contacts = $bml->GetContacts();
        $contact_key = array_search($alias, array_column($contacts, 'alias'));
        $bml->DeleteContact($contacts[$contact_key]['id']);

        $output->writeln('<info>Contact deleted successfully! </info>');
    }
}

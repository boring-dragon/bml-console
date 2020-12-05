<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Jinas\BMLConsole\Helpers\Arr;

class DeleteContact
{
    use Arr;

    public function handle(BML $bml, OutputInterface $output, InputInterface $input)
    {
        $question = new QuestionHelper();

        $contacts = $bml->GetContacts();

        $alias = $question->ask($input, $output, (new Question("<question>Whats the Alias name of the account? </question> \n"))
            ->setAutocompleterValues($this->array_pluck($contacts, 'alias'))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Alias cannot be empty');
                }

                return $value;
            }));

        $contact_key = array_search($alias, array_column($contacts, 'alias'));

        if (!array_key_exists($contact_key, $contacts)) {
            $output->writeln("<error> Contact doesn't exist! </error>");
            return 0;
        }

        $bml->DeleteContact($contacts[$contact_key]['id']);

        $output->writeln('<info>Contact deleted successfully! </info>');
    }
}

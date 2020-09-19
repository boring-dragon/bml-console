<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class AddContact
{
    public function handle(BML $bml, OutputInterface $output, InputInterface $input)
    {
        $question = new QuestionHelper;

        $account_number = $question->ask($input, $output, (new Question("<question>Whats the Account number? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Account number cannot be empty');
                }

                return $value;
            }));
        $alias = $question->ask($input, $output, (new Question("<question>Whats the alias you want to save this number to? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Alias cannot be empty');
                }

                return $value;
            }));

        $bml->AddContact($account_number, $alias);

        $output->writeln("<info>Contact successfully created! </info>");
    }
}

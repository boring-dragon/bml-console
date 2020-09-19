<?php

namespace Jinas\BMLConsole\Commands;

use Carbon\Carbon;
use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class TransactionsBetween
{
    public function handle(BML $bml, OutputInterface $output, InputInterface $input)
    {
        $question = new QuestionHelper();

        $from = $question->ask($input, $output, (new Question("<question>Transactions From? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Transaction From Date cannot be empty');
                }

                return $value;
            }));
        $to = $question->ask($input, $output, (new Question("<question>Transactions To? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Transaction To Date cannot be empty');
                }

                return $value;
            }));

        $table = new Table($output);
        $table->setHeaderTitle("Transactions Between $from - $to");
        $table->setHeaders(['Id', 'Name', 'Description', 'Reference',  'Amount', 'Balance', 'Date']);

        foreach ($bml->GetTransactionsBetween($from, $to) as $transaction) {
            $rows[] = [
                $transaction['id'],
                $transaction['narrative2'],
                $transaction['description'],
                $transaction['reference'],
                $transaction['amount'].' '.$bml->currency,
                $transaction['balance'].' '.$bml->currency,
                Carbon::parse($transaction['bookingDate'])->format('d-m-Y H:i:s'),
            ];
        }

        $table->setRows($rows);
        $table->render();
    }
}

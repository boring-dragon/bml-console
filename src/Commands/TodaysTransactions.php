<?php

namespace Jinas\BMLConsole\Commands;

use Carbon\Carbon;
use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class TodaysTransactions
{
    public function handle(BML $bml, OutputInterface $output)
    {
        $output->writeln('<info>Please note that the transactions date will set according to the next working day.</info>');

        $table = new Table($output);
        $table->setHeaderTitle('Todays Transactions');
        $table->setHeaders(['Id', 'Narrative', 'Description', 'Transaction Settlement', 'Amount', 'Balance', 'Created At']);

        foreach ($bml->GetTodayTransactions() as $transaction) {
            $rows[] = [
                $transaction['id'],
                $transaction['narrative3'],
                $transaction['description'],
                Carbon::parse($transaction['bookingDate'])->diffForHumans(),
                $transaction['amount'].' '.$bml->currency,
                $transaction['balance'].' '.$bml->currency,
                $transaction['narrative2'],
            ];
        }

        $table->setRows($rows);
        $table->render();
    }
}

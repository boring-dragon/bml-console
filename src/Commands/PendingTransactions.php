<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class PendingTransactions
{
    public function handle(BML $bml, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaderTitle('Pending Transactions');
        $table->setHeaders(['Date', 'Description', 'Reference', 'Amount']);

        foreach ($bml->GetPendingTransactions() as $transaction) {
            $rows[] = [
                $transaction['FromDate'],
                $transaction['Description'],
                $transaction['LockedID'],
                $transaction['LockedAmount'],
            ];
        }

        $table->setRows($rows);
        $table->render();
    }
}

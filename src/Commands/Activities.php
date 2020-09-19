<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class Activities
{
    public function handle(BML $bml, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Type', 'Date', 'Contact', 'Amount', 'Remarks', 'Status']);

        foreach ($bml->GetActivities() as $activities) {
            $rows[] = [
                $activities['type'], $activities['datetime'], $activities['creditName'], $activities['formattedAmount'], $activities['message'],
                ($activities['status'] == 'Failed') ? '<fire>Failed</fire>' : '<info>'.$activities['status'].'</info>',
            ];
        }

        $table->setRows($rows);
        $table->render();
    }
}

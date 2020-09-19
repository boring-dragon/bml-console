<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Output\OutputInterface;

class Total
{
    public function handle(BML $bml, OutputInterface $output)
    {
        $output->writeln([
            '<info>',
            'Account Total: '.$bml->availableBalance.'MVR',
            '</info>',
        ]);
    }
}

<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class Contacts
{
    public function handle(BML $bml, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Name', 'Account', 'Alias']);

        foreach ($bml->GetContacts() as $contact) {
            $rows[] = [$contact['name'], $contact['account'], $contact['alias']];
        }

        $table->setRows($rows);
        $table->render();
    }
}

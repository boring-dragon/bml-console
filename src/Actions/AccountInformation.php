<?php

namespace Jinas\BMLConsole\Actions;

use Symfony\Component\Console\Output\OutputInterface;

class AccountInformation
{
    public function handle(OutputInterface $output, $bml)
    {
        $output->writeln([
            "Customer Number:  $bml->customerNumber",
            "Full Name: \t $bml->fullName",
            "ID Card: \t $bml->idCard",
            "Email: \t \t $bml->email",
            "Gender: \t $bml->gender",
            "Phone: \t \t $bml->mobileNumber",
            "Birthdate \t $bml->birthdate",
            "Account Name:  \t  $bml->alias",
            "Account Number: $bml->account",
            "Product: \t $bml->product",
            "Branch: \t $bml->branch",
            "Cleared Balance: <info> $bml->clearedBalance MVR</info>",
            "Account Total: \t <info> $bml->availableBalance  MVR</info>",
            ""
        ]);
    }
}

<?php

namespace Jinas\BMLConsole\Commands;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Transfer
{
    public function handle(BML $bml, OutputInterface $output, InputInterface $input)
    {
        $question = new QuestionHelper();

        $account = $question->ask($input, $output, (new Question("<question>What is the account number?</question> \n"))
            ->setValidator(function ($value) use ($bml) {
                if (trim($value) == '') {
                    throw new \Exception('Account number cannot be empty');
                }

                if (is_null($bml->isValidAccountNumber($value))) {
                    throw new \Exception('Invalid Account number');
                }

                return $value;
            }));

        $amount = $question->ask($input, $output, (new Question("<question>What is the amount you want to transfer?</question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Amount cannot be empty!');
                }

                if (!is_numeric($value)) {
                    throw new \Exception('Amount should be an integer!');
                }

                return $value;
            }));

        $bml->transfer([
            'transfertype'  => 'IAT',
            'channel'       => 'mobile',
            'debitAmount'   => $amount,
            'currency'      => 'MVR',
            'creditAccount' => $account,
            'debitAccount'  => $bml->guid,
        ]);

        $otp = $question->ask($input, $output, (new Question("<question>What is the Verification Code?</question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Verification Code cannot be empty!');
                }

                if (!is_numeric($value)) {
                    throw new \Exception('Verification Code should be an integer!');
                }

                return $value;
            }));

        $invoice = $bml->transfer([
            'transfertype'  => 'IAT',
            'channel'       => 'mobile',
            'debitAmount'   => $amount,
            'currency'      => 'MVR',
            'creditAccount' => $account,
            'debitAccount'  => $bml->guid,
            'otp'           => $otp,
        ]);

        if (!$invoice['success']) {
            throw new \Exception('whoops!. something went wrong. Transaction cannot be completed');
        }

        $table = new Table($output);
        $table->setHeaderTitle('Invoice');
        $table->setHeaders(['Status', 'Message', 'Ref #', 'Date',  'From', 'To', 'Ammount', 'Remarks']);

        $row[] = [
            'SUCCESS',
            'Transfer transaction is successful',
            $invoice['payload']['reference'],
            $invoice['payload']['timestamp'],
            $invoice['payload']['from']['name'],
            $invoice['payload']['to']['account'],
            $invoice['payload']['debitamount'],
            '',
        ];

        $table->setRows($row);
        $table->render();
    }
}

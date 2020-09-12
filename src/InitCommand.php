<?php

namespace Jinas\BMlConsole;

use Jinas\BMLConsole\Helpers\BML;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Jinas\BMLConsole\Helpers\Styles;
use Jinas\BMLConsole\Actions\AccountInformation;

class InitCommand extends Command
{
    use Styles;

    protected $bml;
    protected $exit = false;

    protected $commands = [
        "/total" => \Jinas\BMLConsole\Commands\Total::class,
        "/contacts" => \Jinas\BMLConsole\Commands\Contacts::class,
        "/todays-transactions" => \Jinas\BMLConsole\Commands\TodaysTransactions::class,
        "/pending-transactions" => \Jinas\BMLConsole\Commands\PendingTransactions::class,
        "/transactions-between" => \Jinas\BMLConsole\Commands\TransactionsBetween::class,
        "/activities" => \Jinas\BMLConsole\Commands\Activities::class
    ];

    public function __construct(Bml $bml)
    {
        parent::__construct();

        $this->bml = $bml;
    }

    protected function configure()
    {
        $this->setName("init")
            ->setDescription("Runs the BMl Console");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->LoadColors($output);
        $this->authenticate($input, $output);
        $this->bml->GetDashboardInfo()
            ->GetUserInfo();

        $output->writeln($this->GetAsciiLogo());
        $output->writeln($this->meta()["description"]);
        $output->writeln($this->meta()["accountdetail"]);

        (new AccountInformation())->handle($output, $this->bml);

        $helper = $this->getHelper('question');

        while ($this->exit = true) {
            $action = $helper->ask($input, $output, (new Question("<question>Select Your Action: </question> \n"))
                ->setAutocompleterValues(
                    array_merge(array_keys($this->commands), ["/exit"])
                ));

            if (array_key_exists($action, $this->commands)) {
                (new $this->commands[$action])->handle($this->bml, $output, $input);
            } elseif ($action == "/exit") {
                exit(0);
            } else {
                $output->writeln("<fire>Invalid Choice.</fire>");
            }
        }
    }

    protected function authenticate(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $username = $helper->ask($input, $output, (new Question("<question>Whats Your username? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Username Cannot be empty');
                }

                return $value;
            }));
        $password = $helper->ask($input, $output, (new Question("<question>What is Your Password? </question> \n"))
            ->setValidator(function ($value) {
                if (trim($value) == '') {
                    throw new \Exception('Password Cannot be empty');
                }

                return $value;
            })
            ->setHidden(true)
            ->setHiddenFallback(false));

        $authentication = $this->bml->login($username, $password);

        if (!$authentication["authenticated"]) {
            $output->writeln("<error>Your Username Or Password is Incorrect.</error>");
            exit(0);
        }
    }
}

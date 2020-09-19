<?php

namespace Jinas\BMLConsole\Helpers;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

trait Styles
{
    public function LoadColors(OutputInterface $output)
    {
        foreach ($this->CustomColors() as $name => $color) {
            $output->getFormatter()->setStyle($name, $color);
        }
    }

    public function meta()
    {
        return [
            'title'         => 'BML Console',
            'version'       => '0.1',
            'description'   => "<epic>BML Console for nerds. Thats it :). Note that this is an experimental project.</epic> \n",
            'accountdetail' => [
                '<bruh>======================================================',
                'Account Details',
                '======================================================</bruh>',
            ],
        ];
    }

    public function GetAsciiLogo()
    {
        return "
        <fire>
        $$$$$$$\  $$\      $$\ $$\              $$$$$$\                                         $$\           
        $$  __$$\ $$$\    $$$ |$$ |            $$  __$$\                                        $$ |          
        $$ |  $$ |$$$$\  $$$$ |$$ |            $$ /  \__|$$$$$$\  $$$$$$$\   $$$$$$$\  $$$$$$\  $$ | $$$$$$\  
        $$$$$$$\ |$$\$$\$$ $$ |$$ |            $$ |     $$  __$$\ $$  __$$\ $$  _____|$$  __$$\ $$ |$$  __$$\ 
        $$  __$$\ $$ \$$$  $$ |$$ |            $$ |     $$ /  $$ |$$ |  $$ |\$$$$$$\  $$ /  $$ |$$ |$$$$$$$$ |
        $$ |  $$ |$$ |\$  /$$ |$$ |            $$ |  $$\$$ |  $$ |$$ |  $$ | \____$$\ $$ |  $$ |$$ |$$   ____|
        $$$$$$$  |$$ | \_/ $$ |$$$$$$$$\       \$$$$$$  \$$$$$$  |$$ |  $$ |$$$$$$$  |\$$$$$$  |$$ |\$$$$$$$\ 
        \_______/ \__|     \__|\________|       \______/ \______/ \__|  \__|\_______/  \______/ \__| \_______|
        </fire>
        ";
    }

    protected function CustomColors()
    {
        return [
            'fire' => new OutputFormatterStyle('red', 'black', ['bold', 'blink']),
            'epic' => new OutputFormatterStyle('magenta', 'black'),
            'bruh' => new OutputFormatterStyle('cyan', 'black'),
        ];
    }
}

<?php

namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Icube\AutoCategory\Helper\AutoCategory;

class AutoNew extends Command
{
    /**
     * @var AutoCategory
     */
    protected $autoCategoryHelper;

    public function __construct(
        AutoCategory $autoCategoryHelper
    ) {
        parent::__construct();
        $this->autoCategoryHelper = $autoCategoryHelper;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('autocategory:go');
        $this->setDescription('Command for Auto Category');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Auto Category Command Run");
        $from = "command";
        $result = $this->autoCategoryHelper->autoCategoryCommand($from);
        $output->writeln($result['status']);
        if ($result['count'] != 0) {
            $output->writeln($result['count'] . " product autocategory.");
        }
    }
}

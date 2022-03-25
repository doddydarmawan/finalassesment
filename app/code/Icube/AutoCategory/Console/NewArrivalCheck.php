<?php

namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Command\AutoCategory;

class NewArrivalCheck extends Command
{

    /**
     * @var AutoCategory
     */
    protected $autoCategoryHelper;

    /**
     * @inheritDoc
     */
    public function __construct(
        AutoCategory $autoCategoryHelper
    ) {
        parent::__construct();
        $this->autoCategoryHelper = $autoCategoryHelper;
    }

    protected function configure()
    {
        $this->setName('new:arrival:check');
        $this->setDescription('Check new arrival command');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Command running successfully!");
        $executeCommand = $this->autoCategoryHelper->executeAutoCategoryCommand('COMMAND');
        return $executeCommand;
    }
}

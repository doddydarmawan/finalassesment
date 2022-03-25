<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Icube\AutoCategory\Helper\Config;
use Icube\AutoCategory\Model\CategoryManagement;

class AutoCategory extends Command
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var CategoryManagement
     */
    private $categoryManagement;

    /**
     * Sayhello constructor
     *
     */
    public function __construct(
        Config $config,
        CategoryManagement $categoryManagement
    ) {
        $this->config = $config;
        $this->categoryManagement = $categoryManagement;
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('autocategory:run');
        $this->setDescription('Auto Category command line');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Processing assign category ...</info>');
        
        if ($this->config->IsEnable()) {
            $output->writeln('Can\'t run this command, please turn off (disable) autocategory in admin panel');
        } else {
            $this->categoryManagement->assignCategoryInAllProductByRangeAndExclude();
        }

        $output->writeln('<info>Finish</info>');
    }
}

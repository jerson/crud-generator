<?php

namespace CrudGenerator\Command;

use CrudGenerator\Plugins\MySQL;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class CrudCommand extends Command
{

    /**
     * @var \PDO
     */
    private $pdo;

    private $container;

    /**
     * @var Container
     */
    protected function configure()
    {
        $this
            ->setName('generator:crud')
            ->setDescription('generador de crud');
    }

    public function setContainer(Container $container){
        $this->container = $container;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->pdo = $this->container->get('pdo');
        $mysql = new MySQL($this->pdo);
        $result = $mysql->getTables();

        $output->writeln($result);


    }
}
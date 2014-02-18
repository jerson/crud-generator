<?php

namespace CrudGenerator\Command;

use CrudGenerator\Connector\MySQL;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CrudCommand extends Command
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var ContainerInterface
     */
    private $container;

    protected function configure()
    {
        $this
            ->setName('generator:crud')
            ->setDescription('generador de crud');
    }

    public function setContainer(ContainerInterface $container){
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
        $tables = $mysql->getTables();


        foreach ($tables as $table) {
            $tableProperties = $mysql->getTable($table);

           // print_r($tableProperties);
        }


        $output->writeln($tables);


    }
}
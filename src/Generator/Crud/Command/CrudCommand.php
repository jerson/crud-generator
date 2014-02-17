<?php

namespace Generator\Crud\Command;

use Generator\Crud\Plugins\MySQL;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;



class CrudCommand extends Command
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('generator:crud')
            ->setDescription('generador de crud');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$container = new ContainerBuilder();
//        $this->pdo = $container->get('ccccc');
//        $mysql = new MySQL($this->pdo);
//        $result = $mysql->getTables();
//
//        $output->writeln($result);


    }
}
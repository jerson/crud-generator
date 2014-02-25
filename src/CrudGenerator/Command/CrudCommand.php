<?php

namespace CrudGenerator\Command;

use CrudGenerator\Generator;
use Stringy\Stringy;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;


class CrudCommand extends Command
{

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var ContainerInterface
     */
    private $container;

    protected function configure()
    {
        $this
            ->setName('generator')
            ->setDescription('generador de código')
            ->addArgument(
                'layout',
                InputArgument::OPTIONAL,
                'Plantilla a usar para el generador o el nombre del paquete',
                'JSPSimple'
            )->addOption(
                'config',
                null,
                InputOption::VALUE_OPTIONAL,
                'Archivo de configuración'
            )->addOption(
                'type',
                null,
                InputOption::VALUE_OPTIONAL,
                'Eliges lo que vas a generar package|model|database|view|controller',
                'package'
            );
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $configFile = $input->getOption('config');
        $type = $input->getOption('type');
        $layout = $input->getArgument('layout');
        $configFile = empty($configFile) ? 'config.yml' : $configFile;
        $type = empty($type) ? 'all' : $type;
        $config = array();
        if (!empty($configFile)) {

            if (file_exists($configFile)) {
                $yaml = new Parser();
                $config = $yaml->parse(file_get_contents($configFile));

            } else {
                $output->writeln(sprintf('<error>El Archivo de configuración "%s" no existe</error>', $configFile));
                return;
            }
        }

        $output->writeln('<comment>Iniciando Generador</comment>');
        $this->generator = new Generator($config);

        if ($type == 'package') {

            $packages = $this->container->getParameter('packages');

            if (isset($packages[$layout])) {
                $output->writeln(sprintf('<info>Generando Paquete "%s"</info>', $layout));

                $package = $packages[$layout];

                foreach ($package as $bundleType => $bundleLayout) {

                    $bundleLayout = empty($bundleLayout) ? 'base' : $bundleLayout;
                    $bundleType = Stringy::create($bundleType)->upperCamelize();

                    $output->writeln(sprintf('<info>- %s (%s)</info>', $bundleType, $bundleLayout));
                    $this->generator->generate($bundleType, $bundleLayout);
                }


            } else {

                $output->writeln(sprintf('<error>El Paquete "%s" no existe</error>', $layout));
            }

        } else {

            if ($type == 'database') {
                $output->writeln('<info>Generando Scripts de Base de Datos</info>');
                $this->generator->generateDatabase($layout);
            }
            if ($type == 'model') {
                $output->writeln('<info>Generando Modelos</info>');
                $this->generator->generateModel($layout);
            }
            if ($type == 'controller') {
                $output->writeln('<info>Generando Controladores</info>');
                $this->generator->generateController($layout);
            }
            if ($type == 'view') {
                $output->writeln('<info>Generando Interfaces</info>');
                $this->generator->generateView($layout);
            }

        }


    }
}
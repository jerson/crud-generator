<?php


namespace CrudGenerator\Bundle;

use CrudGenerator\Table\Table;
use Gaufrette\Filesystem;

interface BundleInterface
{


    /**
     * @param Filesystem $fileSystem
     * @param \Twig_Environment $twig
     * @param array $options
     */
    public function __construct(Filesystem $fileSystem, \Twig_Environment $twig, array $options);

    /**
     * @return void
     */
    public function configure();

    /**
     * @param Table[] $tables
     * @return void
     */
    public function setTables(array $tables);

    /**
     * @return void
     */
    public function generate();
}

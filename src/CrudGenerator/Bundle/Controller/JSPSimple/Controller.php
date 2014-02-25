<?php


namespace CrudGenerator\Bundle\Controller\JSPSimple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Controller extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'src/Servlet';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();

            $action = 'Registrar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileName, $action, $fileName);
            $fileContent = $this->twig->render('servletCreate.java.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Modificar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileName, $action, $fileName);
            $fileContent = $this->twig->render('servletUpdate.java.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);


            $action = 'Eliminar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileName, $action, $fileName);
            $fileContent = $this->twig->render('servletDelete.java.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

        }

    }
}
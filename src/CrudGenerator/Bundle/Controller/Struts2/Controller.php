<?php


namespace CrudGenerator\Bundle\Controller\Struts2;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Controller extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'src/main/Controller';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();

            $action = 'Registrar';
            $filePath = sprintf('%s/%s/%sAction.java', $baseDir, $fileName, $action);
            $fileContent = $this->twig->render(
                'actionCreate.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Modificar';
            $filePath = sprintf('%s/%s/%sAction.java', $baseDir, $fileName, $action);
            $fileContent = $this->twig->render(
                'actionUpdate.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);


            $action = 'Eliminar';
            $filePath = sprintf('%s/%s/%sAction.java', $baseDir, $fileName, $action);
            $fileContent = $this->twig->render(
                'actionDelete.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);

        }


        $baseDir = 'src/resources';
        $filePath = sprintf('%s/struts.xml', $baseDir);
        $fileContent = $this->twig->render(
            'struts.xml.twig',
            array('tables' => $this->tables)
        );
        $this->fileSystem->write($filePath, $fileContent, true);


        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->dasherize();


            $filePath = sprintf('%s/%s/struts.xml', $baseDir, $fileName);
            $fileContent = $this->twig->render(
                'strutsPackage.xml.twig',
                array('table' => $table)
            );
            $this->fileSystem->write($filePath, $fileContent, true);

        }

    }
}

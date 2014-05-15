<?php


namespace CrudGenerator\Bundle\Controller\Struts2Simple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Controller extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'src/main/java/com/app/controller';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->camelize();

            $action = 'Listar';
            $filePath = sprintf('%s/%s/%sAction.java', $baseDir, $fileName, $action);
            $fileContent = $this->twig->render(
                'actionList.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);


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

        $baseDir = 'src/main/webapp/META-INF';
        $filePath = sprintf('%s/context.xml', $baseDir);
        $fileContent = $this->twig->render('context.xml.twig');
        $this->fileSystem->write($filePath, $fileContent, true);

        $baseDir = 'src/main/webapp/WEB-INF';
        $filePath = sprintf('%s/web.xml', $baseDir);
        $fileContent = $this->twig->render('web.xml.twig');
        $this->fileSystem->write($filePath, $fileContent, true);

        $baseDir = 'src/main/resources';
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

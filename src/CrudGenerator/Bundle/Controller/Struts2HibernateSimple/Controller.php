<?php


namespace CrudGenerator\Bundle\Controller\Struts2HibernateSimple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Controller extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'src/com/app/controller';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $fileNamePackage = Stringy::create($table->getName())->camelize();

            $action = 'Registrar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileNamePackage, $action, $fileName);
            $fileContent = $this->twig->render(
                'servletCreate.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Modificar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileNamePackage, $action, $fileName);
            $fileContent = $this->twig->render(
                'servletUpdate.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);


            $action = 'Eliminar';
            $filePath = sprintf('%s/%s/%s%s.java', $baseDir, $fileNamePackage, $action, $fileName);
            $fileContent = $this->twig->render(
                'servletDelete.java.twig',
                array('table' => $table, 'action' => $action)
            );
            $this->fileSystem->write($filePath, $fileContent, true);

        }

    }
}

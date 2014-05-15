<?php


namespace CrudGenerator\Bundle\Model\Struts2Simple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Model extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {


        $baseDir = 'src/main/Model';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%s.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('class.java.twig', array('table' => $table));
            $this->fileSystem->write($filePath, $fileContent, true);

        }

        $baseDir = 'src/main/Dao';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%sDao.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('dao.java.twig', array('table' => $table));
            $this->fileSystem->write($filePath, $fileContent, true);

        }


        $fileContent = $this->twig->render('conexion.java.twig');
        $filePath = sprintf('%s/Conexion/Conexion.java', $baseDir);
        $this->fileSystem->write($filePath, $fileContent, true);
    }
}

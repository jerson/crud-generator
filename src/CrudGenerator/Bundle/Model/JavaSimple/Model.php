<?php


namespace CrudGenerator\Bundle\Model\JavaSimple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Model extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {


        $baseDir = 'src/Model';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%s.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('class.java.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }

        $baseDir = 'src/Dao';

        foreach ($this->tables as $table) {
            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%sDao.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('dao.java.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }


        $fileContent = $this->twig->render('conexion.java.twig');
        $filePath = sprintf('%s/Conexion/Conexion.java', $baseDir);
        $this->fileSystem->write($filePath, $fileContent, true);
    }
}

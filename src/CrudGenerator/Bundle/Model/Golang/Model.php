<?php


namespace CrudGenerator\Bundle\Model\Golang;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Model extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

//        $srcDir = 'src/github.com/account';
        $baseDir = 'models';

//        $this->fileSystem->createFile()
//        $this->fileSystem->delete($baseDir);

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->underscored();
            $filePath = sprintf('%s/%s.go', $baseDir, $fileName);

            $fileContent = $this->twig->render('model.go.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }

//        $baseDir = 'src/Dao';
//
//        foreach ($this->tables as $table) {
//            $fileName = Stringy::create($table->getName())->upperCamelize();
//            $filePath = sprintf('%s/%sDao.java', $baseDir, $fileName);
//
//            $fileContent = $this->twig->render('dao.java.twig', ['table' => $table]);
//            $this->fileSystem->write($filePath, $fileContent, true);
//
//        }
//
//
//        $fileContent = $this->twig->render('conexion.java.twig');
//        $filePath = sprintf('%s/Conexion/Conexion.java', $baseDir);
//        $this->fileSystem->write($filePath, $fileContent, true);
    }
}

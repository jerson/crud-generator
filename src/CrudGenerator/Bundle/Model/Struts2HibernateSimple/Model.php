<?php


namespace CrudGenerator\Bundle\Model\Struts2HibernateSimple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Model extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

// esto lo genera hibernate
//        $baseDir = 'src/com/app/model';
//
//        foreach ($this->tables as $table) {
//
//            $fileName = Stringy::create($table->getName())->upperCamelize();
//            $filePath = sprintf('%s/%s.java', $baseDir, $fileName);
//
//            $fileContent = $this->twig->render('class.java.twig', array('table' => $table));
//            $this->fileSystem->write($filePath, $fileContent, true);
//
//        }

        $baseDir = 'src/com/app/dao';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%sDao.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('dao.java.twig', array('table' => $table));
            $this->fileSystem->write($filePath, $fileContent, true);

        }

        $baseDir = 'src/com/app/util';
        $fileContent = $this->twig->render('hibernateUtil.java.twig');
        $filePath = sprintf('%s/HibernateUtil.java', $baseDir);
        $this->fileSystem->write($filePath, $fileContent, true);

    }
}

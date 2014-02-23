<?php


namespace CrudGenerator\Bundle\Model\Base;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Model extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'Model';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->upperCamelize();
            $filePath = sprintf('%s/%s.java', $baseDir, $fileName);

            $fileContent = $this->twig->render('class.java.twig', array('table' => $table));
            $this->fileSystem->write($filePath, $fileContent, true);

        }
    }
}
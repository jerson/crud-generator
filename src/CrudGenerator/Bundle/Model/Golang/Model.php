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

        $baseDir = 'models';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->underscored();
            $filePath = sprintf('%s/%s.go', $baseDir, $fileName);

            $fileContent = $this->twig->render('model.go.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }

        $baseDir = 'repositories';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->underscored();
            $filePath = sprintf('%s/%s_repository.go', $baseDir, $fileName);

            $fileContent = $this->twig->render('repository.go.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }

    }
}

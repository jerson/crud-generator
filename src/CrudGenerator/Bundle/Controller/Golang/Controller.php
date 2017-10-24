<?php


namespace CrudGenerator\Bundle\Controller\Golang;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class Controller extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {

        $baseDir = 'controllers';

        foreach ($this->tables as $table) {
            $fileName = Stringy::create($table->getName())->underscored();
            $filePath = sprintf('%s/%s.go', $baseDir, $fileName);

            $fileContent = $this->twig->render('controller.go.twig', ['table' => $table]);
            $this->fileSystem->write($filePath, $fileContent, true);

        }

        $filePath = 'main.go';
        $fileContent = $this->twig->render('main.go.twig', ['tables' => $this->tables]);
        $this->fileSystem->write($filePath, $fileContent, true);

    }
}

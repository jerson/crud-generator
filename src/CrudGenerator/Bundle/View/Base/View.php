<?php


namespace CrudGenerator\Bundle\View\Base;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;

class View extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {


        $baseDir = 'web';

        $fileContent = $this->twig->render('index.jsp.twig');
        $filePath = sprintf('%s/index.jsp', $baseDir);
        $this->fileSystem->write($filePath, $fileContent, true);
    }
}
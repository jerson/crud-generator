<?php


namespace CrudGenerator\Bundle\View\JSPSimple;


use CrudGenerator\Bundle\Base;
use Stringy\Stringy;
use Symfony\Component\Filesystem\Filesystem;

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

        $symfonyFileSystem = new Filesystem();
        $symfonyFileSystem->copy(__DIR__ . '/Resource/css/bootstrap.min.css', $this->config['output']['dir'] . '/web/css/bootstrap.min.css', true);
        $symfonyFileSystem->copy(__DIR__ . '/Resource/css/navbar.css', $this->config['output']['dir'] . '/web/css/navbar.css', true);
        $symfonyFileSystem->copy(__DIR__ . '/Resource/js/bootstrap.min.js', $this->config['output']['dir'] . '/web/js/bootstrap.min.js', true);
        $symfonyFileSystem->copy(__DIR__ . '/Resource/js/jquery.min.js', $this->config['output']['dir'] . '/web/js/jquery.min.js', true);
        $symfonyFileSystem->copy(__DIR__ . '/Resource/js/jquery.h5validate.min.js', $this->config['output']['dir'] . '/web/js/jquery.h5validate.min.js', true);

        $baseDir = 'web/forms';

        foreach ($this->tables as $table) {

            $fileName = Stringy::create($table->getName())->dasherize();

            $action = 'Registrar';
            $filePath = sprintf('%s/%s/%s.jsp', $baseDir, $fileName, Stringy::create($action)->dasherize());
            $fileContent = $this->twig->render('formCreate.jsp.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Listar';
            $filePath = sprintf('%s/%s/%s.jsp', $baseDir, $fileName, Stringy::create($action)->dasherize());
            $fileContent = $this->twig->render('list.jsp.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Buscar';
            $filePath = sprintf('%s/%s/%s.jsp', $baseDir, $fileName, Stringy::create($action)->dasherize());
            $fileContent = $this->twig->render('search.jsp.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

            $action = 'Modificar';
            $filePath = sprintf('%s/%s/%s.jsp', $baseDir, $fileName, Stringy::create($action)->dasherize());
            $fileContent = $this->twig->render('formUpdate.jsp.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);


            $action = 'Eliminar';
            $filePath = sprintf('%s/%s/%s.jsp', $baseDir, $fileName, Stringy::create($action)->dasherize());
            $fileContent = $this->twig->render('formDelete.jsp.twig', array('table' => $table, 'action' => $action));
            $this->fileSystem->write($filePath, $fileContent, true);

            $this->twig->clearTemplateCache();
            $this->twig->clearCacheFiles();

        }
    }
}
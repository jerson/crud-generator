<?php


namespace CrudGenerator\Bundle\Assets\Golang;


use CrudGenerator\Bundle\Base;

class Assets extends Base
{


    /**
     * @inheritdoc
     */
    public function generate()
    {
        $this->copyAssets(__DIR__ . '/Template');
    }
}

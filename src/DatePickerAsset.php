<?php
/**
 * DataPickerAsset.php
 * @author: silentlun
 * @date  2021年3月24日下午4:30:29
 * @copyright  Copyright igkcms
 */
namespace silentlun\datepicker;

use Yii;
use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    use BootstrapTrait;
    public $sourcePath = __DIR__ . '/assets';
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $bsCss = 'bootstrap-datetimepicker' . ($this->isBs4() ? '4' : '3');
        $this->setupAssets('css', ['css/' . $bsCss]);
        $this->setupAssets('js', ['js/bootstrap-datetimepicker']);
        parent::init();
    }
    
    /**
     * Set up CSS and JS asset arrays based on the base-file names
     *
     * @param string $type whether 'css' or 'js'
     * @param array $files the list of 'css' or 'js' basefile names
     */
    protected function setupAssets($type, $files = [])
    {
        $srcFiles = [];
        $minFiles = [];
        foreach ($files as $file) {
            $srcFiles[] = "{$file}.{$type}";
            $minFiles[] = "{$file}.min.{$type}";
        }
        $this->$type = YII_DEBUG ? $srcFiles : $minFiles;
    }
}
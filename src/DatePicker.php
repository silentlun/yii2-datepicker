<?php
/**
 * DatePicker renders a DatePicker input.
 * @author: silentlun
 * @date  2021年3月24日下午4:32:20
 * @copyright  Copyright igkcms
 */
namespace silentlun\datepicker;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\helpers\ArrayHelper;

class DatePicker extends InputWidget
{
    use BootstrapTrait;
    /**
     * @var array the options for the Bootstrap DatePicker plugin.
     * Please refer to the Bootstrap DatePicker plugin Web page for possible options.
     * @see http://bootstrap-datepicker.readthedocs.org/en/release/options.html
     */
    public $pluginOptions = [];
    /**
     * @var array the event handlers for the underlying Bootstrap DatePicker plugin.
     * Please refer to the [DatePicker](http://bootstrap-datepicker.readthedocs.org/en/release/events.html) plugin
     * Web page for possible events.
     */
    public $clientEvents = [];
    /**
     * @var string the size of the input ('lg', 'md', 'sm', 'xs')
     */
    public $size;
    /**
     * @var array HTML attributes to render on the container
     */
    public $containerOptions = [];
    /**
     * @var string the addon markup if you wish to display the input as a component. If you don't wish to render as a
     * component then set it to null or false.
     */
    public $addon = '<i class="fa fa-calendar"></i>';
    
    /**
     * @var string the use BS4.
     */
    public $addonType = 'right';
    /**
     * @var string the template to render the input.
     */
    public $template = '{input}{addon}';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->size) {
            Html::addCssClass($this->options, 'input-' . $this->size);
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
        }
        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->options, 'kv-datetime-picker');
        Html::addCssClass($this->containerOptions, 'input-group date');
        $this->registerClientScript();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        
        $input = $this->hasModel()
        ? Html::activeTextInput($this->model, $this->attribute, $this->options)
        : Html::textInput($this->name, $this->value, $this->options);
        
        if ($this->addon) {
            if ($this->isBs4()) {
                $addonText = Html::tag('span', $this->addon, ['class' => 'input-group-text']);
                $addon = Html::tag('div', $addonText, ['class' => $this->addonType == 'left' ? 'input-group-prepend' : 'input-group-append']);
            } else {
                $addon = Html::tag('span', $this->addon, ['class' => 'input-group-addon']);
            }
            $input = strtr($this->template, ['{input}' => $input, '{addon}' => $addon]);
            $input = Html::tag('div', $input, $this->containerOptions);
        }
        echo $input;
    }
    
    /**
     * Registers required script for the plugin to work as DatePicker
     */
    public function registerClientScript()
    {
        $js = [];
        $view = $this->getView();
        DatePickerAsset::register($view);
        
        $id = $this->options['id'];
        $selector = ";jQuery('#$id')";
        
        if ($this->addon) {
            $selector .= ".parent()";
        }
        
        $this->pluginOptions = ArrayHelper::merge([
            'format' => 'yyyy-mm-dd hh:ii',
            'autoclose' => true,
            'todayBtn' => true,
            'todayHighlight' => true,
            'fontAwesome' => true,
        ], $this->pluginOptions);
        $options = Json::encode($this->pluginOptions);
        
        
        $js[] = "$selector.datetimepicker($options);";
        
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$selector.on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
    }
}
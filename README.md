silentlun\yii2-datepicker
=========================
Datepicker extension for YII2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist silentlun/yii2-datepicker "*"
```

or add

```
"silentlun/yii2-datepicker": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

与表格一起使用的示例
有两种使用方式，一种是使用ActiveForm实例，另一种是使用小部件来设置其model和attribute。

```php
<?php
use silentlun\datepicker\DatePicker;

// as a widget
?>

<?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'date',
    'template' => '{addon}{input}',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
]);?>

<?php 
// with an ActiveForm instance 
?>
<?= $form->field($model, 'date')->widget(
    DatePicker::className(), [
        // inline too, not bad
         'inline' => true, 
         // 自定义模板
        'template' => '<div style="background-color: #fff; width:250px">{input}</div>',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
]);?>
```

没有模型的使用示例

```php 
<?php
use silentlun\datepicker\DatePicker;
?>
<?= DatePicker::widget([
    'name' => 'Test',
    'value' => '2021-03-21',
    'template' => '{addon}{input}',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
]);?>
```
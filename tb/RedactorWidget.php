<?php
/** Created by griga at 23.06.2014 | 20:05.
 *
 */

namespace yg\tb;

use \Yii;
use \yg\YgComponent;

class RedactorWidget extends \CInputWidget
{

    public function getDefaultOption()
    {
        return [
            'lang' => \Lang::get() == 'uk' ? 'ua' : \Lang::get(),
            'iframe' => true,
            'imageUpload' => '/admin/dashboard/imageUpload',
            'imageGetJson' => '/admin/dashboard/imageList',
            'minHeight' => 300,
        ];
    }

    public $options = [];

    public function run()
    {
        YgComponent::getInstance()->registerScripts();
        $groupName = get_class($this->model) . '_' . $this->attribute . '_' . 'multilang';
        $out = \CHtml::openTag('div', [
            'data-ml-group' => $groupName,
        ]);

        $options = \CMap::mergeArray($this->getDefaultOption(), $this->options);
        foreach (\Lang::getLanguages() as $lang => $langTitle) {

            $out .= \CHtml::openTag('div', [
                'data-ml-language' => $langTitle,
                'class' => $lang == \Lang::get() ? '' : 'hidden',
            ]);
            $out .= \Yii::app()->controller->widget('ext.redactor.ImperaviRedactorWidget', [
                'model' => $this->model,
                'attribute' => $this->attribute . '_' . $lang,
                'options' => $options,
            ], true);
            $out .= \CHtml::closeTag('div');

        }
        $out .= \CHtml::closeTag('div');
        app()->clientScript->registerScript($groupName, '$.fn.ygMultilang.register(\'[data-ml-group="' . $groupName . '"]\',{handlerCssClass: "top-minus-offset"})', \CClientScript::POS_READY);
        echo $out;
    }
}

<?php
/** Created by griga at 19.05.2014 | 18:58.
 *
 */

namespace yg\tb;

use \Yii;
use \yg\YgComponent;


class ActiveForm extends \CActiveForm
{
    public $errorMessageCssClass = 'label label-danger';
    public $enableAjaxValidation = true;
    public $clientOptions = array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
    );
    public $htmlOptions = array(
        'class' => 'form-horizontal'
    );

    public $labelColWidth = 2;


    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function textControl($model, $attribute, $htmlOptions = array())
    {
        $htmlOptions = \CMap::mergeArray(
            array('class' => 'form-control'),
            $htmlOptions
        );
        $multilingual = isset($htmlOptions['multilingual']);

        if ($multilingual) {
            YgComponent::getInstance()->registerScripts();
            unset($htmlOptions['multilingual']);
            $content = '';
            foreach (\Lang::getLanguages() as $langKey => $langTitle) {
                $options = $htmlOptions;
                $options['data-ml-language'] = $langTitle;
                if ($langKey != \Lang::get())
                    $options['class'] .= ' hidden';
                $content .= $this->textField($model, $attribute . '_' . $langKey, $options);
            }
            $groupName = get_class($model) . '_' . $attribute . '_' . 'multilang';
            $content = \CHtml::tag('div', array(
                'data-ml-group' => $groupName,
            ), $content);
            Yii::app()->clientScript->registerScript($groupName, '$.fn.ygMultilang.register(\'[data-ml-group="' . $groupName . '"]\')', \CClientScript::POS_READY);
        } else {
            $content = $this->textField($model, $attribute, $htmlOptions);
        }
        return $this->createRow($model, $attribute, $content, $multilingual);
    }

    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function textAreaControl($model, $attribute, $htmlOptions = array())
    {
        $htmlOptions = \CMap::mergeArray(
            array('class' => 'form-control'),
            $htmlOptions
        );

        $multilingual = isset($htmlOptions['multilingual']);

        if ($multilingual) {
            YgComponent::getInstance()->registerScripts();
            unset($htmlOptions['multilingual']);
            $content = '';
            foreach (\Lang::getLanguages() as $langKey => $langTitle) {
                $options = $htmlOptions;
                $options['data-ml-language'] = $langTitle;
                if ($langKey != \Lang::get())
                    $options['class'] .= ' hidden';
                $content .= $this->textArea($model, $attribute . '_' . $langKey, $options);
            }
            $groupName = get_class($model) . '_' . $attribute . '_' . 'multilang';
            $content = \CHtml::tag('div', array(
                'data-ml-group' => $groupName,
            ), $content);
            Yii::app()->clientScript->registerScript($groupName, '$.fn.ygMultilang.register(\'[data-ml-group="' . $groupName . '"]\')', \CClientScript::POS_READY);
        } else {
            $content = $this->textArea($model, $attribute, $htmlOptions);
        }
        return $this->createRow($model, $attribute, $content, $multilingual);
    }

    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @param array $data
     * @param array $htmlOptions
     * @return string
     */
    public function dropDownControl($model, $attribute, $data, $htmlOptions = array())
    {
        $htmlOptions = \CMap::mergeArray(
            array('class' => 'form-control'),
            $htmlOptions
        );
        $content = $this->dropDownList($model, $attribute, $data, $htmlOptions);
        return $this->createRow($model, $attribute, $content);
    }

    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function checkBoxControl($model, $attribute, $htmlOptions = array())
    {
        $out = '<div class="form-group ' . ($model->hasErrors($attribute) ? 'has-error' : '') . '">';
        $out .= '<div class="checkbox col-sm-' . (12 - $this->labelColWidth) . ' col-sm-offset-' . $this->labelColWidth . '">';
        $out .= '<div class="checkbox">';
        $out .= '<label>' . $this->checkBox($model, $attribute, $htmlOptions) . '<b>' . $model->getAttributeLabel($attribute) . '</b></label>';
        $out .= $this->error($model, 'enabled');
        $out .= '</div></div></div>';
        return $out;
    }

    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @param string $content
     * @param boolean $multilingual
     * @return string
     */
    public function createRow($model, $attribute, $content, $multilingual = false)
    {
        $out = '<div class="form-group ' . ($model->hasErrors($attribute) ? 'has-error' : '') . '">';
        $out .= $this->labelEx($model, $attribute, array('class' => 'control-label col-sm-' . $this->labelColWidth . ($multilingual ? ' label-multilingual' : '')));
        $out .= '<div class="col-sm-' . (12 - $this->labelColWidth) . '">';
        $out .= $content;
        $out .= $this->error($model, $attribute) . '</div></div>';
        return $out;
    }

    /**
     * @param \CActiveRecord $model
     * @param string $attribute
     * @return string
     */
    public function dateControl($model, $attribute)
    {
        $model->$attribute = $model->$attribute ? date('m/d/Y', strtotime($model->$attribute)) : date('m/d/Y');
        $content = \Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => $attribute,
            'options' => array(),
            'htmlOptions' => array(
                'class' => 'form-control',
                'style' => 'position:relative; z-index:10000; width: 120px'
            ),
        ), true);

        return $this->createRow($model, $attribute, $content);

    }


    public function actionButtons($model, $pull = false)
    {
        $out = '<div class="btn-group' . ($pull ? ' pull-' . $pull : '') . '">';
        $out .= \CHtml::hiddenField('form_action');
        $out .= \CHtml::submitButton(t('Save'), array('class' => 'btn btn-success', 'name' => 'save_and_close', 'onclick' => '$(this).closest("form").find("[name=form_action]").val($(this).attr("name"))'));
        $out .= \CHtml::submitButton(t('Save and continue editing'), array('class' => 'btn btn-default', 'name' => 'save_and_continue', 'onclick' => '$(this).closest("form").find("[name=form_action]").val($(this).attr("name"))'));
        $out .= '</div>';
        return $out;
    }

} 
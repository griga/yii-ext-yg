<?php
/** Created by griga at 19.05.2014 | 14:06.
 * 
 */

namespace yg\tb;

use \Yii;
use \yg\YgComponent;
use \yg\tb\ButtonColumn;

Yii::import('web.helpers.CHtml');

class AjaxButtonColumn extends ButtonColumn{

    public $moduleId;
    public $controllerId;
    public $updateModalSuccessRise;
    public function init()
    {
        parent::init();
        YgComponent::getInstance()->registerScripts();


        if(isset($this->controllerId)){
            $updateRoute = $this->controllerId. '/update';
            $deleteRoute = $this->controllerId. '/delete';
            if(isset($this->moduleId)){
                $updateRoute = $this->moduleId . '/' . $updateRoute;
                $deleteRoute = $this->moduleId . '/' . $deleteRoute;
            }
            $this->buttons['update']['url'] = 'Yii::app()->createUrl("'.$updateRoute.'",array("id"=>$data->primaryKey, "ajax"=>1))';
            $this->buttons['delete']['url'] = 'Yii::app()->createUrl("'.$deleteRoute.'",array("id"=>$data->primaryKey, "ajax"=>1))';
        }

        $this->buttons['update']['options']['title']=Yii::t('zii','Update');
        $this->buttons['delete']['options']['title']=Yii::t('zii','Delete');

        if(isset($this->updateModalSuccessRise))
            $this->buttons['update']['options']['data-modal-success-rise']=$this->updateModalSuccessRise;
    }


    public $modelHasPageSize = false;
    public $template = '{update}{delete}';
    public $buttons =  array(
        'update' => array(
            'label' => '<i class="glyphicon glyphicon-pencil"></i>',
            'imageUrl' => false,
            'options'=>array(
                'data-toggle'=>'yg-modal',
            )
        ),
        'delete' => array(
            'label' => '<i class="glyphicon glyphicon-trash"></i>',
            'imageUrl' => false,
        )
    );

}
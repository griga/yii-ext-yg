<?php
/** Created by griga at 19.05.2014 | 14:06.
 * 
 */

namespace yg\tb;

use \Yii;

Yii::import('zii.widgets.grid.CButtonColumn');
Yii::import('web.helpers.CHtml');

class ButtonColumn extends \CButtonColumn{

    public $modelHasPageSize = false;
    public $template = '{update}{delete}';
    public $buttons =  array(
        'update' => array(
            'label' => '<i class="glyphicon glyphicon-pencil"></i>',
            'imageUrl' => false,
        ),
        'delete' => array(
            'label' => '<i class="glyphicon glyphicon-trash"></i>',
            'imageUrl' => false,
        )
    );

    protected function renderFilterCellContent()
    {
        if ($this->modelHasPageSize) {
            echo \CHtml::activeDropDownList($this->grid->dataProvider->model, 'pageSize', array(
                '10' => '10',
                '15' => '15',
                '20' => '20',
                '30' => '30',
                '50' => '50',
                '100' => '100',
            ), array(
                'id' => 'pageSizeSelect'
            ));
        }
    }
} 
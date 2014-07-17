<?php
/** Created by griga at 23.06.2014 | 18:34.
 *
 */

namespace yg\tb;

use \Yii;

Yii::import('zii.widgets.grid.CDataColumn');

class CheckboxColumn extends \CDataColumn
{
    public $action;

    public function init()
    {
        cs()->registerScript('CheckboxColumn'.time(), <<< "JS"
        $('#{$this->grid->id}').on('click','[data-checkbox-cell]', function(){
           $.ajax({
               'url': '{$this->action}',
               'method': 'POST',
               'data':{
                   'id':$(this).data('checkboxCell'),
                   'value': this.checked
               }
           });
        });
JS
            , \CClientScript::POS_READY);
        parent::init();
    }


    protected function renderDataCellContent($row, $data)
    {
        echo \CHtml::checkBox('CheckboxCell_' . $this->name . '_' . $data->id, $data->{$this->name}, [
            'data-checkbox-cell'=>$data->id,
        ]);
    }



}
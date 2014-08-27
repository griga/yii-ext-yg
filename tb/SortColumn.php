<?php
/** Created by griga at 23.06.2014 | 18:34.
 *
 */

namespace yg\tb;

use \Yii;

Yii::import('zii.widgets.grid.CDataColumn');

class SortColumn extends \CDataColumn
{
    public $action;
    public $filter = false;

    public function init()
    {
        cs()->registerPackage('jquery.ui');
        cs()->registerScript('SortColumn' . time(), <<< JS
        $('#{$this->grid->id} tbody').sortable({
            handle: '.sortable-column-cell',
            stop: function(){
                var data = [];
                $('#{$this->grid->id} tbody .sortable-column-cell').each(function(){
                    data.push($(this).data('sortableId'));
                });
                $.post('{$this->action}',{
                    data: data
                })
            },
            helper: function(e, tr)
              {
                var originals = tr.children();
                var helper = tr.clone();
                helper.children().each(function(index)
                {
                  $(this).width(originals.eq(index).width());
                });
                return helper;
              }})
JS
            , \CClientScript::POS_READY);
        parent::init();
    }


    protected function renderDataCellContent($row, $data)
    {
        echo \CHtml::tag('div', [
            'class' => 'sortable-column-cell',
            'data-sortable-id' => $data->id,
        ]);
    }


}
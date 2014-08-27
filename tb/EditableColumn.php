<?php
/** Created by griga at 23.06.2014 | 18:34.
 *
 */

namespace yg\tb;

use yg\YgComponent;
use \Yii;

Yii::import('zii.widgets.grid.CDataColumn');

class EditableColumn extends \CDataColumn
{
    public $action;

    public function init()
    {
        $gridLoadingClass = $this->grid->loadingCssClass;
        $gridId = $this->grid->id;

        YgComponent::getInstance()->registerScripts();
        cs()->registerScript('EditableColumn' . time(), <<< JS
$('.editable-column-cell-wrapper').on('click', '.glyphicon-pencil', function(e){
    var eccw = $(this).closest('.editable-column-cell-wrapper');
    eccw.data('lastValue', eccw.find('.editable-column-current-value').text());
    eccw.find('.editable-column-saved').hide();
    eccw.find('.editable-column-under-edit').show();
    e.preventDefault();
}).on('click', '.glyphicon-ban-circle', function(e){
    var eccw = $(this).closest('.editable-column-cell-wrapper');
    eccw.find('.editable-column-under-edit').hide();
    eccw.find('.editable-column-saved').show();
    e.preventDefault();
}).on('click', '.glyphicon-ok', function(e){
    var eccw = $(this).closest('.editable-column-cell-wrapper');
    var input = eccw.find('input');
    eccw.closest('#{$gridId}').addClass('$gridLoadingClass');
    $.post("{$this->action}",{
        'id': input.data('editableModelId'),
        'field': input.data('editableModelField'),
        'value': input.val()
    }).success(function(){
        eccw.find('.editable-column-current-value').html(input.val());
        eccw.closest('#{$gridId}').removeClass('$gridLoadingClass');
        eccw.find('.editable-column-under-edit').hide();
        eccw.find('.editable-column-saved').show();
    });

    e.preventDefault();
})
JS
            , \CClientScript::POS_READY);
        parent::init();
    }


    protected function renderDataCellContent($row, $data)
    {
        $value = $data->{$this->name};
        echo <<< HTML
<div class="editable-column-cell-wrapper">
    <div class="editable-column-saved">
        <span class="editable-column-current-value">$value</span>
        <a href="#" ><i class="glyphicon glyphicon-pencil"></i></a>
    </div>
    <div class="editable-column-under-edit" style="display: none">
        <input type="text" value="$value" data-editable-model-id="{$data->id}" data-editable-model-field="{$this->name}" style="width: 70%;"/></span>
        <a href="#" ><i class="glyphicon glyphicon-ok"></i></a>
        <a href="#" ><i class="glyphicon glyphicon-ban-circle"></i></a>
    </div>
</div>
HTML;
    }


}
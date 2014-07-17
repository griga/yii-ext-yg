<?php
namespace yg\tb;

use \Yii;

Yii::import('zii.widgets.grid.CGridView');

class GridView extends \CGridView{
    public $template = '{summary}{items}{pager}';
    public $pager =  array(
        'header' => false,
        'cssFile' => false,
        'selectedPageCssClass' => 'active',
        'htmlOptions' => array(
            'class' => 'pagination',
        ),
        'firstPageCssClass' => 'hidden',
        'previousPageCssClass' => 'hidden',
        'nextPageCssClass' => 'hidden',
        'lastPageCssClass' => 'hidden',
    );
    public $pagerCssClass = 'pagination-container';
    public  $enableHistory = true;
    public  $ajaxUpdate = true;
    public $cssFile = false;
    public $itemsCssClass = 'table table-striped table-bordered table-condensed table-hovered';


}
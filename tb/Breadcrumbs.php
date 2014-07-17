<?php
/** Created by griga at 19.05.2014 | 16:22.
 *
 */

namespace yg\tb;

use \Yii;

Yii::import('zii.widgets.CBreadcrumbs');

class Breadcrumbs extends \CBreadcrumbs
{

    public $tagName = 'ol';
    public $htmlOptions = array(
        'class' => 'breadcrumb'
    );
    public $separator = false;
    public $homeLink;
    public $activeLinkTemplate = '<li><a href="{url}">{label}</a></li>';
    public $inactiveLinkTemplate = '<li>{label}</li>';

    public function init()
    {
        if(!isset($this->homeLink))
            $this->homeLink = '<li><a href="'.Yii::app()->createUrl(Yii::app()->homeUrl[0]).'">' . Yii::t('zii','Home') . '</a></li>';
        parent::init();
    }

} 
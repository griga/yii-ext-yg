<?php
/** Created by griga at 06.06.2014 | 3:32.
 *
 */

namespace yg\tb;


use yg\YgComponent;

class ModalRemoteLink extends \CWidget
{

    public $label;
    public $href;
    public $ajaxVar = 'ajax=1';
    public $htmlOptions =[];

    public function run()
    {
        $options = $this->htmlOptions;
        YgComponent::getInstance()->registerScripts();
        $options['data-toggle'] = 'yg-modal';
        $options['href'] = $this->href . (strpos($this->href, '?') === false ? '?' : '&') . $this->ajaxVar;
        echo \CHtml::tag('a', $options, $this->label);
    }
}
<?php
/** Created by griga at 22.12.13 | 7:10.
 * 
 */

class GridFilterClearButtons extends CWidget {

    public $gridId;

    public function init()
    {
        static $registered;
        if(!$registered){
            cs()->registerScript(__CLASS__ . 'init', <<<JS
            $.fn.yiiGridView.addClearFilterToGrid = function (id) {
                $('tr.filters>td', $('#' + id)).each(function () {
                    var filter = $(this);
                    var input = filter.find('input[type=text]');
                    if (input.length) {
                        filter.css('position', 'relative').append(
                                $('<a>', {href: '#', style: 'position: absolute; top: 10px; right: 3px'})
                                    .append($('<i>', {'class': 'glyphicon glyphicon-remove', style: (input.val() ? 'opacity: 0.4' : 'opacity: 0')}))
                            ).on('click', '.glyphicon-remove',function (event) {
                                filter.find('input').val('').trigger('change');
                                event.preventDefault();
                            }).on('mouseenter', '.glyphicon-remove',function () {
                                input.val() && $(this).stop().animate({opacity: 0.9})
                            }).on('mouseleave', '.glyphicon-remove',function () {
                                input.val() && $(this).stop().animate({opacity: 0.4})
                            }).on('change', input, function () {
                                filter.find('.glyphicon-remove').stop().animate({opacity: (input.val() ? 0.4 : 0)})
                            });
                    }
                });
            };
JS
, CClientScript::POS_READY);
            $registered = true;
        }
        parent::init();
    }

    public function run()
    {
        cs()->registerScript(__CLASS__ . $this->gridId, <<<JS
        $(document).on('ajaxSuccess',function(){ $.fn.yiiGridView.addClearFilterToGrid('$this->gridId'); });
        $.fn.yiiGridView.addClearFilterToGrid('$this->gridId');
JS
, CClientScript::POS_READY);
    }


} 
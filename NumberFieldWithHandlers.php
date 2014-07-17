<?php
/** Created by griga at 04.01.14 | 4:23.
 * 
 */

class NumberFieldWithHandlers extends CWidget{
    public function run(){
        cs()->registerCss(__CLASS__.'css', <<< CSS
    .ygnf-wrapper {
        position: relative;
    }


    .ygnf-wrapper .ygnf-decrease-handler .glyphicon,
    .ygnf-wrapper .ygnf-increase-handler .glyphicon{
        font-size: 13px;
    }

    .ygnf-increase-handler {
        position: absolute;
        z-index: 1000;
        right: 4px;
        opacity: .2;
        top: 3px;
    }
    .ygnf-decrease-handler {
        position: absolute;
        z-index: 1000;
        right: 5px;
        opacity: .2;
        bottom: 0;
    }

    .ygnf-decrease-handler:hover, .ygnf-increase-handler:hover {
        opacity: .7;
    }
CSS
);
        cs()->registerScript(__CLASS__.'js', <<< JS
        $('.ygnf-number-field').each(function () {
            var self = $(this),
                wrap = self.wrap("<div class='ygnf-wrapper'></div>").parent();
            !self.val() && self.val(0);
            wrap.css('display', self.css('display'))
                .height(self.outerHeight()).width(self.outerWidth());
            wrap.append($('<div class="ygnf-increase-handler"><a href="#"><i class="glyphicon glyphicon-chevron-up"></i></a></div>'));
            wrap.append($('<div class="ygnf-decrease-handler"><a href="#"><i class="glyphicon glyphicon-chevron-down"></i></a></div>'));
            wrap
                .on('mousedown', '.ygnf-increase-handler, .ygnf-decrease-handler', function () {
                    var handler = $(this);
                    var intervalHandler = setInterval(function () {
                        self.val(handler.hasClass('ygnf-increase-handler') ? parseInt(self.val()) + 1 : parseInt(self.val()) - 1);
                    }, 100);
                    wrap.data('interval', intervalHandler);
                    event.preventDefault();
                })
                .on('mouseup', '.ygnf-increase-handler, .ygnf-decrease-handler', function () {
                    clearInterval(parseInt(wrap.data('interval')));
                    event.preventDefault();
                })
                .on('click', '.ygnf-increase-handler, .ygnf-decrease-handler', function () {
                    self.val($(this).hasClass('ygnf-increase-handler') ? parseInt(self.val()) + 1 : parseInt(self.val()) - 1);
                    event.preventDefault();
                })
        });
JS
,CClientScript::POS_READY);
    }

} 
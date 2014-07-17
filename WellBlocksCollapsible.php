<?php
/** Created by griga at 04.01.14 | 0:44.
 * 
 */

class WellBlocksCollapsible extends CWidget{

    public function run(){
        cs()->registerCss(__CLASS__.'css', <<<CSS
    .well {
        position: relative;
    }

    .well.ygbc-collapsed {
        overflow: hidden;
        height: 38px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .well.ygbc-collapsed > * {
        display: none;
    }

    .well.ygbc-collapsed h4,
    .well.ygbc-collapsed div.ygbc-handler {
        display: block;
    }

    .ygbc-handler {
        position: absolute;
        top: 3px;
        right: 0;
        opacity: 0.3;
    }

    .ygbc-handler:hover {
        opacity: 0.7;
    }
CSS
);
        cs()->registerScript(__CLASS__.'js', <<<JS
        var getCookieName= function(i){
            return 'ygbc-well-' + i;
        };
        var collapseToggle = function(well, cookieName, collapse){
            var self = $(well);
            if (!self.hasClass('ygbc-collapsed') || collapse) {
                self.addClass('ygbc-collapsed').find('.ygbc-handler i').removeClass('glyphicon glyphicon-chevron-left').addClass('glyphicon glyphicon-chevron-down');
                $.cookie(cookieName, 'collapsed',{
                    path: document.location.pathname.replace(/\/?\d+/,'')
                });
            } else {
                self.removeClass('ygbc-collapsed').find('.ygbc-handler i').removeClass('glyphicon glyphicon-chevron-down').addClass('glyphicon glyphicon-chevron-left');
                $.cookie(cookieName, null,{
                    path: document.location.pathname.replace(/\/?\d+/,'')
                })
            }
        };
        var wells = $('.well');
        wells.each(function (i, well) {
            var cn = getCookieName(i),
                collapsed = $.cookie(cn)==='collapsed';
            if(collapsed){
                collapseToggle(well, cn, true);
            }
            $(well).append($('<div class="ygbc-handler"><a href="#"><i class="glyphicon glyphicon-chevron-'+ (collapsed ? 'down' : 'left') +'"></i></a></div>'))
        }).on('click', '.ygbc-handler a', function () {
                var self = $(this).closest('.well')[0],
                    cookieName;
                wells.each(function (i, well) {
                    if (self === well)
                        cookieName = getCookieName(i)
                });
                collapseToggle(self, cookieName);
                event.preventDefault();
            });

JS
, CClientScript::POS_READY);
        cs()->registerPackage('cookie');
    }
} 
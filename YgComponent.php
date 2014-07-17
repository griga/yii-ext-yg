<?php

namespace yg;


class YgComponent{

    private static $_instance;

    private static $_scriptsRegistered = false;

    private function __construct(){


    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function registerScripts(){
        if(!self::$_scriptsRegistered){
            $assetsUrl = \Yii::app()->assetManager->publish(__DIR__.'/assets',false,-1,true);
            \Yii::app()->clientScript->registerCoreScript('jquery');
            \Yii::app()->clientScript->registerScriptFile( $assetsUrl . '/yg-scripts.js');
            self::$_scriptsRegistered = true;
        }

    }

}
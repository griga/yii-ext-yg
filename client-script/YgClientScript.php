<?php
/** Created by griga at 06.06.2014 | 2:38.
 * 
 */

class YgClientScript extends CClientScript {

    private function checkRegistered($id, $category){
        $cookies = r()->getCookies();
        $renderedScripts = $cookies['REGISTERED_FILES'] ? json_decode($cookies['REGISTERED_FILES'], true) : array();
        if(!isset($renderedScripts[$category])){
            $renderedScripts[$category] = array();
        }
        return in_array($id, $renderedScripts[$category]);
    }

    private function addToRegistered($id, $category){
        $cookies = r()->getCookies();
        $renderedScripts = $cookies['REGISTERED_FILES'] ? json_decode($cookies['REGISTERED_FILES'], true) : array();
        if(!isset($renderedScripts[$category])){
            $renderedScripts[$category] = array();
        }
        if(!in_array($id, $renderedScripts[$category])){
            $renderedScripts[$category][] = $id;
            Yii::app()->request->cookies['REGISTERED_FILES'] = new CHttpCookie('REGISTERED_FILES', json_encode($renderedScripts));
        }
    }


    public function registerCoreScript($name)
    {
        if(Yii::app()->request->isAjaxRequest && $this->checkRegistered($name,'scriptCore') ){
            return false;
        } else {
            $this->addToRegistered($name, 'scriptCore');
            return parent::registerCoreScript($name);
        }
    }


    public function registerPackage($name)
    {
        if(Yii::app()->request->isAjaxRequest && $this->checkRegistered($name,'package') ){
            return false;
        } else {
            $this->addToRegistered($name, 'package');
            return parent::registerPackage($name);
        }
    }

    public function registerScriptFile($url, $position = null, array $htmlOptions = array())
    {
        if(Yii::app()->request->isAjaxRequest && $this->checkRegistered($url,'scriptFile') ){
            return false;
        } else {
            $this->addToRegistered($url, 'scriptFile');
            return parent::registerScriptFile($url, $position, $htmlOptions);
        }
    }

}
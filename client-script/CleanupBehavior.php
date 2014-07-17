<?php
/** Created by griga at 06.06.2014 | 3:13.
 * 
 */

class CleanupBehavior extends CBehavior {
    public function attach($owner)
    {
        if(!Yii::app()->request->isAjaxRequest){
            unset(Yii::app()->request->cookies['REGISTERED_FILES']);
        }
    }


} 
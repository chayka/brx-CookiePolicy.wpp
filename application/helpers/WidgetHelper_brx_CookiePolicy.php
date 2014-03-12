<?php

class WidgetHelper_brx_CookiePolicy extends WidgetHelper{
    
    public static function renderWidget($data, $tpl, $js, $css = null) {
        $path = WpHelper::getRootDir();
//        parent::addScriptPath(BRX_COOKIEPOLICY_APPLICATION_PATH.'/views/scripts');
        parent::addScriptPath($path.'/application/views/scripts');
        return parent::renderWidget($data, $tpl, $js, $css);
    }
    
    public static function renderBanner(){
        $accepted = Util::getItem($_COOKIE, 'cookie_policy_accepted');
        return $accepted?'':self::renderWidget(array(), 'widgets/brx.CookiePolicy.Banner.view.phtml', 'brx.CookiePolicy.Banner.view');
    }

}

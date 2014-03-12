<?php

require_once 'application/helpers/UrlHelper_brx_CookiePolicy.php';

class brx_CookiePolicy_CookiePolicyController extends Zend_Controller_Action{

    public function init(){
    }
    
    public function acceptAction(){
        Util::turnRendererOff();
        if(setcookie('cookie_policy_accepted', true, time() + 60*60*24*31*12*5, '/')){
            JsonHelper::respond();
        }
        
        JsonHelper::respondError();
    }
    
    public function declineAction(){
        Util::turnRendererOff();
        if(setcookie('cookie_policy_accepted', false, time() + 60*60*24*31*12*5, '/')){
            JsonHelper::respond();
        }
        
        JsonHelper::respondError();
    }
    
}


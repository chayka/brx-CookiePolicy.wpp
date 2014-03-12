<?php

class EmailHelper_brx_CookiePolicy extends EmailHelper{
    
    public static function sendTemplate($subject, $template, $params, $to, $from = '', $cc = '', $bcc = '', $link=''){
        try{
            
        $html = new Zend_View();
        $html->setScriptPath(WPP_MCC_ADMISSION_PATH. 'application/views/scripts/email/');
//        print_r($params);
        foreach($params as $key => $value){
            $html->assign($key, $value);
        }
        
        $body = $html->render($template);
        }catch(Exception $e){
            JsonHelper::respondError($e->getMessage());
        }

        return EmailHelper::send($subject, $body, $to, $from, $cc, $bcc, $link);
    }

    public static function sendTest(){
        $post = PostModel::query()
                ->postType_Post()
                ->postsPerPage(1)
                ->orderBy_ID()
                ->order_DESC()
                ->selectOne();

        self::sendTemplate('Test message: '.$post->getTitle(), 'test.phtml', array(
            'post' => $post,
        ), UserModel::currentUser()->getEmail(), '', '', '', '');
        
    }
    
}
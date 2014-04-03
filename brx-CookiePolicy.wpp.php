<?php
/*
  Plugin Name: brx-CookiePolicy
  Plugin URI: http://github.com/chayka/brx-CookiePolicy.git
  Description: Cookie Policy add-on.
  Version: 1.0
  Author: Boris Mossounov
  Author URI: http://facebook.com/mossounov
  License: GPL2
 */
require_once 'application/helpers/WidgetHelper_brx_CookiePolicy.php';
require_once 'application/helpers/HtmlHelper_brx_CookiePolicy.php';
require_once 'application/helpers/OptionHelper_brx_CookiePolicy.php';
class brx_CookiePolicy extends WpPlugin{
    
    protected static $instance = null;
    
    const POST_TYPE_DUMMY = 'dummy';
    const TAXONOMY_DUMMY_TAG = 'dummy-tag';
    
    public static function baseUrl(){
        echo BRX_COOKIEPOLICY_URL;
    }
    
    public static function init() {
        
        NlsHelper::load('brx_CookiePolicy');

        self::$instance = $plugin = new brx_CookiePolicy(__FILE__, array(
            'cookie-policy',
        ));
        
        $plugin->addSupport_ConsolePages();

    }

    public static function getInstance() {
        return self::$instance;
    }

    public function registerCustomPostTypes() {
//        ZF_Core::registerCustomPostTypeContentFragment();
    }

    
    public function enableSearch($query){
        if ($query->is_search) {
            $postTypes = $query->get('post_type');
            if(!$postTypes){
                $postTypes = array('post', 'page');
            }
            
            $postTypes[]=  brx_CookiePolicy::POST_TYPE_DUMMY;

            $query->set('post_type', $postTypes);
        }
        return $query;
    }
    
    public function registerTaxonomies(){
  // Add new taxonomy, make it hierarchical (like categories)
    }


    public function postPermalink($permalink, $post, $leavename = false){
        switch($post->post_type){
//            case 'post':
//                return '/entry/'.$post->ID.'/'.($leavename?'%postname%':$post->post_name);
//            case self::POST_TYPE_DUMMY:
//                return '/dummy/'.($leavename?'%postname%':$post->post_name);
            default:
                return $permalink;
        }
    }
    
    public function termLink($link, $term, $taxonomy){
        return $link;
    }

    public function registerNavMenus(){
//        $this->registerNavMenu('main-menu', 'Main-menu');
    }
    
    public function customizeNavMenuItems($items, $args){
//            Util::print_r(func_get_args());
        $byId = array();
        foreach($items as $i=>$item){
            $byId[$item->ID] = $i; 
        }
        foreach($items as $item){
            if($item->menu_item_parent){
                $i = Util::getItem($byId, $item->menu_item_parent, -1);
                if($i >= 0 && !in_array('menu-item-parent', $items[$i]->classes)){
                    $items[$i]->classes[]='menu-item-parent';
                }
            }
            $url = preg_replace('%\/$%', '', $item->url);
            if($url && strpos($_SERVER['REQUEST_URI'], $url)!==false && !$item->current){
                $item->current = 1;
                $item->classes[]='current-menu-item';
            }
        }
        
        return $items;
    }
    
    public function registerMetaBoxes() {
    }
    
    public function savePost($postId, $post){

    }
    
    public function registerResources($minimize = false){
        $this->registerStyle('brx.CookiePolicy.Banner.view', 'brx.CookiePolicy.Banner.view.less', array());
        $this->registerScript('brx.CookiePolicy.Banner.view', 'brx.CookiePolicy.Banner.view.js', array('backbone-brx', 'brx.CookiePolicy.Banner.nls'));
        NlsHelper::registerScriptNls('brx.CookiePolicy.Banner.nls', 'brx.CookiePolicy.Banner.view.js');
    }
    
    public function registerActions(){
//        $this->addAction('add_meta_boxes', array('wpp_MCC_v2', 'addMetaBoxStaff') );
        $this->addAction('wp_footer', array('WidgetHelper_brx_CookiePolicy', 'renderBanner'));
    }
    
    public function registerFilters(){
        $this->addFilter( 'the_search_query', 'enableSearch');
        remove_filter('the_content', 'prepend_attachment', 10);
    }
    public function registerConsolePages() {
        $this->addConsolePage('Cookie Policy', 'Cookie Policy', 'update_core', 'brx-cookiepolicy-plugin-options', '/admin/plugin-options');

    }

    public function registerSidebars() {
        register_sidebar(array(
            'name'=>NlsHelper::_('Stats Counters'),
            'id'=>'stats-counters',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => "<!--",
            'after_title'   => "-->\n"             
        ));
        register_sidebar(array(
            'name'=>NlsHelper::_('Default'),
            'id'=>'default',
        ));
    }

    public static function blockStyles($block = true) {
        
    }
}


ZF_Core::hideAdminBar();
//ZF_Core::showAdminBar();
//ZF_Core::showAdminBarToAdminOnly();

add_action('init', array('brx_CookiePolicy', 'init'));

<?php
App::import('Xml');

class BlogsController extends AppController {

	var $name = 'Blogs';
	var $uses = array();
	
	public function _getArrayOfPosts($forceRefresh=false){
	    $cacheKey = "blog_posts";
	    $items = Cache::read($cacheKey, 'external');
	    if($items==false || $forceRefresh) {
            $feedUrl = Configure::read("Blog.ExternalRssFeed");
            $parsed_xml =& new XML($feedUrl);
            $rss_item = $parsed_xml->toArray();
            $items = $rss_item['Rss']['Channel']['Item'];
            Cache::write($cacheKey, $items, 'external');
	    }
	    return $items;
	}
	
	public function allPostTitles() {
        $posts = $this->_getArrayOfPosts();
        $this->set("posts",$posts);
	}
	

}
?>
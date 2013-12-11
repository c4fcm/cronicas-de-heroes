<?php
class TagCategory extends AppModel {

    const CACHE_KEY_ALL = "allTagCategories";
    
    var $name = 'TagCategory';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Tag'
	);

   var $actsAs = array('Containable');
	
   /**
    * Call this to fetch the cached list of tag categories.
    * The populate_tags task flushes this cache.
    * @param unknown_type $forceRefresh
    */
   public function cachedFindAll($forceRefresh=false){
       $list = Cache::read(TagCategory::CACHE_KEY_ALL);
       if( ($list!==false) && $forceRefresh==false){
           return $list;
       }
       $list = $this->find('all');
       Cache::write(TagCategory::CACHE_KEY_ALL,$list);
       return $list;       
   }
   
}
?>
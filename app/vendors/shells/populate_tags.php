<?php

/**
 * Run this once from the shell to set up the initial categories, 
 * or add new ones.
 * > cake populate_tags
 * @author rahulb
 *
 */
class PopulateTagsShell extends Shell {

    var $uses = array('TagCategory','Tag');
    
    function main() {
        
        $tags = Configure::Read('Tags');
        if($tags==null){
            $this->out("ERROR: Your heroreports.config has no 'Tags' entry.");
            return;
        }

        Cache::delete(TagCategory::CACHE_KEY_ALL);
        
        foreach($tags as $cat=>$terms){
            $existingTagCategory = $this->TagCategory->findByName($cat);
            $tagCategoryId = null;
            if($existingTagCategory==null){
                $this->out("New Category\t\t".$cat);
                $this->TagCategory->create();
                $this->TagCategory->save(array('name'=>$cat));
                $tagCategoryId = $this->TagCategory->id;
            } else {
                $tagCategoryId = $existingTagCategory['TagCategory']['id'];
                $this->out("Existing Category\t".$cat." (".$tagCategoryId.")");
            }
            foreach($terms as $term){
                $existingTag = $this->Tag->findByName($term);
                if($existingTag==null){
                    $this->out("\tNew Tag\t\t".$term);
                    $this->Tag->create();
                    $this->Tag->save(array('tag_category_id'=>$tagCategoryId,'name'=>$term));
                    $tagId = $this->TagCategory->id;
                } else {
                    $tagId = $existingTag['Tag']['id'];
                    $this->out("\tExisting Tag\t".$term." (".$tagId.")");
                }
            }
        }
        
    }
    
}

?>
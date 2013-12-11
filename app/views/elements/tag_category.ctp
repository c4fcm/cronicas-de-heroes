<?php 
/**
 * Print out the tag category title and a list of all the terms in it,
 * linked to the page to view all the reports with that tag.
 * @param   $tagCategory    a category object with all the terms in it
 */
?>
 
<div class="hr-tag-category-list">
<h2><?=__d("tags",$tagCategory['TagCategory']['name'])?></h2>
<ul>
<?php foreach($tagCategory['Tag'] as $tag) {?>
    <li><?=$heroreports->linkToTag($tag)?></li>
<?php } ?>
</ul>
</div>

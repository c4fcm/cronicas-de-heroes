<h3><?php __("Blog") ?></h3>
<ul>
<?php 
foreach($posts as $post){
?>  <li><?php echo $html->link($post['title'],$post['link'])?></li>
<?php
}
?>
</ul>
<small><a href="<?= Configure::read("Blog.ExternalUrl") ?>"><?=__("report.readmore")?></a></small>
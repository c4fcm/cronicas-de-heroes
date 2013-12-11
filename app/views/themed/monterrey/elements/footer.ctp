
<div class="hr-column">
<h2>Tu Opinión nos interesa</h2>
<p>
Envíanos tu comentario a
<br />
<a href="mailto:info-mty@cronicasdeheroes.mx">info-mty@cronicasdeheroes.mx</a>
</p>
<p>
<?php 
if($isLoggedIn) {
    echo $html->link(__('nav.logout',true), 
        array('moderator'=>false, 'controller' => 'users','action'=>'logout'));
} else {
    echo $html->link(__('nav.login',true), 
        array('moderator'=>false, 'controller' => 'users','action'=>'login'));
}
?>
</p>
</div>

<?php 
$featuredTagCategory = null;
foreach($allTagCategories as $tagCategory){
    if($tagCategory['TagCategory']['name']=="tag.category.category"){
        $featuredTagCategory = $tagCategory;
    }
}

if($featuredTagCategory) {
?>
    <div class="hr-column">
    <?php echo $this->element('tag_category',
                    array('tagCategory'=>$featuredTagCategory)
                );?>
    </div>
<?php 
}
?>

<div class="hr-column">
<h2>Eventos, actividades, noticias</h2>
</div>
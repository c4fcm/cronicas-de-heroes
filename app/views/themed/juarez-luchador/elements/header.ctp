<div class="hr-large-button">
    <?php echo $html->link(__('nav.donate',true), 
        array('moderator'=>false, 'controller' => 'pages','action'=>'donate'))?>
</div>

<?php echo $html->link( $html->image('logo.png', array('alt'=>__("site.title",true))) , 
                    array('moderator'=>false, 'controller' => 'home'), array('escape'=>false) ) ?>

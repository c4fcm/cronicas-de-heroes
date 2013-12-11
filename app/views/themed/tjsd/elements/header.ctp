
<div class="hr-choose-locale">
<?php 
echo $html->link(__('locale.english',true), 
        array('moderator'=>false, 'controller' => 'users','action'=>'set_language','eng-tjsd'));
?>
<?php
echo $html->link(__('locale.spanish',true), 
        array('moderator'=>false, 'controller' => 'users','action'=>'set_language','spa-tjsd'));
?>    
</div>

<h1><?php __("site.title")?> <?= Configure::read('Gui.CityName') ?></h1>


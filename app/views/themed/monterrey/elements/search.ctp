<?php

echo $form->create(null, array('url'=>array('moderator'=>false,'controller'=>'reports','action'=>'search'),
                                'id'=>'hr-search-form', 'class'=>'hr-form')
);
?>
<?php
echo $form->input('',array('label'=>false,'name'=>'data[s]','value'=>__('action.search',true)));
?>
<?php
echo $form->submit('search-icon.gif');
?>
<?php
echo $form->end();    

?>
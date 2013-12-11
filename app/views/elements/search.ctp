<?php

echo $form->create(null, array('url'=>array('moderator'=>false,'controller'=>'reports','action'=>'search'),
                                'id'=>'hr-search-form', 'class'=>'hr-form')
);
echo $form->input('',array('div'=>false,'label'=>false,'name'=>'data[s]'));
echo $form->submit(__('action.search',true),array('div'=>false));
echo $form->end();    

?>
<?php 
$pageTitle = __("page.preferences",true).": ".$this->data['User']['username'];
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?></h2>

<?
echo $form->create('User', array("action"=>"save","class"=>"hr-form") );
echo $form->hidden('id');
echo $form->input('password', array('label'=>__('user.label.password',true),'value'=>''));
echo $form->input('language', array('label'=>__('user.label.language',true),
    'options'=>$locales,'selected'=>$this->data['User']['language']));
echo $form->submit(__('action.submit',true));
echo $form->end();
?>

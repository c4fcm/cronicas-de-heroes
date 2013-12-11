<?php 
$pageTitle = __("page.preferences",true).": ".$this->data['User']['username'];
$pageDescription = __("page.preferences.description",true);
$pageIcon = 'icon-none.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

<?
echo $form->create('User', array("action"=>"save","class"=>"hr-form") );
echo $form->hidden('id');
echo $form->input('password', array('label'=>__('user.label.password',true),'value'=>''));
echo $form->input('language', array('label'=>__('user.label.language',true),
    'options'=>$locales,'selected'=>$this->data['User']['language']));
echo $form->submit(__('action.submit',true));
echo $form->end();
?>

</div>
<?php 
$pageTitle = __("page.signup",true);
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?></h2>

<?php print $session->flash(); ?>

<div class="hr-form-signup"> 
<?php
echo $form->create('User', array('action' => 'signup', 'class'=>'hr-form'));
echo $form->input('email', array('label'=>__('user.label.email',true)));
echo $form->input('username', array('label'=>__('user.label.username',true)));
echo $form->input('password', array('label'=>__('user.label.password',true)));
echo $form->submit(__('action.submit',true)); 
echo $form->end(); 
?> 
</div> 

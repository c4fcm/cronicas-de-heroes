<?php 
$pageTitle = __("page.login",true);
$pageDescription = "";
$pageIcon = 'icon-none.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

    <?php print $session->flash(); ?>
    
    <div class="hr-form-login"> 
    <?php 
    echo $form->create('User', array('action' => 'login', 'class'=>'hr-form')); 
    echo $form->input('username', array('label'=>__('user.label.username',true))); 
    echo $form->input('password', array('label'=>__('user.label.password',true)));
    echo $form->submit(__('action.login',true)); 
    echo $form->end(); 
    ?> 
    </div> 
    
    <script type="text/javascript">
    $(document).ready(function(){
        $("#UserUsername").focus();
    });
    </script>
    
</div>
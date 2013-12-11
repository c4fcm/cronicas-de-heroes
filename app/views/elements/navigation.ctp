
    <ul>
        <li><?php echo $html->link(__('nav.home',true), 
                    array('moderator'=>false, 'controller' => 'home'))?></li>
        <li><?php echo $html->link(__('nav.submit',true), 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'create'))?></li>
        <li><?php echo $html->link(__('nav.browse',true), 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'browse'))?></li>
        <li><?php echo $html->link(__('nav.map',true), 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'map'))?></li>
        <li><?php echo $html->link(__('nav.about',true), 
                    array('moderator'=>false, 'controller' => 'pages','action'=>'about'))?></li>
<?php if($isModerator) {?>
        <li><?php echo $html->link(__('nav.moderate',true)." (".$pendingApprovalCount.")", 
                    array('moderator'=>true,'controller' => 'reports','action'=>'index'))?></li>
<?php } ?>
<?php if($isAdmin) {?>
        <li><?php echo $html->link(__('nav.users',true), 
                    array('admin'=>true,'controller' => 'users','action'=>'index'))?></li>
<?php } ?>
<?php if($isLoggedIn) {?>
        <li><?php echo $html->link(__('nav.preferences',true), 
                    array('moderator'=>true, 'controller' => 'users','action'=>'preferences'))?></li>
        <li><?php echo $html->link(__('nav.logout',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'logout'))?></li>
<?php } ?>
    </ul>
<?php if(!$isLoggedIn) {?>
    <div id="hr-nav-submit-invitation">
    <?php echo $html->link( __('nav.inivationtosubmit',true) , 
                    array('controller' => 'reports','action'=>'create' ))
    ?> &rarr;
    </div>
<?php } ?>

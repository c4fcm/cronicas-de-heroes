
    <ul>

        <li><?php 
                echo $html->link("<span class='hr-icon hr-icon-home'></span>".
                                 "<span class='hr-name'>".__('nav.home',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'home'), 
                    array('escape' => false))?></li>

        <li><?php echo $html->link("<span class='hr-icon hr-icon-submit'></span>".
                                 "<span class='hr-name'>".__('nav.submit',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'create'),
                    array('escape' => false))?></li>

        <li><?php echo $html->link("<span class='hr-icon hr-icon-browse'></span>".
                                 "<span class='hr-name'>".__('nav.browse',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'browse'),
                    array('escape' => false))?></li>

        <li><?php echo $html->link("<span class='hr-icon hr-icon-map'></span>".
                                 "<span class='hr-name'>".__('nav.map',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'reports','action'=>'map'),
                    array('escape' => false))?></li>

        <li><?php echo $html->link("<span class='hr-icon hr-icon-downloads'></span>".
                                 "<span class='hr-name'>".__('nav.downloads',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'pages','action'=>'downloads'),
                    array('escape' => false))?></li>
                    
        <li><?php echo $html->link("<span class='hr-icon hr-icon-about'></span>".
                                 "<span class='hr-name'>".__('nav.about',true)."</span>", 
                    array('moderator'=>false, 'controller' => 'pages','action'=>'about'),
                    array('escape' => false))?></li>
                    
<?php if($isModerator) {?>
        <li class="hr-admin-nav"><?php echo $html->link(__('nav.moderate',true)." (".$pendingApprovalCount.")", 
                    array('moderator'=>true,'controller' => 'reports','action'=>'index'))?></li>
<?php } ?>

<?php if($isAdmin) {?>
        <li class="hr-admin-nav"><?php echo $html->link(__('nav.users',true), 
                    array('admin'=>true,'controller' => 'users','action'=>'index'))?></li>
<?php } ?>

<?php if($isLoggedIn) {?>
        <li class="hr-admin-nav"><?php echo $html->link(__('nav.preferences',true), 
                    array('moderator'=>true, 'controller' => 'users','action'=>'preferences'))?></li>
        <li class="hr-admin-nav"><?php echo $html->link(__('nav.logout',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'logout'))?></li>
<?php } ?>

    </ul>

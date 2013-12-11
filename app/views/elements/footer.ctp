<strong>Heroreports</strong> &rarr; 
<a href="http://civic.mit.edu">Center for Civic Media</a>

<br />

<?php if($isLoggedIn) {?>
        <?php echo $html->link(__('nav.logout',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'logout'))?>
<?php } else { ?>
        <?php echo $html->link(__('page.login',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'login'))?>
<?php }?>

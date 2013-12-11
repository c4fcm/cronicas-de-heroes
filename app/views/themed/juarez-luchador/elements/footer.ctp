
<strong>Crónicas de Héroes</strong> &rarr; 
<a href="http://civic.mit.edu">Center for Future Civic Media</a>

<br />

<a href="mailto:info@cronicasdeheroes.mx">info&#64;cronicasdeheroes.mx</a>

<br />

<?php if($isLoggedIn) {?>
        <?php echo $html->link(__('nav.logout',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'logout'))?>
<?php } else { ?>
        <?php echo $html->link(__('page.login',true), 
                    array('moderator'=>false, 'controller' => 'users','action'=>'login'))?>
<?php }?>

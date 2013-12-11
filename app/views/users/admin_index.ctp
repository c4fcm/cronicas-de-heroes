<?php 
$pageTitle = __("page.allusers",true);
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?></h2>

<p>
<?=$html->link(__("link.createuser",true), array("admin"=>true,"action"=>"create") ); ?>
</p>

<br />

<table>

    <tr>
        <th><?php __("user.label.username")?></th>
        <th><?php __("user.label.email")?></th>
        <th><?php __("user.label.admin")?></th>
        <th><?php __("user.label.moderator")?></th>
        <th></th>
    </tr>

<?php foreach( $users as $u) {?>
    <tr>
        <td><?=$u['User']['username']?></td>
        <td><?=$u['User']['email']?></td>
        <td><?($u['User']['admin']) ? __("noun.yes"):""?></td>
        <td><?php __('noun.yes')?></td>
        <td>
            <?php
                print $html->link(__("action.edit",true), array("admin"=>true,"action"=>"edit",$u['User']['id']) );
                ?>
            <?php
                print $html->link(__("action.delete",true),
                        array("admin"=>true,"action"=>"delete",$u['User']['id']),
                        array(),
                        __("action.delete.confirm",true)
                        );
                ?>        
        
        </td>
    </tr>
<?php } ?>

</table>

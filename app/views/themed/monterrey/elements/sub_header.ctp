<?php 
/**
 * Show a bar underneath the header with page-specific content.
 * 
 * @param $icon         the name of an image to use as the icon
 * @param $title        the title for the page
 * @param $description  a short description that appears underneath the title
 * @param $leaveOpen    a hack to add extra content at the end of the element.
 *                      set this to true and you need to close two divs.
 */
?>

<div id="hr-sub-header">
    <div class="hr-width-wrapper">

        <?php echo $this->element('search')?>

        <?php echo $html->image($icon, array('alt'=>__($title,true))); ?>

        <h2><?php echo $title ?></h2>

        <h3><?php echo $description?></h3>

<?php if(isset($leaveOpen) && $leaveOpen==true) {?>
        <!-- you need to close the two divs outside of here -->
<?php } else { ?>
    </div>
</div>
<?php } ?>
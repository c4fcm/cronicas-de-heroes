<?php 
$pageTitle = __("page.alreadyrejected",true);
$pageDescription = __("page.home.description",true);
$pageIcon = 'icon-none.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

    <?php echo $this->element('moderation-list-links')?>
    
    <?php echo $this->element('report_list',array('reportList'=>$reportList)) ?>
    
    <?php echo $this->element('pagination_controls'); ?>

</div>
<?php 
$this->set('title_for_layout', $pageTitle);
?>

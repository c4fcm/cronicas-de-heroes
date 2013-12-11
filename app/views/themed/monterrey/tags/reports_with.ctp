<?php 
$pageTitle = __($tagCategory['name'],true).": ".__($tag['name'],true);
$pageDescription = __("page.tagged_with.description",true);
$pageIcon = 'icon-browse.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">
    
    <?php echo $this->element('report_list',array('reportList'=>$reportList)) ?>
    
    <?php 
    print $this->element('pagination_controls');
    ?>

</div>
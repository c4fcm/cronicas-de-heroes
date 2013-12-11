<?php 
$pageTitle = __("page.report.browse",true);
$pageDescription = __("page.report.browse.description",true);
$pageIcon = 'icon-browse.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

<div class="hr-all-tags-list">
<?php 
foreach($allTagCategories as $tagCategory){
    echo $this->element('tag_category',
                    array('tagCategory'=>$tagCategory)
        );
}
?>
</div>

    <?php 
    
    echo $this->element('report_list',array('reportList'=>$reportList)); 

    echo $this->element('pagination_controls');
    
    ?>

</div>
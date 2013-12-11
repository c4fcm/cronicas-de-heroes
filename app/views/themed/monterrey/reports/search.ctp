<?php 
$pageTitle = __("page.report.searchresults",true);
$pageDescription = __("page.report.searchresults.description",true);
$pageIcon = 'icon-browse.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

<h2><?=$pageTitle?>: <?=$searchStr?></h2>

<?php echo $this->element('report_list',array('reportList'=>$reportList)) ?>

<?php 
print $this->element('pagination_controls');
?>

</div>
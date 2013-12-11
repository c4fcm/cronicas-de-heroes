<?php 
$pageTitle = __("page.report.searchresults",true);
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?>: <?=$searchStr?></h2>

<?php echo $this->element('report_list',array('reportList'=>$reportList)) ?>

<?php 
print $this->element('pagination_controls');
?>

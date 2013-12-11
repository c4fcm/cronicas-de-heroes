<?php 
$pageTitle = __("page.report.browse",true);
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?></h2>

<?php echo $this->element('report_list',array('reportList'=>$reportList)) ?>

<?php 
print $this->element('pagination_controls');
?>

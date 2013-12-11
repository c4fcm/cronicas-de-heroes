<?php 

/**
 * @param   reportlist  a list of reports to show
 */
?>

<div class="hr-report-list">

<?php
$i=0;
foreach($reportList as $report) { 
    $cssClass = 'hr-col-'.($i%3);
?>

<div class="hr-report <?=$cssClass?>  <?=$heroreports->moderatorStatusClass($isModerator, $report['Report']['status'])?>">

    <div class="hr-image-wrapper">
    <?php echo $html->link( $heroreports->smallImage($report) , 
                            array('moderator'=>false, 'controller' => 'reports','action'=>'view', 
                                   $report['Report']['id']),
                            array('escape'=>false));
    ?>
    </div>

    <h3>
    <?php echo $html->link( $report['Report']['name'] , 
                            array('moderator'=>false, 'controller' => 'reports','action'=>'view', 
                                   $report['Report']['id']))
    ?>
    </h3>

    <?php if($isModerator) {?>
        <p class="hr-report-details">
            <b><?php __('report.label.author') ?> <?=$report['Report']['author']?></b>
            <br/>
            <i><?php __('report.label.submittedtime') ?> <?=$time->niceShort($time->convert(strtotime($report['Report']['submitted_time']),-6))?></i>
        </p>
    <?php } ?>

    <p><?=$heroreports->shortBody($report['Report']['body'])?></p>   
    
    <p>
    <?php echo $html->link( __("report.readmore",true), 
                            array('moderator'=>false, 'controller' => 'reports','action'=>'view', 
                                   $report['Report']['id']),
                            array('class'=>"hr-read-more"));
    ?>
    </p> 

    <?php
    if($isModerator) {
        echo $this->element('report_moderate_buttons', array(
                'reportId'=>$report['Report']['id'],
                'status'=>$report['Report']['status'],
        ));
    }
    ?>

</div>

<?php 
    $i++;
}
?>

</div>
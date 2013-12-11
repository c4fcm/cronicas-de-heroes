<?php 

/**
 * @param   reportlist  a list of reports to show
 */
?>

<div class="hr-report-list">

<?php
$i=0;
foreach($reportList as $report) { 
    $i++;
    $cssClass = ($i%2==0) ? 'hr-odd' : 'hr-even';
?>

<div class="hr-report <?=$cssClass?>  <?=$heroreports->moderatorStatusClass($isModerator, $report['Report']['status'])?>">

    <?php echo $heroreports->smallImage($report); ?>

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
            <i><?php __('report.label.submittedtime') ?> <?=$time->niceShort($report['Report']['submitted_time'])?></i>
        </p>
    <?php } ?>

    <p><?=$heroreports->shortBody($report['Report']['body'])?></p>    

    <?php
    if($isModerator) {
        echo $this->element('report_moderate_buttons', array(
                'reportId'=>$report['Report']['id'],
                'status'=>$report['Report']['status'],
        ));
    }
    ?>

</div>

<?php } ?>

</div>
<?php 
$pageTitle = $report['Report']['name'];
$pageDescription = __("page.report.description",true);
$pageIcon = 'icon-browse.gif';
$this->set('title_for_layout', $pageTitle);
    echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

    <div class="hr-report-view <?=$heroreports->moderatorStatusClass($isModerator, $report['Report']['status'])?>">
    
    <div class="hr-report">
    
        <div class="hr-report-media">
            <?php print $this->element('report_audio_play',
                    array('report',$report)
                );
            ?>
            <?php print $heroreports->mediumImage($report); ?>
        </div>
    
        <h2><?=$report['Report']['name']?></h2>
    
        <div class="hr-fields">
    
        <?php
        if($isModerator) {
            echo $this->element('report_moderate_buttons', array(
                'reportId'=>$report['Report']['id'], 'status'=>$report['Report']['status'], 'allowDelete'=>true
            ));
        }
        ?>
    
            <p class="hr-report-body"><?=$report['Report']['body']?></p>
    
            <p class="hr-report-details">
            <b><?php __('report.label.when')?>:</b> <?=$time->format('n/j/Y',$report['Report']['submitted_time'])?>
            <br />
            <b><?php __('report.label.location')?>:</b> <?=$report['Report']['address']?>
            <br />
            
            <?php $heroreports->showTags($allTagCategories,$report['Tag']);?>
             
            <?php if($isModerator) { ?>
                <br />
                <b><?=$heroreports->status($report['Report']['status'])?></b>
            <?php } ?>
            </p>
    
        </div>
    
        <div class="hr-map-container">
            <div id="hr-view-map" class="hr-map"></div>
        </div>
    
    <?php if($isModerator) { ?>
    <div class="hr-report-status-history-list">
        <h4><?php __('reportstatushistory.list')?></h4>
        <table>
            <tr>
                <th><?php __('reportstatushistory.when')?></th>
                <th><?php __('reportstatushistory.status')?></th>
                <th><?php __('reportstatushistory.user')?></th>
            </tr>
            <?php
            $i=0; 
            foreach($statusHistoryList as $status){
                $i++;
                $cssClass = ($i%2==0) ? "even" : "odd";
            ?>
            <tr class="<?=$cssClass?>">
                <td><?= $time->nice($status['ReportStatusHistory']['time'])?></td>
                <td><?= $heroreports->status($status['ReportStatusHistory']['status'])?></td>
                <td><?= $status['User']['username']?></td>
            </tr>
                
            <?php
            }
            ?>
        </table>
    </div>
    <?php } ?>
    
    </div>
    
    </div>
    
    <script type="text/javascript">
    
    var hrMap;
    
    var report = <?=$javascript->object($report['Report']);?>
    
    function init(){
    
        hrMap = new HR.Map.Instance('hr-view-map');
    
        hrMap.addMarkerAtNormalLonLat(report.longitude, report.latitude);
    
        hrMap.setCenterAtNormalLonLat(report.longitude, report.latitude);
    
    }
    
    $(init);
    </script>

</div>
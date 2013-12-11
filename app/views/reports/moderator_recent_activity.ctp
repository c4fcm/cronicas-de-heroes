<?php 
$pageTitle = __("page.report.recentactivity",true);
$this->set('title_for_layout', $pageTitle);
?>

<h2><?=$pageTitle?></h2>

<?php echo $this->element('moderation-list-links')?>

<?php if($isModerator) { ?>
<div class="hr-report-status-history-list">
    <h4><?php __('reportstatushistory.list')?></h4>
    <table>
        <tr>
            <th><?php __('report.label.name')?></th>
            <th><?php __('reportstatushistory.when')?></th>
            <th><?php __('reportstatushistory.status')?></th>
            <th><?php __('reportstatushistory.user')?></th>
        </tr>
        <?php
        foreach($statusHistoryList as $status){
        ?>
        <tr class="<?=$heroreports->moderatorStatusClass(true, $status['ReportStatusHistory']['status'])?>">
            <td><?= $html->link($status['Report']['name'],array(
                'moderator'=>false,'controller'=>'reports','action'=>'view',$status['Report']['id']
            ))?></td>
            <td><?= $time->nice($status['ReportStatusHistory']['time'])?></td>
            <td><?= $heroreports->status($status['ReportStatusHistory']['status'])?></td>
            <td><?= ($status['ReportStatusHistory']['user_id']==null) ? __('noun.anonymous',true) : $status['User']['username']?></td>
        </tr>
            
        <?php
        }
        ?>
    </table>
</div>
<?php } ?>

<?php 
print $this->element('pagination_controls');
?>
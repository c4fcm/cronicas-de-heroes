<?php 

/**
 * @param   reportId    the id of the report to approve or reject
 * @param   status      the report's current status (used to show the right links)
 * @param   allowDelete  optionally show the delete button (not shown by default)
 */

$allowEdit = true;
$allowApprove = true;
$allowRequeue = true;
$allowReject = true;
if(!isset($allowDelete)){
    $allowDelete = false;
}

switch($status) {
    case Report::STATUS_APPROVED;
        $allowApprove = false;
        break;
    case Report::STATUS_REJECTED;
        $allowReject = false;
        break;
    case Report::STATUS_PENDING;
        $allowRequeue = false;
        break;
}

if($isModerator) {

?>

<div class="hr-report-moderation-controls">

<label><?php __('action.manage')?>:</label>

<?php
if($allowEdit){
    echo $html->link( __('action.edit',true), 
                            array('moderator'=>true, 
                                  'controller' => 'reports','action'=>'edit', $reportId));
}
                            
echo $form->create('Report', array('url'=>array('moderator'=>true,'controller'=>'reports','action'=>'approve')));
echo $form->hidden('id',array('value'=>$reportId));
echo $form->submit(__('action.approve',true),array('div'=>false,'disabled'=>!$allowApprove));
echo $form->end();    

echo $form->create('Report', array('url'=>array('moderator'=>true,'controller'=>'reports','action'=>'requeue')));
echo $form->hidden('id',array('value'=>$reportId));
echo $form->submit(__('action.requeue',true),array('div'=>false,'disabled'=>!$allowRequeue));
echo $form->end();    

echo $form->create('Report', array('url'=>array('moderator'=>true,'controller'=>'reports','action'=>'reject')));
echo $form->hidden('id',array('value'=>$reportId));
echo $form->submit(__('action.reject',true),array('div'=>false,'disabled'=>!$allowReject));
echo $form->end();    

if($allowDelete){
    echo $form->create('Report', array('url'=>array('moderator'=>true,'controller'=>'reports','action'=>'delete'),
                        'onSubmit' => "if(!confirmDelete".$reportId."()){ return false; }"));
    echo $form->hidden('id',array('value'=>$reportId));
    echo $form->submit(__('action.delete',true), array('div'=>false));
    echo $form->end();    
    ?>
    <script type="text/javascript">
    function confirmDelete<?=$reportId?>(){
        return confirm("<?php __('action.delete.confirm') ?>");   
    }
    </script>
    <?
}
?>

</div>

<?php 
}
?>
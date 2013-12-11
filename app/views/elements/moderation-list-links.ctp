<p class="hr-moderation-list-links">
[ 
<?php echo $html->link(__('link.seeall',true), 
                array('moderator'=>true,'controller' => 'reports','action'=>'all'))?>
 | 
<?php echo $html->link(__('link.seeapproved',true), 
                array('moderator'=>true,'controller' => 'reports','action'=>'approved'),
                array('class'=>$heroreports->moderatorStatusClass(true, Report::STATUS_APPROVED) )
                )?>
 | 
<?php echo $html->link(__('link.seepending',true), 
                array('moderator'=>true,'controller' => 'reports','action'=>'pending'),
                array('class'=>$heroreports->moderatorStatusClass(true, Report::STATUS_PENDING) )
                )?>
 | 
<?php echo $html->link(__('link.seerejected',true), 
                array('moderator'=>true,'controller' => 'reports','action'=>'rejected'),
                array('class'=>$heroreports->moderatorStatusClass(true, Report::STATUS_REJECTED) )
                )?>
 | 
<?php echo $html->link(__('link.seerecentactivity',true),
                array('moderator'=>true,'controller'=>'reports','action'=>'recentActivity'))?>
 ]
</p>

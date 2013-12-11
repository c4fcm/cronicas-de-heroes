
<?php
if(!empty($report['Report']['audio_file'])) {
    $audioSwfPath = Configure::Read('Server.URL').'swf/player.swf';
?>
    <div class="hr-report-audio">
        <?__('action.report.listen')?>
        <br />
        <object type="application/x-shockwave-flash" data="<?=$audioSwfPath?>" id="audioplayer1" height="24" width="400">
        <param name="movie" value="<?=$audioSwfPath?>">
        <param name="FlashVars" value="titles=<?php __('voicemail.playertext'); ?>&animation=no&playerID=audioplayer1&soundFile=<?=Configure::Read('Server.URL').
            'files/voicemail/'.$report['Report']['audio_file']?>">
        <param name="quality" value="high">
        <param name="menu" value="false">
        <param name="wmode" value="transparent">
        </object>
    </div>
<?php 
}
?>

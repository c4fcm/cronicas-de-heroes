<?php 

echo $javascript->link('jquery.cycle.all.min',false);

$pageTitle = __("page.home",true);
$pageDescription = __("page.home.description",true);
$pageDescription = sprintf($pageDescription,$approvedCount);
$pageIcon = 'icon-none.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
    'leaveOpen'=>true
));
?>

<div id="hr-featured-report-list-wrapper">

    <a href="#" id="hr-featured-report-prev"><?= $html->image('big-arrow-left.gif')?></a>
    <a href="#" id="hr-featured-report-next"><?= $html->image('big-arrow-right.gif')?></a>

    <div class="hr-report-list" id="hr-featured-report-list">
    <?php 
    foreach($recentReportList as $report){
    ?>
        <div class="hr-report">
            <h2><?=$report['Report']['name']?></h2>
            <p><?=$report['Report']['body']?></p>
            <?php echo $html->link( __("report.readmore",true), 
                                        array('moderator'=>false, 'controller' => 'reports','action'=>'view', 
                                               $report['Report']['id']),
                                        array('class'=>"hr-read-more"));
            ?>
        </div>
        
    <?php
    }
    ?>
    </div>

    <div id="hr-featured-report-nav-wrapper">
        <table cellpadding="0" cellspacing="0">
        <tr>
        <td><?= $html->image('nav-border-left.gif')?></td>
        <td><div id="hr-featured-report-nav"></div></td>
        <td><?= $html->image('nav-border-right.gif')?></td>
        </tr>
        </table>
    </div>
    
</div>

    </div>  <!-- closing the divs from the sub_header element -->
</div>

<script type="text/javascript">
$(
function(){
	$('#hr-featured-report-list').cycle({ 
	    fx:    'scrollHorz',
        next:  '#hr-featured-report-next',
        prev:  '#hr-featured-report-prev',
        pager: '#hr-featured-report-nav',
        timeout: 0
	});   
}
);
</script>

<div class="hr-width-wrapper">
    
        <!--  
        <div id="hr-home-recent" class="hr-sidebar-box">
            <h3><?php __('section.recentreports')?></h3>
            <ul>
            <?php foreach($recentReportList as $report){ ?>
                <li><?php echo $html->link( $report['Report']['name'] , 
                                    array('controller' => 'reports','action'=>'view', 
                                           $report['Report']['id']))
                ?></li>
            <?php }?>
            </ul>
        </div>
        -->
        
    <div style="margin-left:280px">
        <video id="hr-drama-movie" controls="controls" 
                src="<?=Configure::Read('Server.URL').'theme/monterrey/files/cdh-mty.mp4'?>" 
                poster="<?=Configure::Read('Server.URL').'theme/monterrey/img/drama-video-poster.jpg'?>" 
                height="360" width="640">
        </video>
        <script type="text/javascript"> 
        jwplayer("hr-drama-movie").setup({
            flashplayer: "<?=Configure::Read('Server.URL').'swf/jwplayer.swf'?>"
        });
        </script>
    </div>

</div>
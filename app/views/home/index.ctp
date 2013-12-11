<?php 
$pageTitle = __("page.home",true);
$this->set('title_for_layout', $pageTitle);
?>

<div class="hr-home-intro">

    <?php echo $this->element('homepage_intro');?>

    <div id="hr-home-map" class="hr-map"></div>
    
</div>

<div class="hr-home-sidebar">
    
    <div class="hr-large-button">
    <?php echo $html->link( __('home.largeinvitation',true) , 
                            array('controller' => 'reports','action'=>'create', ))?> 
    &rarr;
    </div>
    
    <div id="hr-home-featured-report" class="hr-sidebar-box">
        <img src="/img/map/marker-blue.png">
        <h3></h3>
        <p></p>
    </div>
    
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
    
</div>

<script type="text/javascript">

var hrMap;

var ar = {};
<?php
$reportViewUrl = $html->url(array('controller' => 'reports','action'=>'view'));

function getLocHashKey($report){
    $key = md5($report['Report']['longitude']."_".$report['Report']['latitude']);
    return $key;
}
    
$lonlatToCount = array(); 
foreach($reportList as $report){
    $key = getLocHashKey($report);
    if(!array_key_exists($key,$lonlatToCount)){
        $lonlatToCount[$key] = 0;
    }
    $lonlatToCount[$key]++;        
}

foreach($reportList as $report){
    $key = getLocHashKey($report);
?>  ar[<?=$report['Report']['id']?>] = <?=$javascript->object($report['Report']);?>;
    ar[<?=$report['Report']['id']?>]['sm'] = '<?=$heroreports->smallImage($report);?>';
    ar[<?=$report['Report']['id']?>]['dp'] = <?=$lonlatToCount[$key]?>;
<?php 
}
?> 

function showRandomMarker(){
    var marker = hrMap.getRandomMarker();
    var worked = false; // try not to highlight the same feature twice in a row
    var count = 0;      // make sure you don't get a "script takinng too long dialog"
    do {
        count ++;
        worked = hrMap.highlightFeature(marker.feature,{zoom:true});
    } while ((worked==false) && (count < 50));
    // now update the content on the sidebar
    $('#hr-home-featured-report').children('h3').html(
    	    '<a href="<?=$reportViewUrl?>/'+marker.feature.report.id+'">'+marker.feature.report.name+'</a>'
    );
    $('#hr-home-featured-report').children('p').html(marker.feature.report.body);
}

function init(){

    hrMap = new HR.Map.Instance('hr-home-map');

    for (reportId in ar){
        r = ar[reportId];
        hrMap.addMarkerAtNormalLonLat(r.longitude, r.latitude,
                   {report: r,
                    popupContent:'<h4 style="margin-bottom:5px;">'+
                       '<a href="<?=$reportViewUrl?>/'+r.id+'">'+
                	   r.name+'</a>'+r.sm+
                       '</h4>'+'<p>'+r.body+'</p>',
                    scatter:true,
                    scatterCount:r.dp,
                    zoomOnClick: true,
                    handleClicks: false
                   }
        );
    }

    showRandomMarker();
    setInterval(showRandomMarker, 5000);

}

$(init);
</script>
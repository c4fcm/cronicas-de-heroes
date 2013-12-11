<?php 
$pageTitle = __("page.map",true);
$pageDescription = __("page.map.description",true);
$pageIcon = 'icon-map.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

    <div id="hr-all-reports-map" class="hr-map"></div>
    
    <script type="text/javascript">
    
    var hrMap;
    
    var allReports = {};
    <?php 
    
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
    ?>  allReports[<?=$report['Report']['id']?>] = <?=$javascript->object($report['Report']);?>;
        allReports[<?=$report['Report']['id']?>]['smallImageTag'] = '<?=$heroreports->smallImage($report);?>';
        allReports[<?=$report['Report']['id']?>]['dupeLocCount'] = <?=$lonlatToCount[$key]?>;
    <?php 
    }
    ?> 
    
    function init(){
    
        hrMap = new HR.Map.Instance('hr-all-reports-map');
        hrMap.showControls();
    
        for (reportId in allReports){
            r = allReports[reportId];
            hrMap.addMarkerAtNormalLonLat(r.longitude, r.latitude,
                    {'report': r,
                    'popupContent':'<h4 style="margin-bottom:5px;">'+
                       '<a href="<?php echo $html->url( 
                               array('controller' => 'reports','action'=>'view'))?>/'+r.id+'">'+
                       r.name+'</a>'+r.smallImageTag+
                       '</h4>'+'<p>'+r.body+'</p>',
                    'scatter':true,
                    'scatterCount':r.dupeLocCount
                   }
            );
        }
    
    }
    
    $(init);
    </script>

</div>
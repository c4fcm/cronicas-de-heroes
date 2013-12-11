<?php 
$pageTitle = __("page.report.edit",true);
$pageDescription = __("page.report.edit.description",true);
$pageIcon = 'icon-submit.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<div class="hr-width-wrapper">

<?php print $session->flash(); ?>

<div class="hr-edit-form">
    
    <?php
        echo $form->create('Report', array('action' => 'edit','class'=>'hr-form',
                    'enctype' => 'multipart/form-data' ));
    ?>

    <div class="hr-report">
    
        <div class="hr-fields">
        <?php
            echo "<div class=\"hr-status\">".$heroreports->status($report['Report']['status'])."</div>";
            echo $form->input('name', array('label'=>__('report.label.name',true)));
            echo $form->input('body', array('label'=>__('report.label.body',true),'rows' => '8'));
            echo $form->label('audio',__('report.label.audio',true));
            echo $this->element('report_audio_play',
                array('report',$report)
            );            
            echo $form->input('author', array('label'=>__('report.label.author',true)));
            echo $form->input('address', array('label'=>__('report.label.location',true)));
            echo $form->input('submitted_time', array('label'=>__('report.label.submittedtime',true)));
        ?>  <div class="input">
        <?php 
            echo $heroreports->smallImage($report);
            echo $form->label('imageMeta', __('report.label.image',true));
            echo $form->hidden('picture');
            echo $form->file('imageMeta');
            if($heroreports->hasPicture($report)){
                echo $html->link( __('action.removepicture',true), 
                            array('moderator'=>true, 
                                  'controller' => 'reports','action'=>'removePicture', $report['Report']['id']));
            }
        ?>  </div>
        <?php 
        foreach($allTagCategories as $category){
            $tags = $category['Tag'];
            
            $tagOptionsList = array();
            $selected = null;
            foreach($tags as $t){
                $tagOptionsList[$t['id']] = __d("tags",$t['name'],true);
                foreach($report['Tag'] as $usedTag){
                    if($usedTag['id']==$t['id']){
                        $selected = $t['id']; 
                    }
                }
            }
            
        ?>  <div class="input">
        <?php 
            echo $form->label(__d("tags",$category['TagCategory']['name'],true));
            echo $form->select('category'.$category['TagCategory']['id'],$tagOptionsList,
                $selected, array());
        ?>  </div>
        <?php
        }
        
        ?>
            
        <?php
            echo $form->hidden('id');
            echo $form->hidden('status');
            echo $form->hidden('latitude');
            echo $form->hidden('longitude');
            echo $form->hidden('clickedMap',array('value'=>0));
        ?>
        </div>

        <div class="hr-map-container">
            <label><?php __('report.label.map')?></label>
            <div id="hr-edit-map" class="hr-map"></div>
        </div>

    </div>

    <div class="hr-controls-container">
    <?php
        echo $form->submit(__('action.submit',true));
    ?>
    </div>

    <?php 
    echo $form->end();
    ?>

<br />
<?php
echo $this->element('report_moderate_buttons', array(
    'reportId'=>$report['Report']['id'],
    'status'=>$report['Report']['status']
));
?>

</div>

<script type="text/javascript">

var hrMap;

//var report = <?=$javascript->object($this->data['Report']);?>

/**
 * This will update the map with the place clicked, and set the form
 * value correctly.
 */
function setReportLoc(hrMapInstance, ll){
    if(!hrMapInstance.isWithinBoundaries(ll)){
        alert("<?=$outsideMapBoundaryErrMsg?>");
        hrMapInstance.setCenter( hrMapInstance.toMapLonLat(HR.Map.GetDefaultLonLat()) );
        return;    
    }
    // remove the existing marker and place a new one
    hrMapInstance.removeAllMarkers();
    hrMapInstance.addMarker(ll);
    // now set the form value too
    var fixedLonLat = hrMapInstance.toNormalLonLat( ll );
    $('#ReportLatitude').val(fixedLonLat.lat);
    $('#ReportLongitude').val(fixedLonLat.lon);
    $('#ReportClickedMap').val(1);
}

/**
 * Set up the map so that people can click to pick the location for their report
 */
function init(){

    // create the map
	hrMap = new HR.Map.Instance('hr-edit-map');

    // center it on the current report location
    var normalLonLat = new OpenLayers.LonLat($('#ReportLongitude').val(), $('#ReportLatitude').val());
    var mapLonLat = hrMap.toMapLonLat(normalLonLat);
    hrMap.setCenter(mapLonLat);
    setReportLoc(hrMap, mapLonLat);

    // move the location when the user clicks
    hrMap.addClickHandler(setReportLoc);
    $('#ReportClickedMap').val(0);

    // tweak it for moderators
    hrMap.showControls();
    hrMap.showBoundaryPolygon();

}

$(init);
</script>

</div>
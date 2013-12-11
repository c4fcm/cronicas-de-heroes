<?php 
$pageTitle = __("page.report.create",true);
$pageDescription = __("page.report.create.description",true);
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
    
    <div class="hr-create-form">
    
        <?php
            echo $form->create('Report', array('action' => 'create','class'=>'hr-form', 'id'=>'hr-create-report-form',
                'enctype' => 'multipart/form-data'));
        ?>
    
        <div class="hr-report">
    
            <div class="hr-fields">
            <?php
                echo $form->input('name', array('label'=>__('report.label.name',true)));
                echo $form->input('body', array('label'=>__('report.label.body',true),'rows' => '8'));
                echo $form->input('author', array('label'=>__('report.label.author',true)));
                echo $form->input('address', array('label'=>__('report.label.location',true)));
            ?>  <div class="input">
            <?php 
                echo $form->label('imageMeta', __('report.label.image',true));
                echo $form->file('imageMeta');
            ?>  </div>
            <?php 
                echo $form->hidden('latitude');
                echo $form->hidden('longitude');
                echo $form->hidden('clickedMap',array('value'=>0));
            ?>
            
            <?php 
            foreach($allTagCategories as $category){
                $tags = $category['Tag'];
                
                $tagOptionsList = array();
                foreach($tags as $t){
                    $tagOptionsList[$t['id']] = __d("tags",$t['name'],true);
                } 
                
            ?>  <div class="input">
            <?php 
                echo $form->label(__d("tags",$category['TagCategory']['name'],true));
                echo $form->select('category'.$category['TagCategory']['id'],$tagOptionsList,
                    null, array());
            ?>  </div>
            <?php
            }
            
            ?>
            
            <?php 
            if(Configure::Read('Gui.RequireCaptcha')) {
                echo $form->label('captcha', __('report.label.captcha',true)); 
                echo $this->element('image_and_audio',array('plugin'=>'captcha'));
                echo $form->input('captcha',array('label'=>"","size"=>15,"style"=>"width:auto;"));
            } 
            ?>
    
            </div>
    
            <div class="hr-map-container required">
                <label><?php __('report.label.where')?></label>
                <div id="hr-create-map" class="hr-map"></div>
                <small><?php __('report.label.whereDescription')?></small>
            </div>
                
        </div>
        
        <div class="hr-controls-container">
            <?php
                echo $form->submit(__('action.submit',true), array('onClick' => "$(this).addClass('disabled');"));
            ?>
        </div>
    
        <?php 
        echo $form->end();
        ?>
    
    </div>

</div>


<script type="text/javascript">

// this page's instance of a standard Heroreports map object
var hrMap;

/**
 * This will update the map to move the marker icon to the 
 * the location clicked, and set the form values for lon/lat 
 * correctly.
 */
function setReportLoc(hrMapInstance, ll){
    if(!hrMapInstance.isWithinBoundaries(ll)){
        alert("<?=$outsideMapBoundaryErrMsg?>");
        return false;    
    }
    // lazy: remove the existing markers and place a new one
    hrMapInstance.removeAllMarkers();
    hrMapInstance.addMarker(ll);
    // now set the form value too
    var fixedLonLat = hrMapInstance.toNormalLonLat( ll );
    $('#ReportLatitude').val(fixedLonLat.lat);
    $('#ReportLongitude').val(fixedLonLat.lon);
    // and tell the server the user actually clicked to pick a 
    // location (ie. they didn't use the default one)
    $('#ReportClickedMap').val(1);
    return true;
}

/**
 * Set up the map so that people can click to pick the 
 * location for their report and have that save correctly.
 */
function initMap(){
    hrMap = new HR.Map.Instance('hr-create-map');
    hrMap.showControls();
    hrMap.addClickHandler(setReportLoc);
    setReportLoc(hrMap, hrMap.getCenter() );
    $('#ReportClickedMap').val(0);
}

// run some setup once the page is loaded
$(initMap);
$(initAutocomplete);

var _acAddressToLoc = {};

function initAutocomplete() {
    var boundsCorners = HR.Map.GetBoundaryRegionCorners();
    var googleGeocodingBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(boundsCorners.sw.lat, boundsCorners.sw.lon),
            new google.maps.LatLng(boundsCorners.ne.lat, boundsCorners.ne.lon)
            );
    $('#ReportAddress').autocomplete({
        'minLength': 3,
        '_acAddressToLoc': {},  // stores results from google geocaching call
        /**
         * Hit google to geocode the address the user inputs
         */
         'source': function(req, respcb) {
            var plc = req.term;
            var gc = new google.maps.Geocoder();
            var _cb = respcb;
            gc.geocode({'address': plc,
                'bounds': googleGeocodingBounds
                }, function(results) {
                var sugg = [];
                _acAddressToLoc = {};
                if(results && results.length) {
                    for(var i=0; i<results.length; i++) {
                        sugg.push(results[i].formatted_address);
                        _acAddressToLoc[results[i].formatted_address] = results[i].geometry.location;
                    }
                }
                return _cb(sugg);
            });
        },
        /**
         * When they select an item from autocomplete, update the map and hidden input fields
         */
        'select': function(event,ui) {
            var loc = _acAddressToLoc[ui.item.value];
            var normalLon = loc.lng();
            var normalLat = loc.lat();
            var olLoc = new OpenLayers.LonLat(normalLon, normalLat);
            var mapLonLat = hrMap.toMapLonLat( olLoc );
            var validLoc = setReportLoc(hrMap, mapLonLat);
            if(!validLoc){
                event.preventDefault();    // don't update the input field
            }
        }
    });
}

</script>

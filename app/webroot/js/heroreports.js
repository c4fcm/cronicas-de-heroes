
/**
 * Wrapper for all custom Heroreports js code
 */
HR = {
	version: 0.2
};

/**
 * Define some constants that are useful for mapping in general
 */
HR.Map = {
    CLOUDMADE_KEY: "3bb82639a274433fb30120279ea08c76",
	defaultLon: 0, 
    defaultLat: 0, 
	defaultZoom: 12,
	boundaryRegionVerticies: null,
	boundaryRegionCorners: null
};

/**
 * Define some constants for images used on the map
 */
HR.Map.Images = {
    SELECTED_MARKER: '/img/map/marker-purple.png',
    NORMAL_MARKER: '/img/map/marker-blue.png',
	MARKER_SIZE: 20,
	MARKER_BIG_SIZE: 40
};

/**
 * (REQUIRED) Call this in your heroreports-config.js to set the
 * longitude and latitude to center the map on 
 * @param {double} lon
 * @param {double} lat
 */
HR.Map.SetDefaultLonLat = function(lon,lat) {
    HR.Map._defaultLon = lon;
    HR.Map._defaultLat = lat;
};

HR.Map.GetDefaultLonLat = function(){
	return new OpenLayers.LonLat(HR.Map._defaultLon,HR.Map._defaultLat);
}

/**
 * (Optional) Call this in your heroreports-config.js to override the default 
 * zoom level for maps displayed throughout the site.
 * @param {int} zoom
 */
HR.Map.SetDefaultZoom = function(zoom) {
	HR.Map.defaultZoom = zoom;
}

/**
 * (Optional) Call this to define a boundary area for reports.  Users will
 * not be able to place reports outside of this geographical polygon.
 * @param {Array} verticies
 */
HR.Map.SetBoundaryRegion = function(verticies) {
	HR.Map.boundaryRegionVerticies = [];
	for (idx in verticies){
		var lonlat = verticies[idx];
		HR.Map.boundaryRegionVerticies.push( new OpenLayers.LonLat(lonlat[0],lonlat[1]) );
	}
};

/**
 * Does the current map have a boundary region defined (reports can only
 * be located inside the boundary).
 * @return  boolean
 */
HR.Map.HasBoundaryRegion = function() {
	return (HR.Map.boundaryRegionVerticies!=null);
};

/**
 * Get the verticies of the boundary on the map.  
 * @return  {Array} an array of OpenLayers LonLat objects 
 */
HR.Map.GetBoundaryRegion = function() {
	return HR.Map.boundaryRegionVerticies;
};

HR.Map.SetBoundaryRegionCorners = function(arr) {
    HR.Map.boundaryRegionCorners = arr;
}

HR.Map.GetBoundaryRegionCorners = function() {
	return HR.Map.boundaryRegionCorners;
}

/**
 * Get the projection for humans to understand lonlat pairs
 * @return  {OpenLayers.Projection}
 */
HR.Map.GetNormalProjection = function() {
	return new OpenLayers.Projection("EPSG:4326"); 
};

/**
 * Factory method to create a default OpenLayers map
 * @param {String}  divId    the id of the div to replace with a map
 * @param {int}     zoom     the zoom level to set on the map
 */
HR.Map.CreateDefault = function(divId, zoom) {
    var mapLayer = new OpenLayers.Layer.CloudMade("CloudMade", { 
        key: HR.Map.CLOUDMADE_KEY, 
        styleId: 4993,
        sphericalMercator:true
        }); 
    var map = new OpenLayers.Map(divId, { controls: [ ] });
    map.addLayer( mapLayer );
    var normalProjection = HR.Map.GetNormalProjection();
    var center = HR.Map.GetDefaultLonLat().transform(
            normalProjection, map.getProjectionObject());
    map.setCenter(center, zoom);
    return map;
};

/**
 * A useful wrapper class for all maps on the Heroreports website
 */
HR.Map.Instance = OpenLayers.Class({

    // the actual OpenLayers map
	_olMap:null,
	
	// what popup feature is currently showing
	_currentFeature: null, 
	
	// shortcut to the boundary polygon
	_boundaryFeature: null,

	/**
	 * Constructor
	 * @param {String} divId
	 * @param {Object} options
	 */
	initialize: function(divId, options) {
        var defaultMapOptions = {'zoom': HR.Map.defaultZoom};
        OpenLayers.Util.extend(defaultMapOptions, options);
		this._olMap = HR.Map.CreateDefault(divId, defaultMapOptions.zoom); 
        // set up the boundary region
        if ( HR.Map.HasBoundaryRegion() ) {
            // draw the boundary polygon
            var vectorLayer = new OpenLayers.Layer.Vector("Boundaries");
            var verticies = HR.Map.GetBoundaryRegion();
            var points = [];
            for (var p = 0; p < verticies.length; p++) {
                var newLonLat = this.toMapLonLat(verticies[p]);
                points.push(new OpenLayers.Geometry.Point(newLonLat.lon, newLonLat.lat));
            }           
            var linearRing = new OpenLayers.Geometry.LinearRing(points);
            var polygonStyle = {
                strokeColor: "#000000",
                strokeOpacity: 0.5,
                strokeWidth: 1,
                fillColor: "#000000",
                fillOpacity: 0.2
            };
            var polygon = new OpenLayers.Geometry.Polygon([linearRing]);
            this._boundaryFeature = new OpenLayers.Feature.Vector(polygon,null, polygonStyle);
            vectorLayer.addFeatures([this._boundaryFeature]);
            vectorLayer.setVisibility(false);
			this._olMap.addLayer(vectorLayer);
			
        }       
        // set up marker layer
        this._olMap.addLayer( new OpenLayers.Layer.Markers("Markers") );
        
		// hack to fix weird marker offset bug
		this._olMap.updateSize();
	},

    showControls: function(){
        this._olMap.addControl( new OpenLayers.Control.PanZoomBar() );
		//var dragControl = new OpenLayers.Control.DragFeature(this._getMapLayer());
		//this._olMap.addControl( dragControl );
        //dragControl.activate();
	},

    showBoundaryPolygon: function() {
        this._getBoundaryLayer().setVisibility(true);
	},
	
	_getMapLayer: function() {
		return this._olMap.getLayersByName('CloudMade')[0];
	},
	
    /**
     * Get the layer to put all boundaries on on
     */
    _getBoundaryLayer: function() {
        return this._olMap.getLayersByName('Boundaries')[0];
    },	
	
	/**
	 * Get the layer to put all markers on
	 */
	_getMarkerLayer: function() {
		return this._olMap.getLayersByName('Markers')[0];
	},
	
	/**
	 * Return the current center of the map as a OpenLayers LonLat object
	 */
	getCenter: function() {
		return this._olMap.getCenter();
	},
	
	/**
	 * Center the map on a location (OpenLayers LonLat object)
	 * @param {Object} mapLonLat
	 */
	setCenter: function(mapLonLat) {
		this._olMap.setCenter(mapLonLat);
	},
	
	/**
	 * Center the map on a "normal" long/lat pair
	 * @param {Object} normalLon
	 * @param {Object} normalLat
	 */
	setCenterAtNormalLonLat: function(normalLon,normalLat) {
		var normalLonLat = new OpenLayers.LonLat(normalLon, normalLat);
        var mapLonLat = this.toMapLonLat(normalLonLat);
        this.setCenter(mapLonLat);
	},
	
	/**
	 * Translate an OpenLayers LonLat object from map coordinates to human-readable
	 * 'normal' longitude and latitude 
	 * @param {Object} mapLonLat
	 */
	toNormalLonLat: function(mapLonLat) {
        return mapLonLat.transform(this._olMap.getProjectionObject(), HR.Map.GetNormalProjection());
	},
	
	/**
	 * Translate an OpenLayers LonLat object from human-readable 'normal' longitude
	 * and latitude to map coordinates 
	 * @param {Object} normalLonLat
	 */
	toMapLonLat: function(normalLonLat){
		return normalLonLat.transform(HR.Map.GetNormalProjection(), this._olMap.getProjectionObject());
	},
		
	/**
	 * Remove all the markers on the normal marker layer
	 */
	removeAllMarkers: function(){
        this._getMarkerLayer().clearMarkers();
	},
	
	/**
	 * Return true if the lon/lat passed in is within the boudaries set on the map.
	 * Returns true if there are no boundaries set.
	 * @param {Object} mapLonLat   a map-space lon/lat object
	 */
	isWithinBoundaries: function(mapLonLat) {
		if(this._boundaryFeature==null) {
			return true;
		}
        var p = new OpenLayers.Geometry.Point(mapLonLat.lon, mapLonLat.lat);
        var isContained = this._boundaryFeature.geometry.containsPoint(p);
		return isContained;
	},
	
	/**
	 * Add a marker with some info
	 * @param {Object} normalLon
	 * @param {Object} normalLat
	 * @param {Object} options
	 */
    addMarkerAtNormalLonLat: function(normalLon,normalLat,options) {
        var normalLonLat = new OpenLayers.LonLat(normalLon, normalLat);
        var mapLonLat = this.toMapLonLat(normalLonLat);
        this.addMarker(mapLonLat,options);
    },
    
	/**
	 * Add a maker with some info
	 * @param {Object} ll          a map-based OpenLayers.LonLat object
	 * @param {Object} options     specify popup content and configuration
	 */
	addMarker: function(ll,options) {
        var markerOptions = {};
		if (options != null) {
			markerOptions = {
                showCloseBox: true,
                allowOverflow: false,
                popupClass: OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
                    autoSize: false,
					panMapIfOutOfView: true
                }),
                popupContent: '',
				scatter: false,
				scatterCount: 0,
				handleClicks: true,
				zoomOnClick: false
            };
            OpenLayers.Util.extend(markerOptions, options);
		}
        var mapMarkerLayer = this._getMarkerLayer();
		var lonLat = ll;

        // HACK: randomly distribute stacked markers inside the bounds  
        if( (markerOptions.scatter==true) && (markerOptions.scatterCount>0) ){
			var attempts = 0;
            var withinBound = false;
            do {
                // DOUBLE HACK: this math is highly tuned to the Juarez site
                var addinLon = Math.random() * markerOptions.scatterCount * 10 + 2000*Math.random();
                addinLon = addinLon - (markerOptions.scatterCount*10 + 2000)/2;
                var addinLat = Math.random() * markerOptions.scatterCount * 10 + 2000*Math.random();
                addinLat = addinLat - (markerOptions.scatterCount*10 + 2000)/2;

                var randomLonLat = ll.add(addinLon, addinLat);
                lonLat = randomLonLat;
                attempts++;
            }
            while (!this.isWithinBoundaries(lonLat) && (attempts < 5));
            // TRIPLE HACK: force any markers still outside the bounds to be stacked at the map center
			if (!this.isWithinBoundaries(lonLat)) {
				lonLat = new OpenLayers.LonLat(this.getCenter().lon, this.getCenter.lat);
			}
		}

		// set up the marker icon
		var feature = new OpenLayers.Feature(mapMarkerLayer, lonLat); 
        var size = new OpenLayers.Size(HR.Map.Images.MARKER_SIZE, HR.Map.Images.MARKER_SIZE);
        //var offset = new OpenLayers.Pixel(-25,-25); // this is confusing, why do I need this?
        feature.data.icon = new OpenLayers.Icon(HR.Map.Images.SELECTED_MARKER, size/*, offset*/);
        marker = feature.createMarker();
		marker.feature = feature;

        // add in any optional popup info and make it clickable
		if( markerOptions != null ){
            feature.closeBox = markerOptions.showCloseBox; 
			feature.popupClass = markerOptions.popupClass;
			feature.data.popupContentHTML = markerOptions.popupContent;
			feature.data.overflow = (markerOptions.allowOverflow) ? "auto" : "hidden";
			feature.hrMapInstance = this;
			if(markerOptions.report) {
				feature.report = markerOptions.report;
			}
			if (markerOptions.handleClicks) {
				var markerClick = function(evt){
					this.hrMapInstance.highlightFeature(this, {
						zoom: markerOptions.zoomOnClick
					});
					OpenLayers.Event.stop(evt);
				};
				marker.events.register("mousedown", feature, markerClick);
			}
		}
		
		// now add it to the map
        mapMarkerLayer.addMarker(marker);
	},
	
	getRandomMarker: function() {
		var markerLayer = this._getMarkerLayer(); 
		var randomIdx = Math.round(Math.random()*markerLayer.markers.length) % markerLayer.markers.length;
        var randomMarker = markerLayer.markers[randomIdx];
		return randomMarker; 
	},
	
    _unHighlightFeature: function(feature){
		if (feature.popup.visible()) {
            feature.popup.toggle();
		}
        $(feature.marker.icon.imageDiv).children('img').attr('src', HR.Map.Images.SELECTED_MARKER);
        feature.hrMapInstance._setCurrentFeature(null);
		$(feature.marker.icon.imageDiv).children("img").animate({
            height: HR.Map.Images.MARKER_SIZE+"px",
            width: HR.Map.Images.MARKER_SIZE+"px"
        }, 500 );
	},
	
	highlightFeature: function(feature,options) {
        if(feature==this._getCurrentFeature()){
            return false;
        }

        var highlightOptions = {
                zoom: false
            };
        OpenLayers.Util.extend(highlightOptions, options);

        if (highlightOptions.zoom) {
			this._olMap.zoomTo(13);
		}
		// hide any showing popup;
        if(this._hasCurrentFeature()){
            this._unHighlightFeature( this._getCurrentFeature() );
        }
        // make the popup if you need to
        if (feature.popup == null) {
            feature.popup = feature.createPopup(feature.closeBox);
            feature.popup.anchor = feature.data.icon;
            feature.hrMapInstance.getRawMap().addPopup(feature.popup);
            feature.popup.show();
        } else {
            feature.popup.toggle();
        }
		// fix the icon
		$(feature.marker.icon.imageDiv).children('img').attr('src', HR.Map.Images.NORMAL_MARKER);
        feature.hrMapInstance._setCurrentFeature(feature);
		/*if ($(feature.marker.icon.imageDiv).css('topORIG') == null) {
			// gotta save the orig location so we can keep the icon centered as we scale it up/down
			var top = $(feature.marker.icon.imageDiv).css('top').replace("px","");
			$(feature.marker.icon.imageDiv).attr('topORIG', top);
			var left = $(feature.marker.icon.imageDiv).css('left').replace("px","");
			$(feature.marker.icon.imageDiv).attr('leftORIG', left);
		}*/
		var xyMove = (HR.Map.Images.MARKER_BIG_SIZE - HR.Map.Images.MARKER_SIZE)/2;
		$(feature.marker.icon.imageDiv).children("img").animate({
            height: HR.Map.Images.MARKER_BIG_SIZE+"px",
            width: HR.Map.Images.MARKER_BIG_SIZE+"px"
        }, 500 );
		return true;
	},
	
	_setCurrentFeature: function(feature){
		this._currentFeature = feature;
	},
	
	_getCurrentFeature: function() {
		return this._currentFeature;
	},
	
	_hasCurrentFeature: function() {
		return (this._getCurrentFeature()!=null);
	},
	
	/**
	 * Add a callback function that will be called when the map is clicked.
	 * There are two args passed to the callback - this object, and a OpenLayers
	 * LonLat object.
	 * @param {Object} callbackFunc
	 */
	addClickHandler: function(callbackFunc) {
        clickHandler = new HR.Map.ClickControl(this, callbackFunc);
		this._olMap.addControl(clickHandler);
		clickHandler.activate();
	},
	
	/**
	 * Get access to the underlying "raw" map object, which happens to be an
	 * OpenLayers Map object right now because that is the engine we're using.
	 */
	getRawMap: function() {
		return this._olMap;
	}
	
});

/**
 * Handles a single click on a map by invoking a callback you pass
 * in to the constructor.  The callback is called when a single click
 * is map, and passed the HR.Map.Instance and the map-based LonLat
 * object.
 */
HR.Map.ClickControl = OpenLayers.Class(OpenLayers.Control, {                
    
	_callback: null,
    
	_defaultHandlerOptions: {
        single: true,
        'double': false,
        pixelTolerance: 0,
        stopSingle: false,
        stopDouble: false
    },
	
	_hrMapInstance:null,
    
	initialize: function(hrMapInstance, locHandlerCallback) {
        this.handlerOptions = OpenLayers.Util.extend(
            {}, this._defaultHandlerOptions
        );
        OpenLayers.Control.prototype.initialize.apply(
            this, arguments
        ); 
        this.handler = new OpenLayers.Handler.Click(
            this, {
                'click': this._trigger
            }, this.handlerOptions
        );
		this._hrMapInstance = hrMapInstance;
		this._callback = locHandlerCallback;
    }, 

    _trigger: function(e) {
        var lonlat = this._hrMapInstance.getRawMap().getLonLatFromViewPortPx(e.xy);
        this._callback(this._hrMapInstance, lonlat);
    }

});

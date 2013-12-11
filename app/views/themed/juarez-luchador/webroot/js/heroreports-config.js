
/**
 * Set the longitude and latitude where all the maps should be
 * centered.
 * @arg     lon    the longitude of the center
 * @arg     lat    the latitude of the center
 */
HR.Map.SetDefaultLonLat(-106.425624,31.70);

/**
 * Set up a polygon that defines the area reports must be inside of.
 * This lets you make sure people don't create reports someplace else
 * on the map.  
 * @arg     endpoints   an array of arrays, each with two elements,
 *                      indicating the lon/lat of the verticies of 
 *                      a polygon
 */
HR.Map.SetBoundaryRegion([
	[-106.588088,31.779217],
	[-106.534188,31.777685],
	[-106.522773,31.766448],
	[-106.519339,31.766156],
	[-106.51479,31.756378],
	[-106.511357,31.755648],
	[-106.494277,31.743168],
	[-106.475652,31.746379],
	[-106.457713,31.759297],
	[-106.432994,31.748204],
	[-106.385444,31.72616],
	[-106.377204,31.706959],
	[-106.35463,31.691551],
	[-106.337035,31.655103],
	[-106.307853,31.613597],
	[-106.286395,31.587301],
	[-106.341891,31.58609],
	[-106.40506,31.581942],
	[-106.482595,31.605644],
	[-106.588088,31.779217]
]);

/**
 * Set up a box within which the google geocoding will prefer to check first.
 * This won't limit the space like the boundary region, but will help
 * the autocomplete lookup on the create page.
 */
HR.Map.SetBoundaryRegionCorners({
	'sw': {'lon':-106.618195,'lat':31.500117},
    'ne': {'lon':-106.230926,'lat':31.834399}
});

/**
 * Change the default map zoom level for most maps.
 */
HR.Map.SetDefaultZoom(12);
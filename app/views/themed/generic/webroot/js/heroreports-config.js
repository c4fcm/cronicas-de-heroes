
/**
 * Set the longitude and latitude where all the maps should be
 * centered.
 * @arg     lon    the longitude of the center
 * @arg     lat    the latitude of the center
 */
HR.Map.SetDefaultLonLat(-71.101584, 42.363618);

/**
 * Set up a polygon that defines the area reports must be inside of.
 * This lets you make sure people don't create reports someplace else
 * on the map.  
 * @arg     endpoints   an array of arrays, each with two elements,
 *                      indicating the lon/lat of the verticies of 
 *                      a polygon
 */
HR.Map.SetBoundaryRegion([
    [-71.07999801635742,42.36181016806277],
	[-71.10018117523193,42.36745908443492],
	[-71.10888004302979,42.353755223840494],
	[-71.09154224395752,42.35492864610414]
]);

/**
 * Set up a box within which the google geocoding will prefer to check first.
 * This won't limit the space like the boundary region, but will help
 * the autocomplete lookup on the create page.
 */
/*HR.Map.SetBoundaryRegionCorners({
    'sw': {'lon':-106.618195,'lat':31.500117},
    'ne': {'lon':-106.230926,'lat':31.834399}
});*/

/**
 * Change the default map zoom level for most maps.
 */
HR.Map.SetDefaultZoom(14);

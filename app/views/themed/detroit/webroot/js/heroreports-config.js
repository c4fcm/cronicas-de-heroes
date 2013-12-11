
/**
 * Set the longitude and latitude where all the maps should be
 * centered.
 * @arg     lon    the longitude of the center
 * @arg     lat    the latitude of the center
 */
HR.Map.SetDefaultLonLat(-83.0458333, 42.3313889);

/**
 * Set up a polygon that defines the area reports must be inside of.
 * This lets you make sure people don't create reports someplace else
 * on the map.  
 * @arg     endpoints   an array of arrays, each with two elements,
 *                      indicating the lon/lat of the verticies of 
 *                      a polygon
 */
/*HR.Map.SetBoundaryRegion([
	[-86,45],
	[-80,45],
	[-116.748962,32.838058],
	[-116.748962,32.284811],
    [-117.314758,32.284811]
]);
*/
/**
 * Set up a box within which the google geocoding will prefer to check first.
 * This won't limit the space like the boundary region, but will help
 * the autocomplete lookup on the create page.
 */
/*
HR.Map.SetBoundaryRegionCorners({
	'sw': {'lon':-117.314758,'lat':32.284811},
    'ne': {'lon':-116.748962,'lat':32.838058}
});
*/
/**
 * Change the default map zoom level for most maps.
 */
HR.Map.SetDefaultZoom(10);
$(document).ready(function(){
  L.mapbox.accessToken = 'pk.eyJ1IjoiZ3JlZ2dhd2F0dCIsImEiOiJjaWppNGpzZm4wMnZxdHRtNWNuaHFsOWE5In0.XZJCOdDSALLBYWBt4bHmlw';
  var map = L.mapbox.map('map', 'mapbox.streets', {attributionControl: false})
      .setView([0, 40], 6)
  var unclustered = L.mapbox.featureLayer();
  var clustered = L.markerClusterGroup();
  var counties = ""

  var projectPerCounty = {}

  var myIcon = L.mapbox.marker.icon({
    'marker-size': 'large',
    'marker-color': '#fa0'
  })

  function popUp(element){
    return "<b>County:</b> " + element["County"] + "</br></br>" +
        "<b>Number of enrolled facilities:</b> " + element["Facilities"] + "</br></br>" +
        "<b>Total Number of enrolled patients in the county:</b> " + element["Patients"] + "</br></br>"
  }

  function drawCounties(){
    $.ajax({
      type: "GET",
      url: `${base_url}kenya-sponsored-map/data/counties.geojson`,
      dataType: "text",
      success: function(data){
        counties = JSON.parse(data)
        L.geoJson(counties,  {
          style: getStyle,
        }).addTo(map);
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        map.boxZoom.disable();
      }
    });
  }


  function getStyle(feature) {
    return {
      weight: 2,
      opacity: 0.1,
      color: 'black',
      fillOpacity: 0.7,
      fillColor: getColor(projectPerCounty[feature.properties.COUNTY_NAM])
    };
  }

  function getColor(d) {
    return d > 300 ? '#8c2d04' :
        d > 200  ? '#cc4c02' :
            d > 100  ? '#ec7014' :
                d > 70  ? '#fe9929' :
                    d > 50   ? '#fec44f' :
                        d > 30   ? '#fee391' :
                            d > 10   ? '#fff7bc' :
                                '#ffffe5';
  }

  function getLegendHTML() {
    var grades = [0, 10, 30, 50, 70, 100, 200, 300],
        labels = [],
        from, to;

    for (var i = 0; i < grades.length; i++) {
      from = grades[i];
      to = grades[i + 1];

      labels.push(
          '<li><span class="swatch" style="background:' + getColor(from + 1) + '"></span> ' +
          from + (to ? '&ndash;' + to : '+')) + '</li>';
    }

    return '<span>Patients Per County</span><ul>' + labels.join('') + '</ul>';
  }

  populateClusteredMap = function () {
    $.ajax({
      type: "GET",
      url: `${base_url}kenya-sponsored-map/data/rows.csv`,
      dataType: "text",
      success: function(data){
        console.log(data);
        projectPerCounty = {}
        locations = $.csv.toObjects(data);
        locations.forEach(function(element, index){
          projectPerCounty[element["County"]] = element['Patients'];
          lat_long = element.Location.replace(/[()]/g, '').replace(/\s/g, '').split(',')
          if(typeof lat_long[0] === 'undefined' || typeof lat_long[1] === 'undefined'){
            console.log(element.County + " does not have valid location data, skipping")
          } else {
            var marker = L.marker([lat_long[0], lat_long[1]], {
              icon: myIcon
            }).bindPopup(popUp(element)).addTo(unclustered);
            // clustered.addLayer(marker)
          }
        });
        drawCounties()
        map.legendControl.addLegend(getLegendHTML());
        map.addLayer(unclustered)
      }
    });
  }

  populateMap = function (data) {
    console.log(data);
    projectPerCounty = {}
    locations = $.csv.toObjects(data);
    locations.forEach(function(element, index){
      projectPerCounty[element["County"]] = element['Patients'];
      lat_long = element.Location.replace(/[()]/g, '').replace(/\s/g, '').split(',')
      if(typeof lat_long[0] === 'undefined' || typeof lat_long[1] === 'undefined'){
        console.log(element.County + " does not have valid location data, skipping")
      } else {
        var marker = L.marker([lat_long[0], lat_long[1]], {
          icon: myIcon
        }).bindPopup(popUp(element));
        // .addTo(unclustered);
        clustered.addLayer(marker)
      }
    });
    drawCounties()
    map.legendControl.addLegend(getLegendHTML());
    map.addLayer(clustered)
  }
  // populateClusteredMap()

});

(function ($) {
  var mymap = null;
  var features = null;
  var layers = null;
  var lastSelectedPin = null;

function clickOnMenu(id){
  var menu = document.getElementById(id);
  if(menu.className=="submenu show"){
    menu.className="submenu";
  }else{
    $('#democracia_participacion').removeClass('show');
    $('#desarollo_urbano').removeClass('show');
    $('#inclusion_equidad').removeClass('show');
    $('#'+id).addClass('show');
  }
}

function setDataUyLeafletCustoms(){
  $(".leaflet-overlay-pane path").css({ fillOpacity: "0", strokeWidth: "2" }); //Estilo para polígonos y líneas
  if($("body").hasClass("page-node-add-relevamiento-escuela-municipal")){
    //Estoy creando o editando un relevamiento de escuela municipal;
    var icon = "escuelas_municipales.png"
    var iconURL = "/sites/all/modules/ip_geoloc/markers/";
    createPinNodeSelectorAndSetEvents(null,"escuela_municipal","edit-field-location","/export/escuelas/json","edit-field-escuela-mun-und", false,iconURL,icon);
    return false;
  }
  else if ($("body").hasClass("page-node-add-relevamiento-centros-de-salud")){
    //Estoy creando o editando un relevamiento de centro de salud;
    var icon = "atencion_infraestructura.png"
    var iconURL = "/sites/all/modules/ip_geoloc/markers/";
    createPinNodeSelectorAndSetEvents(null,"centro_de_salud","edit-field-location","/export/centros_salud/json","edit-field-centro-de-salud-und", false,iconURL,icon)
    return false;
  }
  else if($("body").hasClass("page-node-add-relevamiento-pp")){
    //Estoy creando o editando un relevamiento de pp;
    var icon = "blue_datos1.png";
    var iconURL = "/sites/all/modules/ip_geoloc/markers/";
    createPinNodeSelectorAndSetEvents(null,"cpcs","edit-field-location","/export/cpcs/json","edit-field-cpc-de-pertenencia-und", false,iconURL,icon);
    return false;
  }
  else if($("body").hasClass("page-node-add")){
    //Estoy creando o editando un relevamiento cualquiera (debo levantar mapa pero no entidades referenciadas);
	   //createMapAndSetEvents("edit-field-location","leaflet-widget_field-location-input", "field_location[und][geom]");
    return false;
  }
  /*else if($("body").hasClass("page-taxonomy-term")){
    //Estoy visualizando una categoría de las del menú izquierdo
    var map = Drupal.settings.leaflet[0].lMap;
    var url = "https://reportes.reportaciudad.org/api/geo_reports/?api_key=1234";
    if(remotePMBGroups){
      url = url + "&gid="+remotePMBGroups;
    }else{
      //Si no hay grupo no muestro nada
      mymap = map;
      addGeolocateButton(mymap,"categories-map");
      //geolocate(mymap,false);
      return false;
    }
    var icon = null;
    if(parentName && parentName=="Inclusión y equidad"){
      icon = "pink_pmb.png"
    }
    if(parentName && parentName=="Desarrollo Institucional"){
      icon = "blue_pmb.png"
    }
    if(parentName && parentName=="Desarrollo Urbano sustentable"){
      icon = "green_pmb.png"
    }
    createPinNodeSelectorAndSetEvents(map,"reporte_pmb","categories-map",url,null, true,"https://reportes.reportaciudad.org",null)
    return false;
  }*/
}

function createMapAndSetEvents(idContainer, idLocationElement, nameLocationElement){
  $("#"+idContainer).empty();
  $("#"+idContainer).height(440);
  $("#"+idContainer).append("<div id='pin_description'><p>Ubicar reporte:</p></div>");
  $("#"+idContainer).append("<div id='map_selector'></div>");
  $("#"+idContainer).append("<input id='"+idLocationElement+"' type='hidden' name='"+nameLocationElement+"' value=''>");
  $("#map_selector").height(400);
  mymap = createMap("map_selector");
  addPinIfUrlContainsPinGeom(mymap,idLocationElement);
  var tipo = getTypeFromClassName();
  //Traigo los otros relevamientos de este tipo
  /*$.getJSON( "/export/all/json" , function( data ) {
    features =  data.features;
    layers = new Array();
    features.forEach(function(feature){
      if (feature.properties) {
		  if(feature.properties.Type==tipo){
			  var lon = feature.geometry.coordinates[0];
			  var lat = feature.geometry.coordinates[1];
			  var layer;
			  var iconURL = getIconURLfromType(feature.properties.Type) + ".png";
			  if(iconURL){
				var markerIcon = L.icon({
					iconUrl: iconURL,
					iconSize: [30, 37.4],
					iconAnchor: [15, 37.4],
					popupAnchor: [15, 0]
				  });
				layer = L.marker([lat, lon], {icon: markerIcon});
				  layer.feature = feature;
				  var html="<div style='text-align: center;'><b>"+feature.properties.Nombre+"</b>";
				  //html += "<a class=/"ver_detalles/" onclick=/"jQuery.ajax({type: 'GET', url: '/node-view/484', success: function(data, textStatus, response){jQuery('#report-over').empty();jQuery('#report-over').append(data);jQuery('.overlay').show();}});/">Ver detalles</a>";
				  html += "</div>";
				  layer.bindPopup(html);
				  mymap.addLayer(layer);
				  layers.push(layer);
			  }else{
				//layer = L.marker([lat, lon], {});
			  }

		  }

      }
    });
  });*/
  //Traigo los reportes de PMB
  /*var url = "https://reportes.reportaciudad.org/api/geo_reports/?api_key=1234";
  var remotePMBGroups = getPMBGroupIdfromType(tipo);
  if(remotePMBGroups){
    url = url + "&gid="+remotePMBGroups;
  }
  $.getJSON( url , function( data ) {
    features =  data.features;
    features.forEach(function(feature){
      if (feature.properties) {
          var lon = feature.geometry.coordinates[1];
          var lat = feature.geometry.coordinates[0];
          var layer;
          var iconURL = null;
          iconBaseUrl = "https://reportes.reportaciudad.org";
          iconURL = iconBaseUrl+feature.properties.pin_url;
          if(iconURL){
            var markerIcon = L.icon({
                iconUrl: iconURL,
                iconSize: [30, 37.4],
                iconAnchor: [15, 37.4],
                popupAnchor: [15, 0]
              });
            layer = L.marker([lat, lon], {icon: markerIcon});
          }
          layer.feature = feature;
          layer = bindPopupToLayer(layer,feature,"reporte_pmb");
          mymap.addLayer(layer);
          layers.push(layer);
      }
  });
});*/
  mymap.on('contextmenu',function(event){
    var lat = event.latlng.lat;
    var lon = event.latlng.lng;
    if(lastSelectedPin){
      mymap.removeLayer(lastSelectedPin);
      lastSelectedPin = null;
    }
    lastSelectedPin = L.marker([lat, lon], {});
    mymap.addLayer(lastSelectedPin);
    setLocationElementValue(idLocationElement,lon,lat);
  });
  mymap.on('click',function(event){
    var lat = event.latlng.lat;
    var lon = event.latlng.lng;
    if(lastSelectedPin){
      mymap.removeLayer(lastSelectedPin);
      lastSelectedPin = null;
    }
    lastSelectedPin = L.marker([lat, lon], {});
    mymap.addLayer(lastSelectedPin);
    setLocationElementValue(idLocationElement,lon,lat);
  });
  addGeolocateButton(mymap,"map_selector");
  //geolocate(mymap,false);
}

function getTypeFromClassName(){
	var classes = $.map($('body')[0].classList, function(cls, i) {
	  if (cls.indexOf('page-node-add-') === 0) {
		return cls.replace('page-node-add-', '');
	  }
	})
	if(classes[0]){
		var type = classes[0].replace(/\-/g, '_');
		return type;
	}
}

function getIconURLfromType(type){
	var url = "/sites/all/modules/ip_geoloc/markers/";
	if(type=="cpcs"){return url + "blue_datos1"}
	if(type=="centro_de_salud"){return url + "atencion_infraestructura"}
	if(type=="relevamiento_centros_de_salud"){return url + "atencion_infraestructura"}
	if(type=="escuela_municipal"){return url + "escuelas_municipales"}
	if(type=="relevamiento_escuela_municipal"){return url + "pink_relevamiento"}
	if(type=="relevamiento_pp"){return url + "presupuesto_participativo"}
	if(type=="tiempo_de_espera_del_colectivo"){return url + "tiempo_espera"}
	if(type=="centro_vecinal"){return url + "centros_vecinales"}
	if(type=="organizacion_sociedad_civil"){return url + "blue_datos1"}
	if(type=="relevamiento_jpv"){return url + "juntas_participativas"}
	if(type=="relevamiento_de_espacios_verdes"){return url + "plazasyespacios_verdes"}
	if(type=="relevamiento_econom_a_social"){return url + "economia_social"}
	if(type=="acoso_en_la_v_a_p_blica"){return url + "acoso_viapublica"}
	if(type=="detenciones_arbitrarias_en_la_v_"){return url + "detenciones"}
	if(type=="infracciones_al_c_digo_de_conviv"){return url + "infracciones_codigo"}
	return null;
}

function getPMBGroupIdfromType(type){
  //Inclusión y equidad
	if(type=="centro_de_salud"){return "27,29,31,32"}
	if(type=="relevamiento_centros_de_salud"){return "27,29,31,32"}
	if(type=="escuela_municipal"){return "27,29,31,32"}
	if(type=="relevamiento_escuela_municipal"){return "27,29,31,32"}
  if(type=="relevamiento_econom_a_social"){return "27,29,31,32"}
  if(type=="acoso_en_la_v_a_p_blica"){return "27,29,31,32"}
  if(type=="detenciones_arbitrarias_en_la_v_"){return "27,29,31,32"}
  if(type=="infracciones_al_c_digo_de_conviv"){return "27,29,31,32"}
  if(type=="actividad_deportivas"){return "27,29,31,32"}
  //Democracia y participacion
	if(type=="centro_vecinal"){return "28,30,33"}
  if(type=="relevamiento_pp"){return "28,30,33"}
  if(type=="cpcs"){return "28,30,33"}
  if(type=="relevamiento_pp"){return "28,30,33"}
	if(type=="ejecuci_n_de_obras_de_pp"){return "28,30,33"}
	if(type=="relevamiento_jpv"){return "28,30,33"}
  //Desarollo urbano
  if(type=="conflictos_de_suelo"){return "1,2,3,4,5,7,13,19,20,21,22,24,25,26"}
	if(type=="relevamiento_de_espacios_verdes"){return "1,2,3,4,5,7,13,19,20,21,22,24,25,26"}
  if(type=="tiempo_de_espera_del_colectivo"){return url + "tiempo_espera"}
	return null;
}

function addPinIfUrlContainsPinGeom(map,idLocationElement){
  var lat = getParameterByName("lat");
  var lon = getParameterByName("long");
  if(lat && lon){
    if(lastSelectedPin){
      map.removeLayer(lastSelectedPin);
      lastSelectedPin = null;
    }
    lastSelectedPin = L.marker([lat, lon], {});
    map.addLayer(lastSelectedPin);
    setLocationElementValue(idLocationElement,lon,lat);
  }
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function setLocationElementValue(idLocationElement,lon,lat){
  var data = '{"type":"FeatureCollection","features":[{"type":"Feature","geometry":{"type":"Point","coordinates":['+lon+','+lat+']},"properties":{}}]}';
  $("#"+idLocationElement).val(data);
}

function createPinNodeSelectorAndSetEvents(map,type,idContainer,url, idNodeSelect, invertCoords, iconBaseUrl, iconFileName){
  if(map==null){
    $("#"+idContainer).empty();
    $("#"+idContainer).height(440);
    $("#"+idContainer).append("<div id='pin_description'></div>");
    $("#"+idContainer).append("<div id='map_selector'></div>");
    $("#map_selector").height(400);
    mymap = createMap("map_selector");
  }else{
    mymap = map;
  }
  $.getJSON( url , function( data ) {
    features =  data.features;
    layers = new Array();
    features.forEach(function(feature){
      if (feature.properties) {
          var lon = feature.geometry.coordinates[0];
          var lat = feature.geometry.coordinates[1];
          if(invertCoords){
            lon = feature.geometry.coordinates[1];
            lat = feature.geometry.coordinates[0];
          }
          var layer;
          var iconURL = null;
          if(iconBaseUrl!=null && iconFileName){
            iconURL = iconBaseUrl+iconFileName;
          }else if(feature.properties.pin_url && iconBaseUrl!=null){
            iconURL = iconBaseUrl+feature.properties.pin_url;
          }
          if(iconURL){
            var markerIcon = L.icon({
                iconUrl: iconURL,
                iconSize: [30, 37.4],
                iconAnchor: [15, 37.4],
                popupAnchor: [15, 0]
              });
            layer = L.marker([lat, lon], {icon: markerIcon});
          }else{
            layer = L.marker([lat, lon], {});
          }
          layer.feature = feature;
          if(idNodeSelect!=null){
            layer.on('click', function(e) {
                $("#"+idNodeSelect).val(e.target.feature.properties.Id);
                showPinDescription(e.target.feature,type);
                mymap.setView([e.target.feature.geometry.coordinates[1], e.target.feature.geometry.coordinates[0]], 13);
            });
          }else{
            layer = bindPopupToLayer(layer,feature,type);
          }
          mymap.addLayer(layer);
          layers.push(layer);
      }
    });
  });
  addGeolocateButton(mymap,idContainer);
  //geolocate(mymap,false);
}

function addGeolocateButton(map,idContainer){
  $("#"+idContainer).append("<div id='gps_control' class='control_over_map'></div>");
  $('#gps_control').click(function(e) {
    e.preventDefault();
    geolocate(map,true);
  });
}

function geolocate(map,moveToPosition){
  map.on('locationfound', onLocationFound);
  map.on('locationerror', onLocationError);
  map.locate({setView: moveToPosition, maxZoom: 16});
}

function onLocationFound(e) {
   var radius = e.accuracy / 2;
   var location = e.latlng
   L.marker(location).addTo(mymap)
   L.circle(location, radius).addTo(mymap);
}

function onLocationError(e) {
   console.log(e.message);
}

function bindPopupToLayer(layer,feature,type){
  if(type=="reporte_pmb"){
    var callback = encodeURIComponent(window.location.href);
    layer.bindPopup("<div style='text-align: center;'><b>"+feature.properties.title+"</b><br>"+feature.properties.category+"<br><a href='https://reportes.reportaciudad.org/report/"+feature.properties.id+"?platform=1&callback="+callback+"'>Ver reporte</a>");
  }
  return layer;
}

function bindPopupReport(url){
  $.ajax({
    type: "GET",
    url: url,
    success: function(data, textStatus, response){
      console.log(data);
      console.log(textStatus);
      console.log(response);
    }
  });
  $('.main_area').append('<div class="overlay"><div class="report-over"></div></div>')
}

function showPinDescription(feature,type){
  $("#pin_description").empty();
  if(type=="centro_de_salud"){
    $("#pin_description").append("<b>Nombre: </b>"+feature.properties.Nombre);
    $("#pin_description").append("<br/><b>Dirección: </b>"+feature.properties.Dirección);
    $("#pin_description").append("<br/><b>Horario: </b>"+feature.properties.Horario);
    $("#pin_description").append("<br/><b>Teléfono: </b>"+feature.properties.Teléfono);
  }
  if(type=="escuela_municipal"){
    $("#pin_description").append("<b>Nombre: </b>"+feature.properties.Nombre);
    $("#pin_description").append("<br/><b>Nº: </b>"+feature.properties.Numero);
  }
  if(type=="cpcs"){
    $("#pin_description").append("<b>Nombre: </b>"+feature.properties.Nombre);
  }
  $("#pin_description").append("<br/>");
}

function createMap(id){
  mymap = L.map(id).setView([-31.421993, -64.175616], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>',
      maxZoom: 18,
      id: id,
  }).addTo(mymap);
  return mymap;
}


$(document).ready(function(){
  $('#democracia_participacion_menu').click(function() {
      clickOnMenu("democracia_participacion");
  });
  $('#desarollo_urbano_menu').click(function() {
      clickOnMenu("desarollo_urbano");
  });
  $('#inclusion_equidad_menu').click(function() {
      clickOnMenu("inclusion_equidad");
  });
  setDataUyLeafletCustoms();
  $('.objetives_button').click(function() {
    $('.objetives_button,.objetivos_table').toggleClass('show');
  });
  $('.external-overlay').click(function() {
    console.log('ENTRA CON URL: '+$(this).attr('x-data'));
    $('.overlay-full').html('<iframe width="800" height="450" src="//'+$(this).attr('x-data')+'" frameborder="0" allowfullscreen></iframe>');
    $('.overlay-full').show();
    $('.overlay-full').click(function(){
      $('.overlay-full').empty();
      $('.overlay-full').hide();
    });
  });
});

})(jQuery);

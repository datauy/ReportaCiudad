(function ($) {
//CODE FOR STATS WITH D3

var catJson = null;
var categoriesArray = [];
var areas = [];
var categoryGroups = [];
var chartLevel = 1;
var colorsByName = [];
var tooltip = d3.select("body")
 .append("div")
 .style("position", "absolute")
 .style("z-index", "10")
 .style("visibility", "hidden")
 .style("background", "#fff")
 .text("a simple tooltip")
 .attr("id","d3_tooltip");

 function getCharts(){
  //Is set filter, return filter, otherwise return term_id
  var args = typeof apiArgs !== 'undefined' ? apiArgs : '';
  var urlParams = getApiRequestURLParams(args);
  getTotalsChart(urlParams);
  getReportsByStateChart(urlParams);
  getReportsPerCategoriesChart("graph-reports-categories",urlParams);
 	/*getReportsEvolution("graph-reports-evolution-chart-visualisation",urlParams);
 	getAnswerTimeByStateChart(urlParams);
 	getAnswerTimeByCategoryChart("graph-average-answertime-by-category-chart",urlParams);*/
 }
 function setCategoryGroupFilter(tid){
 	if( $.isNumeric(tid) ){
    var catSelected = $("#edit-tid option[value='"+tid+"']");
    if ( catSelected.text().substring(0,3) != '---' ) {
      $('#edit-tid option').attr('selected', false);
      catSelected.attr('selected', 'selected');
      window.location.replace("/estadisticas"+getApiRequestURLParams());
    }
    else {
      window.location.replace("/estadisticas"+getApiRequestURLParams(tid));
    }
 	}
 	return false;
 }
function getReportsPerCategoriesChart(container_id,urlParams){
  console.log('Categories');
	$("#"+container_id).html('<div class="loader_throbber"><div class="three-quarters-loader"></div></div>');
	var url = "/api/reportsByCategoryGroup"+urlParams;
  console.log(url);
	d3.json(url, function(data) {
		$("#categories-list").html("");
		$("#"+container_id).html('');

		var width = $("#"+container_id).innerWidth()*0.79,
				height = $("#"+container_id).innerHeight(),
				radius = Math.min(width, height) / 2;

		var arc = d3.svg.arc()
				.outerRadius(radius - 10)
				.innerRadius(radius - 70);

		var pie = d3.layout.pie()
				.sort(null)
				.value(function(d) { return d.reports; });

		var svg = d3.select("#"+container_id).append("svg")
				.attr("width", width)
				.attr("height", height)
			.append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		$.each(data, function(i, item) {
			$("#categories-list").append('<li style="color: '+getRandomColor(item.color,item.groupName)+';"> '+item.reports+' <div class="circulo" style="background-color: '+getRandomColor(item.color,item.groupName)+';"></div><span>'+item.groupName+'</span></li>');
		});

		var g = svg.selectAll(".arc")
				.data(pie(data))
			.enter().append("g")
				.attr("class", "arc");

		g.append("path")
				.attr("d", arc)
				.style("fill", function(d) {
					return getRandomColor(d.data.color,d.data.groupName); })
				.style('cursor', 'pointer')
				.on("mouseover", function(d){tooltip.html("<b>"+d.data.groupName + "</b><br/>" + d.data.reports); return tooltip.style("visibility", "visible");})
				.on("mousemove", function(){return tooltip.style("top", (d3.event.pageY-10)+"px").style("left",(d3.event.pageX+10)+"px");})
				.on("mouseout", function(){return tooltip.style("visibility", "hidden");})
				.on('click', function(d){
          console.log(d.data);
					tooltip.style("visibility", "hidden");
					setCategoryGroupFilter(d.data.tid);
				 });

		g.append("text")
				.attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
				.attr("dy", ".35em")
				.style("display","none")
				.text(function(d) { return d.data.groupName; })


	});

	function type(d) {
		d.reports = +d.reports;
		return d;
	}
}

function getReportsByStateChart(urlParams){
  console.log('State');
	$("#graph-reports-by-state-table").html('<tbody><tr><td><div class="loader_throbber"><div class="three-quarters-loader"></div></div></td></tr></tbody>');
	var url = "/api/reportsByState"+urlParams;
  console.log(url);
	$.getJSON(url, function (data) {
		statesTable = "<tbody>";
		nextRowColor = null;
		$.each(data, function(i, item) {
			statesTable = statesTable + "<tr><td class='report-state-count'>"+item.reports+"</td><td class='report-state'>"+item.state+"</td></tr>";
		});
		statesTable = statesTable + "</tbody>";
		$("#graph-reports-by-state-table").html(statesTable);
	});
}

function getTotalsChart(urlParams){
  console.log('Totals');
	var url = "/api/getTotals"+urlParams;
  console.log(url);
	$.getJSON(url, function (data) {
		$("#graph-total-users-value").html(data[0].users);
		$("#graph-total-reports-value").html(data[0].reports);
	});
}

function getApiRequestURLParams(tid){
	var date_from = $("#edit-date-filter-min-datepicker-popup-0").val();
	var date_to = $("#edit-date-filter-max-datepicker-popup-0").val();
  var categoryGroup = $("#edit-tid").val();
  var state = $("#edit-field-estado-value").val();
  var cpcs = $("#edit-field-cpc-de-pertenencia-target-id").val();
	$("#date_from").html(date_from);
	$("#date_to").html(date_to);
	if(date_from==""){
		$("#date_from").html("el comienzo");
	}
	if(date_to==""){
		$("#date_to").html("hoy");
	}
	if($( "#chart-container" ).hasClass( "hidden" )){
			$("#chart-container").toggleClass("hidden");
	}
	var url = "";
	if(date_from){
		url += "&date_filter[min][date]="+date_from;
	}
	if(date_to){
		url += "&date_filter[max][date]="+date_to;
	}
  if(state && state != 'All'){
      url += "&field_estado_value[]="+state;
	}
  if(categoryGroup){
    $.each(categoryGroup, function(i,term_id) {
      url += "&tid[]="+term_id;
    });
  }
  if(cpcs){
    $.each(cpcs, function(i,cpc_id) {
      url += "&field_cpc_de_pertenencia_target_id[]="+cpc_id;
    });
  }
  /*var cpc_id = 1;
  var cpc_selected = $('#edit-field-cpc-de-pertenencia-target-id-'+cpc_id);
  while ( cpc_selected.length !== 0 ) {
    if ( cpc_selected.prop('checked') ) {
      url += "&field_cpc_de_pertenencia_target_id["+cpc_id+"]="+cpc_id;
    }
    cpc_id = cpc_id + 1;
    cpc_selected = $('#edit-field-cpc-de-pertenencia-target-id-'+cpc_id);
  }*/
  if ( tid ) {
    url = "/"+tid+"?"+url;
  }
  else if (categoryGroup){
    url = "?"+url;
  }
  else {
    url = "/11,12,13?"+url;
  }

	return url;
}

function getRandomColor(originalColor,groupName){
		if(chartLevel==1 && originalColor){
			return originalColor;
		}
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++ ) {
				color += letters[Math.floor(Math.random() * 16)];
		}
		if((chartLevel==1 && !originalColor) || chartLevel==2 || chartLevel==3){
			if(colorsByName[groupName]){
				return colorsByName[groupName];
			}else{
				colorsByName[groupName] = color;
			}
		}
		return color;
}

function download_totals(){
	var url = "/api/getTotals&format=csv";
	url = url + getApiRequestURLParams();
	var win = window.open(url, '_blank');
}

function download_reports(){
	var url = "/api/reports&format=csv";
	url = url + getApiRequestURLParams();
	var win = window.open(url, '_blank');
}

$( document ).ready(function() {
  getCharts();
});

})(jQuery);

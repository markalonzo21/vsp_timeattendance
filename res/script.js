function getEvent(timestamp) {
	$.ajax({
		type: 'GET',
		url: 'report/events/'+timestamp,
		success: function(data){
			//var obj = jQuery.parseJSON(data);
			console.log(data);
			// display_logs();
		}
	});
}

function pollEvent(timestamp){

	var lastModData = timestamp;

	$.ajax({
		type: 'GET',
		url: 'report/pollEvent/'+lastModData,
		timeout: 0,
		success: function(data){
			// console.log(data);
			lastModData = data;
			getEvent(lastModData);
			pollEvent(lastModData);
		},
		error: function(x, t, m){
			if(t === 'timeout'){
				pollEvent(lastModData);
			}
		}
	});
}

// function display_logs(){
// 	$.ajax({
// 		type: 'GET',
// 		url: 'report/displayData',
// 		success: function(data){
// 			if(data){
// 				var html = '<tr>';
// 				html += '<td>'+data[0]['name']+'</td></tr>';
// 				$('#emp_table').prepend(html);
// 			}
// 			console.log(data);
// 		}

// 	});
// }

$(function(){
	pollEvent();
	// display_logs();
});

$(document).ready(function(){
	$("#notif").load("employee/trackRecord");

	setInterval(function(){
		$("#notif").load("employee/trackRecord")
	}, 10000);
});


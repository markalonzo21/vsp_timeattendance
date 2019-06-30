// function getEvent(timestamp) {
// 	$.ajax({
// 		type: 'GET',
// 		url: 'report/events/'+timestamp,
// 		success: function(data){
// 			//var obj = jQuery.parseJSON(data);
// 			// console.log(data);
// 			// display_logs();
// 		}
// 	});
// }

// function pollEvent(timestamp){

// 	var lastModData = timestamp;

// 	$.ajax({
// 		type: 'GET',
// 		url: 'report/pollEvent/'+lastModData,
// 		success: function(data){
// 			// console.log(data);
// 			lastModData = data;
// 			getEvent(lastModData);
// 			pollEvent(lastModData);
// 		}
// 	});
// }

// // function display_logs(){
// // 	$.ajax({
// // 		type: 'GET',
// // 		url: 'report/displayData',
// // 		success: function(data){
// // 			if(data){
// // 				var html = '<tr>';
// // 				html += '<td>'+data[0]['name']+'</td></tr>';
// // 				$('#emp_table').prepend(html);
// // 			}
// // 			console.log(data);
// // 		}
// // 	});
// // }
$(document).ready(function(){
	$("#notif").load("employee/trackRecord");

	setInterval(function(){
		$("#notif").load("employee/trackRecord");
	}, 10000);
	setInterval(function(){
		pollEvent(new Date().getTime());
	}, 60000);

	// $("#genReport").on("click", function(){
	// 	$.ajax({
	// 		url: 'report/generateReport',
	// 		success: function(data){
	// 			console.log('gen success');
	// 		}
	// 	});
	// });

	// Add active class to the current button (highlight it)
	// var header = document.getElementById("sidebar-menu");
	// var btns = header.getElementsByClassName("menu");
	// for (var i = 0; i < btns.length; i++) {
	//   btns[i].addEventListener("click", function() {
	//   var current = document.getElementsByClassName("active");
	//   current[0].className = current[0].className.replace(" active", "");
	//   this.className += " active";
	//   });
	// }
	// $('.menu').click(function(){
 //    $('.menu').removeClass("active");
 //    $(this).addClass("active");
	// });

	// pollEvent(new Date().getTime());
});


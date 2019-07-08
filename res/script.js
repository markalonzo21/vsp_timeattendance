function pollEvent(timestamp){

	var lastModData = timestamp;

	$.ajax({
		type: 'GET',
		url: 'report/pollEvent/'+lastModData,
		success: function(data){
			pollEvent(data);
		}
	});
}

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

	$('#genReport').click(function(){
		var date_range = $("#dateRange").val();
		var coded = $.base64.encode(date_range);
		window.location = "http://localhost/timeattendance/report/generateReport/"+coded;
	});

	$('#dateRange').datepicker({
		language: 'en',
		range: true,
		position: 'left top',
		multipleDatesSeparator: ' - ',
		toggleSelected: false
	});

	pollEvent();

	var ctx = $("#myChart")[0].getContext('2d');
		// console.log(ctx);
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Pink'],
	        datasets: [{
	            label: '# of Votes',
	            data: [12, 19, 3, 5, 2, 3, 23],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)',
	                'rgba(255, 195, 255, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)',
	                'rgba(255, 195, 255, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});

	$("#notif").load("employee/trackRecord");

	setInterval(function(){
		$("#notif").load("employee/trackRecord");
	}, 10000);

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
 //    	$('.menu').removeClass("active");
 //    	$(this).addClass("active");
	// });
	$('#sidebar-menu li').on('click',function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
});


function pollEvent(timestamp){

	var modDate = timestamp;

	$.ajax({
		type: 'GET',
		url: 'report/pollEvent/'+modDate,
		success: function(data){
			$("#emp_table").load('report/displayData');	
			pollEvent(data);
		}
	});
}

$(document).ready(function(){

	$('#sidebar-menu li').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	});

	$("#searchEngine").keyup(function(){
		var input = $(this).val().toLowerCase();
		$("#emp_table tr").filter(function(){
			$(this).toggle($(this).text().toLowerCase().indexOf(input) > -1)
		});
		console.log(input);
	});

	$("#notif").load("employee/trackRecord");

	setInterval(function(){
		$("#notif").load("employee/trackRecord");
	}, 10000);

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
});


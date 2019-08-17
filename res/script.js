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
	
	$('ul#sidebar-menu li a').filter(function(){
		return this.href == location.href
	}).parent().addClass('active').siblings().removeClass('active');

	$("#searchEngine").keyup(function(){
		var input = $(this).val().toLowerCase();
		$("#emp_table tr").filter(function(){
			$(this).toggle($(this).text().toLowerCase().indexOf(input) > -1)
		});
		// console.log(input);
	});

	// $("#notif").load("employee/trackRecord");

	// setInterval(function(){
	// 	$("#notif").load("employee/trackRecord");
	// }, 10000);

	$('#genReport').click(function(){
		var date_range = $("#dateRange").val();
		var coded = $.base64.encode(date_range);
		window.location = window.location.href + '/generateReport/' + coded;
		// window.location = "http://localhost/timeattendance/report/generateReport/"+coded;
	});

	$('#dateRange').datepicker({
		language: 'en',
		range: true,
		position: 'left top',
		multipleDatesSeparator: ' - ',
		toggleSelected: false
	});

	// pollEvent();

	$('.report-link').on('click', function(event){
		let date = $(this)[0].innerText;

		var new_date = new Date(date),
			yr = new_date.getFullYear(),
			day = new_date.getDate()  < 10 ? '0' + new_date.getDate()  : new_date.getDate()
			new_date.setMonth(new_date.getMonth() + 1)
		var month = new_date.getMonth() < 10 ? '0' + new_date.getMonth() : new_date.getMonth(),
		newDate = month + '/' + day + '/' + yr;
		console.log(newDate);

		$('#report-modal-h5')[0].innerText = date;
		$('#report_modal').modal('show');
		var coded = $.base64.encode(newDate);
		$('#report_table').load('report/reportByDate/'+ coded);
	});

	if(window.location.pathname.split('/')[2] == 'home')
	{
		var ctx = $("#myChart")[0].getContext('2d');
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
	}

	let reportModalH5 = document.getElementById('report-modal-h5');
	let reportLink = document.getElementById('report-link');
});


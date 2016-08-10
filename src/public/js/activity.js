(function(undefined){
	var timepiece = {};
	
	timepiece.getActivity = function(successCallback){
		var now = new Date();
		var offset = -now.getTimezoneOffset(); // Negate so offset is in the form UTC+X.
		
		$.get('/activity.php', {offset: offset}, successCallback, 'json');
		
		successCallback = undefined;
	};
	
	$('document').ready(function(){
		
		var refreshActivity = function(){
			var onActivityReceived = function(response){
				$('#time-container h2').text("It's time to");
				$('#activity').text(response.activity);
			};
			
			timepiece.getActivity(onActivityReceived);
			
			// Set timer to auto-refresh every 10 minutes
			setTimeout(refreshActivity, 600000);
		}
		
		refreshActivity();
	});
}());
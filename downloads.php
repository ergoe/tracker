<?php 
include 'model/init.php';
include 'includes/overall/overallHeader.php';
protect_page();
 ?>

<script type="text/javascript">
		
	var int;
	var tenthsSeconds = 0;
	var seconds = 0;
	var value = 0;
	var minutes = 0;
			
	function startTimerNew() {
		int = setInterval(updateDisplay, 100);
	}
	
	function updateDisplay() {
		//var value = parseInt($('#timerLabel').text(), 10);
		value++;
		totalSeconds = value;
		tenthsSeconds++;
		
		if (tenthsSeconds > 9 ) {
			tenthsSeconds = 0;
		} 
		seconds = Math.floor(totalSeconds / 10);
		
		if ( seconds > 59 ) {
			seconds = 0;
		}
		minutes = Math.floor(totalSeconds / 600);
		
		if ( minutes > 59 ) {
			minutes = 0;
		}
				
		secondsDisplay = ( seconds < 10 ) ? '0'+ seconds : seconds;
		$('#timerLabel').text(minutes + ":" + secondsDisplay + ":" + tenthsSeconds);
	}
	
	function stop_timer() {
		
		if (int) {
			this.int = window.clearInterval(int);
		}	
	}
	
	function reset_timer() {
		tenthsSeconds = 0;
		seconds = 0;
		value = 0;	
		
		$('#timerLabel').text(minutes + ":" + '0'+ seconds + ":" + tenthsSeconds);
	}
	
</script>		
<h1>Downloads</h1>
<p>Just a Template</p>


<label id='timerLabel'>0</label> 
<div>
	<input type='button' value='start' onclick="startTimerNew();" />
	<input type='button' value='stop' onclick="stop_timer();" />
	<input type='button' value='reset' onclick="reset_timer();" />
</div>
<?php 
include 'includes/overall/overallFooter.php'; 
?>
<!DOCTYPE html>
<html>
<head>
	<title>AJAX Test</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<select id="btn">
		<option value="option-1">Option 1</option>
	    <option value="option-2">Option 2</option>
	    <option value="option-3">Option 3</option>
	</select>
	<div id="result"></div>

	<script>
		$(document).ready(function(){
			$("#btn").change(function(){
				var selectedOption = $(this).val();
				$.ajax({
					url: "test.php",
					method: "POST",
					data: {
				        selectedOption: selectedOption,
				      },
					success: function(response){
						$("#result").html(response);
					},
					error: function(xhr, status, error){
						console.log(error);
					}
				});
			});
		});
	</script>
</body>
</html>

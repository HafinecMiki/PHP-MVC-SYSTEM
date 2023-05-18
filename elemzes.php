<!DOCTYPE html>
<?php

$data = [];

if (isset($_POST['analitics'])) {
	$content = file_get_contents($_POST['url_link']);
	$content = strip_tags($content);
	$content = preg_replace('/[^A-Za-z0-9\-]/', ' ', $content);
	$subString = explode(" ", $content);
	foreach ($subString as $val) {
		if (count($data) < 64) {
			if (str_contains($val, 'a') || str_contains($val, 'A')) {
				$checkContains = false;
				if (count($data) > 0) {
					foreach ($data as $item) {
						if (strtolower($item) == strtolower($val)) {
							$checkContains = true;
						}
					}
				}

				if (!$checkContains) {
					array_push($data, $val);
				}
			}
		}
	}
}
?>
<html lang="en">

<head>
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
	<div>
		<h3 class="text-primary">Elemzes</h3>
		<hr style="border-top:1px dotted #ccc;" />

		<div class="col-md-6">
			<!-- Login Form Starts -->
			<form method="POST">
				<div class="form-group">
					<label>Url</label>
					<input type="text" name="url_link" class="form-control" required="required" />
				</div>
				<input type="submit" name="analitics" class="btn btn-primary" value="Search" />
			</form>
			<!-- Login Form Ends -->
			<?php
			if (count($data) > 0) {
				echo '<h3>Result</h3>';
				$count = 0;
				foreach ($data as $item) {
					if($item == end($data)){
						echo $item . '.';
					}
					else{
						echo $item . ',';
					}
					
					$count++;
					if($count%7 == 0){
						echo "\n";
					}
				}
			}
			?>
		</div>
	</div>
</body>

</html>
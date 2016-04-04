<!DOCTYPE html>
<head>
	<!-- Pictures from Unsplash used on this site. Thanks! https://unsplash.com/ -->
	<meta charset="utf-8">
	<title>Assignment 2 - JS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php
		require 'images.php';
		
		if (isset($_POST["add_image"])) {
				addImg();
			}
		if (isset($_POST["deleteID"])) {
				deleteImg();
		}
	?>
</head>
<body>
	<?php printNodes(); ?>
	<!-- Print nodes from PHP XML connection -->
	<div class="container" id="slideshow">
		<div class='item'>
			<div>
				<button id='prevBTN'><i class='fa fa-chevron-left fa-5x'></i></button>
				<button id='pauseBTN'><i class='fa fa-pause fa-5x'></i></button>
				<button id='playBTN'><i class='fa fa-play fa-5x'></i></button>
				<form id='view' method="get" action="">
					<button type="submit" name='view' value="admin"><i class='fa fa-edit fa-5x'></i></button>
				</form>
				<!-- Fill in form when loading JS -->
				<form id="deleteForm" method="post" action="">
				</form>
				<button id='nextBTN'><i class='fa fa-chevron-right fa-5x'></i></button>
			</div>
			<img id="slideshowimg" src="">
		</div>
	</div>
	<div class="container">
		<!-- Print if admin -->
		<?php if(isset($_GET['view']) && $_GET['view'] === 'admin') {
		?>
			<div class="item">
				<form method="post" enctype="multipart/form-data">
					<input type="file" name="min_bild"></input>
					<input type="text" name="caption">
					<label for="caption">Caption</label>
					<input type="date" name="date">
					<label for="date">Date</label>
					<input type="submit" name="add_image"></input>
				</form>
			</div>
		<?php } ?>
		<!-- Print nodes from JS XML connection -->
		<div class="item">
			<ul id="bildlista">
			</ul>
		</div>
	</div>
	<script src="images.js"></script>
</body>
</html>

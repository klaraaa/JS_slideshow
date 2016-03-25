<!DOCTYPE html>
<head>
	<!-- Pictures from Unsplash used on this site. Thanks! https://unsplash.com/ -->
	<meta charset="utf-8">
	<title>Assignment 2 - JS</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php require 'images.php'; ?>
	<?php addImg(); ?>
</head>
<body>
	<div class="container">
		<div class="item">
			<form method="post" enctype="multipart/form-data">
				<input type="file" name="min_bild"></input>
				<input type="text" name="caption">
				<label for="caption">Caption</label>
				<input type="text" name="date">
				<label for="date">Date</label>
				<input type="submit" name="add_image"></input>
			</form>
		</div>
		<div class="item">
			<ul id="bildlista">
			</ul>
		</div>
	</div>
	<?php printNodes(); ?>
	<div class="container" id="slideshow">
		<p class="item">Vilken bild vill du se?
			<!-- <input type='submit' id='prevBTN' name='pic_id' value='null'>Previous</button>
			<input type='submit' id='nextBTN' name='pic_id' value='null'>Next</button> -->
		</p>

	</div>
	<script src="images.js"></script>
</body>
</html>

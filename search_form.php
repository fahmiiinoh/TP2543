<?php
session_start();
if (!isset($_SESSION['loggedin']))
  header("LOCATION: login.php");

require 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Search Product</title>
	<?php include_once 'nav_bar.php'; ?>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.21/dist/css/themes/splide-sea-green.min.css">

	<style type="text/css">
		figure {
			display: table;
		}

		figcaption {
			display: table-caption;
			caption-side: bottom;
		}
		li{
			width: auto;
		}
		canvas{
			position: fixed;
			top: 0;
			z-index: -10;
		}
	</style>
</head>
<body>
	<body style="background-color:#9FD7FC;">
	<section class="container-fluid">
		<div class="container content" id="searchbox">
			<div class="text-center" style="margin-bottom: 3rem;">
				<div class="row">
					<div class="col-md-12">
					<h1>Refrigerator Store Products</h1>	
						<hr style="border-top: 1px solid transparent;"/>

					</div>
					<div class="col-md-12">
						<form action="#" method="POST" id="searchForm">
							<div class="form-group">
								<input type="text" class="form-control text-center input-lg" id="inputSearch" name="search"
								placeholder="Nett/Sharp/Top,Bottom..." autocomplete="off" required>
								<span id="helpBlock2" class="help-block"></span>
							</div>
						<p class="text-muted">Search product by Name, brand, or type.</p>
							<button type="submit" class="btn btn-lg btn-primary">Search</button><br><br>

						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="resultSection" class="container resultList" style="padding: 20px;display: none;">
		<div class="text-center">
			<h2>Result</h2>
			<p>Found <span class="result-count">0</span> results.</p>
		</div>
			<div class="row list-item"></div>
	</div>

</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

<script>
	$("#searchForm").submit(function (e) {
		e.preventDefault();

		var input = $("#inputSearch");
		var val = input.val();

		input.parent().removeClass('has-error');
		input.parent().find("#helpBlock2").text("");

		if (val.length > 2) {
			//&& (val.split(" ").length==1 || val.split(" ").length==3)
			$.ajax({
				url: 'search.php',
				type: 'get',
				dataType: 'json',
				data: {
					search: val
				},
				beforeSend: function () {
					$("body").addClass('loading');
					input.addClass('disabled');
				},
				success: function (res) {
					$('.list-item').empty();
					if (res.status == 200) {
						//  console.log(res.data);
						$(".result-count").text(res.data.length);
						$.each(res.data, function (idx, data) {
							if (data.fld_product_image === '')
								data.fld_product_image = data.fld_product_id + '.png';

							$('.list-item').append(`<div class="col-md-4">
								<div class="thumbnail thumbnail-dark">
								<img src="products/${data.fld_product_image}" alt="${data.fld_product_name}" style="height: 345px;">
								<div class="caption text-center">
								<h3>${data.fld_product_name}</h3>
								<p>
								<a href="products_details.php?pid=${data.fld_product_id}" class="btn btn-primary" role="button">View</a>
								</p>
								</div>
								</div>
								</div>`);
						});

							$(".resultList").show("slow", function () {
								$("body").removeClass('loading');
							});
							$('html, body').animate({
								scrollTop: $("#resultSection").offset().top
							}, 500);
						}else{
							console.log(res.data);
						}
					},
					complete: function () {
						input.removeClass('disabled');
					}
				});
		} else {
			input.parent().addClass("has-error");
			input.parent().find("#helpBlock2").text("Please enter more than 2 characters.");
			$('.splide__list').empty();
		}
	});
</script>
</body>
</html>
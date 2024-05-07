<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('layouts.css')
	<title>::: Inicio :::</title>
	<style>
		.feather{
			width: 18px !important;
			height: 18px !important;
		}

		.alert-danger{
			padding-bottom: 0px !important;
		}

		.alert-success{
			padding-bottom: 0px !important;
		}
	</style>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		@include('layouts.navbar-left')
		<!--end sidebar wrapper -->
		<!--start header -->
		@include('layouts.navbar')
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
                @yield('content')
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		 <div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2024. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	@include('layouts.scripts')
	@yield('scripts')
	<script>
		$(document).ready(function () {
			$('#filter').keyup(function () {
				var rex = new RegExp($(this).val(), 'i');
				$('#bodytable tr').hide();
				$('#bodytable tr').filter(function () {
					return rex.test($(this).text());
				}).show();
			})
		})
		feather.replace();
	</script>
</body>

</html>
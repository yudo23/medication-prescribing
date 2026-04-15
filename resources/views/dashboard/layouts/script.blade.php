<!-- jQuery  -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/jquery.min.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/modernizr.min.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/detect.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/fastclick.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/jquery.slimscroll.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/jquery.blockUI.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/waves.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/jquery.nicescroll.js"></script>
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/jquery.scrollTo.min.js"></script>

<!-- skycons -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/plugins/skycons/skycons.min.js"></script>

<!-- skycons -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/plugins/peity/jquery.peity.min.js"></script>

<!-- dashboard -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/pages/dashboard.js"></script>

<!-- App js -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/js/app.js"></script>

<!-- Select2 -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/plugins/bootstrap-select2/select2.min.js"></script>

<!-- SweetAlert 2 -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
	$(function() {
		if ($('.select2').length >= 1) {
			$('.select2').each(function() {
				$(this).select2({
					width: "100%",
					allowClear: true,
					dropdownParent: $(this).parent()
				});
			})
		}

		$('.table-responsive').on('show.bs.dropdown', function() {
			$('.table-responsive').css("min-height", "60vh");
		});

		$('.table-responsive').on('hide.bs.dropdown', function() {
			$('.table-responsive').css("min-height", "auto");
		})
	});

	function openLoader() {
		$('.preloader').css("display", "block");
		$('.preloader').find("#status").css("display", "block");
	}

	function closeLoader() {
		$('.preloader').css("display", "none");
		$('.preloader').find("#status").css("display", "none");
	}

	function responseSuccess(message, callback = null) {
		Swal.fire({
			icon: 'success',
			title: 'success',
			html: message,
			timer: 5000,
		}).then((ok) => {
			if (callback != null) {
				return location.href = callback
			}
		})
	}

	function responseFailed(message) {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			html: message,
			timer: 5000,
		})
	}

	function responseInternalServerError() {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			html: 'Internal server error',
			timer: 5000,
		})
	}

	function sessionTimeOut() {
		Swal.fire({
			type: 'error',
			title: 'Oops...',
			html: "Session login anda telah habis. Silahkan login ulang",
			timer: 5000,
		}).then((ok) => {
			return location.href = '{{route("dashboard.auth.login.index")}}';
		})
	}

	function formatRupiah(value) {
		if (value === null || value === undefined || value === '') return '';

		let str = value.toString().replace(/[^0-9.]/g, '');

		let parts = str.split('.');
		let integerPart = parts[0];
		let decimalPart = parts[1];
		let sisa = integerPart.length % 3;
		let rupiah = integerPart.substr(0, sisa);
		let ribuan = integerPart.substr(sisa).match(/\d{3}/g);

		if (ribuan) {
			rupiah += (sisa ? '.' : '') + ribuan.join('.');
		}

		return decimalPart !== undefined
			? rupiah + ',' + decimalPart
			: rupiah;
	}
</script>
@yield("script")
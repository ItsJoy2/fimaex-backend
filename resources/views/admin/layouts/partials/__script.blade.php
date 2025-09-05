	<!-- Fonts and icons -->
	<script src="{{asset('assets/admin/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset('assets/admin/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <!--   Core JS Files   -->
	<script src="{{asset('assets/admin/js/core/jquery-3.7.1.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

	<!-- Chart JS -->
	<script src="{{asset('assets/admin/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{asset('assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{asset('assets/admin/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{asset('assets/admin/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{asset('assets/admin/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/plugin/jsvectormap/world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Kaiadmin JS -->
	<script src="{{asset('assets/admin/js/kaiadmin.min.js')}}"></script>

	<!-- Kaiadmin DEMO methods, don't include it in your project! -->
	<script src="{{asset('assets/admin/js/setting-demo.js')}}"></script>
	{{-- <script src="{{asset('assets/admin/js/demo.js')}}"></script> --}}
	<script>
		$('#lineChart').sparkline([102,109,120,99,110,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#177dff',
			fillColor: 'rgba(23, 125, 255, 0.14)'
		});

		$('#lineChart2').sparkline([99,125,122,105,110,124,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#f3545d',
			fillColor: 'rgba(243, 84, 93, .14)'
		});

		$('#lineChart3').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.updateStatusBtn').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.dataset.id;
                let userName = this.dataset.name;
                let userEmail = this.dataset.email;
                let userWallet = this.dataset.wallet;
                let blockStatus = this.dataset.block;
                let walletStatus = this.dataset.wallet;

                document.getElementById('modal_user_id').value = userId;
                document.getElementById('modal_user_name').value = userName;
                document.getElementById('modal_user_email').value = userEmail;
                document.getElementById('modal_user_wallet').value = userWallet;
                document.getElementById('modal_block_status').value = blockStatus;
                document.getElementById('modal_wallet_status').value = walletStatus;
            });
        });
    });
</script>

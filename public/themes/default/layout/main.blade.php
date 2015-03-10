@include('partials.header')
		<div class="container">
			@if ( Session::has('success_message'))
				<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('success_message') }}</p>
				</div>
			@elseif ( Session::has('notif_message'))
				<div class="alert alert-primary">
                    <button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('error_message') }}</p>
				</div>
			@elseif ( Session::has('error_message'))
				<div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('error_message') }}</p>
				</div>
			@endif
			@yield('body')
		</div>
@include('partials.footer')
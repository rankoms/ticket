<style>
	.dropdown-toggle:after {
		content: none
	}
</style>
<div class="btn-group">
	<button type="button"
		class="btn profile align-content-center align-items-center d-flex justify-content-center nav-link position-relative dropdown-toggle"
		data-toggle="dropdown" aria-expanded="false">
		<div class="flex-shrink-0 me-3">
			<div class="avatar avatar-online">
				<img src="{{ asset('images/default-user.webp') }}" alt="" class="rounded-circle img-size-50 mr-3 img-circle">
			</div>
		</div>
		<div class="flex-grow-1">
			<span class="fw-semibold d-block lh-1">{{ Auth::user()->name }}</span>
			<small></small>
		</div>
		<i class="fa fa-chevron-down"></i>
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
	</div>
</div>

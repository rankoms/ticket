<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

	<!-- Sidebar -->
	<div class="sidebar">


		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
															with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="{{ route('redeem_voucher.dashboard') }}"
						class="nav-link {{ areActiveRoutes(['redeem_voucher.dashboard']) }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				{{-- 
				<li class="nav-item">
					<a href="{{ route('event.index') }}"
						class="nav-link {{ areActiveRoutes(['event.index', 'event.create', 'event.edit']) }}">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Event
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('ticket.index') }}"
						class="nav-link {{ areActiveRoutes(['ticket.index', 'ticket.create', 'ticket.edit']) }}">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Ticket
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('ticket.index') }}"
						class="nav-link {{ areActiveRoutes(['ticket.index', 'ticket.create', 'ticket.edit']) }}">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Voucher
						</p>
					</a>
				</li>
				 --}}
				<li class="nav-item">
					<a href="{{ route('redeem_voucher.index') }}"
						class="nav-link {{ areActiveRoutes(['ticket.index', 'ticket.create', 'ticket.edit']) }}">
						<i class="nav-icon fas fa-edit"></i>
						<p>
							Voucher Redeem
						</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>

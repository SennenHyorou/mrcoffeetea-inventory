<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
		</li>
	</ul>


	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">

		<!-- Profile Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fa fa-th-large"></i>

			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">Profile Menu</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-envelope mr-2"></i> Profile
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-users mr-2"></i> Settings
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="{{ route('logout') }}"
				    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
					<i class="fa fa-file mr-2"></i> Logout
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>

			</div>
		</li>

	</ul>
</nav>
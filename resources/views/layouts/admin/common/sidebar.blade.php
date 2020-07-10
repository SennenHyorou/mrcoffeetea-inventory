<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="/" class="brand-link">
		<img src="{{ asset('assets/backend/img/logo.jpeg') }}" alt="Mr CoffeeTea Inventory" class="brand-image img-circle elevation-3"
		     style="opacity: .8">
		<span class="brand-text font-weight-light">MCT Inventory</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('assets/backend/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">Administrator</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				<li class="nav-item has-treeview">
					<a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
						<i class="nav-icon fa fa-dashboard"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview {{ Request::is('admin/supplier*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/supplier*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-industry"></i>
						<p>
							Supplier
							<i class="right fa fa-angle-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.supplier.create') }}" class="nav-link {{ Request::is('admin/supplier/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Supplier</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.supplier.index') }}" class="nav-link {{ Request::is('admin/supplier') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Supplier</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview {{ Request::is('admin/category*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/category*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Category
							<i class="right fa fa-angle-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.category.create') }}" class="nav-link {{ Request::is('admin/category/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Category</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.category.index') }}" class="nav-link {{ Request::is('admin/category') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Category</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview {{ Request::is('admin/product*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/product*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-shopping-bag"></i>
						<p>
							Product
							<i class="right fa fa-angle-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.product.create') }}" class="nav-link {{ Request::is('admin/product/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Product</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.product.index') }}" class="nav-link {{ Request::is('admin/product') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Products</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview {{ Request::is('admin/expense*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/expense*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-money"></i>
						<p>
							Expense
							<i class="right fa fa-angle-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.expense.create') }}" class="nav-link {{ Request::is('admin/expense/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.today') }}" class="nav-link {{ Request::is('admin/expense-today') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Today Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.month') }}" class="nav-link {{ Request::is('admin/expense-month*') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Monthly Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.yearly') }}" class="nav-link {{ Request::is('admin/expense-yearly*') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Yearly Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.index') }}" class="nav-link {{ Request::is('admin/expense') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Expense</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Report
							<i class="right fa fa-angle-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.report.product') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Product's Report</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('logout') }}"
					   onclick="event.preventDefault();
					   document.getElementById('logout-form').submit();">
						<i class="nav-icon fa fa-sign-out"></i> Logout
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
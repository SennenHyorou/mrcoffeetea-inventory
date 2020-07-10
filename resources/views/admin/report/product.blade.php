@extends('layouts.admin.app')

@section('title', 'Dashboard')

@push('css')


@endpush

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Product Report</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Expiring this Month</span>
                                <span class="info-box-number">{{ $this_month }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-secondary">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Expiring this Year</span>
                                <span class="info-box-number">{{ $this_year }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Expiring next Year</span>
                                <span class="info-box-number">{{ $next_year }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text mt-3 pb-1">Total Products</span>
                                <span class="info-box-number mb-3">{{ $total_products }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
				<div class="row">
					<div class="col-md-12">
						<!-- AREA CHART -->
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Products Report</h3>
							</div>
							<div class="card-body">
								<div class="chart">
									<div id="barchart_material2" style="width: auto; height: 500px;"></div>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
				</div>
				<!-- /.row -->
			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

@endsection

@push('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Month', 'Products {{ date('Y') }}'],
                @foreach($products as $product)
                    ["{{ date('M', mktime('0', 0, 0, $product['months'], 10)) }}", {{ $product['count'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Monthly New Product',
                width: 'auto',
                legend: { position: 'none' },
                chart: { title: 'Monthly New Product {{ date('Y') }}',
                    subtitle: 'Monthly New Product' },
                bars: 'vertical', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'bottom', label: 'Month'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('barchart_material2'));
            chart.draw(data, options);
        }


	</script>
@endpush

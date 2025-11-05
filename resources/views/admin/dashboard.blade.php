@extends('include.header')
@section('content')
<div class="row sales-cards">
	<div class="col-xl-6 col-sm-12 col-12 d-flex">
		<div class="card d-flex align-items-center justify-content-between flex-fill mb-4">
			<div>
				<h6>Weekly Earning</h6>
				<h3>$<span class="counters" data-count="95000.45">95000.45</span></h3>
				<p class="sales-range"><span class="text-success"><i data-feather="chevron-up" class="feather-16"></i>48%&nbsp;</span>increase compare to last week</p>
			</div>
			<img src="{{ asset('assets/img/icons/weekly-earning.svg') }}" alt="img">
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 col-12 d-flex">
		<div class="card color-info bg-primary flex-fill mb-4">
			<div class="mb-2">
				<img src="{{ asset('assets/img/icons/total-sales.svg') }}" alt="img">
			</div>
			<h3 class="counters" data-count="10000.00">10,000+</h3>
			<p>No of Total Sales</p>
			<i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 col-12 d-flex">
		<div class="card color-info bg-secondary flex-fill mb-4">
			<div class="mb-2">
				<img src="{{ asset('assets/img/icons/purchased-earnings.svg') }}" alt="img">
			</div>
			<h3 class="counters" data-count="800.00">800+</h3>
			<p>No of Total Sales</p>
			<i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xxl-3 col-lg-6 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
				<h5 class="mb-2">Companies</h5>								
				<div class="dropdown mb-2">
					<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
						<i class="ti ti-calendar me-1"></i>This Week
					</a>
					<ul class="dropdown-menu  dropdown-menu-end p-3">
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<div id="company-chart"></div>
				<p class="f-13 d-inline-flex align-items-center"><span class="badge badge-success me-1">+6%</span> 5 Companies  from last month</p>
			</div>
		</div>
	</div>
	<div class="col-xxl-3 col-xl-12 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
				<h5 class="mb-2">Top Plans</h5>							
				<div class="dropdown mb-2">
					<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
						<i class="ti ti-calendar me-1"></i>This Month
					</a>
					<ul class="dropdown-menu  dropdown-menu-end p-3">
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<div id="plan-overview"></div>
				<div class="d-flex align-items-center justify-content-between mb-2">
					<p class="f-13 mb-0"><i class="ti ti-circle-filled text-primary me-1"></i>Basic </p>
					<p class="f-13 fw-medium text-gray-9">60%</p>
				</div>
				<div class="d-flex align-items-center justify-content-between mb-2">
					<p class="f-13 mb-0"><i class="ti ti-circle-filled text-warning me-1"></i>Premium</p>
					<p class="f-13 fw-medium text-gray-9">20%</p>
				</div>
				<div class="d-flex align-items-center justify-content-between mb-0">
					<p class="f-13 mb-0"><i class="ti ti-circle-filled text-info me-1"></i>Enterprise</p>
					<p class="f-13 fw-medium text-gray-9">20%</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 d-flex">
		<div class="card flex-fill">
			<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
				<h5 class="mb-2">Revenue</h5>								
				<div class="dropdown mb-2">
					<a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center" data-bs-toggle="dropdown">
						<i class="ti ti-calendar me-1"></i>2025
					</a>
					<ul class="dropdown-menu  dropdown-menu-end p-3">
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">2025</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body pb-0">
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<div class="mb-1">
                        <h5 class="mb-1">$45787</h5>
                        <p><span class="text-success fw-bold">+40%</span> increased from last year</p>
					</div>
                    <p class="fs-13 text-gray-9 d-flex align-items-center mb-1"><i class="ti ti-circle-filled me-1 fs-6 text-primary"></i>Revenue</p>
				</div>
				<div id="revenue-income"></div>
			</div>
		</div>
	</div>
</div>
<script>
	var page_title = "Dashboard";
</script>
@endsection

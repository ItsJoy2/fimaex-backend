				<!-- Navbar Header -->
				<nav class="navbar navbar-header  navbar-expand-lg border-bottom ">

					<div class="container-fluid">
						<nav class="background-black navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
						</nav>

						<ul class="navbar-nav topbar-nav ms-md-autnavbar navbar-header  navbar-expand-lg border-bottom o align-items-center">
							<li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
								<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
									<i class="fa fa-search"></i>
								</a>
								<ul class="dropdown-menu dropdown-search animated fadeIn">
									<form class="navbar-left navbar-form nav-search">
										<div class="input-group">
											<input type="text" placeholder="Search ..." class="form-control">
										</div>
									</form>
								</ul>
							</li>

							<li class="nav-item topbar-user dropdown hidden-caret">
								<a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
									<div class="avatar-sm">
										<img src="https://yeldo-front-puce.vercel.app/_next/static/media/logo.beb988fc.png" alt="..." class="avatar-img rounded-circle">
									</div>
									<span class="profile-username">
										<span class="op-7">Hi,</span> <span class="fw-bold">{{ auth()->user()->name ?? "not fpund" }}</span>
									</span>
								</a>
								<ul class="dropdown-menu dropdown-user animated fadeIn">
									<div class="dropdown-user-scroll scrollbar-outer">
										<li>
											<div class="user-box">
{{--												<div class="avatar-lg"><img src="{{ Storage::url($generalSettings->favicon) }}" alt="image profile" class="avatar-img rounded"></div>--}}
												<div class="u-text">
													<h4>{{ auth()->user()->name }}</h4>
{{--													<p class="text-muted">{{ auth('admin')->user()->email }}</p><a href="{{route('admin.profile')}}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>--}}
												</div>
											</div>
										</li>
										<li>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                                @csrf
                                            </form>
										</li>
									</div>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
				<!-- End Navbar -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('adminDashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Code Lab Studio</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('adminDashboard') }}"><i
                        class="fas fa-fw fa-table"></i><span>Dashboard </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('category#list') }}"><i
                        class="fa-solid fa-circle-plus"></i><span>Category </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#createPage') }}"><i class="fa-solid fa-plus"></i><span>Add
                        Item </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#viewProduct') }}"><i
                        class="fa-solid fa-layer-group"></i><span>View All Product
                    </span></a>
            </li>
            @if (Auth::user()->role == 'superAdmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('payment#paymentPage') }}"><i
                            class="fa-solid fa-credit-card"></i><span>Payment Method
                        </span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('salePage') }}"><i class="fa-solid fa-list"></i><span>Sale
                        Information </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('orderPage') }}"><i class="fa-solid fa-cart-shopping"></i><span>Order
                        Board
                    </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile#changePassword') }}"><i
                        class="fa-solid fa-lock"></i><span>Change Password
                    </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}"><i class="fa-solid fa-lock"></i><span>User Contacts
                    </span></a>
            </li>

            <li class="nav-item">
                <form action="{{ route('customLogout') }}" method="post" class="nav-link">
                    @csrf
                    <button type="submit" class="btn btn-secondary"><i
                            class="fa-solid fa-right-from-bracket"></i><span>Logout
                        </span>
                    </button>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <a href="{{ route('orderPage') }}" class="ml-auto position-relative me-4 my-auto">
                        <i class="fa-solid fa-list-ul fa-2x"></i>
                        @yield('orderCount')
                    </a>
                    <ul class="navbar-nav ml-3">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name ?? 'Douglas McGee' }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('admin/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile#profilePage') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @if (Auth::user()->role == 'superAdmin')
                                    <a class="dropdown-item" href="{{ route('profile#createAdminPage') }}">
                                        <i class="fa-regular fa-square-plus mr-2 text-gray-400"></i>
                                        Create New Admin
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile#userAccounts') }}">
                                        <i class="fa-solid fa-users mr-2 text-gray-400"></i>
                                        View User Accounts
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('profile#changePassword') }}">
                                    <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>


                                <form class=" d-flex justify-content-center" action="{{ route('customLogout') }}"
                                    method="post" class="nav-link">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary"><i
                                            class="fa-solid fa-right-from-bracket"></i><span>Logout
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                @yield('content')
            </div>
        </div>

        @include('sweetalert::alert')


        <!-- Bootstrap core JavaScript-->
        {{-- <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

        <!-- Page level plugins -->
        {{-- <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script> --}}

        <!-- Page level custom scripts -->
        {{-- <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script> --}}
        {{-- <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script> --}}

        <script>
            function loadFile(event) {
                let reader = new FileReader();
                reader.onload = function() {
                    let imageSrc = document.getElementById('imageSrc');
                    imageSrc.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0])
            }
        </script>

        @yield('js-section')

</body>

</html>

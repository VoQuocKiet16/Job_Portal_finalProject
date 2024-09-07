<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerQuest | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo1.png') }} " />

</head>

<body data-instant-intensity="mousedown" class="d-flex flex-column min-vh-100">

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3 sticky-navbar">
            <div class="container">
                <a class="navbar-brand" href="#">CareerQuest</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('jobs') }}">Find Jobs</a>
                        </li>
                        @if (Auth::check() && (Auth::user()->role == 'recruiter' || Auth::user()->role == 'admin'))
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('resumes') }}">Find Resumes</a>
                        </li>
                    @endif
                    </ul>
                    @if (!Auth::check())
                        <a class="btn btn-outline-primary me-2" href="{{ route('account.login') }}"
                            type="submit">Login</a>
                    @else
                        @if (Auth::user()->role == 'admin')
                            <a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboard') }}"
                                type="submit">Manage</a>
                        @elseif (Auth::user()->role == 'recruiter')
                            <a class="btn btn-outline-primary me-2" href="{{ route('recruiter.dashboard') }}" type="submit">Manage</a>
                            <a class="btn btn-outline-primary me-2" href="{{ route('recruiter.createJob') }}" type="submit">Post a Job</a>
                        @endif
                        <a class="btn btn-primary" href="{{ route('account.profile') }}"
                            type="submit">Account</a>
                    @endif
                    
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('main')
    </main>

    <!-- Footer -->
    <footer class="bg-dark py-3 bg-2">
        <div class="container">
            <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" name="profilePicForm" id="profilePicForm" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <p class="text-danger" id="image-error"></p>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onscroll = function() {
            var navbar = document.querySelector('.navbar');
            if (window.pageYOffset > 0) {
                navbar.classList.add('sticky-navbar');
            } else {
                navbar.classList.remove('sticky-navbar');
            }
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#profilePicForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({

                url: "{{ route('account.updateProfilePic') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == false) {
                        var errors = response.errors;
                        if (errors.image) {
                            $("#image-error").html(errors.image)
                        }
                    } else {
                        window.location.href = '{{ url()->current() }}'
                    }

                }

            })


        });
    </script>
    @yield('customJs')
</body>

@extends('front.layouts.app')

@section('main')
<section class="h-100 custom-bg">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card card-registration my-4">
                    <div class="row g-0">
                        <div class="col-xl-6 d-none d-xl-block">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                                alt="Sample photo" class="img-fluid"
                                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body p-md-5 text-black">
                                <h3 class="mb-5 text-uppercase">User Registration Form</h3>

                                <form action="" name="registrationForm" id="registrationForm">
                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="name">Name*</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter Name"/>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="email">Email*</label>
                                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter Email"/>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <label class="form-label mb-2" for="recruiter">Are you a recruiter?</label>
                                            <select name="recruiter" id="recruiter" class="form-control form-control-lg">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="password">Password*</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter Password"/>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="confirm_password">Confirm Password*</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Please Confirm Password"/>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="button" class="btn btn-light btn-lg" onclick="document.getElementById('registrationForm').reset()">Reset all</button>
                                        <button type="submit" class="btn btn-warning btn-lg ms-2">Submit form</button>
                                    </div>
                                </form>
                                
                                <div class="mt-4 text-center">
                                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script>
        const loginRoute = "{{ route('account.login') }}";
        $("#registrationForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('account.processRegistration') }}",
                type: 'post',
                data: $("#registrationForm").serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == false) {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        }

                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        }

                        if (errors.password) {
                            $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password);
                        } else {
                            $("#password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        }

                        if (errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                        } else {
                            $("#confirm_password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        }
                    } else {
                        $("#name").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        $("#password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        $("#confirm_password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html('');
                        window.location.href = loginRoute;
                    }
                }
            });
        });
    </script>
@endsection

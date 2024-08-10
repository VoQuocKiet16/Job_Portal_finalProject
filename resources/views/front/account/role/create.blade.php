@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    <!-- Display success or error messages -->
                    @include('front.message')
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-3">Request Change Role</h3>
                            <form action="{{ route('role_change_requests.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="requested_role" class="form-label">Requested Role</label>
                                    <input type="text" class="form-control" id="requested_role" name="requested_role"
                                        value="Recruiter" readonly>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

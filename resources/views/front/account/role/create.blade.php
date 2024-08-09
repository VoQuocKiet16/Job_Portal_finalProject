@extends('front.layouts.app')

@section('main')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <!-- Display success or error messages -->
                    @include('front.message')

                    <form action="{{ route('role_change_requests.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="requested_role" class="form-label">Requested Role</label>
                            <input type="text" class="form-control" id="requested_role" name="requested_role" value="Recruiter" readonly>
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
@endsection





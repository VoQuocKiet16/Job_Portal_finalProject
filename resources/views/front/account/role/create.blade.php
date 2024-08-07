@extends('front.layouts.app')

@section('main')
<div class="container">
    <form action="{{ route('role_change_requests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="requested_role">Requested Role</label>
            <input type="text" class="form-control" id="requested_role" name="requested_role" value="Recruiter" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
@endsection



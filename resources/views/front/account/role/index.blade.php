@extends('front.layouts.app')

@section('main')
<div class="container">
    <h1>Role Change Requests</h1>
    <ul>
        @foreach($requests as $request)
        <li>
            {{ $request->user->name }} requested to become a {{ $request->requested_role }}
            <form action="{{ route('admin.role_change_requests.approve', $request->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
            <form action="{{ route('admin.role_change_requests.reject', $request->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection

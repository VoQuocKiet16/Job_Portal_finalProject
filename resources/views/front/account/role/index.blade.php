@extends('front.layouts.app')

@section('main')
<div class="container mt-5">
    <h1 class="mb-4">Role Change Requests</h1>
    
    @if($requests->count())
        <div class="list-group">
            @foreach($requests as $request)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $request->user->name }}</strong> requested to become a <strong>{{ $request->requested_role }}</strong>
                    </div>
                    <div>
                        <form action="{{ route('admin.role_change_requests.approve', $request->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.role_change_requests.reject', $request->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            No role change requests at the moment.
        </div>
    @endif
</div>
@endsection


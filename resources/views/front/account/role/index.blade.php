@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <h3 class="fs-4 mb-4">Role Change Requests</h3>
                        
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
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection



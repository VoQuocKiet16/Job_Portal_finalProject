@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("admin.jobtypes") }}">Job Type</a></li>
                        <li class="breadcrumb-item active">Create Job Type</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <h3 class="fs-4 mb-3">Create Job Type</h3>
                        <form action="{{ route('admin.jobtypes.save') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Job Type Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>                          
            </div>
        </div>
    </div>
</section>
@endsection
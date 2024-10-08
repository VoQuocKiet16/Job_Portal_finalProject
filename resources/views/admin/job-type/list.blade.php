@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fs-4 mb-0">Job Type</h3>
                            <a href="{{ route("admin.jobtypes.create") }}" class="btn btn-primary">Create Job Type</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Name Job Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobtypes->isNotEmpty())
                                        @foreach ($jobtypes as $jobtype)
                                        <tr>
                                            <td>
                                            <p>{{ $jobtype->name }}</p>
                                            </td>
                                            <td>
                                                <div class="action-dots">
                                                    <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route("admin.jobtypes.edit",$jobtype->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" onclick="deleteJobType({{ $jobtype->id }})" href="javascript:void(0);"  ><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-center">No job types found.</td>
                                        </tr>
                                    @endif
                                </tbody>                                
                            </table>
                        </div>
                        <div>
                            {{ $jobtypes->links() }}
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    function deleteJobType(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.jobtypes.delete") }}',
                    type: 'delete',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}" 
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: "Removed!",
                            text: "The job type has been removed.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "{{ route('admin.jobtypes') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong, please try again.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    }
</script>

@endsection

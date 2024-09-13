@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Resume List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fs-4 mb-0">Resume List</h3>
                            <a href="{{ route('resume.create') }}" class="btn btn-primary">Create Resume</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Status</th> 
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @php
                                        $count = 1;
                                    @endphp
                                    @if ($resumes->isNotEmpty())
                                        @foreach ($users_data as $user)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{ $user['personal_info']['profile_title'] ?? '' }}</td>
                                                <td>{{ $user['personal_info']['first_name'] ?? '' }}</td>
                                                <td>{{ $user['personal_info']['last_name'] ?? '' }}</td>
                                                <td>                                                 
                                                    <form action="{{ route('resume.toggleStatus', $user['resume_id']) }}" method="POST" class="status-toggle-form">
                                                        @csrf
                                                        @php
                                                            $isPublic = $resumes->find($user['resume_id'])->status;
                                                        @endphp
                                                        <button type="button" class="btn btn-{{ $isPublic ? 'success' : 'danger' }}" onclick="confirmToggleStatus('{{ $user['resume_id'] }}', {{ $isPublic ? 'true' : 'false' }})">
                                                            {{ $isPublic ? 'Public' : 'Private' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="action-dots">
                                                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="{{ route('resume.view', ['id' => $user['resume_id'] ?? '']) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('resume.edit', ['id' => $user['resume_id'] ?? '']) }}"><i class="fa fa-eye" aria-hidden="true"></i> Edit</a></li>
                                                            <li><a class="dropdown-item" onclick="deleteResume({{ $user['resume_id'] ?? '' }})" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('resume.downloadDoc', ['id' => $user['resume_id'] ?? '']) }}">
                                                                <i class="fa fa-download" aria-hidden="true"></i> Download as DOC</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No resumes found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $resumes->links() }}
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
        function confirmToggleStatus(resumeId, isPublic) {
            let message = isPublic 
                ? "Your resume will be kept private and cannot be found by employers."
                : "Do you want to make your resume public to employers?";
            
            if (confirm(message)) {
                const form = document.querySelector(`form[action*="toggle-status/${resumeId}"]`);
                form.submit();
            }
        }

        function deleteResume(id) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: '{{ route("resume.delete") }}',
                    type: 'delete',
                    data: { id: id},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ route('account.resume') }}";
                    }
                });
            }
        }
    </script>
@endsection

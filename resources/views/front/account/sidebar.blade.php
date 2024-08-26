<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">

        @if(Auth::user()->image !='')
        <img src="{{ asset('profile_pic/'.Auth::user()->image)}}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
        @else
        <img src="{{ asset('assets/images/avatar7.png')}}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
        @endif

        
        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6"> {{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class=" nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                 <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route ('account.profile')}}">Account Settings</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route ('account.myJobApplications') }}">Jobs Applied</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route ('account.savedJobs') }}">Saved Jobs</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route ('account.resume') }}">My Resume (CV)</a>
            </li>   
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route ('role_change_requests.request') }}">Send Request</a>
            </li>    
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class="js-scroll-trigger text-dark text-decoration-none" href="{{ route('account.logout')}}">Logout</a>
            </li>   
        </ul>
    </div>
</div>
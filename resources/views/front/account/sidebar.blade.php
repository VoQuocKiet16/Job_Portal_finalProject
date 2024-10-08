<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        @if (Auth::user()->image != '')
            <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar" class="rounded-circle img-fluid"
                style="width: 150px;">
        @else
            <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid"
                style="width: 150px;">
        @endif
        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6"> {{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change
                Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class=" nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-cog" style="color:black"><a class="js-scroll-trigger text-dark text-decoration-none "
                        style="padding: 10px;" href="{{ route('account.profile') }}"> Account Settings</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-briefcase" style="color:black"> <a
                        class="js-scroll-trigger text-dark text-decoration-none " style="padding: 10px;"
                        href="{{ route('account.myJobApplications') }}"> Jobs Applied</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-heart" style="color:black"> <a class="js-scroll-trigger text-dark text-decoration-none"
                        style="padding: 10px;" href="{{ route('account.savedJobs') }}">Favorite jobs</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-file-alt" style="color:black"><a
                        class="js-scroll-trigger text-dark text-decoration-none " style="padding: 10px;"
                        href="{{ route('account.resume') }}"> My Resume (CV)</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-sign-out-alt" style="color:black"><a
                        class="js-scroll-trigger text-dark text-decoration-none " style="padding: 10px;"
                        href="{{ route('account.logout') }}"> Logout</a></i>
            </li>
        </ul>
    </div>
</div>

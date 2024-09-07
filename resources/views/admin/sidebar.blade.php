<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{route('admin.statisticsAdmin')}}">Statistics</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{route('admin.users')}}">Users</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{route('admin.categories')}}">Category</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{route('admin.jobtypes')}}">Job Types</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none"href="{{route('admin.jobs')}}">Jobs</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{route('admin.jobApplications')}}">Job Applications</a>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <a class ="js-scroll-trigger text-dark text-decoration-none" href="{{ route('account.logout') }}">Logout</a>
            </li>                                                        
        </ul>
    </div>
</div>
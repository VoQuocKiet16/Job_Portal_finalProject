<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <i class="fas fa-chart-line" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.statisticsAdmin')}}">Statistics</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <i class="fas fa-users-cog" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.users')}}">Manage Accounts</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <i class="fas fa-tags" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.categories')}}">Manage Categories</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <i class="fas fa-map-marker-alt" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.locations')}}">Manage Locations</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between p-3">
                <i class="fas fa-briefcase" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.jobtypes')}}">Manage Job Types</a></i> 
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-clipboard-list" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.jobs')}}">Manage Jobs</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-file-signature" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{route('admin.jobApplications')}}">Manage Job Applications</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-sign-out-alt" style="color:black"><a class ="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{ route('account.logout') }}">Logout</a></i>
            </li>                                                        
        </ul>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-chart-bar" style="color:black"><a class="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{ route ('recruiter.statisticsRecruiter')}}">Statistics</a></i>
            </li>
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">                
                <i class="fas fa-clipboard-list" style="color:black"><a class="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{ route ('recruiter.myJobs')}}">Manage Posted Jobs</a></i>
            </li>   
            <li class="nav-link list-group-item d-flex justify-content-between align-items-center p-3">                
                <i class="fas fa-file-signature" style="color:black"><a class="js-scroll-trigger text-dark text-decoration-none" style="padding: 10px;" href="{{ route ('recruiter.applications')}}">Manage Applications</a></i>
            </li>
        </ul>
    </div>
</div>
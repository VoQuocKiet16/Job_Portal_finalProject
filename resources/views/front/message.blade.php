{{-- @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
@endif
@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
    // Close the alert after 5 seconds (5000 ms)
    window.setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script> --}}


@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert" style="padding: 15px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <i class="bi bi-check-circle-fill me-2" style="font-size: 24px;"></i>
        <div>
            {{ Session::get('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="outline: none;"></button>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert" style="padding: 15px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 24px;"></i>
        <div>
            {{ Session::get('error') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="outline: none;"></button>
    </div>
@endif

<script>
    // Close the alert after 5 seconds (5000 ms)
    window.setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>





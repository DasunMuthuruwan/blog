<div class="mb-3 position-relative">
    @php
        $alerts = [
            'newsletter_success' => 'success',
            'newsletter_fail' => 'danger',
            'info' => 'info',
            'fail' => 'danger',
            'success' => 'success'
        ];
    @endphp

    @foreach ($alerts as $key => $type)
        @if (Session::get($key))
            <div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center" role="alert">
                {{-- Optional icon --}}
                <i class="bi 
                    @if($type=='success') bi-check-circle-fill
                    @elseif($type=='danger') bi-x-circle-fill
                    @elseif($type=='info') bi-info-circle-fill
                    @endif
                    me-2"></i>

                <div>{!! Session::get($key) !!}</div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach
</div>

{{-- Optional: auto dismiss after 5 seconds --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                // fade out
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>

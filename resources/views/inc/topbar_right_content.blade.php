@if(backpack_user()->can('system-config.cache-clear'))
    <li class="nav-item" style="min-width: 35px !important;" title="Clear Cache">
        <button class="nav-link" onclick="cacheClear()"><i class="la la-trash"></i>
            <span class="d-md-down-none">Clear Cache</span></button>
    </li>
@endif
<li class="nav-item ml-1" style="min-width: 35px !important;" title="Goto Website">
    <a class="nav-link" href="{{ url('/') }}" target="_blank">
        <i class="la la-globe"></i>
        <span class="d-md-down-none">Goto Website</span>
    </a>
</li>
<li class="nav-item" style="min-width: 35px !important;">
    <a class="nav-link" href="{{ route('message.index') }}">
        <i class="la la-comments"></i>
        @if (backpack_user()->unreadMessagesCount)
            <span class="badge badge-pill badge-danger">{{ backpack_user()->unreadMessagesCount }}</span>
        @endif
    </a>
</li>

<script>
    function cacheClear() {
        swal({
            title: 'Are you sure?',
            text: 'After clearing the cache, the site may be a little slow at first while the new cache is being generated.',
            icon: 'warning',
            buttons: {
                cancel: true,
                confirm: 'Clear Cache'
            },
            dangerMode: true
        })
            .then(async (response) => {
                if (!response) {
                    return;
                }
                try {
                    const response = await fetch('{{ backpack_url('clear-cache') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {

                        return {
                            success: false,
                            message: data.message || 'An error occurred while clearing the cache.'
                        }
                    }

                    return data;

                } catch (error) {
                    console.error('Error clearing cache:', error);
                    return {
                        success: false,
                        message: error.message || 'An error occurred while clearing the cache.'
                    }
                }
            })
            .then((result) => {
                swal({
                    title: result.success ? 'Success' : 'Error',
                    icon: result.success ? 'success' : 'error',
                    text: result.message,
                    buttons: {
                        confirm: true
                    }
                })
                    .then((response) => {
                        if (!response) {
                            return;
                        }
                        window.location.href = '{{ backpack_url('login') }}';
                    });
            });
    }
</script>

@if(backpack_user()->can('system-config.cache-clear'))
    <li class="nav-item" style="min-width: 35px !important;" title="Clear Cache">
        <button class="nav-link" onclick="cacheClear()">  <i class="la la-trash"></i>
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
    function cacheClear()
    {
        if (confirm("Are you sure") === true) {
            // getFullPageLoader();
            $.ajax({
                url: '/admin/clear-cache',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // removeFullPageLoader();
                    if(response.success){
                        new Noty({
                            type: 'success',
                            text: response.message
                        }).show();

                        setTimeout(function () {
                            window.location = '{{ route('backpack.auth.login') }}';
                        }, 2000);

                    }else{
                        new Noty({
                            type: 'warning',
                            text: response.message
                        }).show();
                    }
                },
                error: function(xhr, status, error) {
                    // removeFullPageLoader();
                    console.error('Error clearing cache:', xhr.status);
                    new Noty({
                        type: 'error',
                        text: JSON.parse(xhr.responseText)?.message
                    }).show();
                }
            });

        }
    }
</script>

<div class="grid-dropdown-actions dropdown float-end">
    <a href="#" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown"></a>
    <ul class="dropdown-menu">
        @foreach($default as $action)
            <li>{!! $action->render() !!}</li>
        @endforeach

        @if(!empty($custom))

            @if(!empty($default))
                <li>
                    <hr class="dropdown-divider">
                </li>
            @endif

            @foreach($custom as $action)
                <li>{!! $action->render() !!}</li>
            @endforeach
        @endif
    </ul>
</div>

<script>
    $('.grid-table').on('shown.bs.dropdown', function (e) {

    }).on('hidden.bs.dropdown', function() {

    });
</script>

@yield('child')

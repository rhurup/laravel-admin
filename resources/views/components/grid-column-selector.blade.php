<div class="btn-group float-end column-selector">
    <button type="button" class="btn btn-sm btn-instagram dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fa fa-table"></i>
        &nbsp;
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <ul>
                @foreach($columns as $key => $label)
                    @php
                        if (empty($visible)) {
                            $checked = 'checked';
                        } else {
                            $checked = in_array($key, $visible) ? 'checked' : '';
                        }
                    @endphp

                    <li class="checkbox">
                        <input type="checkbox" class="column-select-item" value="{{ $key }}" {{ $checked }}/>&nbsp;&nbsp;&nbsp;{{ $label }}
                    </li>
                @endforeach
            </ul>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="text-right">
            <button class="btn btn-sm btn-default column-select-all">{{ __('admin.all') }}</button>&nbsp;&nbsp;
            <button class="btn btn-sm btn-primary column-select-submit">{{ __('admin.submit') }}</button>
        </li>
    </ul>
</div>

<style>
.column-selector {
    margin-right: 10px;
}

.column-selector .dropdown-menu {
    padding: 10px;
    height: auto;
    max-height: 500px;
    overflow-x: hidden;
}

.column-selector .dropdown-menu ul {
    padding: 0;
}

.column-selector .dropdown-menu ul li {
    margin: 0;
}

.column-selector .dropdown-menu label {
    width: 100%;
    padding: 3px;
}
</style>

<script>
$('.column-select-submit').on('click', function () {

    var defaults = @json($defaults);
    var selected = [];

    $('.column-select-item:checked').each(function () {
        selected.push($(this).val());
    });

    if (selected.length == 0) {
        return;
    }

    var url = new URL(location);

    if (selected.sort().toString() == defaults.sort().toString()) {
        url.searchParams.delete('_columns_');
    } else {
        url.searchParams.set('_columns_', selected.join());
    }

    $.pjax({container:'#pjax-container', url: url.toString()});
});

</script>

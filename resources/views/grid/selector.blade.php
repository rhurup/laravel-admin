<div class="grid-selector">
    @foreach($selectors as $column => $selector)
        <div class="wrap">
            <div class="select-label">{{ $selector['label'] }}</div>
            <div class="select-options">
                <ul>
                    @foreach($selector['options'] as $value => $option)
                        @php
                            $active = in_array($value, \Illuminate\Support\Arr::get($selected, $column, []));
                        @endphp
                        <li>
                            <a href="{{ \Encore\Admin\Grid\Tools\Selector::url($column, $value, true) }}"
                               class="{{$active ? 'active' : ''}}">{{ $option }}</a>
                            @if(!$active && $selector['type'] == 'many')
                                &nbsp;
                                <a href="{{ \Encore\Admin\Grid\Tools\Selector::url($column, $value) }}" class="add"><i
                                            class="fa fa-plus-square-o"></i></a>
                            @else
                                <a style="visibility: hidden;"><i class="fa fa-plus-square-o"></i></a>
                            @endif
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ \Encore\Admin\Grid\Tools\Selector::url($column) }}" class="clear"><i
                                    class="fa fa-trash"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
</div>



<div class="{{$viewClass['row mb-3up']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="input-group">

            @if ($prepend)
                <span class="input-group-text">{!! $prepend !!}</span>
            @endif

            <input {!! $attributes !!} />

            @if ($append)
                <span class="input-group-text clearfix">{!! $append !!}</span>
            @endif

            @isset($btn)
                <span class="input-group-btn">
                  {!! $btn !!}
                </span>
            @endisset

        </div>

        @include('admin::form.help-block')

    </div>
</div>

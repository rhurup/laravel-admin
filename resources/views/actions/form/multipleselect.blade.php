<div class="row mb-3 up">
    <label>{{ $label }}</label>
    <select class="c {{$class}}" style="width: 100%;" name="{{$name}}[]" {!! $attributes !!} multiple
            data-placeholder="{{ $label }}">

        <option value=""></option>
        @foreach($options as $select => $option)
            <option value="{{$select}}" {{ in_array($select, old($column, $value) ?: []) ? 'selected' : '' }}>{{$option}}</option>
        @endforeach
    </select>
    @include('admin::actions.form.help-block')
</div>


<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" data-name="{{ $name }}" data-resource="{{$resource}}"
           data-on="{{ $states['on']['value'] }}" data-off="{{ $states['off']['value'] }}" data-key="{{ $key }}"
           role="switch" id="{{ $class.'-'.$key }}" {{ $checked }}>
</div>

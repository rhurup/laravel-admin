@foreach($js as $value => $type)
    <script type="{{$type}}" src="{{ admin_asset ("$value") }}"></script>
@endforeach
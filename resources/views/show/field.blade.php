<div class="row mb-3up ">
    <label class="col-sm-{{$width['label']}} control-label">{{ $label }}</label>
    <div class="col-sm-{{$width['field']}}">
        @if($wrapped)
            <div class="box box-solid box-default no-margin box-show">
                <!-- /.card-header -->
                <div class="card-body">
                    @if($escape)
                        {{ $content }}&nbsp;
                    @else
                        {!! $content !!}&nbsp;
                    @endif
                </div><!-- /.card-body -->
            </div>
        @else
            @if($escape)
                {{ $content }}
            @else
                {!! $content !!}
            @endif
        @endif
    </div>
</div>
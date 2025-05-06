<div class="{{$viewClass['row mb-3up']}}">
    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>
    <div class="{{$viewClass['field']}}">
        <div class="box box-solid box-default no-margin">
            <!-- /.card-header -->
            <div class="card-body">
                {!! $value !!}&nbsp;
            </div><!-- /.card-body -->
        </div>

        @include('admin::form.help-block')

    </div>
</div>
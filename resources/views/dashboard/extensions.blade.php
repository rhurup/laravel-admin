<style>
    .ext-icon {
        color: rgba(0, 0, 0, 0.5);
        margin-left: 10px;
    }

    .installed {
        color: #00a65a;
        margin-right: 10px;
    }
</style>
<div class="card">
    <div class="card-header with-border">
        <h3 class="card-title">Available extensions</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="list-group">

            @foreach($extensions as $extension)
                <li class="list-group-item">
                    <div class="product-img">
                        <i class="fa fa-{{$extension['icon']}} fa-2x ext-icon"></i>
                </div>
                <div class="product-info">
                    <a href="{{ $extension['link'] }}" target="_blank" class="product-title">
                        {{ $extension['name'] }}
                    </a>
                    @if($extension['installed'])
                        <span class="float-end installed"><i class="fa fa-check"></i></span>
                    @endif
                </div>
            </li>
            @endforeach

            <!-- /.item -->
        </ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer text-center">
        <a href="https://github.com/laravel-admin-extensions" target="_blank" class="uppercase">View All Extensions</a>
    </div>
    <!-- /.card-footer -->
</div>
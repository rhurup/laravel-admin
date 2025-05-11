<div class="card">
    <div class="card-header with-border">
        <h3 class="card-title">Dependencies</h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body dependencies">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                @foreach($dependencies as $dependency => $version)
                <tr>
                    <td width="240px">{{ $dependency }}</td>
                    <td><span class="label label-primary">{{ $version }}</span></td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->
</div>

<script>
    $('.dependencies').slimscroll({height: '510px', size: '3px'});
</script>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Environment</h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                @foreach($envs as $env)
                <tr>
                    <td width="120px">{{ $env['name'] }}</td>
                    <td>{{ $env['value'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->
</div>
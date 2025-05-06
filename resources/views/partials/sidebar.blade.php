<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar user panel (optional) -->
    <div class="sidebar-brand">
        <!-- Logo -->
        <a href="{{ admin_url('/') }}" class="brand-link">
            <span class="brand-text fw-light">{!! config('admin.logo', config('admin.name')) !!}</span>
        </a>
    </div>
    <div class="sidebar-wrapper" data-overlayscrollbars="host">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                @each('admin::partials.menu', Admin::menu(), 'item')
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="AdminLTE | Dashboard v2">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, admin dashboard, charts, calendar, tables, datatable, vanilla js, colorlibhq">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Third-Party Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <main>
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Third-Party Scripts -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>

    <!-- OverlayScrollbars Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true,
                    },
                });
            }
        });
    </script>

    <!-- DataTable Initialization -->
    <script>
        $(function () {
            $("#example1").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                paging: false,
                lengthChange: true,
                searching: false,
                ordering: false,
                info: false,
                autoWidth: false,
                responsive: true,
            });
        });

        $(document).ready(function () {
            $('.edit-btn').on('click', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');

                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#editUserForm').attr('action', "{{ route('updateUser', ':id') }}".replace(':id', id));

                $('#editUserModal').modal('show');
            });

            $('.delete-btn').on('click', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#delete_user_name').text(name);
                $('#deleteUserForm').attr('action', "{{ route('deleteUser', ':id') }}".replace(':id', id));

                $('#deleteUserModal').modal('show');
            });

            $('.btn-primary').on('click', function () {
                $('#addUserModal').modal('show');
            });
        });
    </script>

    @stack('scripts')

</body>
</html>

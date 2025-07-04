    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>AdminLTE 3 | Starter</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">

    <livewire:styles />
    </head>
    <body class="hold-transition sidebar-mini">
    <div class="wrapper">

    <!-- Navbar -->
    <livewire:layouts.partials.navbar />

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <livewire:layouts.partials.aside_seller />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ $slot }}
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <livewire:layouts.asidebar-notification />
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.partials_seller.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        toastr.options = {
        "positionClass": "toast-bottom-right",
        "progressBar": true,
        }

        window.addEventListener('hide-form', event => {
        $('#form').modal('hide');
        toastr.success(event.detail.message, 'Success!');
        })
    });
    </script>

    <script>
    window.addEventListener('addProductModal', () => {
        $('#addProductModal').modal('show');
    });
    window.addEventListener('hide-add-product-modal', event => {
        $('#addProductModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('show_store', event => {
        $('#form_show_store').modal('show');
    })
    window.addEventListener('hide_show_store', event => {
        $('#form_show_store').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('show-notification_admin-form', event => {
        $('#sendadminNotificationModal').modal('show');
    })
    window.addEventListener('hide-notification_admin-form', event => {
        $('#sendadminNotificationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('show-notification-form', event => {
        $('#sendNotificationModal').modal('show');
    })
    window.addEventListener('hide-notification-form', event => {
        $('#sendNotificationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('store_updated', event => {
        toastr.success(event.detail.message, 'updated successfully!');
    })
    window.addEventListener('show_product', event => {
        $('#show_product').modal('show');
    })
    window.addEventListener('view_product_hide', event => {
        $('#show_product').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })
    window.addEventListener('search_model_show', event => {
        $('#search_model').modal('show');
    });



    </script>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('message'))
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: '{{ session('message')['type'] }}',
                            text: '{{ session('message')['text'] }}'
                        }
                    }));
                @endif
            });
            window.addEventListener('toast', event => {
                const type = event.detail.type || 'info';
                const text = event.detail.text || 'No message';

                switch (type) {
                    case 'success':
                        toastr.success(text, 'Success!');
                        break;
                    case 'error':
                        toastr.error(text, 'Error!');
                        break;
                    case 'warning':
                        toastr.warning(text, 'Warning!');
                        break;
                    default:
                        toastr.info(text, 'Info');
                }
            });
</script>
    <livewire:scripts />
    </body>
    </html>

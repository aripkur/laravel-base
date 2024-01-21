<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="#389f6b" name="theme-color" />
    <meta content="est 2020 " name="description" />
    <meta content="https://twitter.com/eestehh" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config("app.name"))</title>
    <link rel="icon" href="/assets/image/icon-app.png" type="image/icon">


    {{-- muat semua walau tidak digunakan --}}
    <link rel="stylesheet" href="/assets/adminlte/fonts/source-sans-pro.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/print/print.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/tagify/tagify.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/fancybox/jquery.fancybox.css">


    <script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/adminlte/plugins/moment/moment.min.js"></script>
    <script src="/assets/adminlte/plugins/moment/locale/id.js"></script>
    <script src="/assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/adminlte/plugins/select2/js/select2.full.js"></script>
    <script src="/assets/adminlte/plugins/toastr/toastr.min.js"></script>
    <script src="/assets/adminlte/plugins/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/adminlte/plugins/inputmask/jquery.inputmask.js"></script>
    <script src="/assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/assets/adminlte/plugins/print/print.min.js"></script>
    <script src="/assets/adminlte/plugins/chart.js/Chart.min.js"></script>
    <script src="/assets/adminlte/plugins/chart.js/Chart-datalabels.js"></script>
    <script src="/assets/adminlte/plugins/signature-pad/signature_pad.umd.js"></script>
    <script src="/assets/adminlte/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="/assets/adminlte/plugins/tagify/tagify.min.js"></script>
    <script src="/assets/adminlte/plugins/tagify/jQuery.tagify.min.js"></script>
    <script src="/assets/adminlte/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="/assets/adminlte/plugins/qrcode/qrcode.min.js"></script>


    <link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/css/app.css?v=1.0.5">
    <script src="/assets/adminlte/js/adminlte.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed font-sm">
    <div class="wrapper">
        @include('partial.preloader')
        @include('partial.navbar')
        @include('partial.sidebar')

        <div class="content-wrapper">

            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('partial.loading')
        @include('partial.move-to-top')
        {{-- @include('partial.footer-fixed') --}}

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            window.isLoading(false)
            moment.locale('id')
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        // check ajax request session expired
        $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            let error = options.error;
            options.error = function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 401 || jqXHR.status == 419) {
                    Swal.fire({
                        title: 'Akun',
                        text: 'Sesi login anda telah habis silahkan login ulang',
                        icon: 'error',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        confirmButtonText: 'Oke!'
                    }).then((result) => {
                        location.replace(`${window.origin}/login`);
                    })
                }

                if ($.isFunction(error)) {
                    return $.proxy(error, this)(jqXHR, textStatus, errorThrown);
                }
            };
        });

        window.isLoading = (status, text = '') => {

            $('#loading_text').text(text ? text : "tunggu, proses ...")


            if (status) {
                $('#loading').removeClass('d-none')
                return true
            }

            $('#loading').addClass('d-none')
            return false
        }

        $('.select2').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
        });
        $('.select2-no-clear').select2({
            placeholder: '',
            theme: 'bootstrap4',
        });
        $('.date-YMD').datetimepicker({
            format: 'YYYY-MM-DD'
        })
        $('.date-DMY').datetimepicker({
            format: 'DD-MM-YYYY'
        })
        $('.date-Hm').datetimepicker({
            format: 'HH:mm'
        })
        $('.date-DMYHm').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',
            icons: {
                time: 'fas fa-clock'
            }
        })
        $('.date-MY').datetimepicker({
            format: 'MM-YYYY'
        })
        $('.mask-9999-99-99').inputmask("9999-99-99");
        $('.mask-99-99-9999').inputmask("99-99-9999");
        $('.mask-99-2dot-99').inputmask("99:99");
        $('.mask-99-99-9999-space-99-2dot-99').inputmask("99-99-9999 99:99");
        $('.mask-star-star-star-star').inputmask("*-*-*-*");

        window.hitungTahun = (tanggal) => {
            let tgl = moment(tanggal, "DD-MM-YYYY")
            return moment().diff(tgl, 'years');
        }

        window.setDelay = (fn, ms) => {
            let timer = 0
            return function(...args) {
                clearTimeout(timer)
                timer = setTimeout(fn.bind(this, ...args), ms || 0)
            }
        }
        $(".only-number").keypress(evt => {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46 && evt.srcElement.value.split('.').length > 1) {
                return false;
            }
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        })

        $('[data-toggle="popover"]').popover()

        toastr.options = {
            "progressBar": true,
        }
    </script>
    @yield('javascript')
</body>
</html>

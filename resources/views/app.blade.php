<!doctype html>
<html lang="en">

<head>

    <title>{{ env('APP_NAME', 'Beiersdorf') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta data-pf-placeholder="head" name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link data-pf-placeholder="head" rel="stylesheet" type="text/css"
        href="{{ asset('css/bootstrap.min.css') }}?v=<?php echo date('Y-m-d-Hi'); ?>"> --}}
        <link data-pf-placeholder="head" rel="stylesheet" type="text/css"
        href="{{ asset('css/bootstrap4.6.min.css') }}?v=<?php echo date('Y-m-d-Hi'); ?>">
    <link data-pf-placeholder="head" rel="stylesheet" type="text/css"
        href="{{ asset('css/plugins.css') }}?<?php echo date('Y-m-d-Hi'); ?>">
    <link data-pf-placeholder="head" rel="stylesheet" type="text/css"
        href="{{ asset('css/app.css') }}?<?php echo date('Y-m-d-Hi'); ?>">
</head>

<body>

    <div data-pf-placeholder="content" data-pf-sortorder="1" data-pf-options="innerhtml">
        <div id="proxyFrameContent" class="wrapper" data-pf-proxy-url="https://azext-eu.nivea.it/nivea-promo-estate-2025/public/">
            @yield('content')
        </div>
    </div>

    <div data-pf-placeholder="content" data-pf-sortorder="1" data-pf-options="innerhtml">
        <div id="proxyFrameContent" class="wrapper" data-pf-proxy-url="https://azext-eu.nivea.it/nivea-promo-estate-2025/public/">
            <div class="overlayer">
                <div class="container position-relative vh-100 d-flex align-items-center justify-content-center">
                    <div class="row">
                        <div class="col-12 position-relative">
                            <div class="contentBlock text-center ">
                                <div class="closeBtn display-5 mb-2">Chiudi</div>
                                <div class="imageBlock">
                                    <img src="" id="imagepreview1" class="hidden center-fit img-fluid">
                                    <img src="" id="imagepreview2" class="hidden center-fit img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script data-pf-placeholder="scripts" type="text/javascript" proxyframe-sortorder="1"
        src="{{ asset('js/plugins.js') }}?<?php echo date('Y-m-d-Hi'); ?>"></script>


        <script data-pf-placeholder="scripts" type="text/javascript" proxyframe-sortorder="2"
        src="{{ asset('js/bootstrap4.6.bundle.min.js') }}?<?php echo date('Y-m-d-Hi'); ?>"></script>
    <script data-pf-placeholder="scripts" type="text/javascript" proxyframe-sortorder="3"
        src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>

    <script data-pf-placeholder="scripts" type="text/javascript" proxyframe-sortorder="4"
        src="{{ asset('js/app.js') }}?<?php echo date('Y-m-d-Hi'); ?>"></script>

    <script data-pf-placeholder="scripts" type="text/javascript" proxyframe-sortorder="5">
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


            App.GLOBAL.receiptRef =
                "{{ \Cookie::has('pf_confirmation_code') ? \Cookie::get('pf_confirmation_code') : '' }}"

            if (App.GLOBAL.receiptRef == "") {
                App.GLOBAL.receiptRef = "{{ isset($receipt_ref) ? $receipt_ref : '' }}";
            }

            App.Setup();
        });
    </script>

</body>

</html>

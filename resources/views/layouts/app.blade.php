<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JATIM PROPERTINDO</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"/>

    @stack('css')
</head>

<body>

<div class="sidenav" style="text-align: center; color: white">
    <a href="/home"><img class="imgg" style="border-radius: 1rem;" src="{{asset('img/logo.png')}}"> </a>
    <a href="/home" title="Home"><i class="fa fa-home" style="font-size:48px; color: white;"></i></a>
    <a href="{{ route('stockpile.index') }}" title="Stockpile"><img class="imgg"
                                                                    src="{{asset('img/stockpile.png')}}"></a>
    <a href="{{ route('vendor.index') }}" title="Supplier"><img class="imgg" src="{{asset('img/vendor.png')}}"></a>
    {{-- <a href="{{ route('document.index') }}" title="Document"><img class="imgg" src="{{asset('img/report.png')}}"></a> --}}
    <a href="{{ route('category.index') }}" title="Category"><i class="fa fa-navicon"
                                                                style="font-size:48px; color: white;"></i></a>
    <div class="dropdown ml-5">
        <button class="btn dropdown dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-file"
               style="font-size:48px; color: white;">
            </i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a style="font-size: 17px" class="dropdown-item" href="{{ route('report.supplier') }}">Supplier.</a>
            {{-- <a style="font-size: 17px" class="dropdown-item" href="{{ route('report.stockpile') }}">Stockpile.</a> --}}
            <a style="font-size: 17px" class="dropdown-item" href="{{ route('report.document') }}">Progress Doc.</a>
            {{-- <a style="font-size: 17px" class="dropdown-item" href="{{ route('report.supplier.group') }}">Supplier
                Group.</a> --}}

            {{--            <a style="font-size: 17px" class="dropdown-item" href="#"></a>--}}
        </div>
    </div>

    {{--    <a href="{{ route('report.supplier') }}" title="Report Supplier"><img class="imgg"--}}
    {{--                                                                          src="{{asset('img/report.png')}}"></a>--}}
    {{--    <a href="{{ route('report.stockpile') }}" title="Report Stockpile"><img class="imgg"--}}
    {{--                                                                            src="{{asset('img/report.png')}}"></a>--}}

</div>

<div class="main">
    <div class="row">
        <h1 class="col-6" style="font-family: Arial, Helvetica, sans-serif;"><b>@yield('title')</b></h1>
        <div class="card" style="background-color:#393b53;width:40%;border-radius:3rem">
            <div class="row">
                <form id="formLogout" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <h1 class="mt-3"
                    style="font-family: Arial, Helvetica, sans-serif;color:white;margin-left:auto;margin-right:15%">{{ Auth::user()->name }}</h1>

                <a style="font-size:300%;margin-right: 10%;color:white" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('formLogout').submit();"> &#x27BE</a>

            </div>
        </div>
    </div>
    {{-- @include('layouts.flash_errors') --}}
    @yield('content')
</div>
</body>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $('.dropdown-toggle').dropdown();
</script>
@stack('js')

</html>

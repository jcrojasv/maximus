@extends('layouts/base')

@section('estilos')
    
    <!-- MetisMenu CSS -->
    <link href='/css/metisMenu.min.css' type="text/css" rel="stylesheet"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400italic' rel='stylesheet' type='text/css'>
@endsection


@section('content')

    <div id="wrapper">
        <!--Menu -->
        @include('partials/menu')
        <!--Fin menu -->
        <!-- Contenido !-->
        <div id="page-wrapper">
        @yield('cuerpo')
        </div> 
    </div>
    <!-- /#wrapper -->

@endsection


@section('javascript')

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/js/sb-admin-2.js"></script>
    
    @yield('scriptsJs')
    
@endsection
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title') | Maximus - EPG</title>

    <!-- Bootstrap Core CSS -->
    <link href='/css/bootstrap.min.css' type="text/css" rel="stylesheet"/>
   
    <!-- Custom CSS -->
    <link href='/css/sb-admin-2.css' type="text/css" rel="stylesheet"/>
           
    <!-- Custom Fonts -->
    <link href='/css/font-awesome-4.6.3/css/font-awesome.min.css' type="text/css" rel="stylesheet"/>
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('estilos')     
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
     
         
   @yield('javascript')

</head>

<body>
    
    @yield('content')
  
    
    
</body>

</html>


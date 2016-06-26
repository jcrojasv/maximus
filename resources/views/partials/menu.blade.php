
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/home') }}" id='sistema'><span class="fa fa-paw"></span> Maximus V0.1</a>
  </div>
  <!-- /.navbar-header -->

  <ul class="nav navbar-top-links navbar-right">
    <li><span class="text-info" >{!! Auth::user()->name!!}</span></li>
    <!-- /.dropdown -->
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="#"><i class="fa fa-user fa-fw"></i> Mi perfil</a></li>
        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
        <li class="divider"></li>
       
        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
      </ul>
    <!-- /.dropdown-user -->
    </li>
  <!-- /.dropdown -->
  </ul>
  <!-- /.navbar-top-links -->

  <!-- Menu Principal !-->
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">

        <li>
          <a href="{{ url('home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>

        <li>
          <a href="{{ route('propietario.create') }}"><i class="fa fa-folder-open"></i> Ficha T&eacute;cnica</a>
        </li>
        
        <li>
          <a href="#"><i class="fa fa-file-text"></i> Ordenes <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="{{ route('orden.create') }}"> Crear Orden</a></li>
            <li><a href="{{ route('orden.index') }}"> Listado General</a></li>
            
          </ul>
        </li>

        

        <li>
          <a href="{{ url('mascota/') }}"><i class="fa fa-github-alt"></i> Mascotas</a>
        </li>

        <li>
          <a href="{{ url('propietario/') }}"><i class="fa fa-users"></i> Propietarios</a>

        </li>

        

        <li>
          <a href="#"><i class="fa fa-calendar"></i> Citas</a>

        </li>


        
      </ul>
      
    </div>
    <!-- /.sidebar-collapse -->
  </div>
  <!-- /Menu Principal -->
</nav>

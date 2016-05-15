
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{urlSitio}}/home"> <img src="{{dirRaiz}}images/logoSistemaP.png"></a>
  </div>
  <!-- /.navbar-header -->

  <ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="#"><i class="fa fa-user fa-fw"></i> Mi perfil</a></li>
        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
        <li class="divider"></li>
       
        <li><a href="{{urlSitio}}/usuario/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
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
        <li class="sidebar-search">
          <div class="input-group custom-search-form">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
          <!-- /input-group -->                  
        </li>
        
        <li>
          <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>
        
        {% for item in arrMenu %}
        <li {% if item.subelemento %} {% if urlModulo == item.enlace %} class="active" {% endif %}{% endif %}>
          <a href="{{item.enlace}}" > 
            {{ item.titulo | raw}}
            {% if item.subelemento %}<span class="fa-arrow"></span>{% endif %}
          </a>
            
          {% if item.subelemento %}
          
            <ul class="nav nav-second-level collapse">
            {% for subitem in item.subelemento %}
              <li {% if subitem.subelemento %} class=" {% if url == subitem.enlace or urlModulo == subitem.enlace %} active{% endif %}" {% endif %}>
                <a href="{{ subitem.enlace }}">{{ subitem.titulo | raw }}</a>
              </li>
            {% endfor %}
            </ul>
          {% endif %}
        </li>
        {% endfor %}
        
        
      </ul>
      </div>
      <!-- /.sidebar-collapse -->
  </div>
  <!-- /Menu Principal -->
</nav>

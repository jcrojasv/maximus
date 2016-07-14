@extends('layouts/app')

@section('title','Dashboard')

@section('scriptsJs')

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

@endsection

@section('cuerpo')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-clock-o fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $promHoras }}</div>
                        <div>Duracion Promedio!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $totalOrdenesAnual }}</div>
                        <div>Ordenes {{ $year }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('orden.index')}}">
                <div class="panel-footer">
                    <span class="pull-left">Ver listado</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check-square-o fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $totalOrdenesMes}}</div>
                        <div>Ordenes {{ $strMes }}</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Ver listado</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-calendar-check-o fa-4x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $totalOrdenesDia}}</div>
                        <div>Ordenes del d&iacute;a</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('orden.create')}}">
                <div class="panel-footer">
                    <span class="pull-left">Crear Orden</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-8">
        @if(!empty($ordenes))
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-calendar-check-o fa-fw"></i> Ordenes {{ $strFecha }}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <table class="table table-striped table-hover">
                <thead>
                    <th>#</th>
                    <th>Mascota / Esp / Raza</th>
                    <th>Ent/Sal</th>
                    <th>Prop / Tel</th>
                    <th>Accion</th>

                </thead>
                <tbody>
                   @foreach($ordenes as $orden)
                    <tr @if(!$orden->estatus) class="info" @endif>
                        
                        <td>{{$orden->id}}</td>
                        <td>{{$orden->nombre}} / {{ $orden->esp}} / {{ $orden->raza }}</td>
                        <td>{{$orden->entrada}} <br/> {{$orden->salida}}</td>
                        <td>
                            {{$orden->nb}}, {{$orden->ap}}
                           
                        </td>
                        <td>
                        <a href="{{route('orden.edit',['id'=>$orden->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i> Editar</a></td>
                   
                    </tr>
                    @endforeach
                </tbody>
                </table>
                
               
            </div>
            <!-- /.panel-body -->
        </div>
         @endif
        <!-- /.panel -->
        
        <h3 class="page-title">Ordenes diarias semana 27 de Junio 2016</h3>
        <div id="myfirstchart"></div>

            <script type="text/javascript">
            new Morris.Bar({
              element: 'myfirstchart',
              data: [
                { y: 'Lunes', a: 100, b: 90 },
                { y: 'Martes', a: 75,  b: 65 },
                { y: 'Miercoles', a: 50,  b: 40 },
                { y: 'Jueves', a: 75,  b: 65 },
                { y: 'Viernes', a: 50,  b: 40 },
                { y: 'Sabado', a: 75,  b: 65 },
              ],
              xkey: 'y',
              ykeys: ['a', 'b'],
              labels: ['Actual', 'Anterior']
            });
            </script>
  
    </div>
	

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Top Ten Mascotas
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                
                <div class="list-group">
                    @foreach($resultTop as $topTen)
                    <a href="#" class="list-group-item">
                         {{$topTen->mascota}}
                        <span class="pull-right text-muted small"><em>{{$topTen->total}} Ordenes</em>
                        </span>
                    </a>
                    @endforeach
                </div>
                <!-- /.list-group -->
                
                <a href="{{ route('orden.showAcumulado') }}" class="btn btn-default btn-block">Ver listado completo</a>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
                    
	
</div>

<div class="row">
    
</div>


@endsection

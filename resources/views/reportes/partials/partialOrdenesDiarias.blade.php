<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-calendar-check-o fa-fw"></i> Ordenes {{ $strFecha }}
        <div class="pull-right"><a href="{{ route('reportes.ordenesDiarias')}}"><i class="fa fa-plus"></i> Ver m&aacute;s</a></div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">

        <table class="table table-striped table-hover">
        <thead>
            <th>#</th>
            <th>Mascota / Esp / Raza</th>
            <th>Ent/Sal</th>
            <th>Tiempo</th>
            <th>Precio</th>
            <th>Accion</th>

        </thead>
        <tbody>
           @foreach($ordenes as $orden)
            <tr @if(!$orden->estatus) class="danger" @endif>
                
                <td>{{$orden->id}}</td>
                <td>{{$orden->nombre}} / {{ $orden->esp}} / {{ $orden->raza }}</td>
                <td>{{$orden->entrada}} <br/> {{$orden->salida}}</td>
                <td>{{$orden->tiempo}}</td>
                <td align="right"><b>$ {{ number_format($orden->precio, 0,',',' ')}}</b></td>
                <td>
                <a href="{{route('orden.edit',['id'=>$orden->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a></td>
           
            </tr>
            @endforeach
            <tr>
                <td colspan="2"><b>Total en pesos $</b></td>
                <td colspan="4"></td> 
            </tr>
        </tbody>
        </table>
        
       
    </div>
    <!-- /.panel-body -->
</div>
    @include('control.office.table.show',   ['route' => route('office.' . $routeController . '.show',     $id)])
    @include('control.office.table.edit',   ['route' => route('office.' . $routeController . '.edit',     $id)])
    @include('control.office.table.delete', ['route' => route('office.' . $routeController . '.destroy',  $id)])
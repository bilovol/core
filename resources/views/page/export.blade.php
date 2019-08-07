@extends('layout')
@section('content')
    @include('component/menu')
    <div id="app" class="container pt-5">
        <h1 class="h5 font-weight-bold">Экспорт</h1>
        <p>Ручной экспорт контактов в книгу SendPulse</p>
        <export></export>

    </div>
@endsection

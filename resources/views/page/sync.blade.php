@extends('layout')
@section('content')
    @include('component/menu')
    <div id="app" class="container pt-5">
        <h1 class="h5 font-weight-bold">Синхронизация</h1>
        <p>Автоматический экспорт контактов в книгу SendPulse</p>
        <synсronization></synсronization>
    </div>
@endsection

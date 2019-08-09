@extends('layout')
@section('content')
    @include('component/menu')
    <div id="app" class="container pt-5">
        <h1 class="h5 font-weight-bold">Экспорт</h1>
        <p>Ручной экспорт контактов в книгу SendPulse</p>
        <export
        gists-description="Выберите сущность для экспорта"
        gists-title="Сущность"
        books-description="Выберите книгу SendPulse"
        books-title="Книга"
        fields-title="Поля для экспорта"
        btn-title="Export"
        ></export>
    </div>
@endsection

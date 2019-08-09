@extends('layout')
@section('content')
    @include('component/menu')
    <div id="app" class="container pt-5">
        <h1 class="h5 font-weight-bold">Синхронизация</h1>
        <p>Автоматический экспорт контактов в книгу SendPulse</p>
        <synсronization
            table-event-title='Событие'
            table-book-title='Книга'
            table-fields-title='Поля'
            btn-add-event-title="Добавить событие"

            books-select-title="booksSelectTitle"
        ></synсronization>
    </div>
@endsection

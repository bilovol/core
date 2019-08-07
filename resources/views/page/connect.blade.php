@extends('layout')
@section('content')
    @include('component/menu')
    <div id="app" class="container pt-5">
        <h1 class="h5 font-weight-bold">Подключение</h1>
        <p>Поключение к сервису SendPulse</p>
        <connect
            title="Детали авторизации API SendPulse REST"
            description="Данные авторизации можно найти на странице"
            btn-check-connect-title="Check connect"
            btn-save-title="Save"
        ></connect>
    </div>
@endsection

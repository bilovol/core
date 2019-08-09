@extends('layout')
@section('content')
    <div class="twocolordiv">
        <div id="app" class="container pt-5">
            <div class="row justify-content-center align-items-center" style="height: 80vh;">
                <sp-connect
                    title="Подключение"
                    description="Данные авторизации можно найти на странице"
                    btn-connect-title="Connect"
                ></sp-connect>
            </div>
        </div>
    </div>
@endsection

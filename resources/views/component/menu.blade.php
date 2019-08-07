<nav class="navbar spi-nav" style="background: #fff">
    <ul class="nav float-left">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('synсronization*') ? 'active' : '' }}" href="/synсronization">Синхронизация</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('export*') ? 'active' : '' }}" href="/export">Экспорт</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('automation*') ? 'active' : '' }}" href="/automation">Автоматизация</a>
        </li>
    </ul>
    <ul class="nav float-right">
        <li class="nav-item m-0">
            <a class="nav-link {{ request()->is('connect*') ? 'active' : '' }}" href="/connect">Подключение</a>
        </li>
    </ul>
</nav>

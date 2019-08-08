<nav class="navbar spi-nav" style="background: #fff">
    <ul class="nav float-left">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('synсronization*') ? 'active' : '' }}" href="/synсronization">Синхронизация</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('export*') ? 'active' : '' }}" href="/export">Экспорт</a>
        </li>
    </ul>
    <ul class="nav float-right">
        <li class="nav-item m-0">
            <a class="nav-link" href="connect/drop">Выход</a>
        </li>
    </ul>
</nav>

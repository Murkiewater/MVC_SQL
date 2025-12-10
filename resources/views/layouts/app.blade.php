<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">
</head>

<body>
    <header class="header">
        <a class="header__brand" href="{{ route('users.index') }}">Nifty</a>

        <div class="separator"></div>

        <nav class="header__nav">
            <a class="header__nav-link" href="{{ route('users.index') }}"><strong>Пользователи</strong></a>
            <a class="header__nav-link" href="{{ route('groups.index') }}"><strong>Группы</strong></a>
            <a class="header__nav-link" href="{{ route('post-in-groups.index') }}"><strong>Посты</strong></a>
            @auth
                <a href="{{ url('logout') }}" class="header__nav-link"><strong>Выйти</strong></a>
            @else
                <a href="{{ url('login') }}" class="header__nav-link"><strong>Войти</strong></a>
            @endauth
        </nav>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="footer">
            <div class="footer__top">
                <div class="container">
                    <div class="footer__top-inner">
                        <div class="footer-text">
                            <p>
                                NYC <br>
                                НРТ 0000000000000<br>
                                ИНН 000000000
                            </p>
                        </div>
                    </div>
                </div>
                <div class="footer-separator"></div>
            </div>

            <nav class="footer__bottom">
                <div class="container">
                    <div class="footer__bottom-inner">
                        <div class="footer__copy">
                            Социальная Сеть Nifty © 2025
                        </div>
                    </div>
                </div>
            </nav>
        </footer>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                const timeoutDuration = 2500; 
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        alert.classList.add('fade-out'); 
                        setTimeout(function() {
                            alert.remove();
                        }, 500); 
                    }, timeoutDuration);
                });
            }
        });
    </script>
</body>
</html>
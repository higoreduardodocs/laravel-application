<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css" />

  <!-- Scripts -->
  <script src="/js/script.js" defer></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="collapse navbar-collapse" id="navbar">
        <a href="/" class="navbar-brand">
          <img src="/img/hdcevents_logo.svg" alt="Logo" />
        </a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="/" class="nav-link">Eventos</a>
          </li>
          <li class="nav-item">
            <a href="/eventos" class="nav-link">Criar eventos</a>
          </li>
          @auth
          <li class="nav-item">
            <a href="/dashboard" class="nav-link">Meus eventos</a>
          </li>
          <li class="nav-item">
            <form action="/logout" method="POST">
              @csrf
              <a
                href="/logout" class="nav-link"
                onclick="event.preventDefault();
                        this.closest('form').submit();"
              >Sair</a>
            </form>
          </li>
          @endauth
          @guest
          <li class="nav-item">
            <a href="/login" class="nav-link">Entrar</a>
          </li>
          <li class="nav-item">
            <a href="/register" class="nav-link">Cadastrar</a>
          </li>
          @endguest
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <div class="container-fluid">
      @if (session('msg'))
      <p class="msg">{{ session('msg') }}</p>
      @endif
      <div class="row">
        @yield('content')
      </div>
    </div>
  </main>

  <footer>
    <p>2023 &copy; Todos os direitos reservados</p>
  </footer>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
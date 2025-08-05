<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sawaed UAE</title>
</head>
<body>
  <nav>
    <a href="#">Home</a> |
    <a href="#">About</a> |
    <a href="#">Opportunities</a> |
    <a href="#">Dashboard</a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
  </nav>
  @yield('content')
  <footer>
    <a href="#">About</a> | <a href="#">Contact</a>
    <form id="logout-form" action="#" method="POST" class="d-none"></form>
  </footer>
</body>
</html>

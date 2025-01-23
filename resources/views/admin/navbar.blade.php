<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link own-nav-link" href="#">Golam Moktadir</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link own-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
               <a class="dropdown-item" href="javascript:void(0)">Change Password</a>
            </li>
            <li>
               <a class="dropdown-item" href="{{ route('logout') }}" 
                  onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
               Logout</a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                   @csrf
               </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<nav class="navbar navbar-expand-xl navbar-light bg-light mb-4 bordered p-3">
      <div class="container" >
          <a class="navbar-brand" href="/" ><?=Config::get("site_name")?></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav mr-auto">

            </ul>
         

            <ul class="navbar-nav">
            <?php if( (Session::get("access")) != null) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/assets/img/default.png" class="img_nav"/>
                    Julious Mark
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/accounts/logout">Log-out</a>
                    </div>
                </li>
                <?php }else { ?>
                <li class="nav-item">
                    <a class="btn btn-outline-success" href="/signup/">Sign-up</a>
                </li>
                <?php } ?>
            </ul>
          </div>
      </div>
    </nav>
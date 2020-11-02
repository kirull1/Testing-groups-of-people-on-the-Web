<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Kirulls</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Тесты</a>
                </li>
                <?php if ($_COOKIE['status'] == 1) echo '<li class="nav-item"><a class="nav-link" href="qq.php">Создать тест</a></li><li class="nav-item"><a class="nav-link" href="tests.php">Тесты</a></li><li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>';?>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Выйти</a>
                </li>
              </ul>
            </div>
          </nav>
</header>
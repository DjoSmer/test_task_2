<!doctype html>
<html lang="en">
<head>
    <title>Задачник</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row bg-dark">
    <a class="navbar-brand mr-0 mr-md-2" href="/">Задачник</a>

    <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <li class="nav-item">
<?php if ($admin): ?>
    <a class="btn btn-primary" href="logout">Выйти</a>
<?php else: ?>
            <div class="dropdown dropleft">
                <a class="nav-item nav-link mr-md-2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Админ</a>
                <div class="auth-form-dropdown-menu dropdown-menu">
                    <form id="authForm" class="px-4 py-3" method="post" action="login" autocomplete="off">
                        <div class="form-group">
                            <h5 class="card-title">Вход для персонала</h5>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="login" id="authFormLogin" placeholder="логин">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="authFormPassword" placeholder="Пароль">
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
<?php endif; ?>
        </li>
    </ul>
</header>

<main>
    <?php echo $content; ?>
    <div class="ajax-modal">
        <div class="ajax-running"></div>
    </div>
</main>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<script src="js/pagination.js"></script>
<script src="js/app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD MVC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $homeUrl; ?>public/css/style.css">
    <script type="text/javascript">
        var homeUrl = "<?php echo $homeUrl; ?>";
    </script>
</head>
<body>
    <header>
        <nav class="navbar background-primary">
            <div class="container">
                <ul class="nav-list">
                    <li><a href="<?php echo $homeUrl; ?>">Inicio</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-right"><a href="logout">Cerrar Sesión</a></li>
                    <?php else: ?>
                    <li class="nav-right"><a href="login">Iniciar Sesión</a></li>
                    <?php endif;?>                    
                </ul>
            </div>
        </nav>
    </header>
    <div class="container content">
        <h1><?php echo $title;?></h1>
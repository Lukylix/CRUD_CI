<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css"> -->
    <title><?php echo $title; ?></title>
</head>
<div class="container" style='padding-top: 20px'>
    <a class='waves-effect waves-light btn-small <?= isset($_SESSION['logged']) && $_SESSION['logged'] ? ' red' : ' green' ?>' href="<?= isset($_SESSION['logged']) && $_SESSION['logged'] ? '/logout' : '/login' ?>"><?= isset($_SESSION['logged']) && $_SESSION['logged'] ? 'logout' : 'login' ?></a>
    <?php if (!(isset($_SESSION['logged']) && $_SESSION['logged'])) : ?>
        <a class='waves-effect waves-light btn-small gray' href="register">Register</a>
    <?php endif; ?>
    <?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
        <a class="waves-effect waves-light btn-small indigo right" href=" <?= $_SERVER['HTTP_REFERER'] ?> ">Previous page</a>
    <?php endif; ?>
</div>

<body>
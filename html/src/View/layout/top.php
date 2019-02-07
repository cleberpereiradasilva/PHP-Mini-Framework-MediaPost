<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Bootstrap 3 Glyphicons -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title>Hello, world!</title>
  </head>
  <body>
<div class="container">


<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="col-10">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            <?php if(is_auth()){ ?>
              <li class="nav-item">
                <a class="nav-link" href="/users">Usuários</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/groups">Grupos</a>
              </li>              
            <?php } ?>
        </ul>
    </div>
    

    


    <?php if(is_auth()){ ?>      
      <div class="col-2">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <?php echo auth_user()->name ?>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Dados</a>
              <a class="dropdown-item" href="/logout">Logout</a>              
            </div>
          </li>
          </ul>
      </div>
    <?php } ?>




    <?php if(!is_auth()){ ?>

    <div class="col-2">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/login">Login</a>
            </li>
          </ul>
      </div>
    <?php } ?>
</nav>
  
<br /><br /><br />
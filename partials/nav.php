<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <?php if ($_SESSION['user'] ?? false) : ?>
      <a class="navbar-brand" href="#">Hii! Welcome <?php echo $_SESSION['user']['email']; ?></a>
    <?php else : ?>
      <a class="navbar-brand" href="#">Hii! Welcome</a>
    <?php endif; ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?php if ($_SESSION['user'] ?? false) : ?>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <form method="POST" action="/logout">
      <div class="navbar-nav ms-auto"> <!-- Use ms-auto to align items to the right -->
        <a class="nav-link" href="/logout">Logout</a>
      </div>
      </form>
      <!-- <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">H</a>
        <a class="nav-link" href="#">Features</a>
        <a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
      </div>
      </div> -->
    </div>
    <?php endif ?>
  </div>
  </nav>


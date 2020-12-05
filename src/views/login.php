<?php include 'header.php';?>

<?php
if ($fail_login == true) : ?>
    <div class="alert alert-danger" role="alert">
    Неправильные имя пользователя или пароль!
    </div>
<?php endif; ?>

<a href="/task/index" class="btn btn-primary">Назад</a>




<form method="post" action="">
  <div class="form-group">
    <label for="email" >Логин</label>
    <input type="text" class="form-control" name="login" id="name" placeholder="Имя">
    <?php
        if ($errors['login']) {
            echo "<span class='error'>".$errors['login']."</span>";
        }
    ?>
  </div>
  <div class="form-group">
    <label for="password">Пароль</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
    <?php
        if ($errors['password']) {
            echo "<span class='error'>".$errors['password']."</span>";
        }
    ?>
  </div>  
  <button type="submit" class="btn btn-default">Отправить</button>
</form>


<?php include 'footer.php';?>
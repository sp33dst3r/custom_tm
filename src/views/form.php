<?php include 'header.php';?>



<form method="post" action="">
    <?php
    if($id){
        echo '<input type="hidden" name="id" value="'.$id.'" />';
    }

    ?>
  <div class="form-group">
    <label for="name" >Имя</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Имя" value="<?php 
    if($_POST["name"]){
        echo $_POST["name"];
    }elseif($name){
        echo $name;
    }
    ?>">
    <?php
        if($errors['name']){
            echo "<span class='error'>".$errors['name']."</span>";
        }
    ?>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email" value="<?php 
    if ($_POST["email"]) {
        echo $_POST["email"];
    } elseif($email){
        echo $email;
    }
    
    ?>">
    <?php
        if ($errors['email']) {
            echo "<span class='error'>".$errors['email']."</span>";
        }
    ?>
  </div>
  <div class="form-group">
    <label for="text">Текст</label>
    <textarea name="text" class="form-control" id="text" cols="30" rows="10"><?php 
        if($_POST["text"]){
            echo $_POST["text"];
        }elseif($text){
            echo $text;
        }
    
    ?></textarea>
    <?php
        if($errors['text']){
            echo "<span class='error'>".$errors['text']."</span>";
        }
    ?>
  </div>
  
  
  <?php if($_SESSION['user']): ?>
  <div class="checkbox">
    <label>
      <input type="checkbox" value="true" name='status' 
        <?php 
        if ($status == '1') {
            echo 'checked';
        }
      
      ?>
      > Выполнено
    </label>
  </div>
    <?php endif; ?>
  <button type="submit" class="btn btn-default">Сохранить</button>
</form>



<?php include 'footer.php';?>
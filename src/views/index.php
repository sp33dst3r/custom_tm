<?php include 'header.php';?>

<?php
if ($message == 'ok'): ?>
    <div class="alert alert-success" role="alert">
    Запись добавлена
    </div>
<?php endif; ?>

<?php if ($_SESSION['user']) : ?>
    <a href="/admin/logout" class="btn btn-danger">Выйти</a>
<?php else: ?>
    <a href="/admin/index" class="btn btn-primary">Войти</a>
<?php endif; ?>

<?php // pred($order); ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Имя 
        <a class="sorting 
            <?php if($order == 'name' && $by == 'asc')  echo "active" ?>
        " href="/task/index/page/<?=$page?>/order/name/by/asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a class="sorting 
            <?php if($order == 'name' && $by == 'desc')  echo "active" ?>
        " 
        href="/task/index/page/<?=$page?>/order/name/by/desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    
    </th>
      <th scope="col">Email
      <a class="sorting 
            <?php if ($order == 'email' && $by == 'asc')  echo "active" ?>
             " href="/task/index/page/<?=$page?>/order/email/by/asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a class="sorting 
            <?php if ($order == 'email' && $by == 'desc')  echo "active" ?>
        " 
        href="/task/index/page/<?=$page?>/order/email/by/desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
      
      </th>
      <th scope="col">Текст</th>
      <th scope="col"
      >Статус
      <a class="sorting 
            <?php if ($order == 'status' && $by == 'asc')  echo "active" ?>
             " href="/task/index/page/<?=$page?>/order/status/by/asc">
            <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
        <a class="sorting 
            <?php if ($order == 'status' && $by == 'desc')  echo "active" ?>
        " 
        href="/task/index/page/<?=$page?>/order/status/by/desc">
            <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </th>
    <?php if ($_SESSION['user']) : ?>
        <th>Отредактировано админом</th>
        <th>Редактировать</th>
    
    <?php endif; ?>
    </tr>
  </thead>
  <tbody>
      <?php if (count($tasks)) : ?>
        <?php foreach ($tasks as $task) : ?>
            <tr>
            
            <td><?=$task['name']?></td>
            <td><?=$task['email']?></td>
            <td><?=$task['text']?></td>
            <td><?php 
                echo ($task['status'] == '1') ? 'Выполнено' : '-';
            ?></td>
            <?php if ($_SESSION['user']) : ?>
                <td> <?php if ($task['edit_by_admin'] == '1') echo 'отредактировано админом'; ?>  </td>
                <td><a href="/task/edit/id/<?=$task['id']?>/page/<?=($page ?? 1)?>/order/<?=$order?>/by/<?=$by?>/">Редактировать</a> </td>
            <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    
    
  </tbody>
</table>
<?php 
if($count > 3): ?>
    <?php
    $count_pages = ceil($count / 3);
    
    $active = $page;
    $count_show_pages = 3;
    $url = "/task/index/page/1/order/$order/by/$by/";
    $url_page = "/task/index/page/";
    if ($count_pages > 1) { 
        $left = $active - 1;
        $right = $count_pages - $active;
        if ($left < floor($count_show_pages / 2)) $start = 1;
        else $start = $active - floor($count_show_pages / 2);
        $end = $start + $count_show_pages - 1;
        if ($end > $count_pages) {
        $start -= ($end - $count_pages);
        $end = $count_pages;
        if ($start < 1) $start = 1;
        }
    ?>
  <div id="pagination">
    <span>Страницы: </span>
    <?php if ($active != 1) { ?>
      <a href="<?=$url?>" title="Первая страница">&lt;&lt;&lt;</a>
      <a href="<?php if ($active == 2) { ?><?=$url?><?php } else { ?><?=$url_page.($active - 1)."/order/$order/by/$by/"?><?php } ?>" title="Предыдущая страница">&lt;</a>
    <?php } ?>
    <?php for ($i = $start; $i <= $end; $i++) { ?>
      <?php if ($i == $active) { ?><span><?=$i?></span><?php } else { ?><a href="<?php if ($i == 1) { ?><?=$url?><?php } else { ?><?=$url_page.$i."/order/$order/by/$by/"?><?php } ?>"><?=$i?></a><?php } ?>
    <?php } ?>
    <?php if ($active != $count_pages) { ?>
      <a href="<?=$url_page.($active + 1)."/order/$order/by/$by/"?>" title="Следующая страница">&gt;</a>
      <a href="<?=$url_page.$count_pages."/order/$order/by/$by/"?>" title="Последняя страница">&gt;&gt;&gt;</a>
    <?php } ?>
  </div>
<?php } ?>
<?php endif; ?>

<a href="/task/add/" class="btn btn-primary">Добавить</a>

<?php include 'footer.php';?>
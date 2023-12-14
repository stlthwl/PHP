<?php
    $title = "Обратная связь";
    require "header.php";
?>
<div class="container" style="height: 100%;">
    <h1>Info</h1>

    <form action="chek_post.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Введите email">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">login</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Введите имя пользователя">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">password</label>
            <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Введите пароль">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Сообщение</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Введите текст сообщения"></textarea>
        </div>
    </form>
</div>

<?php
require "footer.php"
?>

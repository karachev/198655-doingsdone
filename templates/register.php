<h2 class="content__main-heading">Регистрация аккаунта</h2>

<form class="form" action="" method="post">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class="form__input <?= !empty($errors['email']) ? "form__input--error" : ""?>" type="text" name="email" id="email" value="<?=!empty($data['email']) ? htmlspecialchars($data['email']) : ""?>" placeholder="Введите e-mail">

        <p class="form__message"><?= !empty($errors['email']) ? $errors['email'] : ""?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?= !empty($errors['password']) ? "form__input--error" : ""?>" type="password" name="password" id="password" value="<?=!empty($data['password']) ? htmlspecialchars($data['password']) : ""?>" placeholder="Введите пароль">

        <p class="form__message"><?= !empty($errors['password']) ? $errors['password'] : ""?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="name">Имя <sup>*</sup></label>

        <input class="form__input <?= !empty($errors['name']) ? "form__input--error" : ""?>" type="text" name="name" id="name" value="<?=!empty($data['name']) ? htmlspecialchars($data['name']) : ""?>" placeholder="Введите имя">

        <p class="form__message"><?= !empty($errors['name']) ? $errors['name'] : ""?></p>
    </div>

    <div class="form__row form__row--controls">
        <p class="error-message <?= empty($errors) ? "hidden" : ""?>">Пожалуйста, исправьте ошибки в форме</p>

        <input class="button" type="submit" name="" value="Зарегистрироваться">
    </div>
</form>

<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>
<h1>Login</h1>

<form action="/login" method="post">
    <p>Email</p>
    <input type="text" name="email" placeholder="email address">
    <?php
    $errors = $session->get('email.errors') ?? [];
    if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li style="color: red;"><?php echo htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>Password</p>
    <input type="password" name="password" placeholder="password">
    <?php
    $errors = $session->get('password.errors') ?? [];
    if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li style="color: red;"><?php echo htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <button type="submit">Login</button>
</form>
<?php $view->component('end') ?>

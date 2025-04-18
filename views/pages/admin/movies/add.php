<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 */
?>

<?php $view->component('start') ?>
<h1>Add movie page</h1>

<form action="/admin/movies/add" method="post" enctype="multipart/form-data">
    <p>Name</p>
    <div>
        <input type="text" name="name" id="name">
    </div>

    <?php
    $errors = $session->get('name.errors')['name'] ?? [];
    if (!empty($errors)):
        ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li style="color: red;"><?php echo htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div>
        <input type="file" name="image" >


        <button type="submit">Add</button>
    </div>
</form>
<?php $view->component('end') ?>

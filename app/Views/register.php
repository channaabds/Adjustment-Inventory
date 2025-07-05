<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<form action="<?= base_url('/register/save') ?>" method="post">
    <?= csrf_field() ?>

    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= old('username') ?>">
    <?= isset($validation) ? $validation->getError('username') : '' ?>

    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <?= isset($validation) ? $validation->getError('password') : '' ?>

    <label for="confpassword">Confirm Password</label>
    <input type="password" name="confpassword" id="confpassword">
    <?= isset($validation) ? $validation->getError('confpassword') : '' ?>

    <label for="role">Role</label>
    <select name="role" id="role">
    <option value="">pilih role</option>
        <option value="LEADERMFG1">LEADERMFG1</option>
        <option value="LEADERMFG2">LEADERMFG2</option>
        <option value="PIC2">PIC2</option>
        <option value="PIC">PIC</option>
        <option value="MFG2">MFG2</option>
        <option value="MFG1">MFG1</option>
        <option value="IT">IT</option>
        <option value="USER">USER</option>
    </select>
    <?= isset($validation) ? $validation->getError('role') : '' ?>

    <button type="submit">Register</button>
</form>

</body>
</html>

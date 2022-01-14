<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            outline: 0;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            height: 100vh;
            background-image: url(https://komerce.id/blog/wp-content/uploads/2021/08/ilustrasi-gudang.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px 25px;
            width: 300px;

            background-color: rgba(0, 0, 0, .7);
            box-shadow: 0 0 10px rgba(255, 255, 255, .3);
        }

        .container h1 {
            text-align: left;
            color: #fafafa;
            margin-bottom: 30px;
            text-transform: uppercase;
            border-bottom: 4px solid #2979ff;
        }

        .container label {
            text-align: left;
            color: #90caf9;
        }

        .container input {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin-bottom: 15px;
            border: none;
            background-color: transparent;
            border-bottom: 2px solid #2979ff;
            color: #fff;
            font-size: 20px;
        }

        .container button {
            width: 100%;
            padding: 5px 0;
            border: none;
            background-color: #2979ff;
            font-size: 18px;
            color: #fafafa;
        }
    </style>
</head>

<body>
    <!-- <h2>Login</h2>
    <?php echo validation_errors(); ?>
    <?php echo @$message ? $message : ""; ?>
    <?php echo form_open('AuthController/login'); ?>
    <input type="text" name="username" value="<?php echo set_value('username'); ?>">
    <input type="text" name="password" value="<?php echo set_value('password'); ?>">
    <input type="submit" value="Login">
    </form> -->

    <div class="container">
        <?php echo validation_errors(); ?>
        <h4 style="color:red"><?php echo @$message ? $message : ""; ?></h4>
        <h1>Login</h1>
        <?php echo form_open('AuthController/login'); ?>
        <label>Username</label><br>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>"><br>
        <label>Password</label><br>
        <input type="password" name="password" value="<?php echo set_value('password'); ?>"><br>
        <button type="submit">Log in</button>
        </form>
    </div>
</body>

</html>
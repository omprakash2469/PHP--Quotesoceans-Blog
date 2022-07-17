<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <title>QuotesOceans.com || Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Open sans', sans-serif;
        }

        body {
            background: #eee !important;
        }

        .wrapper {
            margin: 100px 0px;
        }

        .form-signin {
            max-width: 380px;
            padding: 30px 35px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 30px;
        }

        .form-signin .checkbox {
            font-weight: normal;
            display: block;
        }

        .form-signin .form-control {
            width: 100%;
            position: relative;
            font-size: 16px;
            margin-bottom: 22px;
            height: auto;
            padding: 13px;
            border: 1px solid grey;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            cursor: pointer;
        }

        .btn:hover,
        .btn:focus {
            background-color: coral;
            color: white;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form class="form-signin" action="" method="POST">
            <h2 class="form-signin-heading">Login</h2>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username*" required="" autofocus="" />
            <input type="password" class="form-control" name="password" id="password" placeholder="Password*" required="" />
            <?php if (isset($loginError)) : ?>
                <p class="alert"><?php echo $loginError; ?></p>
            <?php endif; ?>
            <label class="checkbox">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
            </label>
            <input type="hidden" name="action" value="login">
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>

</body>

</html>
<?php 

// var_dump($message);

?>
<?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/users/login.css">
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="/assets/js/register.js"></script>
</head>
<body>
    <header>
        <div><h1 id="header-title">V88 Merchandise</h1></div>
        <p>Login</p>
    </header>
    <main>
<?php   if(isset($message)){
?>              <div>
                    <?= $message ?>
                </div>
<?php            }
?>        <h1>Register</h1>
        <form action="/users/register_user" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"/>
            <label for="email">Email address:</label>
            <input type="text" name="email" id="email" class="error"/>
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" id="first_name" class="error"/>
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" id="last_name" class="error"/>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="error"/>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="error"/>
            <input type="submit" value="Register" class="green-background"/>
        </form>
        <a href="login" id="link-login">Already have an account? Login</a>
    </main>
</body>
</html>
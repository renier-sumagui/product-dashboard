<?php $this->load->view('partials/header') ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/users/login.css">
    <title>Login</title>
</head>
<body>
    <header>
        <h1 id="header-title">V88 Merchandise</h1>
        <p id="header-register">Register</p>
    </header>
    <main>
<?php   if(!empty($this->session->flashdata('message'))){
?>        <div>
            <?= $this->session->flashdata('message'); ?>
        </div>
<?php   }
?>        <h1>Login</h1>
        <form action="/users/login_user" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <label for="email">Email address:</label>
            <input type="text" name="email" id="email"/>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password"/>
            <input type="submit" value="Login" class="green-background"/>
        </form>
        <a href="register" id="link-register">Don't have an account? Register</a>
    </main>
</body>
</html>
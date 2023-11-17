<?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/users/edit.css">
    <title>Edit Profile</title>
</head>
<body>
    <header>
        <div>
            <h1>V88 Merchandise</h1>
            <a href="/dashboard/index">Dashboard</a>
            <a href="/users/edit">Profile</a>
        </div>
        <a href="/users/logoff">Logoff</a>
    </header>
    <main>
        <h1>Edit Profile</h1>
        <form action="/users/edit_user" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"/>
            <fieldset>
                <legend>Edit Information</legend>
                <label for="email">Email address:</label>
                <input type="text" name="email" placeholder="(email address of the user)"/>
                <label for="first_name">First name:</label>
                <input type="text" name="first_name" id="first_name" placeholder="(first name of the user)"/>
                <label for="last_name">Last name:</label>
                <input type="text" name="last_name" id="last_name" placeholder="(last name of the user)"/>
                <input type="submit" value="Save" class="green-background"/>
            </fieldset>
        </form>
        <form action="/users/edit_password" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"/>
            <fieldset>
                <legend>Change Password</legend>
                <label for="old_password">Old Password:</label>
                <input type="password" name="old_password" id="old_password"/>
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password"/>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation"/>
                <input type="submit" value="Save" class="green-background"/>
            </fieldset>
        </form>
<?php if($this->session->flashdata('message') !== NULL){
?>      <div class="message">
        <?= $this->session->flashdata('message') ?>
        </div>
<?php }
?>    </main>
</body>
</html>
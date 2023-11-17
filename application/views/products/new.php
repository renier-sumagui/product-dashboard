<?php $this->load->view('partials/header') ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/products/new.css">
    <title>Admin | New Product</title>
</head>
<body>
    <header>
        <div>
            <h1>V88 Merchandise</h1>
            <a href="/dashboard/index">Dashboard</a>
            <a href="/users/edit">Profile</a>
        </div>
        <a href="#">Logoff</a>
    </header>
    <main>
        <div id="title-link-container">
            <h1>Add a new Product</h1>
            <a href="/dashboard/index" id="link-blue-background">Return to Dashboard</a>
        </div>
        <form action="/products/add_new_product" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"/>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="(product name)"/>
            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="(product description)"></textarea>
            <label for="price">Price:</label>
            <input type="text" name="price" id="price"/>
            <label for="inventory_count">Inventory Count:</label>
            <input type="number" name="inventory_count" min="0" max="99"id="inventory_count"/>
            <input type="submit" value="Create" class="green-background">
        </form>

<?php        if($this->session->flashdata('message') !== NULL){
?>        <div id="message">
            <?= $this->session->flashdata('message') ?>
        </div>
<?php       }
?>     </main>
</body>
</html>
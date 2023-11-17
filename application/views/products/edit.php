<?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/products/new.css">
    <title>Admin | Edit Product</title>
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
            <h1>Edit Product #<?= $product_id ?></h1>
            <a href="/dashboard/index" id="link-blue-background">Return to Dashboard</a>
        </div>
        <form action="/products/edit_product" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"/>
            <input type="hidden" name="product_id" value="<?= $product_id ?>"/>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="(product name)"/>
            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="(product description)"></textarea>
            <label for="price">Price:</label>
            <input type="text" name="price" id="price"/>
            <label for="inventory_count">Inventory Count:</label>
            <input type="number" name="inventory_count" min="0" max="99"id="inventory_count"/>
            <input type="submit" value="Save" class="green-background">
        </form>
        <?php        if($this->session->flashdata('message') !== NULL){
?>        <div id="message">
            <?= $this->session->flashdata('message') ?>
        </div>
<?php       }
?>
    </main>
</body>
</html>
<?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/dashboard/admin.css">
    <title>Admin | Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.remove').click(function(){
                $('.popupOverlay, .popupContent').addClass('active');
                var productId = $(this).attr('product-id-attribute')
                $('.yes').click(function(){
                    $(this).attr('href', '/products/remove_product/' + productId);
                    
                });
                $('.no').click(function(){
                    $('.popupOverlay, .popupContent').removeClass('active');
                });
            });

            
        });
    </script>
</head>
<body>
    <div class="popupOverlay">
        <div class="popupContent">
            <h1>Are you sure?</h1>
            <a href="#" class="yes">Yes</a>
            <a href="#" class="no">No</a>
        </div>
    </div>
    <header>
        <div>
            <h1>V88 Merchandise</h1>
            <a href="/dashboard/index">Dashboard</a>
            <a href="/users/edit">Profile</a>
        </div>
        <a href="/users/logoff">Logoff</a>
    </header>
    <main>
        <div id="title-link-container">
            <h1>Manage Products</h1>
            <a href="/products/new" id="link-blue-background">Add new</a>
        </div>
        <table>
            <thead class="gray-background">
                <th>ID</th>
                <th>Name</th>
                <th>Invertory Count</th>
                <th>Quantity Sold</th>
                <th>Action</th>
            </thead>
<?php   if(!empty($products)){
?>            <tbody>
<?php       foreach($products as $key => $row){
?>                <tr class="color<?= $key%2?>">
                    <td><?= $row['id'] ?></td>
                    <td><a href="/products/show/<?= $row['id'] ?>"><?= $row['name'] ?></a></td>
                    <td><?= $row['inventory_count'] ?></td>
                    <td><?= $row['quantity_sold'] ?></td>
                    <td class="add-remove-item">
                        <a href="/products/edit/<?= $row['id'] ?>">edit</a>
                        <a href="#" product-id-attribute = "<?= $row['id'] ?>" class="remove">remove</a>
                    </td>
                </tr>
<?php       }
?>            </tbody>
<?php        }
?>        </table>
    </main>
</body>
</html>
<?php $this->load->view('partials/header'); ?>
    <title>User | Dashboard</title>
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
        <div id="title-link-container">
            <h1>All Products</h1>
        </div>
        <table>
            <thead class="gray-background">
                <th>ID</th>
                <th>Name</th>
                <th>Invertory Count</th>
                <th>Quantity Sold</th>
            </thead>
<?php   if(!empty($products)){
?>            <tbody>
<?php       foreach($products as $key => $row){
?>                <tr class="color<?= $key%2 ?>">
                    <td><?= $row['id'] ?></td>
                    <td><a href="/products/show/<?= $row['id'] ?>"><?= $row['name'] ?></a></td>
                    <td><?= $row['inventory_count'] ?></td>
                    <td><?= $row['quantity_sold'] ?></td>
                </tr>
<?php       }
?>            </tbody>
<?php        }
?>        </table>
    </main>
</body>
</html>
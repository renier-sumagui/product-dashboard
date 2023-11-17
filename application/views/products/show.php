
<?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" type="text/css" href="/assets/css/products/show.css">
    <title>Product Information</title>
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
        <div id="product-information-container">
            <h1 id="product-name"><?= $product['name'] ?> ($<?= $product['price'] ?>)</h1>
            <p>Added since: <?= $product['date'] ?></p>
            <p>Product ID: #<?= $product['id'] ?></p>
            <p>Description: <?= $product['description'] ?></p>
            <p>Total sold: <?= $product['quantity_sold'] ?></p>
            <p>Number of available stocks: <?= $product['inventory_count'] ?></p>
        </div>
        <div id="reviews-and-comments-container">
            <div id="leave-a-review-container">
                <h2>Leave a Review</h2>
                <form action="/reviews/add_review" method="POST" id="review-form">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>"/>
                    <textarea name="review_content" id="review"></textarea>
                    <input type="hidden" name="product_id" value="<?= $product['id']  ?>"/>
                    <input type="submit" value="Post" class="green-background"/>
                </form>
            </div>
            <div id="reviews-and-comments-container">

<?php       if(isset($product_reviews)){
                foreach($product_reviews as $key => $review){
?>                <div class="review-container">
                    <p class="review-header"><span class="reviewee"><?= $review['name'] ?>&nbsp;</span>wrote:<span class="review-time"><?= $review['date'] ?></span></p>
                    <p class="review-details"><?= $review['content'] ?></p>

<?php               if(!empty($comments[$key])){
                        foreach($comments[$key] as $comment){
?>                    <div class="comments-container">
                          <p class="comment-header"><span class="commentee"><?= $comment['name'] ?></span>&nbsp;wrote:<span class="review-time"><?= $comment['created_at'] ?></span></p>
                        <p class="comment-details"><?= $comment['content'] ?></p>
                    </div>
<?php                        }
                    }
?>                    <form action="/comments/add_comment" method="POST" class="form-comments">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"/>
                        <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>"/>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>"/>
                        <textarea name="comment_content" class="add-comment" placeholder="Write a message"></textarea>
                        <input type="submit" value="Post" class="green-background"/>
                    </form>
                </div>
<?php           }
            }
?>            </div>
        </div>
    </main>
</body>
</html>
<?php
include_once 'views/head.php';
?>
<main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Products</h2>
        <div>
            <a href="index.php">
                <button class="btn btn-primary">List product</button>
            </a>
        </div>
    </div>

    <!-- Product Form 1 -->
    <form class="product-form" method="POST" action="index.php?action=update&id=<?php echo $product->id ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $product->name ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" min="0" name="price" value="<?php echo $product->price ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <img src="<?php echo storage($product->image) ?>" width="200px" height="300px" alt="">
            <input type="file" class="form-control" name="image">
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="text" class="form-control" name="quantity" value="<?php echo $product->quantity ?>">
        </div>
        <button type="submit" name="btnSave" value="save" class="btn btn-success">Save</button>
    </form>
</main>
<?php
include_once 'views/footer.php';
?>
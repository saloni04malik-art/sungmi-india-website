<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

$sql = "SELECT id, display_order, name, category, short_description, image, status
        FROM products
        WHERE is_deleted = 0
        ORDER BY display_order ASC, id ASC";

$result = mysqli_query($conn, $sql);
require_once "../includes/header.php";

$catMap = [
    'door'    => 'Doors (door)',
    'wall'    => 'Wall Panels (wall)',
    'ceiling' => 'Ceiling Panels (ceiling)',
    'wetunit' => 'Marine Wet Units (wetunit)',
    'cabin'   => 'Modular Cabins (cabin)'
];
?>

<div class="page-header">


    <a href="add.php" class="btn btn-sm btn-success">Add Product</a>

</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="productTable">

    <thead>

        <tr>
            <th>Order</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category / 360</th>
            <th>Short Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

    </thead>

    <tbody>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($product = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td>
                    <?php echo $product['display_order']; ?>
                </td>

                <td>

                    <?php if (!empty($product['image'])) { ?>

                        <img
                            src="../../<?php echo htmlspecialchars($product['image']); ?>"
                            width="80"
                            alt=""
                        >

                    <?php } else { ?>

                        No Image

                    <?php } ?>

                </td>

                <td>
                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                </td>

                <td>
                    <?php 
                    $catVal = $product['category'] ?? '';
                    if (!empty($catVal)) {
                        $label = $catMap[$catVal] ?? htmlspecialchars($catVal);
                        echo '<span style="display:inline-block; padding:3px 8px; font-size:12px; font-weight:600; background:#e0f2fe; color:#0284c7; border:1px solid #bae6fd; border-radius:6px;">' . htmlspecialchars($label) . '</span>';
                    } else {
                        echo '<span style="color:#9ca3af; font-size:12px;">Not set</span>';
                    }
                    ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($product['short_description'] ?? ''); ?>
                </td>

                <td>

                    <?php if ($product['status'] == 1) { ?>

                        Active

                    <?php } else { ?>

                        Inactive

                    <?php } ?>

                </td>

                <td>

                    <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $product['id']; ?>">
                        Edit
                    </a>

                    

                    <form
                        method="POST"
                        action="delete.php"
                        style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this product?');"
                    >

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $product['id']; ?>"
                        >

                        <button type="submit" class="btn btn-sm btn-danger">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        <?php } ?>

    <?php } else { ?>

        <tr>
            <td colspan="7">No products found.</td>
        </tr>

    <?php } ?>

    </tbody>

</table>
</div>


<?php
include "../includes/footer.php";
?>
<script>
    $(document).ready(function(){
        $('#productTable').DataTable();
    });
</script>
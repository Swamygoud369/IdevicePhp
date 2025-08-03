

<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php"); ?>
 <style>
        .about_text_display {
            font-size: 16px;
            color: rgb(51, 51, 51);
            margin-bottom: 20px;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            text-align: center;
        }
    </style>
<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5 col-sm-4">
                                <h5 class="card-title">About Us</h5>
                            </div>
                            <div class="col-md-7 col-sm-8 text-end">
                                <?php
                                $result = $conn->query("SELECT * FROM about_us LIMIT 1");
                                $row = $result->fetch_assoc();
                                if ($row): ?>
                                    <a href="aboutus_form.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="ti ti-pencil-alt"></i> Edit About</a>
                                <?php else: ?>
                                    <a href="aboutus_form.php" class="btn btn-primary"><i class="ti ti-square-rounded-plus"></i> Add About</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($row): ?>
                            <div class="mt-5">
                                <div class="card mb-3">
                                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Image" style="height: 80px;width: 80px;">
                                    <div class="card-body">
                                    <div class="about_text_display">
                                    <!-- <?php echo $row ? $row['about_text'] : ''; ?> -->
                                    <?php echo $row ? nl2br(html_entity_decode($row['about_text'])) : ''; ?>

                                    </div>
                                        <!-- <p class="card-text"><?php echo htmlspecialchars($row['about_text']); ?></p> -->
                                    </div>
                                    <div class="card-footer text-muted">
                                        Created at: <?php echo htmlspecialchars($row['created_at']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
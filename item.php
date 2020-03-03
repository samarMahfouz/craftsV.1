<?php
session_start();
    $pageTitle = 'item page';
    include 'init.php';

    $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $fid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);

    $stmt = $con->prepare("SELECT
                                  *
                             FROM
                                items
                             WHERE id= ?");
    $stmt->execute(array($fid));
    $items = $stmt->fetchAll();
    foreach($items as $item) {
      ?>
    <!-- Start my designs -->

    <section class="my-design Thedesign" id="design">
      <div class="container">
        <h2 class="designh2 text-center"><?php echo $item['name']?></h2>
        <div class="row designone">
          <div class="col-md-6">
          <img src="<?php echo $itemss . $item['image']?>" alt=""/>
          </div>
          <div class="col-md-6">
            <p class="lead"><?php echo $item['description']?></p>
          </div>
      </div>
        <?php
            }
            ?>
      </div>
    </section>
    <!-- End my designs -->
    </div>
    </div>
<?php
include $temps . 'footer.php';
?>

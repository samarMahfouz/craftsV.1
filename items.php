<?php
session_start();
    $pageTitle = 'items page';
    include 'init.php';
    $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;?>
    <!-- Start my designs -->
    <section class="my-design" id="design">
      <div class="container">
        <h2 class="text-center">my designs</h2>
        <ul class="link text-center">
          <li class="selected filter" data-filter="all">all</li>
          <li  class="filter" data-filter=".crafts">crafts</li>
          <li class="filter" data-filter=".miniature">miniature</li>
          <li class="filter" data-filter=".polymerclay">polymerclay</li>
        </ul>
        <section id="gallery" class="gallery">
          <div class="row">
            <?php
            $stmt = $con->prepare("SELECT
                                          items.*, categories.name AS cat_name
                                     FROM
                                        items
                                     INNER JOIN
                                        categories
                                     ON
                                        categories.id = items.cat_id
                                     ");
            $stmt->execute();
            $items = $stmt->fetchAll();
            foreach($items as $item) {
              ?>
              <div class="col-md-3 mixx">
                <a href="item.php?id=<?php echo $item['id']?>">
                   <div class="mix <?php echo $item['cat_name']?>">
                    <h4><?php echo $item['name']?></h4>
                    <img src="<?php echo $itemss . $item['image']?>" alt=""/>
                  </div>
                  </a>
              </div>
                <?php
            }
            ?>
          </div>
        </section>
      </div>
    </section>
    <!-- End my designs -->
    </div>
    </div>
<?php
include $temps . 'footer.php';
?>

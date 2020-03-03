<?php
session_start();
  $pageTitle = "samar dünyası";
  include 'init.php';
  ?>
    <!-- Start header -->
    <header>
      <div class="overlay">
        <div class="container">
          <section>
            <h1 class="">welcome to my website</h1>
            <p>crafts, miniature and more</p>
          </section>
        </div>
      </div>
    </header>
    <!-- End header -->
    <!-- Start my designs -->
    <section class="my-design" id="design">
      <div class="container">
        <h2>my designs</h2>
        <ul class="link">
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
    <!-- Start testmonials -->
    <section id="testi" class="testi">
      <div class="overlay">
        <div class="container">
            <h2>what friends say?</h2>
            <section class="slider">
              <?php
              $stmt = $con->prepare("SELECT
                                            comments.*, users.username AS user_name
                                       FROM
                                          comments
                                       INNER JOIN
                                          users
                                       ON
                                          users.id = comments.user_id
                                       ");
              $stmt->execute();
              $rows = $stmt->fetchAll();
              foreach($rows as $row){
                echo '<section class="stylecomment">';
                  echo '<q>'. $row['comment'] .'</q>';
                  echo '<p>'. $row['user_name'] .'</p>';
                echo '  </section>';
              }
              ?>
          </section>
        </div>
      </div>
    </section>
    <!-- End testmonials -->
    <!-- Start about me  -->
    <section class="about" id="about">
      <div class="container">
        <section class="con">
          <h2>about me</h2>
          <section class="img"><img src="<?php echo $images;?>myim.jpg" alt=""/></section>
          <section class="info">
            <?php
            $stmt = $con->prepare("SELECT * FROM users where id = 1");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $row){
              echo '<section>';
                echo '<h3>'. $row['fullname'] .'</h3>';
                echo '<p>'. $row['job'] .'</p>';
              echo '  </section>';
            }
            ?>
            <p></p>
          </section>
        </section>
          <hr>
      </div>
    </section>
    <!-- End about me  -->
<?php include $temps . 'footer.php';?>

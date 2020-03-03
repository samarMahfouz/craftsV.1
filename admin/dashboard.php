<?php
  session_start();
  if(isset($_SESSION['email'])){ 
    $pageTitle = 'Dashboard';
    include 'init.php';
    ?>
    <div class="dashboard all-c">
      <div class="container">
          <h1 class="text-center dashhead">Dashboard</h1>
        <div class="row ">
          <div class="col-md-4">
            <a href="users.php">
              <section class="contents users">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span class="spand"><?php echo countRows('id', 'users'); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>Users</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <a href="categories.php">
              <section class="contents sections">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows('id', 'categories'); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>Categories</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>

          <div class="col-md-4">
            <a href="items.php?do=Manage&id=1">
              <section class="contents storys">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows2(1); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>Crafts</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <a href="items.php?do=Manage&id=7">
              <section class="contents novil">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows2(7); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>resin</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <a href="items.php?do=Manage&id=2">
              <section class="contents kasira">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows2(2); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>miniature </h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <a href="items.php">
              <section class="contents khawater">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows2(3); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>ploymer clay</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <a href="comments.php">
              <section class="contents comments">
                <div class="row">
                  <div class="col-md-6 text-center">
                    <span  class="spand"><?php echo countRows('id', 'comments'); ?></span>
                  </div>
                  <div class="col-md-6">
                    <h2>Comments</h2>
                  </div>
                </div>
              </section>
            </a>
          </div>
          <div class="col-md-4">
            <section class="contents likes">
              <div class="row">
                <div class="col-md-6 text-center">
                  <span  class="spand"><?php echo countRows('id', 'likes'); ?></span>
                </div>
                <div class="col-md-6">
                  <h2>Likes</h2>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-4">
            <section class="contents shares">
              <div class="row">
                <div class="col-md-6 text-center">
                  <span  class="spand"><?php echo countRows('id', 'views'); ?></span>
                </div>
                <div class="col-md-6">
                  <h2>Views</h2>
                </div>
              </div>
            </section>
          </div>
        </div>
          <div class="sec-sec">
            <div class="row">
            <div class="col-md-6">
              <div class="last last-users">
                <h3 class="com-header">The Latest Users</h3>
                <div class="most">
                  <ul class="list-unstyled">
                  <?php
                    $lcoms = gLatest('*', 'users', 'id', $limit = 5);
                    echo '<li class="lis">
                            <span class="spans fnamec">name</span>
                          </li>';
                    foreach($lcoms as $lcom) {
                      echo '<li  class="srcls">

                              <span class="fcc">' . $lcom['username'] . '</span>

                             </li>';
                     }
                  ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="last last-users">
                <h3  class="com-header">The Latest comments</h3>
                <div class="most">
                  <ul class="list-unstyled">
                  <?php
                    $lcoms = gLatest('*', 'comments', 'id', $limit = 7);
                    echo '<li><span class="fnamec">name</span><span  class="fcommentc">comment</span></li>';
                    foreach($lcoms as $lcom) {
                        echo '<li  class="srcls"><span  class="fcc">' . $lcom['user_id'] . '</span><span class="fnc">' . $lcom['comment'] . '</span></li>';
                    }
                  ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

          </div>
        </div>
      </div>
    </div>
    <?php include $temps . 'footer.php';
}else{
  header('Location:index.php');
  exit();
}
?>

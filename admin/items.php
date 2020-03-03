<?php
  ob_start();
  session_start();
  $pageTitle = 'Items';
  if(isset($_SESSION['email'])) {
    include 'init.php';
      $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
      $fid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);

    $fdo = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $do =  filter_var(strip_tags($fdo), FILTER_SANITIZE_STRING);
    if($do == 'Manage'){
        $stmtM = $con->prepare("SELECT
                                      items.*, categories.name AS cat_name
                                 FROM
                                    items
                                 INNER JOIN
                                    categories
                                 ON
                                    categories.id = items.cat_id
                                 WHERE cat_id = ?");
        $stmtM->execute(array($fid));
        $mans = $stmtM->fetchAll();
        ?>
        <div class="users ">
          <div class="container">
            <h2 class="text-center sections-header">items page</h2>
            <div class="users-table sections-table">
              <table>
                <thead>
                  <tr>

                    <td>control</td>
                    <td>comments</td>
                    <td>likes</td>
                    <td>views</td>
                    <td>category</td>
                    <td>name</td>
                  </tr>
                </thead>
                <?php
                foreach($mans as $man){
                ?>
                <tbody>
                  <td>
                    <button class="btn btn-danger"><a href="?do=Delete&id=<?php echo $man['id']; ?>">Delete</a></button>
                    <button class="btn btn-info"> <a href="?do=Edit&id=<?php echo $man['id']; ?>">Edit</a></button>
                  </td>
                  <td><?php echo countColumn('comment', 'comments', 'post_id', $man['id']); ?></td>
                  <td><?php echo countColumn('likeit', 'likes', 'post_id', $man['id']); ?></td>
                  <td><?php echo countColumn('viewit', 'views', 'post_id', $man['id']); ?></td>
                  <td>
                    <a class="sname" href="categories.php"><?php echo htmlspecialchars($man['cat_name']);?></a>
                  </td>
                  <td>
                    <a class="sname" href="items.php?do=Manage&id=<?php echo $man['id']; ?>"><?php echo htmlspecialchars($man['name']);?></a>
                  </td>
                </tbody>
                <?php } ?>
              </table>
              <a href="?do=Add" class="btn user-btn">Add new</a>
            </div>
          </div>
        </div>
      <?php
    }elseif($do == 'Add'){
      ?>
      <div class=" add-sec all-c">
        <div class="container">
          <h1 class="text-right">Add new </h1>
          <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <input  type="text" name="name" class="form-control" autocomplete="off"
                  required="required"  placeholder="Article name "/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <textarea name="description"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <input  type="file" name="image" class="form-control"
                  required="required"/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <select name="cat_id">
                <option value="0">...</option>
                <?php
                  $stmt = $con->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $sections = $stmt->fetchAll();
                  foreach($sections as $section) {
                    echo "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";

                  }
                ?>
               </select>
              </div>
            </div>
            <div class="col-sm-10 col-md-6 pull-right">
              <input type="submit" class="btn btn-info" value="save"  />
            </div>
          </form>
        </div>
        </div>
      <?php
    }elseif($do == 'Insert'){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];

        $imageAllowedExtension = array('jpeg', 'jpg', 'png', 'gif');
        $imageExtension = strtolower(end(explode('.', $imageName)));
        if(!in_array($imageExtension, $imageAllowedExtension)){
          $theMsg =  '<div class="btn btn-danger">you should add an image.   </div>';
          redirectTo($theMsg, 'items.php?do=Add');
        }
        $name = $_POST['name'];
        $catid = $_POST['cat_id'];
        $desc = $_POST['description'];
          $image = rand(0, 100000) . '_' . $imageName;
          move_uploaded_file($imageTmp, "uploads/items/" . $image);
        ?>
        <div class=" add-sec all-c">
          <div class="container">
            <?php
              $stmt = $con->prepare("INSERT INTO items(name, cat_id, description, image) VALUES(:zname, :zcatid, :zdesc, :zimage)");
              $stmt->execute(array(
                'zname'  => $name,
                'zcatid' => $catid,
                'zdesc'  => $desc,
                'zimage' => $image
              ));

              $theMsg =  '<div class="btn btn-success">the item is added   </div>';
              redirectTo($theMsg, 'items.php');
            ?>
          </div>
        </div>
            <?php
      }else{
        $theMsg =  '';
        redirectTo($theMsg, 'items.php', 0);
      }
    }elseif($do == 'Edit'){
      $fid  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
      $id =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);
      $stmtE = $con->prepare("SELECT * FROM items WHERE id= ?");
      $stmtE->execute(array($id));
      $mans = $stmtE->fetch();
      $countE = $stmtE->rowCount();
      if($countE > 0){
      ?>
      <div class=" add-sec all-c">
        <div class="container">
          <h1 class="text-right">Edit the article </h1>
          <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <input  type="text" name="name" class="form-control" autocomplete="off"
                  required="required" value="<?php echo $mans['name']; ?>"/>
              </div>
            </div>
            <div class="col-sm-10 col-md-6 pull-right">
              <input type="submit" class="btn btn-info" value="save"  />
            </div>
          </form>
        </div>
        </div>
      <?php
      }else{
        $theMsg =  '';
        redirectTo($theMsg, 'items.php', 0);
      }
    }elseif($do == 'Update'){
      echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $id = $_POST['id'];
          $name = $_POST['name'];

          $stmt  = $con->prepare("UPDATE
                                    items
                                  SET
                                  name =?
                                  WHERE
                                    id = ?  ");
          $stmt->execute(array($name, $id));
          $theMsg =  '<div class="btn btn-success">the item is updated.   </div>';
          redirectTo($theMsg, 'items.php');
        }else{
          $theMsg =  '';
          redirectTo($theMsg, 'items.php', 0);
        }

      echo "</div>";
    }elseif($do == 'Delete'){
        $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
          $secid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);
    ?>
    <div class="all-c users">
      <div class="container">
        <?php
          // hello to make it more dynamic function
          $udstmt = $con->prepare("SELECT * FROM items WHERE id = ?");
          $udstmt->execute(array($secid));
          $count = $udstmt->rowCount();
          if($count > 0){
            $udastmt = $con->prepare("DELETE FROM items WHERE id = ? LIMIT 1");
            $udastmt->execute(array($secid));
            $theMsg =  '<div class="btn btn-success">the item is deleted.   </div>';
            redirectTo($theMsg, 'items.php');
          }else{
            $theMsg =  '<div class="btn btn-danger">there is no such id.   </div>';
            redirectTo($theMsg, 'items.php');
          }
    }else{
      $theMsg =  '';
      redirectTo($theMsg, 'dashboard.php');
    }
    ?>
    </div>
    </div>
<?php
include $temps . 'footer.php';
}else{
  header('Location:index.php');
  exit();
}
  ob_end_flush(); // Release the output
?>

<?php
    include "connection.php";

    //sel all todos
    $sel_todo = "select * from story where status = 'todo'";
    $run_sel_todo = mysqli_query($con, $sel_todo);
    $count_todo = mysqli_num_rows($run_sel_todo);

    //sel all doing
    $sel_doing = "select * from story where status = 'doing'";
    $run_sel_doing = mysqli_query($con, $sel_doing);
    $count_doing = mysqli_num_rows($run_sel_doing);

    //sel all done
    $sel_done = "select * from story where status = 'done' order by story_id desc";
    $run_sel_done = mysqli_query($con, $sel_done);
    $count_done = mysqli_num_rows($run_sel_done);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

     <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <!--jquery-->
   <script src="js/jquery-3.4.1.js"></script>
   <!-- Main Stylesheet File -->
   <link href="css/style.css" rel="stylesheet">

    <title>Scrum Master</title>
    <style>
        *{
            padding: 0;
            margin:0;
        }
        body{
            height: 100vh;
            font-family: 'Times New Roman', Times, serif;
            background-color: burlywood;
            margin-left: auto;
            margin-right: auto;
        }
        .top .add-story{
            cursor: pointer;
        }
        #sec1, #sec2, #sec3{
            height: 70vh;
            overflow-y: scroll;
        }
        .story{
            width: 300px;
            font-weight:900;
            margin-top:10px;
            margin-left:auto;
            margin-right:auto;
            padding:10px 10px 10px 10px;
        }
        .todo{
            background: rgb(230, 82, 82);
        }
        .doing{
            background: rgb(236, 236, 148);
        }
        .done{
            background: rgb(43, 131, 43);
        }
        .story-title{
            margin-bottom:5px;
        }
        .delete-story a{
            color:#000;
            text-decoration: none;
            float: right;
        }
        .edit-story{
            cursor: pointer;
            color:#000;
            text-decoration: none;
        }
        .story-description{
            margin-bottom:5px;
        }
        .story-date{
            text-align:right;
        }
    </style>
</head>
<body class="container">
    <!-- Modal -->
<div class="modal fade" id="addStory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Story</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <div class="form-group">
              <textarea name="story" class="form-control" rows="5" placeholder="write your story..."></textarea>
            </div>
            <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="add">Submit</button>
        </div>
          </form>
           <?php
            if (isset($_POST['add'])) {
                $st =ucfirst($_POST['story']);

                $insert = "insert into story (story, status, date_created) values ('$st','Todo', NOW())";
                $run_insert = mysqli_query($con, $insert);
                if ($run_insert) {
                    header("location: index.php");
                }
            }
           ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal -->
    <div class="top mb-4">
        <div class="heading h2 text-center">Story Board</div>
        <div class="add-story text-info"><i class="fa fa-plus-square" data-toggle="modal" data-target="#addStory"> Add Story</i></div>
    </div>
    <main>
        <div class="row">
            <div class="col-md-4" >
                <h4 class="text-center">Todo (<?php echo $count_todo;?>)</h4>
                <hr>
                <div id="sec1" class="my-0">
                    <?php 
                    if ($count_todo < 1) {
                        echo "<div class='mt-5 h3 text-center'>You do not have any undo task</div>";
                    }
                    while ($row = mysqli_fetch_assoc($run_sel_todo)) {
                        $id = $row['story_id'];
                        $st = $row['story'];
                        $dc = $row['date_created'];
                        $status = $row['status'];

                        ?>
                <div class='story todo'>
                    
                    <form action='index.php' method='get'>
                    <span title ="edit" class="edit-story update-toggler1"><i class="fa fa-edit"></i></span>
                    <span title='Delete' class='delete-story'><a href='index.php?id=<?php echo $id; ?>'><i class="fa fa-trash-o"></i></a></span>
                    </form>
                    <br>
                    <div class="update-slider1">
                    <form action="index.php" method="post">
                        <input type="hidden" name="edit" value= <?php echo $id?>>
                        <textarea name="update_story" class="form-control" rows="2"><?php echo $st;?></textarea>
                        <select name="update_status" class="form-control my-1">
                            <option value="<?php echo $status?>"><?php echo $status?></option>
                            <option value="todo">Todo</option>
                            <option value="doing">Doing</option>
                            <option value="done">Done</option>
                        </select>
                       <a href="index.php?edit=<?php echo $id;?>"> <button type ="submit" name="update" class="btn btn-success">Update</button></a>
                    </form>
                    </div><!--update slider-->
                    <div class='story-details'><?php echo $st ?></div>
                    <div class='story-date'><?php echo $dc ?></div>
                </div>
                <?php } ?>
                </div>
            </div>

            <div class="col-md-4">
                <h4 class="text-center">Doing (<?php echo $count_doing;?>)</h4>
                <hr>
                <div id="sec2">
                <?php 
                if ($count_doing < 1) {
                    echo "<div class='mt-5 h3 text-center'>You are not currenly doing any task</div>";
                }
                    while ($row = mysqli_fetch_assoc($run_sel_doing)) {
                        $id = $row['story_id'];
                        $st = $row['story'];
                        $dc = $row['date_created'];
                        $status = $row['status'];
                        ?>
                <div class='story doing'>
                    <form action='index.php' method='get'>
                    <span title ="edit" class="edit-story update-toggler2"><i class="fa fa-edit"></i></span>
                    <span title='Delete' class='delete-story'><a href='index.php?id=<?php echo $id; ?>'><i class="fa fa-trash-o"></i></a></span>
                    </form>
                    <br>
                    <div class="update-slider2">
                    <form action="index.php" method="post">
                        <input type="hidden" name="edit" value= <?php echo $id?>>
                        <textarea name="update_story" class="form-control" rows="2"><?php echo $st;?></textarea>
                        <select name="update_status" class="form-control my-1">
                            <option value="<?php echo $status?>"><?php echo $status?></option>
                            <option value="todo">Todo</option>
                            <option value="doing">Doing</option>
                            <option value="done">Done</option>
                        </select>
                       <a href="index.php?edit=<?php echo $id;?>"> <button type ="submit" name="update" class="btn btn-success">Update</button></a>
                    </form>
                    </div><!--update slider-->
                    <div class='story-details'><?php echo $st ?></div>
                    <div class='story-date'><?php echo $dc ?></div>
                </div>
                <?php } ?>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="text-center">Done (<?php echo $count_done;?>)</h4>
                <hr>
                <div id="sec3">
                <?php 
                if ($count_done < 1) {
                    echo "<div class='mt-5 h3 text-center'>You have not done any task</div>";
                }
                    while ($row = mysqli_fetch_assoc($run_sel_done)) {
                        $id = $row['story_id'];
                        $st = $row['story'];
                        $dc = $row['date_created'];
                        $status = $row['status'];
                        ?>
                <div class='story done'>
                    <form action='index.php' method='get'>
                    <span title ="edit" class="edit-story update-toggler3"><i class="fa fa-edit"></i></span>
                    <span title='Delete' class='delete-story'><a href='index.php?id=<?php echo $id; ?>'><i class="fa fa-trash-o"></i></a></span>
                    </form>
                    <br>
                    <div class="update-slider3">
                    <form action="index.php" method="post">
                        <input type="hidden" name="edit" value= <?php echo $id?>>
                        <textarea name="update_story" class="form-control" rows="2"><?php echo $st;?></textarea>
                        <select name="update_status" class="form-control my-1">
                            <option value="<?php echo $status?>"><?php echo $status?></option>
                            <option value="todo">Todo</option>
                            <option value="doing">Doing</option>
                            <option value="done">Done</option>
                        </select>
                       <a href="index.php?edit=<?php echo $id;?>"> <button type ="submit" name="update" class="btn btn-success">Update</button></a>
                    </form>
                    </div><!--update slider-->
                    <div class='story-details'><?php echo $st ?></div>
                    <div class='story-date'><?php echo $dc ?></div>
                </div>
                <?php } ?>
            </div>
            </div>
        </div>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $del = "delete from story where story_id = '$id'";
            $run_del = mysqli_query($con, $del);
            if ($run_del) {
                echo "<script> window.open('index.php','_self')</script>";
            } 
        }
        if (isset($_POST['update'])) {
            $id = $_POST['edit'];
            $st = ucfirst($_POST['update_story']);
            $status = $_POST['update_status'];
            $update = "UPDATE story set story = '$st', status = '$status' where story_id = '$id'";
            $run_update = mysqli_query($con, $update);
            if ($run_update) {
                echo "<script> window.open('index.php','_self')</script>";
            }
            
        }
        ?>
    </main>
<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/popper/popper.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/counterup/jquery.waypoints.min.js"></script>
<script src="lib/counterup/jquery.counterup.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/typed/typed.min.js"></script>
<!--custom Javascript-->
<script src="script.js"></script>
</body>
</html>
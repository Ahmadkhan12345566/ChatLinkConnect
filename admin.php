<?php
include "connect.php";
// Starting session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Chat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    body {
      background: #E5DDD5 url("https://www.toptal.com/designers/subtlepatterns/patterns/sports.png") fixed;
    }

    .page-header {
      background: #006A4E;
      margin: 0;
      padding: 20px 0 10px;
      color: #FFFFFF;
      position: fixed;
      width: 100%;
      z-index: 1
    }

    .main {
      height: 100vh;
      padding-top: 70px;
    }

    .chat-log {
      padding: 40px 0 114px;
      height: auto;
      overflow: auto;
    }

    .chat-log__item {
      background: #fafafa;
      padding: 10px;
      margin: 0 auto 20px;
      max-width: 100%;
      float: left;
      border-radius: 4px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
      clear: both;
    }


    .chat-log__item_lsit {
      background: #fafafa;
      padding: 10px;
      margin: 4px auto;
      max-width: 100%;
      float: left;
      border-radius: 4px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
      clear: both;
      
    }

    .chat-log__item.chat-log__item--own {
      float: right;
      background: #DCF8C6;
      text-align: right;
    }

    .chat-form {
      background: #DDDDDD;
      padding: 40px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    .chat-log__author {
      margin: 0 auto .5em;
      font-size: 14px;
      font-weight: bold;
    }
  </style>

</head>


<body>
  <?php
  $time_start = microtime(true);
  $time_start = str_replace(".", "", $time_start);
  $id = 0;
  if (isset($_POST["secret"]) == "secret") {
    $_SESSION["status"] = "1";
  }

  if (isset($_POST["out"])) {
    unset($_SESSION["status"]);
  }


  //  echo $time_start; 
  if (isset($_GET['id'])) {
    $id = $_GET["id"];
  
  
    if (isset($_POST["sendChat"])) {
    
      $chat_id = $id;
      $content = $_POST["content"];
      
      // Escape the content to handle single quotes
      $escaped_content = mysqli_real_escape_string($con, $content);

      $sql1 = "INSERT INTO chats (chat_id,content,is_admin)
            value  ('$chat_id','$escaped_content',1)";

      $result1 = mysqli_query($con, $sql1);

      if ($result1) {
        //       die("User Inserted");
        //  header("location:index.php");
  
      } else {
        die(mysqli_error($con));
      }


    }
    $sql = "select * from `chats` where chat_id=$id ORDER BY id ASC";
    $chats = mysqli_query($con, $sql);



    // end of id 
  

  }

  $sqlthreads = "select *  from `chats` GROUP BY chat_id ORDER BY id DESC";
  $chatsthreads = mysqli_query($con, $sqlthreads);
  

  ?>

  <header class="page-header">
    <div class="container ">
      <div class="row">
     
      <div class="col-md-6">
        <?php if(!isset($_SESSION["status"])){ ?>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Check-In</button>
        <?php } ?>  

        <?php if(isset($_SESSION["status"])){ ?>
                 <form method="POST" action="#">
                 <button name="out" type="submit" class="btn btn-danger" value="1" >Check-Out</button>
                 </form>
          <?php } ?>
    </div>
        <div class="col-md-6" style="float:right;">
         <!-- <label class="btn btn-default" style="color:black;float:right;font-weight: bold;" for="myInput">
          CHAT ID : 
        </label> -->
        <div class="form-group row">
        <div class="col-sm-6">
        <!-- The text field -->
        <!-- <input disabled class="form-control" style="color:black;font-weight: bold;" type="text" value="<?php  echo $id; ?>" id="myInput"> -->
        </div>
        <div class="col-sm-6">
        <!-- The button used to copy the text -->
       <!-- <button class="btn btn-default" style="color:black;font-weight: bold;"  onclick="myFunction()">Copy CHAT ID</button> -->
        </div> 
      </div>
        </div>
      
      </div>
    </div>

  </header>

 <?php if(isset($_SESSION["status"]) == "1"){ ?>
    <div class="main">
      <div class="container ">
        <div class="row">
        <div class="col-md-4">
          <div style="margin-top: 10px;overflow-x: hidden;overflow-y: auto;">

<?php
          if ($chatsthreads) {
            while ($row = mysqli_fetch_assoc($chatsthreads)) {
              // $id= $row["id"];
              $chat_id = $row["chat_id"];
              $content = $row["content"];

              ?>
        <div class="chat-log__item_lsit btn btn-primary">
          <a class="btn btn-primary"  href="admin.php?id=<?php echo $chat_id; ?>" >
                  <div class="chat-log__message">
                    <?php echo $chat_id;  ?>
                  </div>
          </a>
                </div>
                <?php }}?>
                </div>
              </div>
        <div class="col-md-8">
        <?php

if (isset($_GET['id'])) {

  ?>
        <div class="chat-log">

          <?php
          if ($chats) {
            while ($row = mysqli_fetch_assoc($chats)) {
              // $id= $row["id"];
              $is_admin = $row["is_admin"];
              $content = $row["content"];

              ?>

              <?php if ($is_admin == 1) { ?>
                <div class="chat-log__item">
                  <div class="chat-log__message">
                    <?php echo $content; ?>
                  </div>
                </div>
              <?php } ?>
              <?php if ($is_admin == 0) { ?>
                <div class="chat-log__item chat-log__item--own">
                  <div class="chat-log__message">
                    <?php echo $content; ?>
                  </div>
                </div>
              <?php } ?>
            <?php }
          } ?>
        </div>

        <?php } ?>
        </div>
        </div>
      </div>
      <div class="chat-form">
        <div class="container ">
          <div class="row" >
          <div class="col-md-12" >
          <form class="form-horizontal" method="POST" Action="#">
            <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control" id="" placeholder="Message" />
            <div class="row">
              <div class="col-sm-10 col-xs-8">

                <input type="text" class="form-control" id="" placeholder="Message" name="content" />
              </div>
              <div class="col-sm-2 col-xs-4">
                <button type="submit" name="sendChat" class="btn btn-success btn-block">Send</button>
              </div>
            </div>
          </form>
          </div>
          </div>
        </div>
      </div>
    </div>

    <?php } ?>


    

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <form method="post" action="admin.php">
            <div class="form-group">
              <label for="chatId">Enter Secret Code</label>
              <input type="text" name="id" class="form-control" id="chatId" aria-describedby="idHelp"
                placeholder="Enter Secret Code">
              <!-- <small id="idHelp" class="form-text text-muted">Enter the Chat ID provided when chat started</small> -->
            </div>
            <button type="submit" name="secret" class="btn btn-primary">Continue</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>


</body>
<script>
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}
</script>

</html>
<?php
include "connect.php";
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
      max-width: 80%;
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

function is_sha1($str) {
  return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
}
 $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
  $time_start = microtime(true);
  $time_start = str_replace(".", "", $time_start);
  $time_start  = sha1($time_start);
  $id = 0;
  //  echo $time_start; 
  if (isset($_GET['id'])) {
    
    $id = $_GET["id"];
    if(!is_sha1($id)){
           exit;
    }
    
    //  echo $id; 
  
    if (isset($_POST["sendChat"])) {
      // var_dump($_POST);
      // die();
      $chat_id = $id;
      $content = $_POST["content"];
      // Escape the content to handle single quotes
      $escaped_content = mysqli_real_escape_string($con, $content);

      $sql1 = "INSERT INTO chats (chat_id,content)
            value  ('$chat_id','$escaped_content')";

      $result1 = mysqli_query($con, $sql1);

      if ($result1) {
        //       die("User Inserted");
        //  header("location:index.php");
  
      } else {
        die(mysqli_error($con));
      }


    }

    // var_dump($id);
    $sql = "select * from `chats` where chat_id='$id' ORDER BY id ASC";
    $chats = mysqli_query($con, $sql);

    
   // Get the user's IP address
   $user_ip = $_SERVER['REMOTE_ADDR'];

   // Check if the IP is blocked due to exceeding the limit
   $ipsql = "SELECT * FROM `blockips` WHERE ip='$user_ip'";
   $ip_result = mysqli_query($con, $ipsql);

   // Define your maximum allowed attempts
   $max_attempts = 10;


  //  var_dump(mysqli_num_rows($chats));
  //  var_dump(mysqli_num_rows($ip_result));
   // If no records found and the user's IP is not blocked
   if (mysqli_num_rows($chats) == 0 ) {
    // Check if the IP already exists in the blockips table
    $ip_attempts_sql = "SELECT attempts FROM `blockips` WHERE ip='$user_ip'";
    $ip_attempts_result = mysqli_query($con, $ip_attempts_sql);

    if (mysqli_num_rows($ip_attempts_result) > 0) {
        // IP exists, update the attempts count
        $row = mysqli_fetch_assoc($ip_attempts_result);
        $attempts = $row['attempts'];

        if ($attempts >= $max_attempts) {
            // Block access for this IP
            // You might want to show an error message or redirect the user to a blocked page
            // echo "Access Denied. Your IP has been blocked due to exceeding the maximum attempts.";
            exit;
        } else {
          // var_dump("Increment");
            // Increment attempts count for the existing IP
            $attempts++;
            $update_attempts_sql = "UPDATE `blockips` SET attempts=$attempts WHERE ip='$user_ip'";
            mysqli_query($con, $update_attempts_sql);
        }
    } else {

      // var_dump("in insert");
        // IP doesn't exist, insert a new record
        $insert_attempts_sql = "INSERT INTO `blockips` (ip, attempts) VALUES ('$user_ip', 1)";
        mysqli_query($con, $insert_attempts_sql);
    }
}


    

// var_dump($chats);

    // end of id 
  

  }


  ?>

  <header class="page-header">
    <div class="container ">
      <div class="row">
      <div class="col-md-6">
      <a href="index.php?id=<?php echo $time_start; ?>" class="btn btn-danger">
        Start
      </a>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Continue</button>
      </div>
      <?php if ($id != 0) { ?>
        <div class="col-md-6" style="float:right;">
        <!-- <label class="btn btn-default" style="color:black;float:right;font-weight: bold;" for="myInput">
          CHAT ID : 
        </label> -->
        <div class="form-group row">
        <div class="col-sm-8">
        <!-- The text field -->
        <input disabled class="form-control" style="color:black;font-weight: bold;" type="text" value="<?php  echo $id; ?>" id="myInput">
        </div>
        <div class="col-sm-4">
        <!-- The button used to copy the text -->
       <button class="btn btn-default" style="color:black;font-weight: bold;"  onclick="myFunction()">Copy CHAT ID</button>
        </div> 
      </div>
        </div>
      <?php } ?>
      </div>
    </div>

  </header>

  <?php

  if (isset($_GET['id'])) {

    ?>
    <div class="main">
      <div class="container ">
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
      </div>
      <div class="chat-form">
        <div class="container ">
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

    <?php
  } ?>

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <form method="GET" action="index.php">
            <div class="form-group">
              <label for="chatId">Enter Chat ID</label>
              <input type="text" name="id" class="form-control" id="chatId" aria-describedby="idHelp"
                placeholder="Enter Chat ID">
              <small id="idHelp" class="form-text text-muted">Enter the Chat ID provided when chat started</small>
            </div>
            <button type="submit" class="btn btn-success">Continue</button>
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
// function myFunction() {
//   // Get the text field
//   var copyText = document.getElementById("myInput");

//   // Select the text field
//   copyText.select();
//   copyText.setSelectionRange(0, 99999); // For mobile devices

//   // Copy the text inside the text field
//   navigator.clipboard.writeText(copyText.value);
  
//   // Alert the copied text
//   alert("Copied the text: " + copyText.value);
// }

function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Check if the clipboard API is available
  if (navigator.clipboard && navigator.clipboard.writeText) {
    // Copy the text inside the text field using clipboard API
    navigator.clipboard.writeText(copyText.value)
      .then(() => {
        // Alert the copied text
        alert("Copied the text: " + copyText.value);
      })
      .catch((err) => {
        // Handle any errors that occurred while copying
        console.error('Unable to copy:', err);
      });
  } else {
    // Fallback for browsers that do not support the clipboard API
    try {
      // Attempt to copy the text using execCommand (older browsers)
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Fallback: Copying text command was ' + msg);
      
      // Alert the copied text if the copy was successful
      if (successful) {
        alert("Copied the text: " + copyText.value);
      }
    } catch (err) {
      console.error('Fallback: Unable to copy:', err);
    }
  }
}

</script>

</html>
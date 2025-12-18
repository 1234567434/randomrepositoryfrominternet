<?php
require 'go.php';
        $cook = (isset($_COOKIE['por3'])) ? $_COOKIE['por3'] : "";
        if ($my) {
          if (empty($cook) != true) {
            $ff = sqli_pstat($my, "SELECT * FROM authors where cook = ?", "s", [$cook], true);
            if ($ff) {
              $fx = mysqli_fetch_assoc($ff);
              if (isset($fx)) {
                header('Location: dashboard');
                $_SESSION['username'] = strtolower($fx['mail']);
                $_SESSION['author'] = $fx['name'];
        $fg = gid($fx['fid']);        
              if($fg){
              if(isset($fg)){
        if ($fg['type'] == 'st') {
          $ld = jsd($fg['courses'], true);
          $_SESSION['courses'] = [];
          foreach ($ld as $k => $v) {
            $_SESSION['courses'][] = $k;
          }
          
        } elseif ($fg['type'] == 'in'
        ) {
          $_SESSION['courses'] = $fg['courses'];
        }
}
          }      
              }
            }
          }

        $tim = time();
        if (isset($_GET['con'])) {
          $chg = mysqli_query($my, "SELECT * FROM codes");
          if ($chg) {
            $chgg = mysqli_fetch_all($chg);
            if (count($chgg)) {
              for ($i = 0; $i < count($chgg); $i++) {
                $cd = $chgg[$i][3];
                if (password_verify($_GET['con'], $cd)) {

                  if ($chgg[$i][4] > $tim) {
                    $_SESSION['suser'] = $chgg[$i][1];
                    if (mysqli_query($my, "DELETE FROM codes where user = '$_SESSION[suser]'")) {
                      $_SESSION['nstage'] = true;
                      header("Location: ?repass");
                    }
                  } else {
                    $timeout = "Your Code Has Expired Please Go Back And Try Again";
                  }
                } else {
                  $timeout = "Something Went Wrong Please Try Again";
                }
              }
            }
          } else {
            $timeout = "Something Went Wrong Please Try Again";
          }
        }

 if (isset($_GET['save'])) {
        $chg = mysqli_query($my, "SELECT * FROM codes");
        if ($chg) {
            $chgg = mysqli_fetch_all($chg);
            if (count($chgg)){
for($q=0;$q<count($chgg);$q++){
    $us = $chgg[$q][1];
    $cd = $chgg[$q][3];
if (password_verify($_GET['save'], $cd)) {
    if ($chgg[$q][4] > $tim) {
        $vv = mysqli_query($my, "SELECT name,preset FROM dash where name = '$us'");
        if ($vv) {
            $vy = mysqli_fetch_assoc($vv);
          if(isset($vy)){
            $mid = md5($vy['name']);
            $npo = jsd($vy['preset'],true);
            $vz = gid($mid);
            if($vz){
                if(isset($vz)){
                  $ona = $vz['mail'];

                    if(empty($npo['pass'])){
                  $nid = md5($npo['mail']);
                  $nnd = md5($ona);
                  $nmi = $npo['mail'];
                  switch ($vz['type']) {
                    case 'st':
                      $k = 'stu';
                      break;
                    case 'in':
                      $k = 'ints';
                      break;
                  }
                  $tab =  mysqli_multi_query($my, "UPDATE authors set mail = '$nmi', fid = '$nid' where mail = '$ona';UPDATE contract set main = '$nid' where main = '$nnd';UPDATE archive set main = '$nid' where main = '$nnd';UPDATE dash set name = '$nmi',preset = '{}' where name = '$ona';DELETE from codes where user = '$ona';UPDATE $k set main = '$nid' where main = '$nnd'");
                        if ($tab) {
                          $timeout = 'Please Log In With New Details';
                        }else {
                          $timeout = "Something Went Wrong Please Try Saving Again Later";
                        }
                    }else{
                        $opp = $npo['pass'];
                        if(mysqli_query($my, "UPDATE authors set pass = '$opp' where mail = '$ona'")){
                          $timeout = 'Please Log In With New Details';
                        }else{
                          $timeout = "Something Went Wrong Please Try Saving Again Later";
                        }
                    }
                }else{
                  $timeout = "Something Went Wrong Please Try Saving Again Later"; 
                }
            }else {
              $timeout = "Something Went Wrong Please Try Saving Again Later"; 
            }
          }else {
                  $timeout = "Something Went Wrong Please Try Saving Again Later";
            }
      }
    } else {
        $timeout = "Your Code Has Expired Please Go Back And Resave";
    }
} else {
    $timeout = "Something Went Wrong Try Resaving";
}
            }
        }
        } else {
            $timeout = "Something Went Wrong Try Resaving";
        }
    }
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="files/css/style.css" />
  <script src="files/js/jquery-3.js"></script>
  <script src="files/js/timer.js"></script>
  <link rel="shortcut icon" href="img/flogo.ico" type="image/x-icon">
  <link rel="stylesheet" href="files/css/mprogress.min.css">
  <script src="files/js/mprogress.min.js"></script>
  <title>Your Portal</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <?php
      if(isset($_SESSION['suser'])){
        if (isset($_GET['recovery'])) {
          if ($my) {
            $time = time();
            $io = mysqli_query($my, "SELECT * FROM codes where expiry > '$time' and user = '$_SESSION[suser]' order by expiry desc limit 1");
            if ($io) {
              $ix = mysqli_fetch_assoc($io);
              if (isset($ix)) {
                $m = (int) $ix['expiry'] - time();

                $ct = ($m - ((2 / 3) * $m)) * 1000;
              }
            }
          }

          echo '<form method="POST" action="#" onsubmit="return false" class="mail_form login100-form validate-form" enctype="multipart/form-data">
<div href="" class="llogo"></div>
      <div class="lloader"></div>
    <div class="error_note"></div>
    <h2 class="title">Check Your Mail We Sent A Message</h2>

    <div class="rimg"></div>
  
<div class="resend_pin">
    <button disabled="" onclick="return false" class="rmail btn solid">Didnt Recieve A Mail? Resend Here</button>
    
    <div class="clockdiv">
		<div class="hours"></div><span>:</span>
		<div class="minutes"></div><span>:</span>
		<div class="seconds"></div>
	</div>
</div>
<script>
    initializeClock(".rmail",' . (isset($ct) ? $ct : 600000) . ',function(x){
    $(".rmail").click(function(){
        $(this).attr("disabled","");
          conB("do=resend&what=login&mode=recovery&type=Password Recovery",function(x){
       if (x == "done"){
        window.location = "";
  } else {
    errorx(x);
  }
  });
    });
});
    </script>
</form>';
        } else if (isset($_GET['repass']) && $_SESSION['nstage']) {
          echo '<form method="POST" class="sign-in-form recovery-form" enctype="multipart/form-data" action="#">
          <div href="" class="llogo"></div>
          <div class="lloader"></div>
          <div class="error_note"></div>
          <h2 class="title">Password Recovery</h2>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input class="mainpass input100" type="password" name=\'pass\' placeholder="New Password" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input class="input100" type="password" name=\'repeat-pass\' placeholder="Retype Password">
          </div>
          <input type="submit" value="Change Password" class="btn solid">
        </form>';
        }else {
         echo ' <form action="#" method=\'POST\' onsubmit="ggo(\'st\');return false" class="validate-form sign-in-form">
         <div href="" class="llogo"></div>
          <div class="lloader"></div>
          <div style="' . (isset($timeout) ? 'display:block;' : '') . '" class="error_note">'.(isset($timeout) ? $timeout : '').'</div>
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" class=\'input100 inputx\' name=\'email\' placeholder="Email">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input class="input100" type="password" name=\'pass\' placeholder="Password" />
          </div>
          <input type="submit" value="Login" class="btn solid" />
        </form>
        <a onclick="valid()" class="jik">forgot my password</a>';
        }
      }else{
          echo '<form action="#" method=\'POST\' onsubmit="ggo(\'st\');return false" class="validate-form sign-in-form">
          <div href="" class="llogo"></div>
          <div class="lloader"></div>
          <div style="' . (isset($timeout) ? 'display:block;' : '') . '" class="error_note">' . (isset($timeout) ? $timeout : '') . '</div>
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" class=\'input100 inputx\' name=\'email\' placeholder="Email">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input class="input100" type="password" name=\'pass\' placeholder="Password" />
          </div>
          <input type="submit" value="Login" class="btn solid" />
        </form>
        <a onclick="valid()" class="jik">forgot my password</a>';
      }
        ?>
</div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Welcome To Our Portal</h3>
          <p>Sign In to continue</p>
        </div>
        <img src="img/path55.svg" class="image" alt="clicollege student portal" />
      </div>
    </div>
  </div>
  <script src="files/js/appp.js"></script>
</body>

</html>
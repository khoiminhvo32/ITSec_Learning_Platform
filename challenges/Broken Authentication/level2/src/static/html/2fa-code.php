<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../static/css/styles.css">
</head>

<body>        
  <br/>
  <br/>
  <style>
  .form-login {
    background-color: #fefefe;
    margin: 5% auto 5% auto;
    /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%;
    /* Could be more or less, depending on screen size */
  }
  </style>
  <h1 >Broken Authentication Workshop</h3>
  <h2 style="text-align: center;">2FA-code Verify</h2>
  <form class="form-login" method="post">
    <div class="container">
      <label for="psw"><b>Click here to retrieve your 2FA-code via <b>Your Email</b>:</b></label>
      <button type="submit" name="btn-2fa">Retrieve 2FA-code</button>
      <div style="text-align: center;">
        <?php if (isset($message_2FA)) echo "<b>" . $message_2FA . "</b>";?>
      </div>
      <p style="left: 200px;">Go to <a href="/login-email.php">Email login</a></p>
    </div>
  </form>
  <form class="form-login" method="post">
    <div class="container">
      <label for="psw"><b>Enter your 2FA-code</b></label>
      <input type="text" placeholder="Enter Your 2FA-code" name="2FA-value" required>
      <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
      <div style="text-align: center;">
        <?php if (isset($message)) echo "<b>Your Email:</b> ".$message;?>
      </div>
      <button type="submit" name="button">Submit</button>
    </div>
  </form>
</body>

</html>
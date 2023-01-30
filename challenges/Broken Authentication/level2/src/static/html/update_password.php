<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../static/css/styles.css">
</head>

<body>        
  <br/>
  <br/>
  <h1 >Broken Authentication Workshop</h3>
  <h2 style="text-align: center;">Renew your Password</h2>
  <form class="form-login" method="post">
    <div class="container">
      <label for="uname"><b>Enter your new password:</b></label>
      <input type="text" placeholder="Enter Password" name="new_password" required>
      <input type="hidden" name="post_username" value="<?php echo $_SESSION['username']; ?>">

      <span>
        <?php if (isset($message)) echo $message;?>
      </span>
      <button type="submit" name="button">Submit</button>
      <p style="left: 200px;">Get back to <a href="/">Login Page</a></p>
    </div>
  </form>
</body>

</html>
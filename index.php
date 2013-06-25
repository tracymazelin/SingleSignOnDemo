<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>API SSO Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>

  <body>

    <div class="container-narrow">
        <div class="" id="loginModal">
          <div class="modal-header">
          
            <h3>Your Church Website</h3>
          </div>
          <div class="modal-body">
            <div class="well">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                <li><a href="#create" data-toggle="tab">Create Account</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="login">
                  <form class="form-horizontal" action='login.php' method="POST">
                    <?php if(isset($_GET['login']) && $_GET['login'] == "failed") echo 
                    '<div class="alert alert-error">Incorrect Username or Password</div>';?>
                    <fieldset>
                     <br> 
                      <div class="control-group">
                        <!-- Username -->
                        <label class="control-label"  for="username">Username</label>
                        <div class="controls">
                          <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                        </div>
                      </div>
 
                      <div class="control-group">
                        <!-- Password-->
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                          <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                        </div>
                      </div>

                       <div class="control-group">
                          <div class="controls">
                              <a href="#">Forgot Password?</a>
                        </div>
                      </div>

                      <div class="control-group">
                        <!-- Redirect -->
                        <label class="control-label" for="appId">Redirect to:</label>
                        <div class="controls">
                         <label class="radio">
                            <input type="radio" name="appId" id="InFellowship" value="237" checked>
                            InFellowship
                          </label>
                          <label class="radio">
                            <input type="radio" name="appId" id="weblink" value="626">
                            Weblink
                          </label>

                          <label class="radio">
                            <input type="radio" name="appId" id="portal" value="6">
                            Portal
                          </label>
      

                        </div>
                      </div>
 
 
                      <div class="control-group">
                        <!-- Button -->
                        <div class="controls">
                          <button class="btn btn-success">Login</button>
                        </div>
                      </div>
                    </fieldset>
                  </form>                
                </div>
                <div class="tab-pane fade" id="create">
                  <form class="form-horizontal" action='createAccount.php' method="POST">
                   

                              
                    <fieldset>
                     <br> 
                      <div class="control-group">
                        
                        <!-- Username -->
                        <label class="control-label"  for="username">First Name</label>
                        <div class="controls">
                          <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                        </div>
                      </div>
 
                      <div class="control-group">
                        <!-- Password-->
                        <label class="control-label" for="password">Last Name</label>
                        <div class="controls">
                          <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                        </div>
                      </div>

                      <div class="control-group">
                        <!-- Email -->
                        <label class="control-label" for="password">Email Address</label>
                        <div class="controls">
                          <input type="email" id="email" name="email" placeholder="" class="input-xlarge">
                        </div>
                      </div>


                      <div class="control-group">
                        <!-- Button -->
                        <div class="controls">
                          <button class="btn btn-primary">Create Account</button>
                        </div>
                      </div>
                    </fieldset>
                  </form>          
                    
                   
 
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="footer">
        <p>&copy; API Single Sign On/Account Creation Demo. Tracy Mazelin. 2013</p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
  </body>
</html>

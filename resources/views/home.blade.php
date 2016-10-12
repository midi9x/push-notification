<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Push notifications</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="css/app.css">
    <meta name="_token" content="{{ csrf_token() }}">
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="#">Push Notifications</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#about">Docs</a>
                    </li>
                    <li>
                        <a href="#services">Viblo</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="container top-100">
        <div class="row">
            <div class="col-lg-12">

                <label class="switch">
                    <input type="checkbox" class="js-push-button" name="enable-push" id="enable-push" disabled>
                    <div class="slider round"></div>
                </label>
                <label class="switch-label" for="enable-push">Enable Push Notifications</label>
                <hr class="intro-divider">
                <form class="form-inline" id="formPushNofitication" style="display: none">
                    <div class="form-group">
                        <input type="hidden" name="endPoint" id="endPoint">
                        <label for="email">Push notification after:</label>
                        <select class="form-control" name="delayTime" id="delayTime">
                            <option value="0">Push now    </option>
                            <option value="1">1 minute</option>
                            <option value="5">5 minutes</option>
                            <option value="10">10 minutes</option>
                            <option value="15">15 minutes</option>
                            <option value="30">30 minutes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="js/app.js"></script>
</body>
</html>

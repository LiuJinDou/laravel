<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>基于swoole扩展开发的在线聊天室</title>

    <link href="/webim/css/bootstrap.min.css" rel="stylesheet">
    <link href="/webim/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="webim">
<div class="row">
    <div class="col-xs-10 col-xs-offset-1" style="margin-top:40px;">
        <div class="panel panel-info">
            <div class="panel-heading">
                webim: PHP + Swoole 简易聊天室
            </div>
            <div class="panel-body no-padding">
                <div class="col-xs-3 user-list">

                </div>
                <div class="col-xs-9 no-padding">
                    <div class="chat-list">
                    </div>
                    <div class="message">
                        <div class="text">
                            <textarea></textarea>
                        </div>
                        <div class="send">
                            发送
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/webim/js/jquery.min.js"></script>
<script src="/webim/js/bootstrap.min.js"></script>
<script src="/webim/vendor/layer/layer.js"></script>
<script src="/webim/js/webim.js"></script>
<!--<a href="https://github.com/moell-peng/webim" target="_blank">-->
<!--<img style="position: absolute; top: 0; right: 0; border: 0; z-index:9999;" src="images/forkme_right_orange_ff7600.png" alt="Fork me on GitHub">-->
<!--</a>-->
</body>
</html>



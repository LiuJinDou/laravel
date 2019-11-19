<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shadow personal blog</title>
    <meta name="keywords" content="Personal blog" />
    <meta name="description" content="Personal blog" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/front/css/base.css" rel="stylesheet">
    <link href="/front/css/index.css" rel="stylesheet">
    <link href="/front/css/m.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/front/js/modernizr.js"></script>
    <![endif]-->
    <script src="/front/js/page.js"></script>
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <script  src="/js/jquery.min.js"></script>
    <script  src="/front/js/common.js"></script>
    <script src="/js/layui/layui.js"></script>
</head>
<body>
<header>
    <div id="mnav">
        <div class="logo"><a href="/">Shadow personal blog</a></div>
        <h2 id="mnavh"><span class="navicon"></span></h2>
        <ul id="starlist">
            <li><a href="/">网站首页</a></li>
            <li><a href="/front/about">关于我</a></li>
            <li><a href="/front/work">工作分享</a></li>
            <li><a href="/front/study">学无止境</a></li>
            <li><a href="/front/life">慢生活</a></li>
            
            <li><a href="/front/message">留言</a></li>
        </ul>
    </div>
    <script>
        window.onload = function ()
        {
            var oH2 = document.getElementById("mnavh");
            var oUl = document.getElementById("starlist");
            oH2.onclick = function ()
            {
                var style = oUl.style;
                style.display = style.display == "block" ? "none" : "block";
                oH2.className = style.display == "block" ? "open" : ""
            }
        }
    </script>
</header>
<div style="display: none" class="token" _token="<?php echo e(csrf_token()); ?>"></div>
<body id="nv_forum" class="pg_viewthread" onkeydown="if(event.keyCode==27) return false;" style="height: 700px; margin: 0 auto;">
</body>
<script type="text/javascript">
    // 富强", "民主", "文明", "和谐", "自由", "平等", "公正", "法治", "爱国", "敬业", "诚信", "友善"
    (function() {var coreSocialistValues = ["YD,i love you"], index = Math.floor(Math.random() * coreSocialistValues.length);document.body.addEventListener('click', function(e) {if (e.target.tagName == 'A') {return;}var x = e.pageX, y = e.pageY, span = document.createElement('span');span.textContent = coreSocialistValues[index];index = (index + 1) % coreSocialistValues.length;span.style.cssText = ['z-index: 9999999; position: absolute; font-weight: bold; color: #ff6651; top: ', y - 20, 'px; left: ', x, 'px;'].join('');document.body.appendChild(span);animate(span);});function animate(el) {var i = 0, top = parseInt(el.style.top), id = setInterval(frame, 16.7);function frame() {if (i > 180) {clearInterval(id);el.parentNode.removeChild(el);} else {i+=2;el.style.top = top - i + 'px';el.style.opacity = (180 - i) / 180;}}}}());
</script>
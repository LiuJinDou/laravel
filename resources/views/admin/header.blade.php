<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta http-equiv="expires" content="0">
    <title>Shadow</title>
    <link rel="stylesheet" href="/css/admin/ladmin.css">
    <script  src="/js/jquery.min.js"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="http://echarts.baidu.com/dist/echarts.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/admin/ladmin.js"></script>
</head>
<div style="display: none" class="token" _token="{{csrf_token()}}"></div>
<body id="nv_forum" class="pg_viewthread" onkeydown="if(event.keyCode==27) return false;" style="margin: 0 auto;">
</body>
<script type="text/javascript">
    (function() {var coreSocialistValues = ["梦想", "自由", "坚持", "目标", "结果", "未来", "过去", "现在", "家庭", "事业", "爱情"], index = Math.floor(Math.random() * coreSocialistValues.length);document.body.addEventListener('click', function(e) {if (e.target.tagName == 'A') {return;}var x = e.pageX, y = e.pageY, span = document.createElement('span');span.textContent = coreSocialistValues[index];index = (index + 1) % coreSocialistValues.length;span.style.cssText = ['z-index: 9999999; position: absolute; font-weight: bold; color: #ff6651; top: ', y - 20, 'px; left: ', x, 'px;'].join('');document.body.appendChild(span);animate(span);});function animate(el) {var i = 0, top = parseInt(el.style.top), id = setInterval(frame, 16.7);function frame() {if (i > 180) {clearInterval(id);el.parentNode.removeChild(el);} else {i+=2;el.style.top = top - i + 'px';el.style.opacity = (180 - i) / 180;}}}}());
</script>
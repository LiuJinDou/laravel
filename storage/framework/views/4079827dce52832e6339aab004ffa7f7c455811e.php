<?php echo $__env->make('front/head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="line46"></div>
<article>
    <div class="pics">
        <ul></ul>
    </div>
    <div class="blank"></div>
    <div class="leftbox">
        <div class="tuijian">
            <h2 class="hometitle"><span><a href="/front/work">工作分享</a><a href="/front/study">学无止境</a><a href="/front/life">慢生活</a><a href="javascript:void(0);">热门标签</a></span>特别推荐</h2>
            <ul></ul>
        </div>
        <div class="newblogs">
            <h2 class="hometitle">最新文章</h2>
            <ul id="list"></ul>
        </div>
    </div>
    <div class="rightbox">
        <div class="aboutme"></div>
        <div class="blank"></div>
        <div class="search">
            <form action="/front/search" method="get" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input  class="input_submit" value="搜索" type="submit">
            </form>
        </div>
        <div class="paihang">
            <h2 class="ab_title"><a href="javascript:void(0);">点击排行</a></h2>
            <ul></ul>
        </div>
        <div class="links">
            <h2 class="ab_title">友情链接</h2>
            <ul>
                <li><a href="https://www.baidu.com/" target="_blank">百度一下,你就知道</a></li>
                <li><a href="https://www.layui.com/" target="_blank">LayUi,前端框架</a></li>
                <li><a href="https://github.com" target="_blank">GitHub</a></li>
                <li><a href="https://www.echartsjs.com/zh/index.html" target="_blank">ECHARS</a></li>
            </ul>
        </div>

        <div class="weixin"></div>
    </div>
</article>
<?php echo $__env->make('front/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="/front/js/index.js"></script>








@include('front/head')
<div class="line46"></div>
<div class="blank"></div>
<article>
    <div class="leftbox">
        <div class="infos">
            <div class="newsview">
                <h2 class="intitle">您现在的位置是：<a href='/'>首页</a>&nbsp;>&nbsp;留言</h2>
                @include('front/comment')
            </div>
        </div>
    </div>
    <div class="rightbox">
        <div class="aboutme"></div>
        <div class="weixin"></div>
    </div>
</article>
@include('front/footer')
<script src="/front/js/message.js"></script>
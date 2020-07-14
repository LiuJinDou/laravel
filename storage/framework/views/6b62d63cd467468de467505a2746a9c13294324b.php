<?php echo $__env->make('front/head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="line46"></div>
<div class="blank"></div>
<article>
    <div class="leftbox">
        <div class="infos">
            <div class="newsview">
                <h2 class="intitle">您现在的位置是：<a href='/'>首页</a>&nbsp;>&nbsp;留言</h2>
                <?php echo $__env->make('front/comment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
    <div class="rightbox">
        <div class="aboutme"></div>
        <div class="weixin"></div>
    </div>
</article>
<?php echo $__env->make('front/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="/front/js/message.js"></script>
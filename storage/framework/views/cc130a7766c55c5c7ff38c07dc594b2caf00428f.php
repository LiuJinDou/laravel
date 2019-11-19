<?php echo $__env->make('front/head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="line46"></div>
<article>
    <div class="leftbox">
        <div class="newblogs">
            <h2 class="hometitle">A man is not old until regrets take the place of dreams.</h2>
            <ul>
                <?php $__currentLoopData = $data['search']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <h3 class="blogtitle"><a href="/front/info?id=<?php echo e($value['id']); ?>" target="_blank" ><?php echo e($value['title']); ?></a></h3>
                        <div class="bloginfo"><span class="blogpic"><a href="/front/info?id=<?php echo e($value['id']); ?>" title=""><img src="<?php echo e($value['image']); ?>"  /></a></span>
                            <p><?php echo $value['introduction']; ?></p>
                        </div>
                        <div class="autor"><span class="lm f_l"><a href="/"><?php echo e($value['author']); ?></a></span><span class="dtime f_l"><?php echo e($value['create_at']); ?></span><span class="viewnum f_l">浏览（<a href="/"><?php echo e($value['browse']); ?></a>）</span><span class="pingl f_l">评论（<a href="/">30</a>）</span><span class="f_r"><a href="/front.info?id=<?php echo e($value['id']); ?>" class="more">阅读原文>></a></span></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            
        </div>
    </div>
    <div class="rightbox">
        <div class="blank"></div>
        <div class="search">
            <form action="/front/search" method="get" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input  class="input_submit" value="搜索" type="submit">
            </form>
        </div>
        <div class="weixin">
            <h2 class="ab_title">微信关注</h2>
            <ul>
                <img src="images/wx.jpg">
            </ul>
        </div>
    </div>
</article>
<?php echo $__env->make('front/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

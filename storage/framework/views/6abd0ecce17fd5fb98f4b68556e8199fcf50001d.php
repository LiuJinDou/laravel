<?php echo $__env->make('front/head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="line46"></div>
<div class="blank"></div>
<article>
    <div class="leftbox">
        <div class="infos">
            <div class="newsview">
                <h3 class="news_title"><?php echo e($data['current']['title']); ?></h3>
                <div class="news_author"><span class="au01">Shadow</span><span class="au02"><?php echo e($data['current']['create_at']); ?></span><span class="au03">共<b><?php echo e($data['current']['browse']); ?></b>人围观</span></div>
                <div class="tags">
                    <?php $__currentLoopData = $data['current']['tags']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="javascript:void(0);"><?php echo e($value); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="news_about"><strong>简介</strong><?php echo $data['current']['introduction']; ?></div>
                <div class="news_infos">
                    <?php echo $data['current']['content']; ?>

                </div>
            </div>
            <div class="share">
                <p class="diggit"><a href="javascript:void(0)" data-id="<?php echo e($data['current']['id']); ?>"> 很赞哦！ </a>(<b id="diggnum"><?php echo e($data['current']['love']); ?></b>)</p>
                <p class="dasbox"><a href="javascript:void(0)" onclick="dashangToggle()" class="dashang" title="打赏，支持一下">打赏本站</a></p>
                <div class="hide_box" style="display: none;"></div>
                <div class="shang_box" style="display: none;"> <a class="shang_close" href="javascript:void(0)" onclick="dashangToggle()" title="关闭">关闭</a>
                    <div class="shang_tit">
                        <p>感谢您的支持，我会继续努力的!</p>
                    </div>
                    <div class="shang_payimg"> <img src="images/alipayimg.png" alt="扫码支持" title="扫一扫"> </div>
                    <div class="pay_explain">扫码打赏，你说多少就多少</div>
                    <div class="shang_payselect">
                        <div class="pay_item checked" data-id="alipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="images/alipay.jpg" alt="支付宝"></span> </div>
                        <div class="pay_item" data-id="weipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="images/wechat.jpg" alt="微信"></span> </div>
                    </div>
                    <script type="text/javascript">
                        $(function(){
                            $(".pay_item").click(function(){
                                $(this).addClass('checked').siblings('.pay_item').removeClass('checked');
                                var dataid=$(this).attr('data-id');
                                $(".shang_payimg img").attr("src","/front/images/"+dataid+"img.png");
                                $("#shang_pay_txt").text(dataid=="alipay"?"支付宝":"微信");
                            });
                        });
                        function dashangToggle(){
                            $(".hide_box").fadeToggle();
                            $(".shang_box").fadeToggle();
                        }
                    </script>
                </div>
            </div>
            <!--share end-->
            <div class="zsm"><p>打赏本站，你说多少就多少</p><img src="images/help.png"></div>
        </div>
        <div class="nextinfo">
            <p>上一篇：<a href="/front/info?id=<?php echo e($data['prev']['id']); ?>" ><?php echo e($data['prev']['title']); ?></a></p>
            <p>下一篇：<a href="/front/info?id=<?php echo e($data['next']['id']); ?>" ><?php echo e($data['next']['title']); ?></a></p>
        </div>
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                <?php $__currentLoopData = $data['recommend']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="/front/info?id=<?php echo e($value['id']); ?>"><?php echo e($value['title']); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="news_pl">
            <h2>文章评论</h2>
            <ul>
            </ul>
        </div>
    </div>
    <div class="rightbox">
        <div class="search">
            <form action="/e/search/index.php" method="post" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input name="show" value="title" type="hidden">
                <input name="tempid" value="1" type="hidden">
                <input name="tbname" value="news" type="hidden">
                <input name="Submit" class="input_submit" value="搜索" type="submit">
            </form>
        </div>
        <div class="paihang">
            <h2 class="ab_title"><a href="/">本栏推荐</a></h2>
            <ul>
                <li><b><a href="/" target="_blank">住在手机里的朋友</a></b>
                    <p>对于刚毕业的学生来说，想学习建网站，掌握一技之长，最简单的入门无学...</p>
                </li>
                <li><b><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></b>
                    <p>对于刚毕业的学生来说，想学习建网站，掌握一技之长，最简单的入门...</p>
                </li>
                <li><b><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码</a></b>
                    <p>.先前发表过一篇文章《如果要学习web前端开发，需要学习什么？》</p>
                </li>
                <li><b><a href="/" target="_blank">手机的16个惊人小秘密，据说99.999%的人都不知</a></b>
                    <p>对于刚毕业的学生来说，.需要学习什么？》</p>
                </li>
                <li><b><a href="/" target="_blank">你面对的是生活而不是手机</a></b>
                    <p>.最简单的入门无非就是学会html和css，先前发表过一篇文章...</p>
                </li>
            </ul>
            <div class="ad"><img src="images/ad300x100.jpg"></div>
        </div>
        <div class="paihang">
            <h2 class="ab_title"><a href="/">点击排行</a></h2>
            <ul>
                <li><b><a href="/" target="_blank">住在手机里的朋友</a></b>
                    <p>对于刚毕业的学生来说，想学习建网站，掌握一技之长，最简单的入门无学...</p>
                </li>
                <li><b><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></b>
                    <p>对于刚毕业的学生来说，想学习建网站，掌握一技之长，最简单的入门...</p>
                </li>
                <li><b><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码</a></b>
                    <p>.先前发表过一篇文章《如果要学习web前端开发，需要学习什么？》</p>
                </li>
                <li><b><a href="/" target="_blank">手机的16个惊人小秘密，据说99.999%的人都不知</a></b>
                    <p>对于刚毕业的学生来说，.需要学习什么？》</p>
                </li>
                <li><b><a href="/" target="_blank">你面对的是生活而不是手机</a></b>
                    <p>.最简单的入门无非就是学会html和css，先前发表过一篇文章...</p>
                </li>
            </ul>
            <div class="ad"><img src="images/ad01.jpg"></div>
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

<script>
    layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
        var form = layui.form,
            table = layui.table,
            layer = layui.layer,
            upload = layui.upload,
            element = layui.element,
            $ = layui.jquery;
        var _token = $('.token').attr("_token");
        $('.diggit a').click(function () {
            id = $(this).attr('data-id');
            love = $('#diggnum').text();
            $.ajax({
                url:'/front/love',
                data:{_token:_token,id:id},
                type:'POST',
                success:function (e) {
                    if (e.code == 0) {
                        layer.msg(e.msg);
                        $('#diggnum').text(parseInt(parseInt(love)+1));
                    } else {
                        layer.msg(e.msg);
                    }
                }
            })
        });
    });

</script>

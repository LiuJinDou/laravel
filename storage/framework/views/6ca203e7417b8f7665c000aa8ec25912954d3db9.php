<?php echo $__env->make('front/head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="line46"></div>
<div class="blank"></div>
<article>
    <div class="leftbox">
        <div class="infos">
            <div class="newsview">
                <h3 style="text-align: center">此路不通，请绕行</h3>
                <hr>
                <img src="/front/images/404.gif" alt="" style="width: 100%;height: 40%;text-align: center;">
            </div>
            <div class="share">
                <p class="diggit"><a href=""> 很赞哦！ </a>(<b id="diggnum">13</b>)</p>
                <p class="dasbox"><a href="javascript:void(0)" onclick="dashangToggle()" class="dashang" title="打赏，支持一下">打赏本站</a></p>
                <div class="hide_box" style="display: none;"></div>
                <div class="shang_box" style="display: none;"> <a class="shang_close" href="javascript:void(0)" onclick="dashangToggle()" title="关闭">关闭</a>
                    <div class="shang_tit">
                        <p>感谢您的支持，我会继续努力的!</p>
                    </div>
                    <div class="shang_payimg"> <img src="images/alipayimg.jpg" alt="扫码支持" title="扫一扫"> </div>
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
                                $(".shang_payimg img").attr("src","images/"+dataid+"img.jpg");
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
            <div class="zsm"><p>打赏本站，你说多少就多少</p><img src="images/zsm.jpg"></div>
        </div>
        <div class="nextinfo">
            <p>上一篇：<a href="/front/info?id=<?php echo e($data['prev']['id']); ?>" ><?php echo e($data['prev']['title']); ?></a></p>
            <p>下一篇：<a href="/front/info?id=<?php echo e($data['next']['id']); ?>" ><?php echo e($data['next']['title']); ?></a></p>
        </div>
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                <li><a href="/" title="云南之行――丽江古镇玉龙雪山">云南之行――丽江古镇玉龙雪山</a></li>
                <li><a href="/" title="云南之行――大理洱海一日游">云南之行――大理洱海一日游</a></li>
                <li><a href="/" target="_blank">住在手机里的朋友</a></li>
                <li><a href="/" target="_blank">豪雅手机正式发布! 在法国全手工打造的奢侈品</a></li>
                <li><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></li>
                <li><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码...</a></li>
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

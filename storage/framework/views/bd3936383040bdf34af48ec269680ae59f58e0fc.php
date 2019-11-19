<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Shadow·Login</title>
    <link rel="stylesheet" href="/js/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/css/login.css" media="all"/>
    <style>
        /* 覆盖原框架样式 */
        .layui-elem-quote{background-color: inherit!important;}
        .layui-input, .layui-select, .layui-textarea{background-color: inherit; padding-left: 30px;}
    </style>
</head>
<body>
<!-- Head -->
<div class="layui-fluid zyl_center">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-sm12 layui-col-md12 zyl_mar_01">
            <blockquote class="layui-elem-quote">Shadow·Admin Login</blockquote>
        </div>
    </div>
</div>
<!-- Head End -->

<!-- Carousel -->
<div class="layui-row">
    <div class="layui-col-sm12 layui-col-md12">
        <div class="layui-carousel zyl_login_height" id="zyllogin" lay-filter="zyllogin">
            <div carousel-item="">
                <div>
                    <div class="zyl_login_cont"></div>
                </div>
                <div>
                    <img src="/image/login/01.jpg" />
                </div>
                <div>
                    <div class="background">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div>
                    <img src="/image/login/03.jpg" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- Footer -->
<div class="layui-row">
    <div class="layui-col-sm12 layui-col-md12 zyl_center zyl_mar_01">
        © 2019-8-1 Admin login
    </div>
</div>
<!-- Footer End -->



<!-- LoginForm -->
<div class="zyl_lofo_main">
    <fieldset class="layui-elem-field layui-field-title zyl_mar_02">
        <legend>Welcome Login - Shadow background management platform</legend>
    </fieldset>
    <div class="layui-row layui-col-space15">
        <form class="layui-form zyl_pad_01">
            <div class="layui-col-sm12 layui-col-md12">
                <div class="layui-form-item">
                    <?php echo e(csrf_field()); ?>

                    <input type="text" name="name" lay-verify="required|name" autocomplete="off" placeholder="账号" class="layui-input" value="">
                    <i class="layui-icon layui-icon-username zyl_lofo_icon"></i>
                </div>
            </div>
            <div class="layui-col-sm12 layui-col-md12">
                <div class="layui-form-item">
                    <input type="password" name="password" lay-verify="required|pass" autocomplete="off" placeholder="密码" class="layui-input" value="">
                    <i class="layui-icon layui-icon-password zyl_lofo_icon"></i>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="layui-col-sm12 layui-col-md12">
                <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="demo1">立即登录</button>
            </div>
        </form>
    </div>
</div>
<!-- LoginForm End -->


<!-- Jquery Js -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- Layui Js -->
<script type="text/javascript" src="/js/layui/layui.js"></script>
<!-- Jqarticle Js -->
<script type="text/javascript" src="/js/login/jparticle.min.js"></script>
<!-- ZylVerificationCode Js-->
<script type="text/javascript" src="/js/login/zylVerificationCode.js"></script>
<script>
    layui.use(['carousel', 'form'], function(){
        var carousel = layui.carousel
            ,form = layui.form;

        //自定义验证规则
        form.verify({
            name: function(value){
                if(value.length < 5){
                    return '账号至少得5个字符';
                }
            }
            ,pass: [/^[\S]{6,12}$/,'密码必须6到12位，且不能出现空格']
            ,vercodes: function(value){
                //获取验证码
                var zylVerCode = $(".zylVerCode").html();
                if(value!=zylVerCode){
                    return '验证码错误（区分大小写）';
                }
            }
            // ,content: function(value){
            //     layedit.sync(editIndex);
            // }
        });

        //监听提交
        form.on('submit(demo1)', function(data){
            // layer.alert(JSON.stringify(data.field),{
            //     title: '最终的提交信息'
            // })
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/admin/login',
                dateType:'json',
                data:{username:data.field.name,password:data.field.password,_token:'<?php echo e(csrf_token()); ?>'},
                success:function(res){
                    if(res.code==0){
                        window.location.href='/admin/index';
                    } else {
                        layer.open({
                            title: '登录失败'
                            ,content: '用户名/密码不正确，要仔细哦...'
                            ,time:1000
                        });

                    }
                },
                error:function (res) {
                    layer.open({
                        title: '登录失败'
                        ,content: '系统异常,刷新后重试...'
                        ,time:1000
                    });

                }
            });

            return false;
        });


        //设置轮播主体高度
        var zyl_login_height = $(window).height()/1.25;
        var zyl_car_height = $(".zyl_login_height").css("cssText","height:" + zyl_login_height + "px!important");


        //Login轮播主体
        carousel.render({
            elem: '#zyllogin'//指向容器选择器
            ,width: '100%' //设置容器宽度
            ,height:'zyl_car_height'
            ,arrow: 'none' //始终显示箭头
            ,anim: 'fade' //切换动画方式
            ,autoplay: true //是否自动切换false true
            ,arrow: 'none' //切换箭头默认显示状态||不显示：none||悬停显示：hover||始终显示：always
            ,indicator: 'none' //指示器位置||外部：outside||内部：inside||不显示：none
            ,interval: '5000' //自动切换时间:单位：ms（毫秒）
        });


        //监听轮播--案例暂未使用
        carousel.on('change(zyllogin)', function(obj){
            var loginCarousel = obj.index;
        });

        //粒子线条
        $(".zyl_login_cont").jParticle({
            background: "rgba(0,0,0,0)",//背景颜色
            color: "#fff",//粒子和连线的颜色
            particlesNumber:100,//粒子数量
            //disableLinks:true,//禁止粒子间连线
            //disableMouse:true,//禁止粒子间连线(鼠标)
            particle: {
                minSize: 1,//最小粒子
                maxSize: 3,//最大粒子
                speed: 30,//粒子的动画速度
            }
        });

    });

</script>
</body>
</html>

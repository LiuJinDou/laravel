layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,//Tab的切换功能，切换事件监听等，需要依赖element模块
        $ = layui.jquery;
    var h = $(window).height() - 41 - 10 - 60 - 10 - 44 - 10;
    //触发事件
    var active = {
        //在这里给active绑定几项事件，后面可通过active调用这些事件
        tabAdd: function(url, id, name) {
            //新增一个Tab项 传入三个参数，分别是tab页面的地址，还有一个规定的id，对应其标题，是标签中data-id的属性值
            //关于tabAdd的方法所传入的参数可看layui的开发文档中基础方法部分
            element.tabAdd('home-tabs', {
                title: name,
                content: '<iframe id="'+id+'" data-frameid="' + id + '" scrolling="auto" frameborder="0" src="' + url +
                    '" style="width:100%;height:' + h+'px;"></iframe>',
                id: id //规定好的id
            })
            //通过鼠标mouseover事件  动态将新增的tab下的li标签绑定鼠标右键功能的菜单
            //下面的json.id是动态新增Tab的id，一定要传入这个id,避免重复加载mouseover数据
            $(".layui-tab-title li[lay-id=" + id + "]").mouseover(function() {
                var tabId = $(this).attr("lay-id");
                CustomRightClick(tabId); //给tab绑定右击事件
                FrameWH(); //计算ifram层的大小
            });
        },
        tabChange: function(id) {
            //切换到指定Tab项
            element.tabChange('home-tabs', id); //根据传入的id传入到指定的tab项
            if (id=999){
                $('.layui-tab-title > li i:eq(1)').css('display','none');
            }
        },
        tabDelete: function(id) {
            element.tabDelete('home-tabs', id); //删除
        },
        tabRefresh: function(id) { //刷新页面
            $("iframe[data-frameid='" + id + "']").attr("src", $("iframe[data-frameid='" + id + "']").attr("src")) //刷新框架
        }
    };

    //当点击有site-demo-active属性的标签时，即左侧菜单栏中内容 ，触发点击事件
    $('.site-demo-active').on('click', function() {
        var dataid = $(this);

        //这时会判断右侧.layui-tab-title属性下的有lay-id属性的li的数目，即已经打开的tab项数目
        if ($(".layui-tab-title li[lay-id]").length <= 0) {
            //如果比零小，则直接打开新的tab项
            active.tabAdd(dataid.attr("data-url"), dataid.attr("data-id"), dataid.attr("data-title"));
        } else {
            //否则判断该tab项是否以及存在

            var isData = false; //初始化一个标志，为false说明未打开该tab项 为true则说明已有
            $.each($(".layui-tab-title li[lay-id]"), function() {
                //如果点击左侧菜单栏所传入的id 在右侧tab项中的lay-id属性可以找到，则说明该tab项已经打开
                if ($(this).attr("lay-id") == dataid.attr("data-id")) {
                    isData = true;
                }
            })
            if (isData == false) {
                //标志为false 新增一个tab项
                active.tabAdd(dataid.attr("data-url"), dataid.attr("data-id"), dataid.attr("data-title"));
            }
        }
        //最后不管是否新增tab，最后都转到要打开的选项页面上
        active.tabChange(dataid.attr("data-id"));
    });

    function CustomRightClick(id) {
        //取消右键  rightmenu属性开始是隐藏的 ，当右击的时候显示，左击的时候隐藏
        $('.layui-tab-title li').on('contextmenu', function() {
            return false;
        })
        $('.layui-tab-title,.layui-tab-title li').click(function() {
            $('.rightmenu').hide();
        });
        //单击取消右键菜单
        $('body,#aaa').click(function() {
            $('.rightmenu').hide();
        });
        //tab点击右键
        $('.layui-tab-title li').on('contextmenu', function(e) {
            var popupmenu = $(".rightmenu");
            popupmenu.find("li").attr("data-id", id); //在右键菜单中的标签绑定id属性
            //判断右侧菜单的位置
            l = ($(document).width() - e.clientX) < popupmenu.width() ? (e.clientX - popupmenu.width()) : e.clientX;
            t = ($(document).height() - e.clientY) < popupmenu.height() ? (e.clientY - popupmenu.height()) : e.clientY;
            popupmenu.css({
                left: l-180,
                top: t-60
            }).show(); //进行绝对定位
            return false;
        });
    }

    $(".rightmenu li").click(function() {
        //当前的tabId
        var currentTabId = $(this).attr("data-id");

        if ($(this).attr("data-type") == "closeOthers") { //关闭其他
            var tabtitle = $(".layui-tab-title li");
            $.each(tabtitle, function(i) {
                if ($(this).attr("lay-id") != currentTabId) {
                    active.tabDelete($(this).attr("lay-id"))
                }
            })
        } else if ($(this).attr("data-type") == "closeAll") { //关闭全部
            var tabtitle = $(".layui-tab-title li");
            $.each(tabtitle, function(i) {
                active.tabDelete($(this).attr("lay-id"))
            })

        } else if ($(this).attr("data-type") == "refresh") { //刷新页面
            active.tabRefresh($(this).attr("data-id"));

        } else if ($(this).attr("data-type") == "closeRight") { //关闭右边所有
            //找到当前聚焦的li之后的所有li标签 然后遍历
            var tabtitle = $(".layui-tab-title li[lay-id=" + currentTabId + "]~li");
            $.each(tabtitle, function(i) {
                active.tabDelete($(this).attr("lay-id"))
            })
        }

        $('.rightmenu').hide();
    });
    $(document).on('click','.refreshtab',function () {
        refreshTab()
    });
    function refreshTab(){
        id = $('.layui-tab-title li[class=layui-this]').attr('lay-id');
        active.tabRefresh(id);
    }
    //导航栏点击选中时关闭其他选项卡
    $('.layui-nav-item').click(function() {
        $(this).siblings('li').attr('class', 'layui-nav-item');
    });

    function FrameWH() {
        var h = $(window).height() - 41 - 10 - 60 - 10 - 44 - 10;
        $("iframe").css("height", h + "px");
    }

    $(window).resize(function() {
        FrameWH();
    });

    //打开默认页面
    active.tabAdd("/admin/desktop", 999, "<i class='layui-icon'>&#xe68e;</i> My desktop");
    active.tabChange(999);
    element.render();

    $('.control-side i').click(function() {
        if($('.layui-side').css('left')=='0px'){
            $('.layui-side').animate({left: '-200px'}, 100);
            $('.layui-body').animate({left: '0px'}, 100);
            $(this).empty();
            $(this).html('&#xe66b;');
            $(this).attr('title','打开左侧栏');
        }else{
            $('.layui-side').animate({left: '0px'}, 100);
            $('.layui-body').animate({left: '200px'}, 100);
            $(this).empty();
            $(this).html('&#xe668;');
            $(this).attr('title','关闭左侧栏');
        }

    });

    var _token = $('.token').attr("_token");
    //清楚缓存
    $(document).on('click','.clear_cache',function(){
        $.ajax({
            url:'/admin/clear-cache',
            success:function (res) {
                layer.open({
                    title: '清楚缓存'
                    ,time: 500//1秒后自动关闭
                    ,content: res
                });
                location.reload();
            }
        })
    });

    //页面加载调用
    window.onload=function(){
        //每1秒刷新时间
        setInterval(NowTime,1000);
        setInterval(Timer,1000);
    }
    function Timer(){
        //时间
        serverTime = new Date();
        $('#timer').html(serverTime);
    }
    function NowTime(){
        var myDate=new Date();
        var y = myDate.getFullYear();
        var M = myDate.getMonth()+1;     //获取当前月份(0-11,0代表1月)
        var d = myDate.getDate();        //获取当前日(1-31)
        var h = myDate.getHours();       //获取当前小时数(0-23)
        var m = myDate.getMinutes();     //获取当前分钟数(0-59)
        var s = myDate.getSeconds();     //获取当前秒数(0-59)

        //检查是否小于10
        M=check(M);
        d=check(d);
        h=check(h);
        m=check(m);
        s=check(s);
        var timestr = y+"-"+M+"-"+d+" "+h+":"+m+":"+s;
        $('#nowtime').html(timestr);
    }
    //时间数字小于10，则在之前加个“0”补位。
    function check(i){
        var num = (i<10)?("0"+i) : i;
        return num;
    }
    // 字典
    var flag = true;
    $(document).on('click','.mysql',function(){
        var layer = layui.layer,
            $=layui.jquery;
        if (flag) {
            flag = false;
            $.ajax({
                url:'/admin/mysql',
                success:function (res) {
                    layer.open({
                        type: 1,
                        title: '字典',
                        shadeClose: true,
                        shade: false,
                        maxmin: true, //开启最大化最小化按钮
                        offset: ['60px', '200px'],
                        area: ['85%', '85%'],
                        content: res,
                        cancel: function () {
                            flag = true;
                        }
                    });
                }
            })
        }
    })

    //基本信息
    $(document).on('click','.base-info',function(){
        id = $(this).attr('data-id');
        $.ajax({
            url:'/admin/info',
            data:{id:id},
            success:function (res) {
                template = '<form class="layui-form">\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">用户名</label>\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <input type="text" name="name" value=" '+ res.data.name + '" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">\n' +
                    '      <input type="hidden" name="_token" value=" '+ _token + '" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +
                    '      <input type="hidden" name="id" value=" '+ res.data.id + '" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">邮箱</label>\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <input type="text" name="email" value=" '+ res.data.email + '"  required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">手机号</label>\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <input type="text" name="mobile" value=" '+ res.data.mobile + '"  required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">角色</label>\n' +
                    '    <div class="layui-input-block">\n' +
                    '       <select name="role_id" lay-verify="required"></select>   \n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '<div class="">\n' +
                    '    <label class="layui-form-label">头像</label>\n' +
                    ' <div class="layui-upload">\n' +
                    ' <button type="button" class="layui-btn" id="head"><i class="layui-icon">&#xe67c;</i>上传图片</button> <img src="'+res.data.headpic+'" alt="" class="head" width="50px;" height="50px;">\n' +
                    ' <input type="hidden" name="headpic" value=" '+ res.data.headpic + '"  required  lay-verify="required" class="layui-input">\n' +
                    '</div> \n' +
                    ' </div>\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <label class="layui-form-label">状态</label>\n' +
                    '    <div class="layui-input-block">\n '+
                    '       <input type="radio" name="status" value="1" title="正常" checked> ' +
                    '       <input type="radio" name="status" value="0" title="禁用" disabled> ' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '  <div class="layui-form-item">\n' +
                    '    <div class="layui-input-block">\n' +
                    '      <button class="layui-btn" lay-submit lay-filter="base-info">确定</button>\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '</form>';
                info = layer.open({
                    title: '基本资料'
                    ,type : 1
                    ,content: template
                    ,success: function(layero, index){
                        $.ajax({
                            url:'/admin/getRoleList',
                            data:{_token:_token},
                            async: false,
                            type:"POST",
                            dataType: "json",
                            success:function (res) {
                                var option = '<option value="">请选择角色</option>';
                                $.each(res.data, function (index, item) {
                                    option += '<option value="'+item.id+'">'+item.name+'</option>';
                                });
                                console.log(option);
                                $('[name="role_id"]').append(option);
                            }
                        })
                        form.render();
                    }
                });
                //执行实例

                var uploadInst = upload.render({
                    elem: '#head' //绑定元素
                    ,url: '/admin/files' //上传接口
                    ,done: function(res){
                        //上传完毕回调
                        $('.head').attr('src',res.data);
                        $("[name='headpic']").attr('value',res.data);
                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });
            }
        })
        //监听提交
        form.on('submit(base-info)', function(data){
            $.ajax({
                url:'/admin/editor',
                data:data.field,
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    layer.msg(res.msg);
                    if (res.code == 0) layer.close(info);
                }
            })
            return false;
        });
    });
    //安全设置
    $(document).on('click','.safe-set',function(){
        template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">旧密码</label>\n' +
            '    <div class="layui-input-inline">\n' +
            '      <input type="password" name="old_password" value="" placeholder="请输入旧密码" autocomplete="off" class="layui-input">\n' +
            '     <input type="hidden" name="_token" value=" '+ _token + '" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +

            '     <input type="hidden" name="id" value=" '+ $(this).attr('data-id') + '" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            ' <div class="layui-form-mid layui-word-aux">' +
            '     <input type="checkbox" name="forget" lay-skin="switch" lay-filter="switchTest" lay-text="忘记|记得"> \n' +
            '</div>\n'+
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">新密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="new_password" value="" placeholder="请输入新密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">确认新密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="sure_password" value="" placeholder="确认新密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="safe-set">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        safe = layer.open({
            title: '修改密码'
            ,type : 1
            ,content: template
            ,success:function () {
                form.render();
            }
        });

        //监听提交
        form.on('submit(safe-set)', function(data){
            $.ajax({
                url:'/admin/updatePw',
                data:data.field,
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    layer.msg(res.msg);
                    if (res.code == 0) layer.close(safe);
                }
            });
            return false;
        });
    });

    $(document).on('click','.refresh',function(){
        location.reload([true])
    })
});

layui.use(['form', 'laypage', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        laypage = layui.laypage,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    var article_id = $('[name="article_id"]').val();
    get_message();
    init_data();
    laypage.render({
        elem: 'test1'
        ,count: total //数据总数，从服务端得到
        ,jump: function(obj, first){
            //首次不执行
            if(!first){
                //do something
                get_message(obj.curr);
                init_data();
            }
        }
    });
    var uploadInst = upload.render({
        elem: '#head' //绑定元素
        ,url: '/admin/files' //上传接口
        ,done: function(res){
            //上传完毕回调
            $('.head').attr('src',res.data).show();
            $("[name='headpic']").attr('value',res.data);
        }
        ,error: function(){
            //请求异常回调
        }
    });
    function get_message(page=1) {
        $.ajax({
            url:'/front/message',
            data:{_token:_token,page:page,article_id:article_id},
            async: false,
            type:"POST",
            dataType: "json",
            success:function (e) {
                message = e.data.message;
                total = e.data.count;
                if (total == 0) {
                    $('.pagelist').hide();
                }
            }
        });
    }
    function init_data() {
        var message_list = '';

        $.each(message,function (i,v) {
            if (v.headpic!=null) {
                headpic = '<span class="tximg"><img src="'+v.headpic+'"></span>\n';
            } else {
                headpic = '\n';
            }

            message_list += '<div class="fb">\n' +
                '                        <ul>\n' + headpic+
                '                            <p class="fbtime"><span>'+v.create_at+'</span> 昵称：'+v.name+'</p>\n' +
                '                            <p class="fbinfo">'+v.content+'</p>\n' +
                '                        </ul>\n' +
                '                    </div>'
        });
        $('.fb').remove();
        $('.pagelist').before(message_list);
    }
    //添加留言
    $('.add-message').on('click',function () {
        article_id = $('[name="id"]').val();
        name_m = $('[name="name"]').val();
        content = $('[name="content"]').val();
        mycall = $("input[name='mycall']:checked").val();
        headpic = $('[name="headpic"]').val();
        if (headpic.length ==0 && typeof  mycall == 'undefined'){
            layer.msg('请选择/上传头像');return false;
        } else if (headpic.length ==0) {
            headpic = mycall;
        }
        if($(this).attr('label')) {
            layer.msg('Thanks your message!');return false;
        }
        $.ajax({
            url:'/front/addMessage',
            data:{_token:_token,content:content,headpic:headpic,name:name_m,article_id:article_id},
            type:"POST",
            dataType: "json",
            success:function (e) {
                $('.add-message').attr('class','layui-btn layui-btn-disabled add-message');
                $('.add-message').attr('label','1');
                layer.msg(e.msg);
            }
        });
        return false;
    });
});
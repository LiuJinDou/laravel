layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var E = window.wangEditor
    var editor;
    var ue;
    var _token = $('.token').attr("_token");
    var option = '';
    var category = '';
    $.ajax({
        url:'/admin/books/category',
        data:{_token:_token},
        async: false,
        type:"POST",
        dataType: "json",
        success:function (res) {
            category = res.data;
            $('#category_id').append(category_option());
            //重新渲染select
            form.render('select');
        }
    })
    table.render({
        elem: '#test'
        ,url:'/admin/books/list'
        ,method:'post'
        ,where:{_token: _token}
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', align:'center', width:120}
            ,{field:'image', title:'图片', align:'center', width:120,templet:function (d) {
                    if (d.image == null) {
                        return '';
                    }  else {
                        return '<img src="'+ d.image +'" alt="" class="head" width="60px;" height="40px;">';
                    }
                }}
            ,{field:'category_name', title:'分类', align:'center', width:100}
            ,{field:'author', title:'作者', align:'center', width:100}
            ,{field:'author_desc', title:'作者简介', align:'center', width:100}
            ,{field:'tags', title:'标签', align:'center', width:100}
            ,{field:'status', title: '状态',align:'center', width:120, templet:function (d) {
                    if (d.status==1) {
                        return ' <input type="checkbox" id="'+d.id+'" checked name="close" lay-filter="switchTest" lay-skin="switch" lay-text="已读|未读">';
                    }  else {
                        return ' <input type="checkbox" id="'+d.id+'"  name="close" lay-filter="switchTest" lay-skin="switch" lay-text="已读|未读">';
                    }
                }
            }
            ,{field:'share_status', title: '分享状态',align:'center', width:120, templet:function (d) {
                    if (d.share_status==1) {
                        return ' <input type="checkbox" id="'+d.id+'" checked name="close" lay-filter="switchTest" lay-skin="switch" lay-text="已分享|未分享" disabled>';
                    }  else {
                        return ' <input type="checkbox" id="'+d.id+'"  name="close" lay-filter="switchTest" lay-skin="switch" lay-text="已分享|未分享" disabled>';
                    }
                }
            }
            ,{field:'introduction', title:'简介', align:'center', width:100}
            ,{field: 'create_at', title: '创建时间',width:200,align:'center', templet:function (d) { return showTime(d.create_at,1)}}
            ,{field:'create_uid', title:'创建人', width:80,align:'center'}
            ,{field:'update_at', title: '更新时间',width:200,align:'center', templet:function (d) { return showTime(d.update_at,3)}}
            ,{field:'update_uid', title:'更新人', width:80,align:'center', }
            ,{fixed: 'right', title:'操作',  width:150,align:'center', templet:function (d) {
                    operate = ' <a class="layui-btn layui-btn-xs" lay-event="edit" lay-id =\'+d.id+\' >查看</a> \n';
                    if (d.status==0 && d.share_status==0) {
                        operate += ' <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" lay-id ='+d.id+'>删除</a>';
                    }  else if (d.status==1 && d.share_status==0) {
                        operate += '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="share" lay-id ='+d.id+'>分享</a>';
                    }else if (d.status==1 && d.share_status==1) {
                        operate += '<a class="layui-btn layui-btn-xs" lay-event="cancel_share" lay-id ='+d.id+'>取消分享</a>';
                    }
                    return operate;
                }
            }
        ]]
        ,id: 'testReload'
        ,title: 'testReload'
        // ,height: 380
        ,page: true
    });

    //监听行工具事件
    table.on('tool(test)', function(obj){
        var data = obj.data;
        //console.log(obj)
        if(obj.event === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/books/del',
                    type:'POST',
                    data:{id:obj.data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('testReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        } else if(obj.event === 'edit'){
            book(obj);
        } else if (obj.event == 'share') {
            layer.confirm('确定分享吗？', function(index){
                $.ajax({
                    url:'/admin/books/share',
                    type:'POST',
                    data:{id:obj.data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('testReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        }else if (obj.event == 'cancel_share') {
            layer.confirm('确定取消分享吗？', function(index){
                $.ajax({
                    url:'/admin/books/cancel_share',
                    type:'POST',
                    data:{id:obj.data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('testReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        }
    });

    var active = {
        reload: function(){
            var demoReload = $('#demoReload');
            var title = $('#title');
            var category_id = $('#category_id');

            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    id: demoReload.val(),
                    title: title.val(),
                    category_id: category_id.val()
                }
            }, 'data');
        }
    };

    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    //监听指定开关
    form.on('switch(switchTest)', function(data){
        id = $(this).attr('id');
        this.checked ? status = 1 : status = 0;
        $.ajax({
            url:'/admin/books/status',
            type:'POST',
            data:{id:id,_token: _token,status:status},
            success:function (e) {
                layer.msg(e.msg);
                active['reload'] ? active['reload'].call(this) : '';
            }
        });
    });
    $('.add_book').on('click',function () {
        book();
    })
    function category_option(id=0){
        option += '<option value="0">Please select category</option>';
        $.each(category, function (v, item) {
            if (id == item.id) {
                option += '<option selected value="'+item.id+'">'+item.name+'</option>';
            }  else {
                option += '<option value="'+item.id+'">'+item.name+'</option>';
            }
            $.each(item.children, function (v, val) {
                if (id == val.id) {
                    option += '<option selected value="'+val.id+'">--|--'+val.name+'</option>';
                }  else {
                    option += '<option value="'+val.id+'">--|--'+val.name+'</option>';
                }
            });
        });
        return option;
    }
    function book(obj='') {
        if (obj!='') {
            id = obj.data.id;
            category_id = obj.data.category_id;
            name = obj.data.name;
            content = obj.data.content;
            image = obj.data.image;
            introduction = obj.data.introduction;
            tags = obj.data.tags;
            author = obj.data.author;
            author_desc = obj.data.author_desc;
        } else {
            id = 0;category_id=0;name = '';content = '';image = '';introduction = '';tags = '';author='';author_desc='';
        }
        option = category_option(category_id)

        templet = '<form class="layui-form" action="">\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">名称</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="name" required value="'+name+'"  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="id" value="'+id+'" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="_token" value="'+_token+'" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">图片</label>\n' +
            '        <div class="layui-input-inline">\n' +
            '           <div class="layui-upload">\n' +
            '            <button type="button" class="layui-btn" id="article_image"><i class="layui-icon">&#xe67c;</i>上传图片</button> <img src="'+image+'" alt="" class="head" width="50px;" height="50px;">\n' +
            '            <input type="hidden" name="image" value="'+image+'"  required  lay-verify="required" class="layui-input">              </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">分类</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <select name="category_id" lay-verify="required">'+option+'</select>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">作者</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="author" value="'+author+'"  placeholder="请输入作者" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">作者简介</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="author_desc" value="'+author_desc+'"  placeholder="请输入简介" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">标签</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="tags" value="'+tags+'"  placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">简介</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <textarea name="introduction" id="" cols="150" rows="10">'+introduction+'</textarea>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item layui-form-text">\n' +
            '        <label class="layui-form-label">读后感</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <script id="content"></script>\n' +
            '        </div>\n' +
            '        <label class="layui-form-label">\n' +
            '            <button type="button" class="layui-btn layui-btn-primary browse">预览</button>\n' +
            '        </label>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <div class="layui-input-block">\n' +
            '            <button class="layui-btn" lay-submit lay-filter="book">立即提交</button>\n' +
            '            <button type="reset" class="layui-btn layui-btn-primary">重置</button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</form>';
        index = layer.open({
            type: 1,
            title: '查看',
            shadeClose: true,
            shade: false,
            // maxmin: true, //开启最大化最小化按钮
            // offset: ['60px', '200px'],
            // area: ['85%', '85%'],
            content: templet,
            success: function(layero, index){
                var body = layer.getChildFrame('body', index);
                // editor = new E('#toolbar','#content');
                // editor.create();
                ue = UE.getEditor('content');
                //对编辑器的操作最好在编辑器ready之后再做
                ue.ready(function() {
                    //设置编辑器的内容
                    ue.setContent(content);
                    //获取html内容，返回: <p>hello</p>
                    // var html = ue.getContent();
                    //获取纯文本内容，返回: hello
                    // var txt = ue.getContentTxt();
                });
                $('.browse').on('click',function () {
                    // content = editor.txt.html();
                    var content = ue.getContent();
                    browse = layer.open({
                        type: 1,
                        content: content //这里content是一个普通的String
                    });
                    layer.full(browse);
                });
                var uploadInst = upload.render({
                    elem: '#article_image' //绑定元素
                    ,url: '/admin/files' //上传接口
                    ,done: function(res){
                        //上传完毕回调
                        $('.head').attr('src',res.data);
                        $("[name='image']").attr('value',res.data);
                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });
                form.render();
            }
        });
        layer.full(index);
        //监听提交
        form.on('submit(book)', function(data){
            prarm = data.field;
            prarm['content'] = ue.getContent();
            $.ajax({
                url:'/admin/books/editor',
                type:'POST',
                data:prarm,
                success:function (o) {
                    if (o.code == 0) {
                        layer.msg(o.msg);
                        setTimeout( function (){
                            layer.close(index)
                        },1000);//再执行关闭
                        active['reload'] ? active['reload'].call(this) : '';
                        return false;
                    }  else {
                        layer.msg(o.msg);return false;
                    }
                }
            })
            return false;
        });
    }
});
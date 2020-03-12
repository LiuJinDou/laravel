layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var E = window.wangEditor;
    var editor;
    var ue;
    var _token = $('.token').attr("_token");
    var option = '';
    var category = '';
    var two_option = '';
    $.ajax({
        url:'/admin/article/category',
        data:{_token:_token},
        async: false,
        type:"POST",
        dataType: "json",
        success:function (res) {
            category = res.data;
            option += '<option value="0">Please select category</option>';
            $.each(res.data, function (v, item) {
                option += '<option value="'+item.id+'">'+item.name+'</option>';
                $.each(item.children, function (v, val) {
                    option += '<option value="'+val.id+'">&nbsp;--|--'+val.name+'</option>';
                });
            });
            $('#category_id').append(option);
        }
    });
    //重新渲染select
    form.render('select');
    table.render({
        elem: '#test'
        ,url:'/admin/article/list'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,title: '文章列表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'title', title:'标题', align:'center', width:120}
            ,{field:'image', title:'图片', align:'center', width:120,templet:function (d) {
                    if (d.image == null) {
                        return '';
                    }  else {
                        return '<img src="'+ d.image +'" alt="" class="head" width="60px;" height="40px;">';
                    }
                }}
            ,{field:'category_name', title:'分类', align:'center', width:100}
            ,{field:'introduction', title:'简介', align:'center', width:100}
            ,{field:'tags', title:'标签', align:'center', width:100}
            ,{field:'browse', title:'浏览',align:'center', sort: true, width:80}
            ,{field:'love', title:'喜欢',align:'center', sort: true, width:80}
            ,{field:'status', title: '状态',align:'center', width:120, templet:function (d) {
                    if (d.status==1) {
                        return ' <input type="checkbox" id="'+d.id+'" checked name="close" lay-filter="switchTest" lay-skin="switch" lay-text="发布|编辑">';
                    }  else {
                        return ' <input type="checkbox" id="'+d.id+'"  name="close" lay-filter="switchTest" lay-skin="switch" lay-text="发布|编辑">';
                    }
                }
            }
            ,{field: 'create_at', title: '创建时间',width:200,align:'center', templet:function (d) { return showTime(d.create_at,1)}}
            ,{field:'create_uid', title:'创建人', width:80,align:'center'}
            ,{field:'update_at', title: '更新时间',width:200,align:'center', templet:function (d) { return showTime(d.update_at,3)}}
            ,{field:'update_uid', title:'更新人', width:80,align:'center', }
            ,{fixed: 'right', title:'操作',  width:150,align:'center', templet:function (d) {
                    if (d.status==0) {
                        return ' <a class="layui-btn layui-btn-xs" lay-event="edit" lay-id ='+d.id+' >查看</a>\n' +
                                ' <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" lay-id ='+d.id+'>删除</a>';
                    }  else {
                        return ' <a class="layui-btn layui-btn-xs" herf="javascript:void(0);" lay-id ='+d.id+'>取消发布可编辑哦</a>';
                    }
                }
            }
        ]]
        ,id: 'testReload'
        ,title: 'testReload'
        // ,height: 380
        ,page: true
    });

    //头工具栏事件
    table.on('toolbar(test)', function(obj){
        var checkStatus = table.checkStatus(obj.config.id);
        switch(obj.event){
            case 'getCheckData':
                var data = checkStatus.data;
                layer.alert(JSON.stringify(data));
                break;
            case 'getCheckLength':
                var data = checkStatus.data;
                layer.msg('选中了：'+ data.length + ' 个');
                break;
            case 'isAll':
                layer.msg(checkStatus.isAll ? '全选': '未全选');
                break;
        };
    });

    //监听行工具事件
    table.on('tool(test)', function(obj){
        var data = obj.data;
        //console.log(obj)
        if(obj.event === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/article/del',
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
            article(obj);
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
            url:'/admin/article/status',
            type:'POST',
            data:{id:id,_token: _token,status:status},
            success:function (e) {
                layer.msg(e.msg);
                active['reload'] ? active['reload'].call(this) : '';
            }
        });
    });
    $('.add_article').on('click',function () {
        article();
    })

    function article(obj='') {
        if (obj!='') {
            id = obj.data.id;
            category_id = obj.data.category_id;
            title = obj.data.title;
            content = obj.data.content;
            image = obj.data.image;
            introduction = obj.data.introduction;
            tags = obj.data.tags;
        } else {
            id = 0;category_id=0;title = '';content = '';image = '';introduction = '';tags = '';
        }
        option = '';
        option += '<option value="">请选择分类</option>';
        $.each(category, function (index, item) {
            if (item.id == category_id) {
                option += '<option value="'+item.id+'" selected>'+item.name+'</option>';
            } else {
                option += '<option value="'+item.id+'" >'+item.name+'</option>';
            }
            $.each(item.children, function (v, val) {
                if (val.id == category_id) {
                    option += '<option value="'+val.id+'" selected>&nbsp;--|--'+val.name+'</option>';
                } else {
                    option += '<option value="'+val.id+'" >&nbsp;--|--'+val.name+'</option>';
                }
            });
        });
        templet = '<form class="layui-form" action="">\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">标题</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="title" required value="'+title+'"  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="id" value="'+id+'" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="_token" value="'+_token+'" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">图片</label>\n' +
            '        <div class="layui-input-inline">\n' +
            '           <div class="layui-upload">\n' +
            '            <button type="button" class="layui-btn" id="article_image"><i class="layui-icon">&#xe67c;</i>上传图片</button> <img src="'+image+'" alt="" class="head" width="50px;" height="50px;">\n' +
            '            <input type="hidden" name="image" value="'+image+'"  class="layui-input">              </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">分类</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <select name="category_id" lay-verify="required">'+option+'</select>\n' +
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
            // '    <div class="layui-form-item layui-form-text">\n' +
            // '        <label class="layui-form-label">内容</label>\n' +
            // '        <div class="layui-input-block">\n' +
            // '       <div id="toolbar" class="toolbar"></div>\n' +
            // '      <div style="padding: 5px 0; color: #ccc">中间隔离带</div>\n' +
            // '            <div id="content">'+content+'</div>\n' +
            // '        </div>\n' +
            // '        <label class="layui-form-label">\n' +
            // '            <button type="button" class="layui-btn layui-btn-primary browse">预览</button>\n' +
            // '        </label>\n' +
            // '    </div>\n' +
            '    <div class="layui-form-item layui-form-text">\n' +
            '        <label class="layui-form-label">内容</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <script id="content"></script>\n' +
            '        </div>\n' +
            '        <label class="layui-form-label">\n' +
            '            <button type="button" class="layui-btn layui-btn-primary browse">预览</button>\n' +
            '        </label>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <div class="layui-input-block">\n' +
            '            <button class="layui-btn" lay-submit lay-filter="article">立即提交</button>\n' +
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
        form.on('submit(article)', function(data){
            prarm = data.field;
            prarm['content'] = ue.getContent();
            $.ajax({
                url:'/admin/article/editor',
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
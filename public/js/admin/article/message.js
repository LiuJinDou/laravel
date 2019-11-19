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
    table.render({
        elem: '#test'
        ,url:'/admin/article/message'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', align:'center', width:120}
            ,{field:'title', title:'文章', align:'center', width:120}
            ,{field:'headpic', title:'头像', align:'center', width:120,templet:function (d) {
                    if (d.headpic == null) {
                        return '';
                    }  else {
                        return '<img src="'+ d.headpic +'" alt="" class="head" width="60px;" height="40px;">';
                    }
                }}
            ,{field:'content', title:'内容', align:'center', width:200}
            ,{field:'status', title: '状态',align:'center', width:120, templet:function (d) {
                    if (d.status==1) {
                        return ' <input type="checkbox" id="'+d.id+'" name="close" lay-filter="switchTest" lay-skin="switch" lay-text="显示|隐藏">';
                    }  else {
                        return ' <input type="checkbox" id="'+d.id+'" name="open" lay-filter="switchTest" lay-skin="switch" lay-text="显示|隐藏">';
                    }
                }
            }
            ,{field: 'create_at', title: '创建时间',width:200,align:'center'}
            ,{field:'client_ip', title: 'IP',width:200,align:'center'}
            ,{fixed: 'right', title:'操作',  width:150,align:'center', templet:function (d) {
                    // if (d.status==0) {
                        return ' <a class="layui-btn layui-btn-xs" lay-event="edit" lay-id ='+d.id+' >查看</a>\n' +
                            ' <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" lay-id ='+d.id+'>删除</a>';
                    // }  else {
                    //     return ' <a class="layui-btn layui-btn-xs" herf="javascript:void(0);" lay-id ='+d.id+'>取消发布可编辑哦</a>';
                    // }
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
                    url:'/admin/article/messageDel',
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

            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
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
            url:'/admin/article/messageStatus',
            type:'POST',
            data:{id:id,_token: _token,status:status},
            success:function (e) {
                layer.msg(e.msg);
                active['reload'] ? active['reload'].call(this) : '';
            }
        });
    });
});
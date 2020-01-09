layui.use('table', function(){
    var table = layui.table,
        form = layui.form;
    var _token = $('.token').attr("_token");
    table.render({
        elem: '#test'
        ,url:'/admin/roleList'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'角色名称', width:120}
            ,{field:'count', title:'数量', sort: true, width:80}
            ,{field:'member_name', title:'成员名称',sort: true, width:120}
            ,{field: 'create_at', title: '创建时间',templet:function (d) { return showTime(d.create_at,1)}}
            ,{field:'create_uid', title:'创建人', width:80, edit: 'text'}
            ,{field:'update_at', title: '更新时间',templet:function (d) { return showTime(d.update_at,3)}}
            ,{field:'update_uid', title:'更新人', width:80, edit: 'text'}
            ,{fixed: 'right', title:'操作',  width:200,templet:function (d) {
                    if (d.id != 1) {
                        return ' <a class="layui-btn layui-btn-xs" lay-event="edit" data-id="'+d.id+'" data-value="'+d.name+'" >编辑</a>\n' +
                            '    <a class="layui-btn layui-btn-danger layui-btn-xs" data-id="'+d.id+'"  lay-event="privilege">权限设置</a>\n' +
                            '    <a class="layui-btn layui-btn-danger layui-btn-xs" data-id="'+d.id+'"  lay-event="del">删除</a>\n';
                    } else {
                        return '';
                    }

                }
            }
        ]]
        ,name: 'testReload'
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
        if(obj.event === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/roleDel',
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
            obj = $(this);
            role_editor(obj);
        } else if (obj.event ==='privilege') {
            role_privilege(obj.data.id);
        }
    });
    //监听指定开关
    form.on('switch(switchTest)', function(data){
        layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
            offset: '6px'
        });
        layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
    });
    var active = {
        reload: function(){
            var name = $('#role_name');

            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    name: name.val()
                    // key: {
                    //     id: demoReload.val(),
                    //     name: title.val()
                    // }
                }
            }, 'data');
        }
    };

    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    /**
     * 编辑分组
     */
    $('.add_role').on('click',function () {
        obj = $(this);
        role_editor(obj);
    });
    function role_editor(obj) {
        var name = obj.attr("data-value");
        var id = obj.attr("data-id");
        if(typeof name=="undefined"){
            name =  '';
        }
        if(typeof id =="undefined"){
            id = 0;
        }
        template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="name" value="'+ name +'" placeholder="请输入角色名称" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="'+ id +'" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="role">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        index = layer.open({
            title: '新增角色'
            ,type : 1
            ,content: template
        });

        //监听提交
        form.on('submit(role)', function(data){
            layer.msg(JSON.stringify(data.field));
            // return false;
            $.ajax({
                url:'/admin/roleSave',
                data:data.field,
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    layer.msg(res.msg);layer.close(index);
                    return false;
                },
                error:function (res) {
                    layer.msg('系统异常、稍后重试');
                }
            });
            return false;
        });
    }

    function role_privilege(id) {
        privile = layer.full(
            layer.open({
            type: 2,
            content: '/admin/rolePrivilege?id='+id, //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
             success: function(layero, index){
                 var body = layer.getChildFrame('body', index);
                 body.find('[name="role_id"]').val(id);
                 body.find('[name="iframe"]').val(privile);
             },yes:function (layero, index) {
                    layero.close();
            }
        })
        );
    }
});
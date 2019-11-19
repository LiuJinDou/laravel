layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    table.render({
        elem: '#member'
        ,url:'/admin/memberList'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:60, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', width:100, edit: 'text'}
            ,{field:'email', title:'邮箱', width:120, edit: 'text'}
            ,{field:'mobile', title:'手机号',width:120}
            ,{field:'headpic', title:'头像', width:80,templet:function (d) {
                    return '<img src="'+d.headpic+'"  style="width: 50px;height: 40px"/>';
                }}
            ,{field:'role_name', title:'所属角色',sort: true, width:120}
            ,{field:'status', title: '状态',sort: true, width:100, templet:function (d) {
                    if (d.status==1) {
                        return ' <input type="checkbox" data-id="'+d.id+'" checked name="close" lay-filter="switchTest" lay-skin="switch" lay-text="启用|禁用">';
                    }  else {
                        return ' <input type="checkbox" data-id="'+d.id+'" name="close" lay-filter="switchTest" lay-skin="switch" lay-text="启用|禁用">';
                    }
                }
            }
            ,{field: 'create_at', title: '创建时间',width:120, templet:function (d) { return showTime(d.create_at,1)}}
            ,{field:'create_uid', title:'创建人', width:80, edit: 'text'}
            ,{field:'update_at', title: '更新时间',width:120, templet:function (d) { return showTime(d.update_at,3)}}
            ,{field:'update_uid', title:'更新人', width:80, edit: 'text'}
            ,{fixed: 'right', title:'操作',  width:200,templet:function (d) {
                    if (d.role_name!='超级管理员') {
                        return '<a class="layui-btn layui-btn-xs base-info"  data-id ='+d.id+'>编辑</a>\n' +
                                '<a class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="del"  lay-id ='+d.id+'>删除</a>\n' +
                                '<a class="layui-btn layui-btn-danger layui-btn-xs safe-set" data-id ='+d.id+'>修改密码</a> ';
                    }  else {
                        return '';
                    }
                }
            }
        ]]
        ,id: 'member'
        ,title: 'member'
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
    table.on('tool(member)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/privilege/memberDel',
                    type:'POST',
                    data:{id:obj.data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('member', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        } else if(obj.event === 'edit'){
            obj = $(this);
            member_editor(data);
        }
    });
    //监听指定开关
    form.on('switch(switchTest)', function(data){
        id = $(this).attr('data-id');
        if (this.checked) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajax({
            url:'/admin/status',
            data:{_token:_token,status:status,id:id},
            async: false,
            type:"POST",
            dataType: "json",
            success:function (res) {
               layer.msg(res.msg);
            }
        })
    });
    var active = {
        reload: function(){
            var name = $('#member-name');
            //执行重载
            table.reload('member', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    name: name.val()
                }
            }, 'data');
        }
    };

    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    /**
     * 添加成员
     */
    $('.add_member').on('click',function () {
        member_editor();
    });
    function member_editor() {
        template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">用户名</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="name" value="" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+_token+'" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="0" required  lay-verify="required" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="password" value="" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">邮箱</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="email" value=""  required  lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">手机号</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="mobile" value=""  required  lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">\n' +
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
            ' <button type="button" class="layui-btn" id="head"><i class="layui-icon">&#xe67c;</i>上传头像</button> <img src="" alt="" class="head" width="50px;" height="50px;">\n' +
            ' <input type="hidden" name="headpic" value=""  required  lay-verify="required" class="layui-input">\n' +
            '</div> \n' +
            ' </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="add_member">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        info = layer.open({
            title: '添加成员'
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
        //监听提交
        form.on('submit(add_member)', function(data){
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
    }
});
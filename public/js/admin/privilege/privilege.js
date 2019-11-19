layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    var tab_id = $('.layui-tab-title li .layui-this').attr("lay-id");
    /**
     * 编辑分组
     */
    $('.edit_group').on('click',function () {
        var group_name = $(this).attr("data-value");
        var id = $(this).attr("data-id");
        if(typeof group_name=="undefined"){
            group_name =  '';
        }
        if(typeof id =="undefined"){
            id = 0;
        }
        template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="group_name" value="'+ group_name +'" placeholder="名称" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="'+ id +'" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="group">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        index = layer.open({
            title: '权限分组'
            ,type : 1
            ,content: template
        });

        //监听提交
        form.on('submit(group)', function(data){
            layer.msg(JSON.stringify(data.field));
            // return false;
            $.ajax({
                url:'/admin/groupSave',
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
    });
    /**
     * 删除分组
     */
    $('.del_group').on('click',function () {
        var id = $(this).attr("data-id");
        layer.confirm('确定删除吗？', function(index){
            //do something
            $.ajax({
                url:'/admin/groupDel',
                data:{id:id,_token:_token},
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    layer.msg(res.msg);layer.close(index);
                    return false;
                },
                error:function (res) {
                    layer.msg(res.msg);
                }
            });
            layer.close(index);
        });
    });
    /**
     * 编辑权限
     */
    $('.privilege_setting_item_edit').on('click',function () {
        var _token = $('.token').attr("_token");
        var privilege_name = $(this).attr("data-value");
        var privilege_url = $(this).attr("data-url");
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        var group_id = $(this).attr("data-group-id");
        if(typeof privilege_name=="undefined"){
            privilege_name = '';
        }
        if(typeof id=="undefined"){
            id = 0;
        }
        if(typeof group_id=="undefined"){
            group_id = 0;
        }
        if(typeof privilege_url=="undefined"){
            privilege_url = '';
        }
        if(typeof type=="undefined"){
            option = '        <option value="0" selected>类型</option> \n' +
                '        <option value="1">接口</option> \n' +
                '        <option value="2">页面</option> \n';
        } else if (type == 1){
            option = '        <option value="0">类型</option> \n' +
            '        <option value="1" selected>接口</option> \n' +
            '        <option value="2">页面</option> \n';
        }  else if (type == 2) {
            option = '        <option value="0">类型</option> \n' +
            '        <option value="1">接口</option> \n' +
            '        <option value="2" selected>页面</option> \n';
        }

         template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="privilege_name" value="'+ privilege_name +'" placeholder="名称" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
            '      <input type="hidden" name="privilege_group_id" value="'+ group_id +'" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="'+ id +'" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">URL</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="privilege_url" value="'+ privilege_url +'" placeholder="名称" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">类型</label>\n' +
            '    <div class="layui-input-block">\n' +
            '       <select name="type" lay-verify=""> \n' + option +
            '       </select>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="group">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        index = layer.open({
            title: '添加权限'
            ,type : 1
            ,content: template
            ,success: function(layero, index){
                form.render('select');
            }
        });

        //监听提交
        form.on('submit(group)', function(data){
            layer.msg(JSON.stringify(data.field));
            // return false;
            $.ajax({
                url:'/admin/privilegeSave',
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
    });
    /**
     * 删除权限
     */
    $('.privilege_setting_item_del').on('click',function () {
        var id = $(this).attr("data-id");
        layer.confirm('确定删除吗？', function(index){
            //do something
            $.ajax({
                url:'/admin/privilegeDel',
                data:{id:id,_token:_token},
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    layer.msg(res.msg);
                    layer.close(index);
                    return false;
                },
                error:function (res) {
                    layer.msg(res.msg);
                }
            });
            layer.close(index);
        });
    });
});


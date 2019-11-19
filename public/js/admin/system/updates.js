layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        laydate = layui.laydate,
        $ = layui.jquery;
    var E = window.wangEditor
    var editor;
    var _token = $('.token').attr("_token");
    // $('.update_log').
    /**
     * 编辑权限
     */
    $('.update_log_editor').on('click',function () {
        var version = $(this).parents('h3').children('.version').text();
        var date = $(this).parents('h3').children('.date').text();
        var content = $(this).parents('h3').next().html();
        var id = $(this).attr("data-id");
        if(typeof version=="undefined"){
            version = '';
        }
        if(typeof id=="undefined"){
            id = 0;
        }
        if(typeof date=="undefined"){
            date = '';
        }
        if(typeof content=="undefined"){
            content = '';
        }
console.log(content);
        template = '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">版本号</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="version" required value="'+ version +'" placeholder="版本号" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="'+ id +'" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">发布时间</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="date" id="date" required value="'+ date +'" placeholder="请输入发布时间" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '    <div class="layui-form-item layui-form-text">\n' +
            '        <label class="layui-form-label">内容</label>\n' +
            '        <div class="layui-input-block">\n' +
            '       <div id="toolbar" class="toolbar"></div>\n' +
            '      <div style="padding: 5px 0; color: #ccc">中间隔离带</div>\n' +
            '            <div id="content">'+content+'</div>\n' +
            '        </div>\n' +
            '        <label class="layui-form-label">\n' +
            '            <button type="button" class="layui-btn layui-btn-primary browse">预览</button>\n' +
            '        </label>\n' +
            '    </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="updates">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
        index = layer.open({
            title: '添加权限'
            ,type : 1
            ,content: template
            ,success: function(layero, index){
                editor = new E('#toolbar','#content');
                editor.create();
                $('.browse').on('click',function () {
                    content = editor.txt.html();
                    browse = layer.open({
                        type: 1,
                        content: content //这里content是一个普通的String
                    });
                    layer.full(browse);
                });
                //设定控件的层叠顺序
                laydate.render({
                    elem: '#date'
                    ,zIndex: 99999999
                    ,type:'date'
                    ,value:date
                });
                form.render('select');
            }
        });
        layer.full(index);
        //监听提交
        form.on('submit(updates)', function(data){
            layer.msg(JSON.stringify(data.field));
            // return false;
            prarm = data.field;
            prarm['content'] =  editor.txt.html();
            $.ajax({
                url:'/admin/system/updatesSave',
                data:prarm,
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
    $('.update_log_del').on('click',function () {
        var id = $(this).attr("data-id");
        layer.msg('不能删除，请联系管理员');return false;
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

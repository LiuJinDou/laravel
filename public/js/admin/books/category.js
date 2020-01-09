layui.use(['table','form','tree'], function(){
    var table = layui.table,
        tree = layui.tree,
        form = layui.form;
    var _token = $('.token').attr("_token");
    var category_li = '';
    var data_tree = '';
    $.ajax({
        url:'/admin/books/category',
        data:{_token:_token},
        async: false,
        type:"POST",
        dataType: "json",
        success:function (res) {
            data_tree = res.data;
        }
    });
    //渲染
    var inst1 = tree.render({
        elem: '#category'  //绑定元素
        ,data:data_tree
        ,showLine:false
        ,click: function(obj){
            $('.layui-tab').show();
            var data = obj.data;  //获取当前点击的节点数据
            $.ajax({
                url:'/admin/books/bookName',
                data:{_token:_token,id:data.id},
                async: false,
                type:"POST",
                dataType: "json",
                success:function (res) {
                    var book_li = '';
                    $.each(res.data, function (index, item) {
                        book_li +=  '<div class="layui-col-md3">' + item.name + '</div>';
                    });
                    book_li += '';
                    //图书名称
                    $('[name="book"]').html('');
                    $('[name="book"]').append(book_li).show();
                    //分类信息
                    $('.category').html('');
                    $('.category').append(template(data.title,data.id)+'<br><button class="layui-btn del" data-id="'+data.id+'">删除分类</button>').show();
                    $('.child-category').html('');
                    $('.child-category').append('<form class="layui-form">\n' +
                        '  <div class="layui-form-item">\n' +
                        '    <label class="layui-form-label">上级分类：</label>\n' +
                        '    <div class="layui-input-block">\n' +
                        '      <input type="text" name="pname"  value="'+ data.title +'" placeholder="分类名称" autocomplete="off" class="layui-input" disabled>\n' +
                        '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
                        '      <input type="hidden" name="p_id" value="'+ data.id +'" class="layui-input">\n' +
                        '    </div>\n' +
                        '  </div>\n' +
                        '  <div class="layui-form-item">\n' +
                        '    <label class="layui-form-label">分类名称：</label>\n' +
                        '    <div class="layui-input-block">\n' +
                        '      <input type="text" name="name" value="" placeholder="请输入名称" autocomplete="off" class="layui-input">\n' +
                        '    </div>\n' +
                        '  </div>\n' +
                        '  <div class="layui-form-item">\n' +
                        '    <div class="layui-input-block">\n' +
                        '      <button class="layui-btn" lay-submit lay-filter="category">确定</button>\n' +
                        '    </div>\n' +
                        '  </div>\n' +
                        '</form>').show();
                    $('.layui-tab-title li:eq(2)').show();
                    $('.child-category').show();
                    $('.del').on('click',function () {
                        var id = $(this).attr("data-id");
                        $.ajax({
                            url:'/admin/books/categoryDel',
                            data:{id:id,_token:_token},
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
                    });
                }
            });
        }
    });
    var index = '';
    $('.add_category').on('click',function () {
        index = layer.open({
            title: '新增分类'
            ,type : 1
            ,content: template()
        });
    })

    function template(name='',id='') {
        return '<form class="layui-form">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="name" value="'+ name +'" placeholder="请输入名称" autocomplete="off" class="layui-input">\n' +
            '      <input type="hidden" name="_token" value="'+ _token +'" class="layui-input">\n' +
            '      <input type="hidden" name="id" value="'+ id +'" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button class="layui-btn" lay-submit lay-filter="category">确定</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>';
    }
    //监听提交
    form.on('submit(category)', function(data){
        $.ajax({
            url:'/admin/books/categoryEditor',
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
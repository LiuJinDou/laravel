layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        laydate = layui.laydate,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    var category;
    //页面一打开就执行弹层
    layer.ready(function(){
        $.ajax({
            url:'/admin/consume/category',
            type:'POST',
            data:{_token:_token},
            success:function (e) {
                category = e.data;
                $('#category_id').append(option());
                //重新渲染select
                form.render('select');
            }
        });
    });
    function option (id=0){
        var select_option = '';
        select_option = '<option value="">选择分类</option>';
        $.each(category,function (i,v) {
            if (v.id == id) {
                select_option += '<option value="'+v.id+'" selected>'+v.name+'</option>';
            } else {
                select_option += '<option value="'+v.id+'" >'+v.name+'</option>';
            }
        });
        return select_option;
    }
    //设定控件的层叠顺序
    laydate.render({
        elem: '#month'
        ,zIndex: 99999999
        ,type:'month'
    });
    //设定控件的层叠顺序
    laydate.render({
        elem: '#year'
        ,zIndex: 99999999
        ,type:'year'
    });
    table.render({
        elem: '#test'
        ,url:'/admin/consume/list'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,totalRow: true
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left',truefixed: 'left', unresize: true, sort: true, totalRowText: '合计行'}
            ,{field:'month', title:'月份', width:100}
            ,{field:'real_amount', title:'实际金额', width:120, sort: true, totalRow: true, templet:function (d) {
                    return d.real_amount / 100 + '元';
                }}
            ,{field:'amount', title:'支付宝金额', width:120, sort: true, totalRow: true, templet:function (d) {
                    return d.amount / 100 + '元';
                }}
            ,{field:'category_name', title:'分类', width:100}
            ,{field:'type', title:'类型', width:100, templet:function (d) {
                    if (d.type == 1) {
                        return '支出';
                    }  else {
                        return '收入';
                    }
                }
            }
            ,{field:'remark', title:'备注', width:200}
            ,{field:'label', title:'标签', width:120}
            ,{field: 'create_at', title: '创建时间', width:180, templet:function (d) { return showTime(d.create_at,1)}}
            // ,{field:'create_uid', title:'创建人', width:120, edit: 'text'}
            ,{field:'update_at', title: '更新时间', width:150, templet:function (d) { return showTime(d.update_at,3)}}
            // ,{field:'update_uid', title:'更新人', width:120, edit: 'text'}
            ,{fixed: 'right', title:'操作',  width:200,templet:function (d) {
                        return '<a class="layui-btn layui-btn-xs" lay-event="edit" lay-id ='+d.id+'>编辑</a> \n ' +
                                '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="detail" lay-id ='+d.id+'>详情</a>\n'+
                                '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" lay-id ='+d.id+'>删除</a>';
                }
            }
        ]]
        ,id: 'consume'
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
            layer.confirm('删除后不能恢复，真的删除行么,', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/consume/del',
                    type:'POST',
                    data:{id:obj.data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('consume', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        } else if(obj.event === 'edit'){
            consume(obj);
        } else if (obj.event === 'detail') {
            id = obj.data.id;
            console.log(id);
            index = layer.open({
                type: 2,
                title: '消费详情',
                shadeClose: true,
                shade: false,
                content: '/js/admin/template/consume_detail.html',
                cancel: function () {},
                success:function (layero, index) {
                    var body = layer.getChildFrame('body', index);
                    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                    body.find('[name="_token"]').attr('_token',_token)
                    body.find('[name="consume_id"]').attr('data-id',id);
                }
            });
            layer.full(index);
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
            var category_id = $('#category_id');
            var month = $('#month');
            var year = $('#year');
            //执行重载
            table.reload('consume', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    category_id: category_id.val(),
                    month: month.val(),
                    year: year.val()
                }
            }, 'data');
        }
    };

    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    /**
     * batch add consume
     */
    $('.batch_add_consume').on('click',function () {
        batch = layer.open({
            type: 2,
            title: '选择分类',
            shadeClose: true,
            shade: false,
            // maxmin: true, //开启最大化最小化按钮
            // offset: ['60px', '200px'],
            area: ['100%', '100%'],
            content: '/js/admin/template/consume_category.html',
            success: function(layero, index){
                var body = layer.getChildFrame('body', index);
                var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                // console.log(body.html()) //得到iframe页的body内容
                body.find('.token').attr('_token',_token);
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
        layer.full(batch);
    })
    /**
     * add one consume record
     */
    $('.add_consume').on('click',function () {
        consume();
    });

    function consume(obj='') {
        if (obj!='') {
            id = obj.data.id;
            category_id = obj.data.category_id;
            title = obj.data.title;
            month = obj.data.month;
            amount = obj.data.amount;
            image = obj.data.image;
            remark = obj.data.remark;
            label = obj.data.label;
        } else {
            id = 0;category_id=0;title = '';month = '';content = '';image = '';remark = '';label = '';amount=0;
        }
        templet = '<form class="layui-form" action="">\n' +
            '            <input type="hidden" name="id" value="'+id+'" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="_token" value="'+_token+'" autocomplete="off" class="layui-input">\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">日期</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="month" class="layui-input" id="test3" placeholder="yyyy-MM" value="'+month+'">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">消费金额</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="number" name="amount" value="'+amount+'"  placeholder="实际*100" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">分类</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <select name="category_id" lay-verify="required">'+option(category_id)+'</select>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">备注</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="remark" value="'+remark+'"  placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">标签</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="label" value="'+label+'"  placeholder="请输入标签" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <div class="layui-input-block">\n' +
            '            <button class="layui-btn" lay-submit lay-filter="consume">立即提交</button>\n' +
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
                //年月选择器
                laydate.render({
                    elem: '#test3'
                    ,type: 'month'
                    ,value: month //必须遵循format参数设定的格式
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
        form.on('submit(consume)', function(data){
            $.ajax({
                url:'/admin/consume/save',
                type:'POST',
                data:data.field,
                success:function (o) {
                    if (o.code == 0) {
                        layer.msg(o.msg);
                        setTimeout( function (){
                            layer.close(index)
                        },1000);//再执行关闭
                        active['reload'] ? active['reload'].call(this) : '';
                    }  else {
                        layer.msg(o.msg);
                    }
                }
            });
            return false;
        });
    }
});
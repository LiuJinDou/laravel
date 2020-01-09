layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        laydate = layui.laydate,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    //设定控件的层叠顺序
    laydate.render({
        elem: '#month'
        ,zIndex: 99999999
        ,type:'month'
    });
    //设定控件的层叠顺序
    laydate.render({
        elem: '#date'
        ,zIndex: 99999999
        ,type:'date'
    });
    table.render({
        elem: '#detail_list'
        ,url:'/admin/consume/detailList'
        ,method:'post'
        ,where:{_token: _token}
        ,toolbar: '#toolbarDemo'
        ,title: '用户数据表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', width:120}
            ,{field:'date', title:'日期', width:120}
            ,{field:'month', title:'月份', width:200}
            ,{field:'num', title:'数量', width:100}
            ,{field:'amount', title:'金额', width:100, sort: true, templet:function (d) {
                    return d.amount / 100 + '元';
                }}
            ,{field:'type', title:'类型', width:100, templet:function (d) {
                    if (d.type == 1) {
                        return '支出';
                    }  else {
                        return '收入';
                    }
                }
            }
            ,{field:'voucher', title:'电子票/凭证', width:100, sort: true, templet:function (d) {
                    if (d.voucher =='' || d.voucher==null) {
                        return '';
                    }
                    return '<img src="'+d.voucher+'" alt="">\n';
                }}
            ,{field:'remark', title:'备注', width:200}
            ,{field:'label', title:'标签', width:120}
            ,{field: 'create_at', title: '创建时间', width:180, templet:function (d) { return showTime(d.create_at,1)}}
            ,{field:'update_at', title: '更新时间', width:150, templet:function (d) { return showTime(d.update_at,3)}}
            ,{fixed: 'right', title:'操作',  width:200,templet:function (d) {
                    return '<a class="layui-btn layui-btn-xs" lay-event="edit" lay-id ='+d.id+'>编辑</a> \n ' +
                        // '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="detail" lay-id ='+d.id+'>详情</a>\n'+
                        '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" lay-id ='+d.id+'>删除</a>';
                }
            }
        ]]
        ,id: 'detail_list'
        // ,height: 380
        ,page: true
    });

    //头工具栏事件
    table.on('toolbar(detail_list)', function(obj){
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
    table.on('tool(detail_list)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
            layer.confirm('删除后不能恢复，真的删除行么,', function(index){
                obj.del();
                $.ajax({
                    url:'/admin/consume/detailDel',
                    type:'POST',
                    data:{id:data.id,_token: _token},
                    success:function (e) {
                        layer.msg(e.msg);
                    }
                })
                layer.close(index);
                //执行重载
                table.reload('detail_list', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                }, 'data');
            });
        } else if(obj.event === 'edit'){
            detail(obj);
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
            var name = $('#name');
            var month = $('#month');
            var date = $('#date');
            //执行重载
            table.reload('detail_list', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    name: name.val(),
                    month: month.val(),
                    date: date.val()
                }
            }, 'data');
        }
    };

    /**
     * search detial
     */
    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    /**
     * add detail
     */
    $('.add_detail').on('click',function () {
        detail();
    })

    function detail(obj=0) {
        if (obj==0) {
            id = 0;voucher=' ';name = '';content = '';image = '';remark = '';label = '';amount='';consume_id='';consume_option='<option value="" >请选择日期</option>';
        } else {
            id = obj.data.id == null ? 0 : obj.data.id;
            name = obj.data.name== null ? '' : obj.data.name;
            date = obj.data.date== null ? '' : obj.data.date;
            consume_id = obj.data.consume_id == null ? 0 : obj.data.consume_id;
            voucher = obj.data.voucher == null ? '' : obj.data.voucher;
            amount = obj.data.amount == null ? 0 : parseInt(obj.data.amount / 100);
            remark = obj.data.remark == null ? '' : obj.data.remark;
            label = obj.data.label == null ? '' : obj.data.label;
            consume_option = '<option value="'+obj.data.consume_id+'" >'+obj.data.month+'</option>';
        }
        templet = '<form class="layui-form" action="">\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">名称</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="name" required value="'+name+'"  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="id" value="'+id+'" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="_token" value="'+_token+'" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">日期</label>\n' +
            '        <div class="layui-input-block">\n' +
            '           <input type="text" name="date" class="layui-input" id="test1" lay-verify="required" placeholder="yyyy-MM-dd">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">月份</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <select name="consume_id" id="consume_id" required lay-verify="required">'+consume_option+'</select>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">金额</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="number" name="amount" value="'+amount+'" lay-verify="required"  placeholder="" autocomplete="off" class="layui-input" onkeyup="value=value.replace(/^\\D*(\\d*(?:\\.\\d{0,2})?).*$/g, \'$1\')" >\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">电子票/凭证</label>\n' +
            '        <div class="layui-input-inline">\n' +
            '           <div class="layui-upload">\n' +
            '            <button type="button" class="layui-btn" id="voucher_image"><i class="layui-icon">&#xe67c;</i>上传图片</button> <img src="'+voucher+'" alt="" class="voucher" width="50px;" height="50px;">\n' +
            '            <input type="hidden" name="voucher" value="'+voucher+'" class="layui-input">              </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">备注</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="remark" value="'+remark+'"  placeholder="请输入备注" autocomplete="off" class="layui-input">\n' +
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
            content: templet,
            success: function(layero, index){
                //常规用法
                laydate.render({
                    elem: '#test1'
                    ,type: 'date'
                    ,value:date
                    ,done: function(value, date, endDate){
                        console.log(value); //得到日期生成的值，如：2017-08-18
                        console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                        console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                        month = value.substr(0,7);
                        init_month(month);
                    }
                });
                init_month();
                var uploadInst = upload.render({
                    elem: '#voucher_image' //绑定元素
                    ,url: '/admin/files' //上传接口
                    ,done: function(res){
                        //上传完毕回调
                        $('.voucher').attr('src',res.data);
                        $("[name='voucher']").attr('value',res.data);
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
                url:'/admin/consume/detailSave',
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

    function init_month(month=0) {
        $.ajax({
            url:'/admin/consume/list',
            type:'POST',
            data:{_token:_token,month:month},
            success:function (e) {
                category = e.data;
                var consume_option = ''
                $.each(category,function (i,v) {
                    if (v.id == consume_id) {
                        consume_option += '<option value="'+v.id+'" selected>'+v.month+'('+v.category_name+')'+'</option>';
                    }  else  {
                        consume_option += '<option value="'+v.id+'" >'+v.month+'('+v.category_name+')'+'</option>';
                    }
                });
                $('#consume_id').empty();
                $('#consume_id').append(consume_option);
                //重新渲染select
                form.render('select');
            }
        });
    }


    /**
     * export detail
     */
    $('.export_detail').on('click',function () {
        $.ajax({
            url:'/admin/consume/detailExport',
            type:'POST',
            data:{_token: _token},
            success:function (e) {
                layer.msg(e.msg);
            }
        })
    })
});
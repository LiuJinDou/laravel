layui.use(['tree', 'util','table','jquery','laydate','form'], function(){
    var tree = layui.tree
        ,layer = layui.layer
        ,laydate = layui.laydate
        ,table = layui.table
        ,form = layui.form
        ,$ = layui.jquery
        ,util = layui.util
    var _token = $('.token').attr("_token");
    var data = '';
    $.ajax({
        url:'/admin/consume/category',
        type:'POST',
        data:{_token:_token},
        success:function (e) {
            data = [];
            $.each(e.data,function (i,v) {
                data.push( {
                    title: v.name
                    ,id: v.id
                    ,field: 'name'
                    ,spread: false//节点是否初始展开，默认 false
                    // ,disabled: true
                });
            });
            //基本演示
            tree.render({
                elem: '#category'
                ,data: data
                ,showCheckbox: false  //是否显示复选框
                ,id: 'demoId1'
                ,isJump: true //是否允许点击节点时弹出新窗口跳转
                ,click: function(obj){
                    var data = obj.data;  //获取当前点击的节点数据
                    // layer.msg('状态：'+ obj.state + '<br>节点数据：' + JSON.stringify(data));
                    add_detail(obj);
                }
            });
        }
    });
    //按钮事件
    util.event('lay-demo', {
        addCategory: function () {
            add_detail();
        }
    });
    function add_detail(obj='') {
        console.log(obj);
        if (obj!='') {
            id = obj.data.id;
            name = obj.data.title;
        } else {
            id = 0;name = '';
        }
        templet = '<form class="layui-form" action="">\n' +
            '    <div class="layui-form-item">\n' +
            '        <label class="layui-form-label">名称</label>\n' +
            '        <div class="layui-input-block">\n' +
            '            <input type="text" name="name" required value="'+name+'"  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="id" value="'+id+'" autocomplete="off" class="layui-input">\n' +
            '            <input type="hidden" name="_token" value="'+_token+'" autocomplete="off" class="layui-input">\n' +
            '        </div>\n' +
            '    <div class="layui-form-item">\n' +
            '        <div class="layui-input-block">\n' +
            '            <button class="layui-btn" lay-submit lay-filter="category">立即提交</button>\n' +
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
            }
        });
        layer.full(index);
        //监听提交
        form.on('submit(category)', function(data){
            $.ajax({
                url:'/admin/consume/categorySave',
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
    //年月选择器
    laydate.render({
        elem: '#month'
        ,type: 'month'
    });
    /**
     * 分类数据
     */
    table.render({
        elem: '#select_category'
        ,url:'/admin/consume/category'
        ,method:'post'
        ,where:{_token: _token}
        ,title: '消费分类'
        ,width:'40%'
        ,cols: [[
            {type: 'checkbox', fixed: 'left',LAY_CHECKED: true}
            ,{field:'id', title:'ID', width:80, fixed: 'left',truefixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', width:100}
        ]]
        ,id: 'select_category'
    });
    $('.batch_add').click(function () {
        var checkStatus = table.checkStatus('select_category'); //idTest 即为基础参数 id 对应的值
        if (checkStatus.data.length == 0) {
            layer.msg('请选择分类');return false;
        }
        month = $('#month').val();
        if (month == ''){
            layer.msg('请选择月份');return false;
        };
        $.ajax({
            url:'/admin/consume/batchAdd',
            type:'POST',
            data:{_token:_token,month:month,category:checkStatus.data},
            success:function (o) {
                if (o.code == 0) {
                    layer.msg(o.msg);
                    //当你在iframe页面关闭自身时
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    setTimeout( function (){
                        layer.close(index)
                    },1000);//再执行关闭
                }  else {
                    layer.msg('不能添加，请联系管理员');
                }
            }
        });
    });
});
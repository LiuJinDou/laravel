layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        laydate = layui.laydate,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('[name="_token"]').attr("_token");
    var id = $('[name="consume_id"]').attr("data-id");
    table.render({
        elem: '#detail'
        ,url:'/admin/consume/detailList'
        ,method:'post'
        ,where:{_token: _token,consume_id:id}
        ,title: '消费详情列表'
        ,cols: [[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
            ,{field:'name', title:'名称', width:120}
            ,{field:'amount', title:'金额', width:100, templet:function (d) {
                    return d.amount / 100 + '元';
                }}
            ,{field:'month', title:'时间', width:100}
            ,{field:'voucher', title:'电子票/凭证', width:100, templet:function (d) {
                    if (d.voucher == null) {
                        return '';
                    }  else {
                        return '<img src="'+ d.voucher +'" alt="" class="head" width="50px;" height="50px;">';
                    }
                }
            }
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
            ,{field:'update_at', title: '更新时间', width:150, templet:function (d) { return showTime(d.update_at,3)}}
        ]]
        ,id: 'detail'
        // ,height: 380
        ,page: true
    });
});
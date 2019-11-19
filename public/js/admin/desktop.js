layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,//Tab的切换功能，切换事件监听等，需要依赖element模块
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    $.ajax({
        url:'/admin/system/statistics',
        data:{_token:_token},
        type:'POST',
        success:function (res) {
            if (res.code == 0) {
                statistics_str = '';
                $.each(res.data,function (i,v) {
                    statistics_str += '<li class="layui-col-xs2">\n' +
                    '                                        <a href="javascript:;" class="x-admin-backlog-body">\n' +
                    '                                            <h3>'+v.title+'</h3>\n' +
                    '                                            <p>\n' +
                    '                                                <cite>'+v.total+'</cite></p>\n' +
                    '                                        </a>\n' +
                    '                                    </li>';
                })
                console.log(statistics_str);
                $('.layui-card-body ul').append(statistics_str);
            }
        }
    })
});
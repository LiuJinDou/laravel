layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    //页面一打开就执行弹层
    layer.ready(function(){
        //处理是否默认勾选全选
        $('.layui-elem-field').each(function(i,v){
            if($(v).find('.role_privilege_check_area input:checked').length === $(v).find('.role_privilege_check_area input').length){
                $(v).find('[lay-filter="all_select"]').prop('checked',true);
            }
        });
    });
    form.render();
    /**
     * listen all_select
     */
    form.on('checkbox(all_select)', function(data){
        console.log(data.elem); //得到checkbox原始DOM对象
        // console.log(data.elem.checked); //是否被选中，true或者false
        // console.log(data.value); //复选框value值，也可以通过data.elem.value得到
        // console.log(data.othis); //得到美化后的DOM对象
        if(data.elem.checked){
            console.log($(data.elem).parents('fieldset').find('input[type="checkbox"]')); //得到checkbox原始DOM对象
            $(data.elem).parents('fieldset').find('input[type="checkbox"]').prop('checked',true);
            form.render();
        }else{
            $(data.elem).parents('fieldset').find('input[type="checkbox"]').prop('checked',false);
            form.render();
        }
    });
    /**
     * submit privilege
     */
    form.on('submit(privilege)',function () {
        privileges = $('.privilege_setting_item').find('input:checked').serialize();
        role_id = $('[name=role_id]').val();
        iframe = $('[name=iframe]').val();
        $.ajax({
            url:'/admin/rolePrivilege',
            type: "POST",
            dataType: "json",
            data:'_token='+_token+'&id='+role_id+'&'+privileges,
            success:function (o) {
                if (o.data) {
                    layer.msg(o.msg);
                    //当你在iframe页面关闭自身时
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    setTimeout( function (){
                        parent.layer.close(index)
                    },1000);//再执行关闭

                    return false;
                }  else {
                    layer.msg(o.msg);return false;
                }
            }
        });
        return false;
    })
});
layui.define(["layer","jquery","form"],function (exports) {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    var res;
    var obj = {
        ajax : function (url,type='POST',data) {
            $.ajax({
                url:url,
                type:type,
                data:data,
                success:function (e) {
                    res = e;
                }
            })
            return res;
        }
    }
    exports("ajax",obj);
});
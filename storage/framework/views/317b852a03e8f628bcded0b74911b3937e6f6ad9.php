<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<button type="button" class="layui-btn" id="test1">
    <i class="layui-icon">&#xe67c;</i>Upload Image
</button>
<button type="button" class="layui-btn" id="video">
    <i class="layui-icon">&#xe67c;</i>Upload video
</button>

<hr class="layui-bg-blue">
<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">Upload progress</label>
    <div class="layui-input-block">
        <div class="layui-progress layui-progress-big" lay-showPercent="true" lay-filter="progress_video">
            <div class="layui-progress-bar layui-bg-blue" lay-percent="0%"></div>
        </div>
    </div>
</div>
<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">File address</label>
    <div class="layui-input-block">
        <textarea name="address" placeholder="File address after upload" class="layui-textarea"></textarea>
    </div>
</div>
<script>
    layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
        var form = layui.form,
            table = layui.table,
            layer = layui.layer,
            upload = layui.upload,
            element = layui.element,
            $ = layui.jquery;

        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '/admin/files' //上传接口
            ,accept: 'images' //允许上传的文件类型
            ,done: function(res){
                $('[name="address"]').html(res.data);
            }
            ,error: function(){
                //请求异常回调
            }
        });
        var uploadInst = upload.render({
            elem: '#video' //绑定元素
            ,url: '/admin/files' //上传接口
            ,data:{type:1}
            ,accept: 'file' //允许上传的文件类型
            ,done: function(res){
                address = '<iframe src="'+res.data+'" frameborder="0"></iframe>';
                $('[name="address"]').html(address);
            }
            ,error: function(){
                //请求异常回调
            }
            ,progress: function(n){
                var percent = n + '%'; //获取进度百分比
                element.progress('progress_video', percent); //可配合 layui 进度条元素使用
            }
        });
    });
</script>
@include('admin/header')
<div class="demoTable layui-form">
    Please select ategory：
    <div class="layui-input-inline">
        <select id="category_id" lay-filter="category" lay-verify="required" lay-search="">
        </select>
    </div>
    Title：<div class="layui-inline">
        <input class="layui-input" name="title" id="title" autocomplete="off" placeholder="Please input title">
    </div>
    <button class="layui-btn layui-btn-warm" data-type="reload">Search</button>
    <button class="layui-btn add_book" data-type="add_book">addBook</button>
</div>
<table class="layui-hide" id="test" lay-filter="test"></table>

<!-- 加载编辑器的容器 -->
{{--<script id="container" name="content" type="text/plain">--}}
{{--这里写你的初始化内容--}}
{{--</script>--}}
<!-- 配置文件 -->
<script type="text/javascript" src="/editor/ueditor-1.4.3.3/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/editor/ueditor-1.4.3.3/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    // var ue = UE.getEditor('container');
</script>
<script type="text/javascript" src="/js/wangEditor/release/wangEditor.min.js"></script>
<script src="/js/admin/books/book.js"></script>

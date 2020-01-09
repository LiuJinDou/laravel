@include('admin/header')
<style>
.layui-row > .layui-col-xs3{
    width: 200px;
    border: solid 1px #e6e6e6;
    background-color: #f9f9f9;
}
.layui-row .layui-col-xs7 .layui-col-md3{
    border: solid 1px #e6e6e6;
    background-color: #f9f9f9;
    height: 40px;
    word-wrap: break-word;
    white-space:normal;
    word-break:break-all;
    overflow:hidden;
}
.layui-tab{
    display: none;
}
</style>
<div class="demoTable layui-form">
    <button class="layui-btn layui-btn-disabled" data-type="add_category">addCategoty</button>
</div>
<hr class="layui-bg-red">

<div class="layui-row">
    <div class="layui-col-xs3">
        <div class="grid-demo grid-demo-bg1" id="category"></div>
    </div>
    <div class="layui-col-xs7">

        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">文章列表</li>
                <li>编辑分类</li>
                <li>新增子分类</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-row layui-col-space1" name="article"></div>
                </div>
                <div class="layui-tab-item "><div class="category"></div></div>
                <div class="layui-tab-item "><div class="child-category"></div></div>
            </div>
        </div>
    </div>
</div>
<script src="/js/admin/article/category.js"></script>
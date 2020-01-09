@include('admin/header')

<style>
    .update-log-btn-group{
        display: none;
        float: right;
    }
    .layui-timeline>li:hover .update-log-btn-group{
        display: block;
    }

</style>

<div class="layui-btn-group">
    <button class="layui-btn update_log_editor" >add version</button>
</div>
<hr class="layui-bg-gray">
<ul class="layui-timeline">
    @foreach($data as $value)

        <li class="layui-timeline-item">
            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
            <div class="layui-timeline-content layui-text">
                <h3 class="layui-timeline-title">
                    <span class="version">{{$value['version']}}</span>
                    <span class="layui-badge-rim date">{{$value['date']}}</span>
                    <div class="layui-btn-group update-log-btn-group">
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm update_log_editor" data-id="{{$value['id']}}">
                            <i class="layui-icon">&#xe642;</i>
                        </button>
                        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm update_log_del" data-id="{{$value['id']}}">
                            <i class="layui-icon">&#xe640;</i>
                        </button>
                    </div>
                </h3>
                <div class="content">
                    {!! $value['content'] !!}
                </div>
            </div>
        </li>

    @endforeach
</ul>
<script type="text/javascript" src="/js/wangEditor/release/wangEditor.min.js"></script>
<script src="/js/admin/system/updates.js"></script>
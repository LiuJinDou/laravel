@include('admin/header')
<style>
    .rightmenu li:hover{
        color: yellow;
        border-bottom: solid 2px blue;
    }
</style>

<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">误落尘网中，一去几十年</div>
        <div class="control-side"><i title="展开左侧栏" class="layui-icon">&#xe668;</i></div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left" style="height: 50px;">
            {{--<li class="layui-nav-item"><a href="javascript:;" class="mysql">数据库</a></li>--}}
            <li class="layui-nav-item" style="line-height: 50px;"><a href="javascript:;" id="timer"></a></li>
            {{--<li class="layui-nav-item">--}}
                {{--<a href="javascript:;">其它系统</a>--}}
                {{--<dl class="layui-nav-child">--}}
                    {{--<dd><a href="">邮件管理</a></dd>--}}
                    {{--<dd><a href="">消息管理</a></dd>--}}
                    {{--<dd><a href="">授权管理</a></dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item" style="line-height: 50px;">
                <a href="javascript:;">
                    <img src="{{ auth('admin')->user()->headpic }}" class="layui-nav-img">
                    {{ auth('admin')->user()->name }}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" class="base-info" data-id="{{ auth('admin')->user()->id }}">Base info</a></dd>
                    <dd><a href="javascript:;" class="safe-set" data-id="{{ auth('admin')->user()->id }}">Safe set</a></dd>
                    <dd><a href="/admin/logout">Quit</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="javascript:;" class="clear_cache">Clear cache</a></li>
            <li class="layui-nav-item"><a href="javascript:;" class="refresh"><i class="layui-icon layui-icon-refresh" style="font-size: 30px;width: 50px;"></i></a></li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black" style="top: 50px;">
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                @foreach ($data as $item)
                    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                    <ul class="layui-nav layui-nav-tree">
                    <li class="layui-nav-item">
                        <a class="" href="javascript:void(0);"><i class='layui-icon' style="padding-right: 20px;">&#xe756;</i>{{$item['title']}}</a>
                        <dl class="layui-nav-child">
                            @foreach ($item['list'] as $value)
                                <dd><a data-url="{{$value['privilege_url']}}" data-id="{{$value['id']}}" data-title="{{$value['privilege_name']}}" href="javascript:void(0);" class="site-demo-active" data-type="tabAdd"><i class="layui-icon" style="padding:0 20px 0 20px;">&#xe602;</i>{{$value['privilege_name']}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                </ul>
                 @endforeach
            </div>
        </div>
    </div>
    <div class="layui-body" style="top: 50px">
        <div class="layui-layout layui-layout-admin">
            <!-- 选项卡和内容区 -->
            <div class="layui-tab" lay-filter="home-tabs" lay-allowclose="true" style="margin: 0 0 0 0px;">
                <ul class="layui-tab-title"></ul>
                <ul class="rightmenu" style="display: none;position: absolute;">
                    <li data-type="refresh" >刷新</li>
                    <li data-type="closeOthers">关闭其他</li>
                    <li data-type="closeRight" >关闭右侧所有</li>
                    <li data-type="closeAll">关闭所有</li>
                </ul>
                <div class="layui-tab-content">
                    <a href="javascript:;" class="refreshtab" ><i class="layui-icon layui-icon-refresh" style="font-size: 30px;width: 50px;position: absolute;right: 30px;top:50px;"></i></a>
                </div>
            </div>
        </div>
        </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © <a href="/">mengshadow.top</a> - Shadow back-stage management
    </div>
</div>
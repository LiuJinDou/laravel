@include('front/head')
<div class="line46"></div>
<article>
    <div class="leftbox">
        <div class="newblogs">
            <h2 class="hometitle">A man is not old until regrets take the place of dreams.</h2>
            <ul>
                @foreach($data['search'] as $value)
                    <li>
                        <h3 class="blogtitle"><a href="/front/info?id={{$value['id']}}" target="_blank" >{{$value['title']}}</a></h3>
                        <div class="bloginfo"><span class="blogpic"><a href="/front/info?id={{$value['id']}}" title=""><img src="{{$value['image']}}"  /></a></span>
                            <p>{!! $value['introduction'] !!}</p>
                        </div>
                        <div class="autor"><span class="lm f_l"><a href="/">{{$value['author']}}</a></span><span class="dtime f_l">{{$value['create_at']}}</span><span class="viewnum f_l">浏览（<a href="/">{{$value['browse']}}</a>）</span><span class="pingl f_l">评论（<a href="/">30</a>）</span><span class="f_r"><a href="/front.info?id={{$value['id']}}" class="more">阅读原文>></a></span></div>
                    </li>
                @endforeach
            </ul>
            {{--<div class="pagelist"><a title="Total record">&nbsp;<b>142</b> </a>&nbsp;&nbsp;<a href="/jstt/index.html">首页</a>&nbsp;<a href="/jstt/index.html">上一页</a>&nbsp;<a href="/jstt/index.html">1</a>&nbsp;<b>2</b>&nbsp;<a href="/jstt/index_3.html">3</a>&nbsp;<a href="/jstt/index_4.html">4</a>&nbsp;<a href="/jstt/index_5.html">5</a>&nbsp;<a href="/jstt/index_6.html">6</a>&nbsp;<a href="/jstt/index_3.html">下一页</a>&nbsp;<a href="/jstt/index_6.html">尾页</a></div>--}}
        </div>
    </div>
    <div class="rightbox">
        <div class="blank"></div>
        <div class="search">
            <form action="/front/search" method="get" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input  class="input_submit" value="搜索" type="submit">
            </form>
        </div>
        <div class="weixin">
            <h2 class="ab_title">微信关注</h2>
            <ul>
                <img src="images/wx.jpg">
            </ul>
        </div>
    </div>
</article>
@include('front/footer')

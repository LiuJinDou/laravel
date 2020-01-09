layui.use(['form', 'laypage', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        laypage = layui.laypage,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    get_work();
    init_data();

    function get_work(page=1) {
        $.ajax({
            url:'/front/life',
            data:{_token:_token,page:page},
            async: false,
            type:"POST",
            dataType: "json",
            success:function (e) {
                recommends = e.data.recommends;
                lifes = e.data.lifes;
                ranking = e.data.ranking;
                total = e.data.count;
            }
        });
    }
    function init_data() {
        var new_article = '';
        var recommend_article = '';
        var ranking_article = '';
        $.each(lifes,function (i,v) {
            new_article += '<li>' +
                '                        <h3 class="blogtitle"><a href="/" target="_blank" >'+v.title+'</a></h3>' +
                '                        <div class="bloginfo"><span class="blogpic"><a href="/" title=""><img src="'+v.image+'"  /></a></span>' +
                '                            <p>'+v.introduction+'</p>' +
                '                        </div>' +
                '                        <div class="autor"><span class="lm f_l"><a href="/">Person blog</a></span><span class="dtime f_l">2014-02-19</span><span class="viewnum f_l">浏览（<a href="/">'+v.browse+'</a>）</span><span class="pingl f_l">喜欢（<a href="/">'+v.love+'</a>）</span><span class="f_r"><a href="/front/info?id='+v.id+'" class="more">阅读原文</a></span></div>' +
                '                    </li>'
        });
        $.each(recommends,function (i,v) {
            recommend_article += ' <li><b><a href="/front/info?id='+v.id+'" target="_blank">'+v.title+'</a></b>\n' +
                // '                    <p>'+v.introduction+'</p>\n' +
                '                </li>';

        });
        $.each(ranking,function (i,v) {
            ranking_article += ' <li><b><a href="/front/info?id='+v.id+'" target="_blank">'+v.title+'</a></b>'+
                '<p><i><img src="'+v.image+'"></i>'+v.introduction+'</p></li>';
        });
        $('.recommend ul').append(recommend_article);
        $('.newblogs ul').append(new_article);
        $('.ranking ul').append(ranking_article);
    }
    laypage.render({
        elem: 'test1'
        ,count: total //数据总数，从服务端得到
        ,jump: function(obj, first){
            //obj包含了当前分页的所有参数，比如：
            console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
            console.log(obj.limit); //得到每页显示的条数

            //首次不执行
            if(!first){
                //do something
                get_work(obj.curr);
                life_list = '';
                $.each(lifes,function (i,v) {
                    life_list += '<li>' +
                        '                        <h3 class="blogtitle"><a href="/" target="_blank" >'+v.title+'</a></h3>' +
                        '                        <div class="bloginfo"><span class="blogpic"><a href="/" title=""><img src="'+v.image+'"  /></a></span>' +
                        '                            <p>'+v.introduction+'</p>' +
                        '                        </div>' +
                        '                        <div class="autor"><span class="lm f_l"><a href="/">Person blog</a></span><span class="dtime f_l">2014-02-19</span><span class="viewnum f_l">浏览（<a href="/">'+v.browse+'</a>）</span><span class="pingl f_l">喜欢（<a href="/">'+v.love+'</a>）</span><span class="f_r"><a href="/front/info?id='+v.id+'" class="more">阅读原文</a></span></div>' +
                        '                    </li>'
                });
                $('.newblogs ul').html('');
                $('.newblogs ul').append(life_list);
            }
        }
    });
});
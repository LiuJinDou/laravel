layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        upload = layui.upload,
        element = layui.element,
        $ = layui.jquery;
    var _token = $('.token').attr("_token");
    init_data();
    function init_data() {
        $.ajax({
            url:'/front/index',
            data:{_token:_token},
            async: true,
            type:"POST",
            dataType: "json",
            success:function (res) {
                special = res.data.special;
                recommends = res.data.recommends;
                news = res.data.news;
                browses = res.data.browses;
                var special_article = '';
                var new_article = '';
                var recommend_article = '';
                var browse_article = '';
                $.each(special,function (i,v) {
                    special_article += '<li><i><a href="/front/info?id='+v.id+'"><img src="'+v.image+'"style="height: 100%;" /></a></i><span>'+v.title+'</span></li>'
                });
                $.each(news,function (i,v) {
                    new_article += '<li>' +
                        '                        <h3 class="blogtitle"><a href="/front/info?id='+v.id+'" target="_blank" >'+v.title+'</a></h3>' +
                        '                        <div class="bloginfo"><span class="blogpic"><a href=""/front/info?id='+v.id+'"" title=""><img  src="'+v.image+'"  /></a></span>' +
                        '                            <p>'+v.introduction+'</p>' +
                        '                        </div>' +
                        '                        <div class="autor"><span class="lm f_l"><a href="/">'+v.author+'</a></span><span class="dtime f_l">'+showTime(v.create_at)+'</span><span class="viewnum f_l">浏览（<a href="/">'+v.browse+'</a>）</span><span class="pingl f_l">喜欢（<a href="/">'+v.love+'</a>）</span><span class="f_r"><a href="/front/info?id='+v.id+'" class="more">阅读原文</a></span></div>' +
                        '                    </li>'
                });
                $.each(recommends,function (i,v) {
                    recommend_article += '<li>' +
                        '                    <div class="tpic"><img src="'+v.image+'" style="height: 100%;"/></div>' +
                        '                    <b>'+v.title+'</b><span>'+v.introduction+'</span><a href="/front/info?id='+v.id+'" class="readmore">阅读原文</a></li>';
                });
                $.each(browses,function (i,v) {
                    browse_article += ' <li><b><a href="/front/info?id='+v.id+'" target="_blank">'+v.title+'</a></b>'+
                        '<p><i><img src="'+v.image+'" style="height: 100%;" /></i>'+v.introduction+'</p></li>';
                });

                $('.pics ul').append(special_article);
                $('.tuijian ul').append(recommend_article);
                $('.newblogs ul').append(new_article);
                $('.paihang ul').append(browse_article);
            }
        });
    }
});

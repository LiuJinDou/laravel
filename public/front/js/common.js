//时间转换函数
function showTime(tempDate,split_type=1)
{
    var d = new Date(tempDate * 1000);
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();
    month = month<10 ? '0'+month:month;

    day = day<10 ? '0'+day:day;

    hours = hours<10 ? '0'+hours:hours;

    minutes = minutes<10 ? '0'+minutes:minutes;

    seconds = seconds<10 ? '0'+seconds:seconds;


    switch (split_type) {
        case 1:
            var time = year + '-' + month + '-' + day + ' ' + hours+':' + minutes + ':'+ seconds;
            break;
        case 2:
            var time = year + '年' + month + '月' + day + '日 '+hours + '时' + minutes + '分' + seconds + '秒';
            break;
        case 3:
            var time = year + '年' + month + '月' + day + '日';
            break;
        case 4:
            var time =hours+'时' + minutes+'分' + seconds + '秒';
            break;
        case 5:
            var time =hours + ':' + minutes + ':' + seconds;
            break;
        default :
            var time = year + '-' + month + '-' +day+" "+hours+":"+minutes+":"+seconds;
            break;
    }
    return time;

}
$(document).ready(function (){
    weixin = '<h2 class="ab_title">微信关注</h2>\n' +
        '            <ul>\n' +
        '                <img src="/front/images/wx.jpg">\n' +
        '            </ul>';
    $('.weixin').html(weixin);

    aboutme = '<h2 class="ab_title">About me</h2>\n' +
        '            <div class="avatar"><img src="/front/images/b04.jpg" /></div>\n' +
        '            <div class="ab_con">\n' +
        '                <p>网名：Shadow | 即步非烟</p>\n' +
        '                <p>职业：后端开发工程师 </p>\n' +
        '                <p>籍贯：河南省—邓州市</p>\n' +
        '                <p>邮箱：1975876584@qq.com</p>\n' +
        '            </div>';
    $('.aboutme').html(aboutme);

    footer = '<p>Design by <a href="/">Shadow personal blog</a> <a href="/">备案号：京ICP备18056417号-1</a></p>';
    $('footer').html(footer);
})
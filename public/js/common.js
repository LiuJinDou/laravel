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
    function FrameWH() {
        var h = $(window).height() - 41 - 10 - 60 - 10 - 44 - 10;
        $("iframe").css("height", h + "px");
    }

    $(window).resize(function() {
        width = $(window).width();
        if (width < '700px') {
            $('#timer').css('style','diplay:none');
        }
        FrameWH();
    })
})

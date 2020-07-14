<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="demoTable layui-form">
    Please select month：
    <div class="layui-input-inline">
        <input type="text" class="layui-input" id="month" placeholder="yyyy-MM">
    </div>
    Please select week：
    <div class="layui-input-inline">
        <input type="checkbox" name="consume[day]" title="Day" checked>
        <input type="checkbox" name="consume[month]" title="Month" checked>
        <input type="checkbox" name="consume[year]" title="Year" checked>
    </div>
</div>
<hr class="layui-bg-green">
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="consume_day" style="width: 100%;height:350px;"></div>
<hr class="layui-bg-green">
<div id="consume_month" style="width: 100%;height:350px;"></div>
<hr class="layui-bg-green">
<div id="consume_year" style="width: 100%;height:350px;"></div>
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate','element','jquery','layer','upload','table'], function() {
        var form = layui.form,
            table = layui.table,
            layer = layui.layer,
            upload = layui.upload,
            laydate = layui.laydate,
            element = layui.element,
            $ = layui.jquery;
        var _token = $('.token').attr("_token");
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        if (month<=9) {month = '0'+month;}
        var init_month = year+seperator1+month;
        //年月选择器
        laydate.render({
            elem: '#month'
            ,type: 'month'
            ,value: init_month
            ,isInitValue: true
            ,change: function(value, date, endDate){
                console.log(value); //得到日期生成的值，如：2017-08-18
                console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                init_data(value);
            }
        });
        // 基于准备好的dom，初始化echarts实例
        var myChartDay = echarts.init(document.getElementById('consume_day'));
        var myChartMonth = echarts.init(document.getElementById('consume_month'));
        var myChartYear = echarts.init(document.getElementById('consume_year'));
        //页面一打开就获取数据
        layer.ready(function(){
            init_data();
        });

        /**
         * init data
         * @param  month
         */
        function init_data(month=init_month) {
            var consume_month_data = [];
            var year_xAxis_data = [];
            var xAxis_data = [];
            var year_yAxis_data = [];
            var yAxis_data = [];
            $.ajax({
                url:'/admin/consume/echars',
                type:'POST',
                data:{_token:_token,month:month},
                success:function (e) {
                    console.log(e);
                    $.each(e.data.consume_day,function (i,v) {
                        xAxis_data.push(v.date);
                        yAxis_data.push(v.amount);
                    });
                    $.each(e.data.consume_month,function (i,v) {
                        consume_month_data.push( {
                            name: v.category_name
                            ,value: v.real_amount
                        });
                    });
                    $.each(e.data.consume_year,function (i,v) {
                        year_xAxis_data.push(v.month);
                        year_yAxis_data.push(v.real_amount);
                    });
                    console.log(consume_month_data);
                    console.log(xAxis_data);
                    console.log(yAxis_data);
                    // 指定图表的配置项和数据
                    var option = {
                        title: {
                            text: 'Monthly consumption pie chart',
                            align:'center'
                        },
                        label: {
                            normal: {
                                show: true,
                                formatter: '{a}'
                            }
                        },tooltip : {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        series: [
                            {
                                name: '消费详情',
                                type: 'pie',
                                // radius: ['50%', '70%'],
                                itemStyle: {
                                    normal: {label:{
                                            show:true,
                                            formatter:'{b} : {c} ({d}%)'
                                        },
                                        labelLine:{show:true}},
                                    emphasis: {
                                        label: {
                                            show: true,
                                            formatter: "{b}\n{c} ({d}%)",
                                            position: 'center',
                                            textStyle: {
                                                fontSize: '30',
                                                fontWeight: 'bold'
                                            }
                                        }
                                    }
                                },
                                data: consume_month_data
                            }
                        ]
                    };

                    // 使用刚指定的配置项和数据显示图表。
                    myChartMonth.setOption(option);
                    //显示日消费折线图
                    var optionDay = {
                        title: {
                            text: 'Daily consumption line chart',
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        xAxis: {
                            name:'/day',
                            data: xAxis_data,
                            min :'dataMin',
                            max:'dataMax',
                        },
                        yAxis: {
                            name:'/￥',
                            splitLine: {
                                show: false
                            }
                        },
                        toolbox: {
                            left: 'center',
                            feature: {
                                dataZoom: {
                                    yAxisIndex: 'none'
                                },
                                restore: {},
                                saveAsImage: {}
                            }
                        },
                        dataZoom: [{
                            startValue: '2014-06-01'
                        }, {
                            type: 'inside'
                        }],
                        visualMap: {
                            top: 10,
                            right: 10,
                            pieces: [{
                                gt: 0,
                                lte: 100,
                                color: '#096'
                            }, {
                                gt: 100,
                                lte: 200,
                                color: '#ffde33'
                            }, {
                                gt: 200,
                                lte: 300,
                                color: '#ff9933'
                            }, {
                                gt: 300,
                                lte: 400,
                                color: '#cc0033'
                            }, {
                                gt: 400,
                                lte: 500,
                                color: '#660099'
                            }, {
                                gt: 500,
                                color: '#7e0023'
                            }],
                            outOfRange: {
                                color: '#999'
                            }
                        },
                        series: {
                            name: '',
                            type: 'line',
                            data: yAxis_data,
                            markLine: {
                                silent: true,
                                data: [{
                                    yAxis: 50
                                }, {
                                    yAxis: 100
                                }, {
                                    yAxis: 150
                                }, {
                                    yAxis: 200
                                }, {
                                    yAxis: 300
                                },{
                                    yAxis: 500
                                }, {
                                    yAxis: 800
                                }, {
                                    yAxis: 1000
                                }]
                            }
                        }
                    };
                    myChartDay.setOption(optionDay);
                    //显示月消费折线图
                    var optionYear = {
                        title: {
                            text: 'Month consumption line chart',
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        xAxis: {
                            name:'/day',
                            data: year_xAxis_data,
                            min :'dataMin',
                            max:'dataMax',
                        },
                        yAxis: {
                            name:'/￥',
                            splitLine: {
                                show: false
                            }
                        },
                        toolbox: {
                            left: 'center',
                            feature: {
                                dataZoom: {
                                    yAxisIndex: 'none'
                                },
                                restore: {},
                                saveAsImage: {}
                            }
                        },
                        dataZoom: [{
                            startValue: '2014-06-01'
                        }, {
                            type: 'inside'
                        }],
                        visualMap: {
                            top: 10,
                            right: 10,
                            pieces: [{
                                gt: 0,
                                lte: 500,
                                color: '#096'
                            }, {
                                gt: 500,
                                lte: 1000,
                                color: '#ffde33'
                            }, {
                                gt: 1000,
                                lte: 2500,
                                color: '#ff9933'
                            }, {
                                gt: 2500,
                                lte: 3000,
                                color: '#cc0033'
                            }, {
                                gt: 3000,
                                lte: 4000,
                                color: '#660099'
                            }, {
                                gt: 4000,
                                color: '#7e0023'
                            }],
                            outOfRange: {
                                color: '#999'
                            }
                        },
                        series: {
                            name: '',
                            type: 'line',
                            data: year_yAxis_data,
                            markLine: {
                                silent: true,
                                data: [{
                                    yAxis: 500
                                }, {
                                    yAxis: 1000
                                }, {
                                    yAxis: 1500
                                }, {
                                    yAxis: 2000
                                }, {
                                    yAxis: 3000
                                },{
                                    yAxis: 5000
                                }, {
                                    yAxis: 8000
                                }, {
                                    yAxis: 10000
                                }]
                            }
                        }
                    };
                    myChartYear.setOption(optionYear);
                }
            });
        }
        form.render();
        form.on('checkbox()', function(data){
            if (data.othis.text() == '日' && data.elem.checked){
                $('#consume_day').show();
            }
            else if (data.othis.text() == '月' && data.elem.checked){
                $('#consume_month').show();
            }
            else if (data.othis.text() == '年' && data.elem.checked){
                $('#consume_year').show();
            }
            else if (data.othis.text() == '日' && data.elem.checked == false){
                $('#consume_day').css('display','none');
            }
            else if (data.othis.text() == '月' && data.elem.checked == false){
                $('#consume_month').css('display','none');
            }
            else if (data.othis.text() == '年' && data.elem.checked == false){
                $('#consume_year').css('display','none');
            }
        });
    });
</script>

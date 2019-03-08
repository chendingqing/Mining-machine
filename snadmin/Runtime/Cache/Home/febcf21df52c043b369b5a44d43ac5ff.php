<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			无标题文档
		</title>
		<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/font/jquery.datetimepicker.css"/>
		<script src="/font/jquery.js"></script>
<script src="/font/jquery.datetimepicker.js"></script>
<script src="/Public/Highcharts-4.2.5/js/highcharts.js" ></script>
<script src="/Public/Highcharts-4.2.5/js/modules/data.js" ></script>
<script src="/Public/Highcharts-4.2.5/js/modules/drilldown.js" ></script>
<script src="/Public/Highcharts-4.2.5/js/modules/exporting.js" ></script>
	</head>
	<body>
		<div class="place">
			<span>
				位置：
			</span>
			<ul class="placeul">
				<li>
					<a href="#">
						首页
					</a>
				</li>
				<li>
					<a href="#">
						表单
					</a>
				</li>
			</ul>
		</div>
		<div class="formbody">
			<div class="formtitle">
				<span>
					统计信息
				</span>
			</div>
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		<div id="container1" style="height: 400px;width: 600px;float:left;"></div>
		<div id="container2" style="height: 400px;width: 600px;float:left;display:block;padding-bottom:66px;"></div>
			<form id="form1" name="form1" method="post" action="/admin8899.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
							总注册人数
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($coun); ?>" />
						人
						<i>
						</i>
					</li>
					<li>
					<div style="float:left;">
						<label>
							每天注册人数
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($aa); ?>" />
						<input type="text" value="<?php echo ($today); ?>" id="datetimepicker"/>
						</div>
						<!-- <div contenteidtable="true" style="float:left; line-height:2.5;background-color:#A9A9A9;padding:0px 10px;" id="tijiao1" onclick="tijiao1()">提交</div> -->
						<div style="clear:both"></div>
						<script>
function tijiao1(){
var data = $('#datetimepicker').val();
	var data = Date.parse(new Date(data));
	data = data/1000;
	location.href = '/admin8899.php/Home/Index/counts/dir/' + data;
}
$('#datetimepicker').datetimepicker({
	step:5,
	
	lang:'ch',
});
</script>
						
					</li>
					<!-- <li>
						<label>
							提供帮助总金额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($tgbz_jb); ?>" />
						元
						<i>
						</i>
					</li>
					<li>
						<label>
							接受帮助总金额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jsbz_jb); ?>" />
						元
						<i>
						</i>
					</li>
					<li>
						<label>
							经理钱包总额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jl); ?>" />
						元
						<i>
						</i>
					</li> -->
<!-- added ends -->
					<!-- <li>
						<label>
							推荐钱包总额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($tj); ?>" />
						元
						<i>
						</i>
					</li>
					<li>
						<label>
							实际进场金额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($tgbz_jb); ?>" />
						元
						<i>
						</i>
					</li>
					<li>
						<label>
							实际出场金额
						</label>
						<input name="" type="text"
						class="dfinput" required="true" value="<?php echo ($jsbz_jb); ?>" />
						元
						<i>
						</i>
					</li>
					
					<li>
						<label>
							利息总额
						</label>
						<input type="text" value="<?php echo ($lx); ?>"
						class="dfinput" name="" required="">
						元
					</li>
					<li>
						<label>
							解冻金额
						</label>
						<input type="text" value="<?php echo ($ab); ?>" id="withdraw_day_diff"
						class="dfinput" name="withdraw_day_diff" required="">
						元
					</li> -->
					
				</ul>
			</form>
			<style>
				.pages a,.pages span { display:inline-block; padding:2px 5px; margin:0
				1px; border:1px solid #f0f0f0; -webkit-border-radius:3px; -moz-border-radius:3px;
				border-radius:3px; } .pages a,.pages li { display:inline-block; list-style:
				none; text-decoration:none; color:#58A0D3; } .pages a.first,.pages a.prev,.pages
				a.next,.pages a.end{ margin:0; } .pages a:hover{ border-color:#50A8E6;
				} .pages span.current{ background:#50A8E6; color:#FFF; font-weight:700;
				border-color:#50A8E6; }
			</style>
			<div class="pages">
				<br />
				<div align="right">
					<?php echo ($page); ?>
				</div>
			</div>
		</div>
		
		<script>
	$(function () {
    $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '控盘图(总金额：<?php echo $tgbz_jb+$jsbz_jb;?>)'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: '今日交易GEC',
                y: <?php echo $tgbz_jb;?>
            }, {
                name: '今日交易总额',
                y: <?php echo $jsbz_jb;?>,
                sliced: true,
                selected: true
           
            }]
        }]
    });
});
</script>
		 <script>
	$(function () {
    $('#container1').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '泡沫图(总金额：<?php echo $jl+$tj+$lx;?>)'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: '出售中GEC',
                y: <?php echo $csz;?>
            }, {
                name: '求购中GEC',
                y: <?php echo $qgz;?>,
                sliced: true,
                selected: true
           
            },{
                name: '已完成GEC',
                y: <?php echo $jywc;?>,
                sliced: true,
                selected: true
           
            }]
        }]
    });
});
</script>

		<script>
		$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '注册人数树状图'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '注册人数（个）'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: '总注册人数',
                y: <?php echo $coun;?>,
                drilldown: '总注册人数'
            }, {
                name: '每日注册人数',
                y: <?php echo $aa;?>,
                drilldown: '每日注册人数'
            
            }]
        }],
        drilldown: {
            series: [{
                name: 'Microsoft Internet Explorer',
                id: 'Microsoft Internet Explorer',
                data: [
                    [
                        'v11.0',
                        24.13
                    ],
                    [
                        'v8.0',
                        17.2
                    ],
                    [
                        'v9.0',
                        8.11
                    ],
                    [
                        'v10.0',
                        5.33
                    ],
                    [
                        'v6.0',
                        1.06
                    ],
                    [
                        'v7.0',
                        0.5
                    ]
                ]
            }, {
                name: 'Chrome',
                id: 'Chrome',
                data: [
                    [
                        'v40.0',
                        5
                    ],
                    [
                        'v41.0',
                        4.32
                    ],
                    [
                        'v42.0',
                        3.68
                    ],
                    [
                        'v39.0',
                        2.96
                    ],
                    [
                        'v36.0',
                        2.53
                    ],
                    [
                        'v43.0',
                        1.45
                    ],
                    [
                        'v31.0',
                        1.24
                    ],
                    [
                        'v35.0',
                        0.85
                    ],
                    [
                        'v38.0',
                        0.6
                    ],
                    [
                        'v32.0',
                        0.55
                    ],
                    [
                        'v37.0',
                        0.38
                    ],
                    [
                        'v33.0',
                        0.19
                    ],
                    [
                        'v34.0',
                        0.14
                    ],
                    [
                        'v30.0',
                        0.14
                    ]
                ]
            }, {
                name: 'Firefox',
                id: 'Firefox',
                data: [
                    [
                        'v35',
                        2.76
                    ],
                    [
                        'v36',
                        2.32
                    ],
                    [
                        'v37',
                        2.31
                    ],
                    [
                        'v34',
                        1.27
                    ],
                    [
                        'v38',
                        1.02
                    ],
                    [
                        'v31',
                        0.33
                    ],
                    [
                        'v33',
                        0.22
                    ],
                    [
                        'v32',
                        0.15
                    ]
                ]
            }, {
                name: 'Safari',
                id: 'Safari',
                data: [
                    [
                        'v8.0',
                        2.56
                    ],
                    [
                        'v7.1',
                        0.77
                    ],
                    [
                        'v5.1',
                        0.42
                    ],
                    [
                        'v5.0',
                        0.3
                    ],
                    [
                        'v6.1',
                        0.29
                    ],
                    [
                        'v7.0',
                        0.26
                    ],
                    [
                        'v6.2',
                        0.17
                    ]
                ]
            }, {
                name: 'Opera',
                id: 'Opera',
                data: [
                    [
                        'v12.x',
                        0.34
                    ],
                    [
                        'v28',
                        0.24
                    ],
                    [
                        'v27',
                        0.17
                    ],
                    [
                        'v29',
                        0.16
                    ]
                ]
            }]
        }
    });
});
		</script>
	</body>

</html>
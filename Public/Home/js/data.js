	 function openAlert(itme,str){
       	     $("#hint h1").html(itme);
             $("#hint .con").html(str);
             $("#hint").show();
       }
       function closeAlert(){
       	$("#hint").hide();
       }
//阳线是收盘价大于开盘价
//阴线是收盘价小于开盘价
//定义取出时间好和数据的函数
function getData(index,data){
    var mydata={};
        mydata.data=[];
        mydata.deta=[];
		if(index==1){
        for(var i=30,n=0;i>-1;i--,n++){
            var a=new Date(Date.parse(data[i].ctime.replace(/-/g,"/"))).getHours();
            var b=new Date(Date.parse(data[i].ctime.replace(/-/g,"/"))).getMinutes();
              a=a.toString().length==1?"0"+a:a;
              b=b.toString().length==1?"0"+b:b;
              var time=a+":"+b;
              mydata.deta.push(time);
              mydata.data[n]=[];
              mydata.data[n].push(data[i].kp);
              mydata.data[n].push(data[i].sp);
              mydata.data[n].push(data[i].zd);
              mydata.data[n].push(data[i].zg);
            
            }
		}else{
			for(var i=data.length-1,n=0;i>=0;i--,n++){
            var a=new Date(Date.parse(data[i].ctime.replace(/-/g,"/"))).getHours();
            var b=new Date(Date.parse(data[i].ctime.replace(/-/g,"/"))).getMinutes();
              a=a.toString().length==1?"0"+a:a;
              b=b.toString().length==1?"0"+b:b;
              var time=a+":"+b;
              mydata.deta.push(time);
              mydata.data[n]=[];
              mydata.data[n].push(data[i].kp);
              mydata.data[n].push(data[i].sp);
              mydata.data[n].push(data[i].zd);
              mydata.data[n].push(data[i].zg);
            
            }
		}
			//console.log(mydata);
    return mydata;
}
// 封装请求
function myAjax(app){
    $.showLoading();
    var ltype=$("#fsx li.active").attr("data-type");
    var mydata=null;
    var linetype="";
    var datas=null;
    var sname="";
    if(ltype==1){
        sname="分时线";
    }else if(ltype==5){
        sname="5分钟";
    }else if(ltype==15){
        sname="15分钟";
    }else if(ltype==30){
        sname="30分钟";
    }
    $.ajax({	
        url: 'http://61.160.207.152:25589/mydata.php',
        type: 'GET',
        dataType: 'json',
        data: {pid:$("#item1").attr("data-value"),ltype:ltype},
    })
    .done(function(data) {
        mydata=data;
            linetype="candlestick";
			if(ltype==1){
			  var datas=getData(1,mydata).data;
			  var detas=getData(1,mydata).deta;
			}else{
			  var datas=getData(2,mydata).data;
			  var detas=getData(2,mydata).deta;
			}
        
        option={
            title: {
              text: sname,
          },
            series:{
                type:linetype,
                data:datas,
                itemStyle: {
                normal: {
                    color: '#FD1050',
                    color0: '#0CF49B',
                    borderColor: '#FD1050 ',
                    borderColor0: '#0CF49B'
                }
               }
            },
            xAxis:{
                data:detas
            }
        }
        app.setOption(option);
		   	$.hideLoading();
    })
    .fail(function() {
		$.hideLoading();
        console.log("error");
    });
}
function mytiem(index,app,item){
		try
		   {
				clearInterval(circulation2);
				clearInterval(circulation1);
		   }
		catch(err)
		   {
		   }
    $.getJSON("/sinahq/time.php",function(data){
    var time=new Date(data*1000);
    var time1=new Date(data*1000).getDay();
    var h=time.getHours();
    var m=time.getMinutes();
    var s=time.getSeconds();
    h=h.toString().length==1?"0"+h:h;
    m=m.toString().length==1?"0"+m:m;
    s=s.toString().length==1?"0"+s:s;
    var time3=item[index][time1].split("-");
    var str1=(time3[0].split(":"))[0]+(time3[0].split(":"))[1];
    var str2=(time3[1].split(":"))[0]+(time3[1].split(":"))[1];
    str1=str1*100;
    str2=str2*100;
    str3=h+""+m+s;
    if(str3>=str1&&str3<=str2){
		$.hideLoading();
		$(".ts1").hide();
	    $(".ts2").show().html("休市时间:"+item[index][time1]);
       $("#mybtn .btn").unbind("click").bind("click",function(){
				$.alert("正在休市","提示");
		});
	   $(".Zprice").css({"color":"#fff","background":"orange","padding":"3px 10px","border-radius":"5px","font-size":"14px"}).html("休市中");
	  option={
            series:{       
				type:'line',
                data:[]
            },
            xAxis:{
                data:[]
            }
        }
         app.setOption(option);
    }else{
	   $(".ts1").show();
	$(".ts2").hide();
      $("#mybtn .btn").unbind("click").bind("click",zd);
	      // 每分钟更新图表
	myAjax(app);
	$(".Zprice").css({"background":"none","padding":"0","border-radius":"none","font-size":"14px"}).html("");
   circulation1=setInterval(function(){return myAjax(app);},60000);
    //每秒更新涨跌
    circulation2=setInterval(function(){
        $.ajax({
            url: 'http://61.160.207.152:25589/real.php',
            type: 'GET',
            dataType: 'json',
            data: {pid:$("#item1").attr("data-value")},
        })
        .done(function(data) {
            var price=data[0].price;
            if(data[0].price>data[1].price){
              $(".Zprice").css({"color":"red"}).html(price+"&nbsp;&uarr;");
            }else{
              $(".Zprice").css({"color":"green"}).html(price+"&nbsp;&darr;");
            }
        })
        .fail(function() {
            console.log("error");
        });
    },2000)
    }
   })
}
$(function(){
    // 创建echars实例
     var app = echarts.init(document.getElementById('main'));
     // 配置Echars
    var option = {
        title: {
        text: '分时线',
        left:'center',
        textStyle:{
            color:'#e6e6e6',
            fontStyle:'normal',
            fontWeight:'normal',
            fontSize:'16px'
        },
        padding:[15,0,0,0]
    },
    grid:{
        top:40,
        bottom:60,
        left:50,
        right:20
    },
    backgroundColor: '#21202D',
         tooltip: {
        trigger: 'axis',
        axisPointer: {
            animation: false,
            lineStyle: {
                color: '#376df4',
                width: 2,
                opacity: 1
            }
        }
    },
    xAxis: {
        type: 'category',
        data: [],
        axisLine: { lineStyle: { color: '#697384' } },
        scale: true,
        boundaryGap : true,
        axisLabel:{
            show:true
        },
        axisTick:{
            alignWithLabel:true
        }
    },
      dataZoom: [{
        textStyle: {
            color: '#8392A5'
        },
        handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
        handleSize: '80%',
        dataBackground: {
            areaStyle: {
                color: '#8392A5'
            },
            lineStyle: {
                opacity: 0.8,
                color: '#8392A5'
            }
        },
        handleStyle: {
            color: '#fff',
            shadowBlur: 3,
            shadowColor: 'rgba(0, 0, 0, 0.6)',
            shadowOffsetX: 2,
            shadowOffsetY: 2
        }
    }, {
        type: 'inside'
    }],
    yAxis:[ {
        scale: true,
			boundaryGap:['50%','50%'],
        axisLine: { lineStyle: { color: '#697384' } },
        splitLine: { show: true }
    }],
    animation: false,
    series: {
            type: 'line',
            data: [],
            itemStyle: {
                normal: {
                    color: '#FD1050',
                    color0: '#0CF49B',
                    borderColor: '#FD1050',
                    borderColor0: '#0CF49B'
                }
            }
        },
        tooltip:{
        trigger: 'axis',
         formatter:function(param){
                return '时间:'+param[0].name+'<br />'+
                       '开盘:'+param[0].data[0]+'<br />收盘:'+param[0].data[1]+'<br />'+
                       '最低:'+param[0].data[2]+'<br />最高:'+param[0].data[3]
                             
            },
        axisPointer: {
            type:'line',
            animation: false,
            lineStyle: {
                color: '#376df4',
                width: 2,
                opacity: 1
            },
        }
        }
};
app.setOption(option);
   var circulation1="";
   var circulation2="";
   mytiem($("#item1").attr("data-value"),app,item);
   // 分时线的控制和提交
    $("#fsx ul>li").click(function(){
        $("#fsx ul>li").removeClass('active');
        $(this).addClass('active');
       mytiem($("#item1").attr("data-value"),app,item);	
    })
    //select控制和提交
    $("#head .bot>.fl>ul>li").click(function(){
		mytiem($(this).attr("data-value"),app,item);		
    })
//第一次加载判断休市
});
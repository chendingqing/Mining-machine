    // 跳转动画
    function openloading(){
    $("#loading").show(0.5);
    }
    function closeloading(){
        $("#loading").hide(0.5);
    }
  function time(){
  var time={
    //显示时间的元素
    time1:$("#content .countDown").map(function(index,item){
      return [this]; 
    }),
    // 结束时间时间戳
    time2:$("#content>li .time2").map(function(index,item){ 
      var deta=new Date(Date.parse($(this).html().replace(/-/g,"/"))).getTime();
      return [deta]; 
    }), 
    // li
    size:$("#content li"),
      start:function(){
         if(this.size.length==0){
          return false;
         }else{
          //遍历li添加定时器
          for(var i=0;i<this.size.length;i++){
                    // 保存当前结束的时间
                  this.time1[i].time=this.time2[i];          
                  this.size[i].time=setInterval(this.run.bind(this.time1[i]),1000);
				  this.size[i].ajax=setInterval(this.ajax.bind(this.size[i]),1000);
          }
         }
      },
      run:function(){
          //获取当前时间
		  var mythis=this;
		  //alert("aa");
		  $.getJSON("/sinahq/time.php",function(data){
		  var nowtime= data;
			//alert(data);
		  var time=mythis.time-nowtime*1000;
          var h=parseInt(time%86400000/3600000);
          var m=parseInt(time%86400000%3600000/60000);
          var s=parseInt(time%86400000%3600000%60000/1000);
          if(h.toString().length==1){
            h="0"+h;
          }
          if(m.toString().length==1){
            m="0"+m;
          }
          if(s.toString().length==1){
            s="0"+s;
          }
		  if(s>=0){
          $(mythis).html(m+":"+s);
		  }else{
	      $(mythis).html("00:00");
		  }
          //实现等到零秒的实时刷新
          if(h==0&&m==0&s==0){
              setTimeout(function(){
				  window.location.href="/index.php/Home/User/trading.html";
			  },2000);
          }
		  })
          //var nowtime=new Date().getTime();
      },
     //实施刷新价格
	  ajax:function(){
		  var pid=$(this).find("#pid").val();
		  var zprice=$(this).find(".price2");
		  var price1=parseFloat($(this).find(".price1").html());
		  var myyl=$(this).find(".myyl");
		  var myks=$(this).find(".myks");
		  var mypd=$(this).find(".mypd");
		  var zzd=$(this).find(".zzd").attr("data-zzd");
          $.ajax({
			  url:"http://61.160.207.152:25589/real.php",
			  type:"GET",
		      data:{pid:pid},
			  dataType:"json",
			  success:function(data){
				  var price=data[0].price;
				  if(zzd==0){
				  if(price>price1){
                     zprice.css({"color":"red"}).html(price+"&nbsp;&uarr;");
					 myyl.hide();
					 myks.hide();
					 myyl.show();
					 mypd.html("盈");
				  }else if(price<price1){
                     zprice.css({"color":"green"}).html(price+"&nbsp;&darr;");
					 mypd.html("亏");
					 myyl.hide();
					 myks.hide();
					 myks.show();
				  }else{
					  zprice.css({"color":"bule"}).html(price);
					   myyl.hide();
					 myks.hide();
					  mypd.html("平&nbsp;&nbsp;<span style='color:blue;'></span>");
				  }
				  }else{
					  if(price>price1){
                     zprice.css({"color":"red"}).html(price+"&nbsp;&uarr;");
					 myyl.hide();
					 myks.hide();
					 myks.show();
					 mypd.html("亏");
				  }else if(price<price1){
                     zprice.css({"color":"green"}).html(price+"&nbsp;&darr;");
					 mypd.html("盈");
					 myyl.hide();
					 myks.hide();
					 myyl.show();
				  }else{
					 myyl.hide();
					 myks.hide();
					  zprice.css({"color":"bule"}).html(price);
					  mypd.html("平&nbsp;&nbsp;<span style='color:blue;'></span>");
				  }

				  }
			  }
		  })
	  }
    }
    return time;
  }
$(function(){
	if(location.href.indexOf("0.html")!=-1){
	   $("#top>.fl>span").html("白银");
	}else if(location.href.indexOf("1.html")!=-1){
	    $("#top>.fl>span").html("油");
	}else if(location.href.indexOf("2.html")!=-1){
	  $("#top>.fl>span").html("铜");
	}else{
      $("#top>.fl>span").html("所有产品");
	}
	$("#top>div>span").bind("click",function(){
        if($(this).parent().find("ul").is(":hidden")){
            $(this).parent().find("ul").slideDown()
		}else{
			$(this).parent().find("ul").slideUp();
		}
	})
	time().start();
})
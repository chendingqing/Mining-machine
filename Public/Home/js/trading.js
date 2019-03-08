$(function(){
	$.ajax({
    url: 'php/holdentrepot.php',
    type: 'GET',
    dataType: 'json',
    data: {userid:1,item:"所有产品",ctype:""},
  })
  .done(function(data) {
    var str2="";
    if(data[1]==null){
      $("#content2").empty().css({"padding":"0"});
    }else{
      $("#content2").css({"padding-bottom":"50px"})
    for(var n=0;n<data[1].length;n++){
      str2+='<li>'+
      '<div class="top">'+
        '<div class="fl">'+
          '<p class="hn"><i>'+data[1][n][0]+'</i>&nbsp;'+data[1][n][1]+'&nbsp;1M</p>'+
        '</div>'+
        '<div class="fr">'+
          '<p>盈亏:<span>'+data[1][n][4]+'</span></p>'+
        '</div>'+
      '</div>'+
      '<div class="content">'+
        '<div class="fl"><span><span class="price1">'+data[1][n][5]+'</span><br /><span class="operation1">购买价格</span></span><i class="fr"></i></div>'+
        '<div class="fl"><span><span class="price2">'+data[1][n][6]+'</span><br /><span class="operation2">到期价格</span></span><i class="fr"></i></div>'+
       ' <div class="fl"><span><span class="price3">￥'+data[1][n][9]+'</span><br /><span class="operation3">购买金额</span></span></div>'+
      '</div>'+
      '<div class="bottom">'+
        '<p class="fl">购买时间:<span class="time1">'+data[1][n][7]+'</span></p>'+
        '<p class="fr">结算时间:<span class="time2">'+data[1][n][8]+'</span></p>'+
      '</div>'+
    '</li>';
    }
    $("#content2").empty().append(str2);
      time().start();
  }
        })
  .fail(function(data) {
    console.log("error");
  })
})
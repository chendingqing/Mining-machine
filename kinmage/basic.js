$(function () {
    //下拉菜单
    $('.navlist').hover(function () {
        $(this).addClass('navhover');
        $(this).find('.navul').slideDown(0);
    },function () {
        $(this).find('.navul').slideUp(0);
        $(this).removeClass('navhover');
    });
    //股票界面
    $('#holder').parent('div').width(750);
});

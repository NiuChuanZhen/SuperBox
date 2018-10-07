<!-- 弹窗 开始 -->
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<style type="text/css">
    #tanch{
        background-color:rgba(112,128,144,0.6);position:fixed;top:0px;left:0px;z-index:999999;display:none;
    }
    #tanch_in{
        width:500px;max-width: 95% !important;height:190px;background-color:white;margin-left:auto;margin-right:auto;border-radius:5px;font-size:30px;text-align:center;
    }
    #tanch_in_header{
        height:70px;line-height:70px;font-weight:bolder;border-bottom:1px solid #e9ecef;color:white;overflow: hidden;
    }
    #close_tanch{
        float:right;line-height:40px;margin-right:10px;font-size:30px;
    }
    #tanch_in_body{
        height:70px;line-height:70px;font-size:25px;border-bottom:1px solid #e9ecef;text-align:left;padding-left:20px;overflow: hidden
    }
    #tanch_in_foot{
        height:50px;line-height:50px;background-color:#f8f9fa;font-size:20px;border-bottom:1px solid #e9ecef;overflow: hidden;
    }
</style>
<div id="tanch">
    <div id="tanch_in">
        <div id="tanch_in_header"><span id="tanch_in_header_text"></span>
            <span id="close_tanch">×</span>
        </div>
        <div id="tanch_in_body">{{Session key="body"}}</div>
        <div id="tanch_in_foot">友情提示</div>
    </div>
</div>
<script type="text/javascript">
    var Session_status="{{Session key='status'}}";
    if(Session_status=="error"){
        $("#tanch_in_header_text").text("操作失败");
        $("#tanch_in_header").css("background-color","#c82333");
        tanch();
    }
    if(Session_status=="success"){
        $("#tanch_in_header_text").text("操作成功");
        $("#tanch_in_header").css("background-color","#28a745");
        tanch();
    }
    function tanch(){
        var AllHeight;
        var AllWidth;
        var AllHeight=$(window).height();
        var AllWidth=$(window).width();
        $("#tanch").css('width',AllWidth);
        $("#tanch").css('height',AllHeight);
        $('#tanch').css("display","block");
        $('#tanch_in').animate({"margin-top":"100px"});
        setTimeout(function(){
            $("#tanch").css("display","none");
        },3000);

        $("#close_tanch").click(function(){
            $("#tanch").css("display","none");
        });
    }
</script>
<!-- 弹窗结束 -->
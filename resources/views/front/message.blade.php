@include('front/head')
<div class="line46"></div>
<div class="blank"></div>
<article>
    <div class="leftbox">
        <div class="infos">
            <div class="newsview">
                <h2 class="intitle">您现在的位置是：<a href='/'>首页</a>&nbsp;>&nbsp;留言</h2>
                <div class="gbook">
                    <div class="pagelist"><div id="test1"></div></div>
                    <div class="gbox">
                        <form  name="form1" id="form1">
                            <p> <strong>来说点儿什么吧...</strong></p>
                            <p><span> 怎么称呼你呢？:</span>
                                <input type="text" name="name" required lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" style="display: inline;width: auto">
                                <span style="color: red;text-align: center;">（必填哦）</span></p>
                            <p><span>选择头像:</span>
                                <button type="button" class="layui-btn" id="head">
                                    <i class="layui-icon">&#xe67c;</i>上传图片
                                </button>
                                <img src="" alt="" class="head" width="50px;" height="50px;" style="display: none">
                                <input type="hidden" name="headpic" value=""  required  lay-verify="required" class="layui-input">
                                <span style="color: red;text-align: center;">（可以点击下面的图标）</span>
                            </p>
                            <p> <i>
                                    <input type="radio" value= "/front/images/tx1.jpg" id= "1" name="mycall" style="display:none">
                                    <img id="a" src="/front/images/tx1.jpg " onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx2.jpg" id= "2" name="mycall" style="display:none">
                                    <img id="b" src="/front/images/tx2.jpg" onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx3.jpg" id= "3" name="mycall" style="display:none">
                                    <img id="c" src="/front/images/tx3.jpg" onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx4.jpg" id= "4" name="mycall" style="display:none">
                                    <img id="d" src="/front/images/tx4.jpg " onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx5.jpg" id= "5" name="mycall" style="display:none">
                                    <img id="e" src="/front/images/tx5.jpg" onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx6.jpg" id= "6" name="mycall" style="display:none">
                                    <img id="f" src="/front/images/tx6.jpg" onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front//images/tx7.jpg" id= "7" name="mycall" style="display:none">
                                    <img id="g" src="/front/images/tx7.jpg" onclick="myFun(this.id)"></i> <i>
                                    <input type="radio" value= "/front/images/tx8.jpg" id= "8" name="mycall" style="display:none">
                                    <img id="h" src="/front/images/tx8.jpg" onclick="myFun(this.id)"></i>
                            </p>
                            <p><span class="tnr">留言内容:</span>
                                <textarea name="content" cols="60" rows="12" id="lytext"></textarea>
                            </p>
                            <p>
                                <button class="layui-btn add-message" >立即提交</button>
                            </p>
                        </form>
                    </div>
                </div>
                <script>
                    function myFun(sId) {
                        var oImg = document.getElementsByTagName('img');
                        headpic = $("[name='headpic']").val();if (headpic!='')return false;
                        for (var i = 0; i < oImg.length; i++) {
                            if (oImg[i].id == sId) {
                                oImg[i].previousSibling.previousSibling.checked = true;
                                oImg[i].style.opacity = '1';
                                oImg[i].style.with = '60px';
                                oImg[i].style.height = '60px';
                            } else {
                                oImg[i].style.opacity = '.8';
                                oImg[i].style.with = 'auto';
                                oImg[i].style.height = 'auto';
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    <div class="rightbox">
        <div class="aboutme"></div>
        <div class="weixin"></div>
    </div>
</article>
@include('front/footer')
<script src="/front/js/message.js"></script>
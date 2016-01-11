<div class="top-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-4 user-summary">
                <span>欢迎来到{$shop_name}</span>
                {if $logged}
                <a class="tm-email" href="{$link->getPage('MyAccountView')}" title="账号">{$user_email}</a>
                <a class="tm-exit" href="{$exit}" title="退出">退出</a>
                {else}
                <a class="tm-login" href="{$link->getPage('LoginView')}" title="登录">登录</a>
                <a class="tm-reg" href="{$link->getPage('JoinView')}" title="注册">注册</a>
                {/if}
            </div>
            <div class="col-md-8 user-account">
                <ul class="inline fr">
                    <li><a class="tm-order" href="{$link->getPage('MyAccountView')}" title="我的定单">我的定单</a></li>
                    <li><a class="tm-wish" href="{$link->getPage('MyWishView')}" title="我关注的商品"><span aria-hidden="true" class="glyphicon glyphicon-heart before"></span> 我关注的商品</a></li>
                    <li class="spacer"></li>
                    <li>
                        <a class="tm-wechat" href="#done" title="关注微信" >关注我们 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a>
                    </li>
                    <li class="spacer"></li>
                    <li class="dropdown customer-service">
                        <a class="tm-order" href="{$link->getPage('MyAccountView')}">客户服务 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a>
                        <div class="menu">
                            <a href="{$link->getPage('ContactView')}">联系我们</a>
                            <a href="#">客服邮箱</a>
                            <a href="#">帮助中心</a>
                        </div>
                    </li>
                    <li class="spacer"></li>
                    <li><a class="tm-order" href="{$link->getPage('MyAccountView')}" title="网站地图">网站地图 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".tm-wechat").popover({
            trigger:'hover',
            placement: 'bottom',
            html:true,
            content: '<img src="">',
        });
    })
</script>
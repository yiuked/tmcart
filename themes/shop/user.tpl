<div id="main_columns_two" class="custom">
  	{include file="$tpl_dir./block/errors.tpl"}
	{if isset($success)}<div class="success">{$success}</div>{/if}

    <form method="post" action="{$link->getPage('UserView')}" class="form-horizontal">
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">邮箱</label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" value="{$user->email}" placeholder="邮箱">
        </div>
      </div>
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">昵称</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" value="{if isset($smarty.post.name)}{$smarty.post.name}{elseif isset($user->name)}{$user->name}{/if}" placeholder="昵称">
        </div>
      </div>
      <div class="form-group">
        <label for="old_passwd" class="col-sm-2 control-label">原密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="old_passwd" value="" placeholder="原密码">
        </div>
      </div>
      <div class="form-group">
        <label for="passwd" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="passwd" value="" placeholder="新密码">
        </div>
      </div>
      <div class="form-group">
        <label for="confirmation" class="col-sm-2 control-label">确认密码</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="confirmation" value="" placeholder="确认密码">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
          <button type="submit" class="btn btn-success">保存</button>
        </div>
      </div>
    </form>
</div>
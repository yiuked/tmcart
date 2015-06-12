<div id="main_columns_two" class="custom">
	<h2>Your personal information</h2>
  	{include file="$tpl_dir./block/errors.tpl"}
	{if isset($success)}<div class="success">{$success}</div>{/if}
    <form style="width:380px;" method="post" action="{$link->getPage('UserView')}" name="joinCommit" id="joinCommit">
      <input type="hidden" id="joinCommit_prevLocation" value="Bam1" name="prevLocation">
      <div class="formField">
        <div class="label">Email Address:</div>
        <div class="input">{$user->email}</div>
      </div>
	  <div class="formField">
        <div class="label"><span class="requiredRed">*</span> First name:</div>
        <div class="input">
          <input type="text" id="first_name" value="{if isset($smarty.post.first_name)}{$smarty.post.first_name}{elseif isset($user->first_name)}{$user->first_name}{/if}" maxlength="75" name="first_name" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label"><span class="requiredRed">*</span> Last name:</div>
        <div class="input">
          <input type="text" id="last_name" value="{if isset($smarty.post.last_name)}{$smarty.post.last_name}{elseif isset($user->last_name)}{$user->last_name}{/if}" maxlength="75" name="last_name" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label"><span class="requiredRed">*</span>Current Password:</div>
        <div class="input">
          <input type="password" id="old_passwd" name="old_passwd" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label">New Password:</div>
        <div class="input">
          <input type="password" id="passwd" name="passwd" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label">Confirmation:</div>
        <div class="input">
          <input type="password" id="confirmation" name="confirmation" size="30">
        </div>
      </div>
      <div style="height:40px;" class="formField">
        <div style="padding:10px 0px 10px 0px; text-align: left;" class="input">
          <input type="submit" value="Submit" name="joinCommit" id="joinCommit" class="form-send button big east pink collapse">
        </div>
      </div>
    </form>
</div>
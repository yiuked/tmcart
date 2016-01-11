<div class="container">
	<div class="row">
		<div class="col-md-2">
		{$DISPLAY_LEFT}
		</div>
		<div class="col-md-10">
			<h2>收货地址</h2>
			<div class="row">
				<div class="col-md-12">
					<a href="{$link->getPage('AddressView')}" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus"></span> 新增收货地址</a>
					<span>您已创建 {count($addresses)} 个收货地址，最多可创建10个</span>
				</div>
				<div class="col-md-12 address-list">
					{foreach from=$addresses item=address name=address}
						<div class="address-item">
							<div class="head">
								<h3>
									<b>{$address->name}</b>
									{if $address->is_default}
										<small class="label label-success">默认地址</small>
									{/if}
								</h3>
								<div class="extra">
									<a href="#none" data-toggle="modal" data-target=".delete-address-modal"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="content">
								<div class="row">
									<div class="col-sm-2 key">收货人</div>
									<div class="col-sm-8 value">{$address->name}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">国家</div>
									<div class="col-sm-8 value">{$address->join('Country', 'id_country')->name}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">省份</div>
									<div class="col-sm-8 value">{$address->join('State', 'id_state')->name}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">城市</div>
									<div class="col-sm-8 value">{$address->city}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">地址</div>
									<div class="col-sm-8 value">{$address->address}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">详细地址</div>
									<div class="col-sm-8 value">{$address->address2}</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">电话</div>
									<div class="col-sm-8 value">{$address->phone}</div>
									<div class="col-sm-2 other">
										<a href="{$link->getPage('AddressView', $address->id_address)}">编辑</a>
									</div>
								</div>
							</div>
						</div>
					{/foreach}
				</div>
				<div class="col-md-12">
					<a href="{$link->getPage('AddressView')}" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus"></span> 新增收货地址</a>
					<span>您已创建{count($addresses)}个收货地址，最多可创建10个</span>
				</div>
			</div>
		</div>
	</div>

</div>
<div class="modal fade delete-address-modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">删除</h4>
			</div>
			<div class="modal-body">
				<p>您确定要删除该收货地址吗？</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-xs" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary btn-xs">确定</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
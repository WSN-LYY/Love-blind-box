<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	.sdverify{display:inline-block;height:20px;line-height:20px;padding-left:20px;font-size:12px;background:url("<?php echo MODULE_URL;?>/static/mobile/images/v_0.png") no-repeat left center;background-size:16px 16px;}
	.sdverify.v1{background-image:url("<?php echo MODULE_URL;?>/static/mobile/images/v_1.png");color:#07ce81}
	.sdverify.v2{background-image:url("<?php echo MODULE_URL;?>/static/mobile/images/v_2.png");color:#ff8808}
</style> 


<ul class="nav nav-tabs">
	<li class="active"><a href="javascript:location.reload()">分销商管理</a></li>
</ul>

<div class="panel panel-default">
	<nav role="navigation" class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="javascript:;" class="navbar-brand">分销商列表</a>
			</div>
		</div>
	</nav>



	<div class="panel-body table-responsive" style="overflow:visible;">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th>id</th> 
					<th style="width:80px;">分销商</th>
					<th></th>
					<th style="text-align:right;">推广用户数</th>
					<th style="text-align:right;">下级数</th>
					<th style="text-align:right;">下下级数</th>
					<th style="text-align:right;">账户余额</th>
					<th style="text-align:right;">累计收入</th>
					<th style="text-align:right;">累计提现</th> 
					<!--<th>操作</th>-->
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><img src="<?php  echo VP_AVATAR($item['avatar'],'s');?>" style="width:50px;"/></td>
					<td><p><?php  echo $item['nickname'];?></p><p>加入：<?php  echo date('m-d H:i',$item['agent_time'])?></p></td>
					<td style="text-align:right;"><?php  echo $item['users'];?>人</td>
					<td style="text-align:right;"><?php  echo $item['agentbs'];?>人</td>
					<td style="text-align:right;"><?php  echo $item['agentb1s'];?>人</td>
					<td style="text-align:right;"><?php  echo format_money($item['agent_money'])?>元</td>
					<td style="text-align:right;"><?php  echo format_money($item['agent_money_in'])?>元</td>
					<td style="text-align:right;"><?php  echo format_money($item['agent_money_outcash'])?>元</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	</div>
</div>
<script type="text/javascript">
	require(['bootstrap'],function($){
		$('.btn-tooltip').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});

	function displayQr(url) {
		require(['jquery', 'util'], function($, u) {
			var content = '<div class="panel panel-default text-center"><img src="' + url + '" alt="访问地址二维码" class="img-rounded"></div>';
			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
			var diaobj = u.dialog('查看URL二维码', content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.modal('show');
		});
	}


	function school_to_stop(id,name) {
		require(['jquery', 'util'], function($, u) {
			var content =  '	<div class="form-group">';
				content += '	<h4>停用原因：</h4>';
                content += '	<textarea name="op_remark" class="op_remark form-control" rows="5"></textarea>';
				content += '	</div>';

			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
					'<button type="button" class="btn btn-success">确定停用</button>';
			var diaobj = u.dialog(name?name:id, content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.find('.btn-success').click(function() {
				$.post("<?php  echo $this->createWebUrl('school', array('cmd' => 'op','submit' => 'stop'))?>",{
					id:id,
					op_remark:diaobj.find('.op_remark').val()
				},function(resp) {
					if(resp.status==1){
						alert(resp.info);
						location.reload();
					}else{
						alert(resp.info);
					}
				});
			});
			diaobj.modal('show');
		});
	}

	function school_to_use(id,name) {
		require(['jquery', 'util'], function($, u) {
			var content =  '	<div class="form-group">';
				content += '	<h4>启用备注：</h4>';
                content += '	<textarea name="op_remark" class="op_remark form-control" rows="5"></textarea>';
				content += '	</div>';

			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
					'<button type="button" class="btn btn-success">确定启用</button>';
			var diaobj = u.dialog(name?name:id, content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.find('.btn-success').click(function() {
				$.post("<?php  echo $this->createWebUrl('school', array('cmd' => 'op','submit' => 'use'))?>",{
					id:id,
					op_remark:diaobj.find('.op_remark').val()
				},function(resp) {
					if(resp.status==1){
						alert(resp.info);
						location.reload();
					}else{
						alert(resp.info);
					}
				});
			});
			diaobj.modal('show');
		});
	}

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

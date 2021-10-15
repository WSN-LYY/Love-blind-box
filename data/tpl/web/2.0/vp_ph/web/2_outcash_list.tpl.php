<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo $this->createWebUrl('outcash')?>">提现管理</a></li>
</ul>

<form id="the_form" class="form-horizontal form" action="" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-heading">
			查询
		</div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户UID</label>
				<div class="col-sm-9 col-xs-12">
					<input type="text" name="s_user" class="form-control" value="<?php  echo $_GPC['s_user'];?>" placeholder="提现用户UID"/>
					<div class="help-block"></div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
				<div class="col-sm-9 col-xs-12">
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" value="" name="s_state" <?php  if(empty($_GPC['s_state'])) { ?>checked<?php  } ?>/> 未处理
						</label>
						<label class="radio-inline">
							<input type="radio" value="1" name="s_state" <?php  if($_GPC['s_state']==1 ) { ?>checked<?php  } ?>/> 已提现
						</label>
					</div>
					<div class="help-block"></div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<input id="btn-submit" type="submit" value="筛选" class="btn btn-primary col-lg-1" data-loading-text="正在筛选..."/>
				</div>
			</div>
		</div>
	</div>

</form>

<div class="panel panel-default">
	<nav role="navigation" class="navbar navbar-default navbar-static-top" style="margin-bottom:0;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="javascript:;" class="navbar-brand">提现记录</a>
			</div>
		</div>
	</nav>


	<div class="panel-body table-responsive" style="overflow:visible;">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:60px;">UID</th> 
					<th style="width:80px;">提现用户</th>
					<th></th>
					<th style="width:80px;">提现身份</th>
					<th style="text-align:right;width:100px">提现金额</br>实际到账</th>
					<!--<th style="text-align:right;">平台提成</br>提成费率</th>-->
					<th style="text-align:right;width:100px">提现前</br>提现后</th>
					<!--<th style="text-align:right;width:100px">余额</br>总收入</th>-->
					<th style="width:80px;">提现渠道</th>
					<th style="width:120px;">提现账号</th>
					<th>账号信息</th>
					<th>状态</th>
					<th>处理说明</th>
					<th style="width:150px;">提交时间</br>处理时间</th>
					<th style="text-align:right;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td>
						<p><?php  echo pencode($item['_user']['id'])?></p>
						<p><?php  echo $item['_user']['id'];?></p>
					</td>
					<td><img src="<?php  echo VP_AVATAR($item['_user']['avatar'],'s');?>" style="width:50px;"/></td>
					<td><?php  echo $item['_user']['nickname'];?></td>
					<td>
						<?php  if($item['biz']=='user') { ?>用户<?php  } ?>
						<?php  if($item['biz']=='agent') { ?>分销商<?php  } ?>
					</td>
					<td style="text-align:right;"><?php  echo format_money($item['money'])?>元</br><?php  echo format_money($item['cash'])?>元</td>
					<!--<td style="text-align:right;"><?php  echo format_money($item['tax'])?>元</br><?php  echo $item['rate']*100?>%</td>-->
					<td style="text-align:right;"><?php  echo format_money($item['money_before'])?>元</br><?php  echo format_money($item['money_after'])?>元</td>
					<!--<td style="text-align:right;"><?php  echo format_money($item['money'])?>元</br><?php  echo format_money($item['income'])?>元</td>-->

					<td><?php  if($item['channel']==1) { ?>微信转账<?php  } ?><?php  if($item['channel']==2) { ?>企业付款<?php  } ?></td>
					<td>
						<p><a href="<?php  echo VP_IMAGE_URL($item['channel_account'])?>" target="_blank"><img style="width:100px;" src="<?php  echo VP_IMAGE_URL($item['channel_account'],'s')?>"/></a></p>
					</td>
					<td>
						<p>姓名：<?php  echo $item['channel_realname'];?></p>
						<p>微信：<?php  echo $item['weixin'];?></p>
					</td>
					<td>
						<?php  if($item['status']==0) { ?>  
							<label class='label label-danger' >
								待处理
							</label>
						<?php  } ?>
						<?php  if($item['status']==1) { ?>  
							<label class='label label-success' >
								已发放
							</label>
						<?php  } ?>
						<?php  if($item['status']==2) { ?>  
							<label class='label label-default' >
								已拒绝
							</label>
						<?php  } ?>
					</td>
					<td><?php  echo $item['remark'];?></br><?php  echo $item['fedback'];?></td>
					<td><?php  echo date('Y-m-d h:i:s', $item['create_time']);?></br><?php  echo date('Y-m-d h:i:s', $item['update_time']);?></td>

					<td style="text-align:right;overflow:visible;">
						<?php  if($item['status']==0 ||  $item['status']==2) { ?>  
							<label>
								<a href="javascript:;" class="btn btn-success btn-sm" onclick="out_cash('<?php  echo $item['id'];?>','<?php  echo $item['_user']['nickname'];?>','<?php  echo format_money($item['cash'])?>元','<?php  echo $item['channel'];?>','<?php  echo $item['channel_account'];?>','<?php  echo $item['channel_realname'];?>');">发放</a>
								<!--<a href="javascript:;" class="btn btn-danger btn-sm" onclick="refuse_cash('<?php  echo $item['id'];?>','<?php  echo $item['name'];?>');">拒绝</a>-->
							</label>
						<?php  } ?>
					</td>
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
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});

	function out_cash(ids,nickname,money,channel,channel_account,channel_realname) {
		require(['jquery', 'util'], function($, u) {
			var content =  '	<div class="form-group">';
				content += '	<h4>提现用户：'+nickname+'</h4>';
				content += '	<h4>发放金额：'+money+'</h4>';
				content += '	<h4>收款方式：'+(channel==1?'微信转账':'企业付款')+'</h4>';
				//content += '	<h4>收款账户：'+channel_account+'</h4>';
				content += '	<h4>账户实名：'+channel_realname+'</h4>';
                content += '	<textarea name="remark" class="remark form-control" rows="5" placeholder="发放备注"></textarea>';
				content += '	</div>';

			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
					'<button type="button" class="btn btn-success">确认已发放</button>';
			var diaobj = u.dialog('提现发放',content,footer);

			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.find('.btn-success').click(function() {
				$.post("<?php  echo $this->createWebUrl('outcash', array('cmd' => 'outcash'))?>",{
					ids:ids,
					//channel:diaobj.find('input[name="channel"]:checked').val(),
					remark:diaobj.find('.remark').val()
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

	function refuse_cash(id,name) {
		require(['jquery', 'util'], function($, u) {
			var content =  '	<div class="form-group">';
				content += '	<h4>拒绝提现</h4>';
                content += '	<textarea name="fedback" class="fedback form-control" rows="5" placeholder="拒绝原因"></textarea>';
				content += '	</div>';

			var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
					'<button type="button" class="btn btn-success">确定拒绝</button>';
			var diaobj = u.dialog(name?name:id, content, footer);
			diaobj.find('.btn-default').click(function() {
				diaobj.modal('hide');
			});
			diaobj.find('.btn-success').click(function() {
				$.post("<?php  echo $this->createWebUrl('outcash', array('cmd' => 'refusecash'))?>",{
					id:id,
					fedback:diaobj.find('.fedback').val()
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

<div class="page-title">
	
	<div class="title-env">
		<h1 class="title"><?php echo $account['main_title'];?></h1>
	</div>
	
	<div class="breadcrumb-env">
		
		<ol class="breadcrumb bc-1">
			<li>
				<a href="index"><i class="fa-home"></i><?php echo $account['nav_index'];?></a>
			</li>
			<li class="active">
				<strong><?php echo $account['main_title'];?></strong>
			</li>
		</ol>
					
	</div>
		
</div>

<!-- Removing search and results count filter -->
<div class="panel panel-default">
	<div class="panel-body">
		<div style="text-align: right;">
			<a href="accountAdd"><button class="btn btn-white"><?php echo $account['account_add'];?></button></a>
		</div>
		<table class="table table-bordered table-striped" id="dataList">
			<thead>
				<tr>
					<th class="no-sorting">
						<input type="checkbox" class="cbr">
					</th>
					<th><?php echo $account['table_list_name']; ?></th>
					<th><?php echo $account['table_list_create_dt']; ?></th>
					<th><?php echo $account['table_list_actions']; ?></th>
				</tr>
			</thead>
			
			<tbody class="middle-align">
				<?php foreach ($account_data as $value) {?>
					<tr>
						<td>
							<input type="checkbox" class="cbr">
						</td>
						<td><?php echo $value['username'];?></td>
						<td><?php echo $value['create_dt'];?></td>
						<td>
							<a href="accountEdit/id/<?php echo $value['id'];?>" class="btn btn-secondary btn-sm btn-icon icon-left">
								<?php echo $account['account_list_edit'];?>
							</a>
							
							<a href="javascript:;" onclick="deleteModel('<?php echo $value['id'];?>', '<?php echo $value['username'];?>');" class="btn btn-danger btn-sm btn-icon icon-left">
								<?php echo $account['account_list_delete'];?>
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" id="token" name="<?php echo $token;?>" value="<?php echo $hash;?>" />
	</div>
</div>

<!-- delete modal-->
<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $account['confirm_delete'];?></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal"><?php echo $account['close'];?></button>
				<button type="button" id="sure" class="btn btn-info"><?php echo $account['save'];?></button>
			</div>
		</div>
	</div>
</div>

<!--data list-->				
<script type="text/javascript">

	//delete
	function deleteModel(id, username)
	{
		var token = $('#token').val();
		$('#delete .modal-body').html('<?php echo $account['sure_delete'];?> <span class="red">' + username + '</span> ?');
		$('#delete').appendTo("body").modal('show', {backdrop: 'static'}).one('click', '#sure', function() {
			jQuery.ajax({
				data: {'id' : id, 'csrf_token_name' : token},
				type: "POST",
				url: "accountDelete",
				success: function(msg) {
					location.reload();
				},
		        error: function(msg){
		            alert(msg);
		        }
			});
           $('#delete').modal('hide');
        });
	}

	$(document).ready(function($)
	{
		$("#dataList").dataTable({
			dom: "t" + "<'row'<'col-xs-6'i><'col-xs-6'p>>",
			aoColumns: [
				{bSortable: false},
				null,
				null,
				null,
			],
		});
		
		// Replace checkboxes when they appear
		var $state = $("#dataList thead input[type='checkbox']");
		
		$("#dataList").on('draw.dt', function()
		{
			cbr_replace();
			
			$state.trigger('change');
		});
		
		// Script to select all checkboxes
		$state.on('change', function(ev)
		{
			var $chcks = $("#dataList tbody input[type='checkbox']");
			
			if($state.is(':checked'))
			{
				$chcks.prop('checked', true).trigger('change');
			}
			else
			{
				$chcks.prop('checked', false).trigger('change');
			}
		});
	});
</script>
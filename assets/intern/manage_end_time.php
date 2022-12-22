<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-end">
			<div class="form-group">
				<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
				<input type="hidden" name="dur" value="<?php echo $_GET['dur'] ?> ">
				<input type="hidden" name="start" value="<?php echo $_GET['start'] ?> ">
				<label for="" class="control-label">Remarks</label>
				<textarea name="remarks" id="" cols="30" rows="4" class="form-control" required></textarea>
			</div>
		</form>
	</div>
</div>
<script>
	$('#manage-end').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'../ajax.php?action=save_end',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					location.reload()
				}
			}
		})
	})
</script>
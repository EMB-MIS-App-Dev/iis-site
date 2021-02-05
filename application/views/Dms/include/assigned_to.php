
<script>

	$(document).ready(function(){
		var send_group = $('div#sendinfo-attachments-group');

		var region_slct = send_group.find('div#assignto-group select[name="region"]');
		var division_slct = send_group.find('div#assignto-group select[name="division"]');
		var section_slct = send_group.find('div#assignto-group select[name="section"]');
		var receiver_slct = send_group.find('div#assignto-group select[name="receiver"]');

		var rgn_dslctd = region_slct.data('selected');
		var div_dslctd = division_slct.data('selected');
		var sec_dslctd = section_slct.data('selected');
		var rcv_dslctd = receiver_slct.data('selected');

		var region_val = '';
		if(region_slct.is(':visible')) {
			region_val = region_slct.val();

			region_slct.change(function() {
				$('#asgnto-spinner').show();
				send_group.find('div#assignto-group select').prop('disabled', true);
				send_group.find('span#assignto-refunc-group button').prop('disabled', true);
				region_val = $(this).val();
				$.ajax({
						url: '/embis/dms/data/ajax/get_division',
						method: 'POST',
						data: { 'selected': div_dslctd, 'region': region_val },
						dataType: 'html',
						success: function(response) {
							division_slct.html(response).change();
						},
						error: function(response) {
							division_slct.empty().html("<option value=''>-No Data-</option>").change();
							console.log("ERROR");
						},
				});
			}).change();
		}

		division_slct.change(function() {
			$('#asgnto-spinner').show();
			send_group.find('div#assignto-group select').prop('disabled', true);
			send_group.find('span#assignto-refunc-group button').prop('disabled', true);
			var division_val = $(this).val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_section',
					method: 'POST',
					data: { 'selected': sec_dslctd, 'division': division_val, 'region': region_val },
					dataType: 'html',
					success: function(response) {
						section_slct.html(response).change();
					},
					error: function(response) {
						section_slct.empty().html("<option value=''>-No Data-</option>").change();
						console.log("ERROR");
					},
			});
		});

		section_slct.change(function() {
			$('#asgnto-spinner').show();
			send_group.find('div#assignto-group select').prop('disabled', true);
			send_group.find('span#assignto-refunc-group button').prop('disabled', true);
			var section_val = $(this).val();
			var division_val = division_slct.val();
			$.ajax({
					url: '/embis/dms/data/ajax/get_personnel',
					method: 'POST',
					data: { 'selected': rcv_dslctd, 'section': section_val, 'division': division_val, 'region': region_val },
					dataType: 'html',
					success: function(response) {
						receiver_slct.html(response);
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
						send_group.find('span#assignto-refunc-group button').prop('disabled', false);
					},
					error: function(response) {
						receiver_slct.empty().html("<option value=''>-No Data-</option>").change();
						$('#asgnto-spinner').hide();
						send_group.find('div#assignto-group select').prop('disabled', false);
						send_group.find('span#assignto-refunc-group button').prop('disabled', false);
						console.log("ERROR");
					},
			});
		});

		$('#asgn_recall').click(function(){
			div_dslctd = '<?=$recall[0]['receiver_divno']?>';
			sec_dslctd = '<?=$recall[0]['receiver_secno']?>';
			rcv_dslctd = '<?=$recall[0]['receiver_id']?>';

			if(div_dslctd != '') {
		    region_slct.val('<?=$recall[0]['receiver_region']?>').trigger('change');
			}
		});

		$('#asgn_revert').click(function(){
			div_dslctd = '<?=$revert[0]['divno']?>';
			sec_dslctd = '<?=$revert[0]['secno']?>';
			rcv_dslctd = '<?=$revert[0]['token']?>';

			if(div_dslctd != '') {
				region_slct.val('<?=$revert[0]['region']?>').trigger('change');
			}
		});

	}); // DOCUMENT READY END
</script>

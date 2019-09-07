<script type="text/javascript">
	$(function () {
		if ($('#deliveryman_name').length) {
			if (!$('#deliveryman_name').is(':hidden')) {
				$("#deliveryman_name").select2({
					tags: true
				});
			}
		}

		if ($('#customers_name').length) {
			if (!$('#customers_name').is(':hidden')) {
				$("#customers_name").select2({
					tags: true
				});
			}
		}

		if ($('#delivery_dest').length) {
			if (!$('#delivery_dest').is(':hidden')) {
				$("#delivery_dest").select2({
					tags: true
				});
			}
		}

		if ($('#start_location').length) {
			if (!$('#start_location').is(':hidden')) {
				$("#start_location").select2({
					tags: true
				});
			}
		}

		if ($('#destination').length) {
			if (!$('#destination').is(':hidden')) {
				$("#destination").select2({
					tags: true
				});
			}
		}
	});
</script>
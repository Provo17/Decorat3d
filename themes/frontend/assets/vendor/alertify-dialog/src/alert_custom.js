function alert_reset () {
			$("#toggleCSS").attr("href", "../themes/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
                                position : "top-right",
				buttonReverse : false,
				buttonFocus   : "ok"
			});
		}

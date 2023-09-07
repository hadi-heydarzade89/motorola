(function($){


	$(document).ready(function(){
		$('#ippanel_patterncode,#ippanelapikey_patterncode1').each(function(){
			var target_id = $(this).attr('id').replace('_patterncode','');
			$(this).after('<a class="ippanel-pattern-check button" data-target="'+target_id+'">بررسی پترن</a><a class="ippanel-patternlearn thickbox" href="#TB_inline?width=600&height=550&inlineId=ippanel-pattern-modal-content">آموزش ثبت پترن</a>');
			
		});
		$('#ippanelapikey_patternvars').after('<a class="ippanel-patternlearn thickbox" href="#TB_inline?width=600&height=550&inlineId=ippanel-pattern-modal-content">آموزش ثبت پترن</a>');

		$('.ippanel-pattern-check').on('click',function(){
				if($(this).hasClass('proccessing')) return false;
				var patterncode_target = $('#'+$(this).data('target')+'_patterncode');
				var patternvars_target = $('#'+$(this).data('target')+'_patternvars');
				pcode = patterncode_target.val();
				if(pcode == '') {
					alert('لطفاً کد پترن را در کادر مربوطه وارد نمایید.');
					patterncode_target.focus();
					return false;
				}
				if($(this).data('target') == 'ippanel') {
					var paramsData = {
						action: 'digits_ippanel_CheckPattern',
						uname: $("#ippanel_username").val(),
						pass: $("#ippanel_password").val(),
						patternCode: pcode,
					}
				} else {
					var paramsData = {
						action: 'digits_ippanelapikey_CheckPattern',
						apikey: $("#ippanelapikey_apikey").val(),
						patternCode: pcode,
					}
				}
				jQuery.ajax({
					type: 'post',
					async: true,
					url: digsetobj.ajax_url,
					data: paramsData,
					beforeSend: function(){
						$('.ippanel-pattern-check').addClass('proccessing').text('در حال بررسی...');
					},
					success: function (json) {
						var obj = JSON.parse(json);
						var message = '';				
						  if(obj.status.code == 0){
							var pvars = obj.data.patternParams;
							var output = '';
							var pvarsCount = pvars.length;
							var i = 1;
							pvars.forEach(function(value, index, array){
								output += value+':';
								if(i == 1) output +='{OTP}';
								i++
								if(i < pvarsCount+1) output +="\n";
							});
							patternvars_target.val(output);
							if(pvarsCount > 1) alert('پترن انتخابی شما بیش از یک متغیر دارد. تنها متغیر اول با مقدار {OTP} در کادر متغیرها ثبت شده است. برای متغیرهای دیگر مقدار لازم را وارد کنید.');
						  }else if(obj.status.code == 404){
							  alert('پترن در دسترس نیست. مطمئن شوید که کد پترن را درست و بدون فاصله در چپ و راستش درج کرده اید. اگر به تازگی ثبت کرده اید منتظر باشید تا توسط سامانه تایید شود.');
						  }else if(obj.status.code == 962){
							  alert('نام کاربری یا رمز عبور اشتباه است. اطلاعات ورود پنل پیامکتان را درست وارد کنید.');
						  }else if(obj.status.code == 500){
							  alert('بررسی پترن با apikey در حال حاضر امکان ندارد.');
						  }else{
							  alert('این الگو در دسترس شما نیست. اگر به تازگی ثبت کرده اید منتظر باشید تا توسط سامانه تایید شود.');
						  }
					},
					complete: function(){
						$('.ippanel-pattern-check').removeClass('proccessing').text('بررسی پترن');
					},
				});

				return false;
			});
		$('#ippanel_sendpattern').on('change', function() {
			if($(this).val()== 1 && $('#digit_tapp').val() == 10000) {
				$('.ippanelcred #ippanel_patterncode,.ippanelcred #ippanel_patternvars').parents('tr').show();
				$('input[name=dig_messagetemplate]').parents('tr').hide();
			}else if($('#digit_tapp').val() == 10000){
				$('.ippanelcred #ippanel_patterncode,.ippanelcred #ippanel_patternvars').parents('tr').hide();
				$('input[name=dig_messagetemplate]').parents('tr').show();
			}
		});

		$('#ippanelapikey_sendpattern').on('change', function() {
			if($(this).val()== 1 && $('#digit_tapp').val() == 10001) {
				$('.ippanelapikeycred #ippanelapikey_patterncode,.ippanelapikeycred #ippanelapikey_patternvars').parents('tr').show();
				$('input[name=dig_messagetemplate]').parents('tr').hide();
			}else if($('#digit_tapp').val() == 10001){
				$('.ippanelapikeycred #ippanelapikey_patterncode,.ippanelapikeycred #ippanelapikey_patternvars').parents('tr').hide();
				$('input[name=dig_messagetemplate]').parents('tr').show();
			}
		});
    if($('#digit_tapp').val() == 10000){
      $('#ippanel_sendpattern').change();
    } else {
  		$('#ippanelapikey_sendpattern').change();
    }
	});
})(jQuery);
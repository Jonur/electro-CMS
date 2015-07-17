//BEGIN: Display image file before upload
function readURL_favico(input){
	if (input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function (e){
			$('#favico-preview').attr('src', e.target.result);
			$('#favico-preview').removeClass('no-icon');
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function readURL_image(input){
	if (input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function (e){
			$('#image-preview').attr('src', e.target.result);
			$('#image-preview').removeClass('no-icon');
		}
		reader.readAsDataURL(input.files[0]);
	}
}
//END: Display image file before upload

//BEGIN: Refresh listing
function refreshListMG(actionFile, tl, tob){
	window.location.href='?action=' + actionFile + '&tl=' + tl + '&tob=' + tob;
}
function refreshListMI(actionFile, tl, tob, tmg){
	window.location.href='?action=' + actionFile + '&tl=' + tl + '&tob=' + tob + '&tmg=' + tmg;
}
function refreshListMS(actionFile, tl){
	window.location.href='?action=' + actionFile + '&tl=' + tl;
}
function refreshListA(actionFile, tl, tob){
	window.location.href='?action=' + actionFile + '&tl=' + tl + '&tob=' + tob;
}
function refreshListG(actionFile, tl, tob){
	window.location.href='?action=' + actionFile + '&tl=' + tl + '&tob=' + tob;
}
function refreshListF(actionFile, ft, tob){
	window.location.href='?action=' + actionFile + '&ft=' + ft + '&tob=' + tob;
}
function refreshListP(actionFile, tob){
	window.location.href='?action=' + actionFile + '&tob=' + tob;
}
function refreshListC(actionFile, tob){
	window.location.href='?action=' + actionFile + '&tob=' + tob;
}
function refreshListL(actionFile, tob){
	window.location.href='?action=' + actionFile + '&tob=' + tob;
}
function refreshListWU(actionFile, tob){
	window.location.href='?action=' + actionFile + '&tob=' + tob;
}
function refreshListEU(actionFile, tob){
	window.location.href='?action=' + actionFile + '&tob=' + tob;
}
//END: Refresh listing

//BEGIN: OK-Cancel Alert ON DELETE
function checkfields(form)
{
	if(confirm("Είστε σίγουρος για την διαγραφή;"))
		return true;
	else
		return false;
}
function clear_log_confirm(form)
{
	if(confirm("Μη αναστρέψιμη ενέργεια! Είστε σίγουρος για την εκκαθάριση;"))
	{
		window.location.href='scripts/electro_log_delete.php';
		return true;
	}else{
		return false;
	}
}
//END: OK-Cancel Alert ON DELETE

//BEGIN: AJAX for MENU ITEM STRUCTURING IN THE DROP DOWN MENUS
function item_structure(mg_value, mother_value, mi_value)
{
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("items_structure").innerHTML=xmlhttp.responseText;
		}else{
			document.getElementById("items_structure").innerHTML='<img class="toolbox_img" src="images/loading.gif" />';
		}
	}
	xmlhttp.open("GET","scripts/structure.php?mg=" + mg_value + "&mother=" + mother_value + "&mi=" + mi_value,true);
xmlhttp.send();
}
//END: AJAX for MENU ITEM STRUCTURING IN THE DROP DOWN MENUS

//BEGIN: TRIGGER ACTUAL FILE INPUT FIELD FROM FAKE BUTTON
function trigger_from_pc(){
	if ($("form#bs_valform input#my_file_element").length > 0){
		document.getElementById('files_list').innerHTML = '<img id = "favico-preview" src = "#" class = "no-icon" />';
	}
	if ($("form#image-to-gallery input#my_file_element").length > 0){
		document.getElementById('files_list').innerHTML = '<img id = "image-preview" src = "#" class = "no-icon" />';
	}
	if ($('form[name="menu_items_create"] input#my_file_element').length > 0){
		document.getElementById('files_list').innerHTML = '<img id = "image-preview" src = "#" class = "no-icon" />';
	}
	if ($('form[name="files_create"] input#my_file_element').length > 0){
		document.getElementById('files_list').innerHTML = '<img id = "image-preview" src = "#" class = "no-icon" />';
	}
	$('#my_file_element').click();
}
//END: TRIGGER ACTUAL FILE INPUT FIELD FROM FAKE BUTTON

//BEGIN: SHADOWBOX POPUP FOR IMAGE CAPTIONS
function popupGalleryCaptions(fid){
	 Shadowbox.open({
        content:    'scripts/galleries_append_toolbox_image_captions.php?fid=' + fid,
        player:		"iframe",
        title:      "Λεζάντες",
        height:     300,
        width:      754
    });
}
//END: SHADOWBOX POPUP FOR IMAGE CAPTIONS

//BEGIN: EDIT FORM ACTION AND SUBMIT FORM @ RESTORE MANAGER
function edit_and_submit(form_id, action){
	if(!$('ul#record-listing li.single-line input[type="checkbox"]').is(':checked')){
		alert('Καμία επιλεγμένη οντότητα.');
		return false;
	}
	$('#' + form_id).attr("action",action);
	$('#' + form_id).submit();
}
//END: EDIT FORM ACTION AND SUBMIT FORM @ RESTORE MANAGER

//BEGIN: ALLOW LINKING FILES TO GALLERY ONLY IF ANY SELECTED
function enable_form(){
	if(!$('.photocell input').is(':checked')){
		alert('Καμία επιλεγμένη εικόνα.');
		return false;
	}
	return true;
}
//END: ALLOW LINKING FILES TO GALLERY ONLY IF ANY SELECTED

//BEGIN: OK/CANCEL and Form Submission for Electro Cleanup
function electro_cleanup_submit(){
	if(!$('.table input').is(':checked')){
		alert('Καμία επιλεγμένη οντότητα.');
		return false;
	}
	
	if(confirm("Μη αναστρέψιμη ενέργεια! Είστε σίγουρος για την εκκαθάριση;"))
	{
		$('#electro_cleanup').submit();
		return true;
	}else{
		return false;
	}
}
//END: OK/CANCEL and Form Submission for Electro Cleanup

//BEGIN: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ GALLERIES
function update_fl_i_f(item, ext_arr, preview_exception){
	var filename = item.value.replace(/^.*[\\\/]/, '');
	var ext = filename.substr(filename.lastIndexOf('.') + 1);
	
	if (jQuery.inArray(ext.toLowerCase(), ext_arr)==-1){
		$('#my_file_element').val("");
		filename = '<span class="file_error">Μη αποδεκτός τύπος αρχείου.</span>';
		document.getElementById('files_list').innerHTML = filename;
	}else{
		var ext_array_img = ['jpg','jpeg','gif','png'];
		if ((jQuery.inArray(ext.toLowerCase(), ext_array_img)==-1) && (preview_exception == 1)){
			$('img#image-preview').css('display', 'none');
			document.getElementById('files_list').innerHTML = filename;
		}
	}
}
function update_file_list(item)
{
	var ext_array = ['jpg','jpeg','gif','png'];
	update_fl_i_f(item, ext_array, 0);
}
//END: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ GALLERIES

//BEGIN: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ FILES
function accept_files(item)
{	
	var ext_array = ['png','jpeg','gif','jpg','mp3','wav','mpeg','mpg','odt','odf','txt','pdf','xls','doc','docx','xlsx'];
	update_fl_i_f(item, ext_array, 1);
}
//END: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ FILES

//BEGIN: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ BASIC SETTINGS
function update_icon(item)
{
	var ext_array = ['ico'];
	update_fl_i_f(item, ext_array, 0);
}
//END: CHECK FILE TYPE BEFORE UPLOADING AND ACCEPT ONLY THE ONES IN ext_array @ BASIC SETTINGS

//BEGIN: PREVENT CLICK SPAM
function enableButton(){
   $('.append_button').removeAttr('disabled');
}
//END: PREVENT CLICK SPAM

//BEGIN: GET FILE SIZE OF A FILE TO BE UPLOADED
function handleFileSelect(evt){
    var files = evt.target.files; // FileList object
	
	if (files[0].size > 10485760){
		$('#my_file_element').val("");
		filename = '<span class="file_error">Μη επιτρεπτό μέγεθος αρχείου (Μέγιστο επιτρεπτό 10MB).</span>';
		document.getElementById('files_list').innerHTML = filename;
	}
}
//END: GET FILE SIZE OF A FILE TO BE UPLOADED

//BEGIN: PAGINATION - Reload tab content
function electroPagination(link, tab){
	$("#" + tab).tabs("url", $("#" + tab).tabs("option", "selected"), link);
	$("#" + tab).tabs( "load" , $("#" + tab).tabs("option", "selected"));
}
//END: PAGINATION - Reload tab content

//BEGIN: SELECT/UNSELECT ALL links for Restore Manager
function select_unselect(state){
	$('ul#record-listing li.single-line input[type="checkbox"]').prop('checked', state);
}
//END: SELECT/UNSELECT ALL links for Restore Manager

//BEGIN: add validator rule
jQuery.validator.addMethod("noZeroValue", function(value, element) {
    return this.optional(element) || ($(element).val() != 0);
}, "<br />Παρακαλώ επιλέξτε ομάδα μενού που ανήκει το συγκεκριμένο στοιχείο μενού.");
jQuery.validator.addMethod("isValidPhonenumber", function(value, element) {
	var myreg = /^\+?[\d -]+$/;
	return this.optional(element) || myreg.test(value);
}, "<br />Παρακαλώ εισάγετε έγκυρο αριθμό τηλεφώνου.");
//BEGIN: add validator rule

   //------------------------------------//
  //-----------------ON-----------------//
 //-----------DOCUMENT READY-----------//
//------------------------------------//
$(function(){
	//BEGIN: Display image file before upload
	$("form#bs_valform input#my_file_element").change(function(){
		readURL_favico(this);
	});
	$('form#image-to-gallery input#my_file_element, form[name="menu_items_create"] input#my_file_element, form[name="files_create"] input#my_file_element').change(function(){
		readURL_image(this);
	});
	//END: Display image file before upload
	
	//BEGIN: Check this element
	$("#content_area").on("click", "li.single-line.restore-manager, li.single-line.electro-cleanup", function (e) {
		if (e.target.nodeName != "INPUT") {
			var myChks = $(this).children(":checkbox");
			$.each(myChks, function () {
				if ($(this).is(":checked") === true) {
					$(this).prop("checked", false);
				} else {
					$(this).prop("checked", true);
				}
			});
		}
	});
	//END: Check this element
	
	//BEGIN: jquery UI tooltips
	$(document).tooltip();
	//END: jquery UI tooltips

	//BEGIN: Toggle input type password/text
	$('.toggle-pwd').click(function(){
		var ch_type = 'password'; 
		if( $('input.toggle-pwd').is(':checked')){
			ch_type = 'text';
		}else{
			ch_type = 'password';
		}
		$('input[name="eu_pwd"]').prop('type', ch_type);
		$('input[name="eu_pwd_re"]').prop('type', ch_type);
		$('input[name="wu_pwd"]').prop('type', ch_type);
		$('input[name="wu_pwd_re"]').prop('type', ch_type);
	});
	//END: Toggle input type password/text

	//BEGIN: validation message remove after 3 sec if exist
	var messageBox = $('.validation_message, .login_error');
	if (messageBox.length > 0){
		messageBox.fadeIn(1000).delay(3000).fadeOut('slow');
	}
	//END: validation message remove after 3 sec if exist

	//BEGIN: Toggle Menu Items block
	$('.menu_title').click(function (){
		$(this).next().toggleClass('active');
		$(this).next().toggleClass('hide');
		
		if ($(this).next().hasClass('hide')){
			$(this).addClass('menu_spacing');
		}else{
			$(this).removeClass('menu_spacing');
		}
	});
	//END: Toggle Menu Items block
	
	//BEGIN: On page load focus on username field
	$('#electro_un').focus();
	//END: On page load focus on username field
	
	//arxikopoiisi imerologiou
	$("#datepicker_from, #datepicker_to, #datepicker_start, #datepicker_expire").datepicker( {
										showAnim: 'show', 
										dateFormat: 'yy-mm-dd',
										minDate: 0,
										showOtherMonths: true,
										selectOtherMonths: true,
										showOn: "button",
										buttonImage: "images/calendar.jpg",
										buttonImageOnly: true
									});
									
	//adjust datepicker's min-max date according users choice
	$("#datepicker_from").change(function(){
		$("#datepicker_to").datepicker( "option", "minDate", $(this).val() );
	});
	$("#datepicker_to").change(function(){
		$("#datepicker_from").datepicker( "option", "maxDate", $(this).val() );
	});
	$("#datepicker_start").change(function(){
		$("#datepicker_expire").datepicker( "option", "minDate", $(this).val() );
	});
	$("#datepicker_expire").change(function(){
		$("#datepicker_start").datepicker( "option", "maxDate", $(this).val() );
	});

	//Bind #my_file_element to handleFileSelect()
	if (document.getElementById('my_file_element')){
		document.getElementById('my_file_element').addEventListener('change', handleFileSelect, false);
	}
	
	//BEGIN: FORM VALIDATION
	//form validation init
	$("#valform").validate({
		rules: {
			mi_meta_description: {
				minlength: 70,
				maxlength: 160,
			},
			a_meta_description: {
				minlength: 70,
				maxlength: 160,
			},
			mi_mg: {
				noZeroValue : true,
			},
			nm_tel: {
				isValidPhonenumber: true,
			},
		}
		});
	
	// validate signup form on keyup and submit
	$("#eu_valform").validate({
		rules: {
			eu_pwd: {
				required: true,
				minlength: 4
			},
			eu_pwd_re: {
				required: true,
				minlength: 4,
				equalTo: "#eu_pwd"
			}
		}
	});
	
	$("#eu_edit_valform").validate({
		rules: {
			eu_pwd: {
				minlength: 4
			},
			eu_pwd_re: {
				minlength: 4,
				equalTo: "#eu_pwd"
			}
		}
	});
	
	// validate signup form on keyup and submit
	$("#wu_valform").validate({
		rules: {
			wu_pwd: {
				required: true,
				minlength: 4
			},
			wu_pwd_re: {
				required: true,
				minlength: 4,
				equalTo: "#wu_pwd"
			}
		}
	});
	
	$("#wu_edit_valform").validate({
		rules: {
			wu_pwd: {
				minlength: 4
			},
			wu_pwd_re: {
				minlength: 4,
				equalTo: "#wu_pwd"
			},
			wu_tel: {
				isValidPhonenumber: true,
			},
			wu_cel: {
				isValidPhonenumber: true,
			},
			wu_fax: {
				isValidPhonenumber: true,
			},
		}
	});
	
	$(".valform_rank").validate({
		errorLabelContainer: $("span.error_output"),
		messages: {
			gf_rank: "Παρακαλώ εισάγετε μόνο αριθμούς."
		}	
	});
	
	$("#bs_valform").validate({
		rules: {
			bs_title: {
				required: true,
				minlength: 10,
				maxlength: 70,
			},
			bs_description: {
				minlength: 70,
				maxlength: 160,
			}
		}
		});
	//END: FORM VALIDATION
	
	
	//shadowbox init
	Shadowbox.init();
	
	//menu_group_create & menu_group_edit
	$(".fill_alias").click(function(){
		var img_src = $(".expand_collapse").attr("src");
		if(img_src=="images/electro_expand.png"){
			$(".expand_collapse").attr("src","images/electro_collapse.png");
		}else{
			$(".expand_collapse").attr("src","images/electro_expand.png");
		}
		$("#lang_list_edit").slideToggle();
		$("#lang_list").slideToggle();
	});
	//---------------------------------------

	//files_create &files_update
	$(".form_unified_file").click(function(){
		var img_src = $(".expand_collapse").attr("src");
		if(img_src=="images/electro_expand.png"){
			$(".expand_collapse").attr("src","images/electro_collapse.png");
		}else{
			$(".expand_collapse").attr("src","images/electro_expand.png");
		}
		$("#mi_list_edit").slideToggle();
		$("#mi_list").slideToggle();
	});
	//---------------------------------------
	
	//article_create & article_edit
	$(".fill_seo-serp").click(function(){
		var img_src = $(".expand_collapse_seo-serp").attr("src");
		if(img_src=="images/electro_expand.png"){
			$(".expand_collapse_seo-serp").attr("src","images/electro_collapse.png");
		}else{
			$(".expand_collapse_seo-serp").attr("src","images/electro_expand.png");
		}
		$("#seo-serp_edit").slideToggle();
		$("#seo-serp").slideToggle();
	});
	$(".attach_gallery").click(function(){
		var img_src = $(".expand_collapse_gallery").attr("src");
		if(img_src=="images/electro_expand.png"){
			$(".expand_collapse_gallery").attr("src","images/electro_collapse.png");
		}else{
			$(".expand_collapse_gallery").attr("src","images/electro_expand.png");
		}
		$("#gallery_list_edit").slideToggle();
		$("#gallery_list").slideToggle();
	});
	$(".attach_file").click(function(){
		var img_src = $(".expand_collapse_file").attr("src");
		if(img_src=="images/electro_expand.png"){
			$(".expand_collapse_file").attr("src","images/electro_collapse.png");
		}else{
			$(".expand_collapse_file").attr("src","images/electro_expand.png");
		}
		$("#file_list_edit").slideToggle();
		$("#file_list").slideToggle();
	});
	//----------------------------------------
	
	$( "#entity_tabs" ).tabs();	
	
	$('.mg_change').change(function() {
		item_structure($(this).val(), $(".mother_id").val(), $("#edit_id").val());
	});
	$('.mg_change').change();
	
	
	//BEGIN:CKEDITOR
	var config = {
		language: 'el',
		toolbar:
		[
		['Bold', 'Italic', 'Underline','Strike','Subscript','Superscript','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','HorizontalRule','SpecialChar','-','NumberedList', 'BulletedList'],
		['Link', 'Unlink','Image','Flash','Iframe','-','Maximize','-','Undo','Redo','Find','Replace','-','Source','Preview'],
		['UIColor']
		],
		width: 500,
		height: 500, 
		entities_greek : false
	};
	
	$('.jquery_ckeditor').ckeditor(config);
	//END:CKEDITOR
	
	//BEGIN:DISABLE BUTTON FOR 1 sec
	$('.append_button').click(function(){
		$('.append_button').attr("disabled", "disabled");
		setTimeout(enableButton, 1000);
	});
	//END:DISABLE BUTTON FOR 1 sec
	
	//BEGIN: SLIDING
	$('.slide_button_main').click(function() {
		if($('#photo_listing').css('display') != "none"){
			//clear validation message;
			//$('.validation_message_false').html('');
			$('.validation_message_true').html('');
			
			var $marginLefty = $('#photo_listing');
			$('.slide_button_main').html('Επιστροφή');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				$marginLefty.outerWidth() :
				0
			},function(){
					$('#photo_listing').css('display', 'none');
					var $marginLefty = $('#form_selector');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) == -734 ?
						0 :
						-$marginLefty.outerWidth()
					});
				});
		}else{
			var $marginLefty = $('#form_selector');
			$('.slide_button_main').html('Προσθήκη');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				-$marginLefty.outerWidth() :
				0
			},function(){
					var $marginLefty = $('#photo_listing');
					$("#form_selector").css('display', 'none');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) != 0 ?
						0 :
						$marginLefty.outerWidth()
					});
				});
		}
	});
	
	$('.slide_button_server').click(function() {
		if($('#form_selector').css('display') !="none"){
			var $marginLefty = $('#form_selector');
			$('.button_show_server').css('display','inherit');
			$('.slide_button_main').css('display','none');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				$marginLefty.outerWidth() :
				0
			},function(){
					$('#form_selector').css('display', 'none');
					var $marginLefty = $('#from_server');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) == -734 ?
						0 :
						-$marginLefty.outerWidth()
					});
				});
		}else{
			var $marginLefty = $('#from_server');
			$('.button_show_server').css('display','none');
			$('.slide_button_main').css('display','inherit');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				-$marginLefty.outerWidth() :
				0
			},function(){
					var $marginLefty = $('#form_selector');
					$('#from_server').css('display', 'none');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) != 0 ?
						0 :
						$marginLefty.outerWidth()
					});
				});
		}
	});
	
	$('.slide_button_pc').click(function() {
		if($('#form_selector').css('display') !="none"){
			var $marginLefty = $('#form_selector');
			$('.button_show_pc').css('display','inherit');
			$('.slide_button_main').css('display','none');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				$marginLefty.outerWidth() :
				0
			},function(){
					$('#form_selector').css('display', 'none');
					var $marginLefty = $('#from_pc');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) == -734 ?
						0 :
						-$marginLefty.outerWidth()
					});
				});
		}else{
			var $marginLefty = $('#from_pc');
			$('.button_show_pc').css('display','none');
			$('.slide_button_main').css('display','inherit');
			$marginLefty.animate({
				marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
				-$marginLefty.outerWidth() :
				0
			},function(){
					var $marginLefty = $('#form_selector');
					$('#from_pc').css('display', 'none');
					$marginLefty.css('display', 'inherit');
					$marginLefty.animate({
						marginLeft: parseInt($marginLefty.css('marginLeft'),10) != 0 ?
						0 :
						$marginLefty.outerWidth()
					});
				});
		}
	});
	//END: SLIDING
	
	//BEGIN: CHANGE OPACITY OF SELECTED IMAGES IN PHOTO LISTINGS
	$(".photocell_check").change(function(){
		var img_src = $(this).parent().next().children("a").children("img");
		if ($(this).is(':checked')){
			img_src.switchClass( "photocell_img", "photocell_img_selected", 1000 );
		}else{
			img_src.switchClass( "photocell_img_selected", "photocell_img", 1000 );
		}
	});
	//END: CHANGE OPACITY OF SELECTED IMAGES IN PHOTO LISTINGS
	
	//BEGIN: sliding photo listing gallery from server
	var is_clicked = false;
    $("img#arrow_r").click(function(){
        if (is_clicked == true){
            return;
        }
        is_clicked = true;
        var $img_block = $('.photoBlock:visible');//current
        if ($img_block.next().length > 0){
            $img_block.animate({
                    marginLeft:-$('#server_photo_listing').outerWidth()
                },function(){
                    is_clicked = true;
                    var $img_block = $('.photoBlock:visible');//current
                    var $img_block_next = $img_block.next();//next
                    $img_block.css("display","none");
                    $img_block_next.css("display","inherit");
                    $img_block_next.animate({
                        marginLeft:0
                    }
                    );
                    is_clicked = false;
                  });
        }
		is_clicked = false;
    });

    $("img#arrow_l").click(function(){
        if (is_clicked == true){
            return;
        }
        is_clicked = true;
        var $img_block = $('.photoBlock:visible');//current
        if ($img_block.prev().length > 0){
            $img_block.animate({
                    marginLeft:$('#server_photo_listing').outerWidth() 
                }, function(){
                    is_clicked = true;
                    var $img_block = $('.photoBlock:visible');//current
                    var $img_block_prev = $img_block.prev();//previous
                    $img_block.css("display","none");
                    $img_block_prev.css("display","inherit");
                    $img_block_prev.animate({
                        marginLeft:0
                    }
                    );
                    is_clicked = false;
                  });
        }
		is_clicked = false;
    });
	//END: sliding photo listing gallery from server
	
	//BEGIN: show rank onclick
	$('.rank').click(function(){
		var $gf_rank = $(this).parent().next();
		$gf_rank.fadeToggle();
		$inputTxt = $gf_rank.children('form.valform_rank').children('input[name="gf_rank"]');
		console.log($inputTxt.length);
		$inputTxt.focus();
	})
	$('.photocell_gallery').hover(function(){
		//close all others but this
		var $allTB = $('.photocell_toolbox').not($(this).children(':first'));
		$allTB.stop(true,true).slideUp();
		var $allRanks = $('.gf_rank').not(this);
		$allRanks.stop(true,true).fadeOut();
		
		var $toolbox = $(this).children(':first');
		$toolbox.slideDown();
	}, function(){
		var $toolbox = $(this).children(':first');
		$toolbox.delay(1000).slideUp();
		$(this).find(".gf_rank").delay(1000).fadeOut();
	})
	//END: show rank onclick
	
	//BEGIN: Select specific tab on return/load
	//Current Tab-Set Name (ctsn)
	var ctsn = $(document).getUrlParam('ctsn');
	//Current Tab Index Number (ctin)
	var ctin = $(document).getUrlParam('ctin');
	ctin = $('#' + ctin).index();
    $('#' + ctsn).tabs("option", "active", ctin);
	//END: Select specific tab on return/load
});
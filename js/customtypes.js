jQuery(document).ready(function() {
	
	/* ensuring the wordpress image uploader can function on existing fields and for 
	 * custom field uploading:
	 */
	window.original_send_to_editor = window.send_to_editor;//use this function when default upload being used
	uploadingField =  null;//this will tell us when it's a custom field upload
	uploadID = null;
	jQuery('#media-buttons').click(function(){
		uploadingField = null;//unset custom uploading for standard upload buttons
	});
	
	jQuery('.gu-upload').click(function() {
		uploadingField = jQuery(this).prev().attr('id');//upload to specific form element on custom upload (allows multiple custom uploads on the same page)
		tb_show('upload', 'media-upload.php?type=image&TB_iframe=true&width=640&height=600');
		return false;
	});
	
	jQuery('.savesend input').live('click',function() {//getting the id of the image being uploaded
		
		if (top.uploadingField!=null){//using custom field for uploading:
			var id = jQuery(this).attr('id');
			re = /\d+/;
			id = id.match(re);//only digit will be id
			top.uploadID = id;
		}
	});
	
	window.send_to_editor = function(html) {
		if (uploadingField!=null){//if we're using a custom field for uploading:
			imgURL = jQuery('img',html).attr('src');
			jQuery('#'+uploadingField).val(uploadID);
			//include image:
			
			if (jQuery('#'+uploadingField).parent().find('img').length){
				jQuery('#'+uploadingField).parent().find('img').attr('src',imgURL);//load captcha image now in case user has come back to the page
			}
			else{
				html = html.replace('class="','class="gu-upload ');
				jQuery('#'+uploadingField).parent().append(html);
				jQuery('.gu-upload').parent().addClass('thickbox');
			}
			tb_remove();
			
			
		}else{//use original if we're doing a standard upload:
			window.original_send_to_editor(html);
		}
	}
	
	
	
});
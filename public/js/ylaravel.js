var editor = new wangEditor('content');
editor.config.uploadImgUrl = '/posts/image/upload';
//设置headers
editor.config.uploadHeaders = {
	'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
};
editor.create();

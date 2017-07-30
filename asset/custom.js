jQuery(document).ready(function($) {
	
	var thumbs = [];
	$('.cloud-zoom-gallery').each(function() {
		thumbs.push(this);
	});
	$('.cloud-zoom-gallery').on('click', function() {
		//if($.inArray(this, thumbs)===-1) thumbs.push(this);
		for(var i=0;i<thumbs.length;i++) $(thumbs[i]).closest('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
	/*var $thumbnailsContainer, $thumbnails,$productImages, addCloudZoom;

    $('a.zoom').unbind('click.fb');
    $thumbnailsContainer = '.product-thumb';
    $thumbnails = $('a', $thumbnailsContainer);

    $productImages = $('.woocommerce-product-gallery__image img');
    addCloudZoom = function(el){

        el.addClass('cloud-zoom').CloudZoom();

    }

    if($thumbnails.length){
        $thumbnails.unbind('click');
        
        $thumbnails.bind('click',function(){
            var $image = $(this).clone(false);
            $image.insertAfter($productImages);
            $productImages.remove();
            $productImages = $image;
            $('.mousetrap').remove();
            addCloudZoom($productImages);

            return false;

        })

    }
    addCloudZoom($productImages);*/
});
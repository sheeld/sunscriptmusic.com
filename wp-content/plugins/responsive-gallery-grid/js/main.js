/*
    Gallery Grid Main Script
    (c) 2013 bdwm.be
    For any questions please email me at jules@bdwm.be
    Version: 1.3
*/

jQuery(document).ready(function(){
    
    var mobile =  /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
    var scale = parseFloat(rgg_params[0].scale) || 1.0;
    var intime = parseFloat(rgg_params[0].intime) || 100;
    var outtime = parseFloat(rgg_params[0].outtime) || 100;
    
    if(!mobile) {
        
        if (jQuery().colorbox) {
            jQuery('.rgg-imagegrid a').colorbox();
        }
        
        // create copies from the images as placeholders to be used by imagegrid
        jQuery('.rgg-imagegrid img').each(function() {
            var $this = jQuery(this);
            var offset = $this.position();
            $this.clone().addClass('rgg-placeholder').css({ visibility : 'hidden' }).appendTo($this.parent());
            $this.css({ left:offset.left, top:offset.top, position: 'absolute', 'max-width' : 'none' }).addClass('rgg-img');
        });
    
        jQuery('.rgg-imagegrid').each(function() {
            
            $this = jQuery(this);
            var id = parseInt($this.attr('rgg_id'));
            var p = rgg_params[id-1];
            p.scale = parseFloat(p.scale) || 1.0;
            
            jQuery('a', this).each(function() {
               // TODO: save all calculated values in array, each time the window is resized.
            });
            
            jQuery('a', this).mouseenter(function() {
                var $clone = jQuery('.rgg-img', this);
                var $placeholder = $clone.siblings('.rgg-placeholder').eq(0);
                
                var $caption = jQuery('.rgg-caption', this);
                var $innercaption = jQuery('.rgg-inner-caption', this);
                                
                $clone.unbind('mouseleave');
                
                var width = $placeholder.width();
                var caption_width = $placeholder.outerWidth();
                var innercaption_padding = parseInt($innercaption.css('padding-left'));
                var height = $placeholder.height();
                var offset = $placeholder.position();
                
                var newwidth = width*p.scale;
                var caption_newwidth = (caption_width - width) + width*p.scale;
                var innercaption_newpadding = (newwidth - width)/2 + innercaption_padding;
                var newheight = height*p.scale;
                var newoffset = { top: offset.top - (newheight-height)/2, left: offset.left - (newwidth-width)/2 };
                var zindex = $clone.css('z-index');
                var newzindex = 999;
                
                $clone.css({'z-index': newzindex});
                $clone.animate({ left: newoffset.left, top: newoffset.top, height: newheight, width: newwidth },p.intime);
                
                $caption.css({ 'z-index': newzindex+1 });
                $caption.animate({left: newoffset.left, width: caption_newwidth, bottom: 0 - (newheight-height)/2 + p.margin}, p.intime);
                $innercaption.animate({'padding-left':innercaption_newpadding, 'padding-right':innercaption_newpadding}, p.intime);
                
                $hyperlink = $clone.parent();
                $hyperlink.mouseleave(function() {  
                    $clone.css({'z-index': 'auto'});         
                    $clone.animate({ left: offset.left, top: offset.top, height: height, width: width, 'z-index' : zindex }, p.outtime);
                    
                    $caption.css({ 'z-index': 'auto' });
                    $caption.animate({ left: offset.left, bottom: p.margin, width: caption_width }, p.outtime);
                    $innercaption.animate({'padding-left':innercaption_padding, 'padding-right':innercaption_padding}, p.outtime);
                    
                    $hyperlink.unbind('mouseleave');
                });
            });
        });
        
    } else {
        
        // if mobile
        jQuery('.rgg-imagegrid img').addClass('rgg-placeholder');
    }
    
    jQuery('.rgg-imagegrid').each(function() {
        $this = jQuery(this);
        var id = parseInt($this.attr('rgg_id'));
        var p = rgg_params[id-1];
        
        $this.gallerygrid({
            'maxrowheight' :  parseInt(p.maxrowheight) || 20,
            'margin' :        parseInt(p.margin) || 0,
            'items' : '.rgg-placeholder',
            'after_init' : function() { },
            'before' : function() { },
            'after' : function() {
                if (!mobile) {
                    jQuery('.rgg-placeholder').each(function() {
                        // update position of the absolute clones based on their sibling placeholder
                        $placeholder = jQuery(this);
                        $clone = $placeholder.siblings('.rgg-img').eq(0);
                        $caption = $placeholder.siblings('.rgg-caption').eq(0);
                        var offset = $placeholder.position();
                        
                        $clone.css({ left:offset.left, top:offset.top, position: 'absolute', width: $placeholder.width(), height: $placeholder.height() });
                        $caption.css({ bottom: p.margin, width: $placeholder.outerWidth() });
                    });
                }
            }
        });
    });    
});
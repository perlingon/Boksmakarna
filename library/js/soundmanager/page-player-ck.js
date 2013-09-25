/**
 * SoundManager 2 Demo: "Page as playlist" UI
 * ----------------------------------------------
 * http://schillmania.com/projects/soundmanager2/
 *
 * An example of a Muxtape.com-style UI, where an
 * unordered list of MP3 links becomes a playlist
 *
 * Flash 9 "MovieStar" edition supports MPEG4
 * audio as well.
 *
 * Requires SoundManager 2 Javascript API.
 *//*jslint white: false, onevar: true, undef: true, nomen: false, eqeqeq: true, plusplus: false, bitwise: true, newcap: true, immed: true *//*global soundManager, window, document, navigator, setTimeout, attachEvent, Metadata, PP_CONFIG */function PagePlayer(){var e=this,t=this,n=soundManager,r,i=null,s=null,o=document.getElementsByTagName("head")[0],u=null,a=navigator.userAgent,f=a.match(/(opera|firefox)/i),l=a.match(/ipad|ipod|iphone/i),c;this.config={usePeakData:!1,useWaveformData:!1,useEQData:!1,fillGraph:!1,allowRightClick:!0,useThrottling:!0,autoStart:!1,playNext:!0,updatePageTitle:!1,emptyTime:"-:--",useFavIcon:!1};this.css={sDefault:"sm2_link",sLoading:"sm2_loading",sPlaying:"sm2_playing",sPaused:"sm2_paused"};this.sounds=[];this.soundsByObject=[];this.lastSound=null;this.soundCount=0;this.strings=[];this.dragActive=!1;this.dragExec=new Date;this.dragTimer=null;this.pageTitle=document.title;this.lastWPExec=new Date;this.lastWLExec=new Date;this.vuMeterData=[];this.oControls=null;this._mergeObjects=function(e,t){var n={},r,i,s;for(i in e)e.hasOwnProperty(i)&&(n[i]=e[i]);r=typeof t=="undefined"?{}:t;for(s in r)typeof n[s]=="undefined"&&(n[s]=r[s]);return n};r=function(){function r(n){var r=t.call(n),i=r.length;if(e){r[1]="on"+r[1];i>3&&r.pop()}else i===3&&r.push(!1);return r}function i(t,r){var i=t.shift(),s=[n[r]];e?i[s](t[0],t[1]):i[s].apply(i,t)}function s(){i(r(arguments),"add")}function o(){i(r(arguments),"remove")}var e=window.attachEvent&&!window.addEventListener,t=Array.prototype.slice,n={add:e?"attachEvent":"addEventListener",remove:e?"detachEvent":"removeEventListener"};return{add:s,remove:o}}();this.hasClass=function(e,t){return typeof e.className!="undefined"?(new RegExp("(^|\\s)"+t+"(\\s|$)")).test(e.className):!1};this.addClass=function(t,n){if(!t||!n||e.hasClass(t,n))return!1;t.className=(t.className?t.className+" ":"")+n};this.removeClass=function(t,n){if(!t||!n||!e.hasClass(t,n))return!1;t.className=t.className.replace(new RegExp("( "+n+")|("+n+")","g"),"")};this.select=function(t,n){var r=e.getByClassName(t,"div",n||null);return r?r[0]:null};this.getByClassName=document.querySelectorAll?function(e,t,n){var r="."+e,i;t&&(t=t.split(" "));i=t.length>1?t.join(r+", "):t[0]+r;return(n?n:document).querySelectorAll(i)}:function(t,n,r){var i=r?r:document,s=[],o,u,a=[];n&&(n=n.split(" "));if(n instanceof Array){for(o=n.length;o--;)if(!a||!a[n[o]])a[n[o]]=i.getElementsByTagName(n[o]);for(o=n.length;o--;)for(u=a[n[o]].length;u--;)e.hasClass(a[n[o]][u],t)&&s.push(a[n[o]][u])}else{a=i.all||i.getElementsByTagName("*");for(o=0,u=a.length;o<u;o++)e.hasClass(a[o],t)&&s.push(a[o])}return s};this.isChildOfClass=function(t,n){if(!t||!n)return!1;while(t.parentNode&&!e.hasClass(t,n))t=t.parentNode;return e.hasClass(t,n)};this.getParentByNodeName=function(e,t){if(!e||!t)return!1;t=t.toLowerCase();while(e.parentNode&&t!==e.parentNode.nodeName.toLowerCase())e=e.parentNode;return e.parentNode&&t===e.parentNode.nodeName.toLowerCase()?e.parentNode:null};this.getOffX=function(e){var t=0;if(e.offsetParent)while(e.offsetParent){t+=e.offsetLeft;e=e.offsetParent}else e.x&&(t+=e.x);return t};this.getTime=function(e,t){var n=Math.floor(e/1e3),r=Math.floor(n/60),i=n-r*60;return t?r+":"+(i<10?"0"+i:i):{min:r,sec:i}};this.getSoundByObject=function(t){return typeof e.soundsByObject[t.id]!="undefined"?e.soundsByObject[t.id]:null};this.getPreviousItem=function(e){if(e.previousElementSibling)e=e.previousElementSibling;else{e=e.previousSibling;while(e&&e.previousSibling&&e.previousSibling.nodeType!==1)e=e.previousSibling}return e.nodeName.toLowerCase()!=="li"?null:e.getElementsByTagName("a")[0]};this.playPrevious=function(n){n||(n=e.lastSound);if(!n)return!1;var r=e.getPreviousItem(n._data.oLI);r&&t.handleClick({target:r});return r};this.getNextItem=function(e){if(e.nextElementSibling)e=e.nextElementSibling;else{e=e.nextSibling;while(e&&e.nextSibling&&e.nextSibling.nodeType!==1)e=e.nextSibling}return e.nodeName.toLowerCase()!=="li"?null:e.getElementsByTagName("a")[0]};this.playNext=function(n){n||(n=e.lastSound);if(!n)return!1;var r=e.getNextItem(n._data.oLI);r&&t.handleClick({target:r});return r};this.setPageTitle=function(t){if(!e.config.updatePageTitle)return!1;try{document.title=(t?t+" - ":"")+e.pageTitle}catch(n){e.setPageTitle=function(){return!1}}};this.events={play:function(){t.removeClass(this._data.oLI,this._data.className);this._data.className=t.css.sPlaying;t.addClass(this._data.oLI,this._data.className);e.setPageTitle(this._data.originalTitle)},stop:function(){t.removeClass(this._data.oLI,this._data.className);this._data.className="";this._data.oPosition.style.width="0px";e.setPageTitle();e.resetPageIcon()},pause:function(){if(t.dragActive)return!1;t.removeClass(this._data.oLI,this._data.className);this._data.className=t.css.sPaused;t.addClass(this._data.oLI,this._data.className);e.setPageTitle();e.resetPageIcon()},resume:function(){if(t.dragActive)return!1;t.removeClass(this._data.oLI,this._data.className);this._data.className=t.css.sPlaying;t.addClass(this._data.oLI,this._data.className)},finish:function(){t.removeClass(this._data.oLI,this._data.className);this._data.className="";this._data.oPosition.style.width="0px";if(e.config.playNext)t.playNext(this);else{e.setPageTitle();e.resetPageIcon()}},whileloading:function(){function n(){this._data.oLoading.style.width=this.bytesLoaded/this.bytesTotal*100+"%";if(!this._data.didRefresh&&this._data.metadata){this._data.didRefresh=!0;this._data.metadata.refresh()}}if(!t.config.useThrottling)n.apply(this);else{var r=new Date;if(r&&r-e.lastWLExec>50||this.bytesLoaded===this.bytesTotal){n.apply(this);e.lastWLExec=r}}},onload:function(){if(!this.loaded){var e=this._data.oLI.getElementsByTagName("a")[0],t=e.innerHTML,r=this;e.innerHTML=t+' <span style="font-size:0.5em"> | Load failed, d\'oh! '+(n.sandbox.noRemote?" Possible cause: Flash sandbox is denying remote URL access.":n.sandbox.noLocal?"Flash denying local filesystem access":"404?")+"</span>";setTimeout(function(){e.innerHTML=t},5e3)}else this._data.metadata&&this._data.metadata.refresh()},whileplaying:function(){var r=null;if(t.dragActive||!t.config.useThrottling){e.updateTime.apply(this);if(n.flashVersion>=9){t.config.usePeakData&&this.instanceOptions.usePeakData&&e.updatePeaks.apply(this);(t.config.useWaveformData&&this.instanceOptions.useWaveformData||t.config.useEQData&&this.instanceOptions.useEQData)&&e.updateGraph.apply(this)}if(this._data.metadata){r=new Date;if(r&&r-e.lastWPExec>500){this._data.metadata.refreshMetadata(this);e.lastWPExec=r}}this._data.oPosition.style.width=this.position/e.getDurationEstimate(this)*100+"%"}else{r=new Date;if(r-e.lastWPExec>30){e.updateTime.apply(this);if(n.flashVersion>=9){t.config.usePeakData&&this.instanceOptions.usePeakData&&e.updatePeaks.apply(this);(t.config.useWaveformData&&this.instanceOptions.useWaveformData||t.config.useEQData&&this.instanceOptions.useEQData)&&e.updateGraph.apply(this)}this._data.metadata&&this._data.metadata.refreshMetadata(this);this._data.oPosition.style.width=this.position/e.getDurationEstimate(this)*100+"%";e.lastWPExec=r}}}};this.setPageIcon=function(t){if(!e.config.useFavIcon||!e.config.usePeakData||!t)return!1;var n=document.getElementById("sm2-favicon");if(n){o.removeChild(n);n=null}if(!n){n=document.createElement("link");n.id="sm2-favicon";n.rel="shortcut icon";n.type="image/png";n.href=t;document.getElementsByTagName("head")[0].appendChild(n)}};this.resetPageIcon=function(){if(!e.config.useFavIcon)return!1;var t=document.getElementById("favicon");t&&(t.href="/favicon.ico")};this.updatePeaks=function(){var t=this._data.oPeak,r=t.getElementsByTagName("span");r[0].style.marginTop=13-Math.floor(15*this.peakData.left)+"px";r[1].style.marginTop=13-Math.floor(15*this.peakData.right)+"px";n.flashVersion>8&&e.config.useFavIcon&&e.config.usePeakData&&e.setPageIcon(e.vuMeterData[parseInt(16*this.peakData.left,10)][parseInt(16*this.peakData.right,10)])};this.updateGraph=function(){if(t.config.flashVersion<9||!t.config.useWaveformData&&!t.config.useEQData)return!1;var e=this._data.oGraph.getElementsByTagName("div"),n,r,i;if(t.config.useWaveformData){n=8;for(r=255;r--;)e[255-r].style.marginTop=1+n+Math.ceil(this.waveformData.left[r]*-n)+"px"}else{i=9;for(r=255;r--;)e[255-r].style.marginTop=i*2-1+Math.ceil(this.eqData[r]*-i)+"px"}};this.resetGraph=function(){if(!t.config.useEQData||t.config.flashVersion<9)return!1;var e=this._data.oGraph.getElementsByTagName("div"),n=t.config.useEQData?"17px":"9px",r=t.config.fillGraph?"32px":"1px",i;for(i=255;i--;){e[255-i].style.marginTop=n;e[255-i].style.height=r}};this.updateTime=function(){var t=e.strings.timing.replace("%s1",e.getTime(this.position,!0));t=t.replace("%s2",e.getTime(e.getDurationEstimate(this),!0));this._data.oTiming.innerHTML=t};this.getTheDamnTarget=function(e){return e.target||(window.event?window.event.srcElement:null)};this.withinStatusBar=function(t){return e.isChildOfClass(t,"playlist")&&e.isChildOfClass(t,"controls")};this.handleClick=function(r){if(r.button===2){t.config.allowRightClick||t.stopEvent(r);return t.config.allowRightClick}var i=e.getTheDamnTarget(r),s,o,a,f,l,c;if(!i)return!0;e.dragActive&&e.stopDrag();if(e.withinStatusBar(i))return!1;i.nodeName.toLowerCase()!=="a"&&(i=e.getParentByNodeName(i,"a"));if(!i)return!0;s=i.getAttribute("href");if(!i.href||!n.canPlayLink(i)&&!e.hasClass(i,"playable")||e.hasClass(i,"exclude"))return!0;e.initUL(e.getParentByNodeName(i,"ul"));e.initItem(i);o=i.href;a=e.getSoundByObject(i);if(a){e.setPageTitle(a._data.originalTitle);if(a===e.lastSound)a.readyState!==2?a.playState!==1?a.play():a.togglePause():n._writeDebug("Warning: sound failed to load (security restrictions, 404 or bad format)",2);else{e.lastSound&&e.stopSound(e.lastSound);u&&a._data.oTimingBox.appendChild(u);a.togglePause()}}else{a=n.createSound({id:i.id,url:decodeURI(o),onplay:e.events.play,onstop:e.events.stop,onpause:e.events.pause,onresume:e.events.resume,onfinish:e.events.finish,type:i.type||null,whileloading:e.events.whileloading,whileplaying:e.events.whileplaying,onmetadata:e.events.metadata,onload:e.events.onload});f=e.oControls.cloneNode(!0);l=i.parentNode;l.appendChild(f);u&&l.appendChild(u);e.soundsByObject[i.id]=a;a._data={oLink:i,oLI:l,oControls:e.select("controls",l),oStatus:e.select("statusbar",l),oLoading:e.select("loading",l),oPosition:e.select("position",l),oTimingBox:e.select("timing",l),oTiming:e.select("timing",l).getElementsByTagName("div")[0],oPeak:e.select("peak",l),oGraph:e.select("spectrum-box",l),className:e.css.sPlaying,originalTitle:i.innerHTML,metadata:null};u&&a._data.oTimingBox.appendChild(u);a._data.oLI.getElementsByTagName("ul").length&&(a._data.metadata=new Metadata(a));c=e.strings.timing.replace("%s1",e.config.emptyTime);c=c.replace("%s2",e.config.emptyTime);a._data.oTiming.innerHTML=c;e.sounds.push(a);e.lastSound&&e.stopSound(e.lastSound);e.resetGraph.apply(a);a.play()}e.lastSound=a;return e.stopEvent(r)};this.handleMouseDown=function(n){l&&n.touches&&(n=n.touches[0]);if(n.button===2){t.config.allowRightClick||t.stopEvent(n);return t.config.allowRightClick}var i=e.getTheDamnTarget(n);if(!i)return!0;if(!e.withinStatusBar(i))return!0;e.dragActive=!0;e.lastSound.pause();e.setPosition(n);l?r.add(document,"touchmove",e.handleMouseMove):r.add(document,"mousemove",e.handleMouseMove);e.addClass(e.lastSound._data.oControls,"dragging");return e.stopEvent(n)};this.handleMouseMove=function(t){l&&t.touches&&(t=t.touches[0]);if(e.dragActive)if(e.config.useThrottling){var n=new Date;if(n-e.dragExec>20)e.setPosition(t);else{window.clearTimeout(e.dragTimer);e.dragTimer=window.setTimeout(function(){e.setPosition(t)},20)}e.dragExec=n}else e.setPosition(t);else e.stopDrag();t.stopPropagation=!0;return!1};this.stopDrag=function(n){if(e.dragActive){e.removeClass(e.lastSound._data.oControls,"dragging");l?r.remove(document,"touchmove",e.handleMouseMove):r.remove(document,"mousemove",e.handleMouseMove);t.hasClass(e.lastSound._data.oLI,e.css.sPaused)||e.lastSound.resume();e.dragActive=!1;return e.stopEvent(n)}};this.handleStatusClick=function(n){e.setPosition(n);t.hasClass(e.lastSound._data.oLI,e.css.sPaused)||e.resume();return e.stopEvent(n)};this.stopEvent=function(e){if(typeof e!="undefined")if(typeof e.preventDefault!="undefined")e.preventDefault();else{e.stopPropagation=!0;e.returnValue=!1}return!1};this.setPosition=function(t){var n=e.getTheDamnTarget(t),r,i,s,o;if(!n)return!0;i=n;while(!e.hasClass(i,"controls")&&i.parentNode)i=i.parentNode;s=e.lastSound;r=parseInt(t.clientX,10);o=Math.floor((r-e.getOffX(i)-4)/i.offsetWidth*e.getDurationEstimate(s));isNaN(o)||(o=Math.min(o,s.duration));isNaN(o)||s.setPosition(o)};this.stopSound=function(e){n._writeDebug("stopping sound: "+e.id);n.stop(e.id);l||n.unload(e.id)};this.getDurationEstimate=function(e){return e.instanceOptions.isMovieStar?e.duration:!e._data.metadata||!e._data.metadata.data.givenDuration?e.durationEstimate||0:e._data.metadata.data.givenDuration};this.createVUData=function(){var t=0,n=0,r=i.getContext("2d"),s=r.createLinearGradient(0,16,0,0),o,u;s.addColorStop(0,"rgb(0,192,0)");s.addColorStop(.3,"rgb(0,255,0)");s.addColorStop(.625,"rgb(255,255,0)");s.addColorStop(.85,"rgb(255,0,0)");o=r.createLinearGradient(0,16,0,0);u="rgba(0,0,0,0.2)";o.addColorStop(0,u);o.addColorStop(1,"rgba(0,0,0,0.5)");for(t=0;t<16;t++)e.vuMeterData[t]=[];for(t=0;t<16;t++)for(n=0;n<16;n++){i.setAttribute("width",16);i.setAttribute("height",16);r.fillStyle=o;r.fillRect(0,0,7,15);r.fillRect(8,0,7,15);r.fillStyle=s;r.fillRect(0,15-t,7,16-(16-t));r.fillRect(8,15-n,7,16-(16-n));r.clearRect(0,3,16,1);r.clearRect(0,7,16,1);r.clearRect(0,11,16,1);e.vuMeterData[t][n]=i.toDataURL("image/png")}};this.testCanvas=function(){var e=document.createElement("canvas"),t=null,n;if(!e||typeof e.getContext=="undefined")return null;t=e.getContext("2d");if(!t||typeof e.toDataURL!="function")return null;try{n=e.toDataURL("image/png")}catch(r){return null}return e};this.initItem=function(t){t.id||(t.id="pagePlayerMP3Sound"+e.soundCount++);e.addClass(t,e.css.sDefault)};this.initUL=function(t){n.flashVersion>=9&&e.addClass(t,e.cssBase)};this.init=function(o){function g(t){r[t](document,"click",e.handleClick);if(!l){r[t](document,"mousedown",e.handleMouseDown);r[t](document,"mouseup",e.stopDrag)}else{r[t](document,"touchstart",e.handleMouseDown);r[t](document,"touchend",e.stopDrag)}r[t](window,"unload",c)}if(o){n._writeDebug("pagePlayer.init(): Using custom configuration");this.config=this._mergeObjects(o,this.config)}else n._writeDebug("pagePlayer.init(): Using default configuration");var a,h,p,d,v,m;this.cssBase=[];n.useFlashBlock=!0;if(n.flashVersion>=9){n.defaultOptions.usePeakData=this.config.usePeakData;n.defaultOptions.useWaveformData=this.config.useWaveformData;n.defaultOptions.useEQData=this.config.useEQData;this.config.usePeakData&&this.cssBase.push("use-peak");(this.config.useWaveformData||this.config.useEQData)&&this.cssBase.push("use-spectrum");this.cssBase=this.cssBase.join(" ");if(this.config.useFavIcon){i=e.testCanvas();i&&f?e.createVUData():this.config.useFavIcon=!1}}else(this.config.usePeakData||this.config.useWaveformData||this.config.useEQData)&&n._writeDebug("Page player: Note: soundManager.flashVersion = 9 is required for peak/waveform/EQ features.");s=document.createElement("div");s.innerHTML=['  <div class="controls">','   <div class="statusbar">','    <div class="loading"></div>','    <div class="position"></div>',"   </div>","  </div>",'  <div class="timing">','   <div id="sm2_timing" class="timing-data">','    <span class="sm2_position">%s1</span> / <span class="sm2_total">%s2</span>',"   </div>","  </div>",'  <div class="peak">','   <div class="peak-box"><span class="l"></span><span class="r"></span></div>',"  </div>",' <div class="spectrum-container">','  <div class="spectrum-box">','   <div class="spectrum"></div>',"  </div>"," </div>"].join("\n");if(n.flashVersion>=9){u=e.select("spectrum-container",s);u=s.removeChild(u);h=e.select("spectrum-box",u);p=h.getElementsByTagName("div")[0];d=document.createDocumentFragment();v=null;for(a=256;a--;){v=p.cloneNode(!1);v.style.left=a+"px";d.appendChild(v)}h.removeChild(p);h.appendChild(d)}else{s.removeChild(e.select("spectrum-container",s));s.removeChild(e.select("peak",s))}e.oControls=s.cloneNode(!0);m=e.select("timing-data",s);e.strings.timing=m.innerHTML;m.innerHTML="";m.id="";c=function(){g("remove")};g("add");n._writeDebug("pagePlayer.init(): Ready",1);e.config.autoStart&&t.handleClick({target:t.getByClassName("playlist","ul")[0].getElementsByTagName("a")[0]})}}var pagePlayer=null;soundManager.setup({debugMode:!0,preferFlash:!1,useFlashBlock:!0,url:"/swf/",flashVersion:9});soundManager.onready(function(){pagePlayer=new PagePlayer;pagePlayer.init(typeof PP_CONFIG!="undefined"?PP_CONFIG:null)});
/* jQuery 1.7.2 */
(function(a,b){function cy(a){return f.isWindow(a)?a:a.nodeType===9?a.defaultView||a.parentWindow:!1}function cu(a){if(!cj[a]){var b=c.body,d=f("<"+a+">").appendTo(b),e=d.css("display");d.remove();if(e==="none"||e===""){ck||(ck=c.createElement("iframe"),ck.frameBorder=ck.width=ck.height=0),b.appendChild(ck);if(!cl||!ck.createElement)cl=(ck.contentWindow||ck.contentDocument).document,cl.write((f.support.boxModel?"<!doctype html>":"")+"<html><body>"),cl.close();d=cl.createElement(a),cl.body.appendChild(d),e=f.css(d,"display"),b.removeChild(ck)}cj[a]=e}return cj[a]}function ct(a,b){var c={};f.each(cp.concat.apply([],cp.slice(0,b)),function(){c[this]=a});return c}function cs(){cq=b}function cr(){setTimeout(cs,0);return cq=f.now()}function ci(){try{return new a.ActiveXObject("Microsoft.XMLHTTP")}catch(b){}}function ch(){try{return new a.XMLHttpRequest}catch(b){}}function cb(a,c){a.dataFilter&&(c=a.dataFilter(c,a.dataType));var d=a.dataTypes,e={},g,h,i=d.length,j,k=d[0],l,m,n,o,p;for(g=1;g<i;g++){if(g===1)for(h in a.converters)typeof h=="string"&&(e[h.toLowerCase()]=a.converters[h]);l=k,k=d[g];if(k==="*")k=l;else if(l!=="*"&&l!==k){m=l+" "+k,n=e[m]||e["* "+k];if(!n){p=b;for(o in e){j=o.split(" ");if(j[0]===l||j[0]==="*"){p=e[j[1]+" "+k];if(p){o=e[o],o===!0?n=p:p===!0&&(n=o);break}}}}!n&&!p&&f.error("No conversion from "+m.replace(" "," to ")),n!==!0&&(c=n?n(c):p(o(c)))}}return c}function ca(a,c,d){var e=a.contents,f=a.dataTypes,g=a.responseFields,h,i,j,k;for(i in g)i in d&&(c[g[i]]=d[i]);while(f[0]==="*")f.shift(),h===b&&(h=a.mimeType||c.getResponseHeader("content-type"));if(h)for(i in e)if(e[i]&&e[i].test(h)){f.unshift(i);break}if(f[0]in d)j=f[0];else{for(i in d){if(!f[0]||a.converters[i+" "+f[0]]){j=i;break}k||(k=i)}j=j||k}if(j){j!==f[0]&&f.unshift(j);return d[j]}}function b_(a,b,c,d){if(f.isArray(b))f.each(b,function(b,e){c||bD.test(a)?d(a,e):b_(a+"["+(typeof e=="object"?b:"")+"]",e,c,d)});else if(!c&&f.type(b)==="object")for(var e in b)b_(a+"["+e+"]",b[e],c,d);else d(a,b)}function b$(a,c){var d,e,g=f.ajaxSettings.flatOptions||{};for(d in c)c[d]!==b&&((g[d]?a:e||(e={}))[d]=c[d]);e&&f.extend(!0,a,e)}function bZ(a,c,d,e,f,g){f=f||c.dataTypes[0],g=g||{},g[f]=!0;var h=a[f],i=0,j=h?h.length:0,k=a===bS,l;for(;i<j&&(k||!l);i++)l=h[i](c,d,e),typeof l=="string"&&(!k||g[l]?l=b:(c.dataTypes.unshift(l),l=bZ(a,c,d,e,l,g)));(k||!l)&&!g["*"]&&(l=bZ(a,c,d,e,"*",g));return l}function bY(a){return function(b,c){typeof b!="string"&&(c=b,b="*");if(f.isFunction(c)){var d=b.toLowerCase().split(bO),e=0,g=d.length,h,i,j;for(;e<g;e++)h=d[e],j=/^\+/.test(h),j&&(h=h.substr(1)||"*"),i=a[h]=a[h]||[],i[j?"unshift":"push"](c)}}}function bB(a,b,c){var d=b==="width"?a.offsetWidth:a.offsetHeight,e=b==="width"?1:0,g=4;if(d>0){if(c!=="border")for(;e<g;e+=2)c||(d-=parseFloat(f.css(a,"padding"+bx[e]))||0),c==="margin"?d+=parseFloat(f.css(a,c+bx[e]))||0:d-=parseFloat(f.css(a,"border"+bx[e]+"Width"))||0;return d+"px"}d=by(a,b);if(d<0||d==null)d=a.style[b];if(bt.test(d))return d;d=parseFloat(d)||0;if(c)for(;e<g;e+=2)d+=parseFloat(f.css(a,"padding"+bx[e]))||0,c!=="padding"&&(d+=parseFloat(f.css(a,"border"+bx[e]+"Width"))||0),c==="margin"&&(d+=parseFloat(f.css(a,c+bx[e]))||0);return d+"px"}function bo(a){var b=c.createElement("div");bh.appendChild(b),b.innerHTML=a.outerHTML;return b.firstChild}function bn(a){var b=(a.nodeName||"").toLowerCase();b==="input"?bm(a):b!=="script"&&typeof a.getElementsByTagName!="undefined"&&f.grep(a.getElementsByTagName("input"),bm)}function bm(a){if(a.type==="checkbox"||a.type==="radio")a.defaultChecked=a.checked}function bl(a){return typeof a.getElementsByTagName!="undefined"?a.getElementsByTagName("*"):typeof a.querySelectorAll!="undefined"?a.querySelectorAll("*"):[]}function bk(a,b){var c;b.nodeType===1&&(b.clearAttributes&&b.clearAttributes(),b.mergeAttributes&&b.mergeAttributes(a),c=b.nodeName.toLowerCase(),c==="object"?b.outerHTML=a.outerHTML:c!=="input"||a.type!=="checkbox"&&a.type!=="radio"?c==="option"?b.selected=a.defaultSelected:c==="input"||c==="textarea"?b.defaultValue=a.defaultValue:c==="script"&&b.text!==a.text&&(b.text=a.text):(a.checked&&(b.defaultChecked=b.checked=a.checked),b.value!==a.value&&(b.value=a.value)),b.removeAttribute(f.expando),b.removeAttribute("_submit_attached"),b.removeAttribute("_change_attached"))}function bj(a,b){if(b.nodeType===1&&!!f.hasData(a)){var c,d,e,g=f._data(a),h=f._data(b,g),i=g.events;if(i){delete h.handle,h.events={};for(c in i)for(d=0,e=i[c].length;d<e;d++)f.event.add(b,c,i[c][d])}h.data&&(h.data=f.extend({},h.data))}}function bi(a,b){return f.nodeName(a,"table")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function U(a){var b=V.split("|"),c=a.createDocumentFragment();if(c.createElement)while(b.length)c.createElement(b.pop());return c}function T(a,b,c){b=b||0;if(f.isFunction(b))return f.grep(a,function(a,d){var e=!!b.call(a,d,a);return e===c});if(b.nodeType)return f.grep(a,function(a,d){return a===b===c});if(typeof b=="string"){var d=f.grep(a,function(a){return a.nodeType===1});if(O.test(b))return f.filter(b,d,!c);b=f.filter(b,d)}return f.grep(a,function(a,d){return f.inArray(a,b)>=0===c})}function S(a){return!a||!a.parentNode||a.parentNode.nodeType===11}function K(){return!0}function J(){return!1}function n(a,b,c){var d=b+"defer",e=b+"queue",g=b+"mark",h=f._data(a,d);h&&(c==="queue"||!f._data(a,e))&&(c==="mark"||!f._data(a,g))&&setTimeout(function(){!f._data(a,e)&&!f._data(a,g)&&(f.removeData(a,d,!0),h.fire())},0)}function m(a){for(var b in a){if(b==="data"&&f.isEmptyObject(a[b]))continue;if(b!=="toJSON")return!1}return!0}function l(a,c,d){if(d===b&&a.nodeType===1){var e="data-"+c.replace(k,"-$1").toLowerCase();d=a.getAttribute(e);if(typeof d=="string"){try{d=d==="true"?!0:d==="false"?!1:d==="null"?null:f.isNumeric(d)?+d:j.test(d)?f.parseJSON(d):d}catch(g){}f.data(a,c,d)}else d=b}return d}function h(a){var b=g[a]={},c,d;a=a.split(/\s+/);for(c=0,d=a.length;c<d;c++)b[a[c]]=!0;return b}var c=a.document,d=a.navigator,e=a.location,f=function(){function J(){if(!e.isReady){try{c.documentElement.doScroll("left")}catch(a){setTimeout(J,1);return}e.ready()}}var e=function(a,b){return new e.fn.init(a,b,h)},f=a.jQuery,g=a.$,h,i=/^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,j=/\S/,k=/^\s+/,l=/\s+$/,m=/^<(\w+)\s*\/?>(?:<\/\1>)?$/,n=/^[\],:{}\s]*$/,o=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,p=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,q=/(?:^|:|,)(?:\s*\[)+/g,r=/(webkit)[ \/]([\w.]+)/,s=/(opera)(?:.*version)?[ \/]([\w.]+)/,t=/(msie) ([\w.]+)/,u=/(mozilla)(?:.*? rv:([\w.]+))?/,v=/-([a-z]|[0-9])/ig,w=/^-ms-/,x=function(a,b){return(b+"").toUpperCase()},y=d.userAgent,z,A,B,C=Object.prototype.toString,D=Object.prototype.hasOwnProperty,E=Array.prototype.push,F=Array.prototype.slice,G=String.prototype.trim,H=Array.prototype.indexOf,I={};e.fn=e.prototype={constructor:e,init:function(a,d,f){var g,h,j,k;if(!a)return this;if(a.nodeType){this.context=this[0]=a,this.length=1;return this}if(a==="body"&&!d&&c.body){this.context=c,this[0]=c.body,this.selector=a,this.length=1;return this}if(typeof a=="string"){a.charAt(0)!=="<"||a.charAt(a.length-1)!==">"||a.length<3?g=i.exec(a):g=[null,a,null];if(g&&(g[1]||!d)){if(g[1]){d=d instanceof e?d[0]:d,k=d?d.ownerDocument||d:c,j=m.exec(a),j?e.isPlainObject(d)?(a=[c.createElement(j[1])],e.fn.attr.call(a,d,!0)):a=[k.createElement(j[1])]:(j=e.buildFragment([g[1]],[k]),a=(j.cacheable?e.clone(j.fragment):j.fragment).childNodes);return e.merge(this,a)}h=c.getElementById(g[2]);if(h&&h.parentNode){if(h.id!==g[2])return f.find(a);this.length=1,this[0]=h}this.context=c,this.selector=a;return this}return!d||d.jquery?(d||f).find(a):this.constructor(d).find(a)}if(e.isFunction(a))return f.ready(a);a.selector!==b&&(this.selector=a.selector,this.context=a.context);return e.makeArray(a,this)},selector:"",jquery:"1.7.2",length:0,size:function(){return this.length},toArray:function(){return F.call(this,0)},get:function(a){return a==null?this.toArray():a<0?this[this.length+a]:this[a]},pushStack:function(a,b,c){var d=this.constructor();e.isArray(a)?E.apply(d,a):e.merge(d,a),d.prevObject=this,d.context=this.context,b==="find"?d.selector=this.selector+(this.selector?" ":"")+c:b&&(d.selector=this.selector+"."+b+"("+c+")");return d},each:function(a,b){return e.each(this,a,b)},ready:function(a){e.bindReady(),A.add(a);return this},eq:function(a){a=+a;return a===-1?this.slice(a):this.slice(a,a+1)},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},slice:function(){return this.pushStack(F.apply(this,arguments),"slice",F.call(arguments).join(","))},map:function(a){return this.pushStack(e.map(this,function(b,c){return a.call(b,c,b)}))},end:function(){return this.prevObject||this.constructor(null)},push:E,sort:[].sort,splice:[].splice},e.fn.init.prototype=e.fn,e.extend=e.fn.extend=function(){var a,c,d,f,g,h,i=arguments[0]||{},j=1,k=arguments.length,l=!1;typeof i=="boolean"&&(l=i,i=arguments[1]||{},j=2),typeof i!="object"&&!e.isFunction(i)&&(i={}),k===j&&(i=this,--j);for(;j<k;j++)if((a=arguments[j])!=null)for(c in a){d=i[c],f=a[c];if(i===f)continue;l&&f&&(e.isPlainObject(f)||(g=e.isArray(f)))?(g?(g=!1,h=d&&e.isArray(d)?d:[]):h=d&&e.isPlainObject(d)?d:{},i[c]=e.extend(l,h,f)):f!==b&&(i[c]=f)}return i},e.extend({noConflict:function(b){a.$===e&&(a.$=g),b&&a.jQuery===e&&(a.jQuery=f);return e},isReady:!1,readyWait:1,holdReady:function(a){a?e.readyWait++:e.ready(!0)},ready:function(a){if(a===!0&&!--e.readyWait||a!==!0&&!e.isReady){if(!c.body)return setTimeout(e.ready,1);e.isReady=!0;if(a!==!0&&--e.readyWait>0)return;A.fireWith(c,[e]),e.fn.trigger&&e(c).trigger("ready").off("ready")}},bindReady:function(){if(!A){A=e.Callbacks("once memory");if(c.readyState==="complete")return setTimeout(e.ready,1);if(c.addEventListener)c.addEventListener("DOMContentLoaded",B,!1),a.addEventListener("load",e.ready,!1);else if(c.attachEvent){c.attachEvent("onreadystatechange",B),a.attachEvent("onload",e.ready);var b=!1;try{b=a.frameElement==null}catch(d){}c.documentElement.doScroll&&b&&J()}}},isFunction:function(a){return e.type(a)==="function"},isArray:Array.isArray||function(a){return e.type(a)==="array"},isWindow:function(a){return a!=null&&a==a.window},isNumeric:function(a){return!isNaN(parseFloat(a))&&isFinite(a)},type:function(a){return a==null?String(a):I[C.call(a)]||"object"},isPlainObject:function(a){if(!a||e.type(a)!=="object"||a.nodeType||e.isWindow(a))return!1;try{if(a.constructor&&!D.call(a,"constructor")&&!D.call(a.constructor.prototype,"isPrototypeOf"))return!1}catch(c){return!1}var d;for(d in a);return d===b||D.call(a,d)},isEmptyObject:function(a){for(var b in a)return!1;return!0},error:function(a){throw new Error(a)},parseJSON:function(b){if(typeof b!="string"||!b)return null;b=e.trim(b);if(a.JSON&&a.JSON.parse)return a.JSON.parse(b);if(n.test(b.replace(o,"@").replace(p,"]").replace(q,"")))return(new Function("return "+b))();e.error("Invalid JSON: "+b)},parseXML:function(c){if(typeof c!="string"||!c)return null;var d,f;try{a.DOMParser?(f=new DOMParser,d=f.parseFromString(c,"text/xml")):(d=new ActiveXObject("Microsoft.XMLDOM"),d.async="false",d.loadXML(c))}catch(g){d=b}(!d||!d.documentElement||d.getElementsByTagName("parsererror").length)&&e.error("Invalid XML: "+c);return d},noop:function(){},globalEval:function(b){b&&j.test(b)&&(a.execScript||function(b){a.eval.call(a,b)})(b)},camelCase:function(a){return a.replace(w,"ms-").replace(v,x)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toUpperCase()===b.toUpperCase()},each:function(a,c,d){var f,g=0,h=a.length,i=h===b||e.isFunction(a);if(d){if(i){for(f in a)if(c.apply(a[f],d)===!1)break}else for(;g<h;)if(c.apply(a[g++],d)===!1)break}else if(i){for(f in a)if(c.call(a[f],f,a[f])===!1)break}else for(;g<h;)if(c.call(a[g],g,a[g++])===!1)break;return a},trim:G?function(a){return a==null?"":G.call(a)}:function(a){return a==null?"":(a+"").replace(k,"").replace(l,"")},makeArray:function(a,b){var c=b||[];if(a!=null){var d=e.type(a);a.length==null||d==="string"||d==="function"||d==="regexp"||e.isWindow(a)?E.call(c,a):e.merge(c,a)}return c},inArray:function(a,b,c){var d;if(b){if(H)return H.call(b,a,c);d=b.length,c=c?c<0?Math.max(0,d+c):c:0;for(;c<d;c++)if(c in b&&b[c]===a)return c}return-1},merge:function(a,c){var d=a.length,e=0;if(typeof c.length=="number")for(var f=c.length;e<f;e++)a[d++]=c[e];else while(c[e]!==b)a[d++]=c[e++];a.length=d;return a},grep:function(a,b,c){var d=[],e;c=!!c;for(var f=0,g=a.length;f<g;f++)e=!!b(a[f],f),c!==e&&d.push(a[f]);return d},map:function(a,c,d){var f,g,h=[],i=0,j=a.length,k=a instanceof e||j!==b&&typeof j=="number"&&(j>0&&a[0]&&a[j-1]||j===0||e.isArray(a));if(k)for(;i<j;i++)f=c(a[i],i,d),f!=null&&(h[h.length]=f);else for(g in a)f=c(a[g],g,d),f!=null&&(h[h.length]=f);return h.concat.apply([],h)},guid:1,proxy:function(a,c){if(typeof c=="string"){var d=a[c];c=a,a=d}if(!e.isFunction(a))return b;var f=F.call(arguments,2),g=function(){return a.apply(c,f.concat(F.call(arguments)))};g.guid=a.guid=a.guid||g.guid||e.guid++;return g},access:function(a,c,d,f,g,h,i){var j,k=d==null,l=0,m=a.length;if(d&&typeof d=="object"){for(l in d)e.access(a,c,l,d[l],1,h,f);g=1}else if(f!==b){j=i===b&&e.isFunction(f),k&&(j?(j=c,c=function(a,b,c){return j.call(e(a),c)}):(c.call(a,f),c=null));if(c)for(;l<m;l++)c(a[l],d,j?f.call(a[l],l,c(a[l],d)):f,i);g=1}return g?a:k?c.call(a):m?c(a[0],d):h},now:function(){return(new Date).getTime()},uaMatch:function(a){a=a.toLowerCase();var b=r.exec(a)||s.exec(a)||t.exec(a)||a.indexOf("compatible")<0&&u.exec(a)||[];return{browser:b[1]||"",version:b[2]||"0"}},sub:function(){function a(b,c){return new a.fn.init(b,c)}e.extend(!0,a,this),a.superclass=this,a.fn=a.prototype=this(),a.fn.constructor=a,a.sub=this.sub,a.fn.init=function(d,f){f&&f instanceof e&&!(f instanceof a)&&(f=a(f));return e.fn.init.call(this,d,f,b)},a.fn.init.prototype=a.fn;var b=a(c);return a},browser:{}}),e.each("Boolean Number String Function Array Date RegExp Object".split(" "),function(a,b){I["[object "+b+"]"]=b.toLowerCase()}),z=e.uaMatch(y),z.browser&&(e.browser[z.browser]=!0,e.browser.version=z.version),e.browser.webkit&&(e.browser.safari=!0),j.test(" ")&&(k=/^[\s\xA0]+/,l=/[\s\xA0]+$/),h=e(c),c.addEventListener?B=function(){c.removeEventListener("DOMContentLoaded",B,!1),e.ready()}:c.attachEvent&&(B=function(){c.readyState==="complete"&&(c.detachEvent("onreadystatechange",B),e.ready())});return e}(),g={};f.Callbacks=function(a){a=a?g[a]||h(a):{};var c=[],d=[],e,i,j,k,l,m,n=function(b){var d,e,g,h,i;for(d=0,e=b.length;d<e;d++)g=b[d],h=f.type(g),h==="array"?n(g):h==="function"&&(!a.unique||!p.has(g))&&c.push(g)},o=function(b,f){f=f||[],e=!a.memory||[b,f],i=!0,j=!0,m=k||0,k=0,l=c.length;for(;c&&m<l;m++)if(c[m].apply(b,f)===!1&&a.stopOnFalse){e=!0;break}j=!1,c&&(a.once?e===!0?p.disable():c=[]:d&&d.length&&(e=d.shift(),p.fireWith(e[0],e[1])))},p={add:function(){if(c){var a=c.length;n(arguments),j?l=c.length:e&&e!==!0&&(k=a,o(e[0],e[1]))}return this},remove:function(){if(c){var b=arguments,d=0,e=b.length;for(;d<e;d++)for(var f=0;f<c.length;f++)if(b[d]===c[f]){j&&f<=l&&(l--,f<=m&&m--),c.splice(f--,1);if(a.unique)break}}return this},has:function(a){if(c){var b=0,d=c.length;for(;b<d;b++)if(a===c[b])return!0}return!1},empty:function(){c=[];return this},disable:function(){c=d=e=b;return this},disabled:function(){return!c},lock:function(){d=b,(!e||e===!0)&&p.disable();return this},locked:function(){return!d},fireWith:function(b,c){d&&(j?a.once||d.push([b,c]):(!a.once||!e)&&o(b,c));return this},fire:function(){p.fireWith(this,arguments);return this},fired:function(){return!!i}};return p};var i=[].slice;f.extend({Deferred:function(a){var b=f.Callbacks("once memory"),c=f.Callbacks("once memory"),d=f.Callbacks("memory"),e="pending",g={resolve:b,reject:c,notify:d},h={done:b.add,fail:c.add,progress:d.add,state:function(){return e},isResolved:b.fired,isRejected:c.fired,then:function(a,b,c){i.done(a).fail(b).progress(c);return this},always:function(){i.done.apply(i,arguments).fail.apply(i,arguments);return this},pipe:function(a,b,c){return f.Deferred(function(d){f.each({done:[a,"resolve"],fail:[b,"reject"],progress:[c,"notify"]},function(a,b){var c=b[0],e=b[1],g;f.isFunction(c)?i[a](function(){g=c.apply(this,arguments),g&&f.isFunction(g.promise)?g.promise().then(d.resolve,d.reject,d.notify):d[e+"With"](this===i?d:this,[g])}):i[a](d[e])})}).promise()},promise:function(a){if(a==null)a=h;else for(var b in h)a[b]=h[b];return a}},i=h.promise({}),j;for(j in g)i[j]=g[j].fire,i[j+"With"]=g[j].fireWith;i.done(function(){e="resolved"},c.disable,d.lock).fail(function(){e="rejected"},b.disable,d.lock),a&&a.call(i,i);return i},when:function(a){function m(a){return function(b){e[a]=arguments.length>1?i.call(arguments,0):b,j.notifyWith(k,e)}}function l(a){return function(c){b[a]=arguments.length>1?i.call(arguments,0):c,--g||j.resolveWith(j,b)}}var b=i.call(arguments,0),c=0,d=b.length,e=Array(d),g=d,h=d,j=d<=1&&a&&f.isFunction(a.promise)?a:f.Deferred(),k=j.promise();if(d>1){for(;c<d;c++)b[c]&&b[c].promise&&f.isFunction(b[c].promise)?b[c].promise().then(l(c),j.reject,m(c)):--g;g||j.resolveWith(j,b)}else j!==a&&j.resolveWith(j,d?[a]:[]);return k}}),f.support=function(){var b,d,e,g,h,i,j,k,l,m,n,o,p=c.createElement("div"),q=c.documentElement;p.setAttribute("className","t"),p.innerHTML="   <link/><table></table><a href='/a' style='top:1px;float:left;opacity:.55;'>a</a><input type='checkbox'/>",d=p.getElementsByTagName("*"),e=p.getElementsByTagName("a")[0];if(!d||!d.length||!e)return{};g=c.createElement("select"),h=g.appendChild(c.createElement("option")),i=p.getElementsByTagName("input")[0],b={leadingWhitespace:p.firstChild.nodeType===3,tbody:!p.getElementsByTagName("tbody").length,htmlSerialize:!!p.getElementsByTagName("link").length,style:/top/.test(e.getAttribute("style")),hrefNormalized:e.getAttribute("href")==="/a",opacity:/^0.55/.test(e.style.opacity),cssFloat:!!e.style.cssFloat,checkOn:i.value==="on",optSelected:h.selected,getSetAttribute:p.className!=="t",enctype:!!c.createElement("form").enctype,html5Clone:c.createElement("nav").cloneNode(!0).outerHTML!=="<:nav></:nav>",submitBubbles:!0,changeBubbles:!0,focusinBubbles:!1,deleteExpando:!0,noCloneEvent:!0,inlineBlockNeedsLayout:!1,shrinkWrapBlocks:!1,reliableMarginRight:!0,pixelMargin:!0},f.boxModel=b.boxModel=c.compatMode==="CSS1Compat",i.checked=!0,b.noCloneChecked=i.cloneNode(!0).checked,g.disabled=!0,b.optDisabled=!h.disabled;try{delete p.test}catch(r){b.deleteExpando=!1}!p.addEventListener&&p.attachEvent&&p.fireEvent&&(p.attachEvent("onclick",function(){b.noCloneEvent=!1}),p.cloneNode(!0).fireEvent("onclick")),i=c.createElement("input"),i.value="t",i.setAttribute("type","radio"),b.radioValue=i.value==="t",i.setAttribute("checked","checked"),i.setAttribute("name","t"),p.appendChild(i),j=c.createDocumentFragment(),j.appendChild(p.lastChild),b.checkClone=j.cloneNode(!0).cloneNode(!0).lastChild.checked,b.appendChecked=i.checked,j.removeChild(i),j.appendChild(p);if(p.attachEvent)for(n in{submit:1,change:1,focusin:1})m="on"+n,o=m in p,o||(p.setAttribute(m,"return;"),o=typeof p[m]=="function"),b[n+"Bubbles"]=o;j.removeChild(p),j=g=h=p=i=null,f(function(){var d,e,g,h,i,j,l,m,n,q,r,s,t,u=c.getElementsByTagName("body")[0];!u||(m=1,t="padding:0;margin:0;border:",r="position:absolute;top:0;left:0;width:1px;height:1px;",s=t+"0;visibility:hidden;",n="style='"+r+t+"5px solid #000;",q="<div "+n+"display:block;'><div style='"+t+"0;display:block;overflow:hidden;'></div></div>"+"<table "+n+"' cellpadding='0' cellspacing='0'>"+"<tr><td></td></tr></table>",d=c.createElement("div"),d.style.cssText=s+"width:0;height:0;position:static;top:0;margin-top:"+m+"px",u.insertBefore(d,u.firstChild),p=c.createElement("div"),d.appendChild(p),p.innerHTML="<table><tr><td style='"+t+"0;display:none'></td><td>t</td></tr></table>",k=p.getElementsByTagName("td"),o=k[0].offsetHeight===0,k[0].style.display="",k[1].style.display="none",b.reliableHiddenOffsets=o&&k[0].offsetHeight===0,a.getComputedStyle&&(p.innerHTML="",l=c.createElement("div"),l.style.width="0",l.style.marginRight="0",p.style.width="2px",p.appendChild(l),b.reliableMarginRight=(parseInt((a.getComputedStyle(l,null)||{marginRight:0}).marginRight,10)||0)===0),typeof p.style.zoom!="undefined"&&(p.innerHTML="",p.style.width=p.style.padding="1px",p.style.border=0,p.style.overflow="hidden",p.style.display="inline",p.style.zoom=1,b.inlineBlockNeedsLayout=p.offsetWidth===3,p.style.display="block",p.style.overflow="visible",p.innerHTML="<div style='width:5px;'></div>",b.shrinkWrapBlocks=p.offsetWidth!==3),p.style.cssText=r+s,p.innerHTML=q,e=p.firstChild,g=e.firstChild,i=e.nextSibling.firstChild.firstChild,j={doesNotAddBorder:g.offsetTop!==5,doesAddBorderForTableAndCells:i.offsetTop===5},g.style.position="fixed",g.style.top="20px",j.fixedPosition=g.offsetTop===20||g.offsetTop===15,g.style.position=g.style.top="",e.style.overflow="hidden",e.style.position="relative",j.subtractsBorderForOverflowNotVisible=g.offsetTop===-5,j.doesNotIncludeMarginInBodyOffset=u.offsetTop!==m,a.getComputedStyle&&(p.style.marginTop="1%",b.pixelMargin=(a.getComputedStyle(p,null)||{marginTop:0}).marginTop!=="1%"),typeof d.style.zoom!="undefined"&&(d.style.zoom=1),u.removeChild(d),l=p=d=null,f.extend(b,j))});return b}();var j=/^(?:\{.*\}|\[.*\])$/,k=/([A-Z])/g;f.extend({cache:{},uuid:0,expando:"jQuery"+(f.fn.jquery+Math.random()).replace(/\D/g,""),noData:{embed:!0,object:"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",applet:!0},hasData:function(a){a=a.nodeType?f.cache[a[f.expando]]:a[f.expando];return!!a&&!m(a)},data:function(a,c,d,e){if(!!f.acceptData(a)){var g,h,i,j=f.expando,k=typeof c=="string",l=a.nodeType,m=l?f.cache:a,n=l?a[j]:a[j]&&j,o=c==="events";if((!n||!m[n]||!o&&!e&&!m[n].data)&&k&&d===b)return;n||(l?a[j]=n=++f.uuid:n=j),m[n]||(m[n]={},l||(m[n].toJSON=f.noop));if(typeof c=="object"||typeof c=="function")e?m[n]=f.extend(m[n],c):m[n].data=f.extend(m[n].data,c);g=h=m[n],e||(h.data||(h.data={}),h=h.data),d!==b&&(h[f.camelCase(c)]=d);if(o&&!h[c])return g.events;k?(i=h[c],i==null&&(i=h[f.camelCase(c)])):i=h;return i}},removeData:function(a,b,c){if(!!f.acceptData(a)){var d,e,g,h=f.expando,i=a.nodeType,j=i?f.cache:a,k=i?a[h]:h;if(!j[k])return;if(b){d=c?j[k]:j[k].data;if(d){f.isArray(b)||(b in d?b=[b]:(b=f.camelCase(b),b in d?b=[b]:b=b.split(" ")));for(e=0,g=b.length;e<g;e++)delete d[b[e]];if(!(c?m:f.isEmptyObject)(d))return}}if(!c){delete j[k].data;if(!m(j[k]))return}f.support.deleteExpando||!j.setInterval?delete j[k]:j[k]=null,i&&(f.support.deleteExpando?delete a[h]:a.removeAttribute?a.removeAttribute(h):a[h]=null)}},_data:function(a,b,c){return f.data(a,b,c,!0)},acceptData:function(a){if(a.nodeName){var b=f.noData[a.nodeName.toLowerCase()];if(b)return b!==!0&&a.getAttribute("classid")===b}return!0}}),f.fn.extend({data:function(a,c){var d,e,g,h,i,j=this[0],k=0,m=null;if(a===b){if(this.length){m=f.data(j);if(j.nodeType===1&&!f._data(j,"parsedAttrs")){g=j.attributes;for(i=g.length;k<i;k++)h=g[k].name,h.indexOf("data-")===0&&(h=f.camelCase(h.substring(5)),l(j,h,m[h]));f._data(j,"parsedAttrs",!0)}}return m}if(typeof a=="object")return this.each(function(){f.data(this,a)});d=a.split(".",2),d[1]=d[1]?"."+d[1]:"",e=d[1]+"!";return f.access(this,function(c){if(c===b){m=this.triggerHandler("getData"+e,[d[0]]),m===b&&j&&(m=f.data(j,a),m=l(j,a,m));return m===b&&d[1]?this.data(d[0]):m}d[1]=c,this.each(function(){var b=f(this);b.triggerHandler("setData"+e,d),f.data(this,a,c),b.triggerHandler("changeData"+e,d)})},null,c,arguments.length>1,null,!1)},removeData:function(a){return this.each(function(){f.removeData(this,a)})}}),f.extend({_mark:function(a,b){a&&(b=(b||"fx")+"mark",f._data(a,b,(f._data(a,b)||0)+1))},_unmark:function(a,b,c){a!==!0&&(c=b,b=a,a=!1);if(b){c=c||"fx";var d=c+"mark",e=a?0:(f._data(b,d)||1)-1;e?f._data(b,d,e):(f.removeData(b,d,!0),n(b,c,"mark"))}},queue:function(a,b,c){var d;if(a){b=(b||"fx")+"queue",d=f._data(a,b),c&&(!d||f.isArray(c)?d=f._data(a,b,f.makeArray(c)):d.push(c));return d||[]}},dequeue:function(a,b){b=b||"fx";var c=f.queue(a,b),d=c.shift(),e={};d==="inprogress"&&(d=c.shift()),d&&(b==="fx"&&c.unshift("inprogress"),f._data(a,b+".run",e),d.call(a,function(){f.dequeue(a,b)},e)),c.length||(f.removeData(a,b+"queue "+b+".run",!0),n(a,b,"queue"))}}),f.fn.extend({queue:function(a,c){var d=2;typeof a!="string"&&(c=a,a="fx",d--);if(arguments.length<d)return f.queue(this[0],a);return c===b?this:this.each(function(){var b=f.queue(this,a,c);a==="fx"&&b[0]!=="inprogress"&&f.dequeue(this,a)})},dequeue:function(a){return this.each(function(){f.dequeue(this,a)})},delay:function(a,b){a=f.fx?f.fx.speeds[a]||a:a,b=b||"fx";return this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,c){function m(){--h||d.resolveWith(e,[e])}typeof a!="string"&&(c=a,a=b),a=a||"fx";var d=f.Deferred(),e=this,g=e.length,h=1,i=a+"defer",j=a+"queue",k=a+"mark",l;while(g--)if(l=f.data(e[g],i,b,!0)||(f.data(e[g],j,b,!0)||f.data(e[g],k,b,!0))&&f.data(e[g],i,f.Callbacks("once memory"),!0))h++,l.add(m);m();return d.promise(c)}});var o=/[\n\t\r]/g,p=/\s+/,q=/\r/g,r=/^(?:button|input)$/i,s=/^(?:button|input|object|select|textarea)$/i,t=/^a(?:rea)?$/i,u=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,v=f.support.getSetAttribute,w,x,y;f.fn.extend({attr:function(a,b){return f.access(this,f.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){f.removeAttr(this,a)})},prop:function(a,b){return f.access(this,f.prop,a,b,arguments.length>1)},removeProp:function(a){a=f.propFix[a]||a;return this.each(function(){try{this[a]=b,delete this[a]}catch(c){}})},addClass:function(a){var b,c,d,e,g,h,i;if(f.isFunction(a))return this.each(function(b){f(this).addClass(a.call(this,b,this.className))});if(a&&typeof a=="string"){b=a.split(p);for(c=0,d=this.length;c<d;c++){e=this[c];if(e.nodeType===1)if(!e.className&&b.length===1)e.className=a;else{g=" "+e.className+" ";for(h=0,i=b.length;h<i;h++)~g.indexOf(" "+b[h]+" ")||(g+=b[h]+" ");e.className=f.trim(g)}}}return this},removeClass:function(a){var c,d,e,g,h,i,j;if(f.isFunction(a))return this.each(function(b){f(this).removeClass(a.call(this,b,this.className))});if(a&&typeof a=="string"||a===b){c=(a||"").split(p);for(d=0,e=this.length;d<e;d++){g=this[d];if(g.nodeType===1&&g.className)if(a){h=(" "+g.className+" ").replace(o," ");for(i=0,j=c.length;i<j;i++)h=h.replace(" "+c[i]+" "," ");g.className=f.trim(h)}else g.className=""}}return this},toggleClass:function(a,b){var c=typeof a,d=typeof b=="boolean";if(f.isFunction(a))return this.each(function(c){f(this).toggleClass(a.call(this,c,this.className,b),b)});return this.each(function(){if(c==="string"){var e,g=0,h=f(this),i=b,j=a.split(p);while(e=j[g++])i=d?i:!h.hasClass(e),h[i?"addClass":"removeClass"](e)}else if(c==="undefined"||c==="boolean")this.className&&f._data(this,"__className__",this.className),this.className=this.className||a===!1?"":f._data(this,"__className__")||""})},hasClass:function(a){var b=" "+a+" ",c=0,d=this.length;for(;c<d;c++)if(this[c].nodeType===1&&(" "+this[c].className+" ").replace(o," ").indexOf(b)>-1)return!0;return!1},val:function(a){var c,d,e,g=this[0];{if(!!arguments.length){e=f.isFunction(a);return this.each(function(d){var g=f(this),h;if(this.nodeType===1){e?h=a.call(this,d,g.val()):h=a,h==null?h="":typeof h=="number"?h+="":f.isArray(h)&&(h=f.map(h,function(a){return a==null?"":a+""})),c=f.valHooks[this.type]||f.valHooks[this.nodeName.toLowerCase()];if(!c||!("set"in c)||c.set(this,h,"value")===b)this.value=h}})}if(g){c=f.valHooks[g.type]||f.valHooks[g.nodeName.toLowerCase()];if(c&&"get"in c&&(d=c.get(g,"value"))!==b)return d;d=g.value;return typeof d=="string"?d.replace(q,""):d==null?"":d}}}}),f.extend({valHooks:{option:{get:function(a){var b=a.attributes.value;return!b||b.specified?a.value:a.text}},select:{get:function(a){var b,c,d,e,g=a.selectedIndex,h=[],i=a.options,j=a.type==="select-one";if(g<0)return null;c=j?g:0,d=j?g+1:i.length;for(;c<d;c++){e=i[c];if(e.selected&&(f.support.optDisabled?!e.disabled:e.getAttribute("disabled")===null)&&(!e.parentNode.disabled||!f.nodeName(e.parentNode,"optgroup"))){b=f(e).val();if(j)return b;h.push(b)}}if(j&&!h.length&&i.length)return f(i[g]).val();return h},set:function(a,b){var c=f.makeArray(b);f(a).find("option").each(function(){this.selected=f.inArray(f(this).val(),c)>=0}),c.length||(a.selectedIndex=-1);return c}}},attrFn:{val:!0,css:!0,html:!0,text:!0,data:!0,width:!0,height:!0,offset:!0},attr:function(a,c,d,e){var g,h,i,j=a.nodeType;if(!!a&&j!==3&&j!==8&&j!==2){if(e&&c in f.attrFn)return f(a)[c](d);if(typeof a.getAttribute=="undefined")return f.prop(a,c,d);i=j!==1||!f.isXMLDoc(a),i&&(c=c.toLowerCase(),h=f.attrHooks[c]||(u.test(c)?x:w));if(d!==b){if(d===null){f.removeAttr(a,c);return}if(h&&"set"in h&&i&&(g=h.set(a,d,c))!==b)return g;a.setAttribute(c,""+d);return d}if(h&&"get"in h&&i&&(g=h.get(a,c))!==null)return g;g=a.getAttribute(c);return g===null?b:g}},removeAttr:function(a,b){var c,d,e,g,h,i=0;if(b&&a.nodeType===1){d=b.toLowerCase().split(p),g=d.length;for(;i<g;i++)e=d[i],e&&(c=f.propFix[e]||e,h=u.test(e),h||f.attr(a,e,""),a.removeAttribute(v?e:c),h&&c in a&&(a[c]=!1))}},attrHooks:{type:{set:function(a,b){if(r.test(a.nodeName)&&a.parentNode)f.error("type property can't be changed");else if(!f.support.radioValue&&b==="radio"&&f.nodeName(a,"input")){var c=a.value;a.setAttribute("type",b),c&&(a.value=c);return b}}},value:{get:function(a,b){if(w&&f.nodeName(a,"button"))return w.get(a,b);return b in a?a.value:null},set:function(a,b,c){if(w&&f.nodeName(a,"button"))return w.set(a,b,c);a.value=b}}},propFix:{tabindex:"tabIndex",readonly:"readOnly","for":"htmlFor","class":"className",maxlength:"maxLength",cellspacing:"cellSpacing",cellpadding:"cellPadding",rowspan:"rowSpan",colspan:"colSpan",usemap:"useMap",frameborder:"frameBorder",contenteditable:"contentEditable"},prop:function(a,c,d){var e,g,h,i=a.nodeType;if(!!a&&i!==3&&i!==8&&i!==2){h=i!==1||!f.isXMLDoc(a),h&&(c=f.propFix[c]||c,g=f.propHooks[c]);return d!==b?g&&"set"in g&&(e=g.set(a,d,c))!==b?e:a[c]=d:g&&"get"in g&&(e=g.get(a,c))!==null?e:a[c]}},propHooks:{tabIndex:{get:function(a){var c=a.getAttributeNode("tabindex");return c&&c.specified?parseInt(c.value,10):s.test(a.nodeName)||t.test(a.nodeName)&&a.href?0:b}}}}),f.attrHooks.tabindex=f.propHooks.tabIndex,x={get:function(a,c){var d,e=f.prop(a,c);return e===!0||typeof e!="boolean"&&(d=a.getAttributeNode(c))&&d.nodeValue!==!1?c.toLowerCase():b},set:function(a,b,c){var d;b===!1?f.removeAttr(a,c):(d=f.propFix[c]||c,d in a&&(a[d]=!0),a.setAttribute(c,c.toLowerCase()));return c}},v||(y={name:!0,id:!0,coords:!0},w=f.valHooks.button={get:function(a,c){var d;d=a.getAttributeNode(c);return d&&(y[c]?d.nodeValue!=="":d.specified)?d.nodeValue:b},set:function(a,b,d){var e=a.getAttributeNode(d);e||(e=c.createAttribute(d),a.setAttributeNode(e));return e.nodeValue=b+""}},f.attrHooks.tabindex.set=w.set,f.each(["width","height"],function(a,b){f.attrHooks[b]=f.extend(f.attrHooks[b],{set:function(a,c){if(c===""){a.setAttribute(b,"auto");return c}}})}),f.attrHooks.contenteditable={get:w.get,set:function(a,b,c){b===""&&(b="false"),w.set(a,b,c)}}),f.support.hrefNormalized||f.each(["href","src","width","height"],function(a,c){f.attrHooks[c]=f.extend(f.attrHooks[c],{get:function(a){var d=a.getAttribute(c,2);return d===null?b:d}})}),f.support.style||(f.attrHooks.style={get:function(a){return a.style.cssText.toLowerCase()||b},set:function(a,b){return a.style.cssText=""+b}}),f.support.optSelected||(f.propHooks.selected=f.extend(f.propHooks.selected,{get:function(a){var b=a.parentNode;b&&(b.selectedIndex,b.parentNode&&b.parentNode.selectedIndex);return null}})),f.support.enctype||(f.propFix.enctype="encoding"),f.support.checkOn||f.each(["radio","checkbox"],function(){f.valHooks[this]={get:function(a){return a.getAttribute("value")===null?"on":a.value}}}),f.each(["radio","checkbox"],function(){f.valHooks[this]=f.extend(f.valHooks[this],{set:function(a,b){if(f.isArray(b))return a.checked=f.inArray(f(a).val(),b)>=0}})});var z=/^(?:textarea|input|select)$/i,A=/^([^\.]*)?(?:\.(.+))?$/,B=/(?:^|\s)hover(\.\S+)?\b/,C=/^key/,D=/^(?:mouse|contextmenu)|click/,E=/^(?:focusinfocus|focusoutblur)$/,F=/^(\w*)(?:#([\w\-]+))?(?:\.([\w\-]+))?$/,G=function(
a){var b=F.exec(a);b&&(b[1]=(b[1]||"").toLowerCase(),b[3]=b[3]&&new RegExp("(?:^|\\s)"+b[3]+"(?:\\s|$)"));return b},H=function(a,b){var c=a.attributes||{};return(!b[1]||a.nodeName.toLowerCase()===b[1])&&(!b[2]||(c.id||{}).value===b[2])&&(!b[3]||b[3].test((c["class"]||{}).value))},I=function(a){return f.event.special.hover?a:a.replace(B,"mouseenter$1 mouseleave$1")};f.event={add:function(a,c,d,e,g){var h,i,j,k,l,m,n,o,p,q,r,s;if(!(a.nodeType===3||a.nodeType===8||!c||!d||!(h=f._data(a)))){d.handler&&(p=d,d=p.handler,g=p.selector),d.guid||(d.guid=f.guid++),j=h.events,j||(h.events=j={}),i=h.handle,i||(h.handle=i=function(a){return typeof f!="undefined"&&(!a||f.event.triggered!==a.type)?f.event.dispatch.apply(i.elem,arguments):b},i.elem=a),c=f.trim(I(c)).split(" ");for(k=0;k<c.length;k++){l=A.exec(c[k])||[],m=l[1],n=(l[2]||"").split(".").sort(),s=f.event.special[m]||{},m=(g?s.delegateType:s.bindType)||m,s=f.event.special[m]||{},o=f.extend({type:m,origType:l[1],data:e,handler:d,guid:d.guid,selector:g,quick:g&&G(g),namespace:n.join(".")},p),r=j[m];if(!r){r=j[m]=[],r.delegateCount=0;if(!s.setup||s.setup.call(a,e,n,i)===!1)a.addEventListener?a.addEventListener(m,i,!1):a.attachEvent&&a.attachEvent("on"+m,i)}s.add&&(s.add.call(a,o),o.handler.guid||(o.handler.guid=d.guid)),g?r.splice(r.delegateCount++,0,o):r.push(o),f.event.global[m]=!0}a=null}},global:{},remove:function(a,b,c,d,e){var g=f.hasData(a)&&f._data(a),h,i,j,k,l,m,n,o,p,q,r,s;if(!!g&&!!(o=g.events)){b=f.trim(I(b||"")).split(" ");for(h=0;h<b.length;h++){i=A.exec(b[h])||[],j=k=i[1],l=i[2];if(!j){for(j in o)f.event.remove(a,j+b[h],c,d,!0);continue}p=f.event.special[j]||{},j=(d?p.delegateType:p.bindType)||j,r=o[j]||[],m=r.length,l=l?new RegExp("(^|\\.)"+l.split(".").sort().join("\\.(?:.*\\.)?")+"(\\.|$)"):null;for(n=0;n<r.length;n++)s=r[n],(e||k===s.origType)&&(!c||c.guid===s.guid)&&(!l||l.test(s.namespace))&&(!d||d===s.selector||d==="**"&&s.selector)&&(r.splice(n--,1),s.selector&&r.delegateCount--,p.remove&&p.remove.call(a,s));r.length===0&&m!==r.length&&((!p.teardown||p.teardown.call(a,l)===!1)&&f.removeEvent(a,j,g.handle),delete o[j])}f.isEmptyObject(o)&&(q=g.handle,q&&(q.elem=null),f.removeData(a,["events","handle"],!0))}},customEvent:{getData:!0,setData:!0,changeData:!0},trigger:function(c,d,e,g){if(!e||e.nodeType!==3&&e.nodeType!==8){var h=c.type||c,i=[],j,k,l,m,n,o,p,q,r,s;if(E.test(h+f.event.triggered))return;h.indexOf("!")>=0&&(h=h.slice(0,-1),k=!0),h.indexOf(".")>=0&&(i=h.split("."),h=i.shift(),i.sort());if((!e||f.event.customEvent[h])&&!f.event.global[h])return;c=typeof c=="object"?c[f.expando]?c:new f.Event(h,c):new f.Event(h),c.type=h,c.isTrigger=!0,c.exclusive=k,c.namespace=i.join("."),c.namespace_re=c.namespace?new RegExp("(^|\\.)"+i.join("\\.(?:.*\\.)?")+"(\\.|$)"):null,o=h.indexOf(":")<0?"on"+h:"";if(!e){j=f.cache;for(l in j)j[l].events&&j[l].events[h]&&f.event.trigger(c,d,j[l].handle.elem,!0);return}c.result=b,c.target||(c.target=e),d=d!=null?f.makeArray(d):[],d.unshift(c),p=f.event.special[h]||{};if(p.trigger&&p.trigger.apply(e,d)===!1)return;r=[[e,p.bindType||h]];if(!g&&!p.noBubble&&!f.isWindow(e)){s=p.delegateType||h,m=E.test(s+h)?e:e.parentNode,n=null;for(;m;m=m.parentNode)r.push([m,s]),n=m;n&&n===e.ownerDocument&&r.push([n.defaultView||n.parentWindow||a,s])}for(l=0;l<r.length&&!c.isPropagationStopped();l++)m=r[l][0],c.type=r[l][1],q=(f._data(m,"events")||{})[c.type]&&f._data(m,"handle"),q&&q.apply(m,d),q=o&&m[o],q&&f.acceptData(m)&&q.apply(m,d)===!1&&c.preventDefault();c.type=h,!g&&!c.isDefaultPrevented()&&(!p._default||p._default.apply(e.ownerDocument,d)===!1)&&(h!=="click"||!f.nodeName(e,"a"))&&f.acceptData(e)&&o&&e[h]&&(h!=="focus"&&h!=="blur"||c.target.offsetWidth!==0)&&!f.isWindow(e)&&(n=e[o],n&&(e[o]=null),f.event.triggered=h,e[h](),f.event.triggered=b,n&&(e[o]=n));return c.result}},dispatch:function(c){c=f.event.fix(c||a.event);var d=(f._data(this,"events")||{})[c.type]||[],e=d.delegateCount,g=[].slice.call(arguments,0),h=!c.exclusive&&!c.namespace,i=f.event.special[c.type]||{},j=[],k,l,m,n,o,p,q,r,s,t,u;g[0]=c,c.delegateTarget=this;if(!i.preDispatch||i.preDispatch.call(this,c)!==!1){if(e&&(!c.button||c.type!=="click")){n=f(this),n.context=this.ownerDocument||this;for(m=c.target;m!=this;m=m.parentNode||this)if(m.disabled!==!0){p={},r=[],n[0]=m;for(k=0;k<e;k++)s=d[k],t=s.selector,p[t]===b&&(p[t]=s.quick?H(m,s.quick):n.is(t)),p[t]&&r.push(s);r.length&&j.push({elem:m,matches:r})}}d.length>e&&j.push({elem:this,matches:d.slice(e)});for(k=0;k<j.length&&!c.isPropagationStopped();k++){q=j[k],c.currentTarget=q.elem;for(l=0;l<q.matches.length&&!c.isImmediatePropagationStopped();l++){s=q.matches[l];if(h||!c.namespace&&!s.namespace||c.namespace_re&&c.namespace_re.test(s.namespace))c.data=s.data,c.handleObj=s,o=((f.event.special[s.origType]||{}).handle||s.handler).apply(q.elem,g),o!==b&&(c.result=o,o===!1&&(c.preventDefault(),c.stopPropagation()))}}i.postDispatch&&i.postDispatch.call(this,c);return c.result}},props:"attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){a.which==null&&(a.which=b.charCode!=null?b.charCode:b.keyCode);return a}},mouseHooks:{props:"button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,d){var e,f,g,h=d.button,i=d.fromElement;a.pageX==null&&d.clientX!=null&&(e=a.target.ownerDocument||c,f=e.documentElement,g=e.body,a.pageX=d.clientX+(f&&f.scrollLeft||g&&g.scrollLeft||0)-(f&&f.clientLeft||g&&g.clientLeft||0),a.pageY=d.clientY+(f&&f.scrollTop||g&&g.scrollTop||0)-(f&&f.clientTop||g&&g.clientTop||0)),!a.relatedTarget&&i&&(a.relatedTarget=i===a.target?d.toElement:i),!a.which&&h!==b&&(a.which=h&1?1:h&2?3:h&4?2:0);return a}},fix:function(a){if(a[f.expando])return a;var d,e,g=a,h=f.event.fixHooks[a.type]||{},i=h.props?this.props.concat(h.props):this.props;a=f.Event(g);for(d=i.length;d;)e=i[--d],a[e]=g[e];a.target||(a.target=g.srcElement||c),a.target.nodeType===3&&(a.target=a.target.parentNode),a.metaKey===b&&(a.metaKey=a.ctrlKey);return h.filter?h.filter(a,g):a},special:{ready:{setup:f.bindReady},load:{noBubble:!0},focus:{delegateType:"focusin"},blur:{delegateType:"focusout"},beforeunload:{setup:function(a,b,c){f.isWindow(this)&&(this.onbeforeunload=c)},teardown:function(a,b){this.onbeforeunload===b&&(this.onbeforeunload=null)}}},simulate:function(a,b,c,d){var e=f.extend(new f.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?f.event.trigger(e,null,b):f.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},f.event.handle=f.event.dispatch,f.removeEvent=c.removeEventListener?function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)}:function(a,b,c){a.detachEvent&&a.detachEvent("on"+b,c)},f.Event=function(a,b){if(!(this instanceof f.Event))return new f.Event(a,b);a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||a.returnValue===!1||a.getPreventDefault&&a.getPreventDefault()?K:J):this.type=a,b&&f.extend(this,b),this.timeStamp=a&&a.timeStamp||f.now(),this[f.expando]=!0},f.Event.prototype={preventDefault:function(){this.isDefaultPrevented=K;var a=this.originalEvent;!a||(a.preventDefault?a.preventDefault():a.returnValue=!1)},stopPropagation:function(){this.isPropagationStopped=K;var a=this.originalEvent;!a||(a.stopPropagation&&a.stopPropagation(),a.cancelBubble=!0)},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=K,this.stopPropagation()},isDefaultPrevented:J,isPropagationStopped:J,isImmediatePropagationStopped:J},f.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(a,b){f.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c=this,d=a.relatedTarget,e=a.handleObj,g=e.selector,h;if(!d||d!==c&&!f.contains(c,d))a.type=e.origType,h=e.handler.apply(this,arguments),a.type=b;return h}}}),f.support.submitBubbles||(f.event.special.submit={setup:function(){if(f.nodeName(this,"form"))return!1;f.event.add(this,"click._submit keypress._submit",function(a){var c=a.target,d=f.nodeName(c,"input")||f.nodeName(c,"button")?c.form:b;d&&!d._submit_attached&&(f.event.add(d,"submit._submit",function(a){a._submit_bubble=!0}),d._submit_attached=!0)})},postDispatch:function(a){a._submit_bubble&&(delete a._submit_bubble,this.parentNode&&!a.isTrigger&&f.event.simulate("submit",this.parentNode,a,!0))},teardown:function(){if(f.nodeName(this,"form"))return!1;f.event.remove(this,"._submit")}}),f.support.changeBubbles||(f.event.special.change={setup:function(){if(z.test(this.nodeName)){if(this.type==="checkbox"||this.type==="radio")f.event.add(this,"propertychange._change",function(a){a.originalEvent.propertyName==="checked"&&(this._just_changed=!0)}),f.event.add(this,"click._change",function(a){this._just_changed&&!a.isTrigger&&(this._just_changed=!1,f.event.simulate("change",this,a,!0))});return!1}f.event.add(this,"beforeactivate._change",function(a){var b=a.target;z.test(b.nodeName)&&!b._change_attached&&(f.event.add(b,"change._change",function(a){this.parentNode&&!a.isSimulated&&!a.isTrigger&&f.event.simulate("change",this.parentNode,a,!0)}),b._change_attached=!0)})},handle:function(a){var b=a.target;if(this!==b||a.isSimulated||a.isTrigger||b.type!=="radio"&&b.type!=="checkbox")return a.handleObj.handler.apply(this,arguments)},teardown:function(){f.event.remove(this,"._change");return z.test(this.nodeName)}}),f.support.focusinBubbles||f.each({focus:"focusin",blur:"focusout"},function(a,b){var d=0,e=function(a){f.event.simulate(b,a.target,f.event.fix(a),!0)};f.event.special[b]={setup:function(){d++===0&&c.addEventListener(a,e,!0)},teardown:function(){--d===0&&c.removeEventListener(a,e,!0)}}}),f.fn.extend({on:function(a,c,d,e,g){var h,i;if(typeof a=="object"){typeof c!="string"&&(d=d||c,c=b);for(i in a)this.on(i,c,d,a[i],g);return this}d==null&&e==null?(e=c,d=c=b):e==null&&(typeof c=="string"?(e=d,d=b):(e=d,d=c,c=b));if(e===!1)e=J;else if(!e)return this;g===1&&(h=e,e=function(a){f().off(a);return h.apply(this,arguments)},e.guid=h.guid||(h.guid=f.guid++));return this.each(function(){f.event.add(this,a,e,d,c)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,c,d){if(a&&a.preventDefault&&a.handleObj){var e=a.handleObj;f(a.delegateTarget).off(e.namespace?e.origType+"."+e.namespace:e.origType,e.selector,e.handler);return this}if(typeof a=="object"){for(var g in a)this.off(g,c,a[g]);return this}if(c===!1||typeof c=="function")d=c,c=b;d===!1&&(d=J);return this.each(function(){f.event.remove(this,a,d,c)})},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},live:function(a,b,c){f(this.context).on(a,this.selector,b,c);return this},die:function(a,b){f(this.context).off(a,this.selector||"**",b);return this},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return arguments.length==1?this.off(a,"**"):this.off(b,a,c)},trigger:function(a,b){return this.each(function(){f.event.trigger(a,b,this)})},triggerHandler:function(a,b){if(this[0])return f.event.trigger(a,b,this[0],!0)},toggle:function(a){var b=arguments,c=a.guid||f.guid++,d=0,e=function(c){var e=(f._data(this,"lastToggle"+a.guid)||0)%d;f._data(this,"lastToggle"+a.guid,e+1),c.preventDefault();return b[e].apply(this,arguments)||!1};e.guid=c;while(d<b.length)b[d++].guid=c;return this.click(e)},hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)}}),f.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){f.fn[b]=function(a,c){c==null&&(c=a,a=null);return arguments.length>0?this.on(b,null,a,c):this.trigger(b)},f.attrFn&&(f.attrFn[b]=!0),C.test(b)&&(f.event.fixHooks[b]=f.event.keyHooks),D.test(b)&&(f.event.fixHooks[b]=f.event.mouseHooks)}),function(){function x(a,b,c,e,f,g){for(var h=0,i=e.length;h<i;h++){var j=e[h];if(j){var k=!1;j=j[a];while(j){if(j[d]===c){k=e[j.sizset];break}if(j.nodeType===1){g||(j[d]=c,j.sizset=h);if(typeof b!="string"){if(j===b){k=!0;break}}else if(m.filter(b,[j]).length>0){k=j;break}}j=j[a]}e[h]=k}}}function w(a,b,c,e,f,g){for(var h=0,i=e.length;h<i;h++){var j=e[h];if(j){var k=!1;j=j[a];while(j){if(j[d]===c){k=e[j.sizset];break}j.nodeType===1&&!g&&(j[d]=c,j.sizset=h);if(j.nodeName.toLowerCase()===b){k=j;break}j=j[a]}e[h]=k}}}var a=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,d="sizcache"+(Math.random()+"").replace(".",""),e=0,g=Object.prototype.toString,h=!1,i=!0,j=/\\/g,k=/\r\n/g,l=/\W/;[0,0].sort(function(){i=!1;return 0});var m=function(b,d,e,f){e=e||[],d=d||c;var h=d;if(d.nodeType!==1&&d.nodeType!==9)return[];if(!b||typeof b!="string")return e;var i,j,k,l,n,q,r,t,u=!0,v=m.isXML(d),w=[],x=b;do{a.exec(""),i=a.exec(x);if(i){x=i[3],w.push(i[1]);if(i[2]){l=i[3];break}}}while(i);if(w.length>1&&p.exec(b))if(w.length===2&&o.relative[w[0]])j=y(w[0]+w[1],d,f);else{j=o.relative[w[0]]?[d]:m(w.shift(),d);while(w.length)b=w.shift(),o.relative[b]&&(b+=w.shift()),j=y(b,j,f)}else{!f&&w.length>1&&d.nodeType===9&&!v&&o.match.ID.test(w[0])&&!o.match.ID.test(w[w.length-1])&&(n=m.find(w.shift(),d,v),d=n.expr?m.filter(n.expr,n.set)[0]:n.set[0]);if(d){n=f?{expr:w.pop(),set:s(f)}:m.find(w.pop(),w.length===1&&(w[0]==="~"||w[0]==="+")&&d.parentNode?d.parentNode:d,v),j=n.expr?m.filter(n.expr,n.set):n.set,w.length>0?k=s(j):u=!1;while(w.length)q=w.pop(),r=q,o.relative[q]?r=w.pop():q="",r==null&&(r=d),o.relative[q](k,r,v)}else k=w=[]}k||(k=j),k||m.error(q||b);if(g.call(k)==="[object Array]")if(!u)e.push.apply(e,k);else if(d&&d.nodeType===1)for(t=0;k[t]!=null;t++)k[t]&&(k[t]===!0||k[t].nodeType===1&&m.contains(d,k[t]))&&e.push(j[t]);else for(t=0;k[t]!=null;t++)k[t]&&k[t].nodeType===1&&e.push(j[t]);else s(k,e);l&&(m(l,h,e,f),m.uniqueSort(e));return e};m.uniqueSort=function(a){if(u){h=i,a.sort(u);if(h)for(var b=1;b<a.length;b++)a[b]===a[b-1]&&a.splice(b--,1)}return a},m.matches=function(a,b){return m(a,null,null,b)},m.matchesSelector=function(a,b){return m(b,null,null,[a]).length>0},m.find=function(a,b,c){var d,e,f,g,h,i;if(!a)return[];for(e=0,f=o.order.length;e<f;e++){h=o.order[e];if(g=o.leftMatch[h].exec(a)){i=g[1],g.splice(1,1);if(i.substr(i.length-1)!=="\\"){g[1]=(g[1]||"").replace(j,""),d=o.find[h](g,b,c);if(d!=null){a=a.replace(o.match[h],"");break}}}}d||(d=typeof b.getElementsByTagName!="undefined"?b.getElementsByTagName("*"):[]);return{set:d,expr:a}},m.filter=function(a,c,d,e){var f,g,h,i,j,k,l,n,p,q=a,r=[],s=c,t=c&&c[0]&&m.isXML(c[0]);while(a&&c.length){for(h in o.filter)if((f=o.leftMatch[h].exec(a))!=null&&f[2]){k=o.filter[h],l=f[1],g=!1,f.splice(1,1);if(l.substr(l.length-1)==="\\")continue;s===r&&(r=[]);if(o.preFilter[h]){f=o.preFilter[h](f,s,d,r,e,t);if(!f)g=i=!0;else if(f===!0)continue}if(f)for(n=0;(j=s[n])!=null;n++)j&&(i=k(j,f,n,s),p=e^i,d&&i!=null?p?g=!0:s[n]=!1:p&&(r.push(j),g=!0));if(i!==b){d||(s=r),a=a.replace(o.match[h],"");if(!g)return[];break}}if(a===q)if(g==null)m.error(a);else break;q=a}return s},m.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)};var n=m.getText=function(a){var b,c,d=a.nodeType,e="";if(d){if(d===1||d===9||d===11){if(typeof a.textContent=="string")return a.textContent;if(typeof a.innerText=="string")return a.innerText.replace(k,"");for(a=a.firstChild;a;a=a.nextSibling)e+=n(a)}else if(d===3||d===4)return a.nodeValue}else for(b=0;c=a[b];b++)c.nodeType!==8&&(e+=n(c));return e},o=m.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/},leftMatch:{},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(a){return a.getAttribute("href")},type:function(a){return a.getAttribute("type")}},relative:{"+":function(a,b){var c=typeof b=="string",d=c&&!l.test(b),e=c&&!d;d&&(b=b.toLowerCase());for(var f=0,g=a.length,h;f<g;f++)if(h=a[f]){while((h=h.previousSibling)&&h.nodeType!==1);a[f]=e||h&&h.nodeName.toLowerCase()===b?h||!1:h===b}e&&m.filter(b,a,!0)},">":function(a,b){var c,d=typeof b=="string",e=0,f=a.length;if(d&&!l.test(b)){b=b.toLowerCase();for(;e<f;e++){c=a[e];if(c){var g=c.parentNode;a[e]=g.nodeName.toLowerCase()===b?g:!1}}}else{for(;e<f;e++)c=a[e],c&&(a[e]=d?c.parentNode:c.parentNode===b);d&&m.filter(b,a,!0)}},"":function(a,b,c){var d,f=e++,g=x;typeof b=="string"&&!l.test(b)&&(b=b.toLowerCase(),d=b,g=w),g("parentNode",b,f,a,d,c)},"~":function(a,b,c){var d,f=e++,g=x;typeof b=="string"&&!l.test(b)&&(b=b.toLowerCase(),d=b,g=w),g("previousSibling",b,f,a,d,c)}},find:{ID:function(a,b,c){if(typeof b.getElementById!="undefined"&&!c){var d=b.getElementById(a[1]);return d&&d.parentNode?[d]:[]}},NAME:function(a,b){if(typeof b.getElementsByName!="undefined"){var c=[],d=b.getElementsByName(a[1]);for(var e=0,f=d.length;e<f;e++)d[e].getAttribute("name")===a[1]&&c.push(d[e]);return c.length===0?null:c}},TAG:function(a,b){if(typeof b.getElementsByTagName!="undefined")return b.getElementsByTagName(a[1])}},preFilter:{CLASS:function(a,b,c,d,e,f){a=" "+a[1].replace(j,"")+" ";if(f)return a;for(var g=0,h;(h=b[g])!=null;g++)h&&(e^(h.className&&(" "+h.className+" ").replace(/[\t\n\r]/g," ").indexOf(a)>=0)?c||d.push(h):c&&(b[g]=!1));return!1},ID:function(a){return a[1].replace(j,"")},TAG:function(a,b){return a[1].replace(j,"").toLowerCase()},CHILD:function(a){if(a[1]==="nth"){a[2]||m.error(a[0]),a[2]=a[2].replace(/^\+|\s*/g,"");var b=/(-?)(\d*)(?:n([+\-]?\d*))?/.exec(a[2]==="even"&&"2n"||a[2]==="odd"&&"2n+1"||!/\D/.test(a[2])&&"0n+"+a[2]||a[2]);a[2]=b[1]+(b[2]||1)-0,a[3]=b[3]-0}else a[2]&&m.error(a[0]);a[0]=e++;return a},ATTR:function(a,b,c,d,e,f){var g=a[1]=a[1].replace(j,"");!f&&o.attrMap[g]&&(a[1]=o.attrMap[g]),a[4]=(a[4]||a[5]||"").replace(j,""),a[2]==="~="&&(a[4]=" "+a[4]+" ");return a},PSEUDO:function(b,c,d,e,f){if(b[1]==="not")if((a.exec(b[3])||"").length>1||/^\w/.test(b[3]))b[3]=m(b[3],null,null,c);else{var g=m.filter(b[3],c,d,!0^f);d||e.push.apply(e,g);return!1}else if(o.match.POS.test(b[0])||o.match.CHILD.test(b[0]))return!0;return b},POS:function(a){a.unshift(!0);return a}},filters:{enabled:function(a){return a.disabled===!1&&a.type!=="hidden"},disabled:function(a){return a.disabled===!0},checked:function(a){return a.checked===!0},selected:function(a){a.parentNode&&a.parentNode.selectedIndex;return a.selected===!0},parent:function(a){return!!a.firstChild},empty:function(a){return!a.firstChild},has:function(a,b,c){return!!m(c[3],a).length},header:function(a){return/h\d/i.test(a.nodeName)},text:function(a){var b=a.getAttribute("type"),c=a.type;return a.nodeName.toLowerCase()==="input"&&"text"===c&&(b===c||b===null)},radio:function(a){return a.nodeName.toLowerCase()==="input"&&"radio"===a.type},checkbox:function(a){return a.nodeName.toLowerCase()==="input"&&"checkbox"===a.type},file:function(a){return a.nodeName.toLowerCase()==="input"&&"file"===a.type},password:function(a){return a.nodeName.toLowerCase()==="input"&&"password"===a.type},submit:function(a){var b=a.nodeName.toLowerCase();return(b==="input"||b==="button")&&"submit"===a.type},image:function(a){return a.nodeName.toLowerCase()==="input"&&"image"===a.type},reset:function(a){var b=a.nodeName.toLowerCase();return(b==="input"||b==="button")&&"reset"===a.type},button:function(a){var b=a.nodeName.toLowerCase();return b==="input"&&"button"===a.type||b==="button"},input:function(a){return/input|select|textarea|button/i.test(a.nodeName)},focus:function(a){return a===a.ownerDocument.activeElement}},setFilters:{first:function(a,b){return b===0},last:function(a,b,c,d){return b===d.length-1},even:function(a,b){return b%2===0},odd:function(a,b){return b%2===1},lt:function(a,b,c){return b<c[3]-0},gt:function(a,b,c){return b>c[3]-0},nth:function(a,b,c){return c[3]-0===b},eq:function(a,b,c){return c[3]-0===b}},filter:{PSEUDO:function(a,b,c,d){var e=b[1],f=o.filters[e];if(f)return f(a,c,b,d);if(e==="contains")return(a.textContent||a.innerText||n([a])||"").indexOf(b[3])>=0;if(e==="not"){var g=b[3];for(var h=0,i=g.length;h<i;h++)if(g[h]===a)return!1;return!0}m.error(e)},CHILD:function(a,b){var c,e,f,g,h,i,j,k=b[1],l=a;switch(k){case"only":case"first":while(l=l.previousSibling)if(l.nodeType===1)return!1;if(k==="first")return!0;l=a;case"last":while(l=l.nextSibling)if(l.nodeType===1)return!1;return!0;case"nth":c=b[2],e=b[3];if(c===1&&e===0)return!0;f=b[0],g=a.parentNode;if(g&&(g[d]!==f||!a.nodeIndex)){i=0;for(l=g.firstChild;l;l=l.nextSibling)l.nodeType===1&&(l.nodeIndex=++i);g[d]=f}j=a.nodeIndex-e;return c===0?j===0:j%c===0&&j/c>=0}},ID:function(a,b){return a.nodeType===1&&a.getAttribute("id")===b},TAG:function(a,b){return b==="*"&&a.nodeType===1||!!a.nodeName&&a.nodeName.toLowerCase()===b},CLASS:function(a,b){return(" "+(a.className||a.getAttribute("class"))+" ").indexOf(b)>-1},ATTR:function(a,b){var c=b[1],d=m.attr?m.attr(a,c):o.attrHandle[c]?o.attrHandle[c](a):a[c]!=null?a[c]:a.getAttribute(c),e=d+"",f=b[2],g=b[4];return d==null?f==="!=":!f&&m.attr?d!=null:f==="="?e===g:f==="*="?e.indexOf(g)>=0:f==="~="?(" "+e+" ").indexOf(g)>=0:g?f==="!="?e!==g:f==="^="?e.indexOf(g)===0:f==="$="?e.substr(e.length-g.length)===g:f==="|="?e===g||e.substr(0,g.length+1)===g+"-":!1:e&&d!==!1},POS:function(a,b,c,d){var e=b[2],f=o.setFilters[e];if(f)return f(a,c,b,d)}}},p=o.match.POS,q=function(a,b){return"\\"+(b-0+1)};for(var r in o.match)o.match[r]=new RegExp(o.match[r].source+/(?![^\[]*\])(?![^\(]*\))/.source),o.leftMatch[r]=new RegExp(/(^(?:.|\r|\n)*?)/.source+o.match[r].source.replace(/\\(\d+)/g,q));o.match.globalPOS=p;var s=function(a,b){a=Array.prototype.slice.call(a,0);if(b){b.push.apply(b,a);return b}return a};try{Array.prototype.slice.call(c.documentElement.childNodes,0)[0].nodeType}catch(t){s=function(a,b){var c=0,d=b||[];if(g.call(a)==="[object Array]")Array.prototype.push.apply(d,a);else if(typeof a.length=="number")for(var e=a.length;c<e;c++)d.push(a[c]);else for(;a[c];c++)d.push(a[c]);return d}}var u,v;c.documentElement.compareDocumentPosition?u=function(a,b){if(a===b){h=!0;return 0}if(!a.compareDocumentPosition||!b.compareDocumentPosition)return a.compareDocumentPosition?-1:1;return a.compareDocumentPosition(b)&4?-1:1}:(u=function(a,b){if(a===b){h=!0;return 0}if(a.sourceIndex&&b.sourceIndex)return a.sourceIndex-b.sourceIndex;var c,d,e=[],f=[],g=a.parentNode,i=b.parentNode,j=g;if(g===i)return v(a,b);if(!g)return-1;if(!i)return 1;while(j)e.unshift(j),j=j.parentNode;j=i;while(j)f.unshift(j),j=j.parentNode;c=e.length,d=f.length;for(var k=0;k<c&&k<d;k++)if(e[k]!==f[k])return v(e[k],f[k]);return k===c?v(a,f[k],-1):v(e[k],b,1)},v=function(a,b,c){if(a===b)return c;var d=a.nextSibling;while(d){if(d===b)return-1;d=d.nextSibling}return 1}),function(){var a=c.createElement("div"),d="script"+(new Date).getTime(),e=c.documentElement;a.innerHTML="<a name='"+d+"'/>",e.insertBefore(a,e.firstChild),c.getElementById(d)&&(o.find.ID=function(a,c,d){if(typeof c.getElementById!="undefined"&&!d){var e=c.getElementById(a[1]);return e?e.id===a[1]||typeof e.getAttributeNode!="undefined"&&e.getAttributeNode("id").nodeValue===a[1]?[e]:b:[]}},o.filter.ID=function(a,b){var c=typeof a.getAttributeNode!="undefined"&&a.getAttributeNode("id");return a.nodeType===1&&c&&c.nodeValue===b}),e.removeChild(a),e=a=null}(),function(){var a=c.createElement("div");a.appendChild(c.createComment("")),a.getElementsByTagName("*").length>0&&(o.find.TAG=function(a,b){var c=b.getElementsByTagName(a[1]);if(a[1]==="*"){var d=[];for(var e=0;c[e];e++)c[e].nodeType===1&&d.push(c[e]);c=d}return c}),a.innerHTML="<a href='#'></a>",a.firstChild&&typeof a.firstChild.getAttribute!="undefined"&&a.firstChild.getAttribute("href")!=="#"&&(o.attrHandle.href=function(a){return a.getAttribute("href",2)}),a=null}(),c.querySelectorAll&&function(){var a=m,b=c.createElement("div"),d="__sizzle__";b.innerHTML="<p class='TEST'></p>";if(!b.querySelectorAll||b.querySelectorAll(".TEST").length!==0){m=function(b,e,f,g){e=e||c;if(!g&&!m.isXML(e)){var h=/^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec(b);if(h&&(e.nodeType===1||e.nodeType===9)){if(h[1])return s(e.getElementsByTagName(b),f);if(h[2]&&o.find.CLASS&&e.getElementsByClassName)return s(e.getElementsByClassName(h[2]),f)}if(e.nodeType===9){if(b==="body"&&e.body)return s([e.body],f);if(h&&h[3]){var i=e.getElementById(h[3]);if(!i||!i.parentNode)return s([],f);if(i.id===h[3])return s([i],f)}try{return s(e.querySelectorAll(b),f)}catch(j){}}else if(e.nodeType===1&&e.nodeName.toLowerCase()!=="object"){var k=e,l=e.getAttribute("id"),n=l||d,p=e.parentNode,q=/^\s*[+~]/.test(b);l?n=n.replace(/'/g,"\\$&"):e.setAttribute("id",n),q&&p&&(e=e.parentNode);try{if(!q||p)return s(e.querySelectorAll("[id='"+n+"'] "+b),f)}catch(r){}finally{l||k.removeAttribute("id")}}}return a(b,e,f,g)};for(var e in a)m[e]=a[e];b=null}}(),function(){var a=c.documentElement,b=a.matchesSelector||a.mozMatchesSelector||a.webkitMatchesSelector||a.msMatchesSelector;if(b){var d=!b.call(c.createElement("div"),"div"),e=!1;try{b.call(c.documentElement,"[test!='']:sizzle")}catch(f){e=!0}m.matchesSelector=function(a,c){c=c.replace(/\=\s*([^'"\]]*)\s*\]/g,"='$1']");if(!m.isXML(a))try{if(e||!o.match.PSEUDO.test(c)&&!/!=/.test(c)){var f=b.call(a,c);if(f||!d||a.document&&a.document.nodeType!==11)return f}}catch(g){}return m(c,null,null,[a]).length>0}}}(),function(){var a=c.createElement("div");a.innerHTML="<div class='test e'></div><div class='test'></div>";if(!!a.getElementsByClassName&&a.getElementsByClassName("e").length!==0){a.lastChild.className="e";if(a.getElementsByClassName("e").length===1)return;o.order.splice(1,0,"CLASS"),o.find.CLASS=function(a,b,c){if(typeof b.getElementsByClassName!="undefined"&&!c)return b.getElementsByClassName(a[1])},a=null}}(),c.documentElement.contains?m.contains=function(a,b){return a!==b&&(a.contains?a.contains(b):!0)}:c.documentElement.compareDocumentPosition?m.contains=function(a,b){return!!(a.compareDocumentPosition(b)&16)}:m.contains=function(){return!1},m.isXML=function(a){var b=(a?a.ownerDocument||a:0).documentElement;return b?b.nodeName!=="HTML":!1};var y=function(a,b,c){var d,e=[],f="",g=b.nodeType?[b]:b;while(d=o.match.PSEUDO.exec(a))f+=d[0],a=a.replace(o.match.PSEUDO,"");a=o.relative[a]?a+"*":a;for(var h=0,i=g.length;h<i;h++)m(a,g[h],e,c);return m.filter(f,e)};m.attr=f.attr,m.selectors.attrMap={},f.find=m,f.expr=m.selectors,f.expr[":"]=f.expr.filters,f.unique=m.uniqueSort,f.text=m.getText,f.isXMLDoc=m.isXML,f.contains=m.contains}();var L=/Until$/,M=/^(?:parents|prevUntil|prevAll)/,N=/,/,O=/^.[^:#\[\.,]*$/,P=Array.prototype.slice,Q=f.expr.match.globalPOS,R={children:!0,contents:!0,next:!0,prev:!0};f.fn.extend({find:function(a){var b=this,c,d;if(typeof a!="string")return f(a).filter(function(){for(c=0,d=b.length;c<d;c++)if(f.contains(b[c],this))return!0});var e=this.pushStack("","find",a),g,h,i;for(c=0,d=this.length;c<d;c++){g=e.length,f.find(a,this[c],e);if(c>0)for(h=g;h<e.length;h++)for(i=0;i<g;i++)if(e[i]===e[h]){e.splice(h--,1);break}}return e},has:function(a){var b=f(a);return this.filter(function(){for(var a=0,c=b.length;a<c;a++)if(f.contains(this,b[a]))return!0})},not:function(a){return this.pushStack(T(this,a,!1),"not",a)},filter:function(a){return this.pushStack(T(this,a,!0),"filter",a)},is:function(a){return!!a&&(typeof a=="string"?Q.test(a)?f(a,this.context).index(this[0])>=0:f.filter(a,this).length>0:this.filter(a).length>0)},closest:function(a,b){var c=[],d,e,g=this[0];if(f.isArray(a)){var h=1;while(g&&g.ownerDocument&&g!==b){for(d=0;d<a.length;d++)f(g).is(a[d])&&c.push({selector:a[d],elem:g,level:h});g=g.parentNode,h++}return c}var i=Q.test(a)||typeof a!="string"?f(a,b||this.context):0;for(d=0,e=this.length;d<e;d++){g=this[d];while(g){if(i?i.index(g)>-1:f.find.matchesSelector(g,a)){c.push(g);break}g=g.parentNode;if(!g||!g.ownerDocument||g===b||g.nodeType===11)break}}c=c.length>1?f.unique(c):c;return this.pushStack(c,"closest",a)},index:function(a){if(!a)return this[0]&&this[0].parentNode?this.prevAll().length:-1;if(typeof a=="string")return f.inArray(this[0],f(a));return f.inArray(a.jquery?a[0]:a,this)},add:function(a,b){var c=typeof a=="string"?f(a,b):f.makeArray(a&&a.nodeType?[a]:a),d=f.merge(this.get(),c);return this.pushStack(S(c[0])||S(d[0])?d:f.unique(d))},andSelf:function(){return this.add(this.prevObject)}}),f.each({parent:function(a){var b=a.parentNode;return b&&b.nodeType!==11?b:null},parents:function(a){return f.dir(a,"parentNode")},parentsUntil:function(a,b,c){return f.dir(a,"parentNode",c)},next:function(a){return f.nth(a,2,"nextSibling")},prev:function(a){return f.nth(a,2,"previousSibling")},nextAll:function(a){return f.dir(a,"nextSibling")},prevAll:function(a){return f.dir(a,"previousSibling")},nextUntil:function(a,b,c){return f.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return f.dir(a,"previousSibling",c)},siblings:function(a){return f.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return f.sibling(a.firstChild)},contents:function(a){return f.nodeName(a,"iframe")?a.contentDocument||a.contentWindow.document:f.makeArray(a.childNodes)}},function(a,b){f.fn[a]=function(c,d){var e=f.map(this,b,c);L.test(a)||(d=c),d&&typeof d=="string"&&(e=f.filter(d,e)),e=this.length>1&&!R[a]?f.unique(e):e,(this.length>1||N.test(d))&&M.test(a)&&(e=e.reverse());return this.pushStack(e,a,P.call(arguments).join(","))}}),f.extend({filter:function(a,b,c){c&&(a=":not("+a+")");return b.length===1?f.find.matchesSelector(b[0],a)?[b[0]]:[]:f.find.matches(a,b)},dir:function(a,c,d){var e=[],g=a[c];while(g&&g.nodeType!==9&&(d===b||g.nodeType!==1||!f(g).is(d)))g.nodeType===1&&e.push(g),g=g[c];return e},nth:function(a,b,c,d){b=b||1;var e=0;for(;a;a=a[c])if(a.nodeType===1&&++e===b)break;return a},sibling:function(a,b){var c=[];for(;a;a=a.nextSibling)a.nodeType===1&&a!==b&&c.push(a);return c}});var V="abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",W=/ jQuery\d+="(?:\d+|null)"/g,X=/^\s+/,Y=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/ig,Z=/<([\w:]+)/,$=/<tbody/i,_=/<|&#?\w+;/,ba=/<(?:script|style)/i,bb=/<(?:script|object|embed|option|style)/i,bc=new RegExp("<(?:"+V+")[\\s/>]","i"),bd=/checked\s*(?:[^=]|=\s*.checked.)/i,be=/\/(java|ecma)script/i,bf=/^\s*<!(?:\[CDATA\[|\-\-)/,bg={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],area:[1,"<map>","</map>"],_default:[0,"",""]},bh=U(c);bg.optgroup=bg.option,bg.tbody=bg.tfoot=bg.colgroup=bg.caption=bg.thead,bg.th=bg.td,f.support.htmlSerialize||(bg._default=[1,"div<div>","</div>"]),f.fn.extend({text:function(a){return f.access(this,function(a){return a===b?f.text(this):this.empty().append((this[0]&&this[0].ownerDocument||c).createTextNode(a))},null,a,arguments.length)},wrapAll:function(a){if(f.isFunction(a))return this.each(function(b){f(this).wrapAll(a.call(this,b))});if(this[0]){var b=f(a,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstChild&&a.firstChild.nodeType===1)a=a.firstChild;return a}).append(this)}return this},wrapInner:function(a){if(f.isFunction(a))return this.each(function(b){f(this).wrapInner(a.call(this,b))});return this.each(function(){var b=f(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=f.isFunction(a);return this.each(function(c){f(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){f.nodeName(this,"body")||f(this).replaceWith(this.childNodes)}).end()},append:function(){return this.domManip(arguments,!0,function(a){this.nodeType===1&&this.appendChild(a)})},prepend:function(){return this.domManip(arguments,!0,function(a){this.nodeType===1&&this.insertBefore(a,this.firstChild)})},before:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,!1,function(a){this.parentNode.insertBefore(a,this)});if(arguments.length){var a=f
.clean(arguments);a.push.apply(a,this.toArray());return this.pushStack(a,"before",arguments)}},after:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,!1,function(a){this.parentNode.insertBefore(a,this.nextSibling)});if(arguments.length){var a=this.pushStack(this,"after",arguments);a.push.apply(a,f.clean(arguments));return a}},remove:function(a,b){for(var c=0,d;(d=this[c])!=null;c++)if(!a||f.filter(a,[d]).length)!b&&d.nodeType===1&&(f.cleanData(d.getElementsByTagName("*")),f.cleanData([d])),d.parentNode&&d.parentNode.removeChild(d);return this},empty:function(){for(var a=0,b;(b=this[a])!=null;a++){b.nodeType===1&&f.cleanData(b.getElementsByTagName("*"));while(b.firstChild)b.removeChild(b.firstChild)}return this},clone:function(a,b){a=a==null?!1:a,b=b==null?a:b;return this.map(function(){return f.clone(this,a,b)})},html:function(a){return f.access(this,function(a){var c=this[0]||{},d=0,e=this.length;if(a===b)return c.nodeType===1?c.innerHTML.replace(W,""):null;if(typeof a=="string"&&!ba.test(a)&&(f.support.leadingWhitespace||!X.test(a))&&!bg[(Z.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(Y,"<$1></$2>");try{for(;d<e;d++)c=this[d]||{},c.nodeType===1&&(f.cleanData(c.getElementsByTagName("*")),c.innerHTML=a);c=0}catch(g){}}c&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(a){if(this[0]&&this[0].parentNode){if(f.isFunction(a))return this.each(function(b){var c=f(this),d=c.html();c.replaceWith(a.call(this,b,d))});typeof a!="string"&&(a=f(a).detach());return this.each(function(){var b=this.nextSibling,c=this.parentNode;f(this).remove(),b?f(b).before(a):f(c).append(a)})}return this.length?this.pushStack(f(f.isFunction(a)?a():a),"replaceWith",a):this},detach:function(a){return this.remove(a,!0)},domManip:function(a,c,d){var e,g,h,i,j=a[0],k=[];if(!f.support.checkClone&&arguments.length===3&&typeof j=="string"&&bd.test(j))return this.each(function(){f(this).domManip(a,c,d,!0)});if(f.isFunction(j))return this.each(function(e){var g=f(this);a[0]=j.call(this,e,c?g.html():b),g.domManip(a,c,d)});if(this[0]){i=j&&j.parentNode,f.support.parentNode&&i&&i.nodeType===11&&i.childNodes.length===this.length?e={fragment:i}:e=f.buildFragment(a,this,k),h=e.fragment,h.childNodes.length===1?g=h=h.firstChild:g=h.firstChild;if(g){c=c&&f.nodeName(g,"tr");for(var l=0,m=this.length,n=m-1;l<m;l++)d.call(c?bi(this[l],g):this[l],e.cacheable||m>1&&l<n?f.clone(h,!0,!0):h)}k.length&&f.each(k,function(a,b){b.src?f.ajax({type:"GET",global:!1,url:b.src,async:!1,dataType:"script"}):f.globalEval((b.text||b.textContent||b.innerHTML||"").replace(bf,"/*$0*/")),b.parentNode&&b.parentNode.removeChild(b)})}return this}}),f.buildFragment=function(a,b,d){var e,g,h,i,j=a[0];b&&b[0]&&(i=b[0].ownerDocument||b[0]),i.createDocumentFragment||(i=c),a.length===1&&typeof j=="string"&&j.length<512&&i===c&&j.charAt(0)==="<"&&!bb.test(j)&&(f.support.checkClone||!bd.test(j))&&(f.support.html5Clone||!bc.test(j))&&(g=!0,h=f.fragments[j],h&&h!==1&&(e=h)),e||(e=i.createDocumentFragment(),f.clean(a,i,e,d)),g&&(f.fragments[j]=h?e:1);return{fragment:e,cacheable:g}},f.fragments={},f.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){f.fn[a]=function(c){var d=[],e=f(c),g=this.length===1&&this[0].parentNode;if(g&&g.nodeType===11&&g.childNodes.length===1&&e.length===1){e[b](this[0]);return this}for(var h=0,i=e.length;h<i;h++){var j=(h>0?this.clone(!0):this).get();f(e[h])[b](j),d=d.concat(j)}return this.pushStack(d,a,e.selector)}}),f.extend({clone:function(a,b,c){var d,e,g,h=f.support.html5Clone||f.isXMLDoc(a)||!bc.test("<"+a.nodeName+">")?a.cloneNode(!0):bo(a);if((!f.support.noCloneEvent||!f.support.noCloneChecked)&&(a.nodeType===1||a.nodeType===11)&&!f.isXMLDoc(a)){bk(a,h),d=bl(a),e=bl(h);for(g=0;d[g];++g)e[g]&&bk(d[g],e[g])}if(b){bj(a,h);if(c){d=bl(a),e=bl(h);for(g=0;d[g];++g)bj(d[g],e[g])}}d=e=null;return h},clean:function(a,b,d,e){var g,h,i,j=[];b=b||c,typeof b.createElement=="undefined"&&(b=b.ownerDocument||b[0]&&b[0].ownerDocument||c);for(var k=0,l;(l=a[k])!=null;k++){typeof l=="number"&&(l+="");if(!l)continue;if(typeof l=="string")if(!_.test(l))l=b.createTextNode(l);else{l=l.replace(Y,"<$1></$2>");var m=(Z.exec(l)||["",""])[1].toLowerCase(),n=bg[m]||bg._default,o=n[0],p=b.createElement("div"),q=bh.childNodes,r;b===c?bh.appendChild(p):U(b).appendChild(p),p.innerHTML=n[1]+l+n[2];while(o--)p=p.lastChild;if(!f.support.tbody){var s=$.test(l),t=m==="table"&&!s?p.firstChild&&p.firstChild.childNodes:n[1]==="<table>"&&!s?p.childNodes:[];for(i=t.length-1;i>=0;--i)f.nodeName(t[i],"tbody")&&!t[i].childNodes.length&&t[i].parentNode.removeChild(t[i])}!f.support.leadingWhitespace&&X.test(l)&&p.insertBefore(b.createTextNode(X.exec(l)[0]),p.firstChild),l=p.childNodes,p&&(p.parentNode.removeChild(p),q.length>0&&(r=q[q.length-1],r&&r.parentNode&&r.parentNode.removeChild(r)))}var u;if(!f.support.appendChecked)if(l[0]&&typeof (u=l.length)=="number")for(i=0;i<u;i++)bn(l[i]);else bn(l);l.nodeType?j.push(l):j=f.merge(j,l)}if(d){g=function(a){return!a.type||be.test(a.type)};for(k=0;j[k];k++){h=j[k];if(e&&f.nodeName(h,"script")&&(!h.type||be.test(h.type)))e.push(h.parentNode?h.parentNode.removeChild(h):h);else{if(h.nodeType===1){var v=f.grep(h.getElementsByTagName("script"),g);j.splice.apply(j,[k+1,0].concat(v))}d.appendChild(h)}}}return j},cleanData:function(a){var b,c,d=f.cache,e=f.event.special,g=f.support.deleteExpando;for(var h=0,i;(i=a[h])!=null;h++){if(i.nodeName&&f.noData[i.nodeName.toLowerCase()])continue;c=i[f.expando];if(c){b=d[c];if(b&&b.events){for(var j in b.events)e[j]?f.event.remove(i,j):f.removeEvent(i,j,b.handle);b.handle&&(b.handle.elem=null)}g?delete i[f.expando]:i.removeAttribute&&i.removeAttribute(f.expando),delete d[c]}}}});var bp=/alpha\([^)]*\)/i,bq=/opacity=([^)]*)/,br=/([A-Z]|^ms)/g,bs=/^[\-+]?(?:\d*\.)?\d+$/i,bt=/^-?(?:\d*\.)?\d+(?!px)[^\d\s]+$/i,bu=/^([\-+])=([\-+.\de]+)/,bv=/^margin/,bw={position:"absolute",visibility:"hidden",display:"block"},bx=["Top","Right","Bottom","Left"],by,bz,bA;f.fn.css=function(a,c){return f.access(this,function(a,c,d){return d!==b?f.style(a,c,d):f.css(a,c)},a,c,arguments.length>1)},f.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=by(a,"opacity");return c===""?"1":c}return a.style.opacity}}},cssNumber:{fillOpacity:!0,fontWeight:!0,lineHeight:!0,opacity:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":f.support.cssFloat?"cssFloat":"styleFloat"},style:function(a,c,d,e){if(!!a&&a.nodeType!==3&&a.nodeType!==8&&!!a.style){var g,h,i=f.camelCase(c),j=a.style,k=f.cssHooks[i];c=f.cssProps[i]||i;if(d===b){if(k&&"get"in k&&(g=k.get(a,!1,e))!==b)return g;return j[c]}h=typeof d,h==="string"&&(g=bu.exec(d))&&(d=+(g[1]+1)*+g[2]+parseFloat(f.css(a,c)),h="number");if(d==null||h==="number"&&isNaN(d))return;h==="number"&&!f.cssNumber[i]&&(d+="px");if(!k||!("set"in k)||(d=k.set(a,d))!==b)try{j[c]=d}catch(l){}}},css:function(a,c,d){var e,g;c=f.camelCase(c),g=f.cssHooks[c],c=f.cssProps[c]||c,c==="cssFloat"&&(c="float");if(g&&"get"in g&&(e=g.get(a,!0,d))!==b)return e;if(by)return by(a,c)},swap:function(a,b,c){var d={},e,f;for(f in b)d[f]=a.style[f],a.style[f]=b[f];e=c.call(a);for(f in b)a.style[f]=d[f];return e}}),f.curCSS=f.css,c.defaultView&&c.defaultView.getComputedStyle&&(bz=function(a,b){var c,d,e,g,h=a.style;b=b.replace(br,"-$1").toLowerCase(),(d=a.ownerDocument.defaultView)&&(e=d.getComputedStyle(a,null))&&(c=e.getPropertyValue(b),c===""&&!f.contains(a.ownerDocument.documentElement,a)&&(c=f.style(a,b))),!f.support.pixelMargin&&e&&bv.test(b)&&bt.test(c)&&(g=h.width,h.width=c,c=e.width,h.width=g);return c}),c.documentElement.currentStyle&&(bA=function(a,b){var c,d,e,f=a.currentStyle&&a.currentStyle[b],g=a.style;f==null&&g&&(e=g[b])&&(f=e),bt.test(f)&&(c=g.left,d=a.runtimeStyle&&a.runtimeStyle.left,d&&(a.runtimeStyle.left=a.currentStyle.left),g.left=b==="fontSize"?"1em":f,f=g.pixelLeft+"px",g.left=c,d&&(a.runtimeStyle.left=d));return f===""?"auto":f}),by=bz||bA,f.each(["height","width"],function(a,b){f.cssHooks[b]={get:function(a,c,d){if(c)return a.offsetWidth!==0?bB(a,b,d):f.swap(a,bw,function(){return bB(a,b,d)})},set:function(a,b){return bs.test(b)?b+"px":b}}}),f.support.opacity||(f.cssHooks.opacity={get:function(a,b){return bq.test((b&&a.currentStyle?a.currentStyle.filter:a.style.filter)||"")?parseFloat(RegExp.$1)/100+"":b?"1":""},set:function(a,b){var c=a.style,d=a.currentStyle,e=f.isNumeric(b)?"alpha(opacity="+b*100+")":"",g=d&&d.filter||c.filter||"";c.zoom=1;if(b>=1&&f.trim(g.replace(bp,""))===""){c.removeAttribute("filter");if(d&&!d.filter)return}c.filter=bp.test(g)?g.replace(bp,e):g+" "+e}}),f(function(){f.support.reliableMarginRight||(f.cssHooks.marginRight={get:function(a,b){return f.swap(a,{display:"inline-block"},function(){return b?by(a,"margin-right"):a.style.marginRight})}})}),f.expr&&f.expr.filters&&(f.expr.filters.hidden=function(a){var b=a.offsetWidth,c=a.offsetHeight;return b===0&&c===0||!f.support.reliableHiddenOffsets&&(a.style&&a.style.display||f.css(a,"display"))==="none"},f.expr.filters.visible=function(a){return!f.expr.filters.hidden(a)}),f.each({margin:"",padding:"",border:"Width"},function(a,b){f.cssHooks[a+b]={expand:function(c){var d,e=typeof c=="string"?c.split(" "):[c],f={};for(d=0;d<4;d++)f[a+bx[d]+b]=e[d]||e[d-2]||e[0];return f}}});var bC=/%20/g,bD=/\[\]$/,bE=/\r?\n/g,bF=/#.*$/,bG=/^(.*?):[ \t]*([^\r\n]*)\r?$/mg,bH=/^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,bI=/^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,bJ=/^(?:GET|HEAD)$/,bK=/^\/\//,bL=/\?/,bM=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,bN=/^(?:select|textarea)/i,bO=/\s+/,bP=/([?&])_=[^&]*/,bQ=/^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+))?)?/,bR=f.fn.load,bS={},bT={},bU,bV,bW=["*/"]+["*"];try{bU=e.href}catch(bX){bU=c.createElement("a"),bU.href="",bU=bU.href}bV=bQ.exec(bU.toLowerCase())||[],f.fn.extend({load:function(a,c,d){if(typeof a!="string"&&bR)return bR.apply(this,arguments);if(!this.length)return this;var e=a.indexOf(" ");if(e>=0){var g=a.slice(e,a.length);a=a.slice(0,e)}var h="GET";c&&(f.isFunction(c)?(d=c,c=b):typeof c=="object"&&(c=f.param(c,f.ajaxSettings.traditional),h="POST"));var i=this;f.ajax({url:a,type:h,dataType:"html",data:c,complete:function(a,b,c){c=a.responseText,a.isResolved()&&(a.done(function(a){c=a}),i.html(g?f("<div>").append(c.replace(bM,"")).find(g):c)),d&&i.each(d,[c,b,a])}});return this},serialize:function(){return f.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?f.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||bN.test(this.nodeName)||bH.test(this.type))}).map(function(a,b){var c=f(this).val();return c==null?null:f.isArray(c)?f.map(c,function(a,c){return{name:b.name,value:a.replace(bE,"\r\n")}}):{name:b.name,value:c.replace(bE,"\r\n")}}).get()}}),f.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),function(a,b){f.fn[b]=function(a){return this.on(b,a)}}),f.each(["get","post"],function(a,c){f[c]=function(a,d,e,g){f.isFunction(d)&&(g=g||e,e=d,d=b);return f.ajax({type:c,url:a,data:d,success:e,dataType:g})}}),f.extend({getScript:function(a,c){return f.get(a,b,c,"script")},getJSON:function(a,b,c){return f.get(a,b,c,"json")},ajaxSetup:function(a,b){b?b$(a,f.ajaxSettings):(b=a,a=f.ajaxSettings),b$(a,b);return a},ajaxSettings:{url:bU,isLocal:bI.test(bV[1]),global:!0,type:"GET",contentType:"application/x-www-form-urlencoded; charset=UTF-8",processData:!0,async:!0,accepts:{xml:"application/xml, text/xml",html:"text/html",text:"text/plain",json:"application/json, text/javascript","*":bW},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText"},converters:{"* text":a.String,"text html":!0,"text json":f.parseJSON,"text xml":f.parseXML},flatOptions:{context:!0,url:!0}},ajaxPrefilter:bY(bS),ajaxTransport:bY(bT),ajax:function(a,c){function w(a,c,l,m){if(s!==2){s=2,q&&clearTimeout(q),p=b,n=m||"",v.readyState=a>0?4:0;var o,r,u,w=c,x=l?ca(d,v,l):b,y,z;if(a>=200&&a<300||a===304){if(d.ifModified){if(y=v.getResponseHeader("Last-Modified"))f.lastModified[k]=y;if(z=v.getResponseHeader("Etag"))f.etag[k]=z}if(a===304)w="notmodified",o=!0;else try{r=cb(d,x),w="success",o=!0}catch(A){w="parsererror",u=A}}else{u=w;if(!w||a)w="error",a<0&&(a=0)}v.status=a,v.statusText=""+(c||w),o?h.resolveWith(e,[r,w,v]):h.rejectWith(e,[v,w,u]),v.statusCode(j),j=b,t&&g.trigger("ajax"+(o?"Success":"Error"),[v,d,o?r:u]),i.fireWith(e,[v,w]),t&&(g.trigger("ajaxComplete",[v,d]),--f.active||f.event.trigger("ajaxStop"))}}typeof a=="object"&&(c=a,a=b),c=c||{};var d=f.ajaxSetup({},c),e=d.context||d,g=e!==d&&(e.nodeType||e instanceof f)?f(e):f.event,h=f.Deferred(),i=f.Callbacks("once memory"),j=d.statusCode||{},k,l={},m={},n,o,p,q,r,s=0,t,u,v={readyState:0,setRequestHeader:function(a,b){if(!s){var c=a.toLowerCase();a=m[c]=m[c]||a,l[a]=b}return this},getAllResponseHeaders:function(){return s===2?n:null},getResponseHeader:function(a){var c;if(s===2){if(!o){o={};while(c=bG.exec(n))o[c[1].toLowerCase()]=c[2]}c=o[a.toLowerCase()]}return c===b?null:c},overrideMimeType:function(a){s||(d.mimeType=a);return this},abort:function(a){a=a||"abort",p&&p.abort(a),w(0,a);return this}};h.promise(v),v.success=v.done,v.error=v.fail,v.complete=i.add,v.statusCode=function(a){if(a){var b;if(s<2)for(b in a)j[b]=[j[b],a[b]];else b=a[v.status],v.then(b,b)}return this},d.url=((a||d.url)+"").replace(bF,"").replace(bK,bV[1]+"//"),d.dataTypes=f.trim(d.dataType||"*").toLowerCase().split(bO),d.crossDomain==null&&(r=bQ.exec(d.url.toLowerCase()),d.crossDomain=!(!r||r[1]==bV[1]&&r[2]==bV[2]&&(r[3]||(r[1]==="http:"?80:443))==(bV[3]||(bV[1]==="http:"?80:443)))),d.data&&d.processData&&typeof d.data!="string"&&(d.data=f.param(d.data,d.traditional)),bZ(bS,d,c,v);if(s===2)return!1;t=d.global,d.type=d.type.toUpperCase(),d.hasContent=!bJ.test(d.type),t&&f.active++===0&&f.event.trigger("ajaxStart");if(!d.hasContent){d.data&&(d.url+=(bL.test(d.url)?"&":"?")+d.data,delete d.data),k=d.url;if(d.cache===!1){var x=f.now(),y=d.url.replace(bP,"$1_="+x);d.url=y+(y===d.url?(bL.test(d.url)?"&":"?")+"_="+x:"")}}(d.data&&d.hasContent&&d.contentType!==!1||c.contentType)&&v.setRequestHeader("Content-Type",d.contentType),d.ifModified&&(k=k||d.url,f.lastModified[k]&&v.setRequestHeader("If-Modified-Since",f.lastModified[k]),f.etag[k]&&v.setRequestHeader("If-None-Match",f.etag[k])),v.setRequestHeader("Accept",d.dataTypes[0]&&d.accepts[d.dataTypes[0]]?d.accepts[d.dataTypes[0]]+(d.dataTypes[0]!=="*"?", "+bW+"; q=0.01":""):d.accepts["*"]);for(u in d.headers)v.setRequestHeader(u,d.headers[u]);if(d.beforeSend&&(d.beforeSend.call(e,v,d)===!1||s===2)){v.abort();return!1}for(u in{success:1,error:1,complete:1})v[u](d[u]);p=bZ(bT,d,c,v);if(!p)w(-1,"No Transport");else{v.readyState=1,t&&g.trigger("ajaxSend",[v,d]),d.async&&d.timeout>0&&(q=setTimeout(function(){v.abort("timeout")},d.timeout));try{s=1,p.send(l,w)}catch(z){if(s<2)w(-1,z);else throw z}}return v},param:function(a,c){var d=[],e=function(a,b){b=f.isFunction(b)?b():b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};c===b&&(c=f.ajaxSettings.traditional);if(f.isArray(a)||a.jquery&&!f.isPlainObject(a))f.each(a,function(){e(this.name,this.value)});else for(var g in a)b_(g,a[g],c,e);return d.join("&").replace(bC,"+")}}),f.extend({active:0,lastModified:{},etag:{}});var cc=f.now(),cd=/(\=)\?(&|$)|\?\?/i;f.ajaxSetup({jsonp:"callback",jsonpCallback:function(){return f.expando+"_"+cc++}}),f.ajaxPrefilter("json jsonp",function(b,c,d){var e=typeof b.data=="string"&&/^application\/x\-www\-form\-urlencoded/.test(b.contentType);if(b.dataTypes[0]==="jsonp"||b.jsonp!==!1&&(cd.test(b.url)||e&&cd.test(b.data))){var g,h=b.jsonpCallback=f.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,i=a[h],j=b.url,k=b.data,l="$1"+h+"$2";b.jsonp!==!1&&(j=j.replace(cd,l),b.url===j&&(e&&(k=k.replace(cd,l)),b.data===k&&(j+=(/\?/.test(j)?"&":"?")+b.jsonp+"="+h))),b.url=j,b.data=k,a[h]=function(a){g=[a]},d.always(function(){a[h]=i,g&&f.isFunction(i)&&a[h](g[0])}),b.converters["script json"]=function(){g||f.error(h+" was not called");return g[0]},b.dataTypes[0]="json";return"script"}}),f.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/javascript|ecmascript/},converters:{"text script":function(a){f.globalEval(a);return a}}}),f.ajaxPrefilter("script",function(a){a.cache===b&&(a.cache=!1),a.crossDomain&&(a.type="GET",a.global=!1)}),f.ajaxTransport("script",function(a){if(a.crossDomain){var d,e=c.head||c.getElementsByTagName("head")[0]||c.documentElement;return{send:function(f,g){d=c.createElement("script"),d.async="async",a.scriptCharset&&(d.charset=a.scriptCharset),d.src=a.url,d.onload=d.onreadystatechange=function(a,c){if(c||!d.readyState||/loaded|complete/.test(d.readyState))d.onload=d.onreadystatechange=null,e&&d.parentNode&&e.removeChild(d),d=b,c||g(200,"success")},e.insertBefore(d,e.firstChild)},abort:function(){d&&d.onload(0,1)}}}});var ce=a.ActiveXObject?function(){for(var a in cg)cg[a](0,1)}:!1,cf=0,cg;f.ajaxSettings.xhr=a.ActiveXObject?function(){return!this.isLocal&&ch()||ci()}:ch,function(a){f.extend(f.support,{ajax:!!a,cors:!!a&&"withCredentials"in a})}(f.ajaxSettings.xhr()),f.support.ajax&&f.ajaxTransport(function(c){if(!c.crossDomain||f.support.cors){var d;return{send:function(e,g){var h=c.xhr(),i,j;c.username?h.open(c.type,c.url,c.async,c.username,c.password):h.open(c.type,c.url,c.async);if(c.xhrFields)for(j in c.xhrFields)h[j]=c.xhrFields[j];c.mimeType&&h.overrideMimeType&&h.overrideMimeType(c.mimeType),!c.crossDomain&&!e["X-Requested-With"]&&(e["X-Requested-With"]="XMLHttpRequest");try{for(j in e)h.setRequestHeader(j,e[j])}catch(k){}h.send(c.hasContent&&c.data||null),d=function(a,e){var j,k,l,m,n;try{if(d&&(e||h.readyState===4)){d=b,i&&(h.onreadystatechange=f.noop,ce&&delete cg[i]);if(e)h.readyState!==4&&h.abort();else{j=h.status,l=h.getAllResponseHeaders(),m={},n=h.responseXML,n&&n.documentElement&&(m.xml=n);try{m.text=h.responseText}catch(a){}try{k=h.statusText}catch(o){k=""}!j&&c.isLocal&&!c.crossDomain?j=m.text?200:404:j===1223&&(j=204)}}}catch(p){e||g(-1,p)}m&&g(j,k,m,l)},!c.async||h.readyState===4?d():(i=++cf,ce&&(cg||(cg={},f(a).unload(ce)),cg[i]=d),h.onreadystatechange=d)},abort:function(){d&&d(0,1)}}}});var cj={},ck,cl,cm=/^(?:toggle|show|hide)$/,cn=/^([+\-]=)?([\d+.\-]+)([a-z%]*)$/i,co,cp=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]],cq;f.fn.extend({show:function(a,b,c){var d,e;if(a||a===0)return this.animate(ct("show",3),a,b,c);for(var g=0,h=this.length;g<h;g++)d=this[g],d.style&&(e=d.style.display,!f._data(d,"olddisplay")&&e==="none"&&(e=d.style.display=""),(e===""&&f.css(d,"display")==="none"||!f.contains(d.ownerDocument.documentElement,d))&&f._data(d,"olddisplay",cu(d.nodeName)));for(g=0;g<h;g++){d=this[g];if(d.style){e=d.style.display;if(e===""||e==="none")d.style.display=f._data(d,"olddisplay")||""}}return this},hide:function(a,b,c){if(a||a===0)return this.animate(ct("hide",3),a,b,c);var d,e,g=0,h=this.length;for(;g<h;g++)d=this[g],d.style&&(e=f.css(d,"display"),e!=="none"&&!f._data(d,"olddisplay")&&f._data(d,"olddisplay",e));for(g=0;g<h;g++)this[g].style&&(this[g].style.display="none");return this},_toggle:f.fn.toggle,toggle:function(a,b,c){var d=typeof a=="boolean";f.isFunction(a)&&f.isFunction(b)?this._toggle.apply(this,arguments):a==null||d?this.each(function(){var b=d?a:f(this).is(":hidden");f(this)[b?"show":"hide"]()}):this.animate(ct("toggle",3),a,b,c);return this},fadeTo:function(a,b,c,d){return this.filter(":hidden").css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){function g(){e.queue===!1&&f._mark(this);var b=f.extend({},e),c=this.nodeType===1,d=c&&f(this).is(":hidden"),g,h,i,j,k,l,m,n,o,p,q;b.animatedProperties={};for(i in a){g=f.camelCase(i),i!==g&&(a[g]=a[i],delete a[i]);if((k=f.cssHooks[g])&&"expand"in k){l=k.expand(a[g]),delete a[g];for(i in l)i in a||(a[i]=l[i])}}for(g in a){h=a[g],f.isArray(h)?(b.animatedProperties[g]=h[1],h=a[g]=h[0]):b.animatedProperties[g]=b.specialEasing&&b.specialEasing[g]||b.easing||"swing";if(h==="hide"&&d||h==="show"&&!d)return b.complete.call(this);c&&(g==="height"||g==="width")&&(b.overflow=[this.style.overflow,this.style.overflowX,this.style.overflowY],f.css(this,"display")==="inline"&&f.css(this,"float")==="none"&&(!f.support.inlineBlockNeedsLayout||cu(this.nodeName)==="inline"?this.style.display="inline-block":this.style.zoom=1))}b.overflow!=null&&(this.style.overflow="hidden");for(i in a)j=new f.fx(this,b,i),h=a[i],cm.test(h)?(q=f._data(this,"toggle"+i)||(h==="toggle"?d?"show":"hide":0),q?(f._data(this,"toggle"+i,q==="show"?"hide":"show"),j[q]()):j[h]()):(m=cn.exec(h),n=j.cur(),m?(o=parseFloat(m[2]),p=m[3]||(f.cssNumber[i]?"":"px"),p!=="px"&&(f.style(this,i,(o||1)+p),n=(o||1)/j.cur()*n,f.style(this,i,n+p)),m[1]&&(o=(m[1]==="-="?-1:1)*o+n),j.custom(n,o,p)):j.custom(n,h,""));return!0}var e=f.speed(b,c,d);if(f.isEmptyObject(a))return this.each(e.complete,[!1]);a=f.extend({},a);return e.queue===!1?this.each(g):this.queue(e.queue,g)},stop:function(a,c,d){typeof a!="string"&&(d=c,c=a,a=b),c&&a!==!1&&this.queue(a||"fx",[]);return this.each(function(){function h(a,b,c){var e=b[c];f.removeData(a,c,!0),e.stop(d)}var b,c=!1,e=f.timers,g=f._data(this);d||f._unmark(!0,this);if(a==null)for(b in g)g[b]&&g[b].stop&&b.indexOf(".run")===b.length-4&&h(this,g,b);else g[b=a+".run"]&&g[b].stop&&h(this,g,b);for(b=e.length;b--;)e[b].elem===this&&(a==null||e[b].queue===a)&&(d?e[b](!0):e[b].saveState(),c=!0,e.splice(b,1));(!d||!c)&&f.dequeue(this,a)})}}),f.each({slideDown:ct("show",1),slideUp:ct("hide",1),slideToggle:ct("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){f.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),f.extend({speed:function(a,b,c){var d=a&&typeof a=="object"?f.extend({},a):{complete:c||!c&&b||f.isFunction(a)&&a,duration:a,easing:c&&b||b&&!f.isFunction(b)&&b};d.duration=f.fx.off?0:typeof d.duration=="number"?d.duration:d.duration in f.fx.speeds?f.fx.speeds[d.duration]:f.fx.speeds._default;if(d.queue==null||d.queue===!0)d.queue="fx";d.old=d.complete,d.complete=function(a){f.isFunction(d.old)&&d.old.call(this),d.queue?f.dequeue(this,d.queue):a!==!1&&f._unmark(this)};return d},easing:{linear:function(a){return a},swing:function(a){return-Math.cos(a*Math.PI)/2+.5}},timers:[],fx:function(a,b,c){this.options=b,this.elem=a,this.prop=c,b.orig=b.orig||{}}}),f.fx.prototype={update:function(){this.options.step&&this.options.step.call(this.elem,this.now,this),(f.fx.step[this.prop]||f.fx.step._default)(this)},cur:function(){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null))return this.elem[this.prop];var a,b=f.css(this.elem,this.prop);return isNaN(a=parseFloat(b))?!b||b==="auto"?0:b:a},custom:function(a,c,d){function h(a){return e.step(a)}var e=this,g=f.fx;this.startTime=cq||cr(),this.end=c,this.now=this.start=a,this.pos=this.state=0,this.unit=d||this.unit||(f.cssNumber[this.prop]?"":"px"),h.queue=this.options.queue,h.elem=this.elem,h.saveState=function(){f._data(e.elem,"fxshow"+e.prop)===b&&(e.options.hide?f._data(e.elem,"fxshow"+e.prop,e.start):e.options.show&&f._data(e.elem,"fxshow"+e.prop,e.end))},h()&&f.timers.push(h)&&!co&&(co=setInterval(g.tick,g.interval))},show:function(){var a=f._data(this.elem,"fxshow"+this.prop);this.options.orig[this.prop]=a||f.style(this.elem,this.prop),this.options.show=!0,a!==b?this.custom(this.cur(),a):this.custom(this.prop==="width"||this.prop==="height"?1:0,this.cur()),f(this.elem).show()},hide:function(){this.options.orig[this.prop]=f._data(this.elem,"fxshow"+this.prop)||f.style(this.elem,this.prop),this.options.hide=!0,this.custom(this.cur(),0)},step:function(a){var b,c,d,e=cq||cr(),g=!0,h=this.elem,i=this.options;if(a||e>=i.duration+this.startTime){this.now=this.end,this.pos=this.state=1,this.update(),i.animatedProperties[this.prop]=!0;for(b in i.animatedProperties)i.animatedProperties[b]!==!0&&(g=!1);if(g){i.overflow!=null&&!f.support.shrinkWrapBlocks&&f.each(["","X","Y"],function(a,b){h.style["overflow"+b]=i.overflow[a]}),i.hide&&f(h).hide();if(i.hide||i.show)for(b in i.animatedProperties)f.style(h,b,i.orig[b]),f.removeData(h,"fxshow"+b,!0),f.removeData(h,"toggle"+b,!0);d=i.complete,d&&(i.complete=!1,d.call(h))}return!1}i.duration==Infinity?this.now=e:(c=e-this.startTime,this.state=c/i.duration,this.pos=f.easing[i.animatedProperties[this.prop]](this.state,c,0,1,i.duration),this.now=this.start+(this.end-this.start)*this.pos),this.update();return!0}},f.extend(f.fx,{tick:function(){var a,b=f.timers,c=0;for(;c<b.length;c++)a=b[c],!a()&&b[c]===a&&b.splice(c--,1);b.length||f.fx.stop()},interval:13,stop:function(){clearInterval(co),co=null},speeds:{slow:600,fast:200,_default:400},step:{opacity:function(a){f.style(a.elem,"opacity",a.now)},_default:function(a){a.elem.style&&a.elem.style[a.prop]!=null?a.elem.style[a.prop]=a.now+a.unit:a.elem[a.prop]=a.now}}}),f.each(cp.concat.apply([],cp),function(a,b){b.indexOf("margin")&&(f.fx.step[b]=function(a){f.style(a.elem,b,Math.max(0,a.now)+a.unit)})}),f.expr&&f.expr.filters&&(f.expr.filters.animated=function(a){return f.grep(f.timers,function(b){return a===b.elem}).length});var cv,cw=/^t(?:able|d|h)$/i,cx=/^(?:body|html)$/i;"getBoundingClientRect"in c.documentElement?cv=function(a,b,c,d){try{d=a.getBoundingClientRect()}catch(e){}if(!d||!f.contains(c,a))return d?{top:d.top,left:d.left}:{top:0,left:0};var g=b.body,h=cy(b),i=c.clientTop||g.clientTop||0,j=c.clientLeft||g.clientLeft||0,k=h.pageYOffset||f.support.boxModel&&c.scrollTop||g.scrollTop,l=h.pageXOffset||f.support.boxModel&&c.scrollLeft||g.scrollLeft,m=d.top+k-i,n=d.left+l-j;return{top:m,left:n}}:cv=function(a,b,c){var d,e=a.offsetParent,g=a,h=b.body,i=b.defaultView,j=i?i.getComputedStyle(a,null):a.currentStyle,k=a.offsetTop,l=a.offsetLeft;while((a=a.parentNode)&&a!==h&&a!==c){if(f.support.fixedPosition&&j.position==="fixed")break;d=i?i.getComputedStyle(a,null):a.currentStyle,k-=a.scrollTop,l-=a.scrollLeft,a===e&&(k+=a.offsetTop,l+=a.offsetLeft,f.support.doesNotAddBorder&&(!f.support.doesAddBorderForTableAndCells||!cw.test(a.nodeName))&&(k+=parseFloat(d.borderTopWidth)||0,l+=parseFloat(d.borderLeftWidth)||0),g=e,e=a.offsetParent),f.support.subtractsBorderForOverflowNotVisible&&d.overflow!=="visible"&&(k+=parseFloat(d.borderTopWidth)||0,l+=parseFloat(d.borderLeftWidth)||0),j=d}if(j.position==="relative"||j.position==="static")k+=h.offsetTop,l+=h.offsetLeft;f.support.fixedPosition&&j.position==="fixed"&&(k+=Math.max(c.scrollTop,h.scrollTop),l+=Math.max(c.scrollLeft,h.scrollLeft));return{top:k,left:l}},f.fn.offset=function(a){if(arguments.length)return a===b?this:this.each(function(b){f.offset.setOffset(this,a,b)});var c=this[0],d=c&&c.ownerDocument;if(!d)return null;if(c===d.body)return f.offset.bodyOffset(c);return cv(c,d,d.documentElement)},f.offset={bodyOffset:function(a){var b=a.offsetTop,c=a.offsetLeft;f.support.doesNotIncludeMarginInBodyOffset&&(b+=parseFloat(f.css(a,"marginTop"))||0,c+=parseFloat(f.css(a,"marginLeft"))||0);return{top:b,left:c}},setOffset:function(a,b,c){var d=f.css(a,"position");d==="static"&&(a.style.position="relative");var e=f(a),g=e.offset(),h=f.css(a,"top"),i=f.css(a,"left"),j=(d==="absolute"||d==="fixed")&&f.inArray("auto",[h,i])>-1,k={},l={},m,n;j?(l=e.position(),m=l.top,n=l.left):(m=parseFloat(h)||0,n=parseFloat(i)||0),f.isFunction(b)&&(b=b.call(a,c,g)),b.top!=null&&(k.top=b.top-g.top+m),b.left!=null&&(k.left=b.left-g.left+n),"using"in b?b.using.call(a,k):e.css(k)}},f.fn.extend({position:function(){if(!this[0])return null;var a=this[0],b=this.offsetParent(),c=this.offset(),d=cx.test(b[0].nodeName)?{top:0,left:0}:b.offset();c.top-=parseFloat(f.css(a,"marginTop"))||0,c.left-=parseFloat(f.css(a,"marginLeft"))||0,d.top+=parseFloat(f.css(b[0],"borderTopWidth"))||0,d.left+=parseFloat(f.css(b[0],"borderLeftWidth"))||0;return{top:c.top-d.top,left:c.left-d.left}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||c.body;while(a&&!cx.test(a.nodeName)&&f.css(a,"position")==="static")a=a.offsetParent;return a})}}),f.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(a,c){var d=/Y/.test(c);f.fn[a]=function(e){return f.access(this,function(a,e,g){var h=cy(a);if(g===b)return h?c in h?h[c]:f.support.boxModel&&h.document.documentElement[e]||h.document.body[e]:a[e];h?h.scrollTo(d?f(h).scrollLeft():g,d?g:f(h).scrollTop()):a[e]=g},a,e,arguments.length,null)}}),f.each({Height:"height",Width:"width"},function(a,c){var d="client"+a,e="scroll"+a,g="offset"+a;f.fn["inner"+a]=function(){var a=this[0];return a?a.style?parseFloat(f.css(a,c,"padding")):this[c]():null},f.fn["outer"+a]=function(a){var b=this[0];return b?b.style?parseFloat(f.css(b,c,a?"margin":"border")):this[c]():null},f.fn[c]=function(a){return f.access(this,function(a,c,h){var i,j,k,l;if(f.isWindow(a)){i=a.document,j=i.documentElement[d];return f.support.boxModel&&j||i.body&&i.body[d]||j}if(a.nodeType===9){i=a.documentElement;if(i[d]>=i[e])return i[d];return Math.max(a.body[e],i[e],a.body[g],i[g])}if(h===b){k=f.css(a,c),l=parseFloat(k);return f.isNumeric(l)?l:k}f(a).css(c,h)},c,a,arguments.length,null)}}),a.jQuery=a.$=f,typeof define=="function"&&define.amd&&define.amd.jQuery&&define("jquery",[],function(){return f})})(window);

/* jQuery UI 1.8.18 */
(function(a,b){function d(b){return!a(b).parents().andSelf().filter(function(){return a.curCSS(this,"visibility")==="hidden"||a.expr.filters.hidden(this)}).length}function c(b,c){var e=b.nodeName.toLowerCase();if("area"===e){var f=b.parentNode,g=f.name,h;if(!b.href||!g||f.nodeName.toLowerCase()!=="map")return!1;h=a("img[usemap=#"+g+"]")[0];return!!h&&d(h)}return(/input|select|textarea|button|object/.test(e)?!b.disabled:"a"==e?b.href||c:c)&&d(b)}a.ui=a.ui||{};a.ui.version||(a.extend(a.ui,{version:"1.8.18",keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91}}),a.fn.extend({propAttr:a.fn.prop||a.fn.attr,_focus:a.fn.focus,focus:function(b,c){return typeof b=="number"?this.each(function(){var d=this;setTimeout(function(){a(d).focus(),c&&c.call(d)},b)}):this._focus.apply(this,arguments)},scrollParent:function(){var b;a.browser.msie&&/(static|relative)/.test(this.css("position"))||/absolute/.test(this.css("position"))?b=this.parents().filter(function(){return/(relative|absolute|fixed)/.test(a.curCSS(this,"position",1))&&/(auto|scroll)/.test(a.curCSS(this,"overflow",1)+a.curCSS(this,"overflow-y",1)+a.curCSS(this,"overflow-x",1))}).eq(0):b=this.parents().filter(function(){return/(auto|scroll)/.test(a.curCSS(this,"overflow",1)+a.curCSS(this,"overflow-y",1)+a.curCSS(this,"overflow-x",1))}).eq(0);return/fixed/.test(this.css("position"))||!b.length?a(document):b},zIndex:function(c){if(c!==b)return this.css("zIndex",c);if(this.length){var d=a(this[0]),e,f;while(d.length&&d[0]!==document){e=d.css("position");if(e==="absolute"||e==="relative"||e==="fixed"){f=parseInt(d.css("zIndex"),10);if(!isNaN(f)&&f!==0)return f}d=d.parent()}}return 0},disableSelection:function(){return this.bind((a.support.selectstart?"selectstart":"mousedown")+".ui-disableSelection",function(a){a.preventDefault()})},enableSelection:function(){return this.unbind(".ui-disableSelection")}}),a.each(["Width","Height"],function(c,d){function h(b,c,d,f){a.each(e,function(){c-=parseFloat(a.curCSS(b,"padding"+this,!0))||0,d&&(c-=parseFloat(a.curCSS(b,"border"+this+"Width",!0))||0),f&&(c-=parseFloat(a.curCSS(b,"margin"+this,!0))||0)});return c}var e=d==="Width"?["Left","Right"]:["Top","Bottom"],f=d.toLowerCase(),g={innerWidth:a.fn.innerWidth,innerHeight:a.fn.innerHeight,outerWidth:a.fn.outerWidth,outerHeight:a.fn.outerHeight};a.fn["inner"+d]=function(c){if(c===b)return g["inner"+d].call(this);return this.each(function(){a(this).css(f,h(this,c)+"px")})},a.fn["outer"+d]=function(b,c){if(typeof b!="number")return g["outer"+d].call(this,b);return this.each(function(){a(this).css(f,h(this,b,!0,c)+"px")})}}),a.extend(a.expr[":"],{data:function(b,c,d){return!!a.data(b,d[3])},focusable:function(b){return c(b,!isNaN(a.attr(b,"tabindex")))},tabbable:function(b){var d=a.attr(b,"tabindex"),e=isNaN(d);return(e||d>=0)&&c(b,!e)}}),a(function(){var b=document.body,c=b.appendChild(c=document.createElement("div"));c.offsetHeight,a.extend(c.style,{minHeight:"100px",height:"auto",padding:0,borderWidth:0}),a.support.minHeight=c.offsetHeight===100,a.support.selectstart="onselectstart"in c,b.removeChild(c).style.display="none"}),a.extend(a.ui,{plugin:{add:function(b,c,d){var e=a.ui[b].prototype;for(var f in d)e.plugins[f]=e.plugins[f]||[],e.plugins[f].push([c,d[f]])},call:function(a,b,c){var d=a.plugins[b];if(!!d&&!!a.element[0].parentNode)for(var e=0;e<d.length;e++)a.options[d[e][0]]&&d[e][1].apply(a.element,c)}},contains:function(a,b){return document.compareDocumentPosition?a.compareDocumentPosition(b)&16:a!==b&&a.contains(b)},hasScroll:function(b,c){if(a(b).css("overflow")==="hidden")return!1;var d=c&&c==="left"?"scrollLeft":"scrollTop",e=!1;if(b[d]>0)return!0;b[d]=1,e=b[d]>0,b[d]=0;return e},isOverAxis:function(a,b,c){return a>b&&a<b+c},isOver:function(b,c,d,e,f,g){return a.ui.isOverAxis(b,d,f)&&a.ui.isOverAxis(c,e,g)}}))})(jQuery);

/* jQuery UI Widget 1.8.18 */
(function(a,b){if(a.cleanData){var c=a.cleanData;a.cleanData=function(b){for(var d=0,e;(e=b[d])!=null;d++)try{a(e).triggerHandler("remove")}catch(f){}c(b)}}else{var d=a.fn.remove;a.fn.remove=function(b,c){return this.each(function(){c||(!b||a.filter(b,[this]).length)&&a("*",this).add([this]).each(function(){try{a(this).triggerHandler("remove")}catch(b){}});return d.call(a(this),b,c)})}}a.widget=function(b,c,d){var e=b.split(".")[0],f;b=b.split(".")[1],f=e+"-"+b,d||(d=c,c=a.Widget),a.expr[":"][f]=function(c){return!!a.data(c,b)},a[e]=a[e]||{},a[e][b]=function(a,b){arguments.length&&this._createWidget(a,b)};var g=new c;g.options=a.extend(!0,{},g.options),a[e][b].prototype=a.extend(!0,g,{namespace:e,widgetName:b,widgetEventPrefix:a[e][b].prototype.widgetEventPrefix||b,widgetBaseClass:f},d),a.widget.bridge(b,a[e][b])},a.widget.bridge=function(c,d){a.fn[c]=function(e){var f=typeof e=="string",g=Array.prototype.slice.call(arguments,1),h=this;e=!f&&g.length?a.extend.apply(null,[!0,e].concat(g)):e;if(f&&e.charAt(0)==="_")return h;f?this.each(function(){var d=a.data(this,c),f=d&&a.isFunction(d[e])?d[e].apply(d,g):d;if(f!==d&&f!==b){h=f;return!1}}):this.each(function(){var b=a.data(this,c);b?b.option(e||{})._init():a.data(this,c,new d(e,this))});return h}},a.Widget=function(a,b){arguments.length&&this._createWidget(a,b)},a.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",options:{disabled:!1},_createWidget:function(b,c){a.data(c,this.widgetName,this),this.element=a(c),this.options=a.extend(!0,{},this.options,this._getCreateOptions(),b);var d=this;this.element.bind("remove."+this.widgetName,function(){d.destroy()}),this._create(),this._trigger("create"),this._init()},_getCreateOptions:function(){return a.metadata&&a.metadata.get(this.element[0])[this.widgetName]},_create:function(){},_init:function(){},destroy:function(){this.element.unbind("."+this.widgetName).removeData(this.widgetName),this.widget().unbind("."+this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass+"-disabled "+"ui-state-disabled")},widget:function(){return this.element},option:function(c,d){var e=c;if(arguments.length===0)return a.extend({},this.options);if(typeof c=="string"){if(d===b)return this.options[c];e={},e[c]=d}this._setOptions(e);return this},_setOptions:function(b){var c=this;a.each(b,function(a,b){c._setOption(a,b)});return this},_setOption:function(a,b){this.options[a]=b,a==="disabled"&&this.widget()[b?"addClass":"removeClass"](this.widgetBaseClass+"-disabled"+" "+"ui-state-disabled").attr("aria-disabled",b);return this},enable:function(){return this._setOption("disabled",!1)},disable:function(){return this._setOption("disabled",!0)},_trigger:function(b,c,d){var e,f,g=this.options[b];d=d||{},c=a.Event(c),c.type=(b===this.widgetEventPrefix?b:this.widgetEventPrefix+b).toLowerCase(),c.target=this.element[0],f=c.originalEvent;if(f)for(e in f)e in c||(c[e]=f[e]);this.element.trigger(c,d);return!(a.isFunction(g)&&g.call(this.element[0],c,d)===!1||c.isDefaultPrevented())}}})(jQuery);

/* jQuery UI Mouse 1.8.18 */
(function(a,b){var c=!1;a(document).mouseup(function(a){c=!1}),a.widget("ui.mouse",{options:{cancel:":input,option",distance:1,delay:0},_mouseInit:function(){var b=this;this.element.bind("mousedown."+this.widgetName,function(a){return b._mouseDown(a)}).bind("click."+this.widgetName,function(c){if(!0===a.data(c.target,b.widgetName+".preventClickEvent")){a.removeData(c.target,b.widgetName+".preventClickEvent"),c.stopImmediatePropagation();return!1}}),this.started=!1},_mouseDestroy:function(){this.element.unbind("."+this.widgetName)},_mouseDown:function(b){if(!c){this._mouseStarted&&this._mouseUp(b),this._mouseDownEvent=b;var d=this,e=b.which==1,f=typeof this.options.cancel=="string"&&b.target.nodeName?a(b.target).closest(this.options.cancel).length:!1;if(!e||f||!this._mouseCapture(b))return!0;this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){d.mouseDelayMet=!0},this.options.delay));if(this._mouseDistanceMet(b)&&this._mouseDelayMet(b)){this._mouseStarted=this._mouseStart(b)!==!1;if(!this._mouseStarted){b.preventDefault();return!0}}!0===a.data(b.target,this.widgetName+".preventClickEvent")&&a.removeData(b.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(a){return d._mouseMove(a)},this._mouseUpDelegate=function(a){return d._mouseUp(a)},a(document).bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate),b.preventDefault(),c=!0;return!0}},_mouseMove:function(b){if(a.browser.msie&&!(document.documentMode>=9)&&!b.button)return this._mouseUp(b);if(this._mouseStarted){this._mouseDrag(b);return b.preventDefault()}this._mouseDistanceMet(b)&&this._mouseDelayMet(b)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,b)!==!1,this._mouseStarted?this._mouseDrag(b):this._mouseUp(b));return!this._mouseStarted},_mouseUp:function(b){a(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,b.target==this._mouseDownEvent.target&&a.data(b.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(b));return!1},_mouseDistanceMet:function(a){return Math.max(Math.abs(this._mouseDownEvent.pageX-a.pageX),Math.abs(this._mouseDownEvent.pageY-a.pageY))>=this.options.distance},_mouseDelayMet:function(a){return this.mouseDelayMet},_mouseStart:function(a){},_mouseDrag:function(a){},_mouseStop:function(a){},_mouseCapture:function(a){return!0}})})(jQuery);

/* jQuery UI Slider 1.8.18 */
(function(a,b){var c=5;a.widget("ui.slider",a.ui.mouse,{widgetEventPrefix:"slide",options:{animate:!1,distance:0,max:100,min:0,orientation:"horizontal",range:!1,step:1,value:0,values:null},_create:function(){var b=this,d=this.options,e=this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),f="<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>",g=d.values&&d.values.length||1,h=[];this._keySliding=!1,this._mouseSliding=!1,this._animateOff=!0,this._handleIndex=null,this._detectOrientation(),this._mouseInit(),this.element.addClass("ui-slider ui-slider-"+this.orientation+" ui-widget"+" ui-widget-content"+" ui-corner-all"+(d.disabled?" ui-slider-disabled ui-disabled":"")),this.range=a([]),d.range&&(d.range===!0&&(d.values||(d.values=[this._valueMin(),this._valueMin()]),d.values.length&&d.values.length!==2&&(d.values=[d.values[0],d.values[0]])),this.range=a("<div></div>").appendTo(this.element).addClass("ui-slider-range ui-widget-header"+(d.range==="min"||d.range==="max"?" ui-slider-range-"+d.range:"")));for(var i=e.length;i<g;i+=1)h.push(f);this.handles=e.add(a(h.join("")).appendTo(b.element)),this.handle=this.handles.eq(0),this.handles.add(this.range).filter("a").click(function(a){a.preventDefault()}).hover(function(){d.disabled||a(this).addClass("ui-state-hover")},function(){a(this).removeClass("ui-state-hover")}).focus(function(){d.disabled?a(this).blur():(a(".ui-slider .ui-state-focus").removeClass("ui-state-focus"),a(this).addClass("ui-state-focus"))}).blur(function(){a(this).removeClass("ui-state-focus")}),this.handles.each(function(b){a(this).data("index.ui-slider-handle",b)}),this.handles.keydown(function(d){var e=a(this).data("index.ui-slider-handle"),f,g,h,i;if(!b.options.disabled){switch(d.keyCode){case a.ui.keyCode.HOME:case a.ui.keyCode.END:case a.ui.keyCode.PAGE_UP:case a.ui.keyCode.PAGE_DOWN:case a.ui.keyCode.UP:case a.ui.keyCode.RIGHT:case a.ui.keyCode.DOWN:case a.ui.keyCode.LEFT:d.preventDefault();if(!b._keySliding){b._keySliding=!0,a(this).addClass("ui-state-active"),f=b._start(d,e);if(f===!1)return}}i=b.options.step,b.options.values&&b.options.values.length?g=h=b.values(e):g=h=b.value();switch(d.keyCode){case a.ui.keyCode.HOME:h=b._valueMin();break;case a.ui.keyCode.END:h=b._valueMax();break;case a.ui.keyCode.PAGE_UP:h=b._trimAlignValue(g+(b._valueMax()-b._valueMin())/c);break;case a.ui.keyCode.PAGE_DOWN:h=b._trimAlignValue(g-(b._valueMax()-b._valueMin())/c);break;case a.ui.keyCode.UP:case a.ui.keyCode.RIGHT:if(g===b._valueMax())return;h=b._trimAlignValue(g+i);break;case a.ui.keyCode.DOWN:case a.ui.keyCode.LEFT:if(g===b._valueMin())return;h=b._trimAlignValue(g-i)}b._slide(d,e,h)}}).keyup(function(c){var d=a(this).data("index.ui-slider-handle");b._keySliding&&(b._keySliding=!1,b._stop(c,d),b._change(c,d),a(this).removeClass("ui-state-active"))}),this._refreshValue(),this._animateOff=!1},destroy:function(){this.handles.remove(),this.range.remove(),this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all").removeData("slider").unbind(".slider"),this._mouseDestroy();return this},_mouseCapture:function(b){var c=this.options,d,e,f,g,h,i,j,k,l;if(c.disabled)return!1;this.elementSize={width:this.element.outerWidth(),height:this.element.outerHeight()},this.elementOffset=this.element.offset(),d={x:b.pageX,y:b.pageY},e=this._normValueFromMouse(d),f=this._valueMax()-this._valueMin()+1,h=this,this.handles.each(function(b){var c=Math.abs(e-h.values(b));f>c&&(f=c,g=a(this),i=b)}),c.range===!0&&this.values(1)===c.min&&(i+=1,g=a(this.handles[i])),j=this._start(b,i);if(j===!1)return!1;this._mouseSliding=!0,h._handleIndex=i,g.addClass("ui-state-active").focus(),k=g.offset(),l=!a(b.target).parents().andSelf().is(".ui-slider-handle"),this._clickOffset=l?{left:0,top:0}:{left:b.pageX-k.left-g.width()/2,top:b.pageY-k.top-g.height()/2-(parseInt(g.css("borderTopWidth"),10)||0)-(parseInt(g.css("borderBottomWidth"),10)||0)+(parseInt(g.css("marginTop"),10)||0)},this.handles.hasClass("ui-state-hover")||this._slide(b,i,e),this._animateOff=!0;return!0},_mouseStart:function(a){return!0},_mouseDrag:function(a){var b={x:a.pageX,y:a.pageY},c=this._normValueFromMouse(b);this._slide(a,this._handleIndex,c);return!1},_mouseStop:function(a){this.handles.removeClass("ui-state-active"),this._mouseSliding=!1,this._stop(a,this._handleIndex),this._change(a,this._handleIndex),this._handleIndex=null,this._clickOffset=null,this._animateOff=!1;return!1},_detectOrientation:function(){this.orientation=this.options.orientation==="vertical"?"vertical":"horizontal"},_normValueFromMouse:function(a){var b,c,d,e,f;this.orientation==="horizontal"?(b=this.elementSize.width,c=a.x-this.elementOffset.left-(this._clickOffset?this._clickOffset.left:0)):(b=this.elementSize.height,c=a.y-this.elementOffset.top-(this._clickOffset?this._clickOffset.top:0)),d=c/b,d>1&&(d=1),d<0&&(d=0),this.orientation==="vertical"&&(d=1-d),e=this._valueMax()-this._valueMin(),f=this._valueMin()+d*e;return this._trimAlignValue(f)},_start:function(a,b){var c={handle:this.handles[b],value:this.value()};this.options.values&&this.options.values.length&&(c.value=this.values(b),c.values=this.values());return this._trigger("start",a,c)},_slide:function(a,b,c){var d,e,f;this.options.values&&this.options.values.length?(d=this.values(b?0:1),this.options.values.length===2&&this.options.range===!0&&(b===0&&c>d||b===1&&c<d)&&(c=d),c!==this.values(b)&&(e=this.values(),e[b]=c,f=this._trigger("slide",a,{handle:this.handles[b],value:c,values:e}),d=this.values(b?0:1),f!==!1&&this.values(b,c,!0))):c!==this.value()&&(f=this._trigger("slide",a,{handle:this.handles[b],value:c}),f!==!1&&this.value(c))},_stop:function(a,b){var c={handle:this.handles[b],value:this.value()};this.options.values&&this.options.values.length&&(c.value=this.values(b),c.values=this.values()),this._trigger("stop",a,c)},_change:function(a,b){if(!this._keySliding&&!this._mouseSliding){var c={handle:this.handles[b],value:this.value()};this.options.values&&this.options.values.length&&(c.value=this.values(b),c.values=this.values()),this._trigger("change",a,c)}},value:function(a){if(arguments.length)this.options.value=this._trimAlignValue(a),this._refreshValue(),this._change(null,0);else return this._value()},values:function(b,c){var d,e,f;if(arguments.length>1)this.options.values[b]=this._trimAlignValue(c),this._refreshValue(),this._change(null,b);else{if(!arguments.length)return this._values();if(!a.isArray(arguments[0]))return this.options.values&&this.options.values.length?this._values(b):this.value();d=this.options.values,e=arguments[0];for(f=0;f<d.length;f+=1)d[f]=this._trimAlignValue(e[f]),this._change(null,f);this._refreshValue()}},_setOption:function(b,c){var d,e=0;a.isArray(this.options.values)&&(e=this.options.values.length),a.Widget.prototype._setOption.apply(this,arguments);switch(b){case"disabled":c?(this.handles.filter(".ui-state-focus").blur(),this.handles.removeClass("ui-state-hover"),this.handles.propAttr("disabled",!0),this.element.addClass("ui-disabled")):(this.handles.propAttr("disabled",!1),this.element.removeClass("ui-disabled"));break;case"orientation":this._detectOrientation(),this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-"+this.orientation),this._refreshValue();break;case"value":this._animateOff=!0,this._refreshValue(),this._change(null,0),this._animateOff=!1;break;case"values":this._animateOff=!0,this._refreshValue();for(d=0;d<e;d+=1)this._change(null,d);this._animateOff=!1}},_value:function(){var a=this.options.value;a=this._trimAlignValue(a);return a},_values:function(a){var b,c,d;if(arguments.length){b=this.options.values[a],b=this._trimAlignValue(b);return b}c=this.options.values.slice();for(d=0;d<c.length;d+=1)c[d]=this._trimAlignValue(c[d]);return c},_trimAlignValue:function(a){if(a<=this._valueMin())return this._valueMin();if(a>=this._valueMax())return this._valueMax();var b=this.options.step>0?this.options.step:1,c=(a-this._valueMin())%b,d=a-c;Math.abs(c)*2>=b&&(d+=c>0?b:-b);return parseFloat(d.toFixed(5))},_valueMin:function(){return this.options.min},_valueMax:function(){return this.options.max},_refreshValue:function(){var b=this.options.range,c=this.options,d=this,e=this._animateOff?!1:c.animate,f,g={},h,i,j,k;this.options.values&&this.options.values.length?this.handles.each(function(b,i){f=(d.values(b)-d._valueMin())/(d._valueMax()-d._valueMin())*100,g[d.orientation==="horizontal"?"left":"bottom"]=f+"%",a(this).stop(1,1)[e?"animate":"css"](g,c.animate),d.options.range===!0&&(d.orientation==="horizontal"?(b===0&&d.range.stop(1,1)[e?"animate":"css"]({left:f+"%"},c.animate),b===1&&d.range[e?"animate":"css"]({width:f-h+"%"},{queue:!1,duration:c.animate})):(b===0&&d.range.stop(1,1)[e?"animate":"css"]({bottom:f+"%"},c.animate),b===1&&d.range[e?"animate":"css"]({height:f-h+"%"},{queue:!1,duration:c.animate}))),h=f}):(i=this.value(),j=this._valueMin(),k=this._valueMax(),f=k!==j?(i-j)/(k-j)*100:0,g[d.orientation==="horizontal"?"left":"bottom"]=f+"%",this.handle.stop(1,1)[e?"animate":"css"](g,c.animate),b==="min"&&this.orientation==="horizontal"&&this.range.stop(1,1)[e?"animate":"css"]({width:f+"%"},c.animate),b==="max"&&this.orientation==="horizontal"&&this.range[e?"animate":"css"]({width:100-f+"%"},{queue:!1,duration:c.animate}),b==="min"&&this.orientation==="vertical"&&this.range.stop(1,1)[e?"animate":"css"]({height:f+"%"},c.animate),b==="max"&&this.orientation==="vertical"&&this.range[e?"animate":"css"]({height:100-f+"%"},{queue:!1,duration:c.animate}))}}),a.extend(a.ui.slider,{version:"1.8.18"})})(jQuery);

/* jQuery UI Sortable 1.8.18 */
(function(a,b){a.widget("ui.sortable",a.ui.mouse,{widgetEventPrefix:"sort",ready:!1,options:{appendTo:"parent",axis:!1,connectWith:!1,containment:!1,cursor:"auto",cursorAt:!1,dropOnEmpty:!0,forcePlaceholderSize:!1,forceHelperSize:!1,grid:!1,handle:!1,helper:"original",items:"> *",opacity:!1,placeholder:!1,revert:!1,scroll:!0,scrollSensitivity:20,scrollSpeed:20,scope:"default",tolerance:"intersect",zIndex:1e3},_create:function(){var a=this.options;this.containerCache={},this.element.addClass("ui-sortable"),this.refresh(),this.floating=this.items.length?a.axis==="x"||/left|right/.test(this.items[0].item.css("float"))||/inline|table-cell/.test(this.items[0].item.css("display")):!1,this.offset=this.element.offset(),this._mouseInit(),this.ready=!0},destroy:function(){a.Widget.prototype.destroy.call(this),this.element.removeClass("ui-sortable ui-sortable-disabled"),this._mouseDestroy();for(var b=this.items.length-1;b>=0;b--)this.items[b].item.removeData(this.widgetName+"-item");return this},_setOption:function(b,c){b==="disabled"?(this.options[b]=c,this.widget()[c?"addClass":"removeClass"]("ui-sortable-disabled")):a.Widget.prototype._setOption.apply(this,arguments)},_mouseCapture:function(b,c){var d=this;if(this.reverting)return!1;if(this.options.disabled||this.options.type=="static")return!1;this._refreshItems(b);var e=null,f=this,g=a(b.target).parents().each(function(){if(a.data(this,d.widgetName+"-item")==f){e=a(this);return!1}});a.data(b.target,d.widgetName+"-item")==f&&(e=a(b.target));if(!e)return!1;if(this.options.handle&&!c){var h=!1;a(this.options.handle,e).find("*").andSelf().each(function(){this==b.target&&(h=!0)});if(!h)return!1}this.currentItem=e,this._removeCurrentsFromItems();return!0},_mouseStart:function(b,c,d){var e=this.options,f=this;this.currentContainer=this,this.refreshPositions(),this.helper=this._createHelper(b),this._cacheHelperProportions(),this._cacheMargins(),this.scrollParent=this.helper.scrollParent(),this.offset=this.currentItem.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},this.helper.css("position","absolute"),this.cssPosition=this.helper.css("position"),a.extend(this.offset,{click:{left:b.pageX-this.offset.left,top:b.pageY-this.offset.top},parent:this._getParentOffset(),relative:this._getRelativeOffset()}),this.originalPosition=this._generatePosition(b),this.originalPageX=b.pageX,this.originalPageY=b.pageY,e.cursorAt&&this._adjustOffsetFromHelper(e.cursorAt),this.domPosition={prev:this.currentItem.prev()[0],parent:this.currentItem.parent()[0]},this.helper[0]!=this.currentItem[0]&&this.currentItem.hide(),this._createPlaceholder(),e.containment&&this._setContainment(),e.cursor&&(a("body").css("cursor")&&(this._storedCursor=a("body").css("cursor")),a("body").css("cursor",e.cursor)),e.opacity&&(this.helper.css("opacity")&&(this._storedOpacity=this.helper.css("opacity")),this.helper.css("opacity",e.opacity)),e.zIndex&&(this.helper.css("zIndex")&&(this._storedZIndex=this.helper.css("zIndex")),this.helper.css("zIndex",e.zIndex)),this.scrollParent[0]!=document&&this.scrollParent[0].tagName!="HTML"&&(this.overflowOffset=this.scrollParent.offset()),this._trigger("start",b,this._uiHash()),this._preserveHelperProportions||this._cacheHelperProportions();if(!d)for(var g=this.containers.length-1;g>=0;g--)this.containers[g]._trigger("activate",b,f._uiHash(this));a.ui.ddmanager&&(a.ui.ddmanager.current=this),a.ui.ddmanager&&!e.dropBehaviour&&a.ui.ddmanager.prepareOffsets(this,b),this.dragging=!0,this.helper.addClass("ui-sortable-helper"),this._mouseDrag(b);return!0},_mouseDrag:function(b){this.position=this._generatePosition(b),this.positionAbs=this._convertPositionTo("absolute"),this.lastPositionAbs||(this.lastPositionAbs=this.positionAbs);if(this.options.scroll){var c=this.options,d=!1;this.scrollParent[0]!=document&&this.scrollParent[0].tagName!="HTML"?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-b.pageY<c.scrollSensitivity?this.scrollParent[0].scrollTop=d=this.scrollParent[0].scrollTop+c.scrollSpeed:b.pageY-this.overflowOffset.top<c.scrollSensitivity&&(this.scrollParent[0].scrollTop=d=this.scrollParent[0].scrollTop-c.scrollSpeed),this.overflowOffset.left+this.scrollParent[0].offsetWidth-b.pageX<c.scrollSensitivity?this.scrollParent[0].scrollLeft=d=this.scrollParent[0].scrollLeft+c.scrollSpeed:b.pageX-this.overflowOffset.left<c.scrollSensitivity&&(this.scrollParent[0].scrollLeft=d=this.scrollParent[0].scrollLeft-c.scrollSpeed)):(b.pageY-a(document).scrollTop()<c.scrollSensitivity?d=a(document).scrollTop(a(document).scrollTop()-c.scrollSpeed):a(window).height()-(b.pageY-a(document).scrollTop())<c.scrollSensitivity&&(d=a(document).scrollTop(a(document).scrollTop()+c.scrollSpeed)),b.pageX-a(document).scrollLeft()<c.scrollSensitivity?d=a(document).scrollLeft(a(document).scrollLeft()-c.scrollSpeed):a(window).width()-(b.pageX-a(document).scrollLeft())<c.scrollSensitivity&&(d=a(document).scrollLeft(a(document).scrollLeft()+c.scrollSpeed))),d!==!1&&a.ui.ddmanager&&!c.dropBehaviour&&a.ui.ddmanager.prepareOffsets(this,b)}this.positionAbs=this._convertPositionTo("absolute");if(!this.options.axis||this.options.axis!="y")this.helper[0].style.left=this.position.left+"px";if(!this.options.axis||this.options.axis!="x")this.helper[0].style.top=this.position.top+"px";for(var e=this.items.length-1;e>=0;e--){var f=this.items[e],g=f.item[0],h=this._intersectsWithPointer(f);if(!h)continue;if(g!=this.currentItem[0]&&this.placeholder[h==1?"next":"prev"]()[0]!=g&&!a.ui.contains(this.placeholder[0],g)&&(this.options.type=="semi-dynamic"?!a.ui.contains(this.element[0],g):!0)){this.direction=h==1?"down":"up";if(this.options.tolerance=="pointer"||this._intersectsWithSides(f))this._rearrange(b,f);else break;this._trigger("change",b,this._uiHash());break}}this._contactContainers(b),a.ui.ddmanager&&a.ui.ddmanager.drag(this,b),this._trigger("sort",b,this._uiHash()),this.lastPositionAbs=this.positionAbs;return!1},_mouseStop:function(b,c){if(!!b){a.ui.ddmanager&&!this.options.dropBehaviour&&a.ui.ddmanager.drop(this,b);if(this.options.revert){var d=this,e=d.placeholder.offset();d.reverting=!0,a(this.helper).animate({left:e.left-this.offset.parent.left-d.margins.left+(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollLeft),top:e.top-this.offset.parent.top-d.margins.top+(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollTop)},parseInt(this.options.revert,10)||500,function(){d._clear(b)})}else this._clear(b,c);return!1}},cancel:function(){var b=this;if(this.dragging){this._mouseUp({target:null}),this.options.helper=="original"?this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper"):this.currentItem.show();for(var c=this.containers.length-1;c>=0;c--)this.containers[c]._trigger("deactivate",null,b._uiHash(this)),this.containers[c].containerCache.over&&(this.containers[c]._trigger("out",null,b._uiHash(this)),this.containers[c].containerCache.over=0)}this.placeholder&&(this.placeholder[0].parentNode&&this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.options.helper!="original"&&this.helper&&this.helper[0].parentNode&&this.helper.remove(),a.extend(this,{helper:null,dragging:!1,reverting:!1,_noFinalSort:null}),this.domPosition.prev?a(this.domPosition.prev).after(this.currentItem):a(this.domPosition.parent).prepend(this.currentItem));return this},serialize:function(b){var c=this._getItemsAsjQuery(b&&b.connected),d=[];b=b||{},a(c).each(function(){var c=(a(b.item||this).attr(b.attribute||"id")||"").match(b.expression||/(.+)[-=_](.+)/);c&&d.push((b.key||c[1]+"[]")+"="+(b.key&&b.expression?c[1]:c[2]))}),!d.length&&b.key&&d.push(b.key+"=");return d.join("&")},toArray:function(b){var c=this._getItemsAsjQuery(b&&b.connected),d=[];b=b||{},c.each(function(){d.push(a(b.item||this).attr(b.attribute||"id")||"")});return d},_intersectsWith:function(a){var b=this.positionAbs.left,c=b+this.helperProportions.width,d=this.positionAbs.top,e=d+this.helperProportions.height,f=a.left,g=f+a.width,h=a.top,i=h+a.height,j=this.offset.click.top,k=this.offset.click.left,l=d+j>h&&d+j<i&&b+k>f&&b+k<g;return this.options.tolerance=="pointer"||this.options.forcePointerForContainers||this.options.tolerance!="pointer"&&this.helperProportions[this.floating?"width":"height"]>a[this.floating?"width":"height"]?l:f<b+this.helperProportions.width/2&&c-this.helperProportions.width/2<g&&h<d+this.helperProportions.height/2&&e-this.helperProportions.height/2<i},_intersectsWithPointer:function(b){var c=a.ui.isOverAxis(this.positionAbs.top+this.offset.click.top,b.top,b.height),d=a.ui.isOverAxis(this.positionAbs.left+this.offset.click.left,b.left,b.width),e=c&&d,f=this._getDragVerticalDirection(),g=this._getDragHorizontalDirection();if(!e)return!1;return this.floating?g&&g=="right"||f=="down"?2:1:f&&(f=="down"?2:1)},_intersectsWithSides:function(b){var c=a.ui.isOverAxis(this.positionAbs.top+this.offset.click.top,b.top+b.height/2,b.height),d=a.ui.isOverAxis(this.positionAbs.left+this.offset.click.left,b.left+b.width/2,b.width),e=this._getDragVerticalDirection(),f=this._getDragHorizontalDirection();return this.floating&&f?f=="right"&&d||f=="left"&&!d:e&&(e=="down"&&c||e=="up"&&!c)},_getDragVerticalDirection:function(){var a=this.positionAbs.top-this.lastPositionAbs.top;return a!=0&&(a>0?"down":"up")},_getDragHorizontalDirection:function(){var a=this.positionAbs.left-this.lastPositionAbs.left;return a!=0&&(a>0?"right":"left")},refresh:function(a){this._refreshItems(a),this.refreshPositions();return this},_connectWith:function(){var a=this.options;return a.connectWith.constructor==String?[a.connectWith]:a.connectWith},_getItemsAsjQuery:function(b){var c=this,d=[],e=[],f=this._connectWith();if(f&&b)for(var g=f.length-1;g>=0;g--){var h=a(f[g]);for(var i=h.length-1;i>=0;i--){var j=a.data(h[i],this.widgetName);j&&j!=this&&!j.options.disabled&&e.push([a.isFunction(j.options.items)?j.options.items.call(j.element):a(j.options.items,j.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),j])}}e.push([a.isFunction(this.options.items)?this.options.items.call(this.element,null,{options:this.options,item:this.currentItem}):a(this.options.items,this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),this]);for(var g=e.length-1;g>=0;g--)e[g][0].each(function(){d.push(this)});return a(d)},_removeCurrentsFromItems:function(){var a=this.currentItem.find(":data("+this.widgetName+"-item)");for(var b=0;b<this.items.length;b++)for(var c=0;c<a.length;c++)a[c]==this.items[b].item[0]&&this.items.splice(b,1)},_refreshItems:function(b){this.items=[],this.containers=[this];var c=this.items,d=this,e=[[a.isFunction(this.options.items)?this.options.items.call(this.element[0],b,{item:this.currentItem}):a(this.options.items,this.element),this]],f=this._connectWith();if(f&&this.ready)for(var g=f.length-1;g>=0;g--){var h=a(f[g]);for(var i=h.length-1;i>=0;i--){var j=a.data(h[i],this.widgetName);j&&j!=this&&!j.options.disabled&&(e.push([a.isFunction(j.options.items)?j.options.items.call(j.element[0],b,{item:this.currentItem}):a(j.options.items,j.element),j]),this.containers.push(j))}}for(var g=e.length-1;g>=0;g--){var k=e[g][1],l=e[g][0];for(var i=0,m=l.length;i<m;i++){var n=a(l[i]);n.data(this.widgetName+"-item",k),c.push({item:n,instance:k,width:0,height:0,left:0,top:0})}}},refreshPositions:function(b){this.offsetParent&&this.helper&&(this.offset.parent=this._getParentOffset());for(var c=this.items.length-1;c>=0;c--){var d=this.items[c];if(d.instance!=this.currentContainer&&this.currentContainer&&d.item[0]!=this.currentItem[0])continue;var e=this.options.toleranceElement?a(this.options.toleranceElement,d.item):d.item;b||(d.width=e.outerWidth(),d.height=e.outerHeight());var f=e.offset();d.left=f.left,d.top=f.top}if(this.options.custom&&this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this);else for(var c=this.containers.length-1;c>=0;c--){var f=this.containers[c].element.offset();this.containers[c].containerCache.left=f.left,this.containers[c].containerCache.top=f.top,this.containers[c].containerCache.width=this.containers[c].element.outerWidth(),this.containers[c].containerCache.height=this.containers[c].element.outerHeight()}return this},_createPlaceholder:function(b){var c=b||this,d=c.options;if(!d.placeholder||d.placeholder.constructor==String){var e=d.placeholder;d.placeholder={element:function(){var b=a(document.createElement(c.currentItem[0].nodeName)).addClass(e||c.currentItem[0].className+" ui-sortable-placeholder").removeClass("ui-sortable-helper")[0];e||(b.style.visibility="hidden");return b},update:function(a,b){if(!e||!!d.forcePlaceholderSize)b.height()||b.height(c.currentItem.innerHeight()-parseInt(c.currentItem.css("paddingTop")||0,10)-parseInt(c.currentItem.css("paddingBottom")||0,10)),b.width()||b.width(c.currentItem.innerWidth()-parseInt(c.currentItem.css("paddingLeft")||0,10)-parseInt(c.currentItem.css("paddingRight")||0,10))}}}c.placeholder=a(d.placeholder.element.call(c.element,c.currentItem)),c.currentItem.after(c.placeholder),d.placeholder.update(c,c.placeholder)},_contactContainers:function(b){var c=null,d=null;for(var e=this.containers.length-1;e>=0;e--){if(a.ui.contains(this.currentItem[0],this.containers[e].element[0]))continue;if(this._intersectsWith(this.containers[e].containerCache)){if(c&&a.ui.contains(this.containers[e].element[0],c.element[0]))continue;c=this.containers[e],d=e}else this.containers[e].containerCache.over&&(this.containers[e]._trigger("out",b,this._uiHash(this)),this.containers[e].containerCache.over=0)}if(!!c)if(this.containers.length===1)this.containers[d]._trigger("over",b,this._uiHash(this)),this.containers[d].containerCache.over=1;else if(this.currentContainer!=this.containers[d]){var f=1e4,g=null,h=this.positionAbs[this.containers[d].floating?"left":"top"];for(var i=this.items.length-1;i>=0;i--){if(!a.ui.contains(this.containers[d].element[0],this.items[i].item[0]))continue;var j=this.items[i][this.containers[d].floating?"left":"top"];Math.abs(j-h)<f&&(f=Math.abs(j-h),g=this.items[i])}if(!g&&!this.options.dropOnEmpty)return;this.currentContainer=this.containers[d],g?this._rearrange(b,g,null,!0):this._rearrange(b,null,this.containers[d].element,!0),this._trigger("change",b,this._uiHash()),this.containers[d]._trigger("change",b,this._uiHash(this)),this.options.placeholder.update(this.currentContainer,this.placeholder),this.containers[d]._trigger("over",b,this._uiHash(this)),this.containers[d].containerCache.over=1}},_createHelper:function(b){var c=this.options,d=a.isFunction(c.helper)?a(c.helper.apply(this.element[0],[b,this.currentItem])):c.helper=="clone"?this.currentItem.clone():this.currentItem;d.parents("body").length||a(c.appendTo!="parent"?c.appendTo:this.currentItem[0].parentNode)[0].appendChild(d[0]),d[0]==this.currentItem[0]&&(this._storedCSS={width:this.currentItem[0].style.width,height:this.currentItem[0].style.height,position:this.currentItem.css("position"),top:this.currentItem.css("top"),left:this.currentItem.css("left")}),(d[0].style.width==""||c.forceHelperSize)&&d.width(this.currentItem.width()),(d[0].style.height==""||c.forceHelperSize)&&d.height(this.currentItem.height());return d},_adjustOffsetFromHelper:function(b){typeof b=="string"&&(b=b.split(" ")),a.isArray(b)&&(b={left:+b[0],top:+b[1]||0}),"left"in b&&(this.offset.click.left=b.left+this.margins.left),"right"in b&&(this.offset.click.left=this.helperProportions.width-b.right+this.margins.left),"top"in b&&(this.offset.click.top=b.top+this.margins.top),"bottom"in b&&(this.offset.click.top=this.helperProportions.height-b.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var b=this.offsetParent.offset();this.cssPosition=="absolute"&&this.scrollParent[0]!=document&&a.ui.contains(this.scrollParent[0],this.offsetParent[0])&&(b.left+=this.scrollParent.scrollLeft(),b.top+=this.scrollParent.scrollTop());if(this.offsetParent[0]==document.body||this.offsetParent[0].tagName&&this.offsetParent[0].tagName.toLowerCase()=="html"&&a.browser.msie)b={top:0,left:0};return{top:b.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:b.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){if(this.cssPosition=="relative"){var a=this.currentItem.position();return{top:a.top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:a.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}}return{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.currentItem.css("marginLeft"),10)||0,top:parseInt(this.currentItem.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var b=this.options;b.containment=="parent"&&(b.containment=this.helper[0].parentNode);if(b.containment=="document"||b.containment=="window")this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,a(b.containment=="document"?document:window).width()-this.helperProportions.width-this.margins.left,(a(b.containment=="document"?document:window).height()||document.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top];if(!/^(document|window|parent)$/.test(b.containment)){var c=a(b.containment)[0],d=a(b.containment).offset(),e=a(c).css("overflow")!="hidden";this.containment=[d.left+(parseInt(a(c).css("borderLeftWidth"),10)||0)+(parseInt(a(c).css("paddingLeft"),10)||0)-this.margins.left,d.top+(parseInt(a(c).css("borderTopWidth"),10)||0)+(parseInt(a(c).css("paddingTop"),10)||0)-this.margins.top,d.left+(e?Math.max(c.scrollWidth,c.offsetWidth):c.offsetWidth)-(parseInt(a(c).css("borderLeftWidth"),10)||0)-(parseInt(a(c).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,d.top+(e?Math.max(c.scrollHeight,c.offsetHeight):c.offsetHeight)-(parseInt(a(c).css("borderTopWidth"),10)||0)-(parseInt(a(c).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top]}},_convertPositionTo:function(b,c){c||(c=this.position);var d=b=="absolute"?1:-1,e=this.options,f=this.cssPosition=="absolute"&&(this.scrollParent[0]==document||!a.ui.contains(this.scrollParent[0],this.offsetParent[0]))?this.offsetParent:this.scrollParent,g=/(html|body)/i.test(f[0].tagName);return{top:c.top+this.offset.relative.top*d+this.offset.parent.top*d-(a.browser.safari&&this.cssPosition=="fixed"?0:(this.cssPosition=="fixed"?-this.scrollParent.scrollTop():g?0:f.scrollTop())*d),left:c.left+this.offset.relative.left*d+this.offset.parent.left*d-(a.browser.safari&&this.cssPosition=="fixed"?0:(this.cssPosition=="fixed"?-this.scrollParent.scrollLeft():g?0:f.scrollLeft())*d)}},_generatePosition:function(b){var c=this.options,d=this.cssPosition=="absolute"&&(this.scrollParent[0]==document||!a.ui.contains(this.scrollParent[0],this.offsetParent[0]))?this.offsetParent:this.scrollParent,e=/(html|body)/i.test(d[0].tagName);this.cssPosition=="relative"&&(this.scrollParent[0]==document||this.scrollParent[0]==this.offsetParent[0])&&(this.offset.relative=this._getRelativeOffset());var f=b.pageX,g=b.pageY;if(this.originalPosition){this.containment&&(b.pageX-this.offset.click.left<this.containment[0]&&(f=this.containment[0]+this.offset.click.left),b.pageY-this.offset.click.top<this.containment[1]&&(g=this.containment[1]+this.offset.click.top),b.pageX-this.offset.click.left>this.containment[2]&&(f=this.containment[2]+this.offset.click.left),b.pageY-this.offset.click.top>this.containment[3]&&(g=this.containment[3]+this.offset.click.top));if(c.grid){var h=this.originalPageY+Math.round((g-this.originalPageY)/c.grid[1])*c.grid[1];g=this.containment?h-this.offset.click.top<this.containment[1]||h-this.offset.click.top>this.containment[3]?h-this.offset.click.top<this.containment[1]?h+c.grid[1]:h-c.grid[1]:h:h;var i=this.originalPageX+Math.round((f-this.originalPageX)/c.grid[0])*c.grid[0];f=this.containment?i-this.offset.click.left<this.containment[0]||i-this.offset.click.left>this.containment[2]?i-this.offset.click.left<this.containment[0]?i+c.grid[0]:i-c.grid[0]:i:i}}return{top:g-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+(a.browser.safari&&this.cssPosition=="fixed"?0:this.cssPosition=="fixed"?-this.scrollParent.scrollTop():e?0:d.scrollTop()),left:f-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+(a.browser.safari&&this.cssPosition=="fixed"?0:this.cssPosition=="fixed"?-this.scrollParent.scrollLeft():e?0:d.scrollLeft())}},_rearrange:function(a,b,c,d){c?c[0].appendChild(this.placeholder[0]):b.item[0].parentNode.insertBefore(this.placeholder[0],this.direction=="down"?b.item[0]:b.item[0].nextSibling),this.counter=this.counter?++this.counter:1;var e=this,f=this.counter;window.setTimeout(function(){f==e.counter&&e.refreshPositions(!d)},0)},_clear:function(b,c){this.reverting=!1;var d=[],e=this;!this._noFinalSort&&this.currentItem.parent().length&&this.placeholder.before(this.currentItem),this._noFinalSort=null;if(this.helper[0]==this.currentItem[0]){for(var f in this._storedCSS)if(this._storedCSS[f]=="auto"||this._storedCSS[f]=="static")this._storedCSS[f]="";this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")}else this.currentItem.show();this.fromOutside&&!c&&d.push(function(a){this._trigger("receive",a,this._uiHash(this.fromOutside))}),(this.fromOutside||this.domPosition.prev!=this.currentItem.prev().not(".ui-sortable-helper")[0]||this.domPosition.parent!=this.currentItem.parent()[0])&&!c&&d.push(function(a){this._trigger("update",a,this._uiHash())});if(!a.ui.contains(this.element[0],this.currentItem[0])){c||d.push(function(a){this._trigger("remove",a,this._uiHash())});for(var f=this.containers.length-1;f>=0;f--)a.ui.contains(this.containers[f].element[0],this.currentItem[0])&&!c&&(d.push(function(a){return function(b){a._trigger("receive",b,this._uiHash(this))}}.call(this,this.containers[f])),d.push(function(a){return function(b){a._trigger("update",b,this._uiHash(this))}}.call(this,this.containers[f])))}for(var f=this.containers.length-1;f>=0;f--)c||d.push(function(a){return function(b){a._trigger("deactivate",b,this._uiHash(this))}}.call(this,this.containers[f])),this.containers[f].containerCache.over&&(d.push(function(a){return function(b){a._trigger("out",b,this._uiHash(this))}}.call(this,this.containers[f])),this.containers[f].containerCache.over=0);this._storedCursor&&a("body").css("cursor",this._storedCursor),this._storedOpacity&&this.helper.css("opacity",this._storedOpacity),this._storedZIndex&&this.helper.css("zIndex",this._storedZIndex=="auto"?"":this._storedZIndex),this.dragging=!1;if(this.cancelHelperRemoval){if(!c){this._trigger("beforeStop",b,this._uiHash());for(var f=0;f<d.length;f++)d[f].call(this,b);this._trigger("stop",b,this._uiHash())}return!1}c||this._trigger("beforeStop",b,this._uiHash()),this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.helper[0]!=this.currentItem[0]&&this.helper.remove(),this.helper=null;if(!c){for(var f=0;f<d.length;f++)d[f].call(this,b);this._trigger("stop",b,this._uiHash())}this.fromOutside=!1;return!0},_trigger:function(){a.Widget.prototype._trigger.apply(this,arguments)===!1&&this.cancel()},_uiHash:function(b){var c=b||this;return{helper:c.helper,placeholder:c.placeholder||a([]),position:c.position,originalPosition:c.originalPosition,offset:c.positionAbs,item:c.currentItem,sender:b?b.element:null}}}),a.extend(a.ui.sortable,{version:"1.8.18"})})(jQuery);

/* jQuery UI Datepicker 1.8.18 */
(function($,undefined){function isArray(a){return a&&($.browser.safari&&typeof a=="object"&&a.length||a.constructor&&a.constructor.toString().match(/\Array\(\)/))}function extendRemove(a,b){$.extend(a,b);for(var c in b)if(b[c]==null||b[c]==undefined)a[c]=b[c];return a}function bindHover(a){var b="button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";return a.bind("mouseout",function(a){var c=$(a.target).closest(b);!c.length||c.removeClass("ui-state-hover ui-datepicker-prev-hover ui-datepicker-next-hover")}).bind("mouseover",function(c){var d=$(c.target).closest(b);!$.datepicker._isDisabledDatepicker(instActive.inline?a.parent()[0]:instActive.input[0])&&!!d.length&&(d.parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover"),d.addClass("ui-state-hover"),d.hasClass("ui-datepicker-prev")&&d.addClass("ui-datepicker-prev-hover"),d.hasClass("ui-datepicker-next")&&d.addClass("ui-datepicker-next-hover"))})}function Datepicker(){this.debug=!1,this._curInst=null,this._keyEvent=!1,this._disabledInputs=[],this._datepickerShowing=!1,this._inDialog=!1,this._mainDivId="ui-datepicker-div",this._inlineClass="ui-datepicker-inline",this._appendClass="ui-datepicker-append",this._triggerClass="ui-datepicker-trigger",this._dialogClass="ui-datepicker-dialog",this._disableClass="ui-datepicker-disabled",this._unselectableClass="ui-datepicker-unselectable",this._currentClass="ui-datepicker-current-day",this._dayOverClass="ui-datepicker-days-cell-over",this.regional=[],this.regional[""]={closeText:"Done",prevText:"Prev",nextText:"Next",currentText:"Today",monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],monthNamesShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],dayNamesShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],dayNamesMin:["Su","Mo","Tu","We","Th","Fr","Sa"],weekHeader:"Wk",dateFormat:"mm/dd/yy",firstDay:0,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""},this._defaults={showOn:"focus",showAnim:"fadeIn",showOptions:{},defaultDate:null,appendText:"",buttonText:"...",buttonImage:"",buttonImageOnly:!1,hideIfNoPrevNext:!1,navigationAsDateFormat:!1,gotoCurrent:!1,changeMonth:!1,changeYear:!1,yearRange:"c-10:c+10",showOtherMonths:!1,selectOtherMonths:!1,showWeek:!1,calculateWeek:this.iso8601Week,shortYearCutoff:"+10",minDate:null,maxDate:null,duration:"fast",beforeShowDay:null,beforeShow:null,onSelect:null,onChangeMonthYear:null,onClose:null,numberOfMonths:1,showCurrentAtPos:0,stepMonths:1,stepBigMonths:12,altField:"",altFormat:"",constrainInput:!0,showButtonPanel:!1,autoSize:!1,disabled:!1},$.extend(this._defaults,this.regional[""]),this.dpDiv=bindHover($('<div id="'+this._mainDivId+'" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))}$.extend($.ui,{datepicker:{version:"1.8.18"}});var PROP_NAME="datepicker",dpuuid=(new Date).getTime(),instActive;$.extend(Datepicker.prototype,{markerClassName:"hasDatepicker",maxRows:4,log:function(){this.debug&&console.log.apply("",arguments)},_widgetDatepicker:function(){return this.dpDiv},setDefaults:function(a){extendRemove(this._defaults,a||{});return this},_attachDatepicker:function(target,settings){var inlineSettings=null;for(var attrName in this._defaults){var attrValue=target.getAttribute("date:"+attrName);if(attrValue){inlineSettings=inlineSettings||{};try{inlineSettings[attrName]=eval(attrValue)}catch(err){inlineSettings[attrName]=attrValue}}}var nodeName=target.nodeName.toLowerCase(),inline=nodeName=="div"||nodeName=="span";target.id||(this.uuid+=1,target.id="dp"+this.uuid);var inst=this._newInst($(target),inline);inst.settings=$.extend({},settings||{},inlineSettings||{}),nodeName=="input"?this._connectDatepicker(target,inst):inline&&this._inlineDatepicker(target,inst)},_newInst:function(a,b){var c=a[0].id.replace(/([^A-Za-z0-9_-])/g,"\\\\$1");return{id:c,input:a,selectedDay:0,selectedMonth:0,selectedYear:0,drawMonth:0,drawYear:0,inline:b,dpDiv:b?bindHover($('<div class="'+this._inlineClass+' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>')):this.dpDiv}},_connectDatepicker:function(a,b){var c=$(a);b.append=$([]),b.trigger=$([]);c.hasClass(this.markerClassName)||(this._attachments(c,b),c.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).keyup(this._doKeyUp).bind("setData.datepicker",function(a,c,d){b.settings[c]=d}).bind("getData.datepicker",function(a,c){return this._get(b,c)}),this._autoSize(b),$.data(a,PROP_NAME,b),b.settings.disabled&&this._disableDatepicker(a))},_attachments:function(a,b){var c=this._get(b,"appendText"),d=this._get(b,"isRTL");b.append&&b.append.remove(),c&&(b.append=$('<span class="'+this._appendClass+'">'+c+"</span>"),a[d?"before":"after"](b.append)),a.unbind("focus",this._showDatepicker),b.trigger&&b.trigger.remove();var e=this._get(b,"showOn");(e=="focus"||e=="both")&&a.focus(this._showDatepicker);if(e=="button"||e=="both"){var f=this._get(b,"buttonText"),g=this._get(b,"buttonImage");b.trigger=$(this._get(b,"buttonImageOnly")?$("<img/>").addClass(this._triggerClass).attr({src:g,alt:f,title:f}):$('<button type="button"></button>').addClass(this._triggerClass).html(g==""?f:$("<img/>").attr({src:g,alt:f,title:f}))),a[d?"before":"after"](b.trigger),b.trigger.click(function(){$.datepicker._datepickerShowing&&$.datepicker._lastInput==a[0]?$.datepicker._hideDatepicker():$.datepicker._datepickerShowing&&$.datepicker._lastInput!=a[0]?($.datepicker._hideDatepicker(),$.datepicker._showDatepicker(a[0])):$.datepicker._showDatepicker(a[0]);return!1})}},_autoSize:function(a){if(this._get(a,"autoSize")&&!a.inline){var b=new Date(2009,11,20),c=this._get(a,"dateFormat");if(c.match(/[DM]/)){var d=function(a){var b=0,c=0;for(var d=0;d<a.length;d++)a[d].length>b&&(b=a[d].length,c=d);return c};b.setMonth(d(this._get(a,c.match(/MM/)?"monthNames":"monthNamesShort"))),b.setDate(d(this._get(a,c.match(/DD/)?"dayNames":"dayNamesShort"))+20-b.getDay())}a.input.attr("size",this._formatDate(a,b).length)}},_inlineDatepicker:function(a,b){var c=$(a);c.hasClass(this.markerClassName)||(c.addClass(this.markerClassName).append(b.dpDiv).bind("setData.datepicker",function(a,c,d){b.settings[c]=d}).bind("getData.datepicker",function(a,c){return this._get(b,c)}),$.data(a,PROP_NAME,b),this._setDate(b,this._getDefaultDate(b),!0),this._updateDatepicker(b),this._updateAlternate(b),b.settings.disabled&&this._disableDatepicker(a),b.dpDiv.css("display","block"))},_dialogDatepicker:function(a,b,c,d,e){var f=this._dialogInst;if(!f){this.uuid+=1;var g="dp"+this.uuid;this._dialogInput=$('<input type="text" id="'+g+'" style="position: absolute; top: -100px; width: 0px; z-index: -10;"/>'),this._dialogInput.keydown(this._doKeyDown),$("body").append(this._dialogInput),f=this._dialogInst=this._newInst(this._dialogInput,!1),f.settings={},$.data(this._dialogInput[0],PROP_NAME,f)}extendRemove(f.settings,d||{}),b=b&&b.constructor==Date?this._formatDate(f,b):b,this._dialogInput.val(b),this._pos=e?e.length?e:[e.pageX,e.pageY]:null;if(!this._pos){var h=document.documentElement.clientWidth,i=document.documentElement.clientHeight,j=document.documentElement.scrollLeft||document.body.scrollLeft,k=document.documentElement.scrollTop||document.body.scrollTop;this._pos=[h/2-100+j,i/2-150+k]}this._dialogInput.css("left",this._pos[0]+20+"px").css("top",this._pos[1]+"px"),f.settings.onSelect=c,this._inDialog=!0,this.dpDiv.addClass(this._dialogClass),this._showDatepicker(this._dialogInput[0]),$.blockUI&&$.blockUI(this.dpDiv),$.data(this._dialogInput[0],PROP_NAME,f);return this},_destroyDatepicker:function(a){var b=$(a),c=$.data(a,PROP_NAME);if(!!b.hasClass(this.markerClassName)){var d=a.nodeName.toLowerCase();$.removeData(a,PROP_NAME),d=="input"?(c.append.remove(),c.trigger.remove(),b.removeClass(this.markerClassName).unbind("focus",this._showDatepicker).unbind("keydown",this._doKeyDown).unbind("keypress",this._doKeyPress).unbind("keyup",this._doKeyUp)):(d=="div"||d=="span")&&b.removeClass(this.markerClassName).empty()}},_enableDatepicker:function(a){var b=$(a),c=$.data(a,PROP_NAME);if(!!b.hasClass(this.markerClassName)){var d=a.nodeName.toLowerCase();if(d=="input")a.disabled=!1,c.trigger.filter("button").each(function(){this.disabled=!1}).end().filter("img").css({opacity:"1.0",cursor:""});else if(d=="div"||d=="span"){var e=b.children("."+this._inlineClass);e.children().removeClass("ui-state-disabled"),e.find("select.ui-datepicker-month, select.ui-datepicker-year").removeAttr("disabled")}this._disabledInputs=$.map(this._disabledInputs,function(b){return b==a?null:b})}},_disableDatepicker:function(a){var b=$(a),c=$.data(a,PROP_NAME);if(!!b.hasClass(this.markerClassName)){var d=a.nodeName.toLowerCase();if(d=="input")a.disabled=!0,c.trigger.filter("button").each(function(){this.disabled=!0}).end().filter("img").css({opacity:"0.5",cursor:"default"});else if(d=="div"||d=="span"){var e=b.children("."+this._inlineClass);e.children().addClass("ui-state-disabled"),e.find("select.ui-datepicker-month, select.ui-datepicker-year").attr("disabled","disabled")}this._disabledInputs=$.map(this._disabledInputs,function(b){return b==a?null:b}),this._disabledInputs[this._disabledInputs.length]=a}},_isDisabledDatepicker:function(a){if(!a)return!1;for(var b=0;b<this._disabledInputs.length;b++)if(this._disabledInputs[b]==a)return!0;return!1},_getInst:function(a){try{return $.data(a,PROP_NAME)}catch(b){throw"Missing instance data for this datepicker"}},_optionDatepicker:function(a,b,c){var d=this._getInst(a);if(arguments.length==2&&typeof b=="string")return b=="defaults"?$.extend({},$.datepicker._defaults):d?b=="all"?$.extend({},d.settings):this._get(d,b):null;var e=b||{};typeof b=="string"&&(e={},e[b]=c);if(d){this._curInst==d&&this._hideDatepicker();var f=this._getDateDatepicker(a,!0),g=this._getMinMaxDate(d,"min"),h=this._getMinMaxDate(d,"max");extendRemove(d.settings,e),g!==null&&e.dateFormat!==undefined&&e.minDate===undefined&&(d.settings.minDate=this._formatDate(d,g)),h!==null&&e.dateFormat!==undefined&&e.maxDate===undefined&&(d.settings.maxDate=this._formatDate(d,h)),this._attachments($(a),d),this._autoSize(d),this._setDate(d,f),this._updateAlternate(d),this._updateDatepicker(d)}},_changeDatepicker:function(a,b,c){this._optionDatepicker(a,b,c)},_refreshDatepicker:function(a){var b=this._getInst(a);b&&this._updateDatepicker(b)},_setDateDatepicker:function(a,b){var c=this._getInst(a);c&&(this._setDate(c,b),this._updateDatepicker(c),this._updateAlternate(c))},_getDateDatepicker:function(a,b){var c=this._getInst(a);c&&!c.inline&&this._setDateFromField(c,b);return c?this._getDate(c):null},_doKeyDown:function(a){var b=$.datepicker._getInst(a.target),c=!0,d=b.dpDiv.is(".ui-datepicker-rtl");b._keyEvent=!0;if($.datepicker._datepickerShowing)switch(a.keyCode){case 9:$.datepicker._hideDatepicker(),c=!1;break;case 13:var e=$("td."+$.datepicker._dayOverClass+":not(."+$.datepicker._currentClass+")",b.dpDiv);e[0]&&$.datepicker._selectDay(a.target,b.selectedMonth,b.selectedYear,e[0]);var f=$.datepicker._get(b,"onSelect");if(f){var g=$.datepicker._formatDate(b);f.apply(b.input?b.input[0]:null,[g,b])}else $.datepicker._hideDatepicker();return!1;case 27:$.datepicker._hideDatepicker();break;case 33:$.datepicker._adjustDate(a.target,a.ctrlKey?-$.datepicker._get(b,"stepBigMonths"):-$.datepicker._get(b,"stepMonths"),"M");break;case 34:$.datepicker._adjustDate(a.target,a.ctrlKey?+$.datepicker._get(b,"stepBigMonths"):+$.datepicker._get(b,"stepMonths"),"M");break;case 35:(a.ctrlKey||a.metaKey)&&$.datepicker._clearDate(a.target),c=a.ctrlKey||a.metaKey;break;case 36:(a.ctrlKey||a.metaKey)&&$.datepicker._gotoToday(a.target),c=a.ctrlKey||a.metaKey;break;case 37:(a.ctrlKey||a.metaKey)&&$.datepicker._adjustDate(a.target,d?1:-1,"D"),c=a.ctrlKey||a.metaKey,a.originalEvent.altKey&&$.datepicker._adjustDate(a.target,a.ctrlKey?-$.datepicker._get(b,"stepBigMonths"):-$.datepicker._get(b,"stepMonths"),"M");break;case 38:(a.ctrlKey||a.metaKey)&&$.datepicker._adjustDate(a.target,-7,"D"),c=a.ctrlKey||a.metaKey;break;case 39:(a.ctrlKey||a.metaKey)&&$.datepicker._adjustDate(a.target,d?-1:1,"D"),c=a.ctrlKey||a.metaKey,a.originalEvent.altKey&&$.datepicker._adjustDate(a.target,a.ctrlKey?+$.datepicker._get(b,"stepBigMonths"):+$.datepicker._get(b,"stepMonths"),"M");break;case 40:(a.ctrlKey||a.metaKey)&&$.datepicker._adjustDate(a.target,7,"D"),c=a.ctrlKey||a.metaKey;break;default:c=!1}else a.keyCode==36&&a.ctrlKey?$.datepicker._showDatepicker(this):c=!1;c&&(a.preventDefault(),a.stopPropagation())},_doKeyPress:function(a){var b=$.datepicker._getInst(a.target);if($.datepicker._get(b,"constrainInput")){var c=$.datepicker._possibleChars($.datepicker._get(b,"dateFormat")),d=String.fromCharCode(a.charCode==undefined?a.keyCode:a.charCode);return a.ctrlKey||a.metaKey||d<" "||!c||c.indexOf(d)>-1}},_doKeyUp:function(a){var b=$.datepicker._getInst(a.target);if(b.input.val()!=b.lastVal)try{var c=$.datepicker.parseDate($.datepicker._get(b,"dateFormat"),b.input?b.input.val():null,$.datepicker._getFormatConfig(b));c&&($.datepicker._setDateFromField(b),$.datepicker._updateAlternate(b),$.datepicker._updateDatepicker(b))}catch(a){$.datepicker.log(a)}return!0},_showDatepicker:function(a){a=a.target||a,a.nodeName.toLowerCase()!="input"&&(a=$("input",a.parentNode)[0]);if(!$.datepicker._isDisabledDatepicker(a)&&$.datepicker._lastInput!=a){var b=$.datepicker._getInst(a);$.datepicker._curInst&&$.datepicker._curInst!=b&&($.datepicker._curInst.dpDiv.stop(!0,!0),b&&$.datepicker._datepickerShowing&&$.datepicker._hideDatepicker($.datepicker._curInst.input[0]));var c=$.datepicker._get(b,"beforeShow"),d=c?c.apply(a,[a,b]):{};if(d===!1)return;extendRemove(b.settings,d),b.lastVal=null,$.datepicker._lastInput=a,$.datepicker._setDateFromField(b),$.datepicker._inDialog&&(a.value=""),$.datepicker._pos||($.datepicker._pos=$.datepicker._findPos(a),$.datepicker._pos[1]+=a.offsetHeight);var e=!1;$(a).parents().each(function(){e|=$(this).css("position")=="fixed";return!e}),e&&$.browser.opera&&($.datepicker._pos[0]-=document.documentElement.scrollLeft,$.datepicker._pos[1]-=document.documentElement.scrollTop);var f={left:$.datepicker._pos[0],top:$.datepicker._pos[1]};$.datepicker._pos=null,b.dpDiv.empty(),b.dpDiv.css({position:"absolute",display:"block",top:"-1000px"}),$.datepicker._updateDatepicker(b),f=$.datepicker._checkOffset(b,f,e),b.dpDiv.css({position:$.datepicker._inDialog&&$.blockUI?"static":e?"fixed":"absolute",display:"none",left:f.left+"px",top:f.top+"px"});if(!b.inline){var g=$.datepicker._get(b,"showAnim"),h=$.datepicker._get(b,"duration"),i=function(){var a=b.dpDiv.find("iframe.ui-datepicker-cover");if(!!a.length){var c=$.datepicker._getBorders(b.dpDiv);a.css({left:-c[0],top:-c[1],width:b.dpDiv.outerWidth(),height:b.dpDiv.outerHeight()})}};b.dpDiv.zIndex($(a).zIndex()+1),$.datepicker._datepickerShowing=!0,$.effects&&$.effects[g]?b.dpDiv.show(g,$.datepicker._get(b,"showOptions"),h,i):b.dpDiv[g||"show"](g?h:null,i),(!g||!h)&&i(),b.input.is(":visible")&&!b.input.is(":disabled")&&b.input.focus(),$.datepicker._curInst=b}}},_updateDatepicker:function(a){var b=this;b.maxRows=4;var c=$.datepicker._getBorders(a.dpDiv);instActive=a,a.dpDiv.empty().append(this._generateHTML(a));var d=a.dpDiv.find("iframe.ui-datepicker-cover");!d.length||d.css({left:-c[0],top:-c[1],width:a.dpDiv.outerWidth(),height:a.dpDiv.outerHeight()}),a.dpDiv.find("."+this._dayOverClass+" a").mouseover();var e=this._getNumberOfMonths(a),f=e[1],g=17;a.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width(""),f>1&&a.dpDiv.addClass("ui-datepicker-multi-"+f).css("width",g*f+"em"),a.dpDiv[(e[0]!=1||e[1]!=1?"add":"remove")+"Class"]("ui-datepicker-multi"),a.dpDiv[(this._get(a,"isRTL")?"add":"remove")+"Class"]("ui-datepicker-rtl"),a==$.datepicker._curInst&&$.datepicker._datepickerShowing&&a.input&&a.input.is(":visible")&&!a.input.is(":disabled")&&a.input[0]!=document.activeElement&&a.input.focus();if(a.yearshtml){var h=a.yearshtml;setTimeout(function(){h===a.yearshtml&&a.yearshtml&&a.dpDiv.find("select.ui-datepicker-year:first").replaceWith(a.yearshtml),h=a.yearshtml=null},0)}},_getBorders:function(a){var b=function(a){return{thin:1,medium:2,thick:3}[a]||a};return[parseFloat(b(a.css("border-left-width"))),parseFloat(b(a.css("border-top-width")))]},_checkOffset:function(a,b,c){var d=a.dpDiv.outerWidth(),e=a.dpDiv.outerHeight(),f=a.input?a.input.outerWidth():0,g=a.input?a.input.outerHeight():0,h=document.documentElement.clientWidth+$(document).scrollLeft(),i=document.documentElement.clientHeight+$(document).scrollTop();b.left-=this._get(a,"isRTL")?d-f:0,b.left-=c&&b.left==a.input.offset().left?$(document).scrollLeft():0,b.top-=c&&b.top==a.input.offset().top+g?$(document).scrollTop():0,b.left-=Math.min(b.left,b.left+d>h&&h>d?Math.abs(b.left+d-h):0),b.top-=Math.min(b.top,b.top+e>i&&i>e?Math.abs(e+g):0);return b},_findPos:function(a){var b=this._getInst(a),c=this._get(b,"isRTL");while(a&&(a.type=="hidden"||a.nodeType!=1||$.expr.filters.hidden(a)))a=a[c?"previousSibling":"nextSibling"];var d=$(a).offset();return[d.left,d.top]},_hideDatepicker:function(a){var b=this._curInst;if(!(!b||a&&b!=$.data(a,PROP_NAME))&&this._datepickerShowing){var c=this._get(b,"showAnim"),d=this._get(b,"duration"),e=this,f=function(){$.datepicker._tidyDialog(b),e._curInst=null};$.effects&&$.effects[c]?b.dpDiv.hide(c,$.datepicker._get(b,"showOptions"),d,f):b.dpDiv[c=="slideDown"?"slideUp":c=="fadeIn"?"fadeOut":"hide"](c?d:null,f),c||f(),this._datepickerShowing=!1;var g=this._get(b,"onClose");g&&g.apply(b.input?b.input[0]:null,[b.input?b.input.val():"",b]),this._lastInput=null,this._inDialog&&(this._dialogInput.css({position:"absolute",left:"0",top:"-100px"}),$.blockUI&&($.unblockUI(),$("body").append(this.dpDiv))),this._inDialog=!1}},_tidyDialog:function(a){a.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar")},_checkExternalClick:function(a){if(!!$.datepicker._curInst){var b=$(a.target),c=$.datepicker._getInst(b[0]);(b[0].id!=$.datepicker._mainDivId&&b.parents("#"+$.datepicker._mainDivId).length==0&&!b.hasClass($.datepicker.markerClassName)&&!b.closest("."+$.datepicker._triggerClass).length&&$.datepicker._datepickerShowing&&(!$.datepicker._inDialog||!$.blockUI)||b.hasClass($.datepicker.markerClassName)&&$.datepicker._curInst!=c)&&$.datepicker._hideDatepicker()}},_adjustDate:function(a,b,c){var d=$(a),e=this._getInst(d[0]);this._isDisabledDatepicker(d[0])||(this._adjustInstDate(e,b+(c=="M"?this._get(e,"showCurrentAtPos"):0),c),this._updateDatepicker(e))},_gotoToday:function(a){var b=$(a),c=this._getInst(b[0]);if(this._get(c,"gotoCurrent")&&c.currentDay)c.selectedDay=c.currentDay,c.drawMonth=c.selectedMonth=c.currentMonth,c.drawYear=c.selectedYear=c.currentYear;else{var d=new Date;c.selectedDay=d.getDate(),c.drawMonth=c.selectedMonth=d.getMonth(),c.drawYear=c.selectedYear=d.getFullYear()}this._notifyChange(c),this._adjustDate(b)},_selectMonthYear:function(a,b,c){var d=$(a),e=this._getInst(d[0]);e["selected"+(c=="M"?"Month":"Year")]=e["draw"+(c=="M"?"Month":"Year")]=parseInt(b.options[b.selectedIndex].value,10),this._notifyChange(e),this._adjustDate(d)},_selectDay:function(a,b,c,d){var e=$(a);if(!$(d).hasClass(this._unselectableClass)&&!this._isDisabledDatepicker(e[0])){var f=this._getInst(e[0]);f.selectedDay=f.currentDay=$("a",d).html(),f.selectedMonth=f.currentMonth=b,f.selectedYear=f.currentYear=c,this._selectDate(a,this._formatDate(f,f.currentDay,f.currentMonth,f.currentYear))}},_clearDate:function(a){var b=$(a),c=this._getInst(b[0]);this._selectDate(b,"")},_selectDate:function(a,b){var c=$(a),d=this._getInst(c[0]);b=b!=null?b:this._formatDate(d),d.input&&d.input.val(b),this._updateAlternate(d);var e=this._get(d,"onSelect");e?e.apply(d.input?d.input[0]:null,[b,d]):d.input&&d.input.trigger("change"),d.inline?this._updateDatepicker(d):(this._hideDatepicker(),this._lastInput=d.input[0],typeof d.input[0]!="object"&&d.input.focus(),this._lastInput=null)},_updateAlternate:function(a){var b=this._get(a,"altField");if(b){var c=this._get(a,"altFormat")||this._get(a,"dateFormat"),d=this._getDate(a),e=this.formatDate(c,d,this._getFormatConfig(a));$(b).each(function(){$(this).val(e)})}},noWeekends:function(a){var b=a.getDay();return[b>0&&b<6,""]},iso8601Week:function(a){var b=new Date(a.getTime());b.setDate(b.getDate()+4-(b.getDay()||7));var c=b.getTime();b.setMonth(0),b.setDate(1);return Math.floor(Math.round((c-b)/864e5)/7)+1},parseDate:function(a,b,c){if(a==null||b==null)throw"Invalid arguments";b=typeof b=="object"?b.toString():b+"";if(b=="")return null;var d=(c?c.shortYearCutoff:null)||this._defaults.shortYearCutoff;d=typeof d!="string"?d:(new Date).getFullYear()%100+parseInt(d,10);var e=(c?c.dayNamesShort:null)||this._defaults.dayNamesShort,f=(c?c.dayNames:null)||this._defaults.dayNames,g=(c?c.monthNamesShort:null)||this._defaults.monthNamesShort,h=(c?c.monthNames:null)||this._defaults.monthNames,i=-1,j=-1,k=-1,l=-1,m=!1,n=function(b){var c=s+1<a.length&&a.charAt(s+1)==b;c&&s++;return c},o=function(a){var c=n(a),d=a=="@"?14:a=="!"?20:a=="y"&&c?4:a=="o"?3:2,e=new RegExp("^\\d{1,"+d+"}"),f=b.substring(r).match(e);if(!f)throw"Missing number at position "+r;r+=f[0].length;return parseInt(f[0],10)},p=function(a,c,d){var e=$.map(n(a)?d:c,function(a,b){return[[b,a]]}).sort(function(a,b){return-(a[1].length-b[1].length)}),f=-1;$.each(e,function(a,c){var d=c[1];if(b.substr(r,d.length).toLowerCase()==d.toLowerCase()){f=c[0],r+=d.length;return!1}});if(f!=-1)return f+1;throw"Unknown name at position "+r},q=function(){if(b.charAt(r)!=a.charAt(s))throw"Unexpected literal at position "+r;r++},r=0;for(var s=0;s<a.length;s++)if(m)a.charAt(s)=="'"&&!n("'")?m=!1:q();else switch(a.charAt(s)){case"d":k=o("d");break;case"D":p("D",e,f);break;case"o":l=o("o");break;case"m":j=o("m");break;case"M":j=p("M",g,h);break;case"y":i=o("y");break;case"@":var t=new Date(o("@"));i=t.getFullYear(),j=t.getMonth()+1,k=t.getDate();break;case"!":var t=new Date((o("!")-this._ticksTo1970)/1e4);i=t.getFullYear(),j=t.getMonth()+1,k=t.getDate();break;case"'":n("'")?q():m=!0;break;default:q()}if(r<b.length)throw"Extra/unparsed characters found in date: "+b.substring(r);i==-1?i=(new Date).getFullYear():i<100&&(i+=(new Date).getFullYear()-(new Date).getFullYear()%100+(i<=d?0:-100));if(l>-1){j=1,k=l;for(;;){var u=this._getDaysInMonth(i,j-1);if(k<=u)break;j++,k-=u}}var t=this._daylightSavingAdjust(new Date(i,j-1,k));if(t.getFullYear()!=i||t.getMonth()+1!=j||t.getDate()!=k)throw"Invalid date";return t},ATOM:"yy-mm-dd",COOKIE:"D, dd M yy",ISO_8601:"yy-mm-dd",RFC_822:"D, d M y",RFC_850:"DD, dd-M-y",RFC_1036:"D, d M y",RFC_1123:"D, d M yy",RFC_2822:"D, d M yy",RSS:"D, d M y",TICKS:"!",TIMESTAMP:"@",W3C:"yy-mm-dd",_ticksTo1970:(718685+Math.floor(492.5)-Math.floor(19.7)+Math.floor(4.925))*24*60*60*1e7,formatDate:function(a,b,c){if(!b)return"";var d=(c?c.dayNamesShort:null)||this._defaults.dayNamesShort,e=(c?c.dayNames:null)||this._defaults.dayNames,f=(c?c.monthNamesShort:null)||this._defaults.monthNamesShort,g=(c?c.monthNames:null)||this._defaults.monthNames,h=function(b){var c=m+1<a.length&&a.charAt(m+1)==b;c&&m++;return c},i=function(a,b,c){var d=""+b;if(h(a))while(d.length<c)d="0"+d;return d},j=function(a,b,c,d){return h(a)?d[b]:c[b]},k="",l=!1;if(b)for(var m=0;m<a.length;m++)if(l)a.charAt(m)=="'"&&!h("'")?l=!1:k+=a.charAt(m);else switch(a.charAt(m)){case"d":k+=i("d",b.getDate(),2);break;case"D":k+=j("D",b.getDay(),d,e);break;case"o":k+=i("o",Math.round(((new Date(b.getFullYear(),b.getMonth(),b.getDate())).getTime()-(new Date(b.getFullYear(),0,0)).getTime())/864e5),3);break;case"m":k+=i("m",b.getMonth()+1,2);break;case"M":k+=j("M",b.getMonth(),f,g);break;case"y":k+=h("y")?b.getFullYear():(b.getYear()%100<10?"0":"")+b.getYear()%100;break;case"@":k+=b.getTime();break;case"!":k+=b.getTime()*1e4+this._ticksTo1970;break;case"'":h("'")?k+="'":l=!0;break;default:k+=a.charAt(m)}return k},_possibleChars:function(a){var b="",c=!1,d=function(b){var c=e+1<a.length&&a.charAt(e+1)==b;c&&e++;return c};for(var e=0;e<a.length;e++)if(c)a.charAt(e)=="'"&&!d("'")?c=!1:b+=a.charAt(e);else switch(a.charAt(e)){case"d":case"m":case"y":case"@":b+="0123456789";break;case"D":case"M":return null;case"'":d("'")?b+="'":c=!0;break;default:b+=a.charAt(e)}return b},_get:function(a,b){return a.settings[b]!==undefined?a.settings[b]:this._defaults[b]},_setDateFromField:function(a,b){if(a.input.val()!=a.lastVal){var c=this._get(a,"dateFormat"),d=a.lastVal=a.input?a.input.val():null,e,f;e=f=this._getDefaultDate(a);var g=this._getFormatConfig(a);try{e=this.parseDate(c,d,g)||f}catch(h){this.log(h),d=b?"":d}a.selectedDay=e.getDate(),a.drawMonth=a.selectedMonth=e.getMonth(),a.drawYear=a.selectedYear=e.getFullYear(),a.currentDay=d?e.getDate():0,a.currentMonth=d?e.getMonth():0,a.currentYear=d?e.getFullYear():0,this._adjustInstDate(a)}},_getDefaultDate:function(a){return this._restrictMinMax(a,this._determineDate(a,this._get(a,"defaultDate"),new Date))},_determineDate:function(a,b,c){var d=function(a){var b=new Date;b.setDate(b.getDate()+a);return b},e=function(b){try{return $.datepicker.parseDate($.datepicker._get(a,"dateFormat"),b,$.datepicker._getFormatConfig(a))}catch(c){}var d=(b.toLowerCase().match(/^c/)?$.datepicker._getDate(a):null)||new Date,e=d.getFullYear(),f=d.getMonth(),g=d.getDate(),h=/([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g,i=h.exec(b);while(i){switch(i[2]||"d"){case"d":case"D":g+=parseInt(i[1],10);break;case"w":case"W":g+=parseInt(i[1],10)*7;break;case"m":case"M":f+=parseInt(i[1],10),g=Math.min(g,$.datepicker._getDaysInMonth(e,f));break;case"y":case"Y":e+=parseInt(i[1],10),g=Math.min(g,$.datepicker._getDaysInMonth(e,f))}i=h.exec(b)}return new Date(e,f,g)},f=b==null||b===""?c:typeof b=="string"?e(b):typeof b=="number"?isNaN(b)?c:d(b):new Date(b.getTime());f=f&&f.toString()=="Invalid Date"?c:f,f&&(f.setHours(0),f.setMinutes(0),f.setSeconds(0),f.setMilliseconds(0));return this._daylightSavingAdjust(f)},_daylightSavingAdjust:function(a){if(!a)return null;a.setHours(a.getHours()>12?a.getHours()+2:0);return a},_setDate:function(a,b,c){var d=!b,e=a.selectedMonth,f=a.selectedYear,g=this._restrictMinMax(a,this._determineDate(a,b,new Date));a.selectedDay=a.currentDay=g.getDate(),a.drawMonth=a.selectedMonth=a.currentMonth=g.getMonth(),a.drawYear=a.selectedYear=a.currentYear=g.getFullYear(),(e!=a.selectedMonth||f!=a.selectedYear)&&!c&&this._notifyChange(a),this._adjustInstDate(a),a.input&&a.input.val(d?"":this._formatDate(a))},_getDate:function(a){var b=!a.currentYear||a.input&&a.input.val()==""?null:this._daylightSavingAdjust(new Date(a.currentYear,a.currentMonth,a.currentDay));return b},_generateHTML:function(a){var b=new Date;b=this._daylightSavingAdjust(new Date(b.getFullYear(),b.getMonth(),b.getDate()));var c=this._get(a,"isRTL"),d=this._get(a,"showButtonPanel"),e=this._get(a,"hideIfNoPrevNext"),f=this._get(a,"navigationAsDateFormat"),g=this._getNumberOfMonths(a),h=this._get(a,"showCurrentAtPos"),i=this._get(a,"stepMonths"),j=g[0]!=1||g[1]!=1,k=this._daylightSavingAdjust(a.currentDay?new Date(a.currentYear,a.currentMonth,a.currentDay):new Date(9999,9,9)),l=this._getMinMaxDate(a,"min"),m=this._getMinMaxDate(a,"max"),n=a.drawMonth-h,o=a.drawYear;n<0&&(n+=12,o--);if(m){var p=this._daylightSavingAdjust(new Date(m.getFullYear(),m.getMonth()-g[0]*g[1]+1,m.getDate()));p=l&&p<l?l:p;while(this._daylightSavingAdjust(new Date(o,n,1))>p)n--,n<0&&(n=11,o--)}a.drawMonth=n,a.drawYear=o;var q=this._get(a,"prevText");q=f?this.formatDate(q,this._daylightSavingAdjust(new Date(o,n-i,1)),this._getFormatConfig(a)):q;var r=this._canAdjustMonth(a,-1,o,n)?'<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery_'+dpuuid+".datepicker._adjustDate('#"+a.id+"', -"+i+", 'M');\""+' title="'+q+'"><span class="ui-icon ui-icon-circle-triangle-'+(c?"e":"w")+'">'+q+"</span></a>":e?"":'<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="'+q+'"><span class="ui-icon ui-icon-circle-triangle-'+(c?"e":"w")+'">'+q+"</span></a>",s=this._get(a,"nextText");s=f?this.formatDate(s,this._daylightSavingAdjust(new Date(o,n+i,1)),this._getFormatConfig(a)):s;var t=this._canAdjustMonth(a,1,o,n)?'<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery_'+dpuuid+".datepicker._adjustDate('#"+a.id+"', +"+i+", 'M');\""+' title="'+s+'"><span class="ui-icon ui-icon-circle-triangle-'+(c?"w":"e")+'">'+s+"</span></a>":e?"":'<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="'+s+'"><span class="ui-icon ui-icon-circle-triangle-'+(c?"w":"e")+'">'+s+"</span></a>",u=this._get(a,"currentText"),v=this._get(a,"gotoCurrent")&&a.currentDay?k:b;u=f?this.formatDate(u,v,this._getFormatConfig(a)):u;var w=a.inline?"":'<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery_'+dpuuid+'.datepicker._hideDatepicker();">'+this._get(a,"closeText")+"</button>",x=d?'<div class="ui-datepicker-buttonpane ui-widget-content">'+(c?w:"")+(this._isInRange(a,v)?'<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery_'+dpuuid+".datepicker._gotoToday('#"+a.id+"');\""+">"+u+"</button>":"")+(c?"":w)+"</div>":"",y=parseInt(this._get(a,"firstDay"),10);y=isNaN(y)?0:y;var z=this._get(a,"showWeek"),A=this._get(a,"dayNames"),B=this._get(a,"dayNamesShort"),C=this._get(a,"dayNamesMin"),D=this._get(a,"monthNames"),E=this._get(a,"monthNamesShort"),F=this._get(a,"beforeShowDay"),G=this._get(a,"showOtherMonths"),H=this._get(a,"selectOtherMonths"),I=this._get(a,"calculateWeek")||this.iso8601Week,J=this._getDefaultDate(a),K="";for(var L=0;L<g[0];L++){var M="";this.maxRows=4;for(var N=0;N<g[1];N++){var O=this._daylightSavingAdjust(new Date(o,n,a.selectedDay)),P=" ui-corner-all",Q="";if(j){Q+='<div class="ui-datepicker-group';if(g[1]>1)switch(N){case 0:Q+=" ui-datepicker-group-first",P=" ui-corner-"+(c?"right":"left");break;case g[1]-1:Q+=" ui-datepicker-group-last",P=" ui-corner-"+(c?"left":"right");break;default:Q+=" ui-datepicker-group-middle",P=""}Q+='">'}Q+='<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix'+P+'">'+(/all|left/.test(P)&&L==0?c?t:r:"")+(/all|right/.test(P)&&L==0?c?r:t:"")+this._generateMonthYearHeader(a,n,o,l,m,L>0||N>0,D,E)+'</div><table class="ui-datepicker-calendar"><thead>'+"<tr>";var R=z?'<th class="ui-datepicker-week-col">'+this._get(a,"weekHeader")+"</th>":"";for(var S=0;S<7;S++){var T=(S+y)%7;R+="<th"+((S+y+6)%7>=5?' class="ui-datepicker-week-end"':"")+">"+'<span title="'+A[T]+'">'+C[T]+"</span></th>"}Q+=R+"</tr></thead><tbody>";var U=this._getDaysInMonth(o,n);o==a.selectedYear&&n==a.selectedMonth&&(a.selectedDay=Math.min(a.selectedDay,U));var V=(this._getFirstDayOfMonth(o,n)-y+7)%7,W=Math.ceil((V+U)/7),X=j?this.maxRows>W?this.maxRows:W:W;this.maxRows=X;var Y=this._daylightSavingAdjust(new Date(o,n,1-V));for(var Z=0;Z<X;Z++){Q+="<tr>";var _=z?'<td class="ui-datepicker-week-col">'+this._get(a,"calculateWeek")(Y)+"</td>":"";for(var S=0;S<7;S++){var ba=F?F.apply(a.input?a.input[0]:null,[Y]):[!0,""],bb=Y.getMonth()!=n,bc=bb&&!H||!ba[0]||l&&Y<l||m&&Y>m;_+='<td class="'+((S+y+6)%7>=5?" ui-datepicker-week-end":"")+(bb?" ui-datepicker-other-month":"")+(Y.getTime()==O.getTime()&&n==a.selectedMonth&&a._keyEvent||J.getTime()==Y.getTime()&&J.getTime()==O.getTime()?" "+this._dayOverClass:"")+(bc?" "+this._unselectableClass+" ui-state-disabled":"")+(bb&&!G?"":" "+ba[1]+(Y.getTime()==k.getTime()?" "+this._currentClass:"")+(Y.getTime()==b.getTime()?" ui-datepicker-today":""))+'"'+((!bb||G)&&ba[2]?' title="'+ba[2]+'"':"")+(bc?"":' onclick="DP_jQuery_'+dpuuid+".datepicker._selectDay('#"+a.id+"',"+Y.getMonth()+","+Y.getFullYear()+', this);return false;"')+">"+(bb&&!G?"&#xa0;":bc?'<span class="ui-state-default">'+Y.getDate()+"</span>":'<a class="ui-state-default'+(Y.getTime()==b.getTime()?" ui-state-highlight":"")+(Y.getTime()==k.getTime()?" ui-state-active":"")+(bb?" ui-priority-secondary":"")+'" href="#">'+Y.getDate()+"</a>")+"</td>",Y.setDate(Y.getDate()+1),Y=this._daylightSavingAdjust(Y)}Q+=_+"</tr>"}n++,n>11&&(n=0,o++),Q+="</tbody></table>"+(j?"</div>"+(g[0]>0&&N==g[1]-1?'<div class="ui-datepicker-row-break"></div>':""):""),M+=Q}K+=M}K+=x+($.browser.msie&&parseInt($.browser.version,10)<7&&!a.inline?'<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>':""),
a._keyEvent=!1;return K},_generateMonthYearHeader:function(a,b,c,d,e,f,g,h){var i=this._get(a,"changeMonth"),j=this._get(a,"changeYear"),k=this._get(a,"showMonthAfterYear"),l='<div class="ui-datepicker-title">',m="";if(f||!i)m+='<span class="ui-datepicker-month">'+g[b]+"</span>";else{var n=d&&d.getFullYear()==c,o=e&&e.getFullYear()==c;m+='<select class="ui-datepicker-month" onchange="DP_jQuery_'+dpuuid+".datepicker._selectMonthYear('#"+a.id+"', this, 'M');\" "+">";for(var p=0;p<12;p++)(!n||p>=d.getMonth())&&(!o||p<=e.getMonth())&&(m+='<option value="'+p+'"'+(p==b?' selected="selected"':"")+">"+h[p]+"</option>");m+="</select>"}k||(l+=m+(f||!i||!j?"&#xa0;":""));if(!a.yearshtml){a.yearshtml="";if(f||!j)l+='<span class="ui-datepicker-year">'+c+"</span>";else{var q=this._get(a,"yearRange").split(":"),r=(new Date).getFullYear(),s=function(a){var b=a.match(/c[+-].*/)?c+parseInt(a.substring(1),10):a.match(/[+-].*/)?r+parseInt(a,10):parseInt(a,10);return isNaN(b)?r:b},t=s(q[0]),u=Math.max(t,s(q[1]||""));t=d?Math.max(t,d.getFullYear()):t,u=e?Math.min(u,e.getFullYear()):u,a.yearshtml+='<select class="ui-datepicker-year" onchange="DP_jQuery_'+dpuuid+".datepicker._selectMonthYear('#"+a.id+"', this, 'Y');\" "+">";for(;t<=u;t++)a.yearshtml+='<option value="'+t+'"'+(t==c?' selected="selected"':"")+">"+t+"</option>";a.yearshtml+="</select>",l+=a.yearshtml,a.yearshtml=null}}l+=this._get(a,"yearSuffix"),k&&(l+=(f||!i||!j?"&#xa0;":"")+m),l+="</div>";return l},_adjustInstDate:function(a,b,c){var d=a.drawYear+(c=="Y"?b:0),e=a.drawMonth+(c=="M"?b:0),f=Math.min(a.selectedDay,this._getDaysInMonth(d,e))+(c=="D"?b:0),g=this._restrictMinMax(a,this._daylightSavingAdjust(new Date(d,e,f)));a.selectedDay=g.getDate(),a.drawMonth=a.selectedMonth=g.getMonth(),a.drawYear=a.selectedYear=g.getFullYear(),(c=="M"||c=="Y")&&this._notifyChange(a)},_restrictMinMax:function(a,b){var c=this._getMinMaxDate(a,"min"),d=this._getMinMaxDate(a,"max"),e=c&&b<c?c:b;e=d&&e>d?d:e;return e},_notifyChange:function(a){var b=this._get(a,"onChangeMonthYear");b&&b.apply(a.input?a.input[0]:null,[a.selectedYear,a.selectedMonth+1,a])},_getNumberOfMonths:function(a){var b=this._get(a,"numberOfMonths");return b==null?[1,1]:typeof b=="number"?[1,b]:b},_getMinMaxDate:function(a,b){return this._determineDate(a,this._get(a,b+"Date"),null)},_getDaysInMonth:function(a,b){return 32-this._daylightSavingAdjust(new Date(a,b,32)).getDate()},_getFirstDayOfMonth:function(a,b){return(new Date(a,b,1)).getDay()},_canAdjustMonth:function(a,b,c,d){var e=this._getNumberOfMonths(a),f=this._daylightSavingAdjust(new Date(c,d+(b<0?b:e[0]*e[1]),1));b<0&&f.setDate(this._getDaysInMonth(f.getFullYear(),f.getMonth()));return this._isInRange(a,f)},_isInRange:function(a,b){var c=this._getMinMaxDate(a,"min"),d=this._getMinMaxDate(a,"max");return(!c||b.getTime()>=c.getTime())&&(!d||b.getTime()<=d.getTime())},_getFormatConfig:function(a){var b=this._get(a,"shortYearCutoff");b=typeof b!="string"?b:(new Date).getFullYear()%100+parseInt(b,10);return{shortYearCutoff:b,dayNamesShort:this._get(a,"dayNamesShort"),dayNames:this._get(a,"dayNames"),monthNamesShort:this._get(a,"monthNamesShort"),monthNames:this._get(a,"monthNames")}},_formatDate:function(a,b,c,d){b||(a.currentDay=a.selectedDay,a.currentMonth=a.selectedMonth,a.currentYear=a.selectedYear);var e=b?typeof b=="object"?b:this._daylightSavingAdjust(new Date(d,c,b)):this._daylightSavingAdjust(new Date(a.currentYear,a.currentMonth,a.currentDay));return this.formatDate(this._get(a,"dateFormat"),e,this._getFormatConfig(a))}}),$.fn.datepicker=function(a){if(!this.length)return this;$.datepicker.initialized||($(document).mousedown($.datepicker._checkExternalClick).find("body").append($.datepicker.dpDiv),$.datepicker.initialized=!0);var b=Array.prototype.slice.call(arguments,1);if(typeof a=="string"&&(a=="isDisabled"||a=="getDate"||a=="widget"))return $.datepicker["_"+a+"Datepicker"].apply($.datepicker,[this[0]].concat(b));if(a=="option"&&arguments.length==2&&typeof arguments[1]=="string")return $.datepicker["_"+a+"Datepicker"].apply($.datepicker,[this[0]].concat(b));return this.each(function(){typeof a=="string"?$.datepicker["_"+a+"Datepicker"].apply($.datepicker,[this].concat(b)):$.datepicker._attachDatepicker(this,a)})},$.datepicker=new Datepicker,$.datepicker.initialized=!1,$.datepicker.uuid=(new Date).getTime(),$.datepicker.version="1.8.18",window["DP_jQuery_"+dpuuid]=$})(jQuery);

/**
 *
 * Color picker
 * Author: Stefan Petre www.eyecon.ro
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
(function ($) {
	var ColorPicker = function () {
		var
			ids = {},
			inAction,
			charMin = 65,
			visible,
			tpl = '<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><span>#</span><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div><input type="button" class="submit" value="Сохранить" /></div>',
			defaults = {
				eventName: 'click',
				onShow: function () {},
				onBeforeShow: function(){},
				onHide: function () {},
				onChange: function () {},
				onSubmit: function () {},
				color: 'ff0000',
				livePreview: true,
				flat: false
			},
			fillRGBFields = function  (hsb, cal) {
				var rgb = HSBToRGB(hsb);
				$(cal).data('colorpicker').fields
					.eq(1).val(rgb.r).end()
					.eq(2).val(rgb.g).end()
					.eq(3).val(rgb.b).end();
			},
			fillHSBFields = function  (hsb, cal) {
				$(cal).data('colorpicker').fields
					.eq(4).val(hsb.h).end()
					.eq(5).val(hsb.s).end()
					.eq(6).val(hsb.b).end();
			},
			fillHexFields = function (hsb, cal) {
				$(cal).data('colorpicker').fields
					.eq(0).val(HSBToHex(hsb)).end();
			},
			setSelector = function (hsb, cal) {
				$(cal).data('colorpicker').selector.css('backgroundColor', '#' + HSBToHex({h: hsb.h, s: 100, b: 100}));
				$(cal).data('colorpicker').selectorIndic.css({
					left: parseInt(150 * hsb.s/100, 10),
					top: parseInt(150 * (100-hsb.b)/100, 10)
				});
			},
			setHue = function (hsb, cal) {
				$(cal).data('colorpicker').hue.css('top', parseInt(150 - 150 * hsb.h/360, 10));
			},
			setCurrentColor = function (hsb, cal) {
				$(cal).data('colorpicker').currentColor.css('backgroundColor', '#' + HSBToHex(hsb));
			},
			setNewColor = function (hsb, cal) {
				$(cal).data('colorpicker').newColor.css('backgroundColor', '#' + HSBToHex(hsb));
			},
			keyDown = function (ev) {
				var pressedKey = ev.charCode || ev.keyCode || -1;
				if ((pressedKey > charMin && pressedKey <= 90) || pressedKey == 32) {
					return false;
				}
				var cal = $(this).parent().parent();
				if (cal.data('colorpicker').livePreview === true) {
					change.apply(this);
				}
			},
			change = function (ev) {
				var cal = $(this).parent().parent(), col;
				if (this.parentNode.className.indexOf('_hex') > 0) {
					cal.data('colorpicker').color = col = HexToHSB(fixHex(this.value));
				} else if (this.parentNode.className.indexOf('_hsb') > 0) {
					cal.data('colorpicker').color = col = fixHSB({
						h: parseInt(cal.data('colorpicker').fields.eq(4).val(), 10),
						s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
						b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
					});
				} else {
					cal.data('colorpicker').color = col = RGBToHSB(fixRGB({
						r: parseInt(cal.data('colorpicker').fields.eq(1).val(), 10),
						g: parseInt(cal.data('colorpicker').fields.eq(2).val(), 10),
						b: parseInt(cal.data('colorpicker').fields.eq(3).val(), 10)
					}));
				}
				if (ev) {
					fillRGBFields(col, cal.get(0));
					fillHexFields(col, cal.get(0));
					fillHSBFields(col, cal.get(0));
				}
				setSelector(col, cal.get(0));
				setHue(col, cal.get(0));
				setNewColor(col, cal.get(0));
				cal.data('colorpicker').onChange.apply(cal, [col, HSBToHex(col), HSBToRGB(col)]);
			},
			blur = function (ev) {
				var cal = $(this).parent().parent();
				cal.data('colorpicker').fields.parent().removeClass('colorpicker_focus');
			},
			focus = function () {
				charMin = this.parentNode.className.indexOf('_hex') > 0 ? 70 : 65;
				$(this).parent().parent().data('colorpicker').fields.parent().removeClass('colorpicker_focus');
				$(this).parent().addClass('colorpicker_focus');
			},
			downIncrement = function (ev) {
				var field = $(this).parent().find('input').focus();
				var current = {
					el: $(this).parent().addClass('colorpicker_slider'),
					max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
					y: ev.pageY,
					field: field,
					val: parseInt(field.val(), 10),
					preview: $(this).parent().parent().data('colorpicker').livePreview					
				};
				$(document).bind('mouseup', current, upIncrement);
				$(document).bind('mousemove', current, moveIncrement);
			},
			moveIncrement = function (ev) {
				ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val + ev.pageY - ev.data.y, 10))));
				if (ev.data.preview) {
					change.apply(ev.data.field.get(0), [true]);
				}
				return false;
			},
			upIncrement = function (ev) {
				change.apply(ev.data.field.get(0), [true]);
				ev.data.el.removeClass('colorpicker_slider').find('input').focus();
				$(document).unbind('mouseup', upIncrement);
				$(document).unbind('mousemove', moveIncrement);
				return false;
			},
			downHue = function (ev) {
				var current = {
					cal: $(this).parent(),
					y: $(this).offset().top
				};
				current.preview = current.cal.data('colorpicker').livePreview;
				$(document).bind('mouseup', current, upHue);
				$(document).bind('mousemove', current, moveHue);
			},
			moveHue = function (ev) {
				change.apply(
					ev.data.cal.data('colorpicker')
						.fields
						.eq(4)
						.val(parseInt(360*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.y))))/150, 10))
						.get(0),
					[ev.data.preview]
				);
				return false;
			},
			upHue = function (ev) {
				fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upHue);
				$(document).unbind('mousemove', moveHue);
				return false;
			},
			downSelector = function (ev) {
				var current = {
					cal: $(this).parent(),
					pos: $(this).offset()
				};
				current.preview = current.cal.data('colorpicker').livePreview;
				$(document).bind('mouseup', current, upSelector);
				$(document).bind('mousemove', current, moveSelector);
			},
			moveSelector = function (ev) {
				change.apply(
					ev.data.cal.data('colorpicker')
						.fields
						.eq(6)
						.val(parseInt(100*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.pos.top))))/150, 10))
						.end()
						.eq(5)
						.val(parseInt(100*(Math.max(0,Math.min(150,(ev.pageX - ev.data.pos.left))))/150, 10))
						.get(0),
					[ev.data.preview]
				);
				return false;
			},
			upSelector = function (ev) {
				fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upSelector);
				$(document).unbind('mousemove', moveSelector);
				return false;
			},
			enterSubmit = function (ev) {
				$(this).addClass('colorpicker_focus');
			},
			leaveSubmit = function (ev) {
				$(this).removeClass('colorpicker_focus');
			},
			clickSubmit = function (ev) {
				var cal = $(this).parent();
				var col = cal.data('colorpicker').color;
				cal.data('colorpicker').origColor = col;
				setCurrentColor(col, cal.get(0));
				cal.data('colorpicker').onSubmit(col, HSBToHex(col), HSBToRGB(col), cal.data('colorpicker').el);
			},
			show = function (ev) {
				var cal = $('#' + $(this).data('colorpickerId'));
				cal.data('colorpicker').onBeforeShow.apply(this, [cal.get(0)]);
				var pos = $(this).offset();
				var viewPort = getViewport();
				var top = pos.top + this.offsetHeight;
				var left = pos.left;
				if (top + 176 > viewPort.t + viewPort.h) {
					top -= this.offsetHeight + 176;
				}
				if (left + 356 > viewPort.l + viewPort.w) {
					left -= 356;
				}
				cal.css({left: left + 'px', top: top + 'px'});
				if (cal.data('colorpicker').onShow.apply(this, [cal.get(0)]) != false) {
					cal.show();
				}
				$(document).bind('mousedown', {cal: cal}, hide);
				return false;
			},
			hide = function (ev) {
				if (!isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
					if (ev.data.cal.data('colorpicker').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
						ev.data.cal.hide();
					}
					$(document).unbind('mousedown', hide);
				}
			},
			isChildOf = function(parentEl, el, container) {
				if (parentEl == el) {
					return true;
				}
				if (parentEl.contains) {
					return parentEl.contains(el);
				}
				if ( parentEl.compareDocumentPosition ) {
					return !!(parentEl.compareDocumentPosition(el) & 16);
				}
				var prEl = el.parentNode;
				while(prEl && prEl != container) {
					if (prEl == parentEl)
						return true;
					prEl = prEl.parentNode;
				}
				return false;
			},
			getViewport = function () {
				var m = document.compatMode == 'CSS1Compat';
				return {
					l : window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
					t : window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
					w : window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
					h : window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
				};
			},
			fixHSB = function (hsb) {
				return {
					h: Math.min(360, Math.max(0, hsb.h)),
					s: Math.min(100, Math.max(0, hsb.s)),
					b: Math.min(100, Math.max(0, hsb.b))
				};
			}, 
			fixRGB = function (rgb) {
				return {
					r: Math.min(255, Math.max(0, rgb.r)),
					g: Math.min(255, Math.max(0, rgb.g)),
					b: Math.min(255, Math.max(0, rgb.b))
				};
			},
			fixHex = function (hex) {
				var len = 6 - hex.length;
				if (len > 0) {
					var o = [];
					for (var i=0; i<len; i++) {
						o.push('0');
					}
					o.push(hex);
					hex = o.join('');
				}
				return hex;
			}, 
			HexToRGB = function (hex) {
				var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
				return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
			},
			HexToHSB = function (hex) {
				return RGBToHSB(HexToRGB(hex));
			},
			RGBToHSB = function (rgb) {
				var hsb = {
					h: 0,
					s: 0,
					b: 0
				};
				var min = Math.min(rgb.r, rgb.g, rgb.b);
				var max = Math.max(rgb.r, rgb.g, rgb.b);
				var delta = max - min;
				hsb.b = max;
				if (max != 0) {
					
				}
				hsb.s = max != 0 ? 255 * delta / max : 0;
				if (hsb.s != 0) {
					if (rgb.r == max) {
						hsb.h = (rgb.g - rgb.b) / delta;
					} else if (rgb.g == max) {
						hsb.h = 2 + (rgb.b - rgb.r) / delta;
					} else {
						hsb.h = 4 + (rgb.r - rgb.g) / delta;
					}
				} else {
					hsb.h = -1;
				}
				hsb.h *= 60;
				if (hsb.h < 0) {
					hsb.h += 360;
				}
				hsb.s *= 100/255;
				hsb.b *= 100/255;
				return hsb;
			},
			HSBToRGB = function (hsb) {
				var rgb = {};
				var h = Math.round(hsb.h);
				var s = Math.round(hsb.s*255/100);
				var v = Math.round(hsb.b*255/100);
				if(s == 0) {
					rgb.r = rgb.g = rgb.b = v;
				} else {
					var t1 = v;
					var t2 = (255-s)*v/255;
					var t3 = (t1-t2)*(h%60)/60;
					if(h==360) h = 0;
					if(h<60) {rgb.r=t1;	rgb.b=t2; rgb.g=t2+t3}
					else if(h<120) {rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3}
					else if(h<180) {rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3}
					else if(h<240) {rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3}
					else if(h<300) {rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3}
					else if(h<360) {rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3}
					else {rgb.r=0; rgb.g=0;	rgb.b=0}
				}
				return {r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b)};
			},
			RGBToHex = function (rgb) {
				var hex = [
					rgb.r.toString(16),
					rgb.g.toString(16),
					rgb.b.toString(16)
				];
				$.each(hex, function (nr, val) {
					if (val.length == 1) {
						hex[nr] = '0' + val;
					}
				});
				return hex.join('');
			},
			HSBToHex = function (hsb) {
				return RGBToHex(HSBToRGB(hsb));
			},
			restoreOriginal = function () {
				var cal = $(this).parent();
				var col = cal.data('colorpicker').origColor;
				cal.data('colorpicker').color = col;
				fillRGBFields(col, cal.get(0));
				fillHexFields(col, cal.get(0));
				fillHSBFields(col, cal.get(0));
				setSelector(col, cal.get(0));
				setHue(col, cal.get(0));
				setNewColor(col, cal.get(0));
			};
		return {
			init: function (opt) {
				opt = $.extend({}, defaults, opt||{});
				if (typeof opt.color == 'string') {
					opt.color = HexToHSB(opt.color);
				} else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
					opt.color = RGBToHSB(opt.color);
				} else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
					opt.color = fixHSB(opt.color);
				} else {
					return this;
				}
				return this.each(function () {
					if (!$(this).data('colorpickerId')) {
						var options = $.extend({}, opt);
						options.origColor = opt.color;
						var id = 'collorpicker_' + parseInt(Math.random() * 1000);
						$(this).data('colorpickerId', id);
						var cal = $(tpl).attr('id', id);
						if (options.flat) {
							cal.appendTo(this).show();
						} else {
							cal.appendTo(document.body);
						}
						options.fields = cal
											.find('input')
												.bind('keyup', keyDown)
												.bind('change', change)
												.bind('blur', blur)
												.bind('focus', focus);
						cal
							.find('span').bind('mousedown', downIncrement).end()
							.find('>div.colorpicker_current_color').bind('click', restoreOriginal);
						options.selector = cal.find('div.colorpicker_color').bind('mousedown', downSelector);
						options.selectorIndic = options.selector.find('div div');
						options.el = this;
						options.hue = cal.find('div.colorpicker_hue div');
						cal.find('div.colorpicker_hue').bind('mousedown', downHue);
						options.newColor = cal.find('div.colorpicker_new_color');
						options.currentColor = cal.find('div.colorpicker_current_color');
						cal.data('colorpicker', options);
						cal.find('div.colorpicker_submit')
							.bind('mouseenter', enterSubmit)
							.bind('mouseleave', leaveSubmit)
							.bind('click', clickSubmit);
						fillRGBFields(options.color, cal.get(0));
						fillHSBFields(options.color, cal.get(0));
						fillHexFields(options.color, cal.get(0));
						setHue(options.color, cal.get(0));
						setSelector(options.color, cal.get(0));
						setCurrentColor(options.color, cal.get(0));
						setNewColor(options.color, cal.get(0));
						if (options.flat) {
							cal.css({
								position: 'relative',
								display: 'block'
							});
						} else {
							$(this).bind(options.eventName, show);
						}
					}
				});
			},
			showPicker: function() {
				return this.each( function () {
					if ($(this).data('colorpickerId')) {
						show.apply(this);
					}
				});
			},
			hidePicker: function() {
				return this.each( function () {
					if ($(this).data('colorpickerId')) {
						$('#' + $(this).data('colorpickerId')).hide();
					}
				});
			},
			setColor: function(col) {
				if (typeof col == 'string') {
					col = HexToHSB(col);
				} else if (col.r != undefined && col.g != undefined && col.b != undefined) {
					col = RGBToHSB(col);
				} else if (col.h != undefined && col.s != undefined && col.b != undefined) {
					col = fixHSB(col);
				} else {
					return this;
				}
				return this.each(function(){
					if ($(this).data('colorpickerId')) {
						var cal = $('#' + $(this).data('colorpickerId'));
						cal.data('colorpicker').color = col;
						cal.data('colorpicker').origColor = col;
						fillRGBFields(col, cal.get(0));
						fillHSBFields(col, cal.get(0));
						fillHexFields(col, cal.get(0));
						setHue(col, cal.get(0));
						setSelector(col, cal.get(0));
						setCurrentColor(col, cal.get(0));
						setNewColor(col, cal.get(0));
					}
				});
			}
		};
	}();
	$.fn.extend({
		ColorPicker: ColorPicker.init,
		ColorPickerHide: ColorPicker.hidePicker,
		ColorPickerShow: ColorPicker.showPicker,
		ColorPickerSetColor: ColorPicker.setColor
	});
})(jQuery);








/* Easing 1.3 */
jQuery.easing.jswing=jQuery.easing.swing;
jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,a,c,b,d){return jQuery.easing[jQuery.easing.def](e,a,c,b,d)},easeInQuad:function(e,a,c,b,d){return b*(a/=d)*a+c},easeOutQuad:function(e,a,c,b,d){return-b*(a/=d)*(a-2)+c},easeInOutQuad:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a+c;return-b/2*(--a*(a-2)-1)+c},easeInCubic:function(e,a,c,b,d){return b*(a/=d)*a*a+c},easeOutCubic:function(e,a,c,b,d){return b*((a=a/d-1)*a*a+1)+c},easeInOutCubic:function(e,a,c,b,d){if((a/=d/2)<1)return b/
2*a*a*a+c;return b/2*((a-=2)*a*a+2)+c},easeInQuart:function(e,a,c,b,d){return b*(a/=d)*a*a*a+c},easeOutQuart:function(e,a,c,b,d){return-b*((a=a/d-1)*a*a*a-1)+c},easeInOutQuart:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a+c;return-b/2*((a-=2)*a*a*a-2)+c},easeInQuint:function(e,a,c,b,d){return b*(a/=d)*a*a*a*a+c},easeOutQuint:function(e,a,c,b,d){return b*((a=a/d-1)*a*a*a*a+1)+c},easeInOutQuint:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a*a+c;return b/2*((a-=2)*a*a*a*a+2)+c},easeInSine:function(e,
a,c,b,d){return-b*Math.cos(a/d*(Math.PI/2))+b+c},easeOutSine:function(e,a,c,b,d){return b*Math.sin(a/d*(Math.PI/2))+c},easeInOutSine:function(e,a,c,b,d){return-b/2*(Math.cos(Math.PI*a/d)-1)+c},easeInExpo:function(e,a,c,b,d){return a==0?c:b*Math.pow(2,10*(a/d-1))+c},easeOutExpo:function(e,a,c,b,d){return a==d?c+b:b*(-Math.pow(2,-10*a/d)+1)+c},easeInOutExpo:function(e,a,c,b,d){if(a==0)return c;if(a==d)return c+b;if((a/=d/2)<1)return b/2*Math.pow(2,10*(a-1))+c;return b/2*(-Math.pow(2,-10*--a)+2)+c},
easeInCirc:function(e,a,c,b,d){return-b*(Math.sqrt(1-(a/=d)*a)-1)+c},easeOutCirc:function(e,a,c,b,d){return b*Math.sqrt(1-(a=a/d-1)*a)+c},easeInOutCirc:function(e,a,c,b,d){if((a/=d/2)<1)return-b/2*(Math.sqrt(1-a*a)-1)+c;return b/2*(Math.sqrt(1-(a-=2)*a)+1)+c},easeInElastic:function(e,a,c,b,d){var e=1.70158,f=0,g=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return-(g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f))+c},easeOutElastic:function(e,
a,c,b,d){var e=1.70158,f=0,g=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return g*Math.pow(2,-10*a)*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInOutElastic:function(e,a,c,b,d){var e=1.70158,f=0,g=b;if(a==0)return c;if((a/=d/2)==2)return c+b;f||(f=d*0.3*1.5);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);if(a<1)return-0.5*g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+c;return g*Math.pow(2,-10*(a-=1))*Math.sin((a*d-e)*
2*Math.PI/f)*0.5+b+c},easeInBack:function(e,a,c,b,d,f){f==void 0&&(f=1.70158);return b*(a/=d)*a*((f+1)*a-f)+c},easeOutBack:function(e,a,c,b,d,f){f==void 0&&(f=1.70158);return b*((a=a/d-1)*a*((f+1)*a+f)+1)+c},easeInOutBack:function(e,a,c,b,d,f){f==void 0&&(f=1.70158);if((a/=d/2)<1)return b/2*a*a*(((f*=1.525)+1)*a-f)+c;return b/2*((a-=2)*a*(((f*=1.525)+1)*a+f)+2)+c},easeInBounce:function(e,a,c,b,d){return b-jQuery.easing.easeOutBounce(e,d-a,0,b,d)+c},easeOutBounce:function(e,a,c,b,d){return(a/=d)<1/
2.75?b*7.5625*a*a+c:a<2/2.75?b*(7.5625*(a-=1.5/2.75)*a+0.75)+c:a<2.5/2.75?b*(7.5625*(a-=2.25/2.75)*a+0.9375)+c:b*(7.5625*(a-=2.625/2.75)*a+0.984375)+c},easeInOutBounce:function(e,a,c,b,d){if(a<d/2)return jQuery.easing.easeInBounce(e,a*2,0,b,d)*0.5+c;return jQuery.easing.easeOutBounce(e,a*2-d,0,b,d)*0.5+b*0.5+c}});

/* Cufon 1.09i */
var Cufon=(function(){var m=function(){return m.replace.apply(null,arguments)};var x=m.DOM={ready:(function(){var C=false,E={loaded:1,complete:1};var B=[],D=function(){if(C){return}C=true;for(var F;F=B.shift();F()){}};if(document.addEventListener){document.addEventListener("DOMContentLoaded",D,false);window.addEventListener("pageshow",D,false)}if(!window.opera&&document.readyState){(function(){E[document.readyState]?D():setTimeout(arguments.callee,10)})()}if(document.readyState&&document.createStyleSheet){(function(){try{document.body.doScroll("left");D()}catch(F){setTimeout(arguments.callee,1)}})()}q(window,"load",D);return function(F){if(!arguments.length){D()}else{C?F():B.push(F)}}})(),root:function(){return document.documentElement||document.body}};var n=m.CSS={Size:function(C,B){this.value=parseFloat(C);this.unit=String(C).match(/[a-z%]*$/)[0]||"px";this.convert=function(D){return D/B*this.value};this.convertFrom=function(D){return D/this.value*B};this.toString=function(){return this.value+this.unit}},addClass:function(C,B){var D=C.className;C.className=D+(D&&" ")+B;return C},color:j(function(C){var B={};B.color=C.replace(/^rgba\((.*?),\s*([\d.]+)\)/,function(E,D,F){B.opacity=parseFloat(F);return"rgb("+D+")"});return B}),fontStretch:j(function(B){if(typeof B=="number"){return B}if(/%$/.test(B)){return parseFloat(B)/100}return{"ultra-condensed":0.5,"extra-condensed":0.625,condensed:0.75,"semi-condensed":0.875,"semi-expanded":1.125,expanded:1.25,"extra-expanded":1.5,"ultra-expanded":2}[B]||1}),getStyle:function(C){var B=document.defaultView;if(B&&B.getComputedStyle){return new a(B.getComputedStyle(C,null))}if(C.currentStyle){return new a(C.currentStyle)}return new a(C.style)},gradient:j(function(F){var G={id:F,type:F.match(/^-([a-z]+)-gradient\(/)[1],stops:[]},C=F.substr(F.indexOf("(")).match(/([\d.]+=)?(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)/ig);for(var E=0,B=C.length,D;E<B;++E){D=C[E].split("=",2).reverse();G.stops.push([D[1]||E/(B-1),D[0]])}return G}),quotedList:j(function(E){var D=[],C=/\s*((["'])([\s\S]*?[^\\])\2|[^,]+)\s*/g,B;while(B=C.exec(E)){D.push(B[3]||B[1])}return D}),recognizesMedia:j(function(G){var E=document.createElement("style"),D,C,B;E.type="text/css";E.media=G;try{E.appendChild(document.createTextNode("/**/"))}catch(F){}C=g("head")[0];C.insertBefore(E,C.firstChild);D=(E.sheet||E.styleSheet);B=D&&!D.disabled;C.removeChild(E);return B}),removeClass:function(D,C){var B=RegExp("(?:^|\\s+)"+C+"(?=\\s|$)","g");D.className=D.className.replace(B,"");return D},supports:function(D,C){var B=document.createElement("span").style;if(B[D]===undefined){return false}B[D]=C;return B[D]===C},textAlign:function(E,D,B,C){if(D.get("textAlign")=="right"){if(B>0){E=" "+E}}else{if(B<C-1){E+=" "}}return E},textShadow:j(function(F){if(F=="none"){return null}var E=[],G={},B,C=0;var D=/(#[a-f0-9]+|[a-z]+\(.*?\)|[a-z]+)|(-?[\d.]+[a-z%]*)|,/ig;while(B=D.exec(F)){if(B[0]==","){E.push(G);G={};C=0}else{if(B[1]){G.color=B[1]}else{G[["offX","offY","blur"][C++]]=B[2]}}}E.push(G);return E}),textTransform:(function(){var B={uppercase:function(C){return C.toUpperCase()},lowercase:function(C){return C.toLowerCase()},capitalize:function(C){return C.replace(/\b./g,function(D){return D.toUpperCase()})}};return function(E,D){var C=B[D.get("textTransform")];return C?C(E):E}})(),whiteSpace:(function(){var D={inline:1,"inline-block":1,"run-in":1};var C=/^\s+/,B=/\s+$/;return function(H,F,G,E){if(E){if(E.nodeName.toLowerCase()=="br"){H=H.replace(C,"")}}if(D[F.get("display")]){return H}if(!G.previousSibling){H=H.replace(C,"")}if(!G.nextSibling){H=H.replace(B,"")}return H}})()};n.ready=(function(){var B=!n.recognizesMedia("all"),E=false;var D=[],H=function(){B=true;for(var K;K=D.shift();K()){}};var I=g("link"),J=g("style");function C(K){return K.disabled||G(K.sheet,K.media||"screen")}function G(M,P){if(!n.recognizesMedia(P||"all")){return true}if(!M||M.disabled){return false}try{var Q=M.cssRules,O;if(Q){search:for(var L=0,K=Q.length;O=Q[L],L<K;++L){switch(O.type){case 2:break;case 3:if(!G(O.styleSheet,O.media.mediaText)){return false}break;default:break search}}}}catch(N){}return true}function F(){if(document.createStyleSheet){return true}var L,K;for(K=0;L=I[K];++K){if(L.rel.toLowerCase()=="stylesheet"&&!C(L)){return false}}for(K=0;L=J[K];++K){if(!C(L)){return false}}return true}x.ready(function(){if(!E){E=n.getStyle(document.body).isUsable()}if(B||(E&&F())){H()}else{setTimeout(arguments.callee,10)}});return function(K){if(B){K()}else{D.push(K)}}})();function s(D){var C=this.face=D.face,B={"\u0020":1,"\u00a0":1,"\u3000":1};this.glyphs=D.glyphs;this.w=D.w;this.baseSize=parseInt(C["units-per-em"],10);this.family=C["font-family"].toLowerCase();this.weight=C["font-weight"];this.style=C["font-style"]||"normal";this.viewBox=(function(){var F=C.bbox.split(/\s+/);var E={minX:parseInt(F[0],10),minY:parseInt(F[1],10),maxX:parseInt(F[2],10),maxY:parseInt(F[3],10)};E.width=E.maxX-E.minX;E.height=E.maxY-E.minY;E.toString=function(){return[this.minX,this.minY,this.width,this.height].join(" ")};return E})();this.ascent=-parseInt(C.ascent,10);this.descent=-parseInt(C.descent,10);this.height=-this.ascent+this.descent;this.spacing=function(L,N,E){var O=this.glyphs,M,K,G,P=[],F=0,J=-1,I=-1,H;while(H=L[++J]){M=O[H]||this.missingGlyph;if(!M){continue}if(K){F-=G=K[H]||0;P[I]-=G}F+=P[++I]=~~(M.w||this.w)+N+(B[H]?E:0);K=M.k}P.total=F;return P}}function f(){var C={},B={oblique:"italic",italic:"oblique"};this.add=function(D){(C[D.style]||(C[D.style]={}))[D.weight]=D};this.get=function(H,I){var G=C[H]||C[B[H]]||C.normal||C.italic||C.oblique;if(!G){return null}I={normal:400,bold:700}[I]||parseInt(I,10);if(G[I]){return G[I]}var E={1:1,99:0}[I%100],K=[],F,D;if(E===undefined){E=I>400}if(I==500){I=400}for(var J in G){if(!k(G,J)){continue}J=parseInt(J,10);if(!F||J<F){F=J}if(!D||J>D){D=J}K.push(J)}if(I<F){I=F}if(I>D){I=D}K.sort(function(M,L){return(E?(M>=I&&L>=I)?M<L:M>L:(M<=I&&L<=I)?M>L:M<L)?-1:1});return G[K[0]]}}function r(){function D(F,G){if(F.contains){return F.contains(G)}return F.compareDocumentPosition(G)&16}function B(G){var F=G.relatedTarget;if(!F||D(this,F)){return}C(this,G.type=="mouseover")}function E(F){C(this,F.type=="mouseenter")}function C(F,G){setTimeout(function(){var H=d.get(F).options;m.replace(F,G?h(H,H.hover):H,true)},10)}this.attach=function(F){if(F.onmouseenter===undefined){q(F,"mouseover",B);q(F,"mouseout",B)}else{q(F,"mouseenter",E);q(F,"mouseleave",E)}}}function u(){var C=[],D={};function B(H){var E=[],G;for(var F=0;G=H[F];++F){E[F]=C[D[G]]}return E}this.add=function(F,E){D[F]=C.push(E)-1};this.repeat=function(){var E=arguments.length?B(arguments):C,F;for(var G=0;F=E[G++];){m.replace(F[0],F[1],true)}}}function A(){var D={},B=0;function C(E){return E.cufid||(E.cufid=++B)}this.get=function(E){var F=C(E);return D[F]||(D[F]={})}}function a(B){var D={},C={};this.extend=function(E){for(var F in E){if(k(E,F)){D[F]=E[F]}}return this};this.get=function(E){return D[E]!=undefined?D[E]:B[E]};this.getSize=function(F,E){return C[F]||(C[F]=new n.Size(this.get(F),E))};this.isUsable=function(){return !!B}}function q(C,B,D){if(C.addEventListener){C.addEventListener(B,D,false)}else{if(C.attachEvent){C.attachEvent("on"+B,function(){return D.call(C,window.event)})}}}function v(C,B){var D=d.get(C);if(D.options){return C}if(B.hover&&B.hoverables[C.nodeName.toLowerCase()]){b.attach(C)}D.options=B;return C}function j(B){var C={};return function(D){if(!k(C,D)){C[D]=B.apply(null,arguments)}return C[D]}}function c(F,E){var B=n.quotedList(E.get("fontFamily").toLowerCase()),D;for(var C=0;D=B[C];++C){if(i[D]){return i[D].get(E.get("fontStyle"),E.get("fontWeight"))}}return null}function g(B){return document.getElementsByTagName(B)}function k(C,B){return C.hasOwnProperty(B)}function h(){var C={},B,F;for(var E=0,D=arguments.length;B=arguments[E],E<D;++E){for(F in B){if(k(B,F)){C[F]=B[F]}}}return C}function o(E,M,C,N,F,D){var K=document.createDocumentFragment(),H;if(M===""){return K}var L=N.separate;var I=M.split(p[L]),B=(L=="words");if(B&&t){if(/^\s/.test(M)){I.unshift("")}if(/\s$/.test(M)){I.push("")}}for(var J=0,G=I.length;J<G;++J){H=z[N.engine](E,B?n.textAlign(I[J],C,J,G):I[J],C,N,F,D,J<G-1);if(H){K.appendChild(H)}}return K}function l(D,M){var C=D.nodeName.toLowerCase();if(M.ignore[C]){return}var E=!M.textless[C];var B=n.getStyle(v(D,M)).extend(M);var F=c(D,B),G,K,I,H,L,J;if(!F){return}for(G=D.firstChild;G;G=I){K=G.nodeType;I=G.nextSibling;if(E&&K==3){if(H){H.appendData(G.data);D.removeChild(G)}else{H=G}if(I){continue}}if(H){D.replaceChild(o(F,n.whiteSpace(H.data,B,H,J),B,M,G,D),H);H=null}if(K==1){if(G.firstChild){if(G.nodeName.toLowerCase()=="cufon"){z[M.engine](F,null,B,M,G,D)}else{arguments.callee(G,M)}}J=G}}}var t=" ".split(/\s+/).length==0;var d=new A();var b=new r();var y=new u();var e=false;var z={},i={},w={autoDetect:false,engine:null,forceHitArea:false,hover:false,hoverables:{a:true},ignore:{applet:1,canvas:1,col:1,colgroup:1,head:1,iframe:1,map:1,optgroup:1,option:1,script:1,select:1,style:1,textarea:1,title:1,pre:1},printable:true,selector:(window.Sizzle||(window.jQuery&&function(B){return jQuery(B)})||(window.dojo&&dojo.query)||(window.Ext&&Ext.query)||(window.YAHOO&&YAHOO.util&&YAHOO.util.Selector&&YAHOO.util.Selector.query)||(window.$$&&function(B){return $$(B)})||(window.$&&function(B){return $(B)})||(document.querySelectorAll&&function(B){return document.querySelectorAll(B)})||g),separate:"words",textless:{dl:1,html:1,ol:1,table:1,tbody:1,thead:1,tfoot:1,tr:1,ul:1},textShadow:"none"};var p={words:/\s/.test("\u00a0")?/[^\S\u00a0]+/:/\s+/,characters:"",none:/^/};m.now=function(){x.ready();return m};m.refresh=function(){y.repeat.apply(y,arguments);return m};m.registerEngine=function(C,B){if(!B){return m}z[C]=B;return m.set("engine",C)};m.registerFont=function(D){if(!D){return m}var B=new s(D),C=B.family;if(!i[C]){i[C]=new f()}i[C].add(B);return m.set("fontFamily",'"'+C+'"')};m.replace=function(D,C,B){C=h(w,C);if(!C.engine){return m}if(!e){n.addClass(x.root(),"cufon-active cufon-loading");n.ready(function(){n.addClass(n.removeClass(x.root(),"cufon-loading"),"cufon-ready")});e=true}if(C.hover){C.forceHitArea=true}if(C.autoDetect){delete C.fontFamily}if(typeof C.textShadow=="string"){C.textShadow=n.textShadow(C.textShadow)}if(typeof C.color=="string"&&/^-/.test(C.color)){C.textGradient=n.gradient(C.color)}else{delete C.textGradient}if(!B){y.add(D,arguments)}if(D.nodeType||typeof D=="string"){D=[D]}n.ready(function(){for(var F=0,E=D.length;F<E;++F){var G=D[F];if(typeof G=="string"){m.replace(C.selector(G),C,true)}else{l(G,C)}}});return m};m.set=function(B,C){w[B]=C;return m};return m})();Cufon.registerEngine("vml",(function(){var e=document.namespaces;if(!e){return}e.add("cvml","urn:schemas-microsoft-com:vml");e=null;var b=document.createElement("cvml:shape");b.style.behavior="url(#default#VML)";if(!b.coordsize){return}b=null;var h=(document.documentMode||0)<8;document.write(('<style type="text/css">cufoncanvas{text-indent:0;}@media screen{cvml\\:shape,cvml\\:rect,cvml\\:fill,cvml\\:shadow{behavior:url(#default#VML);display:block;antialias:true;position:absolute;}cufoncanvas{position:absolute;text-align:left;}cufon{display:inline-block;position:relative;vertical-align:'+(h?"middle":"text-bottom")+";}cufon cufontext{position:absolute;left:-10000in;font-size:1px;}a cufon{cursor:pointer}}@media print{cufon cufoncanvas{display:none;}}</style>").replace(/;/g,"!important;"));function c(i,j){return a(i,/(?:em|ex|%)$|^[a-z-]+$/i.test(j)?"1em":j)}function a(l,m){if(m==="0"){return 0}if(/px$/i.test(m)){return parseFloat(m)}var k=l.style.left,j=l.runtimeStyle.left;l.runtimeStyle.left=l.currentStyle.left;l.style.left=m.replace("%","em");var i=l.style.pixelLeft;l.style.left=k;l.runtimeStyle.left=j;return i}function f(l,k,j,n){var i="computed"+n,m=k[i];if(isNaN(m)){m=k.get(n);k[i]=m=(m=="normal")?0:~~j.convertFrom(a(l,m))}return m}var g={};function d(p){var q=p.id;if(!g[q]){var n=p.stops,o=document.createElement("cvml:fill"),i=[];o.type="gradient";o.angle=180;o.focus="0";o.method="sigma";o.color=n[0][1];for(var m=1,l=n.length-1;m<l;++m){i.push(n[m][0]*100+"% "+n[m][1])}o.colors=i.join(",");o.color2=n[l][1];g[q]=o}return g[q]}return function(ac,G,Y,C,K,ad,W){var n=(G===null);if(n){G=K.alt}var I=ac.viewBox;var p=Y.computedFontSize||(Y.computedFontSize=new Cufon.CSS.Size(c(ad,Y.get("fontSize"))+"px",ac.baseSize));var y,q;if(n){y=K;q=K.firstChild}else{y=document.createElement("cufon");y.className="cufon cufon-vml";y.alt=G;q=document.createElement("cufoncanvas");y.appendChild(q);if(C.printable){var Z=document.createElement("cufontext");Z.appendChild(document.createTextNode(G));y.appendChild(Z)}if(!W){y.appendChild(document.createElement("cvml:shape"))}}var ai=y.style;var R=q.style;var l=p.convert(I.height),af=Math.ceil(l);var V=af/l;var P=V*Cufon.CSS.fontStretch(Y.get("fontStretch"));var U=I.minX,T=I.minY;R.height=af;R.top=Math.round(p.convert(T-ac.ascent));R.left=Math.round(p.convert(U));ai.height=p.convert(ac.height)+"px";var F=Y.get("color");var ag=Cufon.CSS.textTransform(G,Y).split("");var L=ac.spacing(ag,f(ad,Y,p,"letterSpacing"),f(ad,Y,p,"wordSpacing"));if(!L.length){return null}var k=L.total;var x=-U+k+(I.width-L[L.length-1]);var ah=p.convert(x*P),X=Math.round(ah);var O=x+","+I.height,m;var J="r"+O+"ns";var u=C.textGradient&&d(C.textGradient);var o=ac.glyphs,S=0;var H=C.textShadow;var ab=-1,aa=0,w;while(w=ag[++ab]){var D=o[ag[ab]]||ac.missingGlyph,v;if(!D){continue}if(n){v=q.childNodes[aa];while(v.firstChild){v.removeChild(v.firstChild)}}else{v=document.createElement("cvml:shape");q.appendChild(v)}v.stroked="f";v.coordsize=O;v.coordorigin=m=(U-S)+","+T;v.path=(D.d?"m"+D.d+"xe":"")+"m"+m+J;v.fillcolor=F;if(u){v.appendChild(u.cloneNode(false))}var ae=v.style;ae.width=X;ae.height=af;if(H){var s=H[0],r=H[1];var B=Cufon.CSS.color(s.color),z;var N=document.createElement("cvml:shadow");N.on="t";N.color=B.color;N.offset=s.offX+","+s.offY;if(r){z=Cufon.CSS.color(r.color);N.type="double";N.color2=z.color;N.offset2=r.offX+","+r.offY}N.opacity=B.opacity||(z&&z.opacity)||1;v.appendChild(N)}S+=L[aa++]}var M=v.nextSibling,t,A;if(C.forceHitArea){if(!M){M=document.createElement("cvml:rect");M.stroked="f";M.className="cufon-vml-cover";t=document.createElement("cvml:fill");t.opacity=0;M.appendChild(t);q.appendChild(M)}A=M.style;A.width=X;A.height=af}else{if(M){q.removeChild(M)}}ai.width=Math.max(Math.ceil(p.convert(k*P)),0);if(h){var Q=Y.computedYAdjust;if(Q===undefined){var E=Y.get("lineHeight");if(E=="normal"){E="1em"}else{if(!isNaN(E)){E+="em"}}Y.computedYAdjust=Q=0.5*(a(ad,E)-parseFloat(ai.height))}if(Q){ai.marginTop=Math.ceil(Q)+"px";ai.marginBottom=Q+"px"}}return y}})());Cufon.registerEngine("canvas",(function(){var b=document.createElement("canvas");if(!b||!b.getContext||!b.getContext.apply){return}b=null;var a=Cufon.CSS.supports("display","inline-block");var e=!a&&(document.compatMode=="BackCompat"||/frameset|transitional/i.test(document.doctype.publicId));var f=document.createElement("style");f.type="text/css";f.appendChild(document.createTextNode(("cufon{text-indent:0;}@media screen,projection{cufon{display:inline;display:inline-block;position:relative;vertical-align:middle;"+(e?"":"font-size:1px;line-height:1px;")+"}cufon cufontext{display:-moz-inline-box;display:inline-block;width:0;height:0;overflow:hidden;text-indent:-10000in;}"+(a?"cufon canvas{position:relative;}":"cufon canvas{position:absolute;}")+"}@media print{cufon{padding:0;}cufon canvas{display:none;}}").replace(/;/g,"!important;")));document.getElementsByTagName("head")[0].appendChild(f);function d(p,h){var n=0,m=0;var g=[],o=/([mrvxe])([^a-z]*)/g,k;generate:for(var j=0;k=o.exec(p);++j){var l=k[2].split(",");switch(k[1]){case"v":g[j]={m:"bezierCurveTo",a:[n+~~l[0],m+~~l[1],n+~~l[2],m+~~l[3],n+=~~l[4],m+=~~l[5]]};break;case"r":g[j]={m:"lineTo",a:[n+=~~l[0],m+=~~l[1]]};break;case"m":g[j]={m:"moveTo",a:[n=~~l[0],m=~~l[1]]};break;case"x":g[j]={m:"closePath"};break;case"e":break generate}h[g[j].m].apply(h,g[j].a)}return g}function c(m,k){for(var j=0,h=m.length;j<h;++j){var g=m[j];k[g.m].apply(k,g.a)}}return function(V,w,P,t,C,W){var k=(w===null);if(k){w=C.getAttribute("alt")}var A=V.viewBox;var m=P.getSize("fontSize",V.baseSize);var B=0,O=0,N=0,u=0;var z=t.textShadow,L=[];if(z){for(var U=z.length;U--;){var F=z[U];var K=m.convertFrom(parseFloat(F.offX));var I=m.convertFrom(parseFloat(F.offY));L[U]=[K,I];if(I<B){B=I}if(K>O){O=K}if(I>N){N=I}if(K<u){u=K}}}var Z=Cufon.CSS.textTransform(w,P).split("");var E=V.spacing(Z,~~m.convertFrom(parseFloat(P.get("letterSpacing"))||0),~~m.convertFrom(parseFloat(P.get("wordSpacing"))||0));if(!E.length){return null}var h=E.total;O+=A.width-E[E.length-1];u+=A.minX;var s,n;if(k){s=C;n=C.firstChild}else{s=document.createElement("cufon");s.className="cufon cufon-canvas";s.setAttribute("alt",w);n=document.createElement("canvas");s.appendChild(n);if(t.printable){var S=document.createElement("cufontext");S.appendChild(document.createTextNode(w));s.appendChild(S)}}var aa=s.style;var H=n.style;var j=m.convert(A.height);var Y=Math.ceil(j);var M=Y/j;var G=M*Cufon.CSS.fontStretch(P.get("fontStretch"));var J=h*G;var Q=Math.ceil(m.convert(J+O-u));var o=Math.ceil(m.convert(A.height-B+N));n.width=Q;n.height=o;H.width=Q+"px";H.height=o+"px";B+=A.minY;H.top=Math.round(m.convert(B-V.ascent))+"px";H.left=Math.round(m.convert(u))+"px";var r=Math.max(Math.ceil(m.convert(J)),0)+"px";if(a){aa.width=r;aa.height=m.convert(V.height)+"px"}else{aa.paddingLeft=r;aa.paddingBottom=(m.convert(V.height)-1)+"px"}var X=n.getContext("2d"),D=j/A.height;X.scale(D,D*M);X.translate(-u,-B);X.save();function T(){var x=V.glyphs,ab,l=-1,g=-1,y;X.scale(G,1);while(y=Z[++l]){var ab=x[Z[l]]||V.missingGlyph;if(!ab){continue}if(ab.d){X.beginPath();if(ab.code){c(ab.code,X)}else{ab.code=d("m"+ab.d,X)}X.fill()}X.translate(E[++g],0)}X.restore()}if(z){for(var U=z.length;U--;){var F=z[U];X.save();X.fillStyle=F.color;X.translate.apply(X,L[U]);T()}}var q=t.textGradient;if(q){var v=q.stops,p=X.createLinearGradient(0,A.minY,0,A.maxY);for(var U=0,R=v.length;U<R;++U){p.addColorStop.apply(p,v[U])}X.fillStyle=p}else{X.fillStyle=P.get("color")}T();return s}})());

/* Helios Light */
Cufon.registerFont({"w":556,"face":{"font-family":"Helios Light","font-weight":400,"font-stretch":"normal","units-per-em":"1000","panose-1":"2 0 5 3 4 0 0 2 0 4","ascent":"800","descent":"-200","x-height":"14","bbox":"-46 -929 1025.01 212.03","underline-thickness":"58","underline-position":"-32","unicode-range":"U+0020-U+2122"},"glyphs":{" ":{"w":278},"\u00a0":{"w":278},"#":{"d":"504,-228r-111,0r-32,228r-59,0r31,-228r-137,0r-34,228r-59,0r34,-228r-110,0r0,-59r119,0r21,-140r-112,0r0,-59r120,0r32,-212r60,0r-32,212r136,0r31,-212r59,0r-31,212r100,0r0,59r-108,0r-20,140r102,0r0,59xm227,-427r-22,140r138,0r20,-140r-136,0"},"$":{"d":"255,-651v-118,-11,-179,144,-95,217v25,21,59,29,95,40r0,-257xm302,-35v131,11,204,-166,108,-247v-27,-23,-67,-31,-108,-40r0,287xm518,-169v-4,122,-96,181,-216,188r0,76r-47,0r0,-76v-129,-10,-219,-79,-215,-222r62,0v4,99,60,158,153,168r0,-297v-104,-26,-202,-61,-199,-191v2,-117,82,-177,199,-182r0,-61r47,0r0,61v118,3,187,63,195,176r-65,0v-3,-78,-52,-119,-130,-122r0,266v120,28,221,65,216,216"},"&":{"d":"109,-190v0,99,63,155,162,155v87,0,139,-46,183,-96r-205,-244v-71,36,-140,87,-140,185xm385,-576v0,-55,-35,-89,-92,-90v-67,-1,-114,54,-88,121v16,38,42,70,67,100v59,-36,113,-60,113,-131xm488,-186v24,-38,29,-84,30,-140r59,0v-4,73,-16,138,-50,188r117,138r-81,0r-70,-85v-57,67,-116,104,-227,104v-135,0,-225,-79,-225,-214v0,-123,85,-180,172,-223v-33,-42,-79,-90,-77,-161v2,-94,67,-141,162,-141v89,0,151,52,151,139v0,105,-74,137,-142,181","w":667},"'":{"d":"85,-720r52,0r0,226r-52,0r0,-226","w":222},"(":{"d":"55,-276v1,-210,79,-339,171,-463r51,0v-85,124,-154,275,-154,467v0,187,73,341,154,463r-51,0v-91,-128,-172,-252,-171,-467","w":333},")":{"d":"210,-275v0,-187,-73,-342,-154,-464r51,0v91,128,171,253,171,467v0,210,-81,338,-171,463r-51,0v85,-124,154,-274,154,-466","w":333},"*":{"d":"173,-603r0,-117r42,0r0,117r114,-42r15,44r-114,37r75,106r-39,24r-74,-108r-78,106r-35,-27r77,-101r-112,-40r18,-42","w":389},"+":{"d":"300,-500r60,0r0,220r220,0r0,60r-220,0r0,220r-60,0r0,-220r-220,0r0,-60r220,0r0,-220","w":660},",":{"d":"102,100v28,-14,38,-51,34,-100r-34,0r0,-88r73,0v-3,67,11,149,-21,188v-14,18,-31,30,-52,37r0,-37","w":278},"-":{"d":"293,-280r0,60r-253,0r0,-60r253,0","w":333},".":{"d":"102,0r0,-88r73,0r0,88r-73,0","w":278},"\/":{"d":"53,90r-56,0r235,-829r56,0","w":278},"0":{"d":"278,-40v153,0,174,-154,174,-307v0,-155,-22,-304,-176,-304v-151,0,-173,158,-173,311v0,157,22,300,175,300xm39,-347v0,-194,43,-358,239,-358v197,0,238,168,238,365v0,193,-44,354,-238,354v-197,0,-239,-164,-239,-361"},"1":{"d":"120,-566v112,-4,182,-35,195,-139r51,0r0,705r-64,0r0,-524r-182,0r0,-42"},"2":{"d":"290,-651v-100,0,-149,76,-153,177r-68,0v4,-145,84,-226,229,-231v161,-5,260,128,202,278v-64,166,-300,169,-375,327v-5,14,-8,29,-9,46r393,0r0,54r-461,0v-5,-167,111,-230,209,-298v78,-54,188,-80,188,-208v0,-94,-61,-145,-155,-145"},"3":{"d":"273,-651v-94,0,-147,58,-151,151r-64,0v5,-133,84,-205,228,-205v119,0,201,55,201,174v0,81,-38,131,-100,157v77,24,124,77,125,174v2,173,-158,244,-333,203v-96,-23,-135,-95,-145,-207r64,0v-2,107,71,166,175,164v102,-2,175,-59,175,-159v0,-119,-107,-139,-227,-141r0,-52v113,-1,202,-23,202,-135v0,-88,-63,-124,-150,-124"},"4":{"d":"422,-698r0,470r98,0r0,54r-98,0r0,174r-64,0r0,-174r-322,0r0,-55r328,-469r58,0xm99,-228r259,0r0,-374"},"5":{"d":"267,-399v-73,0,-119,27,-153,73r-53,-7r57,-365r350,0r0,54r-296,0r-44,237v44,-28,84,-48,155,-46v142,5,221,89,223,233v2,175,-138,265,-316,224v-90,-21,-147,-81,-155,-187r64,0v11,91,77,143,174,143v108,0,169,-71,169,-180v0,-110,-64,-179,-175,-179"},"6":{"d":"288,14v-230,0,-274,-238,-236,-468v22,-135,86,-251,245,-251v115,0,196,65,206,173r-66,0v-14,-68,-54,-119,-134,-119v-167,1,-185,164,-198,319v42,-56,85,-110,185,-110v141,0,224,87,224,227v0,142,-83,229,-226,229xm450,-217v0,-109,-51,-174,-162,-171v-103,2,-159,72,-159,175v0,102,54,173,160,173v110,0,161,-72,161,-177"},"7":{"d":"152,0v29,-260,151,-469,279,-634r-372,0r0,-64r449,0r0,60v-145,167,-257,371,-286,638r-70,0"},"8":{"d":"448,-198v0,-101,-69,-147,-169,-147v-104,0,-171,47,-171,151v0,101,72,154,175,154v99,0,165,-59,165,-158xm419,-538v0,-80,-55,-114,-143,-113v-85,1,-143,42,-143,127v0,87,64,125,150,125v89,0,136,-48,136,-139xm44,-194v0,-92,50,-159,123,-185v-55,-34,-103,-64,-98,-154v6,-110,87,-172,201,-172v120,0,213,51,213,172v0,83,-34,128,-96,158v71,25,125,85,125,175v0,148,-99,214,-248,214v-128,0,-220,-75,-220,-208"},"9":{"d":"515,-349v0,203,-67,363,-257,363v-121,0,-193,-58,-205,-169r65,0v14,72,54,115,137,115v162,0,187,-158,196,-313r-2,-2v-38,65,-95,110,-190,110v-141,0,-218,-87,-218,-227v0,-146,78,-233,227,-233v195,0,247,159,247,356xm426,-474v2,-101,-57,-177,-158,-177v-109,0,-163,73,-163,181v-1,106,58,173,163,171v103,-2,156,-72,158,-175"},":":{"d":"102,0r0,-88r73,0r0,88r-73,0xm102,-404r0,-88r73,0r0,88r-73,0","w":278},";":{"d":"102,100v28,-14,38,-51,34,-100r-34,0r0,-88r73,0v-3,67,11,149,-21,188v-14,18,-31,30,-52,37r0,-37xm102,-404r0,-88r73,0r0,88r-73,0","w":278},"<":{"d":"580,-58r0,64r-500,-235r0,-53r500,-223r0,64r-421,186","w":660},"=":{"d":"580,-318r-500,0r0,-60r500,0r0,60xm580,-124r-500,0r0,-60r500,0r0,60","w":660},">":{"d":"580,-229r-500,235r0,-64r421,-197r-421,-186r0,-64r500,223r0,53","w":660},"?":{"d":"263,-739v130,0,218,61,218,188v0,178,-213,166,-198,369r-58,0v-1,-83,14,-142,55,-186v52,-55,137,-93,137,-188v0,-87,-65,-129,-156,-129v-101,0,-150,67,-153,169r-61,0v4,-138,78,-223,216,-223xm219,0r0,-88r73,0r0,88r-73,0","w":500},"@":{"d":"419,-31v127,0,209,-60,265,-136r59,0v-61,106,-164,186,-324,186v-180,0,-293,-102,-350,-233v-38,-91,-37,-205,1,-296v66,-159,262,-279,480,-206v146,49,259,219,188,405v-34,90,-100,178,-211,178v-38,0,-77,-17,-86,-50v-26,27,-71,49,-119,50v-128,0,-165,-136,-121,-253v37,-100,102,-200,230,-200v51,0,95,27,112,66r15,-46r67,0r-113,355v3,47,63,26,89,5v76,-59,127,-211,76,-330v-52,-123,-232,-190,-387,-126v-140,58,-239,251,-166,433v45,112,143,198,295,198xm306,-442v-45,65,-87,246,31,246v88,0,126,-104,152,-180v25,-70,17,-151,-56,-151v-61,0,-99,45,-127,85","w":800},"A":{"d":"365,-720r276,720r-70,0r-83,-226r-328,0r-85,226r-70,0r283,-720r77,0xm183,-284r282,0r-141,-378","w":651,"k":{"y":52,"w":68,"v":68,"t":30,"q":22,"o":22,"g":22,"f":30,"e":22,"d":22,"c":22,"Y":90,"W":75,"V":90,"U":30,"T":75,"Q":30,"O":30,"G":30,"C":30}},"B":{"d":"542,-203v0,-183,-221,-133,-393,-141r0,286v176,-8,393,45,393,-145xm509,-539v0,-161,-206,-115,-360,-123r0,260v162,-4,360,33,360,-137xm610,-203v0,145,-91,203,-235,203r-294,0r0,-720r260,0v140,1,233,47,236,181v1,91,-47,137,-115,157v95,12,147,78,148,179","w":663,"k":{"Y":30}},"C":{"d":"53,-360v0,-238,104,-379,335,-379v163,0,255,85,279,228r-70,0v-26,-116,-94,-170,-227,-170v-179,0,-249,139,-249,319v0,184,67,323,255,323v135,0,200,-87,228,-198r71,0v-36,150,-125,256,-312,256v-221,0,-310,-158,-310,-379","w":727,"k":{"Y":37}},"D":{"d":"669,-361v0,229,-105,361,-342,361r-246,0r0,-720r246,0v242,-12,342,134,342,359xm596,-284v29,-228,-50,-395,-284,-378r-163,0r0,604r163,0v171,7,265,-76,284,-226","w":722,"k":{"Y":37}},"E":{"d":"560,-720r0,58r-411,0r0,251r371,0r0,58r-371,0r0,295r421,0r0,58r-489,0r0,-720r479,0","w":611},"F":{"d":"545,-720r0,58r-396,0r0,251r360,0r0,58r-360,0r0,353r-68,0r0,-720r464,0","w":563,"k":{"A":52}},"G":{"d":"53,-364v0,-226,106,-375,333,-375v170,0,270,84,301,228r-70,0v-26,-103,-102,-170,-226,-170v-199,0,-270,144,-270,344v0,133,59,228,151,274v94,48,233,16,286,-45v42,-48,72,-114,72,-206r-243,0r0,-58r308,0r0,372r-58,0r0,-123v-51,87,-130,145,-269,142v-218,-5,-315,-155,-315,-383","w":776},"H":{"d":"149,-411r426,0r0,-309r68,0r0,720r-68,0r0,-353r-426,0r0,353r-68,0r0,-720r68,0r0,309","w":724},"I":{"d":"149,0r-68,0r0,-720r68,0r0,720","w":230},"J":{"d":"224,-43v97,0,127,-58,127,-156r0,-521r68,0r0,523v-1,139,-62,216,-203,216v-148,0,-190,-101,-190,-247r68,0v-3,107,20,185,130,185","w":500},"K":{"d":"149,-357r357,-363r89,0r-284,287r334,433r-83,0r-300,-391r-113,113r0,278r-68,0r0,-720r68,0r0,363","w":663,"k":{"q":30,"o":30,"g":30,"e":30,"d":30,"c":30,"U":30,"Q":30,"O":30,"G":30,"C":30}},"L":{"d":"149,-58r386,0r0,58r-454,0r0,-720r68,0r0,662","k":{"Y":127,"W":82,"V":97,"T":90}},"M":{"d":"185,-720r236,635r2,0r232,-635r103,0r0,720r-68,0r0,-642r-2,0r-236,642r-64,0r-237,-642r-2,0r0,642r-68,0r0,-720r104,0","w":839},"N":{"d":"158,-720r416,629r2,0r0,-629r68,0r0,720r-79,0r-414,-628r-2,0r0,628r-68,0r0,-720r77,0","w":725},"O":{"d":"385,-739v228,0,339,154,339,380v0,171,-71,290,-190,348v-81,39,-210,36,-292,0v-154,-67,-231,-289,-168,-495v41,-135,139,-233,311,-233xm121,-359v0,186,80,320,268,320v186,0,267,-135,267,-320v0,-191,-83,-322,-269,-322v-185,0,-266,137,-266,322","w":777,"k":{"Y":45,"V":30,"A":30}},"P":{"d":"579,-519v3,213,-215,206,-430,201r0,318r-68,0r0,-720r258,0v150,-1,238,58,240,201xm511,-517v0,-181,-193,-140,-362,-145r0,286v165,-4,362,32,362,-141","w":632,"k":{"A":90}},"Q":{"d":"724,-359v0,125,-41,226,-108,291r96,74r-38,46r-106,-82v-76,54,-230,62,-326,19v-153,-68,-229,-285,-168,-491v40,-136,136,-237,311,-237v227,0,339,147,339,380xm121,-359v-3,209,116,355,337,311v21,-4,40,-13,57,-23r-82,-63r36,-47r97,74v58,-53,90,-146,90,-252v0,-192,-84,-322,-269,-322v-185,0,-263,138,-266,322","w":777,"k":{"Y":45,"V":30}},"R":{"d":"540,-528v3,-177,-224,-126,-391,-134r0,277r212,0v104,-1,177,-40,179,-143xm538,0v-49,-92,23,-300,-110,-322v-82,-14,-187,-2,-279,-5r0,327r-68,0r0,-720r282,0v149,1,245,47,245,189v0,102,-41,140,-117,176v72,24,92,100,92,195v0,66,4,128,30,153r0,7r-75,0","w":680},"S":{"d":"567,-191v0,253,-429,276,-505,79v-11,-30,-19,-64,-19,-103r66,0v10,117,82,176,207,176v109,0,183,-46,183,-149v0,-182,-260,-124,-371,-214v-39,-31,-68,-73,-68,-144v0,-200,303,-246,426,-130v36,35,59,86,60,152r-65,0v-2,-107,-72,-157,-177,-157v-103,0,-178,43,-178,138v0,178,261,115,372,205v40,32,69,75,69,147","w":627},"T":{"d":"312,0r-68,0r0,-662r-228,0r0,-58r524,0r0,58r-228,0r0,662","k":{"z":52,"y":52,"w":45,"v":52,"u":75,"s":60,"r":67,"q":75,"p":75,"o":75,"n":75,"m":75,"g":75,"f":22,"e":75,"d":75,"c":75,"a":75,"T":-22,"J":105,"A":75}},"U":{"d":"360,19v-187,0,-279,-106,-279,-290r0,-449r68,0r0,429v1,169,52,249,211,252v158,2,211,-93,211,-252r0,-429r68,0r0,449v0,187,-92,290,-279,290","w":720,"k":{"A":30}},"V":{"d":"89,-720r217,640r216,-640r71,0r-250,720r-75,0r-250,-720r71,0","w":611,"k":{"u":45,"t":15,"s":52,"r":45,"q":52,"p":45,"o":52,"n":45,"m":45,"g":52,"e":52,"d":52,"c":52,"a":60,"Q":30,"O":30,"G":30,"C":30,"A":90}},"W":{"d":"82,-720r155,624r2,0r167,-624r76,0r164,624r2,0r157,-624r70,0r-189,720r-75,0r-167,-636r-2,0r-167,636r-75,0r-186,-720r68,0","w":889,"k":{"u":37,"s":37,"r":37,"q":37,"p":30,"o":45,"n":30,"m":30,"g":45,"e":45,"d":45,"c":45,"a":45,"A":75}},"X":{"d":"107,-720r197,303r198,-303r79,0r-236,350r247,370r-78,0r-210,-318r-209,318r-77,0r248,-370r-238,-350r79,0","w":611},"Y":{"d":"90,-720r212,347r217,-347r79,0r-261,406r0,314r-68,0r0,-309r-257,-411r78,0","w":611,"k":{"u":75,"s":60,"r":67,"q":75,"p":67,"o":75,"n":67,"m":67,"g":75,"e":75,"d":75,"c":75,"a":82,"Q":45,"O":45,"G":45,"C":45,"A":90}},"Z":{"d":"576,-720r0,57r-461,605r464,0r0,58r-548,0r0,-57r461,-605r-422,0r0,-58r506,0","w":611},"[":{"d":"282,-739r0,50r-127,0r0,830r127,0r0,50r-191,0r0,-930r191,0","w":333},"\\":{"d":"-46,-739r60,0r310,739r-60,0","w":278},"]":{"d":"242,-739r0,930r-191,0r0,-50r127,0r0,-830r-127,0r0,-50r191,0","w":333},"^":{"d":"73,-245r230,-453r52,0r231,453r-57,0r-201,-392r-197,392r-58,0","w":660},"_":{"d":"0,119r0,-58r500,0r0,58r-500,0","w":500},"`":{"d":"45,-713r78,0r111,139r-51,0","w":333},"a":{"d":"224,-40v106,0,185,-45,189,-151r0,-81v-90,46,-306,-2,-301,139v2,64,48,93,112,93xm284,-478v-90,0,-142,35,-151,117r-61,0v9,-118,89,-171,213,-171v113,0,188,45,188,161r0,282v1,29,2,49,27,49v12,0,25,-5,36,-9r0,47v-11,4,-34,10,-47,10v-60,1,-66,-27,-78,-80v-42,51,-105,86,-190,86v-101,0,-173,-48,-173,-149v0,-88,62,-134,181,-156v71,-13,187,10,184,-82v-2,-71,-46,-105,-129,-105","w":558},"b":{"d":"484,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm314,14v-89,0,-146,-48,-182,-105r0,91r-60,0r0,-720r60,0r0,285v33,-58,103,-97,185,-97v159,0,231,116,231,274v0,163,-69,272,-234,272","w":596},"c":{"d":"48,-258v0,-158,79,-274,238,-274v126,0,199,61,215,177r-61,0v-20,-71,-68,-123,-154,-123v-123,0,-174,98,-174,220v0,123,50,216,174,218v93,1,146,-57,159,-139r64,0v-23,114,-88,193,-223,193v-165,0,-238,-109,-238,-272","w":557},"d":{"d":"464,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm279,-532v82,0,153,40,185,97r0,-285r60,0r0,720r-60,0v-2,-29,4,-66,-2,-91v-32,61,-93,105,-180,105v-165,0,-234,-109,-234,-272v0,-158,72,-274,231,-274","w":596},"e":{"d":"450,-295v6,-134,-109,-221,-234,-168v-61,26,-95,89,-104,168r338,0xm48,-257v0,-159,79,-275,238,-275v156,0,230,116,228,287r-402,0v3,119,56,205,174,205v83,0,141,-48,157,-119r67,0v-31,100,-93,173,-224,173v-164,0,-238,-108,-238,-271","w":562},"f":{"d":"221,-680v-79,-3,-62,87,-64,162r100,0r0,50r-100,0r0,468r-60,0r0,-468r-77,0r0,-50r77,0v-3,-112,-3,-219,110,-214v20,0,35,1,50,6r0,51v-13,-3,-25,-5,-36,-5","w":278,"k":{"y":-15}},"g":{"d":"464,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm282,-532v89,0,145,49,182,105r0,-91r60,0r0,468v0,166,-71,264,-243,262v-120,-2,-201,-48,-219,-149r64,0v11,100,167,116,252,74v69,-34,87,-119,86,-220v-33,58,-103,97,-185,97v-159,0,-231,-116,-231,-274v0,-163,69,-272,234,-272","w":596},"h":{"d":"289,-478v-209,2,-148,276,-157,478r-60,0r0,-720r60,0r0,274v45,-44,85,-86,167,-86v118,0,184,67,184,193r0,339r-60,0r0,-338v-1,-94,-38,-141,-134,-140","w":555},"i":{"d":"132,0r-60,0r0,-518r60,0r0,518xm72,-631r0,-89r60,0r0,89r-60,0","w":204},"j":{"d":"5,147v56,9,83,-13,83,-70r0,-595r60,0r0,587v2,86,-16,139,-104,135v-15,0,-28,-1,-39,-4r0,-53xm88,-631r0,-89r60,0r0,89r-60,0","w":220},"k":{"d":"132,-272r254,-246r82,0r-194,187r217,331r-67,0r-194,-289r-98,93r0,196r-60,0r0,-720r60,0r0,448","w":504,"k":{"q":15,"o":15,"g":15,"e":15,"d":15,"c":15}},"l":{"d":"132,0r-60,0r0,-720r60,0r0,720","w":204},"m":{"d":"283,-478v-203,5,-142,279,-151,478r-60,0r0,-518r60,0v2,25,-4,57,2,78v26,-55,85,-91,160,-92v86,-1,129,39,152,100v31,-62,85,-99,169,-100v125,-2,162,83,161,205r0,327r-60,0r0,-358v-2,-78,-28,-121,-111,-120v-203,5,-142,279,-151,478r-60,0r0,-358v-2,-78,-28,-122,-111,-120","w":848},"n":{"d":"289,-478v-209,2,-148,276,-157,478r-60,0r0,-518r60,0r0,72v45,-44,85,-86,167,-86v118,0,184,67,184,193r0,339r-60,0r0,-338v-1,-94,-38,-141,-134,-140","w":555},"o":{"d":"48,-259v0,-162,78,-273,240,-273v163,0,240,110,240,273v0,163,-80,273,-240,273v-160,0,-240,-108,-240,-273xm464,-259v0,-128,-48,-219,-176,-219v-125,0,-176,95,-176,219v0,126,51,219,176,219v125,0,176,-95,176,-219","w":576,"k":{"x":22}},"p":{"d":"484,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm317,14v-82,0,-153,-40,-185,-97r0,287r-60,0r0,-722r60,0v2,29,-4,66,2,91v33,-60,93,-105,180,-105v165,0,234,109,234,272v0,158,-72,274,-231,274","w":596},"q":{"d":"464,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm282,-532v89,0,145,49,182,105r0,-91r60,0r0,722r-60,0r0,-287v-33,58,-103,97,-185,97v-159,0,-231,-116,-231,-274v0,-163,69,-272,234,-272","w":596},"r":{"d":"303,-467v-128,0,-171,86,-171,213r0,254r-60,0r0,-518r60,0v2,31,-4,70,2,97v31,-76,71,-109,169,-111r0,65","w":330},"s":{"d":"229,-478v-92,-7,-158,87,-93,142v90,76,308,31,308,199v0,137,-165,177,-292,137v-67,-21,-110,-79,-116,-162r61,0v18,85,57,122,155,122v73,0,128,-29,128,-96v0,-113,-163,-86,-246,-126v-47,-23,-87,-53,-86,-122v1,-94,77,-150,182,-148v118,2,188,51,200,163r-61,0v-9,-77,-60,-103,-140,-109","w":492},"t":{"d":"205,-40v17,0,34,-3,49,-7r0,49v-18,3,-44,13,-69,12v-66,-2,-92,-31,-92,-103r0,-379r-73,0r0,-50r73,0r0,-144r60,0r0,144r97,0r0,50r-97,0r0,355v-2,46,4,73,52,73","w":278},"u":{"d":"256,14v-126,0,-184,-68,-184,-191r0,-341r60,0r0,340v1,91,39,140,133,138v110,-3,158,-84,158,-196r0,-282r60,0r0,518r-60,0v-1,-23,2,-51,-1,-72v-38,45,-84,86,-166,86","w":555},"v":{"d":"82,-518r168,444r168,-444r65,0r-201,518r-67,0r-198,-518r65,0","w":500},"w":{"d":"75,-518r134,442r120,-442r67,0r114,438r136,-438r61,0r-168,518r-64,0r-113,-435r-2,0r-115,435r-72,0r-158,-518r60,0","w":722},"x":{"d":"108,-518r143,206r147,-206r76,0r-187,250r194,268r-72,0r-157,-224r-161,224r-73,0r199,-268r-183,-250r74,0","w":500,"k":{"o":22,"e":22,"d":22,"c":22}},"y":{"d":"220,148v-26,46,-86,68,-152,49r0,-56v39,9,82,9,100,-22v19,-32,35,-69,51,-115r-201,-522r67,0r166,445r166,-445r65,0r-228,599v-11,26,-23,48,-34,67","w":490},"z":{"d":"454,-518r0,53r-344,415r357,0r0,50r-434,0r0,-53r344,-415r-321,0r0,-50r398,0","w":500},"{":{"d":"51,-279v64,-12,77,-48,82,-116v8,-128,-42,-309,78,-340v17,-4,50,-12,74,-6v-61,18,-88,47,-88,121r0,206v-1,77,-17,121,-82,135r0,2v118,24,76,207,82,341v3,69,27,106,86,123v-113,4,-150,-49,-150,-162r0,-182v5,-76,-28,-103,-82,-122","w":333},"|":{"d":"81,-739r60,0r0,739r-60,0r0,-739","w":222},"}":{"d":"139,-620v0,-76,-32,-100,-88,-123v106,-3,152,39,152,144r0,204v2,68,18,105,82,116r0,2v-58,14,-82,46,-82,120v0,127,38,302,-76,335v-18,5,-47,11,-74,8v121,-19,86,-185,86,-314v0,-80,18,-134,82,-149r0,-2v-122,-19,-82,-209,-82,-341","w":333},"~":{"d":"266,-256v-80,-36,-120,27,-153,82r-33,-47v34,-46,64,-103,141,-103v85,0,139,72,220,72v54,0,77,-50,99,-87r40,34v-32,64,-96,135,-195,98v-40,-15,-80,-32,-119,-49","w":660},"\u2019":{"d":"80,-532v28,-14,38,-51,34,-100r-34,0r0,-88r73,0v-3,67,11,149,-21,188v-14,18,-31,30,-52,37r0,-37","w":222},"\u2122":{"d":"523,-720r120,311r2,0r118,-311r96,0r0,421r-52,0r0,-377r-2,0r-145,377r-34,0r-145,-377r-2,0r0,377r-52,0r0,-421r96,0xm349,-720r0,40r-134,0r0,381r-52,0r0,-381r-134,0r0,-40r320,0","w":940},"\u0401":{"d":"560,-720r0,58r-411,0r0,251r371,0r0,58r-371,0r0,295r421,0r0,58r-489,0r0,-720r479,0xm204,-786r0,-89r60,0r0,89r-60,0xm363,-786r0,-89r60,0r0,89r-60,0","w":611},"\u00a9":{"d":"668,-92v-78,86,-263,150,-415,81v-129,-59,-232,-171,-232,-350v0,-177,103,-290,232,-348v151,-69,334,-1,415,81v87,88,148,268,82,415v-20,46,-49,85,-82,121xm172,-126v65,75,227,128,356,70v111,-50,191,-150,191,-305v0,-153,-81,-254,-191,-303v-76,-34,-178,-34,-255,0v-111,49,-192,149,-192,303v0,101,42,178,91,235xm418,-189v69,0,111,-41,121,-103r54,0v-12,92,-76,147,-175,147v-133,0,-210,-86,-210,-219v0,-133,75,-217,207,-217v95,0,166,56,178,143r-54,0v-8,-56,-61,-100,-123,-99v-102,1,-150,71,-150,172v0,101,51,176,152,176","w":800},"\u0404":{"d":"48,-360v0,-238,104,-379,335,-379v163,0,255,85,279,228r-70,0v-26,-116,-94,-170,-227,-170v-161,0,-242,111,-249,270r308,0r0,58r-308,0v4,182,71,314,255,314v135,0,200,-87,228,-198r71,0v-36,150,-125,256,-312,256v-221,0,-310,-158,-310,-379","w":722},"\u00ab":{"d":"297,-291r146,-113r0,63r-104,82r104,80r0,62r-146,-111r0,-63xm113,-291r146,-113r0,63r-104,82r104,80r0,62r-146,-111r0,-63"},"\u0407":{"d":"149,0r-68,0r0,-720r68,0r0,720xm0,-786r0,-89r60,0r0,89r-60,0xm170,-786r0,-89r60,0r0,89r-60,0","w":230},"\u0406":{"d":"149,0r-68,0r0,-720r68,0r0,720","w":230},"\u0456":{"d":"132,0r-60,0r0,-518r60,0r0,518xm72,-631r0,-89r60,0r0,89r-60,0","w":204},"\u0451":{"d":"450,-295v6,-134,-109,-221,-234,-168v-61,26,-95,89,-104,168r338,0xm48,-257v0,-159,79,-275,238,-275v156,0,230,116,228,287r-402,0v3,119,56,205,174,205v83,0,141,-48,157,-119r67,0v-31,100,-93,173,-224,173v-164,0,-238,-108,-238,-271xm180,-597r0,-89r60,0r0,89r-60,0xm334,-597r0,-89r60,0r0,89r-60,0","w":562},"\u2116":{"d":"156,-720r416,629r2,0r0,-629r68,0r0,720r-79,0r-414,-628r-2,0r0,628r-68,0r0,-720r77,0xm713,-91r312,0r0,39r-312,0r0,-39xm869,-454v-79,0,-116,56,-117,134v-1,75,41,136,117,134v80,-2,117,-57,117,-134v0,-80,-36,-134,-117,-134xm1025,-320v1,96,-61,166,-156,164v-99,-3,-156,-62,-156,-164v0,-101,54,-164,156,-164v102,0,154,63,156,164","w":1079},"\u0454":{"d":"48,-258v0,-158,79,-274,238,-274v126,0,199,61,215,177r-61,0v-16,-94,-126,-154,-226,-107v-58,27,-91,86,-99,161r203,0r0,50r-206,0v4,119,54,209,174,211v93,2,146,-57,159,-139r64,0v-23,114,-88,193,-223,193v-165,0,-238,-109,-238,-272","w":557},"\u00bb":{"d":"443,-230r-146,113r0,-63r104,-82r-104,-80r0,-62r146,111r0,63xm259,-230r-146,113r0,-63r104,-82r-104,-80r0,-62r146,111r0,63"},"\u0457":{"d":"132,0r-60,0r0,-518r60,0r0,518xm0,-610r0,-89r60,0r0,89r-60,0xm144,-610r0,-89r60,0r0,89r-60,0","w":204},"\u0410":{"d":"365,-720r276,720r-70,0r-83,-226r-328,0r-85,226r-70,0r283,-720r77,0xm183,-284r282,0r-141,-378","w":651,"k":{"\u0447":60,"\u0444":22,"\u0443":52,"\u0442":52,"\u0441":22,"\u043e":22,"\u0435":22,"\u0427":90,"\u0424":37,"\u0423":52,"\u0422":75,"\u0421":30,"\u041e":30,"\u0451":22}},"\u0411":{"d":"579,-201v0,143,-90,201,-240,201r-258,0r0,-720r446,0r0,58r-378,0r0,251r171,0v151,2,259,58,259,210xm511,-203v0,-174,-192,-149,-362,-150r0,295v169,-5,362,36,362,-145","w":632},"\u0412":{"d":"542,-203v0,-183,-221,-133,-393,-141r0,286v176,-8,393,45,393,-145xm509,-539v0,-161,-206,-115,-360,-123r0,260v162,-4,360,33,360,-137xm610,-203v0,145,-91,203,-235,203r-294,0r0,-720r260,0v140,1,233,47,236,181v1,91,-47,137,-115,157v95,12,147,78,148,179","w":663},"\u0413":{"d":"545,-720r0,58r-396,0r0,662r-68,0r0,-720r464,0","w":563,"k":{"\u044f":75,"\u044e":90,"\u044d":90,"\u0443":60,"\u0441":90,"\u0440":90,"\u043e":90,"\u043d":90,"\u043c":90,"\u043b":97,"\u0438":90,"\u0437":90,"\u0436":75,"\u0435":90,"\u0434":90,"\u0432":90,"\u0430":90,"\u0424":45,"\u0423":-30,"\u0422":-22,"\u041b":37,"\u0414":52,"\u0410":105,"\u0451":90}},"\u0414":{"d":"79,-58v57,-112,83,-226,83,-402r0,-260r451,0r0,662r55,0r0,223r-68,0r0,-165r-506,0r0,165r-68,0r0,-223r53,0xm230,-432v1,156,-28,272,-80,374r395,0r0,-604r-315,0r0,230","w":694},"\u0415":{"d":"560,-720r0,58r-411,0r0,251r371,0r0,58r-371,0r0,295r421,0r0,58r-489,0r0,-720r479,0","w":611},"\u0416":{"d":"534,-348r336,-372r80,0r-274,301r314,419r-78,0r-281,-373r-97,107r0,266r-68,0r0,-266r-97,-107r-281,373r-78,0r314,-419r-274,-301r80,0r336,372r0,-372r68,0r0,372","w":999,"k":{"\u0447":67,"\u0443":45,"\u0442":45,"\u0424":37,"\u041e":30}},"\u0417":{"d":"305,-680v-107,0,-173,49,-175,157r-67,0v3,-145,94,-215,242,-215v140,0,252,49,252,185v0,89,-40,144,-112,173v81,24,139,85,139,184v0,147,-104,218,-269,215v-161,-3,-266,-73,-270,-234r66,0v9,126,78,176,207,176v116,0,198,-39,198,-149v0,-128,-97,-175,-239,-165r0,-58v122,5,216,-19,212,-138v-3,-98,-84,-131,-184,-131","w":637},"\u0418":{"d":"149,-91r2,0r416,-629r77,0r0,720r-68,0r0,-628r-2,0r-414,628r-79,0r0,-720r68,0r0,629","w":725},"\u0419":{"d":"149,-91r2,0r416,-629r77,0r0,720r-68,0r0,-628r-2,0r-414,628r-79,0r0,-720r68,0r0,629xm513,-929v-8,81,-64,126,-149,126v-81,0,-134,-49,-139,-126r39,0v9,53,46,81,105,81v61,0,94,-29,107,-81r37,0","w":725},"\u041a":{"d":"149,-357r357,-363r89,0r-284,287r334,433r-83,0r-300,-391r-113,113r0,278r-68,0r0,-720r68,0r0,363","w":663,"k":{"\u0447":75,"\u0444":30,"\u0443":52,"\u0442":45,"\u0441":30,"\u043e":30,"\u0435":30,"\u0424":52,"\u0421":30,"\u041e":30,"\u0451":30}},"\u041b":{"d":"16,-49v65,14,82,2,100,-79v27,-126,16,-415,18,-592r479,0r0,720r-68,0r0,-662r-343,0r0,312v-2,146,-4,277,-74,344v-27,26,-73,24,-112,12r0,-55","w":694},"\u041c":{"d":"185,-720r236,635r2,0r232,-635r103,0r0,720r-68,0r0,-642r-2,0r-236,642r-64,0r-237,-642r-2,0r0,642r-68,0r0,-720r104,0","w":839},"\u041d":{"d":"149,-411r426,0r0,-309r68,0r0,720r-68,0r0,-353r-426,0r0,353r-68,0r0,-720r68,0r0,309","w":724},"\u041e":{"d":"385,-739v228,0,339,154,339,380v0,171,-71,290,-190,348v-81,39,-210,36,-292,0v-154,-67,-231,-289,-168,-495v41,-135,139,-233,311,-233xm121,-359v0,186,80,320,268,320v186,0,267,-135,267,-320v0,-191,-83,-322,-269,-322v-185,0,-266,137,-266,322","w":777,"k":{"\u0434":30,"\u0425":30,"\u0416":30,"\u0414":30,"\u0410":30}},"\u041f":{"d":"643,-720r0,720r-68,0r0,-662r-426,0r0,662r-68,0r0,-720r562,0","w":724},"\u0420":{"d":"579,-519v3,213,-215,206,-430,201r0,318r-68,0r0,-720r258,0v150,-1,238,58,240,201xm511,-517v0,-181,-193,-140,-362,-145r0,286v165,-4,362,32,362,-141","w":632,"k":{"\u041b":52,"\u0414":60,"\u0410":90}},"\u0421":{"d":"53,-360v0,-238,104,-379,335,-379v163,0,255,85,279,228r-70,0v-26,-116,-94,-170,-227,-170v-179,0,-249,139,-249,319v0,184,67,323,255,323v135,0,200,-87,228,-198r71,0v-36,150,-125,256,-312,256v-221,0,-310,-158,-310,-379","w":727},"\u0422":{"d":"312,0r-68,0r0,-662r-228,0r0,-58r524,0r0,58r-228,0r0,662","k":{"\u044f":60,"\u044e":75,"\u044d":75,"\u044c":75,"\u044b":75,"\u0449":75,"\u0448":75,"\u0447":60,"\u0446":75,"\u0445":45,"\u0444":75,"\u0443":52,"\u0441":75,"\u0440":75,"\u043f":75,"\u043e":75,"\u043d":75,"\u043c":75,"\u043b":75,"\u043a":75,"\u0438":75,"\u0437":60,"\u0436":52,"\u0435":75,"\u0434":75,"\u0433":75,"\u0432":75,"\u0431":22,"\u0430":75,"\u0424":37,"\u0423":-30,"\u0422":-22,"\u041b":30,"\u0414":67,"\u0410":75,"\u0451":75}},"\u0423":{"d":"121,-43v55,12,104,-2,117,-47r14,-29r-248,-601r71,0r214,521r220,-521r75,0r-273,627v-27,75,-85,130,-190,107r0,-57","w":580,"k":{"\u044f":45,"\u044e":52,"\u044d":60,"\u0449":52,"\u0448":52,"\u0447":38,"\u0446":52,"\u0445":22,"\u0444":52,"\u0442":15,"\u0441":60,"\u0440":52,"\u043f":52,"\u043e":60,"\u043d":52,"\u043c":52,"\u043b":60,"\u043a":52,"\u0439":52,"\u0438":52,"\u0437":37,"\u0435":60,"\u0434":75,"\u0433":52,"\u0432":52,"\u0431":22,"\u0430":60,"\u0424":22,"\u0422":-30,"\u041b":30,"\u0414":52,"\u0410":97,"\u0451":60}},"\u0424":{"d":"454,-720r0,62v168,-10,265,62,312,180v46,116,5,263,-58,324v-57,56,-137,90,-254,83r0,71r-68,0r0,-71v-209,10,-333,-94,-333,-292v0,-137,70,-228,168,-272v47,-22,100,-25,165,-23r0,-62r68,0xm121,-365v0,157,91,248,265,236r0,-471v-174,-11,-265,78,-265,235xm719,-365v0,-157,-91,-246,-265,-235r0,471v174,11,265,-79,265,-236","w":840,"k":{"\u0425":37,"\u0423":22,"\u0422":37,"\u0416":37,"\u0410":37}},"\u0425":{"d":"107,-720r197,303r198,-303r79,0r-236,350r247,370r-78,0r-210,-318r-209,318r-77,0r248,-370r-238,-350r79,0","w":611,"k":{"\u0443":37,"\u0424":37,"\u041e":30}},"\u0426":{"d":"149,-58r426,0r0,-662r68,0r0,662r55,0r0,223r-68,0r0,-165r-549,0r0,-720r68,0r0,662","w":724},"\u0427":{"d":"294,-327v-144,0,-220,-67,-219,-212r0,-181r68,0r0,194v-7,180,233,143,383,128r0,-322r68,0r0,720r-68,0r0,-338v-68,10,-154,10,-232,11","w":675},"\u0428":{"d":"149,-58r300,0r0,-662r68,0r0,662r300,0r0,-662r68,0r0,720r-804,0r0,-720r68,0r0,662","w":966},"\u0429":{"d":"149,-58r300,0r0,-662r68,0r0,662r300,0r0,-662r68,0r0,662r55,0r0,223r-68,0r0,-165r-791,0r0,-720r68,0r0,662","w":966},"\u042a":{"d":"640,-201v0,143,-90,201,-240,201r-258,0r0,-662r-149,0r0,-58r217,0r0,309r171,0v151,2,259,58,259,210xm572,-203v0,-174,-192,-149,-362,-150r0,295v169,-5,362,36,362,-145","w":693},"\u042b":{"d":"579,-201v0,143,-90,201,-240,201r-258,0r0,-720r68,0r0,309r171,0v151,2,259,58,259,210xm511,-203v0,-174,-192,-149,-362,-150r0,295v169,-5,362,36,362,-145xm778,0r-68,0r0,-720r68,0r0,720","w":859},"\u042c":{"d":"579,-201v0,143,-90,201,-240,201r-258,0r0,-720r68,0r0,309r171,0v151,2,259,58,259,210xm511,-203v0,-174,-192,-149,-362,-150r0,295v169,-5,362,36,362,-145","w":632,"k":{"\u0422":60}},"\u042d":{"d":"56,-511v25,-143,116,-228,279,-228v230,0,335,141,335,379v0,221,-89,379,-310,379v-186,0,-276,-105,-312,-256r71,0v29,111,93,198,228,198v184,0,251,-132,255,-314r-308,0r0,-58r308,0v-23,-148,-82,-270,-249,-270v-132,0,-201,54,-227,170r-70,0","w":723,"k":{"\u0434":30,"\u0414":30}},"\u042e":{"d":"611,-739v228,0,339,154,339,380v0,171,-71,290,-190,348v-80,39,-209,39,-290,1v-120,-56,-189,-172,-191,-343r-130,0r0,353r-68,0r0,-720r68,0r0,309r130,0v28,-188,121,-328,332,-328xm347,-359v0,186,80,320,268,320v186,0,267,-135,267,-320v0,-191,-83,-322,-269,-322v-185,0,-266,137,-266,322","w":1003,"k":{"\u0434":30,"\u0414":30}},"\u042f":{"d":"53,-519v0,-143,90,-202,240,-201r258,0r0,720r-68,0r0,-318r-178,0r-201,318r-81,0r208,-324v-105,-18,-178,-71,-178,-195xm121,-517v0,174,197,137,362,141r0,-286v-169,5,-362,-36,-362,145","w":632},"\u0430":{"d":"224,-40v106,0,185,-45,189,-151r0,-81v-90,46,-306,-2,-301,139v2,64,48,93,112,93xm284,-478v-90,0,-142,35,-151,117r-61,0v9,-118,89,-171,213,-171v113,0,188,45,188,161r0,282v1,29,2,49,27,49v12,0,25,-5,36,-9r0,47v-11,4,-34,10,-47,10v-60,1,-66,-27,-78,-80v-42,51,-105,86,-190,86v-101,0,-173,-48,-173,-149v0,-88,62,-134,181,-156v71,-13,187,10,184,-82v-2,-71,-46,-105,-129,-105","w":558,"k":{"\u0447":15,"\u0442":15}},"\u0431":{"d":"295,14v-215,0,-261,-207,-233,-428v17,-136,71,-237,202,-261r76,-15v39,-11,79,-12,86,-49r63,0v-20,137,-238,77,-313,170v-29,35,-47,79,-57,137v37,-58,88,-102,180,-100v161,3,236,111,236,273v0,163,-80,273,-240,273xm119,-266v0,126,52,226,176,226v125,0,176,-95,176,-219v0,-128,-48,-219,-176,-219v-124,0,-176,89,-176,212","w":583},"\u0432":{"d":"410,-145v1,-127,-156,-97,-278,-100r0,195r167,0v64,1,111,-33,111,-95xm391,-380v4,-118,-149,-82,-259,-88r0,173v110,-4,256,27,259,-85xm474,-148v-2,95,-60,148,-151,148r-251,0r0,-518r241,0v79,3,138,42,138,116v0,67,-29,111,-81,128v53,14,106,57,104,126","w":522},"\u0433":{"d":"392,-518r0,50r-260,0r0,468r-60,0r0,-518r320,0","w":404,"k":{"\u0443":-15,"\u0442":-15,"\u043b":30,"\u0434":37}},"\u0434":{"d":"64,-50v69,-112,63,-289,62,-468r343,0r0,468r52,0r0,185r-60,0r0,-135r-383,0r0,135r-60,0r0,-185r46,0xm185,-468v2,164,2,314,-57,418r281,0r0,-418r-224,0","w":553,"k":{"\u0447":45}},"\u0435":{"d":"450,-295v6,-134,-109,-221,-234,-168v-61,26,-95,89,-104,168r338,0xm48,-257v0,-159,79,-275,238,-275v156,0,230,116,228,287r-402,0v3,119,56,205,174,205v83,0,141,-48,157,-119r67,0v-31,100,-93,173,-224,173v-164,0,-238,-108,-238,-271","w":562},"\u0436":{"d":"105,-518r232,256r0,-256r60,0r0,256r232,-256r78,0r-186,204r207,314r-68,0r-183,-272r-80,82r0,190r-60,0r0,-190r-80,-82r-183,272r-68,0r207,-314r-186,-204r78,0","w":734,"k":{"\u043e":22}},"\u0437":{"d":"246,-478v-85,0,-115,36,-134,108r-58,0v13,-100,81,-162,190,-162v107,0,188,37,194,135v4,63,-47,110,-98,119v61,14,119,66,117,141v-1,109,-90,151,-207,151v-126,0,-202,-64,-213,-176r59,0v8,79,67,122,157,122v76,0,140,-30,140,-96v0,-96,-76,-122,-179,-115r0,-50v89,7,164,-12,164,-90v0,-68,-60,-87,-132,-87","w":505},"\u0438":{"d":"132,-80r296,-438r66,0r0,518r-60,0r0,-438r-295,438r-67,0r0,-518r60,0r0,438","w":566},"\u0439":{"d":"132,-80r296,-438r66,0r0,518r-60,0r0,-438r-295,438r-67,0r0,-518r60,0r0,438xm427,-697v-8,81,-64,126,-149,126v-81,0,-134,-49,-139,-126r39,0v9,53,46,81,105,81v61,0,94,-29,107,-81r37,0","w":566},"\u043a":{"d":"132,-272r254,-246r82,0r-194,187r217,331r-67,0r-194,-289r-98,93r0,196r-60,0r0,-518r60,0r0,246","w":504,"k":{"\u0441":15,"\u043e":15,"\u0435":15,"\u0451":15}},"\u043b":{"d":"7,-52v83,22,96,-57,99,-145v2,-33,3,-76,4,-128v1,-52,1,-116,1,-193r359,0r0,518r-60,0r0,-468r-239,0r-3,216v-6,130,-14,291,-161,249r0,-49","w":553},"\u043c":{"d":"150,-518r175,450r174,-450r78,0r0,518r-60,0r0,-424r-165,424r-55,0r-165,-424r0,424r-60,0r0,-518r78,0","w":649},"\u043d":{"d":"135,-301r288,0r0,-217r60,0r0,518r-60,0r0,-251r-288,0r0,251r-60,0r0,-518r60,0r0,217","w":558},"\u043e":{"d":"48,-259v0,-162,78,-273,240,-273v163,0,240,110,240,273v0,163,-80,273,-240,273v-160,0,-240,-108,-240,-273xm464,-259v0,-128,-48,-219,-176,-219v-125,0,-176,95,-176,219v0,126,51,219,176,219v125,0,176,-95,176,-219","w":576,"k":{"\u0445":22,"\u0436":22}},"\u043f":{"d":"480,-518r0,518r-60,0r0,-468r-288,0r0,468r-60,0r0,-518r408,0","w":552},"\u0440":{"d":"484,-250v0,-130,-49,-228,-177,-228v-116,0,-179,95,-175,226v3,120,56,212,175,212v116,0,177,-91,177,-210xm317,14v-82,0,-153,-40,-185,-97r0,287r-60,0r0,-722r60,0v2,29,-4,66,2,91v33,-60,93,-105,180,-105v165,0,234,109,234,272v0,158,-72,274,-231,274","w":596},"\u0441":{"d":"48,-258v0,-158,79,-274,238,-274v126,0,199,61,215,177r-61,0v-20,-71,-68,-123,-154,-123v-123,0,-174,98,-174,220v0,123,50,216,174,218v93,1,146,-57,159,-139r64,0v-23,114,-88,193,-223,193v-165,0,-238,-109,-238,-272","w":557},"\u0442":{"d":"422,-518r0,50r-174,0r0,468r-60,0r0,-468r-174,0r0,-50r408,0","w":436,"k":{"\u0443":-15,"\u0442":-15,"\u043b":30,"\u0434":45}},"\u0443":{"d":"220,148v-26,46,-86,68,-152,49r0,-56v39,9,82,9,100,-22v19,-32,35,-69,51,-115r-201,-522r67,0r166,445r166,-445r65,0r-228,599v-11,26,-23,48,-34,67","w":490,"k":{"\u0442":-15,"\u0434":22}},"\u0444":{"d":"112,-261v0,116,34,221,146,221v112,0,147,-106,147,-221v0,-112,-39,-217,-147,-217v-109,0,-146,105,-146,217xm249,-532v73,-2,129,43,156,90r0,-297r60,0r0,299v27,-47,83,-95,156,-92v146,5,201,125,201,273v0,151,-52,273,-201,273v-78,0,-126,-33,-156,-89r0,279r-60,0r0,-281v-31,56,-78,91,-156,91v-149,0,-201,-123,-201,-275v0,-148,55,-266,201,-271xm465,-261v0,115,35,221,147,221v112,0,146,-105,146,-221v0,-112,-37,-217,-146,-217v-108,0,-147,104,-147,217","w":870},"\u0445":{"d":"108,-518r143,206r147,-206r76,0r-187,250r194,268r-72,0r-157,-224r-161,224r-73,0r199,-268r-183,-250r74,0","w":500,"k":{"\u043e":22,"\u0435":22,"\u0451":22}},"\u0446":{"d":"132,-50r288,0r0,-468r60,0r0,468r52,0r0,186r-60,0r0,-136r-400,0r0,-518r60,0r0,468","w":560},"\u0447":{"d":"218,-226v-99,0,-163,-56,-163,-157r0,-135r60,0r0,142v-8,119,179,107,263,80r0,-222r60,0r0,518r-60,0r0,-245v-47,15,-99,19,-160,19","w":510},"\u0448":{"d":"132,-50r262,0r0,-468r60,0r0,468r262,0r0,-468r60,0r0,518r-704,0r0,-518r60,0r0,468","w":848},"\u0449":{"d":"132,-50r262,0r0,-468r60,0r0,468r262,0r0,-468r60,0r0,468r52,0r0,186r-60,0r0,-136r-696,0r0,-518r60,0r0,468","w":856},"\u044a":{"d":"491,-149v5,185,-215,146,-392,149r0,-468r-110,0r0,-50r170,0r0,217r152,0v106,2,177,50,180,152xm427,-149v0,-65,-55,-103,-120,-102r-148,0r0,201v120,-1,268,20,268,-99","w":539},"\u044b":{"d":"464,-149v5,185,-215,146,-392,149r0,-518r60,0r0,217r152,0v106,2,177,50,180,152xm400,-149v0,-65,-55,-103,-120,-102r-148,0r0,201v120,-1,268,20,268,-99xm629,0r-60,0r0,-518r60,0r0,518","w":701},"\u044c":{"d":"464,-149v5,185,-215,146,-392,149r0,-518r60,0r0,217r152,0v106,2,177,50,180,152xm400,-149v0,-65,-55,-103,-120,-102r-148,0r0,201v120,-1,268,20,268,-99","w":512,"k":{"\u0442":52}},"\u044d":{"d":"54,-355v18,-104,94,-180,215,-177v159,4,238,116,238,274v0,163,-73,272,-238,272v-135,0,-200,-79,-223,-193r64,0v14,82,66,141,159,139v120,-2,169,-93,174,-211r-206,0r0,-50r203,0v-13,-99,-62,-177,-171,-177v-86,0,-135,52,-154,123r-61,0","w":555},"\u044e":{"d":"478,14v-157,0,-237,-103,-240,-265r-106,0r0,251r-60,0r0,-518r60,0r0,217r109,0v17,-136,87,-231,237,-231v163,0,240,110,240,273v0,163,-80,273,-240,273xm478,-40v125,0,176,-95,176,-219v0,-128,-48,-219,-176,-219v-125,0,-176,95,-176,219v0,126,51,219,176,219","w":766},"\u044f":{"d":"48,-369v-3,-185,215,-146,392,-149r0,518r-60,0r0,-221r-143,0r-125,221r-67,0r131,-226v-76,-18,-127,-59,-128,-143xm112,-369v0,65,55,98,120,98r148,0r0,-197v-120,1,-268,-20,-268,99","w":512},"\"":{"d":"57,-720r52,0r0,226r-52,0r0,-226xm168,-720r52,0r0,226r-52,0r0,-226","w":278},"!":{"d":"130,-496r0,-224r73,0r0,224r-14,315r-45,0xm130,0r0,-88r73,0r0,88r-73,0","w":333}}});

/* Arial Bold */
Cufon.registerFont({"w":1139,"face":{"font-family":"Arial","font-weight":700,"font-stretch":"normal","units-per-em":"2048","panose-1":"2 11 7 4 2 2 2 2 2 4","ascent":"1638","descent":"-410","x-height":"24","bbox":"-94 -1831 2197.04 432.065","underline-thickness":"215","underline-position":"-110","unicode-range":"U+0020-U+2192"},"glyphs":{" ":{"w":569,"k":{"Y":37,"A":76}},"\u00a0":{"w":569},"!":{"d":"257,-378r-73,-744r0,-344r304,0r0,344r-72,744r-159,0xm196,0r0,-281r281,0r0,281r-281,0","w":682},"\"":{"d":"165,-945r-53,-273r0,-248r306,0r0,248r-46,273r-207,0xm616,-945r-53,-273r0,-248r306,0r0,248r-46,273r-207,0","w":971},"#":{"d":"154,-365r-136,0r0,-220r180,0r60,-295r-240,0r0,-221r285,0r79,-390r224,0r-79,390r221,0r77,-390r232,0r-80,390r138,0r0,221r-183,0r-60,295r243,0r0,220r-288,0r-79,390r-223,0r77,-390r-222,0r-79,390r-226,0xm483,-880r-59,295r222,0r58,-295r-221,0"},"$":{"d":"1048,-439v-1,256,-174,428,-414,457r0,187r-145,0r0,-182v-243,-31,-383,-185,-419,-434r261,-28v18,100,82,185,158,222r0,-419v-228,-64,-374,-190,-379,-445v-4,-226,164,-388,379,-404r0,-99r145,0r0,99v211,24,338,148,373,348r-253,33v-15,-79,-55,-132,-120,-160r0,391v160,43,269,100,327,169v58,69,87,157,87,265xm489,-1267v-102,26,-173,171,-97,273v21,30,54,54,97,73r0,-346xm634,-203v134,-12,225,-199,130,-315v-26,-32,-70,-58,-130,-75r0,390"},"%":{"d":"415,-717v-222,0,-326,-144,-326,-387v0,-240,104,-387,321,-387v222,0,326,144,326,387v0,240,-104,387,-321,387xm341,-1298v-40,52,-40,332,0,384v34,45,105,45,139,0v39,-51,38,-332,0,-383v-34,-45,-104,-46,-139,-1xm624,56r-208,0r781,-1547r202,0xm1404,59v-222,0,-326,-145,-326,-388v0,-241,104,-387,323,-387v220,0,324,146,324,387v0,241,-103,388,-321,388xm1330,-522v-44,48,-44,335,0,383v29,49,104,46,138,1v39,-52,40,-332,1,-384v-33,-45,-110,-48,-139,0","w":1821},"&":{"d":"1215,-345v46,46,176,139,231,166r-170,217v-83,-41,-163,-97,-240,-168v-113,100,-226,152,-427,156v-295,6,-519,-161,-519,-428v0,-233,151,-356,335,-449v-78,-96,-151,-186,-151,-322v0,-200,179,-318,410,-318v229,0,401,130,404,334v0,59,-18,116,-53,169v-35,53,-107,114,-214,181r204,269v24,-43,45,-98,62,-167r254,58v-42,146,-64,213,-126,302xm691,-1293v-78,0,-141,45,-143,111v-3,64,91,156,133,206v57,-43,163,-116,160,-187v-3,-76,-66,-130,-150,-130xm378,-412v-4,123,92,210,219,206v118,-3,180,-47,260,-112r-286,-353v-105,52,-189,132,-193,259","w":1479},"'":{"d":"145,-945r-53,-273r0,-248r306,0r0,248r-46,273r-207,0","w":487},"(":{"d":"616,-1491v-153,350,-240,546,-240,966v0,401,91,650,237,956r-193,0v-174,-260,-309,-583,-313,-962v-4,-389,147,-716,317,-960r192,0","w":682},")":{"d":"576,-546v0,387,-130,704,-313,977r-194,0v125,-258,179,-425,223,-727v11,-74,14,-151,14,-229v0,-418,-87,-617,-239,-966r191,0v176,251,318,560,318,945","w":682},"*":{"d":"245,-792r-151,-117v60,-68,124,-130,189,-193v-16,-1,-227,-52,-255,-64r59,-176v87,35,165,74,234,117v-16,-109,-24,-197,-24,-266r178,0v0,49,-9,138,-27,268v13,-5,42,-18,86,-39v60,-27,115,-51,166,-70r53,181v-74,17,-160,33,-257,49r177,202r-153,101r-135,-223v-41,72,-87,149,-140,230","w":797},"+":{"d":"469,-211r0,-381r-384,0r0,-263r384,0r0,-381r256,0r0,381r385,0r0,263r-385,0r0,381r-256,0","w":1196},",":{"d":"140,-281r281,0v-2,129,8,302,-21,393v-32,104,-120,178,-228,215r-55,-116v105,-36,154,-85,159,-211r-136,0r0,-281","w":569},"-":{"d":"115,-391r0,-281r552,0r0,281r-552,0","w":682},"\u00ad":{"d":"115,-391r0,-281r552,0r0,281r-552,0","w":682},".":{"d":"147,0r0,-281r281,0r0,281r-281,0","w":569},"\/":{"d":"-3,25r363,-1516r211,0r-367,1516r-207,0","w":569},"0":{"d":"230,-1322v147,-198,518,-197,665,2v91,123,143,319,143,597v0,277,-48,477,-144,598v-79,100,-190,150,-332,150v-143,0,-258,-55,-345,-165v-87,-110,-131,-305,-131,-586v0,-276,52,-472,144,-596xm652,-1206v-51,-43,-130,-43,-181,0v-27,22,-45,61,-62,116v-35,111,-36,612,-3,722v31,102,58,160,156,160v91,0,125,-59,153,-149v34,-111,36,-612,3,-721v-19,-64,-40,-106,-66,-128"},"1":{"d":"162,-1101v151,-51,369,-207,416,-371r228,0r0,1472r-281,0r0,-1059v-103,96,-224,167,-363,213r0,-255","k":{"1":113}},"2":{"d":"571,-1472v337,-12,559,278,429,596v-65,159,-145,234,-296,375v-133,124,-159,137,-226,240r558,0r0,261r-985,0v11,-99,43,-192,96,-280v53,-88,159,-206,316,-352v127,-118,204,-198,233,-240v39,-58,58,-115,58,-172v1,-122,-70,-197,-190,-195v-135,2,-192,83,-200,229r-280,-28v25,-288,199,-424,487,-434"},"3":{"d":"1051,-440v0,258,-226,465,-492,465v-265,0,-459,-174,-482,-414r272,-33v13,123,86,214,208,214v124,0,206,-108,206,-244v0,-129,-79,-229,-196,-230v-36,0,-79,7,-129,21r31,-229v139,6,232,-63,234,-189v1,-97,-65,-164,-161,-162v-109,2,-175,84,-185,196r-259,-44v43,-243,184,-373,452,-383v230,-9,435,161,435,376v0,129,-70,231,-211,308v158,31,277,164,277,348"},"4":{"d":"638,0r0,-295r-600,0r0,-246r636,-931r236,0r0,930r182,0r0,247r-182,0r0,295r-272,0xm638,-542r0,-501r-337,501r337,0"},"5":{"d":"1077,-492v0,286,-219,517,-502,517v-271,0,-454,-162,-484,-402r280,-29v11,113,94,206,207,206v138,0,210,-122,210,-287v0,-162,-74,-270,-218,-270v-81,0,-153,36,-217,107r-228,-33r144,-763r743,0r0,263r-530,0r-44,249v321,-158,639,103,639,442"},"6":{"d":"1066,-472v0,288,-192,497,-471,497v-148,0,-270,-58,-365,-173v-95,-115,-143,-303,-143,-565v0,-269,50,-462,149,-581v99,-119,228,-178,387,-178v239,0,382,145,416,365r-272,30v-11,-101,-60,-164,-161,-164v-59,0,-109,27,-150,80v-41,53,-67,164,-78,333v70,-83,157,-124,261,-124v243,-2,427,219,427,480xm595,-745v-123,0,-193,107,-193,251v0,156,79,286,207,286v127,0,182,-104,182,-261v0,-163,-61,-276,-196,-276"},"7":{"d":"284,0v15,-460,211,-901,442,-1185r-639,0r0,-261r961,0r0,204v-249,254,-488,752,-493,1242r-271,0"},"8":{"d":"83,-419v4,-184,96,-313,245,-372v-126,-50,-208,-150,-208,-303v0,-235,182,-378,440,-378v256,0,440,144,440,378v0,151,-87,255,-202,303v146,57,247,176,249,360v4,271,-197,457,-474,457v-278,0,-495,-177,-490,-445xm563,-1249v-106,0,-177,70,-177,175v0,109,68,178,174,178v107,0,176,-70,176,-179v0,-103,-70,-174,-173,-174xm564,-671v-129,0,-202,110,-204,225v-3,141,80,246,208,246v127,0,201,-101,201,-243v0,-129,-83,-228,-205,-228"},"9":{"d":"65,-976v0,-285,194,-496,470,-496v149,0,271,57,366,172v95,115,143,305,143,568v0,268,-50,461,-149,580v-99,119,-229,178,-388,178v-246,0,-379,-139,-414,-365r272,-30v11,101,61,163,163,163v58,0,107,-27,148,-80v41,-53,67,-164,78,-332v-71,82,-159,123,-265,123v-241,1,-424,-219,-424,-481xm537,-701v123,0,192,-108,192,-252v0,-155,-79,-286,-207,-286v-127,0,-181,106,-181,263v0,162,62,275,196,275"},":":{"d":"201,-781r0,-281r281,0r0,281r-281,0xm201,0r0,-281r281,0r0,281r-281,0","w":682},";":{"d":"193,-781r0,-281r281,0r0,281r-281,0xm193,-281r281,0v-2,129,8,302,-21,393v-32,104,-120,178,-228,215r-55,-116v104,-35,154,-87,159,-211r-136,0r0,-281","w":682},"\u037e":{"d":"193,-781r0,-281r281,0r0,281r-281,0xm193,-281r281,0v-2,129,8,302,-21,393v-32,104,-120,178,-228,215r-55,-116v104,-35,154,-87,159,-211r-136,0r0,-281","w":682},"<":{"d":"1100,-167r-1005,-437r0,-242r1005,-435r0,285r-701,268r701,278r0,283","w":1196},"=":{"d":"85,-816r0,-258r1025,0r0,258r-1025,0xm85,-372r0,-259r1025,0r0,259r-1025,0","w":1196},">":{"d":"95,-166r0,-283r702,-276r-702,-273r0,-281r1006,435r0,240","w":1196},"?":{"d":"630,-1481v285,0,528,173,528,421v0,62,-17,121,-52,176v-35,55,-113,128,-225,226v-111,97,-130,95,-130,280r-255,0v-9,-254,49,-322,204,-451v81,-67,131,-110,147,-131v104,-142,-29,-316,-205,-307v-161,8,-248,98,-278,247r-258,-32v15,-249,240,-429,524,-429xm496,0r0,-281r281,0r0,281r-281,0","w":1251},"@":{"d":"1089,247v318,0,548,-88,688,-266r213,0v-140,288,-460,450,-885,450v-439,0,-773,-154,-927,-441v-163,-303,-148,-696,16,-996v163,-298,462,-486,892,-486v502,0,851,286,851,771v0,170,-52,324,-157,461v-131,173,-300,260,-505,260v-106,0,-159,-35,-181,-114v-79,76,-169,114,-272,114v-227,2,-385,-180,-385,-419v0,-323,237,-665,542,-665v119,0,206,45,263,136r25,-111r264,0r-151,717v-9,45,-14,75,-14,88v-1,29,14,49,39,50v32,0,73,-20,124,-58v122,-89,228,-271,228,-469v0,-352,-287,-577,-675,-577v-372,0,-622,165,-744,422v-64,134,-95,272,-95,417v0,472,349,716,846,716xm1002,-904v-212,0,-294,263,-306,474v-11,190,130,300,286,219v125,-65,199,-276,205,-459v4,-135,-66,-234,-185,-234","w":1997},"A":{"d":"1471,0r-322,0r-128,-333r-586,0r-121,333r-314,0r571,-1466r313,0xm926,-580r-202,-544r-198,544r400,0","w":1479,"k":{"\u2019":113,"y":76,"w":37,"v":76,"Y":188,"W":113,"V":152,"T":152," ":76}},"B":{"d":"1100,-779v161,44,278,166,278,354v0,231,-146,394,-372,415v-163,15,-624,9,-856,10r0,-1466r586,0v288,-6,422,33,525,198v31,50,45,108,45,171v-1,151,-93,269,-206,318xm446,-1222r0,339r194,0v115,0,187,-2,215,-5v94,-10,163,-67,163,-167v-1,-97,-57,-151,-149,-162v-39,-5,-315,-5,-423,-5xm446,-639r0,392r274,0v107,0,174,-3,203,-9v87,-16,151,-79,149,-183v-1,-95,-50,-152,-124,-179v-74,-26,-359,-20,-502,-21","w":1479},"C":{"d":"762,-228v190,0,285,-128,325,-311r287,91v-80,294,-263,470,-609,473v-405,3,-668,-314,-668,-745v0,-458,256,-771,686,-771v308,0,518,156,587,429r-293,70v-30,-142,-144,-246,-309,-246v-256,0,-366,193,-366,496v0,185,33,317,100,396v67,79,153,118,260,118","w":1479},"D":{"d":"148,-1466v262,7,617,-32,820,28v280,82,409,340,409,719v0,259,-74,448,-202,571v-103,99,-247,148,-470,148r-557,0r0,-1466xm444,-1218r0,971v123,-2,313,7,400,-14v188,-47,225,-219,227,-471v1,-198,-23,-319,-114,-403v-94,-87,-164,-81,-380,-83r-133,0","w":1479},"E":{"d":"149,0r0,-1466r1087,0r0,248r-791,0r0,325r736,0r0,247r-736,0r0,399r819,0r0,247r-1115,0","w":1366},"F":{"d":"151,0r0,-1466r1005,0r0,248r-709,0r0,347r612,0r0,248r-612,0r0,623r-296,0","w":1251,"k":{"A":113,".":227,",":227}},"G":{"d":"823,-228v134,2,268,-63,347,-125r0,-186r-339,0r0,-247r638,0r0,584v-117,115,-392,229,-627,227v-471,-3,-744,-302,-744,-763v0,-326,150,-562,377,-680v206,-107,614,-90,777,42v99,80,169,181,198,316r-294,55v-39,-139,-155,-234,-330,-233v-277,2,-423,188,-423,488v0,314,141,517,420,522","w":1593},"H":{"d":"150,0r0,-1466r296,0r0,577r580,0r0,-577r296,0r0,1466r-296,0r0,-641r-580,0r0,641r-296,0","w":1479},"I":{"d":"140,0r0,-1466r296,0r0,1466r-296,0","w":569},"J":{"d":"497,-228v166,0,181,-90,181,-291r0,-947r295,0r0,928v1,260,-42,382,-188,486v-74,53,-175,77,-298,77v-296,0,-453,-174,-452,-478r279,-32v4,164,48,257,183,257"},"K":{"d":"153,0r0,-1466r296,0r0,651r598,-651r398,0r-552,571r582,895r-383,0r-403,-688r-240,245r0,443r-296,0","w":1479},"L":{"d":"157,0r0,-1454r296,0r0,1207r736,0r0,247r-1032,0","w":1251,"k":{"\u2019":113,"y":76,"Y":188,"W":113,"V":152,"T":152," ":37}},"M":{"d":"145,0r0,-1466r443,0r266,1000r263,-1000r444,0r0,1466r-275,0r0,-1154r-291,1154r-285,0r-290,-1154r0,1154r-275,0","w":1706},"N":{"d":"152,0r0,-1466r288,0r600,979r0,-979r275,0r0,1466r-297,0r-591,-956r0,956r-275,0","w":1479},"O":{"d":"802,25v-441,0,-713,-297,-713,-749v0,-267,71,-440,203,-577v120,-125,278,-189,506,-190v441,-3,713,302,713,760v0,455,-270,756,-709,756xm801,-1238v-271,0,-407,200,-407,504v0,298,144,506,407,506v265,0,404,-207,404,-510v0,-304,-133,-500,-404,-500","w":1593},"P":{"d":"149,0r0,-1466r475,0v180,0,297,7,352,22v170,45,296,204,296,429v0,248,-136,393,-327,441v-104,26,-340,21,-500,21r0,553r-296,0xm445,-1218r0,416v122,0,338,1,396,-23v71,-30,125,-92,126,-186v2,-108,-74,-179,-166,-197v-52,-10,-254,-10,-356,-10","w":1366,"k":{"A":152,".":264,",":264," ":37}},"Q":{"d":"1510,-733v-3,246,-58,406,-181,547v73,52,152,93,237,124r-109,209v-159,-57,-122,-51,-328,-185v-96,42,-202,63,-319,63v-456,2,-721,-292,-721,-758v0,-462,266,-758,713,-758v444,0,714,298,708,758xm394,-733v0,303,135,512,397,512v43,0,83,-7,121,-21v-60,-39,-121,-70,-183,-92r83,-169v97,33,190,83,279,150v76,-89,112,-216,114,-380v4,-305,-135,-505,-405,-505v-268,0,-406,202,-406,505","w":1593},"R":{"d":"1349,-1055v0,243,-154,378,-387,408v169,104,202,162,327,361r179,286r-354,0r-214,-319v-76,-114,-127,-186,-156,-215v-63,-65,-105,-77,-238,-78r-60,0r0,612r-296,0r0,-1466r623,0v286,3,406,23,512,180v45,66,64,144,64,231xm446,-846r219,0v142,0,231,-6,266,-18v68,-23,113,-82,113,-172v0,-103,-60,-164,-151,-177v-61,-9,-335,-4,-447,-5r0,372","w":1479,"k":{"Y":76,"W":37,"V":37}},"S":{"d":"928,-1034v-26,-149,-97,-211,-269,-212v-86,0,-153,18,-202,53v-61,43,-62,133,-3,180v38,30,128,64,272,98v144,34,251,69,320,105v131,70,227,189,220,383v-10,308,-243,453,-587,453v-370,0,-565,-175,-605,-503r288,-28v32,180,123,276,320,281v161,4,288,-72,288,-202v0,-91,-54,-121,-137,-152v-35,-12,-114,-33,-237,-64v-159,-39,-269,-89,-334,-145v-144,-125,-181,-336,-72,-505v86,-132,251,-199,472,-199v337,0,546,149,562,444","w":1366},"T":{"d":"479,0r0,-1218r-435,0r0,-248r1165,0r0,248r-434,0r0,1218r-296,0","w":1251,"k":{"y":152,"w":152,"u":152,"s":152,"r":113,"o":152,"i":37,"e":152,"c":152,"a":152,"O":37,"A":152,";":227,":":227,".":227,"-":113,",":227}},"U":{"d":"147,-1466r296,0r0,794v0,126,4,208,11,245v27,124,128,199,286,199v151,0,245,-65,267,-178v10,-50,13,-133,13,-249r0,-811r296,0r0,770v-5,300,4,416,-112,557v-92,112,-238,164,-455,164v-252,0,-388,-52,-490,-175v-115,-138,-112,-261,-112,-534r0,-782","w":1479},"V":{"d":"523,0r-524,-1466r321,0r371,1085r359,-1085r314,0r-525,1466r-316,0","w":1366,"k":{"y":76,"u":76,"r":113,"o":152,"i":37,"e":113,"a":113,"A":152,";":113,":":113,".":188,"-":113,",":188}},"W":{"d":"357,0r-350,-1466r303,0r221,1007r268,-1007r352,0r257,1024r225,-1024r298,0r-356,1466r-314,0r-292,-1096r-291,1096r-321,0","w":1933,"k":{"y":37,"u":37,"r":37,"o":37,"i":18,"e":37,"a":76,"A":113,";":37,":":37,".":113,"-":41,",":113}},"X":{"d":"0,0r501,-765r-454,-701r346,0r294,471r288,-471r343,0r-456,712r501,754r-357,0r-325,-507r-326,507r-355,0","w":1366},"Y":{"d":"534,0r0,-617r-537,-849r347,0r345,580r338,-580r341,0r-539,851r0,615r-295,0","w":1366,"k":{"v":113,"u":113,"q":152,"p":113,"o":152,"i":76,"e":113,"a":113,"A":188,";":152,":":152,".":227,"-":113,",":227," ":37}},"Z":{"d":"22,0r0,-267r770,-951r-683,0r0,-248r1073,0r0,230r-803,989r834,0r0,247r-1191,0","w":1251},"[":{"d":"146,413r0,-1879r498,0r0,221r-231,0r0,1437r231,0r0,221r-498,0","w":682},"\\":{"d":"-3,-1491r207,0r367,1516r-211,0","w":569},"]":{"d":"536,-1466r0,1879r-498,0r0,-221r231,0r0,-1439r-231,0r0,-219r498,0","w":682},"^":{"d":"115,-692r376,-799r223,0r366,799r-284,0r-198,-489r-197,489r-286,0","w":1196},"_":{"d":"-19,405r0,-182r1168,0r0,182r-1168,0"},"`":{"d":"495,-1192r-177,0r-276,-299r315,0","w":682},"a":{"d":"542,-871v-113,2,-152,42,-185,133r-255,-46v62,-210,185,-301,460,-302v214,-1,343,43,410,158v61,104,32,401,34,579v2,181,9,232,64,349r-278,0v-9,-19,-27,-86,-37,-116v-84,81,-182,137,-329,140v-204,5,-353,-124,-353,-314v0,-231,163,-293,387,-334v131,-24,222,-48,273,-69v4,-139,-44,-180,-191,-178xm409,-418v-113,78,-31,244,101,244v89,0,190,-65,212,-143v8,-27,12,-129,11,-193v-54,22,-281,62,-324,92"},"b":{"d":"728,24v-147,0,-263,-80,-332,-180r0,156r-261,0r0,-1466r281,0r0,528v87,-99,189,-148,308,-148v283,0,448,228,448,544v0,321,-166,566,-444,566xm649,-871v-156,0,-235,132,-235,317v0,212,81,356,246,356v152,0,224,-139,224,-330v0,-206,-67,-343,-235,-343","w":1251},"c":{"d":"85,-530v0,-336,191,-557,515,-556v272,1,409,120,473,338r-277,50v-17,-103,-79,-167,-192,-167v-166,0,-230,118,-230,315v0,215,58,345,234,345v129,0,179,-74,203,-202r276,47v-55,242,-206,383,-492,384v-319,1,-510,-223,-510,-554"},"d":{"d":"84,-535v0,-324,161,-551,448,-551v119,0,221,49,308,148r0,-528r281,0r0,1466r-261,0r0,-156v-71,103,-184,180,-332,180v-271,0,-444,-248,-444,-559xm606,-871v-154,0,-235,135,-235,317v0,113,16,195,47,246v45,73,109,110,190,110v153,0,233,-143,233,-329v0,-207,-67,-344,-235,-344","w":1251},"e":{"d":"583,-186v104,0,153,-59,179,-152r280,47v-67,193,-214,312,-462,315v-330,4,-515,-217,-515,-547v0,-325,188,-563,487,-563v349,0,519,245,505,636r-704,0v0,152,90,264,230,264xm778,-622v0,-145,-80,-249,-209,-249v-130,0,-216,108,-211,249r420,0"},"f":{"d":"575,-1275v-91,0,-113,38,-114,138r0,75r210,0r0,221r-210,0r0,841r-281,0r0,-841r-156,0r0,-221r156,0r0,-80v-10,-252,98,-349,327,-349v80,0,158,12,235,36r-38,196v-45,-11,-88,-16,-129,-16","w":682,"k":{"\u2019":-37}},"g":{"d":"1120,-109v11,395,-134,540,-504,540v-180,0,-308,-31,-383,-93v-84,-70,-120,-148,-112,-268r321,39v13,89,63,107,163,107v174,0,241,-44,234,-233r0,-155v-84,115,-190,172,-318,172v-266,0,-437,-244,-437,-537v0,-320,166,-549,448,-549v131,0,240,58,325,173r0,-149r263,0r0,953xm604,-871v-157,0,-232,132,-232,318v0,191,71,326,227,326v157,0,245,-135,245,-319v0,-192,-78,-325,-240,-325","w":1251},"h":{"d":"658,-871v-181,0,-231,128,-231,339r0,532r-281,0r0,-1466r281,0r0,539v124,-150,311,-207,500,-123v156,70,186,187,186,427r0,623r-281,0r0,-561v-5,-179,8,-222,-72,-283v-26,-19,-61,-27,-102,-27","w":1251},"i":{"d":"147,-1206r0,-260r281,0r0,260r-281,0xm147,0r0,-1062r281,0r0,1062r-281,0","w":569},"j":{"d":"141,-1206r0,-260r281,0r0,260r-281,0xm-45,161v72,21,160,4,177,-54v5,-18,9,-69,9,-156r0,-1013r281,0r0,1029v-5,237,-4,331,-128,417v-94,65,-267,54,-388,17","w":569},"k":{"d":"137,0r0,-1466r281,0r0,778r329,-374r346,0r-363,388r389,674r-303,0r-267,-477r-131,137r0,340r-281,0"},"l":{"d":"147,0r0,-1466r281,0r0,1466r-281,0","w":569},"m":{"d":"1016,-917v80,-96,173,-169,324,-169v162,0,269,70,319,187v19,45,29,119,29,220r0,679r-281,0r0,-607v0,-105,-10,-173,-29,-204v-44,-73,-160,-78,-231,-24v-86,65,-98,153,-98,325r0,510r-281,0r0,-582v-4,-161,6,-213,-62,-267v-51,-40,-150,-26,-202,13v-86,66,-97,145,-97,320r0,516r-281,0r0,-1062r259,0r0,145v93,-113,203,-169,331,-169v150,0,242,65,300,169","w":1821},"n":{"d":"1113,0r-281,0r0,-542v-4,-185,6,-238,-76,-301v-62,-48,-168,-34,-229,12v-99,76,-101,146,-101,350r0,481r-281,0r0,-1062r261,0r0,156v122,-163,317,-230,520,-146v149,61,187,173,187,392r0,660","w":1251},"o":{"d":"631,24v-335,-9,-557,-212,-549,-570v7,-316,219,-536,547,-540v315,-3,549,239,549,552v0,313,-237,566,-547,558xm630,-857v-163,0,-260,139,-260,326v0,188,96,326,260,326v164,0,259,-139,259,-328v0,-186,-96,-324,-259,-324","w":1251},"p":{"d":"730,24v-152,0,-219,-61,-310,-155r0,535r-281,0r0,-1466r262,0r0,156v61,-97,180,-182,331,-180v271,3,443,241,443,549v0,315,-170,561,-445,561xm656,-864v-157,0,-239,133,-239,315v0,203,79,350,244,350v161,0,228,-136,228,-336v0,-191,-75,-329,-233,-329","w":1251},"q":{"d":"542,-1086v162,0,249,74,321,181r0,-157r259,0r0,1466r-281,0r0,-534v-65,85,-174,154,-314,154v-284,0,-436,-263,-436,-567v0,-310,173,-543,451,-543xm607,-198v155,0,243,-153,243,-346v0,-188,-76,-322,-233,-322v-163,0,-239,139,-239,338v0,198,70,330,229,330","w":1251},"r":{"d":"396,-911v75,-112,105,-175,242,-175v64,0,126,18,185,53r-87,245v-78,-52,-162,-66,-232,-14v-28,21,-48,62,-64,118v-31,106,-23,491,-24,684r-281,0r0,-1062r261,0r0,151","w":797,"k":{"\u2019":-76,".":113,",":113}},"s":{"d":"1040,-332v0,227,-210,356,-483,356v-277,0,-453,-118,-509,-327r282,-43v25,109,94,168,227,167v107,-1,201,-22,201,-115v0,-66,-39,-72,-114,-90v-226,-53,-370,-96,-431,-137v-84,-57,-126,-137,-126,-239v0,-217,185,-326,447,-326v276,0,407,82,470,281r-265,49v-25,-86,-86,-129,-200,-128v-74,0,-127,10,-159,31v-40,26,-44,80,-4,108v25,19,112,45,262,79v150,34,255,75,314,125v59,50,88,120,88,209"},"t":{"d":"634,-1062r0,224r-192,0r0,428v6,128,-14,146,30,187v52,28,88,10,161,-13r24,218v-134,63,-381,60,-449,-50v-51,-83,-48,-138,-48,-307r0,-463r-129,0r0,-224r129,0r0,-211r282,-164r0,375r192,0","w":682},"u":{"d":"494,24v-242,0,-353,-143,-353,-414r0,-672r281,0r0,488v0,149,8,240,16,274v25,111,196,143,289,70v110,-87,99,-136,99,-384r0,-448r281,0r0,1062r-261,0r0,-159v-67,101,-197,183,-352,183","w":1251},"v":{"d":"439,0r-428,-1062r295,0r200,542r58,181r59,-181r202,-542r289,0r-422,1062r-253,0","k":{".":152,",":152}},"w":{"d":"345,0r-336,-1062r273,0r199,696r183,-696r271,0r177,696r203,-696r277,0r-341,1062r-270,0r-183,-683r-180,683r-273,0","w":1593,"k":{".":76,",":76}},"x":{"d":"12,0r383,-547r-367,-515r343,0r188,292r198,-292r330,0r-360,503r393,559r-345,0r-216,-329r-218,329r-329,0"},"y":{"d":"14,-1062r299,0r254,754r248,-754r291,0r-442,1207v-67,184,-160,282,-398,286v-54,0,-107,-6,-159,-17r-25,-220v105,22,212,21,264,-44v31,-39,55,-88,72,-147","k":{".":152,",":152}},"z":{"d":"34,0r0,-219r398,-457v65,-75,114,-128,145,-159v-33,2,-76,3,-129,4r-375,2r0,-233r878,0r0,199r-406,468r-143,155v219,-15,365,-4,580,-7r0,247r-948,0","w":1024},"{":{"d":"539,46v4,139,50,143,205,145r0,240v-244,9,-397,-37,-448,-217v-21,-76,-13,-409,-33,-470v-35,-105,-76,-146,-203,-154r0,-240v200,-11,219,-134,219,-356v0,-215,-4,-301,83,-394v73,-78,202,-98,382,-91r0,239v-155,2,-199,2,-204,138v-2,63,-6,326,-35,400v-36,92,-70,129,-153,184v122,71,172,174,180,364v5,111,7,181,7,212","w":797},"|":{"d":"176,431r0,-1922r223,0r0,1922r-223,0","w":573},"}":{"d":"98,-1491v323,-4,412,112,412,448v0,122,5,202,15,239v31,106,77,146,204,154r0,240v-142,2,-189,70,-211,189v-16,88,-9,382,-26,437v-33,110,-89,161,-202,197v-45,14,-156,19,-245,18r0,-240v114,-2,152,-1,189,-53v12,-16,15,-45,16,-86v2,-64,6,-329,35,-400v34,-84,77,-138,152,-182v-104,-66,-148,-127,-172,-262v-8,-46,-13,-149,-16,-308v-2,-151,-42,-148,-204,-152r0,-239r53,0","w":797},"~":{"d":"1129,-654v-75,77,-238,164,-397,120v-77,-21,-311,-124,-392,-124v-93,0,-184,46,-273,139r0,-259v111,-119,237,-159,412,-126v48,9,319,129,377,124v111,-9,204,-67,273,-144r0,270","w":1196},"\u00a9":{"d":"-9,-730v0,-439,325,-766,766,-766v440,0,766,327,766,766v0,440,-325,766,-766,766v-440,0,-766,-325,-766,-766xm1372,-730v0,-352,-261,-615,-615,-615v-354,0,-615,262,-615,615v0,353,262,615,615,615v353,0,615,-262,615,-615xm751,-445v111,0,162,-68,192,-171r161,54v-44,152,-156,259,-336,260v-235,2,-390,-173,-387,-421v4,-257,137,-431,389,-431v186,0,279,92,334,243r-162,38v-32,-84,-79,-139,-178,-139v-142,0,-207,115,-207,283v0,164,63,284,194,284","w":1509},"\u2122":{"d":"469,-647r0,-677r-253,0r0,-142r665,0r0,142r-246,0r0,677r-166,0xm980,-647r0,-819r259,0r149,564r150,-564r259,0r0,819r-158,0r0,-653r-177,653r-150,0r-176,-653r0,653r-156,0","w":2048},"\u00ab":{"d":"633,-983r-260,451r260,462r-221,0r-316,-462r316,-451r221,0xm1025,-983r-259,451r259,462r-221,0r-316,-462r316,-451r221,0"},"\u00bb":{"d":"498,-70r260,-452r-260,-461r221,0r316,461r-316,452r-221,0xm106,-70r260,-452r-260,-461r221,0r316,461r-316,452r-221,0"},"\u2019":{"d":"140,-1462r281,0v-2,129,8,302,-21,393v-32,104,-120,178,-228,215r-55,-116v105,-36,154,-85,159,-211r-136,0r0,-281","w":569,"k":{"\u2019":76,"s":76," ":113}},"\u2190":{"d":"79,-543v166,-77,270,-179,413,-333r76,0v-85,166,-86,169,-195,309r1595,0r0,101r-1595,0v69,72,135,175,198,309r-78,0v-148,-163,-239,-251,-414,-341r0,-45","w":2048},"\u2192":{"d":"1968,-498v-174,89,-267,179,-414,341r-77,0v63,-134,128,-237,197,-309r-1595,0r0,-101r1595,0v-109,-140,-110,-143,-195,-309r76,0v145,156,246,254,413,333r0,45","w":2048},"\u0401":{"d":"356,-1550r0,-241r241,0r0,241r-241,0xm786,-1550r0,-241r242,0r0,241r-242,0xm149,0r0,-1466r1087,0r0,248r-791,0r0,325r736,0r0,247r-736,0r0,399r819,0r0,247r-1115,0","w":1370},"\u0404":{"d":"1073,-994v-35,-139,-153,-239,-314,-241v-219,-3,-338,178,-358,381r460,0r0,246r-460,0v25,224,130,382,341,382v194,0,309,-127,331,-312r297,92v-64,281,-269,471,-609,471v-326,0,-520,-182,-610,-397v-44,-104,-63,-222,-63,-353v0,-439,248,-766,679,-766v325,0,538,169,599,430","w":1457},"\u0406":{"d":"140,0r0,-1466r296,0r0,1466r-296,0","w":569},"\u0407":{"d":"-54,-1550r0,-241r241,0r0,241r-241,0xm376,-1550r0,-241r242,0r0,241r-242,0xm140,0r0,-1466r296,0r0,1466r-296,0","w":565},"\u0410":{"d":"1471,0r-322,0r-128,-333r-586,0r-121,333r-314,0r571,-1466r313,0xm926,-580r-202,-544r-198,544r400,0","w":1479,"k":{"\u044d":-25,"\u0442":27,"\u0441":27,"\u0431":27,"\u0430":-25,"\u042d":51,"\u0427":156,"\u0424":51,"\u0423":78,"\u0422":102,"\u0421":51,"\u041f":27,"\u041e":27,"\u041b":-25,"\u0414":-76,"\u2019":104}},"\u0411":{"d":"155,-1466r1096,0r0,246r-800,0r0,340v226,6,503,-21,668,40v139,51,261,209,261,401v0,192,-122,348,-252,400v-66,26,-160,39,-281,39r-692,0r0,-1466xm1072,-439v-7,-166,-122,-195,-320,-195r-301,0r0,388v146,-2,374,9,482,-14v73,-16,143,-87,139,-179","w":1472,"k":{"\u0443":27,"\u042f":51,"\u042d":51,"\u042a":78,"\u0427":78,"\u0425":51,"\u0424":27,"\u0423":51,"\u0422":51,"\u0421":27,"\u041b":51,"\u0417":27,"\u0416":51,"\u0410":78}},"\u0412":{"d":"1100,-779v161,44,278,166,278,354v0,231,-146,394,-372,415v-163,15,-624,9,-856,10r0,-1466r586,0v288,-6,422,33,525,198v31,50,45,108,45,171v-1,151,-93,269,-206,318xm446,-1222r0,339r194,0v115,0,187,-2,215,-5v94,-10,163,-67,163,-167v-1,-97,-57,-151,-149,-162v-39,-5,-315,-5,-423,-5xm446,-639r0,392r274,0v107,0,174,-3,203,-9v87,-16,151,-79,149,-183v-1,-95,-50,-152,-124,-179v-74,-26,-359,-20,-502,-21","w":1479,"k":{"\u0447":78,"\u0445":27,"\u0442":27,"\u042f":51,"\u042a":102,"\u0427":78,"\u0425":78,"\u0424":51,"\u0423":78,"\u0422":78,"\u0421":78,"\u041e":51,"\u041b":51,"\u0417":27,"\u0416":78,"\u0414":27,"\u0410":102}},"\u0413":{"d":"164,-1466r993,0r0,246r-697,0r0,1220r-296,0r0,-1466","w":1161,"k":{"\u044f":78,"\u044e":78,"\u044c":78,"\u044b":78,"\u0443":78,"\u0440":78,"\u043e":102,"\u043d":51,"\u043c":78,"\u043b":102,"\u0438":51,"\u0435":104,"\u0434":78,"\u0432":51,"\u0430":27,"\u0421":27,"\u041e":27,"\u041b":51,"\u0414":51,"\u0410":129,"\u00bb":78,"\u00ab":78,";":27,":":27,".":256,",":231}},"\u0414":{"d":"118,-246v154,-314,147,-721,149,-1220r1013,0r0,1220r129,0r0,566r-246,0r0,-320r-923,0r0,320r-246,0r0,-566r124,0xm549,-1220v0,445,-40,770,-121,974r557,0r0,-974r-436,0","w":1459,"k":{"\u0443":-25,"\u043e":-25,"\u0437":-51,"\u0435":-25,"\u0427":27,"\u0424":27,"\u0423":-25,"\u0417":-25}},"\u0415":{"d":"149,0r0,-1466r1087,0r0,248r-791,0r0,325r736,0r0,247r-736,0r0,399r819,0r0,247r-1115,0","w":1366},"\u0416":{"d":"1070,-1466r0,624v49,-4,87,-22,112,-55v25,-33,60,-107,105,-224v59,-153,120,-249,180,-292v64,-46,199,-64,346,-63r0,219v-124,-6,-200,14,-243,90v-25,44,-91,249,-136,316v-22,33,-58,66,-111,96v168,58,218,179,305,353r200,402r-348,0r-176,-379v-37,-70,-106,-205,-145,-234v-25,-18,-54,-29,-89,-29r0,642r-289,0r0,-642v-112,11,-119,56,-180,163v-86,151,-153,319,-230,479r-348,0v106,-202,217,-469,339,-638v43,-59,100,-98,167,-117v-105,-58,-129,-110,-171,-223v-35,-93,-60,-155,-76,-187v-40,-79,-114,-98,-244,-92r0,-219v150,-1,285,17,349,64v59,44,119,140,177,291v45,117,81,193,106,225v25,32,62,50,111,54r0,-624r289,0","w":1851,"k":{"\u043e":27,"\u0430":-25,"\u042a":-76,"\u0427":-25,"\u0423":-51,"\u0422":-51,"\u0421":51,"\u041e":27,"\u0417":-25}},"\u0417":{"d":"822,-1060v0,-117,-95,-190,-226,-190v-124,0,-203,61,-238,184r-288,-67v62,-239,238,-358,529,-358v172,0,301,37,389,113v88,76,132,165,132,267v0,173,-107,266,-240,338v172,59,292,161,292,367v0,291,-232,437,-565,431v-332,-6,-477,-95,-563,-363r271,-89v48,154,113,204,283,210v159,6,268,-72,268,-199v0,-162,-163,-212,-358,-200r0,-221v183,10,314,-63,314,-223","w":1283,"k":{"\u042f":51,"\u0427":78,"\u0424":51,"\u0423":78,"\u0422":78,"\u0421":51,"\u041e":27,"\u041b":51,"\u0416":51}},"\u0418":{"d":"153,-1466r277,0r0,976r594,-976r295,0r0,1466r-277,0r0,-957r-593,957r-296,0r0,-1466","w":1472},"\u0419":{"d":"738,-1687v108,0,165,-48,175,-144r137,0v-13,173,-130,291,-312,291v-182,0,-299,-118,-312,-291r137,0v10,96,67,144,175,144xm153,-1466r277,0r0,976r594,-976r295,0r0,1466r-277,0r0,-957r-593,957r-296,0r0,-1466","w":1472},"\u041a":{"d":"154,-1466r296,0r0,624v66,-7,111,-24,134,-51v23,-27,59,-103,108,-228v61,-159,124,-256,185,-296v65,-43,198,-60,340,-59r0,219v-125,-6,-200,14,-243,90v-25,44,-91,249,-136,316v-22,33,-58,66,-111,96v66,19,121,56,163,113v120,163,238,443,342,642r-348,0r-175,-379v-38,-69,-107,-208,-147,-235v-25,-17,-62,-27,-112,-28r0,642r-296,0r0,-1466","w":1250,"k":{"\u0441":27,"\u0437":-25,"\u0430":-25,"\u042d":-25,"\u0427":-51,"\u0424":27,"\u0423":-51,"\u0422":-51,"\u0421":27,"\u0417":-76}},"\u041b":{"d":"98,-229v129,-4,157,-15,157,-148r-1,-1089r1027,0r0,1466r-296,0r0,-1218r-441,0r0,626v0,179,-5,305,-18,376v-27,150,-116,227,-305,225v-35,0,-98,-3,-189,-10r0,-229","w":1437,"k":{"\u0430":-51}},"\u041c":{"d":"145,0r0,-1466r443,0r266,1000r263,-1000r444,0r0,1466r-275,0r0,-1154r-291,1154r-285,0r-290,-1154r0,1154r-275,0","w":1706,"k":{"\u0447":27,"\u0441":27,"\u0430":-25}},"\u041d":{"d":"150,0r0,-1466r296,0r0,577r580,0r0,-577r296,0r0,1466r-296,0r0,-641r-580,0r0,641r-296,0","w":1479},"\u041e":{"d":"802,25v-441,0,-713,-297,-713,-749v0,-267,71,-440,203,-577v120,-125,278,-189,506,-190v441,-3,713,302,713,760v0,455,-270,756,-709,756xm801,-1238v-271,0,-407,200,-407,504v0,298,144,506,407,506v265,0,404,-207,404,-510v0,-304,-133,-500,-404,-500","w":1593,"k":{"\u043b":27,"\u0434":51,"\u042f":27,"\u0425":78,"\u0423":51,"\u041b":51,"\u0416":27,"\u0414":27,"\u0410":51}},"\u041f":{"d":"153,-1466r1166,0r0,1466r-296,0r0,-1220r-574,0r0,1220r-296,0r0,-1466","w":1472},"\u0420":{"d":"149,0r0,-1466r475,0v180,0,297,7,352,22v170,45,296,204,296,429v0,248,-136,393,-327,441v-104,26,-340,21,-500,21r0,553r-296,0xm445,-1218r0,416v122,0,338,1,396,-23v71,-30,125,-92,126,-186v2,-108,-74,-179,-166,-197v-52,-10,-254,-10,-356,-10","w":1366,"k":{"\u044f":27,"\u043e":51,"\u0435":51,"\u0434":129,"\u0430":27,"\u042f":51,"\u0425":78,"\u0424":27,"\u0423":27,"\u0422":27,"\u0421":51,"\u041e":27,"\u041c":27,"\u041b":129,"\u0417":27,"\u0416":27,"\u0414":129,"\u0410":180,";":27,":":27,".":307,",":283}},"\u0421":{"d":"762,-228v190,0,285,-128,325,-311r287,91v-80,294,-263,470,-609,473v-405,3,-668,-314,-668,-745v0,-458,256,-771,686,-771v308,0,518,156,587,429r-293,70v-30,-142,-144,-246,-309,-246v-256,0,-366,193,-366,496v0,185,33,317,100,396v67,79,153,118,260,118","w":1479,"k":{"\u0447":27,"\u0444":27,"\u0441":27,"\u0436":-25,"\u0431":27,"\u0430":-25,"\u042d":27,"\u042a":27,"\u0427":51,"\u0425":78,"\u0423":27,"\u0422":51,"\u041e":51,"\u041c":27,"\u041b":51,"\u0417":27,"\u0414":27,"\u0410":51}},"\u0422":{"d":"479,0r0,-1218r-435,0r0,-248r1165,0r0,248r-434,0r0,1218r-296,0","w":1251,"k":{"\u044f":51,"\u044e":27,"\u044c":27,"\u044b":27,"\u0449":27,"\u0445":78,"\u0443":78,"\u0441":129,"\u0440":78,"\u043f":27,"\u043e":129,"\u043c":104,"\u043b":129,"\u043a":78,"\u0438":78,"\u0435":102,"\u0432":78,"\u0430":51,"\u042f":27,"\u0424":78,"\u041e":51,"\u041b":51,"\u0416":-51,"\u0414":51,"\u0410":129,"\u00ab":51,";":27,":":27,".":231,",":205}},"\u0423":{"d":"0,-1466r331,0r342,761r292,-761r309,0r-495,1114v-54,121,-109,213,-165,276v-56,63,-128,94,-217,94v-87,0,-156,-6,-205,-17r0,-220v99,7,214,10,262,-33v29,-26,58,-79,85,-162","w":1274,"k":{"\u044f":102,"\u044e":78,"\u0449":78,"\u0448":78,"\u0446":78,"\u0445":51,"\u0441":129,"\u0440":78,"\u043f":78,"\u043e":129,"\u043d":78,"\u043c":102,"\u043b":129,"\u043a":78,"\u0439":78,"\u0438":78,"\u0437":102,"\u0436":27,"\u0435":129,"\u0434":129,"\u0433":78,"\u0432":78,"\u0431":51,"\u042f":51,"\u042d":27,"\u0424":78,"\u041e":51,"\u041b":78,"\u0414":104,"\u0410":154,"\u00bb":78,"\u00ab":78,";":51,":":51,".":256,",":231}},"\u0424":{"d":"89,-746v0,-378,231,-565,640,-574r0,-145r290,0r0,145v233,9,396,68,495,172v191,199,191,604,0,804v-99,104,-262,164,-495,173r0,171r-290,0r0,-171v-234,-9,-399,-66,-495,-173v-96,-107,-145,-241,-145,-402xm1019,-418v227,-9,353,-89,353,-337v0,-212,-118,-318,-353,-318r0,655xm729,-1073v-243,0,-353,102,-353,336v0,213,118,319,353,319r0,-655","w":1748,"k":{"\u043b":51,"\u042f":53,"\u0427":27,"\u0424":27,"\u0423":78,"\u0422":78,"\u041b":78,"\u0414":104,"\u0410":51}},"\u0425":{"d":"0,0r501,-765r-454,-701r346,0r294,471r288,-471r343,0r-456,712r501,754r-357,0r-325,-507r-326,507r-355,0","w":1366,"k":{"\u0443":27,"\u043e":27,"\u042d":51,"\u0424":78,"\u0421":78,"\u041e":53,"\u0417":27}},"\u0426":{"d":"154,-1466r296,0r0,1220r574,0r0,-1220r296,0r0,1220r122,0r0,566r-246,0r0,-320r-1042,0r0,-1466","w":1496,"k":{"\u043e":-25,"\u0435":-25,"\u0430":-76}},"\u0427":{"d":"987,-590v-203,104,-535,113,-715,-22v-96,-72,-147,-189,-147,-359r0,-495r296,0r0,350v7,200,-19,251,87,322v118,79,387,42,479,-40r0,-632r296,0r0,1466r-296,0r0,-590","w":1439},"\u0428":{"d":"154,-1466r296,0r0,1220r424,0r0,-1220r295,0r0,1220r438,0r0,-1220r295,0r2,1467r-1750,-1r0,-1466","w":2058},"\u0429":{"d":"154,-1466r296,0r0,1220r424,0r0,-1220r295,0r0,1220r438,0r0,-1220r295,0r0,1220r132,0r0,566r-246,0r0,-320r-1634,0r0,-1466","w":2087,"k":{"\u0430":-25}},"\u042a":{"d":"26,-1466r733,0r0,586v228,6,496,-21,664,42v141,53,263,209,263,402v0,191,-121,349,-251,399v-65,25,-158,37,-280,37r-692,0r0,-1220r-437,0r0,-246xm1380,-439v-8,-164,-119,-195,-320,-195r-301,0r0,388v147,-2,372,10,481,-14v74,-16,144,-86,140,-179","w":1781,"k":{"\u042f":78,"\u2019":205}},"\u042b":{"d":"157,-1466r296,0r0,586v229,6,496,-22,665,42v141,54,262,212,262,404v0,188,-124,352,-252,399v-64,23,-156,35,-279,35r-692,0r0,-1466xm1074,-438v-9,-164,-118,-196,-320,-196r-301,0r0,388v145,-2,374,9,481,-14v71,-15,145,-88,140,-178xm1551,-1466r296,0r0,1466r-296,0r0,-1466","w":2005},"\u042c":{"d":"847,-880v331,-10,521,164,531,445v6,191,-120,346,-250,397v-65,25,-158,38,-281,38r-692,0r0,-1466r296,0r0,586r396,0xm1072,-439v-7,-165,-123,-195,-320,-195r-301,0r0,388v145,-2,376,9,482,-14v71,-16,143,-88,139,-179","w":1472,"k":{"\u042f":78,"\u042d":78,"\u0427":154,"\u0425":104,"\u0422":207,"\u0421":51,"\u041e":27,"\u041c":51,"\u041b":78,"\u0417":51,"\u0416":78,"\u0414":27,"\u0410":51,"\u2019":154}},"\u042d":{"d":"384,-538v23,190,139,312,330,312v211,0,316,-157,342,-382r-460,0r0,-246r460,0v-22,-203,-139,-381,-358,-381v-168,0,-274,107,-314,241r-293,-67v59,-259,274,-430,598,-430v432,0,680,329,680,766v0,311,-122,538,-313,658v-97,61,-215,92,-352,92v-334,0,-540,-157,-617,-471","w":1457,"k":{"\u043b":51,"\u0436":-25,"\u0434":27,"\u042f":51,"\u0425":51,"\u0424":27,"\u041b":78,"\u0417":27,"\u0416":51,"\u0414":51}},"\u042e":{"d":"1355,-1491v425,6,661,302,661,756v0,315,-112,538,-298,667v-164,114,-524,118,-698,25v-170,-91,-319,-318,-336,-565r-238,0r0,608r-296,0r0,-1466r296,0r0,612r238,0v37,-361,258,-643,671,-637xm1712,-748v0,-296,-120,-486,-372,-486v-106,0,-193,39,-260,118v-67,79,-100,208,-100,385v0,291,108,509,370,509v275,0,362,-217,362,-526","w":2112,"k":{"\u043b":51,"\u0436":-25,"\u0434":51,"\u0427":27,"\u0425":78,"\u0422":51,"\u0421":27,"\u041b":78,"\u0416":51,"\u0414":51,"\u0410":51}},"\u042f":{"d":"510,-647v-241,-33,-382,-167,-387,-407v-4,-181,104,-333,245,-376v74,-23,184,-36,331,-36r623,0r0,1466r-296,0r0,-612v-102,-3,-216,6,-258,42v-100,85,-304,419,-410,570r-354,0r179,-286v127,-195,159,-259,327,-361xm1026,-1218r-231,0v-196,8,-245,-20,-327,62v-55,55,-55,187,-2,242v81,84,140,68,341,68r219,0r0,-372","w":1472},"\u0430":{"d":"542,-871v-113,2,-152,42,-185,133r-255,-46v62,-210,185,-301,460,-302v214,-1,343,43,410,158v61,104,32,401,34,579v2,181,9,232,64,349r-278,0v-9,-19,-27,-86,-37,-116v-84,81,-182,137,-329,140v-204,5,-353,-124,-353,-314v0,-231,163,-293,387,-334v131,-24,222,-48,273,-69v4,-139,-44,-180,-191,-178xm409,-418v-113,78,-31,244,101,244v89,0,190,-65,212,-143v8,-27,12,-129,11,-193v-54,22,-281,62,-324,92","k":{"\u0447":51,"\u0437":-25}},"\u0431":{"d":"92,-744v0,-498,144,-707,631,-716v82,-2,195,21,221,-40r191,0v-24,209,-83,258,-350,258v-111,0,-236,-1,-308,28v-136,55,-194,171,-193,389v75,-143,194,-228,395,-233v274,-7,499,266,499,539v0,299,-238,543,-551,543v-234,0,-413,-126,-480,-302v-36,-94,-55,-249,-55,-466xm631,-836v-152,0,-253,143,-253,313v0,173,96,312,250,314v158,2,258,-144,258,-313v0,-170,-100,-314,-255,-314","w":1265,"k":{"\u044f":27,"\u044d":27,"\u044a":27,"\u0447":51,"\u0445":51,"\u0443":27,"\u0441":27,"\u043c":27,"\u043b":51,"\u0437":27,"\u0436":27,"\u0434":51}},"\u0432":{"d":"1179,-279v0,185,-149,279,-360,279r-669,0r0,-1062r615,0v228,0,373,70,377,277v2,122,-83,217,-181,243v128,27,218,126,218,263xm433,-621v182,-6,427,35,429,-137v0,-45,-18,-76,-54,-96v-64,-36,-256,-27,-375,-28r0,261xm433,-180v182,-12,453,52,452,-133v0,-52,-22,-85,-63,-107v-55,-30,-264,-31,-389,-30r0,270","w":1259,"k":{"\u044f":27,"\u044a":51,"\u0447":78,"\u0444":27,"\u0443":51,"\u0442":27,"\u0441":51,"\u043e":27,"\u043c":27,"\u043b":27,"\u0436":27,"\u0435":27,"\u0431":27,"\u0430":27}},"\u0433":{"d":"136,-1062r717,0r0,227r-436,0r0,835r-281,0r0,-1062","w":853,"k":{"\u0441":27,"\u043e":27,"\u043b":51,"\u0434":78,".":205,",":180}},"\u0434":{"d":"1025,0r-804,0r0,280r-228,0r0,-510r115,0v48,-53,88,-137,119,-250v31,-113,50,-307,56,-582r857,0r0,832r114,0r0,510r-229,0r0,-280xm862,-230r1,-601r-340,0v-11,293,-58,494,-140,601r479,0","w":1300,"k":{"\u044a":27,"\u0443":-25,"\u0441":27,"\u0437":-25}},"\u0435":{"d":"583,-186v104,0,153,-59,179,-152r280,47v-67,193,-214,312,-462,315v-330,4,-515,-217,-515,-547v0,-325,188,-563,487,-563v349,0,519,245,505,636r-704,0v0,152,90,264,230,264xm778,-622v0,-145,-80,-249,-209,-249v-130,0,-216,108,-211,249r420,0","k":{"\u0447":51,"\u0445":27,"\u0443":27,"\u0442":27,"\u0441":27,"\u043c":27,"\u0436":27,"\u0431":27}},"\u0436":{"d":"587,0r0,-453v-37,3,-63,11,-77,25v-14,14,-44,51,-75,121r-134,307r-302,0r150,-293v76,-147,155,-231,237,-252v-61,-23,-105,-85,-141,-181v-52,-139,-37,-148,-210,-152r0,-186v255,-21,326,27,399,240v30,85,54,138,72,160v18,22,45,35,81,36r0,-434r279,0r0,434v36,0,64,-12,82,-35v18,-23,42,-77,71,-161v72,-213,144,-260,399,-240r0,186v-172,4,-158,14,-210,152v-36,96,-80,158,-141,181v82,21,162,105,237,252r150,293r-302,0r-133,-307v-45,-90,-54,-133,-153,-146r0,453r-279,0","w":1452,"k":{"\u0447":51,"\u0441":27,"\u043e":51,"\u0437":-25,"\u0435":27,"\u0430":-25}},"\u0437":{"d":"660,-303v0,-105,-106,-142,-227,-133r0,-183v97,-2,126,-2,169,-55v72,-88,4,-227,-117,-219v-105,7,-141,40,-180,138r-238,-51v40,-178,214,-277,423,-280v227,-4,403,110,403,309v0,138,-80,183,-189,239v137,37,235,107,235,259v0,83,-39,153,-116,213v-77,60,-189,90,-334,90v-253,0,-408,-99,-465,-297r257,-47v41,104,110,156,205,156v94,0,174,-57,174,-139","w":1018,"k":{"\u044a":51,"\u0447":78,"\u0444":27,"\u0443":51,"\u0441":51,"\u043e":51,"\u043c":51,"\u043b":27,"\u0437":27,"\u0436":27,"\u0435":27,"\u0431":51,"\u0430":27}},"\u0438":{"d":"140,-1062r270,0r0,667r432,-667r276,0r0,1062r-270,0r0,-679r-438,679r-270,0r0,-1062","w":1259},"\u0439":{"d":"638,-1349v108,0,165,-48,175,-144r137,0v-13,173,-130,291,-312,291v-182,0,-299,-118,-312,-291r137,0v10,96,67,144,175,144xm140,-1062r270,0r0,667r432,-667r276,0r0,1062r-270,0r0,-679r-438,679r-270,0r0,-1062","w":1259},"\u043a":{"d":"136,-1062r280,0r0,434v47,-5,80,-20,99,-43v19,-23,44,-74,70,-153v69,-210,145,-261,397,-240r1,186v-172,4,-158,14,-209,152v-36,97,-80,158,-141,181v94,21,169,128,236,252r157,293r-302,0r-140,-307v-54,-100,-53,-139,-168,-146r0,453r-280,0r0,-1062","w":1025,"k":{"\u044d":27,"\u0447":27,"\u0444":27,"\u0441":27,"\u043e":27,"\u043b":-25}},"\u043b":{"d":"25,-207v66,-1,167,24,185,-33v9,-25,13,-94,13,-208r0,-614r941,0r0,1062r-280,0r0,-834r-383,0r0,477v3,195,-34,302,-135,352v-81,40,-217,28,-341,5r0,-207","w":1301,"k":{"\u0447":51,"\u0443":27,"\u0441":27,"\u043e":27,"\u0435":27,"\u0431":27}},"\u043c":{"d":"155,-1062r348,0r264,740r266,-740r347,0r0,1062r-239,0r0,-699r-259,699r-240,0r-247,-699r0,699r-240,0r0,-1062","w":1515,"k":{"\u044d":27,"\u0444":27,"\u0443":27,"\u0441":27,"\u043e":27,"\u0437":27,"\u0431":27,"\u0430":27}},"\u043d":{"d":"136,-1062r281,0r0,389r402,0r0,-389r282,0r0,1062r-282,0r0,-446r-402,0r0,446r-281,0r0,-1062","w":1237},"\u043e":{"d":"631,24v-335,-9,-557,-212,-549,-570v7,-316,219,-536,547,-540v315,-3,549,239,549,552v0,313,-237,566,-547,558xm630,-857v-163,0,-260,139,-260,326v0,188,96,326,260,326v164,0,259,-139,259,-328v0,-186,-96,-324,-259,-324","w":1251,"k":{"\u044f":27,"\u044d":27,"\u0447":51,"\u0445":51,"\u0443":27,"\u0442":51,"\u0441":27,"\u043c":27,"\u043b":51,"\u0437":27,"\u0436":27,"\u0434":27}},"\u043f":{"d":"136,-1062r943,0r0,1062r-281,0r0,-835r-381,0r0,835r-281,0r0,-1062","w":1237},"\u0440":{"d":"730,24v-152,0,-219,-61,-310,-155r0,535r-281,0r0,-1466r262,0r0,156v61,-97,180,-182,331,-180v271,3,443,241,443,549v0,315,-170,561,-445,561xm656,-864v-157,0,-239,133,-239,315v0,203,79,350,244,350v161,0,228,-136,228,-336v0,-191,-75,-329,-233,-329","w":1251,"k":{"\u044f":27,"\u044d":27,"\u0447":51,"\u0445":27,"\u0443":27,"\u0442":27,"\u043c":27,"\u043b":51,"\u0437":27,"\u0436":27,"\u0434":51}},"\u0441":{"d":"85,-530v0,-336,191,-557,515,-556v272,1,409,120,473,338r-277,50v-17,-103,-79,-167,-192,-167v-166,0,-230,118,-230,315v0,215,58,345,234,345v129,0,179,-74,203,-202r276,47v-55,242,-206,383,-492,384v-319,1,-510,-223,-510,-554","k":{"\u044a":27,"\u0447":53,"\u0445":27,"\u0431":27,"\u0430":-25}},"\u0442":{"d":"21,-1062r961,0r0,227r-340,0r0,835r-281,0r0,-835r-340,0r0,-227","w":1003,"k":{"\u0443":-51,"\u0441":27,"\u043e":27,"\u043b":27,"\u0436":-25,"\u0434":27,".":180,",":154}},"\u0443":{"d":"14,-1062r299,0r254,754r248,-754r291,0r-442,1207v-67,184,-160,282,-398,286v-54,0,-107,-6,-159,-17r-25,-220v105,22,212,21,264,-44v31,-39,55,-88,72,-147","k":{"\u044f":27,"\u044d":27,"\u0445":-25,"\u0444":27,"\u0442":-25,"\u0441":51,"\u0440":27,"\u043e":51,"\u043c":27,"\u043b":27,"\u0437":27,"\u0436":-25,"\u0435":27,"\u0434":51,"\u0430":27,"\u00bb":-51,";":27,":":27,".":180,",":154}},"\u0444":{"d":"489,-1086v129,0,207,66,269,152r0,-532r279,0r0,539v61,-94,145,-157,284,-158v247,-2,388,292,388,561v0,271,-168,548,-409,548v-123,0,-200,-67,-263,-149r0,529r-279,0r0,-529v-69,83,-149,149,-278,149v-252,0,-396,-278,-396,-559v0,-159,43,-291,128,-395v85,-104,178,-156,277,-156xm699,-792v-88,-108,-190,-103,-265,14v-107,167,-69,586,131,587v55,0,98,-33,139,-93v74,-109,73,-411,-5,-508xm1227,-189v199,0,240,-406,141,-581v-37,-65,-82,-99,-141,-99v-209,0,-243,429,-137,591v38,59,84,89,137,89","w":1792,"k":{"\u044f":27,"\u0447":51,"\u0443":27,"\u0442":27,"\u043e":27,"\u043c":27,"\u043b":51,"\u0435":27,"\u0434":27,"\u0431":27}},"\u0445":{"d":"12,0r383,-547r-367,-515r343,0r188,292r198,-292r330,0r-360,503r393,559r-345,0r-216,-329r-218,329r-329,0","k":{"\u044d":27,"\u0447":51,"\u0444":27,"\u0443":-25,"\u0441":51,"\u043e":51,"\u0437":27,"\u0435":51,"\u0431":27}},"\u0446":{"d":"137,-1062r281,0r0,835r401,0r0,-835r281,0r0,835r111,0r0,507r-227,0r0,-280r-847,0r0,-1062","w":1259,"k":{"\u0441":27,"\u0437":-25,"\u0430":-25}},"\u0447":{"d":"398,-808v-9,167,62,233,209,233v50,0,106,-11,168,-34r0,-453r281,0r0,1062r-281,0r0,-424v-207,57,-324,68,-482,-12v-137,-70,-179,-171,-179,-372r0,-254r284,0r0,254","w":1189},"\u0448":{"d":"140,-1062r258,0r0,835r326,0r0,-835r259,0r0,835r325,0r0,-835r259,0r0,1062r-1427,0r0,-1062","w":1707},"\u0449":{"d":"141,-1062r259,0r0,835r323,0r0,-835r259,0r0,835r327,0r0,-835r259,0r0,835r115,0r0,507r-227,0r0,-280r-1315,0r0,-1062","w":1728,"k":{"\u043e":27,"\u0430":-25}},"\u044a":{"d":"1411,-310v-9,225,-144,310,-424,310r-600,0r0,-835r-347,0r0,-227r628,0r0,441v169,2,416,-8,536,23v111,29,213,148,207,288xm929,-178v136,1,193,-32,193,-135v0,-51,-21,-85,-60,-106v-66,-35,-269,-28,-394,-29r0,270r261,0","w":1493},"\u044b":{"d":"1174,-309v-5,229,-170,310,-424,309r-601,0r0,-1062r281,0r0,441v170,2,415,-9,536,23v112,30,211,147,208,289xm691,-178v122,-1,194,-27,194,-136v0,-51,-20,-86,-59,-106v-66,-35,-271,-27,-396,-28r0,270r261,0xm1334,-1062r281,0r0,1062r-281,0r0,-1062","w":1749},"\u044c":{"d":"1178,-309v-5,229,-169,310,-422,309r-603,0r0,-1062r281,0r0,441v172,2,414,-9,537,24v113,30,209,147,207,288xm696,-178v135,2,192,-33,192,-135v0,-51,-21,-85,-60,-106v-67,-35,-268,-28,-394,-29r0,270r262,0","w":1259,"k":{"\u0447":180,"\u0442":180}},"\u044d":{"d":"1049,-534v0,346,-174,559,-512,558v-252,0,-412,-112,-481,-337r278,-51v23,113,87,170,192,170v150,0,209,-105,225,-256r-293,0r0,-171r299,0v-11,-150,-69,-247,-215,-247v-88,0,-174,49,-188,128r-274,-51v67,-197,219,-295,455,-295v338,0,514,218,514,552","w":1131,"k":{"\u044f":27,"\u0445":27,"\u0442":27,"\u0441":27,"\u043c":27,"\u043b":51,"\u0437":27,"\u0436":27,"\u0434":27,"\u0431":27}},"\u044e":{"d":"1159,-1086v315,3,516,224,510,563v-4,224,-77,381,-217,473v-73,49,-169,74,-287,74v-170,0,-297,-46,-380,-138v-83,-92,-128,-191,-135,-296r-224,0r0,410r-281,0r0,-1062r281,0r0,429r224,0v27,-266,213,-456,509,-453xm1163,-196v167,0,216,-139,216,-330v0,-135,-20,-226,-59,-272v-39,-46,-94,-69,-165,-69v-177,0,-223,118,-224,314v0,140,19,234,57,283v38,49,97,74,175,74","w":1749,"k":{"\u044d":27,"\u0447":78,"\u0445":51,"\u0442":51,"\u0441":27,"\u043c":27,"\u043b":51,"\u0436":27,"\u0434":27,"\u0431":27}},"\u044f":{"d":"352,-460v-156,-7,-265,-133,-265,-300v0,-138,73,-243,177,-276v54,-18,134,-26,240,-26r553,0r0,1062r-279,0r0,-441v-165,-8,-206,40,-271,144r-185,297r-327,0r201,-308v57,-88,109,-139,156,-152xm376,-745v-6,175,229,130,402,137r0,-273r-201,0v-131,2,-197,22,-201,136","w":1195},"\u0451":{"d":"229,-1250r0,-241r241,0r0,241r-241,0xm659,-1250r0,-241r242,0r0,241r-242,0xm583,-186v104,0,153,-59,179,-152r280,47v-67,193,-214,312,-462,315v-330,4,-515,-217,-515,-547v0,-325,188,-563,487,-563v349,0,519,245,505,636r-704,0v0,152,90,264,230,264xm778,-622v0,-145,-80,-249,-209,-249v-130,0,-216,108,-211,249r420,0"},"\u0454":{"d":"776,-740v-21,-135,-256,-170,-340,-66v-34,42,-57,102,-63,185r299,0r0,171r-293,0v17,152,75,256,225,256v105,0,169,-57,192,-170r278,51v-69,225,-229,337,-481,337v-338,1,-512,-212,-512,-558v0,-334,176,-552,514,-552v236,0,388,98,455,295","w":1131},"\u0456":{"d":"147,-1206r0,-260r281,0r0,260r-281,0xm147,0r0,-1062r281,0r0,1062r-281,0","w":569},"\u0457":{"d":"147,0r0,-1062r281,0r0,1062r-281,0xm-48,-1250r0,-241r241,0r0,241r-241,0xm382,-1250r0,-241r242,0r0,241r-242,0","w":576},"\u2116":{"d":"163,-1466r290,0r577,968r0,-968r280,0r0,1466r-302,0r-568,-942r0,942r-277,0r0,-1466xm1807,-382v-242,0,-403,-179,-403,-411v0,-240,163,-408,395,-408v229,0,401,185,398,415v-2,163,-71,275,-173,346v-56,39,-128,58,-217,58xm1811,-1009v-109,0,-135,109,-135,242v0,110,28,190,124,190v106,0,129,-107,129,-236v0,-111,-24,-196,-118,-196xm1440,-286r715,0r0,221r-715,0r0,-221","w":2283}}});

/* Form 3.02 */
(function(b){function o(a){var c=a.data;a.isDefaultPrevented()||(a.preventDefault(),b(this).ajaxSubmit(c))}function s(a){var c=a.target,g=b(c);if(!g.is(":submit,input:image")){c=g.closest(":submit");if(0===c.length)return;c=c[0]}var f=this;f.clk=c;"image"==c.type&&(void 0!==a.offsetX?(f.clk_x=a.offsetX,f.clk_y=a.offsetY):"function"==typeof b.fn.offset?(g=g.offset(),f.clk_x=a.pageX-g.left,f.clk_y=a.pageY-g.top):(f.clk_x=a.pageX-c.offsetLeft,f.clk_y=a.pageY-c.offsetTop));setTimeout(function(){f.clk=
f.clk_x=f.clk_y=null},100)}function p(){if(b.fn.ajaxSubmit.debug){var a="[jquery.form] "+Array.prototype.join.call(arguments,"");window.console&&window.console.log?window.console.log(a):window.opera&&window.opera.postError&&window.opera.postError(a)}}var t,u;t=void 0!==b("<input type='file'/>").get(0).files;u=void 0!==window.FormData;b.fn.ajaxSubmit=function(a){function c(c){for(var f=new FormData,e=0;e<c.length;e++)f.append(c[e].name,c[e].value);if(a.extraData)for(var g in a.extraData)a.extraData.hasOwnProperty(g)&&
f.append(g,a.extraData[g]);a.data=null;c=b.extend(!0,{},b.ajaxSettings,a,{contentType:!1,processData:!1,cache:!1,type:"POST"});a.uploadProgress&&(c.xhr=function(){var b=jQuery.ajaxSettings.xhr();b.upload&&(b.upload.onprogress=function(b){var c=0;b.lengthComputable&&(c=parseInt(100*(b.position/b.total),10));a.uploadProgress(b,b.position,b.total,c)});return b});c.data=null;var k=c.beforeSend;c.beforeSend=function(b,d){d.data=f;k&&k.call(d,b,a)};b.ajax(c)}function g(c){function e(){function a(){try{var b=
(m.contentWindow?m.contentWindow.document:m.contentDocument?m.contentDocument:m.document).readyState;p("state = "+b);b&&"uninitialized"==b.toLowerCase()&&setTimeout(a,50)}catch(c){p("Server abort: ",c," (",c.name,")"),g(x),v&&clearTimeout(v),v=void 0}}var c=k.attr("target"),i=k.attr("action");j.setAttribute("target",o);f||j.setAttribute("method","POST");i!=d.url&&j.setAttribute("action",d.url);!d.skipEncodingOverride&&(!f||/post/i.test(f))&&k.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"});
d.timeout&&(v=setTimeout(function(){s=!0;g(t)},d.timeout));var h=[];try{if(d.extraData)for(var l in d.extraData)d.extraData.hasOwnProperty(l)&&h.push(b('<input type="hidden" name="'+l+'">').attr("value",d.extraData[l]).appendTo(j)[0]);d.iframeTarget||(r.appendTo("body"),m.attachEvent?m.attachEvent("onload",g):m.addEventListener("load",g,!1));setTimeout(a,15);j.submit()}finally{j.setAttribute("action",i),c?j.setAttribute("target",c):k.removeAttr("target"),b(h).remove()}}function g(a){if(!i.aborted&&
!z){try{q=m.contentWindow?m.contentWindow.document:m.contentDocument?m.contentDocument:m.document}catch(c){p("cannot access response document: ",c),a=x}if(a===t&&i)i.abort("timeout");else if(a==x&&i)i.abort("server abort");else if(q&&q.location.href!=d.iframeSrc||s){m.detachEvent?m.detachEvent("onload",g):m.removeEventListener("load",g,!1);var a="success",e;try{if(s)throw"timeout";var f="xml"==d.dataType||q.XMLDocument||b.isXMLDoc(q);p("isXml="+f);if(!f&&window.opera&&(null===q.body||!q.body.innerHTML)&&
--B){p("requeing onLoad callback, DOM not available");setTimeout(g,250);return}var h=q.body?q.body:q.documentElement;i.responseText=h?h.innerHTML:null;i.responseXML=q.XMLDocument?q.XMLDocument:q;f&&(d.dataType="xml");i.getResponseHeader=function(a){return{"content-type":d.dataType}[a]};h&&(i.status=Number(h.getAttribute("status"))||i.status,i.statusText=h.getAttribute("statusText")||i.statusText);var j=(d.dataType||"").toLowerCase(),l=/(json|script|text)/.test(j);if(l||d.textarea){var k=q.getElementsByTagName("textarea")[0];
if(k)i.responseText=k.value,i.status=Number(k.getAttribute("status"))||i.status,i.statusText=k.getAttribute("statusText")||i.statusText;else if(l){var o=q.getElementsByTagName("pre")[0],w=q.getElementsByTagName("body")[0];o?i.responseText=o.textContent?o.textContent:o.innerText:w&&(i.responseText=w.textContent?w.textContent:w.innerText)}}else"xml"==j&&!i.responseXML&&i.responseText&&(i.responseXML=C(i.responseText));try{u=D(i,j,d)}catch(A){a="parsererror",i.error=e=A||a}}catch(y){p("error caught: ",
y),a="error",i.error=e=y||a}i.aborted&&(p("upload aborted"),a=null);i.status&&(a=200<=i.status&&300>i.status||304===i.status?"success":"error");"success"===a?(d.success&&d.success.call(d.context,u,"success",i),n&&b.event.trigger("ajaxSuccess",[i,d])):a&&(void 0===e&&(e=i.statusText),d.error&&d.error.call(d.context,i,a,e),n&&b.event.trigger("ajaxError",[i,d,e]));n&&b.event.trigger("ajaxComplete",[i,d]);n&&!--b.active&&b.event.trigger("ajaxStop");d.complete&&d.complete.call(d.context,i,a);z=!0;d.timeout&&
clearTimeout(v);setTimeout(function(){d.iframeTarget||r.remove();i.responseXML=null},100)}}}var j=k[0],h,l,d,n,o,r,m,i,s,v;h=!!b.fn.prop;if(c)if(h)for(l=0;l<c.length;l++)h=b(j[c[l].name]),h.prop("disabled",!1);else for(l=0;l<c.length;l++)h=b(j[c[l].name]),h.removeAttr("disabled");if(b(":input[name=submit],:input[id=submit]",j).length)alert('Error: Form elements must not have name or id of "submit".');else if(d=b.extend(!0,{},b.ajaxSettings,a),d.context=d.context||d,o="jqFormIO"+(new Date).getTime(),
d.iframeTarget?(r=b(d.iframeTarget),(h=r.attr("name"))?o=h:r.attr("name",o)):(r=b('<iframe name="'+o+'" src="'+d.iframeSrc+'" />'),r.css({position:"absolute",top:"-1000px",left:"-1000px"})),m=r[0],i={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(a){var c=a==="timeout"?"timeout":"aborted";p("aborting upload... "+c);this.aborted=1;r.attr("src",d.iframeSrc);i.error=
c;d.error&&d.error.call(d.context,i,c,a);n&&b.event.trigger("ajaxError",[i,d,c]);d.complete&&d.complete.call(d.context,i,c)}},(n=d.global)&&0===b.active++&&b.event.trigger("ajaxStart"),n&&b.event.trigger("ajaxSend",[i,d]),d.beforeSend&&!1===d.beforeSend.call(d.context,i,d))d.global&&b.active--;else if(!i.aborted){if(c=j.clk)if((h=c.name)&&!c.disabled)d.extraData=d.extraData||{},d.extraData[h]=c.value,"image"==c.type&&(d.extraData[h+".x"]=j.clk_x,d.extraData[h+".y"]=j.clk_y);var t=1,x=2,c=b("meta[name=csrf-token]").attr("content");
if((h=b("meta[name=csrf-param]").attr("content"))&&c)d.extraData=d.extraData||{},d.extraData[h]=c;d.forceSync?e():setTimeout(e,10);var u,q,B=50,z,C=b.parseXML||function(a,b){if(window.ActiveXObject){b=new ActiveXObject("Microsoft.XMLDOM");b.async="false";b.loadXML(a)}else b=(new DOMParser).parseFromString(a,"text/xml");return b&&b.documentElement&&b.documentElement.nodeName!="parsererror"?b:null},E=b.parseJSON||function(a){return window.eval("("+a+")")},D=function(a,c,d){var e=a.getResponseHeader("content-type")||
"",f=c==="xml"||!c&&e.indexOf("xml")>=0,a=f?a.responseXML:a.responseText;f&&a.documentElement.nodeName==="parsererror"&&b.error&&b.error("parsererror");d&&d.dataFilter&&(a=d.dataFilter(a,c));typeof a==="string"&&(c==="json"||!c&&e.indexOf("json")>=0?a=E(a):(c==="script"||!c&&e.indexOf("javascript")>=0)&&b.globalEval(a));return a}}}if(!this.length)return p("ajaxSubmit: skipping submit process - no element selected"),this;var f,e,k=this;"function"==typeof a&&(a={success:a});f=this.attr("method");e=
this.attr("action");(e=(e="string"===typeof e?b.trim(e):"")||window.location.href||"")&&(e=(e.match(/^([^#]+)/)||[])[1]);a=b.extend(!0,{url:e,success:b.ajaxSettings.success,type:f||"GET",iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},a);e={};this.trigger("form-pre-serialize",[this,a,e]);if(e.veto)return p("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(a.beforeSerialize&&!1===a.beforeSerialize(this,a))return p("ajaxSubmit: submit aborted via beforeSerialize callback"),
this;var l=a.traditional;void 0===l&&(l=b.ajaxSettings.traditional);var h,j=this.formToArray(a.semantic);a.data&&(a.extraData=a.data,h=b.param(a.data,l));if(a.beforeSubmit&&!1===a.beforeSubmit(j,this,a))return p("ajaxSubmit: submit aborted via beforeSubmit callback"),this;this.trigger("form-submit-validate",[j,this,a,e]);if(e.veto)return p("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;e=b.param(j,l);h&&(e=e?e+"&"+h:h);"GET"==a.type.toUpperCase()?(a.url+=(0<=a.url.indexOf("?")?
"&":"?")+e,a.data=null):a.data=e;var n=[];a.resetForm&&n.push(function(){k.resetForm()});a.clearForm&&n.push(function(){k.clearForm(a.includeHidden)});if(!a.dataType&&a.target){var o=a.success||function(){};n.push(function(c){var e=a.replaceTarget?"replaceWith":"html";b(a.target)[e](c).each(o,arguments)})}else a.success&&n.push(a.success);a.success=function(b,c,e){for(var f=a.context||a,g=0,h=n.length;g<h;g++)n[g].apply(f,[b,c,e||k,k])};h=0<b("input:file:enabled[value]",this).length;e="multipart/form-data"==
k.attr("enctype")||"multipart/form-data"==k.attr("encoding");l=t&&u;p("fileAPI :"+l);!1!==a.iframe&&(a.iframe||(h||e)&&!l)?a.closeKeepAlive?b.get(a.closeKeepAlive,function(){g(j)}):g(j):(h||e)&&l?c(j):b.ajax(a);this.trigger("form-submit-notify",[this,a]);return this};b.fn.ajaxForm=function(a){a=a||{};a.delegation=a.delegation&&b.isFunction(b.fn.on);if(!a.delegation&&0===this.length){var c=this.selector,g=this.context;if(!b.isReady&&c)return p("DOM not ready, queuing ajaxForm"),b(function(){b(c,g).ajaxForm(a)}),
this;p("terminating; zero elements found by selector"+(b.isReady?"":" (DOM not ready)"));return this}return a.delegation?(b(document).off("submit.form-plugin",this.selector,o).off("click.form-plugin",this.selector,s).on("submit.form-plugin",this.selector,a,o).on("click.form-plugin",this.selector,a,s),this):this.ajaxFormUnbind().bind("submit.form-plugin",a,o).bind("click.form-plugin",a,s)};b.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")};b.fn.formToArray=function(a){var c=
[];if(0===this.length)return c;var g=this[0],f=a?g.getElementsByTagName("*"):g.elements;if(!f)return c;var e,k,l,h,j,n;e=0;for(n=f.length;e<n;e++)if(j=f[e],l=j.name)if(a&&g.clk&&"image"==j.type)!j.disabled&&g.clk==j&&(c.push({name:l,value:b(j).val(),type:j.type}),c.push({name:l+".x",value:g.clk_x},{name:l+".y",value:g.clk_y}));else if((h=b.fieldValue(j,!0))&&h.constructor==Array){k=0;for(j=h.length;k<j;k++)c.push({name:l,value:h[k]})}else if(t&&"file"==j.type&&!j.disabled){h=j.files;for(k=0;k<h.length;k++)c.push({name:l,
value:h[k],type:j.type})}else null!==h&&"undefined"!=typeof h&&c.push({name:l,value:h,type:j.type});if(!a&&g.clk&&(a=b(g.clk),f=a[0],(l=f.name)&&!f.disabled&&"image"==f.type))c.push({name:l,value:a.val()}),c.push({name:l+".x",value:g.clk_x},{name:l+".y",value:g.clk_y});return c};b.fn.formSerialize=function(a){return b.param(this.formToArray(a))};b.fn.fieldSerialize=function(a){var c=[];this.each(function(){var g=this.name;if(g){var f=b.fieldValue(this,a);if(f&&f.constructor==Array)for(var e=0,k=f.length;e<
k;e++)c.push({name:g,value:f[e]});else null!==f&&"undefined"!=typeof f&&c.push({name:this.name,value:f})}});return b.param(c)};b.fn.fieldValue=function(a){for(var c=[],g=0,f=this.length;g<f;g++){var e=b.fieldValue(this[g],a);null===e||"undefined"==typeof e||e.constructor==Array&&!e.length||(e.constructor==Array?b.merge(c,e):c.push(e))}return c};b.fieldValue=function(a,c){var g=a.name,f=a.type,e=a.tagName.toLowerCase();void 0===c&&(c=!0);if(c&&(!g||a.disabled||"reset"==f||"button"==f||("checkbox"==
f||"radio"==f)&&!a.checked||("submit"==f||"image"==f)&&a.form&&a.form.clk!=a||"select"==e&&-1==a.selectedIndex))return null;if("select"==e){var k=a.selectedIndex;if(0>k)return null;for(var g=[],e=a.options,l=(f="select-one"==f)?k+1:e.length,k=f?k:0;k<l;k++){var h=e[k];if(h.selected){var j=h.value;j||(j=h.attributes&&h.attributes.value&&!h.attributes.value.specified?h.text:h.value);if(f)return j;g.push(j)}}return g}return b(a).val()};b.fn.clearForm=function(a){return this.each(function(){b("input,select,textarea",
this).clearFields(a)})};b.fn.clearFields=b.fn.clearInputs=function(a){var b=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var g=this.type,f=this.tagName.toLowerCase();b.test(g)||"textarea"==f||a&&/hidden/.test(g)?this.value="":"checkbox"==g||"radio"==g?this.checked=!1:"select"==f&&(this.selectedIndex=-1)})};b.fn.resetForm=function(){return this.each(function(){("function"==typeof this.reset||"object"==typeof this.reset&&!this.reset.nodeType)&&
this.reset()})};b.fn.enable=function(a){void 0===a&&(a=!0);return this.each(function(){this.disabled=!a})};b.fn.selected=function(a){void 0===a&&(a=!0);return this.each(function(){var c=this.type;"checkbox"==c||"radio"==c?this.checked=a:"option"==this.tagName.toLowerCase()&&(c=b(this).parent("select"),a&&c[0]&&"select-one"==c[0].type&&c.find("option").selected(!1),this.selected=a)})};b.fn.ajaxSubmit.debug=!1})(jQuery);

/* Validation 1.9.0 */
(function(c){c.extend(c.fn,{validate:function(a){if(this.length){var b=c.data(this[0],"validator");if(b)return b;this.attr("novalidate","novalidate");b=new c.validator(a,this[0]);c.data(this[0],"validator",b);if(b.settings.onsubmit){a=this.find("input, button");a.filter(".cancel").click(function(){b.cancelSubmit=true});b.settings.submitHandler&&a.filter(":submit").click(function(){b.submitButton=this});this.submit(function(d){function e(){if(b.settings.submitHandler){if(b.submitButton)var f=c("<input type='hidden'/>").attr("name",
b.submitButton.name).val(b.submitButton.value).appendTo(b.currentForm);b.settings.submitHandler.call(b,b.currentForm);b.submitButton&&f.remove();return false}return true}b.settings.debug&&d.preventDefault();if(b.cancelSubmit){b.cancelSubmit=false;return e()}if(b.form()){if(b.pendingRequest){b.formSubmitted=true;return false}return e()}else{b.focusInvalid();return false}})}return b}else a&&a.debug&&window.console&&console.warn("nothing selected, can't validate, returning nothing")},valid:function(){if(c(this[0]).is("form"))return this.validate().form();
else{var a=true,b=c(this[0].form).validate();this.each(function(){a&=b.element(this)});return a}},removeAttrs:function(a){var b={},d=this;c.each(a.split(/\s/),function(e,f){b[f]=d.attr(f);d.removeAttr(f)});return b},rules:function(a,b){var d=this[0];if(a){var e=c.data(d.form,"validator").settings,f=e.rules,g=c.validator.staticRules(d);switch(a){case "add":c.extend(g,c.validator.normalizeRule(b));f[d.name]=g;if(b.messages)e.messages[d.name]=c.extend(e.messages[d.name],b.messages);break;case "remove":if(!b){delete f[d.name];
return g}var h={};c.each(b.split(/\s/),function(j,i){h[i]=g[i];delete g[i]});return h}}d=c.validator.normalizeRules(c.extend({},c.validator.metadataRules(d),c.validator.classRules(d),c.validator.attributeRules(d),c.validator.staticRules(d)),d);if(d.required){e=d.required;delete d.required;d=c.extend({required:e},d)}return d}});c.extend(c.expr[":"],{blank:function(a){return!c.trim(""+a.value)},filled:function(a){return!!c.trim(""+a.value)},unchecked:function(a){return!a.checked}});c.validator=function(a,
b){this.settings=c.extend(true,{},c.validator.defaults,a);this.currentForm=b;this.init()};c.validator.format=function(a,b){if(arguments.length==1)return function(){var d=c.makeArray(arguments);d.unshift(a);return c.validator.format.apply(this,d)};if(arguments.length>2&&b.constructor!=Array)b=c.makeArray(arguments).slice(1);if(b.constructor!=Array)b=[b];c.each(b,function(d,e){a=a.replace(RegExp("\\{"+d+"\\}","g"),e)});return a};c.extend(c.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",
validClass:"valid",errorElement:"label",focusInvalid:true,errorContainer:c([]),errorLabelContainer:c([]),onsubmit:true,ignore:":hidden",ignoreTitle:false,onfocusin:function(a){this.lastActive=a;if(this.settings.focusCleanup&&!this.blockFocusCleanup){this.settings.unhighlight&&this.settings.unhighlight.call(this,a,this.settings.errorClass,this.settings.validClass);this.addWrapper(this.errorsFor(a)).hide()}},onfocusout:function(a){if(!this.checkable(a)&&(a.name in this.submitted||!this.optional(a)))this.element(a)},
onkeyup:function(a){if(a.name in this.submitted||a==this.lastElement)this.element(a)},onclick:function(a){if(a.name in this.submitted)this.element(a);else a.parentNode.name in this.submitted&&this.element(a.parentNode)},highlight:function(a,b,d){a.type==="radio"?this.findByName(a.name).addClass(b).removeClass(d):c(a).addClass(b).removeClass(d)},unhighlight:function(a,b,d){a.type==="radio"?this.findByName(a.name).removeClass(b).addClass(d):c(a).removeClass(b).addClass(d)}},setDefaults:function(a){c.extend(c.validator.defaults,
a)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",creditcard:"Please enter a valid credit card number.",equalTo:"Please enter the same value again.",accept:"Please enter a value with a valid extension.",maxlength:c.validator.format("Please enter no more than {0} characters."),
minlength:c.validator.format("Please enter at least {0} characters."),rangelength:c.validator.format("Please enter a value between {0} and {1} characters long."),range:c.validator.format("Please enter a value between {0} and {1}."),max:c.validator.format("Please enter a value less than or equal to {0}."),min:c.validator.format("Please enter a value greater than or equal to {0}.")},autoCreateRanges:false,prototype:{init:function(){function a(e){var f=c.data(this[0].form,"validator"),g="on"+e.type.replace(/^validate/,
"");f.settings[g]&&f.settings[g].call(f,this[0],e)}this.labelContainer=c(this.settings.errorLabelContainer);this.errorContext=this.labelContainer.length&&this.labelContainer||c(this.currentForm);this.containers=c(this.settings.errorContainer).add(this.settings.errorLabelContainer);this.submitted={};this.valueCache={};this.pendingRequest=0;this.pending={};this.invalid={};this.reset();var b=this.groups={};c.each(this.settings.groups,function(e,f){c.each(f.split(/\s/),function(g,h){b[h]=e})});var d=
this.settings.rules;c.each(d,function(e,f){d[e]=c.validator.normalizeRule(f)});c(this.currentForm).validateDelegate("[type='text'], [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ","focusin focusout keyup",a).validateDelegate("[type='radio'], [type='checkbox'], select, option","click",
a);this.settings.invalidHandler&&c(this.currentForm).bind("invalid-form.validate",this.settings.invalidHandler)},form:function(){this.checkForm();c.extend(this.submitted,this.errorMap);this.invalid=c.extend({},this.errorMap);this.valid()||c(this.currentForm).triggerHandler("invalid-form",[this]);this.showErrors();return this.valid()},checkForm:function(){this.prepareForm();for(var a=0,b=this.currentElements=this.elements();b[a];a++)this.check(b[a]);return this.valid()},element:function(a){this.lastElement=
a=this.validationTargetFor(this.clean(a));this.prepareElement(a);this.currentElements=c(a);var b=this.check(a);if(b)delete this.invalid[a.name];else this.invalid[a.name]=true;if(!this.numberOfInvalids())this.toHide=this.toHide.add(this.containers);this.showErrors();return b},showErrors:function(a){if(a){c.extend(this.errorMap,a);this.errorList=[];for(var b in a)this.errorList.push({message:a[b],element:this.findByName(b)[0]});this.successList=c.grep(this.successList,function(d){return!(d.name in a)})}this.settings.showErrors?
this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){c.fn.resetForm&&c(this.currentForm).resetForm();this.submitted={};this.lastElement=null;this.prepareForm();this.hideErrors();this.elements().removeClass(this.settings.errorClass)},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(a){var b=0,d;for(d in a)b++;return b},hideErrors:function(){this.addWrapper(this.toHide).hide()},valid:function(){return this.size()==
0},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{c(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").focus().trigger("focusin")}catch(a){}},findLastActive:function(){var a=this.lastActive;return a&&c.grep(this.errorList,function(b){return b.element.name==a.name}).length==1&&a},elements:function(){var a=this,b={};return c(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function(){!this.name&&
a.settings.debug&&window.console&&console.error("%o has no name assigned",this);if(this.name in b||!a.objectLength(c(this).rules()))return false;return b[this.name]=true})},clean:function(a){return c(a)[0]},errors:function(){return c(this.settings.errorElement+"."+this.settings.errorClass,this.errorContext)},reset:function(){this.successList=[];this.errorList=[];this.errorMap={};this.toShow=c([]);this.toHide=c([]);this.currentElements=c([])},prepareForm:function(){this.reset();this.toHide=this.errors().add(this.containers)},
prepareElement:function(a){this.reset();this.toHide=this.errorsFor(a)},check:function(a){a=this.validationTargetFor(this.clean(a));var b=c(a).rules(),d=false,e;for(e in b){var f={method:e,parameters:b[e]};try{var g=c.validator.methods[e].call(this,a.value.replace(/\r/g,""),a,f.parameters);if(g=="dependency-mismatch")d=true;else{d=false;if(g=="pending"){this.toHide=this.toHide.not(this.errorsFor(a));return}if(!g){this.formatAndAdd(a,f);return false}}}catch(h){this.settings.debug&&window.console&&console.log("exception occured when checking element "+
a.id+", check the '"+f.method+"' method",h);throw h;}}if(!d){this.objectLength(b)&&this.successList.push(a);return true}},customMetaMessage:function(a,b){if(c.metadata){var d=this.settings.meta?c(a).metadata()[this.settings.meta]:c(a).metadata();return d&&d.messages&&d.messages[b]}},customMessage:function(a,b){var d=this.settings.messages[a];return d&&(d.constructor==String?d:d[b])},findDefined:function(){for(var a=0;a<arguments.length;a++)if(arguments[a]!==undefined)return arguments[a]},defaultMessage:function(a,
b){return this.findDefined(this.customMessage(a.name,b),this.customMetaMessage(a,b),!this.settings.ignoreTitle&&a.title||undefined,c.validator.messages[b],"<strong>Warning: No message defined for "+a.name+"</strong>")},formatAndAdd:function(a,b){var d=this.defaultMessage(a,b.method),e=/\$?\{(\d+)\}/g;if(typeof d=="function")d=d.call(this,b.parameters,a);else if(e.test(d))d=jQuery.format(d.replace(e,"{$1}"),b.parameters);this.errorList.push({message:d,element:a});this.errorMap[a.name]=d;this.submitted[a.name]=
d},addWrapper:function(a){if(this.settings.wrapper)a=a.add(a.parent(this.settings.wrapper));return a},defaultShowErrors:function(){for(var a=0;this.errorList[a];a++){var b=this.errorList[a];this.settings.highlight&&this.settings.highlight.call(this,b.element,this.settings.errorClass,this.settings.validClass);this.showLabel(b.element,b.message)}if(this.errorList.length)this.toShow=this.toShow.add(this.containers);if(this.settings.success)for(a=0;this.successList[a];a++)this.showLabel(this.successList[a]);
if(this.settings.unhighlight){a=0;for(b=this.validElements();b[a];a++)this.settings.unhighlight.call(this,b[a],this.settings.errorClass,this.settings.validClass)}this.toHide=this.toHide.not(this.toShow);this.hideErrors();this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return c(this.errorList).map(function(){return this.element})},showLabel:function(a,b){var d=this.errorsFor(a);if(d.length){d.removeClass(this.settings.validClass).addClass(this.settings.errorClass);
d.attr("generated")&&d.html(b)}else{d=c("<"+this.settings.errorElement+"/>").attr({"for":this.idOrName(a),generated:true}).addClass(this.settings.errorClass).html(b||"");if(this.settings.wrapper)d=d.hide().show().wrap("<"+this.settings.wrapper+"/>").parent();this.labelContainer.append(d).length||(this.settings.errorPlacement?this.settings.errorPlacement(d,c(a)):d.insertAfter(a))}if(!b&&this.settings.success){d.text("");typeof this.settings.success=="string"?d.addClass(this.settings.success):this.settings.success(d)}this.toShow=
this.toShow.add(d)},errorsFor:function(a){var b=this.idOrName(a);return this.errors().filter(function(){return c(this).attr("for")==b})},idOrName:function(a){return this.groups[a.name]||(this.checkable(a)?a.name:a.id||a.name)},validationTargetFor:function(a){if(this.checkable(a))a=this.findByName(a.name).not(this.settings.ignore)[0];return a},checkable:function(a){return/radio|checkbox/i.test(a.type)},findByName:function(a){var b=this.currentForm;return c(document.getElementsByName(a)).map(function(d,
e){return e.form==b&&e.name==a&&e||null})},getLength:function(a,b){switch(b.nodeName.toLowerCase()){case "select":return c("option:selected",b).length;case "input":if(this.checkable(b))return this.findByName(b.name).filter(":checked").length}return a.length},depend:function(a,b){return this.dependTypes[typeof a]?this.dependTypes[typeof a](a,b):true},dependTypes:{"boolean":function(a){return a},string:function(a,b){return!!c(a,b.form).length},"function":function(a,b){return a(b)}},optional:function(a){return!c.validator.methods.required.call(this,
c.trim(a.value),a)&&"dependency-mismatch"},startRequest:function(a){if(!this.pending[a.name]){this.pendingRequest++;this.pending[a.name]=true}},stopRequest:function(a,b){this.pendingRequest--;if(this.pendingRequest<0)this.pendingRequest=0;delete this.pending[a.name];if(b&&this.pendingRequest==0&&this.formSubmitted&&this.form()){c(this.currentForm).submit();this.formSubmitted=false}else if(!b&&this.pendingRequest==0&&this.formSubmitted){c(this.currentForm).triggerHandler("invalid-form",[this]);this.formSubmitted=
false}},previousValue:function(a){return c.data(a,"previousValue")||c.data(a,"previousValue",{old:null,valid:true,message:this.defaultMessage(a,"remote")})}},classRuleSettings:{required:{required:true},email:{email:true},url:{url:true},date:{date:true},dateISO:{dateISO:true},dateDE:{dateDE:true},number:{number:true},numberDE:{numberDE:true},digits:{digits:true},creditcard:{creditcard:true}},addClassRules:function(a,b){a.constructor==String?this.classRuleSettings[a]=b:c.extend(this.classRuleSettings,
a)},classRules:function(a){var b={};(a=c(a).attr("class"))&&c.each(a.split(" "),function(){this in c.validator.classRuleSettings&&c.extend(b,c.validator.classRuleSettings[this])});return b},attributeRules:function(a){var b={};a=c(a);for(var d in c.validator.methods){var e;if(e=d==="required"&&typeof c.fn.prop==="function"?a.prop(d):a.attr(d))b[d]=e;else if(a[0].getAttribute("type")===d)b[d]=true}b.maxlength&&/-1|2147483647|524288/.test(b.maxlength)&&delete b.maxlength;return b},metadataRules:function(a){if(!c.metadata)return{};
var b=c.data(a.form,"validator").settings.meta;return b?c(a).metadata()[b]:c(a).metadata()},staticRules:function(a){var b={},d=c.data(a.form,"validator");if(d.settings.rules)b=c.validator.normalizeRule(d.settings.rules[a.name])||{};return b},normalizeRules:function(a,b){c.each(a,function(d,e){if(e===false)delete a[d];else if(e.param||e.depends){var f=true;switch(typeof e.depends){case "string":f=!!c(e.depends,b.form).length;break;case "function":f=e.depends.call(b,b)}if(f)a[d]=e.param!==undefined?
e.param:true;else delete a[d]}});c.each(a,function(d,e){a[d]=c.isFunction(e)?e(b):e});c.each(["minlength","maxlength","min","max"],function(){if(a[this])a[this]=Number(a[this])});c.each(["rangelength","range"],function(){if(a[this])a[this]=[Number(a[this][0]),Number(a[this][1])]});if(c.validator.autoCreateRanges){if(a.min&&a.max){a.range=[a.min,a.max];delete a.min;delete a.max}if(a.minlength&&a.maxlength){a.rangelength=[a.minlength,a.maxlength];delete a.minlength;delete a.maxlength}}a.messages&&delete a.messages;
return a},normalizeRule:function(a){if(typeof a=="string"){var b={};c.each(a.split(/\s/),function(){b[this]=true});a=b}return a},addMethod:function(a,b,d){c.validator.methods[a]=b;c.validator.messages[a]=d!=undefined?d:c.validator.messages[a];b.length<3&&c.validator.addClassRules(a,c.validator.normalizeRule(a))},methods:{required:function(a,b,d){if(!this.depend(d,b))return"dependency-mismatch";switch(b.nodeName.toLowerCase()){case "select":return(a=c(b).val())&&a.length>0;case "input":if(this.checkable(b))return this.getLength(a,
b)>0;default:return c.trim(a).length>0}},remote:function(a,b,d){if(this.optional(b))return"dependency-mismatch";var e=this.previousValue(b);this.settings.messages[b.name]||(this.settings.messages[b.name]={});e.originalMessage=this.settings.messages[b.name].remote;this.settings.messages[b.name].remote=e.message;d=typeof d=="string"&&{url:d}||d;if(this.pending[b.name])return"pending";if(e.old===a)return e.valid;e.old=a;var f=this;this.startRequest(b);var g={};g[b.name]=a;c.ajax(c.extend(true,{url:d,
mode:"abort",port:"validate"+b.name,dataType:"json",data:g,success:function(h){f.settings.messages[b.name].remote=e.originalMessage;var j=h===true;if(j){var i=f.formSubmitted;f.prepareElement(b);f.formSubmitted=i;f.successList.push(b);f.showErrors()}else{i={};h=h||f.defaultMessage(b,"remote");i[b.name]=e.message=c.isFunction(h)?h(a):h;f.showErrors(i)}e.valid=j;f.stopRequest(b,j)}},d));return"pending"},minlength:function(a,b,d){return this.optional(b)||this.getLength(c.trim(a),b)>=d},maxlength:function(a,
b,d){return this.optional(b)||this.getLength(c.trim(a),b)<=d},rangelength:function(a,b,d){a=this.getLength(c.trim(a),b);return this.optional(b)||a>=d[0]&&a<=d[1]},min:function(a,b,d){return this.optional(b)||a>=d},max:function(a,b,d){return this.optional(b)||a<=d},range:function(a,b,d){return this.optional(b)||a>=d[0]&&a<=d[1]},email:function(a,b){return this.optional(b)||/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(a)},
url:function(a,b){return this.optional(b)||/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(a)},
date:function(a,b){return this.optional(b)||!/Invalid|NaN/.test(new Date(a))},dateISO:function(a,b){return this.optional(b)||/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(a)},number:function(a,b){return this.optional(b)||/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(a)},digits:function(a,b){return this.optional(b)||/^\d+$/.test(a)},creditcard:function(a,b){if(this.optional(b))return"dependency-mismatch";if(/[^0-9 -]+/.test(a))return false;var d=0,e=0,f=false;a=a.replace(/\D/g,"");for(var g=a.length-1;g>=
0;g--){e=a.charAt(g);e=parseInt(e,10);if(f)if((e*=2)>9)e-=9;d+=e;f=!f}return d%10==0},accept:function(a,b,d){d=typeof d=="string"?d.replace(/,/g,"|"):"png|jpe?g|gif";return this.optional(b)||a.match(RegExp(".("+d+")$","i"))},equalTo:function(a,b,d){d=c(d).unbind(".validate-equalTo").bind("blur.validate-equalTo",function(){c(b).valid()});return a==d.val()}}});c.format=c.validator.format})(jQuery);
(function(c){var a={};if(c.ajaxPrefilter)c.ajaxPrefilter(function(d,e,f){e=d.port;if(d.mode=="abort"){a[e]&&a[e].abort();a[e]=f}});else{var b=c.ajax;c.ajax=function(d){var e=("port"in d?d:c.ajaxSettings).port;if(("mode"in d?d:c.ajaxSettings).mode=="abort"){a[e]&&a[e].abort();return a[e]=b.apply(this,arguments)}return b.apply(this,arguments)}}})(jQuery);
(function(c){!jQuery.event.special.focusin&&!jQuery.event.special.focusout&&document.addEventListener&&c.each({focus:"focusin",blur:"focusout"},function(a,b){function d(e){e=c.event.fix(e);e.type=b;return c.event.handle.call(this,e)}c.event.special[b]={setup:function(){this.addEventListener(a,d,true)},teardown:function(){this.removeEventListener(a,d,true)},handler:function(e){arguments[0]=c.event.fix(e);arguments[0].type=b;return c.event.handle.apply(this,arguments)}}});c.extend(c.fn,{validateDelegate:function(a,
b,d){return this.bind(b,function(e){var f=c(e.target);if(f.is(a))return d.apply(f,arguments)})}})})(jQuery);

/* Validation Methods */
$.validator.addMethod('latnum', function(val, el) {return /^[a-z0-9]*$/i.test(val);}, 'Please use latin characters and/or numbers only');
$.validator.addMethod('requiredPlaceholder', function(val, el) {return val != $(el).data('placeholder');});
$.validator.addClassRules('required', {required: true, requiredPlaceholder: true});

/* FancyBox 1.3.4 */
;(function(b){var m,t,u,f,D,j,E,n,z,A,q=0,e={},o=[],p=0,d={},l=[],G=null,v=new Image,J=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,W=/[^\.]\.(swf)\s*$/i,K,L=1,y=0,s="",r,i,h=false,B=b.extend(b("<div/>")[0],{prop:0}),M=b.browser.msie&&b.browser.version<7&&!window.XMLHttpRequest,N=function(){t.hide();v.onerror=v.onload=null;G&&G.abort();m.empty()},O=function(){if(false===e.onError(o,q,e)){t.hide();h=false}else{e.titleShow=false;e.width="auto";e.height="auto";m.html('<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>');
F()}},I=function(){var a=o[q],c,g,k,C,P,w;N();e=b.extend({},b.fn.fancybox.defaults,typeof b(a).data("fancybox")=="undefined"?e:b(a).data("fancybox"));w=e.onStart(o,q,e);if(w===false)h=false;else{if(typeof w=="object")e=b.extend(e,w);k=e.title||(a.nodeName?b(a).attr("title"):a.title)||"";if(a.nodeName&&!e.orig)e.orig=b(a).children("img:first").length?b(a).children("img:first"):b(a);if(k===""&&e.orig&&e.titleFromAlt)k=e.orig.attr("alt");c=e.href||(a.nodeName?b(a).attr("href"):a.href)||null;if(/^(?:javascript)/i.test(c)||
c=="#")c=null;if(e.type){g=e.type;if(!c)c=e.content}else if(e.content)g="html";else if(c)g=c.match(J)?"image":c.match(W)?"swf":b(a).hasClass("iframe")?"iframe":c.indexOf("#")===0?"inline":"ajax";if(g){if(g=="inline"){a=c.substr(c.indexOf("#"));g=b(a).length>0?"inline":"ajax"}e.type=g;e.href=c;e.title=k;if(e.autoDimensions)if(e.type=="html"||e.type=="inline"||e.type=="ajax"){e.width="auto";e.height="auto"}else e.autoDimensions=false;if(e.modal){e.overlayShow=true;e.hideOnOverlayClick=false;e.hideOnContentClick=
false;e.enableEscapeButton=false;e.showCloseButton=false}e.padding=parseInt(e.padding,10);e.margin=parseInt(e.margin,10);m.css("padding",e.padding+e.margin);b(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){b(this).replaceWith(j.children())});switch(g){case "html":m.html(e.content);F();break;case "inline":if(b(a).parent().is("#fancybox-content")===true){h=false;break}b('<div class="fancybox-inline-tmp" />').hide().insertBefore(b(a)).bind("fancybox-cleanup",function(){b(this).replaceWith(j.children())}).bind("fancybox-cancel",
function(){b(this).replaceWith(m.children())});b(a).appendTo(m);F();break;case "image":h=false;b.fancybox.showActivity();v=new Image;v.onerror=function(){O()};v.onload=function(){h=true;v.onerror=v.onload=null;e.width=v.width;e.height=v.height;b("<img />").attr({id:"fancybox-img",src:v.src,alt:e.title}).appendTo(m);Q()};v.src=c;break;case "swf":e.scrolling="no";C='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+e.width+'" height="'+e.height+'"><param name="movie" value="'+c+
'"></param>';P="";b.each(e.swf,function(x,H){C+='<param name="'+x+'" value="'+H+'"></param>';P+=" "+x+'="'+H+'"'});C+='<embed src="'+c+'" type="application/x-shockwave-flash" width="'+e.width+'" height="'+e.height+'"'+P+"></embed></object>";m.html(C);F();break;case "ajax":h=false;b.fancybox.showActivity();e.ajax.win=e.ajax.success;G=b.ajax(b.extend({},e.ajax,{url:c,data:e.ajax.data||{},error:function(x){x.status>0&&O()},success:function(x,H,R){if((typeof R=="object"?R:G).status==200){if(typeof e.ajax.win==
"function"){w=e.ajax.win(c,x,H,R);if(w===false){t.hide();return}else if(typeof w=="string"||typeof w=="object")x=w}m.html(x);F()}}}));break;case "iframe":Q()}}else O()}},F=function(){var a=e.width,c=e.height;a=a.toString().indexOf("%")>-1?parseInt((b(window).width()-e.margin*2)*parseFloat(a)/100,10)+"px":a=="auto"?"auto":a+"px";c=c.toString().indexOf("%")>-1?parseInt((b(window).height()-e.margin*2)*parseFloat(c)/100,10)+"px":c=="auto"?"auto":c+"px";m.wrapInner('<div style="width:'+a+";height:"+c+
";overflow: "+(e.scrolling=="auto"?"auto":e.scrolling=="yes"?"scroll":"hidden")+';position:relative;"></div>');e.width=m.width();e.height=m.height();Q()},Q=function(){var a,c;t.hide();if(f.is(":visible")&&false===d.onCleanup(l,p,d)){b.event.trigger("fancybox-cancel");h=false}else{h=true;b(j.add(u)).unbind();b(window).unbind("resize.fb scroll.fb");b(document).unbind("keydown.fb");f.is(":visible")&&d.titlePosition!=="outside"&&f.css("height",f.height());l=o;p=q;d=e;if(d.overlayShow){u.css({"background-color":d.overlayColor,
opacity:d.overlayOpacity,cursor:d.hideOnOverlayClick?"pointer":"auto",height:b(document).height()});if(!u.is(":visible")){M&&b("select:not(#fancybox-tmp select)").filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one("fancybox-cleanup",function(){this.style.visibility="inherit"});u.show()}}else u.hide();i=X();s=d.title||"";y=0;n.empty().removeAttr("style").removeClass();if(d.titleShow!==false){if(b.isFunction(d.titleFormat))a=d.titleFormat(s,l,p,d);else a=s&&s.length?
d.titlePosition=="float"?'<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">'+s+'</td><td id="fancybox-title-float-right"></td></tr></table>':'<div id="fancybox-title-'+d.titlePosition+'">'+s+"</div>":false;s=a;if(!(!s||s==="")){n.addClass("fancybox-title-"+d.titlePosition).html(s).appendTo("body").show();switch(d.titlePosition){case "inside":n.css({width:i.width-d.padding*2,marginLeft:d.padding,marginRight:d.padding});
y=n.outerHeight(true);n.appendTo(D);i.height+=y;break;case "over":n.css({marginLeft:d.padding,width:i.width-d.padding*2,bottom:d.padding}).appendTo(D);break;case "float":n.css("left",parseInt((n.width()-i.width-40)/2,10)*-1).appendTo(f);break;default:n.css({width:i.width-d.padding*2,paddingLeft:d.padding,paddingRight:d.padding}).appendTo(f)}}}n.hide();if(f.is(":visible")){b(E.add(z).add(A)).hide();a=f.position();r={top:a.top,left:a.left,width:f.width(),height:f.height()};c=r.width==i.width&&r.height==
i.height;j.fadeTo(d.changeFade,0.3,function(){var g=function(){j.html(m.contents()).fadeTo(d.changeFade,1,S)};b.event.trigger("fancybox-change");j.empty().removeAttr("filter").css({"border-width":d.padding,width:i.width-d.padding*2,height:e.autoDimensions?"auto":i.height-y-d.padding*2});if(c)g();else{B.prop=0;b(B).animate({prop:1},{duration:d.changeSpeed,easing:d.easingChange,step:T,complete:g})}})}else{f.removeAttr("style");j.css("border-width",d.padding);if(d.transitionIn=="elastic"){r=V();j.html(m.contents());
f.show();if(d.opacity)i.opacity=0;B.prop=0;b(B).animate({prop:1},{duration:d.speedIn,easing:d.easingIn,step:T,complete:S})}else{d.titlePosition=="inside"&&y>0&&n.show();j.css({width:i.width-d.padding*2,height:e.autoDimensions?"auto":i.height-y-d.padding*2}).html(m.contents());f.css(i).fadeIn(d.transitionIn=="none"?0:d.speedIn,S)}}}},Y=function(){if(d.enableEscapeButton||d.enableKeyboardNav)b(document).bind("keydown.fb",function(a){if(a.keyCode==27&&d.enableEscapeButton){a.preventDefault();b.fancybox.close()}else if((a.keyCode==
37||a.keyCode==39)&&d.enableKeyboardNav&&a.target.tagName!=="INPUT"&&a.target.tagName!=="TEXTAREA"&&a.target.tagName!=="SELECT"){a.preventDefault();b.fancybox[a.keyCode==37?"prev":"next"]()}});if(d.showNavArrows){if(d.cyclic&&l.length>1||p!==0)z.show();if(d.cyclic&&l.length>1||p!=l.length-1)A.show()}else{z.hide();A.hide()}},S=function(){if(!b.support.opacity){j.get(0).style.removeAttribute("filter");f.get(0).style.removeAttribute("filter")}e.autoDimensions&&j.css("height","auto");f.css("height","auto");
s&&s.length&&n.show();d.showCloseButton&&E.show();Y();d.hideOnContentClick&&j.bind("click",b.fancybox.close);d.hideOnOverlayClick&&u.bind("click",b.fancybox.close);b(window).bind("resize.fb",b.fancybox.resize);d.centerOnScroll&&b(window).bind("scroll.fb",b.fancybox.center);if(d.type=="iframe")b('<iframe id="fancybox-frame" name="fancybox-frame'+(new Date).getTime()+'" frameborder="0" hspace="0" '+(b.browser.msie?'allowtransparency="true""':"")+' scrolling="'+e.scrolling+'" src="'+d.href+'"></iframe>').appendTo(j);
f.show();h=false;b.fancybox.center();d.onComplete(l,p,d);var a,c;if(l.length-1>p){a=l[p+1].href;if(typeof a!=="undefined"&&a.match(J)){c=new Image;c.src=a}}if(p>0){a=l[p-1].href;if(typeof a!=="undefined"&&a.match(J)){c=new Image;c.src=a}}},T=function(a){var c={width:parseInt(r.width+(i.width-r.width)*a,10),height:parseInt(r.height+(i.height-r.height)*a,10),top:parseInt(r.top+(i.top-r.top)*a,10),left:parseInt(r.left+(i.left-r.left)*a,10)};if(typeof i.opacity!=="undefined")c.opacity=a<0.5?0.5:a;f.css(c);
j.css({width:c.width-d.padding*2,height:c.height-y*a-d.padding*2})},U=function(){return[b(window).width()-d.margin*2,b(window).height()-d.margin*2,b(document).scrollLeft()+d.margin,b(document).scrollTop()+d.margin]},X=function(){var a=U(),c={},g=d.autoScale,k=d.padding*2;c.width=d.width.toString().indexOf("%")>-1?parseInt(a[0]*parseFloat(d.width)/100,10):d.width+k;c.height=d.height.toString().indexOf("%")>-1?parseInt(a[1]*parseFloat(d.height)/100,10):d.height+k;if(g&&(c.width>a[0]||c.height>a[1]))if(e.type==
"image"||e.type=="swf"){g=d.width/d.height;if(c.width>a[0]){c.width=a[0];c.height=parseInt((c.width-k)/g+k,10)}if(c.height>a[1]){c.height=a[1];c.width=parseInt((c.height-k)*g+k,10)}}else{c.width=Math.min(c.width,a[0]);c.height=Math.min(c.height,a[1])}c.top=parseInt(Math.max(a[3]-20,a[3]+(a[1]-c.height-40)*0.5),10);c.left=parseInt(Math.max(a[2]-20,a[2]+(a[0]-c.width-40)*0.5),10);return c},V=function(){var a=e.orig?b(e.orig):false,c={};if(a&&a.length){c=a.offset();c.top+=parseInt(a.css("paddingTop"),
10)||0;c.left+=parseInt(a.css("paddingLeft"),10)||0;c.top+=parseInt(a.css("border-top-width"),10)||0;c.left+=parseInt(a.css("border-left-width"),10)||0;c.width=a.width();c.height=a.height();c={width:c.width+d.padding*2,height:c.height+d.padding*2,top:c.top-d.padding-20,left:c.left-d.padding-20}}else{a=U();c={width:d.padding*2,height:d.padding*2,top:parseInt(a[3]+a[1]*0.5,10),left:parseInt(a[2]+a[0]*0.5,10)}}return c},Z=function(){if(t.is(":visible")){b("div",t).css("top",L*-40+"px");L=(L+1)%12}else clearInterval(K)};
b.fn.fancybox=function(a){if(!b(this).length)return this;b(this).data("fancybox",b.extend({},a,b.metadata?b(this).metadata():{})).unbind("click.fb").bind("click.fb",function(c){c.preventDefault();if(!h){h=true;b(this).blur();o=[];q=0;c=b(this).attr("rel")||"";if(!c||c==""||c==="nofollow")o.push(this);else{o=b("a[rel="+c+"], area[rel="+c+"]");q=o.index(this)}I()}});return this};b.fancybox=function(a,c){var g;if(!h){h=true;g=typeof c!=="undefined"?c:{};o=[];q=parseInt(g.index,10)||0;if(b.isArray(a)){for(var k=
0,C=a.length;k<C;k++)if(typeof a[k]=="object")b(a[k]).data("fancybox",b.extend({},g,a[k]));else a[k]=b({}).data("fancybox",b.extend({content:a[k]},g));o=jQuery.merge(o,a)}else{if(typeof a=="object")b(a).data("fancybox",b.extend({},g,a));else a=b({}).data("fancybox",b.extend({content:a},g));o.push(a)}if(q>o.length||q<0)q=0;I()}};b.fancybox.showActivity=function(){clearInterval(K);t.show();K=setInterval(Z,66)};b.fancybox.hideActivity=function(){t.hide()};b.fancybox.next=function(){return b.fancybox.pos(p+
1)};b.fancybox.prev=function(){return b.fancybox.pos(p-1)};b.fancybox.pos=function(a){if(!h){a=parseInt(a);o=l;if(a>-1&&a<l.length){q=a;I()}else if(d.cyclic&&l.length>1){q=a>=l.length?0:l.length-1;I()}}};b.fancybox.cancel=function(){if(!h){h=true;b.event.trigger("fancybox-cancel");N();e.onCancel(o,q,e);h=false}};b.fancybox.close=function(){function a(){u.fadeOut("fast");n.empty().hide();f.hide();b.event.trigger("fancybox-cleanup");j.empty();d.onClosed(l,p,d);l=e=[];p=q=0;d=e={};h=false}if(!(h||f.is(":hidden"))){h=
true;if(d&&false===d.onCleanup(l,p,d))h=false;else{N();b(E.add(z).add(A)).hide();b(j.add(u)).unbind();b(window).unbind("resize.fb scroll.fb");b(document).unbind("keydown.fb");j.find("iframe").attr("src",M&&/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank");d.titlePosition!=="inside"&&n.empty();f.stop();if(d.transitionOut=="elastic"){r=V();var c=f.position();i={top:c.top,left:c.left,width:f.width(),height:f.height()};if(d.opacity)i.opacity=1;n.empty().hide();B.prop=1;
b(B).animate({prop:0},{duration:d.speedOut,easing:d.easingOut,step:T,complete:a})}else f.fadeOut(d.transitionOut=="none"?0:d.speedOut,a)}}};b.fancybox.resize=function(){u.is(":visible")&&u.css("height",b(document).height());b.fancybox.center(true)};b.fancybox.center=function(a){var c,g;if(!h){g=a===true?1:0;c=U();!g&&(f.width()>c[0]||f.height()>c[1])||f.stop().animate({top:parseInt(Math.max(c[3]-20,c[3]+(c[1]-j.height()-40)*0.5-d.padding)),left:parseInt(Math.max(c[2]-20,c[2]+(c[0]-j.width()-40)*0.5-
d.padding))},typeof a=="number"?a:200)}};b.fancybox.init=function(){if(!b("#fancybox-wrap").length){b("body").append(m=b('<div id="fancybox-tmp"></div>'),t=b('<div id="fancybox-loading"><div></div></div>'),u=b('<div id="fancybox-overlay"></div>'),f=b('<div id="fancybox-wrap"></div>'));D=b('<div id="fancybox-outer"></div>').append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>').appendTo(f);
D.append(j=b('<div id="fancybox-content"></div>'),E=b('<a id="fancybox-close"></a>'),n=b('<div id="fancybox-title"></div>'),z=b('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),A=b('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));E.click(b.fancybox.close);t.click(b.fancybox.cancel);z.click(function(a){a.preventDefault();b.fancybox.prev()});A.click(function(a){a.preventDefault();b.fancybox.next()});
b.fn.mousewheel&&f.bind("mousewheel.fb",function(a,c){if(h)a.preventDefault();else if(b(a.target).get(0).clientHeight==0||b(a.target).get(0).scrollHeight===b(a.target).get(0).clientHeight){a.preventDefault();b.fancybox[c>0?"prev":"next"]()}});b.support.opacity||f.addClass("fancybox-ie");if(M){t.addClass("fancybox-ie6");f.addClass("fancybox-ie6");b('<iframe id="fancybox-hide-sel-frame" src="'+(/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank")+'" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(D)}}};
b.fn.fancybox.defaults={padding:10,margin:40,opacity:false,modal:false,cyclic:false,scrolling:"auto",width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:0.7,overlayColor:"#777",titleShow:true,titlePosition:"float",titleFormat:null,titleFromAlt:false,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",easingIn:"swing",
easingOut:"swing",showCloseButton:true,showNavArrows:true,enableEscapeButton:true,enableKeyboardNav:true,onStart:function(){},onCancel:function(){},onComplete:function(){},onCleanup:function(){},onClosed:function(){},onError:function(){}};b(document).ready(function(){b.fancybox.init()})})(jQuery);

/* Mousewheel 3.0.6 */
(function(a){function d(b){var c=b||window.event,d=[].slice.call(arguments,1),e=0,f=!0,g=0,h=0;return b=a.event.fix(c),b.type="mousewheel",c.wheelDelta&&(e=c.wheelDelta/120),c.detail&&(e=-c.detail/3),h=e,c.axis!==undefined&&c.axis===c.HORIZONTAL_AXIS&&(h=0,g=-1*e),c.wheelDeltaY!==undefined&&(h=c.wheelDeltaY/120),c.wheelDeltaX!==undefined&&(g=-1*c.wheelDeltaX/120),d.unshift(b,e,g,h),(a.event.dispatch||a.event.handle).apply(this,d)}var b=["DOMMouseScroll","mousewheel"];if(a.event.fixHooks)for(var c=b.length;c;)a.event.fixHooks[b[--c]]=a.event.mouseHooks;a.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=b.length;a;)this.addEventListener(b[--a],d,!1);else this.onmousewheel=d},teardown:function(){if(this.removeEventListener)for(var a=b.length;a;)this.removeEventListener(b[--a],d,!1);else this.onmousewheel=null}},a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);

/* Jcrop 0.9.9 */
(function(g){g.Jcrop=function(p,J){function q(a){return parseInt(a,10)+"px"}function A(a){return parseInt(a,10)+"%"}function K(a){a=g(a).offset();return[a.left,a.top]}function B(a){return[a.pageX-P[0],a.pageY-P[1]]}function E(a){"object"!==typeof a&&(a={});b=g.extend(b,a);"function"!==typeof b.onChange&&(b.onChange=function(){});"function"!==typeof b.onSelect&&(b.onSelect=function(){});"function"!==typeof b.onRelease&&(b.onRelease=function(){})}function ba(a,b){P=K(l);C.setCursor("move"===a?a:a+"-resize");
if("move"===a)return C.activateHandlers(oa(b),W);var r=t.getFixed(),j=ca(a),c=t.getCorner(ca(j));t.setPressed(t.getCorner(j));t.setCurrent(c);C.activateHandlers(pa(a,r),W)}function pa(a,e){return function(r){if(b.aspectRatio)switch(a){case "e":r[1]=e.y+1;break;case "w":r[1]=e.y+1;break;case "n":r[0]=e.x+1;break;case "s":r[0]=e.x+1}else switch(a){case "e":r[1]=e.y2;break;case "w":r[1]=e.y2;break;case "n":r[0]=e.x2;break;case "s":r[0]=e.x2}t.setCurrent(r);m.update()}}function oa(a){var b=a;X.watchKeys();
return function(a){t.moveOffset([a[0]-b[0],a[1]-b[1]]);b=a;m.update()}}function ca(a){switch(a){case "n":return"sw";case "s":return"nw";case "e":return"nw";case "w":return"ne";case "ne":return"sw";case "nw":return"se";case "se":return"nw";case "sw":return"ne"}}function da(a){return function(e){if(b.disabled||"move"===a&&!b.allowMove)return!1;L=!0;ba(a,B(e));e.stopPropagation();e.preventDefault();return!1}}function ea(a,b,r){var j=a.width(),c=a.height();j>b&&0<b&&(j=b,c=b/a.width()*a.height());c>r&&
0<r&&(c=r,j=r/a.height()*a.width());u=a.width()/j;z=a.height()/c;a.width(j).height(c)}function Y(a){return{x:parseInt(a.x*u,10),y:parseInt(a.y*z,10),x2:parseInt(a.x2*u,10),y2:parseInt(a.y2*z,10),w:parseInt(a.w*u,10),h:parseInt(a.h*z,10)}}function W(){var a=t.getFixed();a.w>b.minSelect[0]&&a.h>b.minSelect[1]?(m.enableHandles(),m.done()):m.release();C.setCursor(b.allowSelect?"crosshair":"default")}function fa(a){if(b.disabled||!b.allowSelect)return!1;L=!0;P=K(l);m.disableHandles();"crosshair"!==ga&&
(C.setCursor("crosshair"),ga="crosshair");var e=B(a);t.setPressed(e);m.update();C.activateHandlers(qa,W);X.watchKeys();a.stopPropagation();a.preventDefault();return!1}function qa(a){t.setCurrent(a);m.update()}function ha(){var a=g("<div></div>").addClass(b.baseClass+"-tracker");g.browser.msie&&a.css({opacity:0,backgroundColor:"white"});return a}function ia(a){ja([parseInt(a[0],10)/u,parseInt(a[1],10)/z,parseInt(a[2],10)/u,parseInt(a[3],10)/z])}function ja(a){t.setPressed([a[0],a[1]]);t.setCurrent([a[2],
a[3]]);m.update()}function ka(){b.disabled=!0;m.disableHandles();m.setCursor("default");C.setCursor("default")}function la(){b.disabled=!1;Z()}function Z(a){b.allowResize?a?m.enableOnly():m.enableHandles():m.disableHandles();C.setCursor(b.allowSelect?"crosshair":"default");m.setCursor(b.allowMove?"move":"default");b.hasOwnProperty("setSelect")&&(ia(b.setSelect),m.done(),delete b.setSelect);b.hasOwnProperty("trueSize")&&(u=b.trueSize[0]/s,z=b.trueSize[1]/o);b.hasOwnProperty("bgColor")&&(g.fx.step.hasOwnProperty("backgroundColor")&&
b.fadeTime?D.animate({backgroundColor:b.bgColor},{queue:!1,duration:b.fadeTime}):D.css("backgroundColor",b.bgColor),delete b.bgColor);b.hasOwnProperty("bgOpacity")&&(U=b.bgOpacity,m.isAwake()&&(b.fadeTime?l.fadeTo(b.fadeTime,U):D.css("opacity",b.opacity)),delete b.bgOpacity);Q=b.maxSize[0]||0;R=b.maxSize[1]||0;S=b.minSize[0]||0;T=b.minSize[1]||0;b.hasOwnProperty("outerImage")&&(l.attr("src",b.outerImage),delete b.outerImage);m.refresh()}var b=g.extend({},g.Jcrop.defaults),P,ga,$=!1;g.browser.msie&&
"6"===g.browser.version.split(".")[0]&&($=!0);"object"!==typeof p&&(p=g(p)[0]);"object"!==typeof J&&(J={});E(J);var ma={border:"none",margin:0,padding:0,position:"absolute"},F=g(p),l=F.clone().removeAttr("id").css(ma);l.width(F.width());l.height(F.height());F.after(l).hide();ea(l,b.boxWidth,b.boxHeight);var s=l.width(),o=l.height(),D=g("<div />").width(s).height(o).addClass(b.baseClass+"-holder").css({position:"relative",backgroundColor:b.bgColor}).insertAfter(F).append(l);delete b.bgColor;b.addClass&&
D.addClass(b.addClass);var V=g("<img />").attr("src",l.attr("src")).css(ma).width(s).height(o),aa=g("<div />").width(A(100)).height(A(100)).css({zIndex:310,position:"absolute",overflow:"hidden"}).append(V),M=g("<div />").width(A(100)).height(A(100)).css("zIndex",320),N=g("<div />").css({position:"absolute",zIndex:300}).insertBefore(l).append(aa,M);$&&N.css({overflowY:"hidden"});var O=b.boundary,G=ha().width(s+2*O).height(o+2*O).css({position:"absolute",top:q(-O),left:q(-O),zIndex:290}).mousedown(fa),
U=b.bgOpacity,Q,R,S,T,u,z,L,ra;P=K(l);var H=function(){function a(){var a={},b=["touchstart","touchmove","touchend"],c=document.createElement("div"),d;try{for(d=0;d<b.length;d++){var f=b[d],f="on"+f,i=f in c;i||(c.setAttribute(f,"return;"),i="function"==typeof c[f]);a[b[d]]=i}return a.touchstart&&a.touchend&&a.touchmove}catch(e){return!1}}var e;e=!0===b.touchSupport||!1===b.touchSupport?b.touchSupport:a();return{createDragger:function(a){return function(j){j.pageX=j.originalEvent.changedTouches[0].pageX;
j.pageY=j.originalEvent.changedTouches[0].pageY;if(b.disabled||"move"===a&&!b.allowMove)return!1;L=!0;ba(a,B(j));j.stopPropagation();j.preventDefault();return!1}},newSelection:function(a){a.pageX=a.originalEvent.changedTouches[0].pageX;a.pageY=a.originalEvent.changedTouches[0].pageY;return fa(a)},isSupported:a,support:e}}(),t=function(){function a(){if(!b.aspectRatio){var a=f-c,e=i-d;Q&&Math.abs(a)>Q&&(f=0<a?c+Q:c-Q);R&&Math.abs(e)>R&&(i=0<e?d+R:d-R);T/z&&Math.abs(e)<T/z&&(i=0<e?d+T/z:d-T/z);S/u&&
Math.abs(a)<S/u&&(f=0<a?c+S/u:c-S/u);0>c&&(f-=c,c-=c);0>d&&(i-=d,d-=d);0>f&&(c-=f,f-=f);0>i&&(d-=i,i-=i);f>s&&(a=f-s,c-=a,f-=a);i>o&&(a=i-o,d-=a,i-=a);c>s&&(a=c-o,i-=a,d-=a);d>o&&(a=d-o,i-=a,d-=a);return j(r(c,d,f,i))}var a=b.aspectRatio,e=b.minSize[0]/u,g=b.maxSize[0]/u,l=f-c,m=i-d,n=Math.abs(l),k=Math.abs(m);0===g&&(g=10*s);n/k<a?(n=i,w=k*a,k=0>l?c-w:w+c,0>k?(k=0,h=Math.abs((k-c)/a),n=0>m?d-h:h+d):k>s&&(k=s,h=Math.abs((k-c)/a),n=0>m?d-h:h+d)):(k=f,h=n/a,n=0>m?d-h:d+h,0>n?(n=0,w=Math.abs((n-d)*a),
k=0>l?c-w:w+c):n>o&&(n=o,w=Math.abs(n-d)*a,k=0>l?c-w:w+c));k>c?(k-c<e?k=c+e:k-c>g&&(k=c+g),n=n>d?d+(k-c)/a:d-(k-c)/a):k<c&&(c-k<e?k=c-e:c-k>g&&(k=c-g),n=n>d?d+(c-k)/a:d-(c-k)/a);0>k?(c-=k,k=0):k>s&&(c-=k-s,k=s);0>n?(d-=n,n=0):n>o&&(d-=n-o,n=o);return j(r(c,d,k,n))}function e(a){0>a[0]&&(a[0]=0);0>a[1]&&(a[1]=0);a[0]>s&&(a[0]=s);a[1]>o&&(a[1]=o);return[a[0],a[1]]}function r(a,b,c,d){var i=a,f=c,e=b,na=d;c<a&&(i=c,f=a);d<b&&(e=d,na=b);return[Math.round(i),Math.round(e),Math.round(f),Math.round(na)]}
function j(a){return{x:a[0],y:a[1],x2:a[2],y2:a[3],w:a[2]-a[0],h:a[3]-a[1]}}var c=0,d=0,f=0,i=0,g,l;return{flipCoords:r,setPressed:function(a){a=e(a);f=c=a[0];i=d=a[1]},setCurrent:function(a){a=e(a);g=a[0]-f;l=a[1]-i;f=a[0];i=a[1]},getOffset:function(){return[g,l]},moveOffset:function(a){var b=a[0],a=a[1];0>c+b&&(b-=b+c);0>d+a&&(a-=a+d);o<i+a&&(a+=o-(i+a));s<f+b&&(b+=s-(f+b));c+=b;f+=b;d+=a;i+=a},getCorner:function(b){var c=a();switch(b){case "ne":return[c.x2,c.y];case "nw":return[c.x,c.y];case "se":return[c.x2,
c.y2];case "sw":return[c.x,c.y2]}},getFixed:a}}(),m=function(){function a(a){a=g("<div />").css({position:"absolute",opacity:b.borderOpacity}).addClass(b.baseClass+"-"+a);aa.append(a);return a}function e(a,b){var c=g("<div />").mousedown(da(a)).css({cursor:a+"-resize",position:"absolute",zIndex:b});H.support&&c.bind("touchstart",H.createDragger(a));M.append(c);return c}function r(a){var c=b.handleSize,d=c,i=n,f=n;switch(a){case "n":case "s":c=A(100);break;case "e":case "w":d=A(100)}return e(a,z++).width(c).height(d).css({top:q(-i+
1),left:q(-f+1)})}function j(a){var c;for(c=0;c<a.length;c++)v[a[c]]=e(a[c],z++).css({top:q(-n+1),left:q(-n+1),opacity:b.handleOpacity}).addClass(b.baseClass+"-handle")}function c(a){var b=Math.round(a.h/2-n),c=Math.round(a.w/2-n),d=a.w-n,a=a.h-n;v.e&&(v.e.css({top:q(b),left:q(d)}),v.w.css({top:q(b)}),v.s.css({top:q(a),left:q(c)}),v.n.css({left:q(c)}));v.ne&&(v.ne.css({left:q(d)}),v.se.css({top:q(a),left:q(d)}),v.sw.css({top:q(a)}));v.b&&(v.b.css({top:q(a)}),v.r.css({left:q(d)}))}function d(){var a=
t.getFixed();t.setPressed([a.x,a.y]);t.setCurrent([a.x2,a.y2]);f()}function f(){if(u)return i()}function i(){var a=t.getFixed(),d=a.h;N.width(a.w).height(d);var d=a.x,i=a.y;V.css({top:q(-i),left:q(-d)});N.css({top:q(i),left:q(d)});p&&c(a);u||(N.show(),b.bgFade?l.fadeTo(b.fadeTime,U):l.css("opacity",U),u=!0);b.onChange.call(I,Y(a))}function m(){p=!0;if(b.allowResize)return c(t.getFixed()),M.show(),!0}function o(){p=!1;M.hide()}function s(a){void 0===a?o():m()}var u,z=370,v={},p=!1,n=b.handleOffset;
b.drawBorders&&(a("hline"),a("hline bottom"),a("vline"),a("vline right"));b.dragEdges&&(v.t=r("n"),v.b=r("s"),v.r=r("e"),v.l=r("w"));b.sideHandles&&j(["n","s","e","w"]);b.cornerHandles&&j(["sw","nw","ne","se"]);var k=ha().mousedown(da("move")).css({cursor:"move",position:"absolute",zIndex:360});H.support&&k.bind("touchstart.jcrop",H.createDragger("move"));aa.append(k);o();return{updateVisible:f,update:i,release:function(){o();N.hide();b.bgFade?l.fadeTo(b.fadeTime,1):l.css("opacity",1);u=false;b.onRelease.call(I)},
refresh:d,isAwake:function(){return u},setCursor:function(a){k.css("cursor",a)},enableHandles:m,enableOnly:function(){p=true},showHandles:function(){if(p){c(t.getFixed());M.show()}},disableHandles:o,animMode:s,done:function(){s(false);d()}}}(),C=function(){function a(a){c(B(a));return!1}function e(i){i.preventDefault();i.stopPropagation();L&&(L=!1,d(B(i)),m.isAwake()&&b.onSelect.call(I,Y(t.getFixed())),G.css({zIndex:290}),f&&g(document).unbind("mousemove",a).unbind("mouseup",e),c=function(){},d=function(){});
return!1}function r(b){b.pageX=b.originalEvent.changedTouches[0].pageX;b.pageY=b.originalEvent.changedTouches[0].pageY;return a(b)}function j(a){a.pageX=a.originalEvent.changedTouches[0].pageX;a.pageY=a.originalEvent.changedTouches[0].pageY;return e(a)}var c=function(){},d=function(){},f=b.trackDocument;H.support&&g(document).bind("touchmove",r).bind("touchend",j);f||G.mousemove(a).mouseup(e).mouseout(e);l.before(G);return{activateHandlers:function(b,j){L=!0;c=b;d=j;G.css({zIndex:450});f&&g(document).bind("mousemove",
a).bind("mouseup",e);return!1},setCursor:function(a){G.css("cursor",a)}}}(),X=function(){function a(){j.hide()}function e(a,c,e){b.allowMove&&(t.moveOffset([c,e]),m.updateVisible());a.preventDefault();a.stopPropagation()}function r(a){if(a.ctrlKey)return!0;var b=(ra=a.shiftKey?!0:!1)?10:1;switch(a.keyCode){case 37:e(a,-b,0);break;case 39:e(a,b,0);break;case 38:e(a,0,-b);break;case 40:e(a,0,b);break;case 27:m.release();break;case 9:return!0}return!1}var j=g('<input type="radio" />').css({position:"fixed",
left:"-120px",width:"12px"}),c=g("<div />").css({position:"absolute",overflow:"hidden"}).append(j);b.keySupport&&(j.keydown(r).blur(a),$||!b.fixedSupport?(j.css({position:"absolute",left:"-20px"}),c.append(j).insertBefore(l)):j.insertBefore(l));return{watchKeys:function(){if(b.keySupport){j.show();j.focus()}}}}();H.support&&G.bind("touchstart",H.newSelection);M.hide();Z(!0);var I={setImage:function(a,e){m.release();ka();var g=new Image;g.onload=function(){var j=g.height,c=b.boxWidth,d=b.boxHeight;
l.width(g.width).height(j);l.attr("src",a);V.attr("src",a);ea(l,c,d);s=l.width();o=l.height();V.width(s).height(o);G.width(s+2*O).height(o+2*O);D.width(s).height(o);la();"function"===typeof e&&e.call(I)};g.src=a},animateTo:function(a,e){var g=parseInt(a[0],10)/u,j=parseInt(a[1],10)/z,c=parseInt(a[2],10)/u,d=parseInt(a[3],10)/z,g=t.flipCoords(g,j,c,d),j=t.getFixed(),f=[j.x,j.y,j.x2,j.y2],i=b.animationDelay,l=g[0]-f[0],o=g[1]-f[1],s=g[2]-f[2],q=g[3]-f[3],p=0,v=b.swingSpeed;x=f[0];y=f[1];c=f[2];d=f[3];
m.animMode(!0);var A=function(){return function(){p+=(100-p)/v;f[0]=x+p/100*l;f[1]=y+p/100*o;f[2]=c+p/100*s;f[3]=d+p/100*q;99.8<=p&&(p=100);100>p?(ja(f),window.setTimeout(A,i)):(m.done(),"function"===typeof e&&e.call(I))}}();window.setTimeout(A,i)},setSelect:ia,setOptions:function(a){E(a);Z()},tellSelect:function(){return Y(t.getFixed())},tellScaled:function(){return t.getFixed()},setClass:function(a){D.removeClass().addClass(b.baseClass+"-holder").addClass(a)},disable:ka,enable:la,cancel:function(){m.done();
C.activateHandlers(null,null)},release:m.release,destroy:function(){D.remove();F.show();g(p).removeData("Jcrop")},focus:X.watchKeys,getBounds:function(){return[s*u,o*z]},getWidgetSize:function(){return[s,o]},getScaleFactor:function(){return[u,z]},ui:{holder:D,selection:N}};g.browser.msie&&D.bind("selectstart",function(){return!1});F.data("Jcrop",I);return I};g.fn.Jcrop=function(p,J){function q(q){var K="object"===typeof p?p:{},B=K.useImg||q.src,E=new Image;E.onload=function(){function p(){if(!E.width||
!E.height)window.setTimeout(p,50);else{var B=g.Jcrop(q,K);"function"===typeof J&&J.call(B)}}window.setTimeout(p,50)};E.src=B}this.each(function(){if(g(this).data("Jcrop")){if("api"===p)return g(this).data("Jcrop");g(this).data("Jcrop").setOptions(p)}else q(this)});return this};g.Jcrop.defaults={allowSelect:!0,allowMove:!0,allowResize:!0,trackDocument:!0,baseClass:"jcrop",addClass:null,bgColor:"black",bgOpacity:0.6,bgFade:!1,borderOpacity:0.4,handleOpacity:0.5,handleSize:9,handleOffset:5,aspectRatio:0,
keySupport:!0,cornerHandles:!0,sideHandles:!0,drawBorders:!0,dragEdges:!0,fixedSupport:!0,touchSupport:null,boxWidth:0,boxHeight:0,boundary:2,fadeTime:400,animationDelay:20,swingSpeed:3,minSelect:[0,0],maxSize:[0,0],minSize:[0,0],onChange:function(){},onSelect:function(){},onRelease:function(){}}})(jQuery);

/* jPicker 1.1.6 */
(function(e,a){Math.precision=function(j,h){if(h===undefined){h=0}return Math.round(j*Math.pow(10,h))/Math.pow(10,h)};var d=function(z,k){var o=this,j=z.find("img:first"),F=0,E=100,w=100,D=0,C=100,v=100,s=0,p=0,n,q,u=new Array(),l=function(y){for(var x=0;x<u.length;x++){u[x].call(o,o,y)}},H=function(x){var y=z.offset();n={l:y.left|0,t:y.top|0};clearTimeout(q);q=setTimeout(function(){A.call(o,x)},0);e(document).bind("mousemove",h).bind("mouseup",B);x.preventDefault()},h=function(x){clearTimeout(q);q=setTimeout(function(){A.call(o,x)},0);x.stopPropagation();x.preventDefault();return false},B=function(x){e(document).unbind("mouseup",B).unbind("mousemove",h);x.stopPropagation();x.preventDefault();return false},A=function(M){var K=M.pageX-n.l,x=M.pageY-n.t,L=z.w,y=z.h;if(K<0){K=0}else{if(K>L){K=L}}if(x<0){x=0}else{if(x>y){x=y}}J.call(o,"xy",{x:((K/L)*w)+F,y:((x/y)*v)+D})},r=function(){var L=0,x=0,N=z.w,K=z.h,M=j.w,y=j.h;setTimeout(function(){if(w>0){if(s==E){L=N}else{L=((s/w)*N)|0}}if(v>0){if(p==C){x=K}else{x=((p/v)*K)|0}}if(M>=N){L=(N>>1)-(M>>1)}else{L-=M>>1}if(y>=K){x=(K>>1)-(y>>1)}else{x-=y>>1}j.css({left:L+"px",top:x+"px"})},0)},J=function(x,K,y){var O=K!==undefined;if(!O){if(x===undefined||x==null){x="xy"}switch(x.toLowerCase()){case"x":return s;case"y":return p;case"xy":default:return{x:s,y:p}}}if(y!=null&&y==o){return}var N=false,M,L;if(x==null){x="xy"}switch(x.toLowerCase()){case"x":M=K&&(K.x&&K.x|0||K|0)||0;break;case"y":L=K&&(K.y&&K.y|0||K|0)||0;break;case"xy":default:M=K&&K.x&&K.x|0||0;L=K&&K.y&&K.y|0||0;break}if(M!=null){if(M<F){M=F}else{if(M>E){M=E}}if(s!=M){s=M;N=true}}if(L!=null){if(L<D){L=D}else{if(L>C){L=C}}if(p!=L){p=L;N=true}}N&&l.call(o,y||o)},t=function(x,L){var P=L!==undefined;if(!P){if(x===undefined||x==null){x="all"}switch(x.toLowerCase()){case"minx":return F;case"maxx":return E;case"rangex":return{minX:F,maxX:E,rangeX:w};case"miny":return D;case"maxy":return C;case"rangey":return{minY:D,maxY:C,rangeY:v};case"all":default:return{minX:F,maxX:E,rangeX:w,minY:D,maxY:C,rangeY:v}}}var O=false,N,K,M,y;if(x==null){x="all"}switch(x.toLowerCase()){case"minx":N=L&&(L.minX&&L.minX|0||L|0)||0;break;case"maxx":K=L&&(L.maxX&&L.maxX|0||L|0)||0;break;case"rangex":N=L&&L.minX&&L.minX|0||0;K=L&&L.maxX&&L.maxX|0||0;break;case"miny":M=L&&(L.minY&&L.minY|0||L|0)||0;break;case"maxy":y=L&&(L.maxY&&L.maxY|0||L|0)||0;break;case"rangey":M=L&&L.minY&&L.minY|0||0;y=L&&L.maxY&&L.maxY|0||0;break;case"all":default:N=L&&L.minX&&L.minX|0||0;K=L&&L.maxX&&L.maxX|0||0;M=L&&L.minY&&L.minY|0||0;y=L&&L.maxY&&L.maxY|0||0;break}if(N!=null&&F!=N){F=N;w=E-F}if(K!=null&&E!=K){E=K;w=E-F}if(M!=null&&D!=M){D=M;v=C-D}if(y!=null&&C!=y){C=y;v=C-D}},I=function(x){if(e.isFunction(x)){u.push(x)}},m=function(y){if(!e.isFunction(y)){return}var x;while((x=e.inArray(y,u))!=-1){u.splice(x,1)}},G=function(){e(document).unbind("mouseup",B).unbind("mousemove",h);z.unbind("mousedown",H);z=null;j=null;u=null};e.extend(true,o,{val:J,range:t,bind:I,unbind:m,destroy:G});j.src=k.arrow&&k.arrow.image;j.w=k.arrow&&k.arrow.width||j.width();j.h=k.arrow&&k.arrow.height||j.height();z.w=k.map&&k.map.width||z.width();z.h=k.map&&k.map.height||z.height();z.bind("mousedown",H);I.call(o,r)},b=function(u,z,k,y){var q=this,l=u.find("td.Text input"),r=l.eq(3),v=l.eq(4),h=l.eq(5),o=l.length>7?l.eq(6):null,n=l.eq(0),p=l.eq(1),x=l.eq(2),s=l.eq(l.length>7?7:6),B=l.length>7?l.eq(8):null,C=function(E){if(E.target.value==""&&E.target!=s.get(0)&&(k!=null&&E.target!=k.get(0)||k==null)){return}if(!t(E)){return E}switch(E.target){case r.get(0):switch(E.keyCode){case 38:r.val(j.call(q,(r.val()<<0)+1,0,255));z.val("r",r.val(),E.target);return false;case 40:r.val(j.call(q,(r.val()<<0)-1,0,255));z.val("r",r.val(),E.target);return false}break;case v.get(0):switch(E.keyCode){case 38:v.val(j.call(q,(v.val()<<0)+1,0,255));z.val("g",v.val(),E.target);return false;case 40:v.val(j.call(q,(v.val()<<0)-1,0,255));z.val("g",v.val(),E.target);return false}break;case h.get(0):switch(E.keyCode){case 38:h.val(j.call(q,(h.val()<<0)+1,0,255));z.val("b",h.val(),E.target);return false;case 40:h.val(j.call(q,(h.val()<<0)-1,0,255));z.val("b",h.val(),E.target);return false}break;case o&&o.get(0):switch(E.keyCode){case 38:o.val(j.call(q,parseFloat(o.val())+1,0,100));z.val("a",Math.precision((o.val()*255)/100,y),E.target);return false;case 40:o.val(j.call(q,parseFloat(o.val())-1,0,100));z.val("a",Math.precision((o.val()*255)/100,y),E.target);return false}break;case n.get(0):switch(E.keyCode){case 38:n.val(j.call(q,(n.val()<<0)+1,0,360));z.val("h",n.val(),E.target);return false;case 40:n.val(j.call(q,(n.val()<<0)-1,0,360));z.val("h",n.val(),E.target);return false}break;case p.get(0):switch(E.keyCode){case 38:p.val(j.call(q,(p.val()<<0)+1,0,100));z.val("s",p.val(),E.target);return false;case 40:p.val(j.call(q,(p.val()<<0)-1,0,100));z.val("s",p.val(),E.target);return false}break;case x.get(0):switch(E.keyCode){case 38:x.val(j.call(q,(x.val()<<0)+1,0,100));z.val("v",x.val(),E.target);return false;case 40:x.val(j.call(q,(x.val()<<0)-1,0,100));z.val("v",x.val(),E.target);return false}break}},w=function(E){if(E.target.value==""&&E.target!=s.get(0)&&(k!=null&&E.target!=k.get(0)||k==null)){return}if(!t(E)){return E}switch(E.target){case r.get(0):r.val(j.call(q,r.val(),0,255));z.val("r",r.val(),E.target);break;case v.get(0):v.val(j.call(q,v.val(),0,255));z.val("g",v.val(),E.target);break;case h.get(0):h.val(j.call(q,h.val(),0,255));z.val("b",h.val(),E.target);break;case o&&o.get(0):o.val(j.call(q,o.val(),0,100));z.val("a",Math.precision((o.val()*255)/100,y),E.target);break;case n.get(0):n.val(j.call(q,n.val(),0,360));z.val("h",n.val(),E.target);break;case p.get(0):p.val(j.call(q,p.val(),0,100));z.val("s",p.val(),E.target);break;case x.get(0):x.val(j.call(q,x.val(),0,100));z.val("v",x.val(),E.target);break;case s.get(0):s.val(s.val().replace(/[^a-fA-F0-9]/g,"").toLowerCase().substring(0,6));k&&k.val(s.val());z.val("hex",s.val()!=""?s.val():null,E.target);break;case k&&k.get(0):k.val(k.val().replace(/[^a-fA-F0-9]/g,"").toLowerCase().substring(0,6));s.val(k.val());z.val("hex",k.val()!=""?k.val():null,E.target);break;case B&&B.get(0):B.val(B.val().replace(/[^a-fA-F0-9]/g,"").toLowerCase().substring(0,2));z.val("a",B.val()!=null?parseInt(B.val(),16):null,E.target);break}},A=function(E){if(z.val()!=null){switch(E.target){case r.get(0):r.val(z.val("r"));break;case v.get(0):v.val(z.val("g"));break;case h.get(0):h.val(z.val("b"));break;case o&&o.get(0):o.val(Math.precision((z.val("a")*100)/255,y));break;case n.get(0):n.val(z.val("h"));break;case p.get(0):p.val(z.val("s"));break;case x.get(0):x.val(z.val("v"));break;case s.get(0):case k&&k.get(0):s.val(z.val("hex"));k&&k.val(z.val("hex"));break;case B&&B.get(0):B.val(z.val("ahex").substring(6));break}}},t=function(E){switch(E.keyCode){case 9:case 16:case 29:case 37:case 39:return false;case"c".charCodeAt():case"v".charCodeAt():if(E.ctrlKey){return false}}return true},j=function(G,F,E){if(G==""||isNaN(G)){return F}if(G>E){return E}if(G<F){return F}return G},m=function(G,E){var F=G.val("all");if(E!=r.get(0)){r.val(F!=null?F.r:"")}if(E!=v.get(0)){v.val(F!=null?F.g:"")}if(E!=h.get(0)){h.val(F!=null?F.b:"")}if(o&&E!=o.get(0)){o.val(F!=null?Math.precision((F.a*100)/255,y):"")}if(E!=n.get(0)){n.val(F!=null?F.h:"")}if(E!=p.get(0)){p.val(F!=null?F.s:"")}if(E!=x.get(0)){x.val(F!=null?F.v:"")}if(E!=s.get(0)&&(k&&E!=k.get(0)||!k)){s.val(F!=null?F.hex:"")}if(k&&E!=k.get(0)&&E!=s.get(0)){k.val(F!=null?F.hex:"")}if(B&&E!=B.get(0)){B.val(F!=null?F.ahex.substring(6):"")}},D=function(){r.add(v).add(h).add(o).add(n).add(p).add(x).add(s).add(k).add(B).unbind("keyup",w).unbind("blur",A);r.add(v).add(h).add(o).add(n).add(p).add(x).unbind("keydown",C);z.unbind(m);r=null;v=null;h=null;o=null;n=null;p=null;x=null;s=null;B=null};e.extend(true,q,{destroy:D});r.add(v).add(h).add(o).add(n).add(p).add(x).add(s).add(k).add(B).bind("keyup",w).bind("blur",A);r.add(v).add(h).add(o).add(n).add(p).add(x).bind("keydown",C);z.bind(m)};e.jPicker={List:[],Color:function(z){var q=this,j,o,t,u,n,A,x,k=new Array(),m=function(r){for(var h=0;h<k.length;h++){k[h].call(q,q,r)}},l=function(h,G,r){var F=G!==undefined;if(!F){if(h===undefined||h==null||h==""){h="all"}if(j==null){return null}switch(h.toLowerCase()){case"ahex":return g.rgbaToHex({r:j,g:o,b:t,a:u});case"hex":return l("ahex").substring(0,6);case"all":return{r:j,g:o,b:t,a:u,h:n,s:A,v:x,hex:l.call(q,"hex"),ahex:l.call(q,"ahex")};default:var D={};for(var B=0;B<h.length;B++){switch(h.charAt(B)){case"r":if(h.length==1){D=j}else{D.r=j}break;case"g":if(h.length==1){D=o}else{D.g=o}break;case"b":if(h.length==1){D=t}else{D.b=t}break;case"a":if(h.length==1){D=u}else{D.a=u}break;case"h":if(h.length==1){D=n}else{D.h=n}break;case"s":if(h.length==1){D=A}else{D.s=A}break;case"v":if(h.length==1){D=x}else{D.v=x}break}}return D=={}?l.call(q,"all"):D;break}}if(r!=null&&r==q){return}var v=false;if(h==null){h=""}if(G==null){if(j!=null){j=null;v=true}if(o!=null){o=null;v=true}if(t!=null){t=null;v=true}if(u!=null){u=null;v=true}if(n!=null){n=null;v=true}if(A!=null){A=null;v=true}if(x!=null){x=null;v=true}v&&m.call(q,r||q);return}switch(h.toLowerCase()){case"ahex":case"hex":var D=g.hexToRgba(G&&(G.ahex||G.hex)||G||"00000000");l.call(q,"rgba",{r:D.r,g:D.g,b:D.b,a:h=="ahex"?D.a:u!=null?u:255},r);break;default:if(G&&(G.ahex!=null||G.hex!=null)){l.call(q,"ahex",G.ahex||G.hex||"00000000",r);return}var s={},E=false,C=false;if(G.r!==undefined&&!h.indexOf("r")==-1){h+="r"}if(G.g!==undefined&&!h.indexOf("g")==-1){h+="g"}if(G.b!==undefined&&!h.indexOf("b")==-1){h+="b"}if(G.a!==undefined&&!h.indexOf("a")==-1){h+="a"}if(G.h!==undefined&&!h.indexOf("h")==-1){h+="h"}if(G.s!==undefined&&!h.indexOf("s")==-1){h+="s"}if(G.v!==undefined&&!h.indexOf("v")==-1){h+="v"}for(var B=0;B<h.length;B++){switch(h.charAt(B)){case"r":if(C){continue}E=true;s.r=G&&G.r&&G.r|0||G&&G|0||0;if(s.r<0){s.r=0}else{if(s.r>255){s.r=255}}if(j!=s.r){j=s.r;v=true}break;case"g":if(C){continue}E=true;s.g=G&&G.g&&G.g|0||G&&G|0||0;if(s.g<0){s.g=0}else{if(s.g>255){s.g=255}}if(o!=s.g){o=s.g;v=true}break;case"b":if(C){continue}E=true;s.b=G&&G.b&&G.b|0||G&&G|0||0;if(s.b<0){s.b=0}else{if(s.b>255){s.b=255}}if(t!=s.b){t=s.b;v=true}break;case"a":s.a=G&&G.a!=null?G.a|0:G!=null?G|0:255;if(s.a<0){s.a=0}else{if(s.a>255){s.a=255}}if(u!=s.a){u=s.a;v=true}break;case"h":if(E){continue}C=true;s.h=G&&G.h&&G.h|0||G&&G|0||0;if(s.h<0){s.h=0}else{if(s.h>360){s.h=360}}if(n!=s.h){n=s.h;v=true}break;case"s":if(E){continue}C=true;s.s=G&&G.s!=null?G.s|0:G!=null?G|0:100;if(s.s<0){s.s=0}else{if(s.s>100){s.s=100}}if(A!=s.s){A=s.s;v=true}break;case"v":if(E){continue}C=true;s.v=G&&G.v!=null?G.v|0:G!=null?G|0:100;if(s.v<0){s.v=0}else{if(s.v>100){s.v=100}}if(x!=s.v){x=s.v;v=true}break}}if(v){if(E){j=j||0;o=o||0;t=t||0;var D=g.rgbToHsv({r:j,g:o,b:t});n=D.h;A=D.s;x=D.v}else{if(C){n=n||0;A=A!=null?A:100;x=x!=null?x:100;var D=g.hsvToRgb({h:n,s:A,v:x});j=D.r;o=D.g;t=D.b}}u=u!=null?u:255;m.call(q,r||q)}break}},p=function(h){if(e.isFunction(h)){k.push(h)}},y=function(r){if(!e.isFunction(r)){return}var h;while((h=e.inArray(r,k))!=-1){k.splice(h,1)}},w=function(){k=null};e.extend(true,q,{val:l,bind:p,unbind:y,destroy:w});if(z){if(z.ahex!=null){l("ahex",z)}else{if(z.hex!=null){l((z.a!=null?"a":"")+"hex",z.a!=null?{ahex:z.hex+g.intToHex(z.a)}:z)}else{if(z.r!=null&&z.g!=null&&z.b!=null){l("rgb"+(z.a!=null?"a":""),z)}else{if(z.h!=null&&z.s!=null&&z.v!=null){l("hsv"+(z.a!=null?"a":""),z)}}}}}},ColorMethods:{hexToRgba:function(m){m=this.validateHex(m);if(m==""){return{r:null,g:null,b:null,a:null}}var l="00",k="00",h="00",j="255";if(m.length==6){m+="ff"}if(m.length>6){l=m.substring(0,2);k=m.substring(2,4);h=m.substring(4,6);j=m.substring(6,m.length)}else{if(m.length>4){l=m.substring(4,m.length);m=m.substring(0,4)}if(m.length>2){k=m.substring(2,m.length);m=m.substring(0,2)}if(m.length>0){h=m.substring(0,m.length)}}return{r:this.hexToInt(l),g:this.hexToInt(k),b:this.hexToInt(h),a:this.hexToInt(j)}},validateHex:function(h){h=h.toLowerCase().replace(/[^a-f0-9]/g,"");if(h.length>8){h=h.substring(0,8)}return h},rgbaToHex:function(h){return this.intToHex(h.r)+this.intToHex(h.g)+this.intToHex(h.b)+this.intToHex(h.a)},intToHex:function(j){var h=(j|0).toString(16);if(h.length==1){h=("0"+h)}return h.toLowerCase()},hexToInt:function(h){return parseInt(h,16)},rgbToHsv:function(l){var o=l.r/255,n=l.g/255,j=l.b/255,k={h:0,s:0,v:0},m=0,h=0,p;if(o>=n&&o>=j){h=o;m=n>j?j:n}else{if(n>=j&&n>=o){h=n;m=o>j?j:o}else{h=j;m=n>o?o:n}}k.v=h;k.s=h?(h-m)/h:0;if(!k.s){k.h=0}else{p=h-m;if(o==h){k.h=(n-j)/p}else{if(n==h){k.h=2+(j-o)/p}else{k.h=4+(o-n)/p}}k.h=parseInt(k.h*60);if(k.h<0){k.h+=360}}k.s=(k.s*100)|0;k.v=(k.v*100)|0;return k},hsvToRgb:function(n){var r={r:0,g:0,b:0,a:100},m=n.h,x=n.s,u=n.v;if(x==0){if(u==0){r.r=r.g=r.b=0}else{r.r=r.g=r.b=(u*255/100)|0}}else{if(m==360){m=0}m/=60;x=x/100;u=u/100;var l=m|0,o=m-l,k=u*(1-x),j=u*(1-(x*o)),w=u*(1-(x*(1-o)));switch(l){case 0:r.r=u;r.g=w;r.b=k;break;case 1:r.r=j;r.g=u;r.b=k;break;case 2:r.r=k;r.g=u;r.b=w;break;case 3:r.r=k;r.g=j;r.b=u;break;case 4:r.r=w;r.g=k;r.b=u;break;case 5:r.r=u;r.g=k;r.b=j;break}r.r=(r.r*255)|0;r.g=(r.g*255)|0;r.b=(r.b*255)|0}return r}}};var f=e.jPicker.Color,c=e.jPicker.List,g=e.jPicker.ColorMethods;e.fn.jPicker=function(j){var h=arguments;return this.each(function(){var w=this,av=e.extend(true,{},e.fn.jPicker.defaults,j);if(e(w).get(0).nodeName.toLowerCase()=="input"){e.extend(true,av,{window:{bindToInput:true,expandable:true,input:e(w)}});if(e(w).val()==""){av.color.active=new f({hex:null});av.color.current=new f({hex:null})}else{if(g.validateHex(e(w).val())){av.color.active=new f({hex:e(w).val(),a:av.color.active.val("a")});av.color.current=new f({hex:e(w).val(),a:av.color.active.val("a")})}}}if(av.window.expandable){e(w).after('<span class="jPicker"><span class="Icon"><span class="Color">&nbsp;</span><span class="Alpha">&nbsp;</span><span class="Image" title="Click To Open Color Picker">&nbsp;</span><span class="Container">&nbsp;</span></span></span>')}else{av.window.liveUpdate=false}var Q=parseFloat(navigator.appVersion.split("MSIE")[1])<7&&document.body.filters,R=null,l=null,s=null,au=null,at=null,ar=null,P=null,O=null,N=null,M=null,L=null,K=null,D=null,U=null,aw=null,J=null,I=null,am=null,ai=null,E=null,an=null,ah=null,X=null,ab=null,aq=null,r=null,C=null,u=null,ag=function(aB){var aD=G.active,aE=n.clientPath,aA=aD.val("hex"),aC,az;av.color.mode=aB;switch(aB){case"h":setTimeout(function(){y.call(w,l,"transparent");x.call(w,au,0);Y.call(w,au,100);x.call(w,at,260);Y.call(w,at,100);y.call(w,s,"transparent");x.call(w,P,0);Y.call(w,P,100);x.call(w,O,260);Y.call(w,O,100);x.call(w,N,260);Y.call(w,N,100);x.call(w,M,260);Y.call(w,M,100);x.call(w,K,260);Y.call(w,K,100)},0);D.range("all",{minX:0,maxX:100,minY:0,maxY:100});U.range("rangeY",{minY:0,maxY:360});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("s"),y:100-aD.val("v")},D);U.val("y",360-aD.val("h"),U);break;case"s":setTimeout(function(){y.call(w,l,"transparent");x.call(w,au,-260);x.call(w,at,-520);x.call(w,P,-260);x.call(w,O,-520);x.call(w,K,260);Y.call(w,K,100)},0);D.range("all",{minX:0,maxX:360,minY:0,maxY:100});U.range("rangeY",{minY:0,maxY:100});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("h"),y:100-aD.val("v")},D);U.val("y",100-aD.val("s"),U);break;case"v":setTimeout(function(){y.call(w,l,"000000");x.call(w,au,-780);x.call(w,at,260);y.call(w,s,aA);x.call(w,P,-520);x.call(w,O,260);Y.call(w,O,100);x.call(w,K,260);Y.call(w,K,100)},0);D.range("all",{minX:0,maxX:360,minY:0,maxY:100});U.range("rangeY",{minY:0,maxY:100});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("h"),y:100-aD.val("s")},D);U.val("y",100-aD.val("v"),U);break;case"r":aC=-1040;az=-780;D.range("all",{minX:0,maxX:255,minY:0,maxY:255});U.range("rangeY",{minY:0,maxY:255});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("b"),y:255-aD.val("g")},D);U.val("y",255-aD.val("r"),U);break;case"g":aC=-1560;az=-1820;D.range("all",{minX:0,maxX:255,minY:0,maxY:255});U.range("rangeY",{minY:0,maxY:255});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("b"),y:255-aD.val("r")},D);U.val("y",255-aD.val("g"),U);break;case"b":aC=-2080;az=-2860;D.range("all",{minX:0,maxX:255,minY:0,maxY:255});U.range("rangeY",{minY:0,maxY:255});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("r"),y:255-aD.val("g")},D);U.val("y",255-aD.val("b"),U);break;case"a":setTimeout(function(){y.call(w,l,"transparent");x.call(w,au,-260);x.call(w,at,-520);x.call(w,P,260);x.call(w,O,260);Y.call(w,O,100);x.call(w,K,0);Y.call(w,K,100)},0);D.range("all",{minX:0,maxX:360,minY:0,maxY:100});U.range("rangeY",{minY:0,maxY:255});if(aD.val("ahex")==null){break}D.val("xy",{x:aD.val("h"),y:100-aD.val("v")},D);U.val("y",255-aD.val("a"),U);break;default:throw ("Invalid Mode");break}switch(aB){case"h":break;case"s":case"v":case"a":setTimeout(function(){Y.call(w,au,100);Y.call(w,P,100);x.call(w,N,260);Y.call(w,N,100);x.call(w,M,260);Y.call(w,M,100)},0);break;case"r":case"g":case"b":setTimeout(function(){y.call(w,l,"transparent");y.call(w,s,"transparent");Y.call(w,P,100);Y.call(w,au,100);x.call(w,au,aC);x.call(w,at,aC-260);x.call(w,P,az-780);x.call(w,O,az-520);x.call(w,N,az);x.call(w,M,az-260);x.call(w,K,260);Y.call(w,K,100)},0);break}if(aD.val("ahex")==null){return}aj.call(w,aD)},aj=function(aA,az){if(az==null||(az!=U&&az!=D)){v.call(w,aA,az)}setTimeout(function(){ay.call(w,aA);al.call(w,aA);W.call(w,aA)},0)},z=function(aA,az){var aC=G.active;if(az!=D&&aC.val()==null){return}var aB=aA.val("all");switch(av.color.mode){case"h":aC.val("sv",{s:aB.x,v:100-aB.y},az);break;case"s":case"a":aC.val("hv",{h:aB.x,v:100-aB.y},az);break;case"v":aC.val("hs",{h:aB.x,s:100-aB.y},az);break;case"r":aC.val("gb",{g:255-aB.y,b:aB.x},az);break;case"g":aC.val("rb",{r:255-aB.y,b:aB.x},az);break;case"b":aC.val("rg",{r:aB.x,g:255-aB.y},az);break}},ac=function(aA,az){var aB=G.active;if(az!=U&&aB.val()==null){return}switch(av.color.mode){case"h":aB.val("h",{h:360-aA.val("y")},az);break;case"s":aB.val("s",{s:100-aA.val("y")},az);break;case"v":aB.val("v",{v:100-aA.val("y")},az);break;case"r":aB.val("r",{r:255-aA.val("y")},az);break;case"g":aB.val("g",{g:255-aA.val("y")},az);break;case"b":aB.val("b",{b:255-aA.val("y")},az);break;case"a":aB.val("a",255-aA.val("y"),az);break}},v=function(aC,az){if(az!=D){switch(av.color.mode){case"h":var aH=aC.val("sv");D.val("xy",{x:aH!=null?aH.s:100,y:100-(aH!=null?aH.v:100)},az);break;case"s":case"a":var aB=aC.val("hv");D.val("xy",{x:aB&&aB.h||0,y:100-(aB!=null?aB.v:100)},az);break;case"v":var aE=aC.val("hs");D.val("xy",{x:aE&&aE.h||0,y:100-(aE!=null?aE.s:100)},az);break;case"r":var aA=aC.val("bg");D.val("xy",{x:aA&&aA.b||0,y:255-(aA&&aA.g||0)},az);break;case"g":var aI=aC.val("br");D.val("xy",{x:aI&&aI.b||0,y:255-(aI&&aI.r||0)},az);break;case"b":var aG=aC.val("rg");D.val("xy",{x:aG&&aG.r||0,y:255-(aG&&aG.g||0)},az);break}}if(az!=U){switch(av.color.mode){case"h":U.val("y",360-(aC.val("h")||0),az);break;case"s":var aJ=aC.val("s");U.val("y",100-(aJ!=null?aJ:100),az);break;case"v":var aF=aC.val("v");U.val("y",100-(aF!=null?aF:100),az);break;case"r":U.val("y",255-(aC.val("r")||0),az);break;case"g":U.val("y",255-(aC.val("g")||0),az);break;case"b":U.val("y",255-(aC.val("b")||0),az);break;case"a":var aD=aC.val("a");U.val("y",255-(aD!=null?aD:255),az);break}}},ay=function(aA){try{var az=aA.val("all");E.css({backgroundColor:az&&"#"+az.hex||"transparent"});Y.call(w,E,az&&Math.precision((az.a*100)/255,4)||0)}catch(aB){}},al=function(aC){switch(av.color.mode){case"h":y.call(w,l,new f({h:aC.val("h")||0,s:100,v:100}).val("hex"));break;case"s":case"a":var aB=aC.val("s");Y.call(w,at,100-(aB!=null?aB:100));break;case"v":var aA=aC.val("v");Y.call(w,au,aA!=null?aA:100);break;case"r":Y.call(w,at,Math.precision((aC.val("r")||0)/255*100,4));break;case"g":Y.call(w,at,Math.precision((aC.val("g")||0)/255*100,4));break;case"b":Y.call(w,at,Math.precision((aC.val("b")||0)/255*100));break}var az=aC.val("a");Y.call(w,ar,Math.precision(((255-(az||0))*100)/255,4))},W=function(aF){switch(av.color.mode){case"h":var aH=aF.val("a");Y.call(w,L,Math.precision(((255-(aH||0))*100)/255,4));break;case"s":var aA=aF.val("hva"),aB=new f({h:aA&&aA.h||0,s:100,v:aA!=null?aA.v:100});y.call(w,s,aB.val("hex"));Y.call(w,O,100-(aA!=null?aA.v:100));Y.call(w,L,Math.precision(((255-(aA&&aA.a||0))*100)/255,4));break;case"v":var aC=aF.val("hsa"),aE=new f({h:aC&&aC.h||0,s:aC!=null?aC.s:100,v:100});y.call(w,s,aE.val("hex"));Y.call(w,L,Math.precision(((255-(aC&&aC.a||0))*100)/255,4));break;case"r":case"g":case"b":var aD=0,aG=0,az=aF.val("rgba");if(av.color.mode=="r"){aD=az&&az.b||0;aG=az&&az.g||0}else{if(av.color.mode=="g"){aD=az&&az.b||0;aG=az&&az.r||0}else{if(av.color.mode=="b"){aD=az&&az.r||0;aG=az&&az.g||0}}}var aI=aG>aD?aD:aG;Y.call(w,O,aD>aG?Math.precision(((aD-aG)/(255-aG))*100,4):0);Y.call(w,N,aG>aD?Math.precision(((aG-aD)/(255-aD))*100,4):0);Y.call(w,M,Math.precision((aI/255)*100,4));Y.call(w,L,Math.precision(((255-(az&&az.a||0))*100)/255,4));break;case"a":var aH=aF.val("a");y.call(w,s,aF.val("hex")||"000000");Y.call(w,L,aH!=null?0:100);Y.call(w,K,aH!=null?100:0);break}},y=function(az,aA){az.css({backgroundColor:aA&&aA.length==6&&"#"+aA||"transparent"})},t=function(az,aA){if(Q&&(aA.indexOf("AlphaBar.png")!=-1||aA.indexOf("Bars.png")!=-1||aA.indexOf("Maps.png")!=-1)){az.attr("pngSrc",aA);az.css({backgroundImage:"none",filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+aA+"', sizingMethod='scale')"})}else{az.css({backgroundImage:"url('"+aA+"')"})}},x=function(az,aA){az.css({top:aA+"px"})},Y=function(aA,az){aA.css({visibility:az>0?"visible":"hidden"});if(az>0&&az<100){if(Q){var aB=aA.attr("pngSrc");if(aB!=null&&(aB.indexOf("AlphaBar.png")!=-1||aB.indexOf("Bars.png")!=-1||aB.indexOf("Maps.png")!=-1)){aA.css({filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+aB+"', sizingMethod='scale') progid:DXImageTransform.Microsoft.Alpha(opacity="+az+")"})}else{aA.css({opacity:Math.precision(az/100,4)})}}else{aA.css({opacity:Math.precision(az/100,4)})}}else{if(az==0||az==100){if(Q){var aB=aA.attr("pngSrc");if(aB!=null&&(aB.indexOf("AlphaBar.png")!=-1||aB.indexOf("Bars.png")!=-1||aB.indexOf("Maps.png")!=-1)){aA.css({filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+aB+"', sizingMethod='scale')"})}else{aA.css({opacity:""})}}else{aA.css({opacity:""})}}}},B=function(){G.active.val("ahex",G.current.val("ahex"))},T=function(){G.current.val("ahex",G.active.val("ahex"))},A=function(az){e(this).parents("tbody:first").find('input:radio[value!="'+az.target.value+'"]').removeAttr("checked");ag.call(w,az.target.value)},Z=function(){B.call(w)},q=function(){B.call(w);av.window.expandable&&ao.call(w);e.isFunction(ax)&&ax.call(w,G.active,X)},m=function(){T.call(w);av.window.expandable&&ao.call(w);e.isFunction(ae)&&ae.call(w,G.active,ah)},af=function(){V.call(w)},ap=function(aB,az){var aA=aB.val("hex");an.css({backgroundColor:aA&&"#"+aA||"transparent"});Y.call(w,an,Math.precision(((aB.val("a")||0)*100)/255,4))},H=function(aC,az){var aB=aC.val("hex");var aA=aC.val("va");aq.css({backgroundColor:aB&&"#"+aB||"transparent"});Y.call(w,r,Math.precision(((255-(aA&&aA.a||0))*100)/255,4));if(av.window.bindToInput&&av.window.updateInputColor){av.window.input.css({backgroundColor:aB&&"#"+aB||"transparent",color:aA==null||aA.v>75?"#000000":"#ffffff"})}},S=function(aB){var az=av.window.element,aA=av.window.page;J=parseInt(R.css("left"));I=parseInt(R.css("top"));am=aB.pageX;ai=aB.pageY;e(document).bind("mousemove",k).bind("mouseup",p);aB.preventDefault()},k=function(az){R.css({left:J-(am-az.pageX)+"px",top:I-(ai-az.pageY)+"px"});if(av.window.expandable&&!e.support.boxModel){R.prev().css({left:R.css("left"),top:R.css("top")})}az.stopPropagation();az.preventDefault();return false},p=function(az){e(document).unbind("mousemove",k).unbind("mouseup",p);az.stopPropagation();az.preventDefault();return false},F=function(az){az.preventDefault();az.stopPropagation();G.active.val("ahex",e(this).attr("title")||null,az.target);return false},ae=e.isFunction(h[1])&&h[1]||null,ad=e.isFunction(h[2])&&h[2]||null,ax=e.isFunction(h[3])&&h[3]||null,V=function(){G.current.val("ahex",G.active.val("ahex"));var az=function(){if(!av.window.expandable||e.support.boxModel){return}var aA=R.find("table:first");R.before("<iframe/>");R.prev().css({width:aA.width(),height:R.height(),opacity:0,position:"absolute",left:R.css("left"),top:R.css("top")})};if(av.window.expandable){e(document.body).children("div.jPicker.Container").css({zIndex:10});R.css({zIndex:20})}switch(av.window.effects.type){case"fade":R.fadeIn(av.window.effects.speed.show,az);break;case"slide":R.slideDown(av.window.effects.speed.show,az);break;case"show":default:R.show(av.window.effects.speed.show,az);break}},ao=function(){var az=function(){if(av.window.expandable){R.css({zIndex:10})}if(!av.window.expandable||e.support.boxModel){return}R.prev().remove()};switch(av.window.effects.type){case"fade":R.fadeOut(av.window.effects.speed.hide,az);break;case"slide":R.slideUp(av.window.effects.speed.hide,az);break;case"show":default:R.hide(av.window.effects.speed.hide,az);break}},o=function(){var aG=av.window,az=aG.expandable?e(w).next().find(".Container:first"):null;R=aG.expandable?e("<div/>"):e(w);R.addClass("jPicker Container");if(aG.expandable){R.hide()}R.get(0).onselectstart=function(aN){if(aN.target.nodeName.toLowerCase()!=="input"){return false}};var aJ=G.active.val("all");if(aG.alphaPrecision<0){aG.alphaPrecision=0}else{if(aG.alphaPrecision>2){aG.alphaPrecision=2}}var aK='<table class="jPicker" cellpadding="0" cellspacing="0"><tbody>'+(aG.expandable?'<tr><td class="Move" colspan="5">&nbsp;</td></tr>':"")+'<tr><td rowspan="9"><h2 class="Title">'+(aG.title||aa.text.title)+'</h2><div class="Map"><span class="Map1">&nbsp;</span><span class="Map2">&nbsp;</span><span class="Map3">&nbsp;</span><img src="'+n.clientPath+n.colorMap.arrow.file+'" class="Arrow"/></div></td><td rowspan="9"><div class="Bar"><span class="Map1">&nbsp;</span><span class="Map2">&nbsp;</span><span class="Map3">&nbsp;</span><span class="Map4">&nbsp;</span><span class="Map5">&nbsp;</span><span class="Map6">&nbsp;</span><img src="'+n.clientPath+n.colorBar.arrow.file+'" class="Arrow"/></div></td><td colspan="2" class="Preview">'+aa.text.newColor+'<div><span class="Active" title="'+aa.tooltips.colors.newColor+'">&nbsp;</span><span class="Current" title="'+aa.tooltips.colors.currentColor+'">&nbsp;</span></div>'+aa.text.currentColor+'</td><td rowspan="9" class="Button"><input type="button" class="Ok" value="'+aa.text.ok+'" title="'+aa.tooltips.buttons.ok+'"/><input type="button" class="Cancel" value="'+aa.text.cancel+'" title="'+aa.tooltips.buttons.cancel+'"/><hr/><div class="Grid">&nbsp;</div></td></tr><tr class="Hue"><td class="Radio"><label title="'+aa.tooltips.hue.radio+'"><input type="radio" value="h"'+(av.color.mode=="h"?' checked="checked"':"")+'/>H:</label></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.h:"")+'" title="'+aa.tooltips.hue.textbox+'"/>&nbsp;&deg;</td></tr><tr class="Saturation"><td class="Radio"><label title="'+aa.tooltips.saturation.radio+'"><input type="radio" value="s"'+(av.color.mode=="s"?' checked="checked"':"")+'/>S:</label></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.s:"")+'" title="'+aa.tooltips.saturation.textbox+'"/>&nbsp;%</td></tr><tr class="Value"><td class="Radio"><label title="'+aa.tooltips.value.radio+'"><input type="radio" value="v"'+(av.color.mode=="v"?' checked="checked"':"")+'/>V:</label><br/><br/></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.v:"")+'" title="'+aa.tooltips.value.textbox+'"/>&nbsp;%<br/><br/></td></tr><tr class="Red"><td class="Radio"><label title="'+aa.tooltips.red.radio+'"><input type="radio" value="r"'+(av.color.mode=="r"?' checked="checked"':"")+'/>R:</label></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.r:"")+'" title="'+aa.tooltips.red.textbox+'"/></td></tr><tr class="Green"><td class="Radio"><label title="'+aa.tooltips.green.radio+'"><input type="radio" value="g"'+(av.color.mode=="g"?' checked="checked"':"")+'/>G:</label></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.g:"")+'" title="'+aa.tooltips.green.textbox+'"/></td></tr><tr class="Blue"><td class="Radio"><label title="'+aa.tooltips.blue.radio+'"><input type="radio" value="b"'+(av.color.mode=="b"?' checked="checked"':"")+'/>B:</label></td><td class="Text"><input type="text" maxlength="3" value="'+(aJ!=null?aJ.b:"")+'" title="'+aa.tooltips.blue.textbox+'"/></td></tr><tr class="Alpha"><td class="Radio">'+(aG.alphaSupport?'<label title="'+aa.tooltips.alpha.radio+'"><input type="radio" value="a"'+(av.color.mode=="a"?' checked="checked"':"")+"/>A:</label>":"&nbsp;")+'</td><td class="Text">'+(aG.alphaSupport?'<input type="text" maxlength="'+(3+aG.alphaPrecision)+'" value="'+(aJ!=null?Math.precision((aJ.a*100)/255,aG.alphaPrecision):"")+'" title="'+aa.tooltips.alpha.textbox+'"/>&nbsp;%':"&nbsp;")+'</td></tr><tr class="Hex"><td colspan="2" class="Text"><label title="'+aa.tooltips.hex.textbox+'">#:<input type="text" maxlength="6" class="Hex" value="'+(aJ!=null?aJ.hex:"")+'"/></label>'+(aG.alphaSupport?'<input type="text" maxlength="2" class="AHex" value="'+(aJ!=null?aJ.ahex.substring(6):"")+'" title="'+aa.tooltips.hex.alpha+'"/></td>':"&nbsp;")+"</tr></tbody></table>";if(aG.expandable){R.html(aK);if(e(document.body).children("div.jPicker.Container").length==0){e(document.body).prepend(R)}else{e(document.body).children("div.jPicker.Container:last").after(R)}R.mousedown(function(){e(document.body).children("div.jPicker.Container").css({zIndex:10});R.css({zIndex:20})});R.css({left:aG.position.x=="left"?(az.offset().left-530-(aG.position.y=="center"?25:0))+"px":aG.position.x=="center"?(az.offset().left-260)+"px":aG.position.x=="right"?(az.offset().left-10+(aG.position.y=="center"?25:0))+"px":aG.position.x=="screenCenter"?((e(document).width()>>1)-260)+"px":(az.offset().left+parseInt(aG.position.x))+"px",position:"absolute",top:aG.position.y=="top"?(az.offset().top-312)+"px":aG.position.y=="center"?(az.offset().top-156)+"px":aG.position.y=="bottom"?(az.offset().top+25)+"px":(az.offset().top+parseInt(aG.position.y))+"px"})}else{R=e(w);R.html(aK)}var aD=R.find("tbody:first");l=aD.find("div.Map:first");s=aD.find("div.Bar:first");var aL=l.find("span"),aI=s.find("span");au=aL.filter(".Map1:first");at=aL.filter(".Map2:first");ar=aL.filter(".Map3:first");P=aI.filter(".Map1:first");O=aI.filter(".Map2:first");N=aI.filter(".Map3:first");M=aI.filter(".Map4:first");L=aI.filter(".Map5:first");K=aI.filter(".Map6:first");D=new d(l,{map:{width:n.colorMap.width,height:n.colorMap.height},arrow:{image:n.clientPath+n.colorMap.arrow.file,width:n.colorMap.arrow.width,height:n.colorMap.arrow.height}});D.bind(z);U=new d(s,{map:{width:n.colorBar.width,height:n.colorBar.height},arrow:{image:n.clientPath+n.colorBar.arrow.file,width:n.colorBar.arrow.width,height:n.colorBar.arrow.height}});U.bind(ac);aw=new b(aD,G.active,aG.expandable&&aG.bindToInput?aG.input:null,aG.alphaPrecision);var aB=aJ!=null?aJ.hex:null,aH=aD.find(".Preview"),aF=aD.find(".Button");E=aH.find(".Active:first").css({backgroundColor:aB&&"#"+aB||"transparent"});an=aH.find(".Current:first").css({backgroundColor:aB&&"#"+aB||"transparent"}).bind("click",Z);Y.call(w,an,Math.precision(G.current.val("a")*100)/255,4);ah=aF.find(".Ok:first").bind("click",m);X=aF.find(".Cancel:first").bind("click",q);ab=aF.find(".Grid:first");setTimeout(function(){t.call(w,au,n.clientPath+"Maps.png");t.call(w,at,n.clientPath+"Maps.png");t.call(w,ar,n.clientPath+"map-opacity.png");t.call(w,P,n.clientPath+"Bars.png");t.call(w,O,n.clientPath+"Bars.png");t.call(w,N,n.clientPath+"Bars.png");t.call(w,M,n.clientPath+"Bars.png");t.call(w,L,n.clientPath+"bar-opacity.png");t.call(w,K,n.clientPath+"AlphaBar.png");t.call(w,aH.find("div:first"),n.clientPath+"preview-opacity.png")},0);aD.find("td.Radio input").bind("click",A);if(G.quickList&&G.quickList.length>0){var aE="";for(i=0;i<G.quickList.length;i++){if((typeof(G.quickList[i])).toString().toLowerCase()=="string"){G.quickList[i]=new f({hex:G.quickList[i]})}var aC=G.quickList[i].val("a");var aM=G.quickList[i].val("ahex");if(!aG.alphaSupport&&aM){aM=aM.substring(0,6)+"ff"}var aA=G.quickList[i].val("hex");aE+='<span class="QuickColor"'+(aM&&' title="#'+aM+'"'||"")+' style="background-color:'+(aA&&"#"+aA||"")+";"+(aA?"":"background-image:url("+n.clientPath+"NoColor.png)")+(aG.alphaSupport&&aC&&aC<255?";opacity:"+Math.precision(aC/255,4)+";filter:Alpha(opacity="+Math.precision(aC/2.55,4)+")":"")+'">&nbsp;</span>'}t.call(w,ab,n.clientPath+"bar-opacity.png");ab.html(aE);ab.find(".QuickColor").click(F)}ag.call(w,av.color.mode);G.active.bind(aj);e.isFunction(ad)&&G.active.bind(ad);G.current.bind(ap);if(aG.expandable){w.icon=az.parents(".Icon:first");aq=w.icon.find(".Color:first").css({backgroundColor:aB&&"#"+aB||"transparent"});r=w.icon.find(".Alpha:first");t.call(w,r,n.clientPath+"bar-opacity.png");Y.call(w,r,Math.precision(((255-(aJ!=null?aJ.a:0))*100)/255,4));C=w.icon.find(".Image:first").css({backgroundImage:"url('"+n.clientPath+n.picker.file+"')"}).bind("click",af);if(aG.bindToInput&&aG.updateInputColor){aG.input.css({backgroundColor:aB&&"#"+aB||"transparent",color:aJ==null||aJ.v>75?"#000000":"#ffffff"})}u=aD.find(".Move:first").bind("mousedown",S);G.active.bind(H)}else{V.call(w)}},ak=function(){R.find("td.Radio input").unbind("click",A);an.unbind("click",Z);X.unbind("click",q);ah.unbind("click",m);if(av.window.expandable){C.unbind("click",af);u.unbind("mousedown",S);w.icon=null}R.find(".QuickColor").unbind("click",F);l=null;s=null;au=null;at=null;ar=null;P=null;O=null;N=null;M=null;L=null;K=null;D.destroy();D=null;U.destroy();U=null;aw.destroy();aw=null;E=null;an=null;ah=null;X=null;ab=null;ae=null;ax=null;ad=null;R.html("");for(i=0;i<c.length;i++){if(c[i]==w){c.splice(i,1)}}},n=av.images,aa=av.localization,G={active:(typeof(av.color.active)).toString().toLowerCase()=="string"?new f({ahex:!av.window.alphaSupport&&av.color.active?av.color.active.substring(0,6)+"ff":av.color.active}):new f({ahex:!av.window.alphaSupport&&av.color.active.val("ahex")?av.color.active.val("ahex").substring(0,6)+"ff":av.color.active.val("ahex")}),current:(typeof(av.color.active)).toString().toLowerCase()=="string"?new f({ahex:!av.window.alphaSupport&&av.color.active?av.color.active.substring(0,6)+"ff":av.color.active}):new f({ahex:!av.window.alphaSupport&&av.color.active.val("ahex")?av.color.active.val("ahex").substring(0,6)+"ff":av.color.active.val("ahex")}),quickList:av.color.quickList};e.extend(true,w,{commitCallback:ae,liveCallback:ad,cancelCallback:ax,color:G,show:V,hide:ao,destroy:ak});c.push(w);setTimeout(function(){o.call(w)},0)})};e.fn.jPicker.defaults={window:{title:null,effects:{type:"slide",speed:{show:"slow",hide:"fast"}},position:{x:"screenCenter",y:"top"},expandable:false,liveUpdate:true,alphaSupport:false,alphaPrecision:0,updateInputColor:true},color:{mode:"h",active:new f({ahex:"#ffcc00ff"}),quickList:[new f({h:360,s:33,v:100}),new f({h:360,s:66,v:100}),new f({h:360,s:100,v:100}),new f({h:360,s:100,v:75}),new f({h:360,s:100,v:50}),new f({h:180,s:0,v:100}),new f({h:30,s:33,v:100}),new f({h:30,s:66,v:100}),new f({h:30,s:100,v:100}),new f({h:30,s:100,v:75}),new f({h:30,s:100,v:50}),new f({h:180,s:0,v:90}),new f({h:60,s:33,v:100}),new f({h:60,s:66,v:100}),new f({h:60,s:100,v:100}),new f({h:60,s:100,v:75}),new f({h:60,s:100,v:50}),new f({h:180,s:0,v:80}),new f({h:90,s:33,v:100}),new f({h:90,s:66,v:100}),new f({h:90,s:100,v:100}),new f({h:90,s:100,v:75}),new f({h:90,s:100,v:50}),new f({h:180,s:0,v:70}),new f({h:120,s:33,v:100}),new f({h:120,s:66,v:100}),new f({h:120,s:100,v:100}),new f({h:120,s:100,v:75}),new f({h:120,s:100,v:50}),new f({h:180,s:0,v:60}),new f({h:150,s:33,v:100}),new f({h:150,s:66,v:100}),new f({h:150,s:100,v:100}),new f({h:150,s:100,v:75}),new f({h:150,s:100,v:50}),new f({h:180,s:0,v:50}),new f({h:180,s:33,v:100}),new f({h:180,s:66,v:100}),new f({h:180,s:100,v:100}),new f({h:180,s:100,v:75}),new f({h:180,s:100,v:50}),new f({h:180,s:0,v:40}),new f({h:210,s:33,v:100}),new f({h:210,s:66,v:100}),new f({h:210,s:100,v:100}),new f({h:210,s:100,v:75}),new f({h:210,s:100,v:50}),new f({h:180,s:0,v:30}),new f({h:240,s:33,v:100}),new f({h:240,s:66,v:100}),new f({h:240,s:100,v:100}),new f({h:240,s:100,v:75}),new f({h:240,s:100,v:50}),new f({h:180,s:0,v:20}),new f({h:270,s:33,v:100}),new f({h:270,s:66,v:100}),new f({h:270,s:100,v:100}),new f({h:270,s:100,v:75}),new f({h:270,s:100,v:50}),new f({h:180,s:0,v:10}),new f({h:300,s:33,v:100}),new f({h:300,s:66,v:100}),new f({h:300,s:100,v:100}),new f({h:300,s:100,v:75}),new f({h:300,s:100,v:50}),new f({h:180,s:0,v:0}),new f({h:330,s:33,v:100}),new f({h:330,s:66,v:100}),new f({h:330,s:100,v:100}),new f({h:330,s:100,v:75}),new f({h:330,s:100,v:50}),new f()]},images:{clientPath:"/jPicker/images/",colorMap:{width:256,height:256,arrow:{file:"mappoint.gif",width:15,height:15}},colorBar:{width:20,height:256,arrow:{file:"rangearrows.gif",width:20,height:7}},picker:{file:"picker.gif",width:25,height:24}},localization:{text:{title:"Drag Markers To Pick A Color",newColor:"new",currentColor:"current",ok:"OK",cancel:"Cancel"},tooltips:{colors:{newColor:"New Color - Press &ldquo;OK&rdquo; To Commit",currentColor:"Click To Revert To Original Color"},buttons:{ok:"Commit To This Color Selection",cancel:"Cancel And Revert To Original Color"},hue:{radio:"Set To &ldquo;Hue&rdquo; Color Mode",textbox:"Enter A &ldquo;Hue&rdquo; Value (0-360&deg;)"},saturation:{radio:"Set To &ldquo;Saturation&rdquo; Color Mode",textbox:"Enter A &ldquo;Saturation&rdquo; Value (0-100%)"},value:{radio:"Set To &ldquo;Value&rdquo; Color Mode",textbox:"Enter A &ldquo;Value&rdquo; Value (0-100%)"},red:{radio:"Set To &ldquo;Red&rdquo; Color Mode",textbox:"Enter A &ldquo;Red&rdquo; Value (0-255)"},green:{radio:"Set To &ldquo;Green&rdquo; Color Mode",textbox:"Enter A &ldquo;Green&rdquo; Value (0-255)"},blue:{radio:"Set To &ldquo;Blue&rdquo; Color Mode",textbox:"Enter A &ldquo;Blue&rdquo; Value (0-255)"},alpha:{radio:"Set To &ldquo;Alpha&rdquo; Color Mode",textbox:"Enter A &ldquo;Alpha&rdquo; Value (0-100)"},hex:{textbox:"Enter A &ldquo;Hex&rdquo; Color Value (#000000-#ffffff)",alpha:"Enter A &ldquo;Alpha&rdquo; Value (#00-#ff)"}}}}})(jQuery,"1.1.6");

/* SoundManager 2.97a.20111220 */
(function(G){function W(W,la){function l(b){return function(a){var d=this._t;return!d||!d._a?(d&&d.sID?c._wD(k+"ignoring "+a.type+": "+d.sID):c._wD(k+"ignoring "+a.type),null):b.call(this,a)}}this.flashVersion=8;this.debugMode=!0;this.debugFlash=!1;this.consoleOnly=this.useConsole=!0;this.waitForWindowLoad=!1;this.bgColor="#ffffff";this.useHighPerformance=!1;this.html5PollingInterval=this.flashPollingInterval=null;this.flashLoadTimeout=1E3;this.wmode=null;this.allowScriptAccess="always";this.useFlashBlock=
!1;this.useHTML5Audio=!0;this.html5Test=/^(probably|maybe)$/i;this.preferFlash=!0;this.noSWFCache=!1;this.audioFormats={mp3:{type:['audio/mpeg; codecs="mp3"',"audio/mpeg","audio/mp3","audio/MPA","audio/mpa-robust"],required:!0},mp4:{related:["aac","m4a"],type:['audio/mp4; codecs="mp4a.40.2"',"audio/aac","audio/x-m4a","audio/MP4A-LATM","audio/mpeg4-generic"],required:!1},ogg:{type:["audio/ogg; codecs=vorbis"],required:!1},wav:{type:['audio/wav; codecs="1"',"audio/wav","audio/wave","audio/x-wav"],required:!1}};
this.defaultOptions={autoLoad:!1,autoPlay:!1,from:null,loops:1,onid3:null,onload:null,whileloading:null,onplay:null,onpause:null,onresume:null,whileplaying:null,onposition:null,onstop:null,onfailure:null,onfinish:null,multiShot:!0,multiShotEvents:!1,position:null,pan:0,stream:!0,to:null,type:null,usePolicyFile:!1,volume:100};this.flash9Options={isMovieStar:null,usePeakData:!1,useWaveformData:!1,useEQData:!1,onbufferchange:null,ondataerror:null};this.movieStarOptions={bufferTime:3,serverURL:null,onconnect:null,
duration:null};this.movieID="sm2-container";this.id=la||"sm2movie";this.debugID="soundmanager-debug";this.debugURLParam=/([#?&])debug=1/i;this.versionNumber="V2.97a.20111220";this.movieURL=this.version=null;this.url=W||null;this.altURL=null;this.enabled=this.swfLoaded=!1;this.oMC=null;this.sounds={};this.soundIDs=[];this.didFlashBlock=this.muted=!1;this.filePattern=null;this.filePatterns={flash8:/\.mp3(\?.*)?$/i,flash9:/\.mp3(\?.*)?$/i};this.features={buffering:!1,peakData:!1,waveformData:!1,eqData:!1,
movieStar:!1};this.sandbox={type:null,types:{remote:"remote (domain-based) rules",localWithFile:"local with file access (no internet access)",localWithNetwork:"local with network (internet access only, no local access)",localTrusted:"local, trusted (local+internet access)"},description:null,noRemote:null,noLocal:null};var ma;try{ma="undefined"!==typeof Audio&&"undefined"!==typeof(new Audio).canPlayType}catch(fb){ma=!1}this.hasHTML5=ma;this.html5={usingFlash:null};this.flash={};this.ignoreFlash=this.html5Only=
!1;var Ea,c=this,i=null,k="HTML5::",u,p=navigator.userAgent,j=G,O=j.location.href.toString(),h=document,na,X,m,B=[],oa=!0,w,P=!1,Q=!1,n=!1,y=!1,Y=!1,o,Za=0,R,v,pa,H,I,Z,Fa,qa,E,$,aa,J,ra,sa,ba,ca,K,Ga,ta,$a=["log","info","warn","error"],Ha,da,Ia,S=null,ua=null,q,va,L,Ja,ea,fa,wa,s,ga=!1,xa=!1,Ka,La,Ma,ha=0,T=null,ia,z=null,Na,ja,U,C,ya,za,Oa,r,Pa=Array.prototype.slice,F=!1,t,ka,Qa,A,Ra,Aa=p.match(/(ipad|iphone|ipod)/i),ab=p.match(/firefox/i),bb=p.match(/droid/i),D=p.match(/msie/i),cb=p.match(/webkit/i),
V=p.match(/safari/i)&&!p.match(/chrome/i),db=p.match(/opera/i),Ba=p.match(/(mobile|pre\/|xoom)/i)||Aa,Ca=!O.match(/usehtml5audio/i)&&!O.match(/sm2\-ignorebadua/i)&&V&&!p.match(/silk/i)&&p.match(/OS X 10_6_([3-7])/i),Sa="undefined"!==typeof console&&"undefined"!==typeof console.log,Da="undefined"!==typeof h.hasFocus?h.hasFocus():null,M=V&&"undefined"===typeof h.hasFocus,Ta=!M,Ua=/(mp3|mp4|mpa)/i,N=h.location?h.location.protocol.match(/http/i):null,Va=!N?"http://":"",Wa=/^\s*audio\/(?:x-)?(?:mpeg4|aac|flv|mov|mp4||m4v|m4a|mp4v|3gp|3g2)\s*(?:$|;)/i,
Xa="mpeg4,aac,flv,mov,mp4,m4v,f4v,m4a,mp4v,3gp,3g2".split(","),eb=RegExp("\\.("+Xa.join("|")+")(\\?.*)?$","i");this.mimePattern=/^\s*audio\/(?:x-)?(?:mp(?:eg|3))\s*(?:$|;)/i;this.useAltURL=!N;this._global_a=null;if(Ba&&(c.useHTML5Audio=!0,c.preferFlash=!1,Aa))F=c.ignoreFlash=!0;this.supported=this.ok=function(){return z?n&&!y:c.useHTML5Audio&&c.hasHTML5};this.getMovie=function(c){return u(c)||h[c]||j[c]};this.createSound=function(b){function a(){f=ea(f);c.sounds[e.id]=new Ea(e);c.soundIDs.push(e.id);
return c.sounds[e.id]}var d,f=null,e=d=null;d="soundManager.createSound(): "+q(!n?"notReady":"notOK");if(!n||!c.ok())return wa(d),!1;2===arguments.length&&(b={id:arguments[0],url:arguments[1]});f=v(b);f.url=ia(f.url);e=f;e.id.toString().charAt(0).match(/^[0-9]$/)&&c._wD("soundManager.createSound(): "+q("badID",e.id),2);c._wD("soundManager.createSound(): "+e.id+" ("+e.url+")",1);if(s(e.id,!0))return c._wD("soundManager.createSound(): "+e.id+" exists",1),c.sounds[e.id];if(ja(e))d=a(),c._wD("Loading sound "+
e.id+" via HTML5"),d._setup_html5(e);else{if(8<m){if(null===e.isMovieStar)e.isMovieStar=e.serverURL||(e.type?e.type.match(Wa):!1)||e.url.match(eb);e.isMovieStar&&c._wD("soundManager.createSound(): using MovieStar handling");if(e.isMovieStar){if(e.usePeakData)o("noPeak"),e.usePeakData=!1;1<e.loops&&o("noNSLoop")}}e=fa(e,"soundManager.createSound(): ");d=a();if(8===m)i._createSound(e.id,e.loops||1,e.usePolicyFile);else if(i._createSound(e.id,e.url,e.usePeakData,e.useWaveformData,e.useEQData,e.isMovieStar,
e.isMovieStar?e.bufferTime:!1,e.loops||1,e.serverURL,e.duration||null,e.autoPlay,!0,e.autoLoad,e.usePolicyFile),!e.serverURL)d.connected=!0,e.onconnect&&e.onconnect.apply(d);!e.serverURL&&(e.autoLoad||e.autoPlay)&&d.load(e)}!e.serverURL&&e.autoPlay&&d.play();return d};this.destroySound=function(b,a){if(!s(b))return!1;var d=c.sounds[b],f;d._iO={};d.stop();d.unload();for(f=0;f<c.soundIDs.length;f++)if(c.soundIDs[f]===b){c.soundIDs.splice(f,1);break}a||d.destruct(!0);delete c.sounds[b];return!0};this.load=
function(b,a){return!s(b)?!1:c.sounds[b].load(a)};this.unload=function(b){return!s(b)?!1:c.sounds[b].unload()};this.onposition=this.onPosition=function(b,a,d,f){return!s(b)?!1:c.sounds[b].onposition(a,d,f)};this.clearOnPosition=function(b,a,d){return!s(b)?!1:c.sounds[b].clearOnPosition(a,d)};this.start=this.play=function(b,a){if(!n||!c.ok())return wa("soundManager.play(): "+q(!n?"notReady":"notOK")),!1;if(!s(b)){a instanceof Object||(a={url:a});return a&&a.url?(c._wD('soundManager.play(): attempting to create "'+
b+'"',1),a.id=b,c.createSound(a).play()):!1}return c.sounds[b].play(a)};this.setPosition=function(b,a){return!s(b)?!1:c.sounds[b].setPosition(a)};this.stop=function(b){if(!s(b))return!1;c._wD("soundManager.stop("+b+")",1);return c.sounds[b].stop()};this.stopAll=function(){var b;c._wD("soundManager.stopAll()",1);for(b in c.sounds)c.sounds.hasOwnProperty(b)&&c.sounds[b].stop()};this.pause=function(b){return!s(b)?!1:c.sounds[b].pause()};this.pauseAll=function(){var b;for(b=c.soundIDs.length;b--;)c.sounds[c.soundIDs[b]].pause()};
this.resume=function(b){return!s(b)?!1:c.sounds[b].resume()};this.resumeAll=function(){var b;for(b=c.soundIDs.length;b--;)c.sounds[c.soundIDs[b]].resume()};this.togglePause=function(b){return!s(b)?!1:c.sounds[b].togglePause()};this.setPan=function(b,a){return!s(b)?!1:c.sounds[b].setPan(a)};this.setVolume=function(b,a){return!s(b)?!1:c.sounds[b].setVolume(a)};this.mute=function(b){var a=0;"string"!==typeof b&&(b=null);if(b){if(!s(b))return!1;c._wD('soundManager.mute(): Muting "'+b+'"');return c.sounds[b].mute()}c._wD("soundManager.mute(): Muting all sounds");
for(a=c.soundIDs.length;a--;)c.sounds[c.soundIDs[a]].mute();return c.muted=!0};this.muteAll=function(){c.mute()};this.unmute=function(b){"string"!==typeof b&&(b=null);if(b){if(!s(b))return!1;c._wD('soundManager.unmute(): Unmuting "'+b+'"');return c.sounds[b].unmute()}c._wD("soundManager.unmute(): Unmuting all sounds");for(b=c.soundIDs.length;b--;)c.sounds[c.soundIDs[b]].unmute();c.muted=!1;return!0};this.unmuteAll=function(){c.unmute()};this.toggleMute=function(b){return!s(b)?!1:c.sounds[b].toggleMute()};
this.getMemoryUse=function(){var c=0;i&&8!==m&&(c=parseInt(i._getMemoryUse(),10));return c};this.disable=function(b){var a;"undefined"===typeof b&&(b=!1);if(y)return!1;y=!0;o("shutdown",1);for(a=c.soundIDs.length;a--;)Ha(c.sounds[c.soundIDs[a]]);R(b);r.remove(j,"load",I);return!0};this.canPlayMIME=function(b){var a;c.hasHTML5&&(a=U({type:b}));return!z||a?a:b?!!(8<m&&b.match(Wa)||b.match(c.mimePattern)):null};this.canPlayURL=function(b){var a;c.hasHTML5&&(a=U({url:b}));return!z||a?a:b?!!b.match(c.filePattern):
null};this.canPlayLink=function(b){return"undefined"!==typeof b.type&&b.type&&c.canPlayMIME(b.type)?!0:c.canPlayURL(b.href)};this.getSoundById=function(b,a){if(!b)throw Error("soundManager.getSoundById(): sID is null/undefined");var d=c.sounds[b];!d&&!a&&c._wD('"'+b+'" is an invalid sound ID.',2);return d};this.onready=function(b,a){if(b&&b instanceof Function)return n&&c._wD(q("queue","onready")),a||(a=j),pa("onready",b,a),H(),!0;throw q("needFunction","onready");};this.ontimeout=function(b,a){if(b&&
b instanceof Function)return n&&c._wD(q("queue","ontimeout")),a||(a=j),pa("ontimeout",b,a),H({type:"ontimeout"}),!0;throw q("needFunction","ontimeout");};this._wD=this._writeDebug=function(b,a,d){var f,e;if(!c.debugMode)return!1;"undefined"!==typeof d&&d&&(b=b+" | "+(new Date).getTime());if(Sa&&c.useConsole){d=$a[a];if("undefined"!==typeof console[d])console[d](b);else console.log(b);if(c.consoleOnly)return!0}try{f=u("soundmanager-debug");if(!f)return!1;e=h.createElement("div");if(0===++Za%2)e.className=
"sm2-alt";a="undefined"===typeof a?0:parseInt(a,10);e.appendChild(h.createTextNode(b));if(a){if(2<=a)e.style.fontWeight="bold";if(3===a)e.style.color="#ff3333"}f.insertBefore(e,f.firstChild)}catch(i){}return!0};this._debug=function(){var b,a;o("currentObj",1);for(b=0,a=c.soundIDs.length;b<a;b++)c.sounds[c.soundIDs[b]]._debug()};this.reboot=function(){c._wD("soundManager.reboot()");c.soundIDs.length&&c._wD("Destroying "+c.soundIDs.length+" SMSound objects...");var b,a;for(b=c.soundIDs.length;b--;)c.sounds[c.soundIDs[b]].destruct();
try{if(D)ua=i.innerHTML;S=i.parentNode.removeChild(i);c._wD("Flash movie removed.")}catch(d){o("badRemove",2)}ua=S=z=null;c.enabled=sa=n=ga=xa=P=Q=y=c.swfLoaded=!1;c.soundIDs=c.sounds=[];i=null;for(b in B)if(B.hasOwnProperty(b))for(a=B[b].length;a--;)B[b][a].fired=!1;c._wD("soundManager: Rebooting...");j.setTimeout(c.beginDelayedInit,20)};this.getMoviePercent=function(){return i&&"undefined"!==typeof i.PercentLoaded?i.PercentLoaded():null};this.beginDelayedInit=function(){Y=!0;J();setTimeout(function(){if(xa)return!1;
ca();aa();return xa=!0},20);Z()};this.destruct=function(){c._wD("soundManager.destruct()");c.disable(!0)};Ea=function(b){var a=this,d,f,e,h,g,Ya,j=!1,x=[],l=0,n,r,p=null,t=null,u=null;this.sID=b.id;this.url=b.url;this._iO=this.instanceOptions=this.options=v(b);this.pan=this.options.pan;this.volume=this.options.volume;this.isHTML5=!1;this._a=null;this.id3={};this._debug=function(){if(c.debugMode){var b=null,e=[],d,f;for(b in a.options)null!==a.options[b]&&(a.options[b]instanceof Function?(d=a.options[b].toString(),
d=d.replace(/\s\s+/g," "),f=d.indexOf("{"),e.push(" "+b+": {"+d.substr(f+1,Math.min(Math.max(d.indexOf("\n")-1,64),64)).replace(/\n/g,"")+"... }")):e.push(" "+b+": "+a.options[b]));c._wD("SMSound() merged options: {\n"+e.join(", \n")+"\n}")}};this._debug();this.load=function(b){var d=null;if("undefined"!==typeof b)a._iO=v(b,a.options),a.instanceOptions=a._iO;else if(b=a.options,a._iO=b,a.instanceOptions=a._iO,p&&p!==a.url)o("manURL"),a._iO.url=a.url,a.url=null;if(!a._iO.url)a._iO.url=a.url;a._iO.url=
ia(a._iO.url);c._wD("SMSound.load(): "+a._iO.url,1);if(a._iO.url===a.url&&0!==a.readyState&&2!==a.readyState)return o("onURL",1),3===a.readyState&&a._iO.onload&&a._iO.onload.apply(a,[!!a.duration]),a;b=a._iO;p=a.url;a.loaded=!1;a.readyState=1;a.playState=0;if(ja(b))d=a._setup_html5(b),d._called_load?c._wD(k+"ignoring request to load again: "+a.sID):(c._wD(k+"load: "+a.sID),a._html5_canplay=!1,a._a.autobuffer="auto",a._a.preload="auto",d.load(),d._called_load=!0,b.autoPlay&&a.play());else try{a.isHTML5=
!1,a._iO=fa(ea(b)),b=a._iO,8===m?i._load(a.sID,b.url,b.stream,b.autoPlay,b.whileloading?1:0,b.loops||1,b.usePolicyFile):i._load(a.sID,b.url,!!b.stream,!!b.autoPlay,b.loops||1,!!b.autoLoad,b.usePolicyFile)}catch(e){o("smError",2),w("onload",!1),K({type:"SMSOUND_LOAD_JS_EXCEPTION",fatal:!0})}return a};this.unload=function(){0!==a.readyState&&(c._wD('SMSound.unload(): "'+a.sID+'"'),a.isHTML5?(h(),a._a&&(a._a.pause(),ya(a._a))):8===m?i._unload(a.sID,"about:blank"):i._unload(a.sID),d());return a};this.destruct=
function(b){c._wD('SMSound.destruct(): "'+a.sID+'"');if(a.isHTML5){if(h(),a._a)a._a.pause(),ya(a._a),F||e(),a._a._t=null,a._a=null}else a._iO.onfailure=null,i._destroySound(a.sID);b||c.destroySound(a.sID,!0)};this.start=this.play=function(b,d){var e,d=void 0===d?!0:d;b||(b={});a._iO=v(b,a._iO);a._iO=v(a._iO,a.options);a._iO.url=ia(a._iO.url);a.instanceOptions=a._iO;if(a._iO.serverURL&&!a.connected)return a.getAutoPlay()||(c._wD("SMSound.play():  Netstream not connected yet - setting autoPlay"),a.setAutoPlay(!0)),
a;ja(a._iO)&&(a._setup_html5(a._iO),g());if(1===a.playState&&!a.paused)if(e=a._iO.multiShot)c._wD('SMSound.play(): "'+a.sID+'" already playing (multi-shot)',1);else return c._wD('SMSound.play(): "'+a.sID+'" already playing (one-shot)',1),a;if(a.loaded)c._wD('SMSound.play(): "'+a.sID+'"');else if(0===a.readyState){c._wD('SMSound.play(): Attempting to load "'+a.sID+'"',1);if(!a.isHTML5)a._iO.autoPlay=!0;a.load(a._iO)}else{if(2===a.readyState)return c._wD('SMSound.play(): Could not load "'+a.sID+'" - exiting',
2),a;c._wD('SMSound.play(): "'+a.sID+'" is loading - attempting to play..',1)}if(!a.isHTML5&&9===m&&0<a.position&&a.position===a.duration)c._wD('SMSound.play(): "'+a.sID+'": Sound at end, resetting to position:0'),b.position=0;if(a.paused&&a.position&&0<a.position)c._wD('SMSound.play(): "'+a.sID+'" is resuming from paused state',1),a.resume();else{a._iO=v(b,a._iO);if(null!==a._iO.from&&null!==a._iO.to&&0===a.instanceCount&&0===a.playState&&!a._iO.serverURL){e=function(){a._iO=v(b,a._iO);a.play(a._iO)};
if(a.isHTML5&&!a._html5_canplay)return c._wD('SMSound.play(): Beginning load of "'+a.sID+'" for from/to case'),a.load({_oncanplay:e}),!1;if(!a.isHTML5&&!a.loaded&&(!a.readyState||2!==a.readyState))return c._wD('SMSound.play(): Preloading "'+a.sID+'" for from/to case'),a.load({onload:e}),!1;a._iO=r()}c._wD('SMSound.play(): "'+a.sID+'" is starting to play');(!a.instanceCount||a._iO.multiShotEvents||!a.isHTML5&&8<m&&!a.getAutoPlay())&&a.instanceCount++;0===a.playState&&a._iO.onposition&&Ya(a);a.playState=
1;a.paused=!1;a.position="undefined"!==typeof a._iO.position&&!isNaN(a._iO.position)?a._iO.position:0;if(!a.isHTML5)a._iO=fa(ea(a._iO));a._iO.onplay&&d&&(a._iO.onplay.apply(a),j=!0);a.setVolume(a._iO.volume,!0);a.setPan(a._iO.pan,!0);a.isHTML5?(g(),e=a._setup_html5(),a.setPosition(a._iO.position),e.play()):i._start(a.sID,a._iO.loops||1,9===m?a._iO.position:a._iO.position/1E3)}return a};this.stop=function(c){var b=a._iO;if(1===a.playState){a._onbufferchange(0);a._resetOnPosition(0);a.paused=!1;if(!a.isHTML5)a.playState=
0;n();b.to&&a.clearOnPosition(b.to);if(a.isHTML5){if(a._a)c=a.position,a.setPosition(0),a.position=c,a._a.pause(),a.playState=0,a._onTimer(),h()}else i._stop(a.sID,c),b.serverURL&&a.unload();a.instanceCount=0;a._iO={};b.onstop&&b.onstop.apply(a)}return a};this.setAutoPlay=function(b){c._wD("sound "+a.sID+" turned autoplay "+(b?"on":"off"));a._iO.autoPlay=b;a.isHTML5||(i._setAutoPlay(a.sID,b),b&&!a.instanceCount&&1===a.readyState&&(a.instanceCount++,c._wD("sound "+a.sID+" incremented instance count to "+
a.instanceCount)))};this.getAutoPlay=function(){return a._iO.autoPlay};this.setPosition=function(b){void 0===b&&(b=0);var d=a.isHTML5?Math.max(b,0):Math.min(a.duration||a._iO.duration,Math.max(b,0));a.position=d;b=a.position/1E3;a._resetOnPosition(a.position);a._iO.position=d;if(a.isHTML5){if(a._a)if(a._html5_canplay){if(a._a.currentTime!==b){c._wD("setPosition("+b+"): setting position");try{a._a.currentTime=b,(0===a.playState||a.paused)&&a._a.pause()}catch(e){c._wD("setPosition("+b+"): setting position failed: "+
e.message,2)}}}else c._wD("setPosition("+b+"): delaying, sound not ready")}else b=9===m?a.position:b,a.readyState&&2!==a.readyState&&i._setPosition(a.sID,b,a.paused||!a.playState);a.isHTML5&&a.paused&&a._onTimer(!0);return a};this.pause=function(b){if(a.paused||0===a.playState&&1!==a.readyState)return a;c._wD("SMSound.pause()");a.paused=!0;a.isHTML5?(a._setup_html5().pause(),h()):(b||void 0===b)&&i._pause(a.sID);a._iO.onpause&&a._iO.onpause.apply(a);return a};this.resume=function(){var b=a._iO;if(!a.paused)return a;
c._wD("SMSound.resume()");a.paused=!1;a.playState=1;a.isHTML5?(a._setup_html5().play(),g()):(b.isMovieStar&&!b.serverURL&&a.setPosition(a.position),i._pause(a.sID));j&&b.onplay?(b.onplay.apply(a),j=!0):b.onresume&&b.onresume.apply(a);return a};this.togglePause=function(){c._wD("SMSound.togglePause()");if(0===a.playState)return a.play({position:9===m&&!a.isHTML5?a.position:a.position/1E3}),a;a.paused?a.resume():a.pause();return a};this.setPan=function(b,c){"undefined"===typeof b&&(b=0);"undefined"===
typeof c&&(c=!1);a.isHTML5||i._setPan(a.sID,b);a._iO.pan=b;if(!c)a.pan=b,a.options.pan=b;return a};this.setVolume=function(b,d){"undefined"===typeof b&&(b=100);"undefined"===typeof d&&(d=!1);if(a.isHTML5){if(a._a)a._a.volume=Math.max(0,Math.min(1,b/100))}else i._setVolume(a.sID,c.muted&&!a.muted||a.muted?0:b);a._iO.volume=b;if(!d)a.volume=b,a.options.volume=b;return a};this.mute=function(){a.muted=!0;if(a.isHTML5){if(a._a)a._a.muted=!0}else i._setVolume(a.sID,0);return a};this.unmute=function(){a.muted=
!1;var b="undefined"!==typeof a._iO.volume;if(a.isHTML5){if(a._a)a._a.muted=!1}else i._setVolume(a.sID,b?a._iO.volume:a.options.volume);return a};this.toggleMute=function(){return a.muted?a.unmute():a.mute()};this.onposition=this.onPosition=function(b,c,d){x.push({position:b,method:c,scope:"undefined"!==typeof d?d:a,fired:!1});return a};this.clearOnPosition=function(a,b){var c,a=parseInt(a,10);if(isNaN(a))return!1;for(c=0;c<x.length;c++)if(a===x[c].position&&(!b||b===x[c].method))x[c].fired&&l--,
x.splice(c,1)};this._processOnPosition=function(){var b,c;b=x.length;if(!b||!a.playState||l>=b)return!1;for(;b--;)if(c=x[b],!c.fired&&a.position>=c.position)c.fired=!0,l++,c.method.apply(c.scope,[c.position]);return!0};this._resetOnPosition=function(a){var b,c;b=x.length;if(!b)return!1;for(;b--;)if(c=x[b],c.fired&&a<=c.position)c.fired=!1,l--;return!0};r=function(){var b=a._iO,d=b.from,e=b.to,f,g;g=function(){c._wD(a.sID+': "to" time of '+e+" reached.");a.clearOnPosition(e,g);a.stop()};f=function(){c._wD(a.sID+
': playing "from" '+d);if(null!==e&&!isNaN(e))a.onPosition(e,g)};if(null!==d&&!isNaN(d))b.position=d,b.multiShot=!1,f();return b};Ya=function(){var b=a._iO.onposition;if(b)for(var c in b)if(b.hasOwnProperty(c))a.onPosition(parseInt(c,10),b[c])};n=function(){var b=a._iO.onposition;if(b)for(var c in b)b.hasOwnProperty(c)&&a.clearOnPosition(parseInt(c,10))};g=function(){a.isHTML5&&Ka(a)};h=function(){a.isHTML5&&La(a)};d=function(){x=[];l=0;j=!1;a._hasTimer=null;a._a=null;a._html5_canplay=!1;a.bytesLoaded=
null;a.bytesTotal=null;a.duration=a._iO&&a._iO.duration?a._iO.duration:null;a.durationEstimate=null;a.eqData=[];a.eqData.left=[];a.eqData.right=[];a.failures=0;a.isBuffering=!1;a.instanceOptions={};a.instanceCount=0;a.loaded=!1;a.metadata={};a.readyState=0;a.muted=!1;a.paused=!1;a.peakData={left:0,right:0};a.waveformData={left:[],right:[]};a.playState=0;a.position=null};d();this._onTimer=function(b){var c,d=!1,e={};if(a._hasTimer||b){if(a._a&&(b||(0<a.playState||1===a.readyState)&&!a.paused)){c=a._get_html5_duration();
if(c!==t)t=c,a.duration=c,d=!0;a.durationEstimate=a.duration;c=1E3*a._a.currentTime||0;c!==u&&(u=c,d=!0);(d||b)&&a._whileplaying(c,e,e,e,e);return d}return!1}};this._get_html5_duration=function(){var b=a._iO,c=a._a?1E3*a._a.duration:b?b.duration:void 0;return c&&!isNaN(c)&&Infinity!==c?c:b?b.duration:null};this._setup_html5=function(b){var b=v(a._iO,b),e=decodeURI,g=F?c._global_a:a._a,h=e(b.url),i=g&&g._t?g._t.instanceOptions:null;if(g){if(g._t&&(!F&&h===e(p)||F&&i.url===b.url&&(!p||p===i.url)))return g;
c._wD("setting new URL on existing object: "+h+(p?", old URL: "+p:""));F&&g._t&&g._t.playState&&b.url!==i.url&&g._t.stop();d();g.src=b.url;p=a.url=b.url;g._called_load=!1}else{c._wD("creating HTML5 Audio() element with URL: "+h);g=new Audio(b.url);g._called_load=!1;if(bb)g._called_load=!0;if(F)c._global_a=g}a.isHTML5=!0;a._a=g;g._t=a;f();g.loop=1<b.loops?"loop":"";b.autoLoad||b.autoPlay?a.load():(g.autobuffer=!1,g.preload="none");g.loop=1<b.loops?"loop":"";return g};f=function(){if(a._a._added_events)return!1;
var b;c._wD(k+"adding event listeners: "+a.sID);a._a._added_events=!0;for(b in A)A.hasOwnProperty(b)&&a._a&&a._a.addEventListener(b,A[b],!1);return!0};e=function(){var b;c._wD(k+"removing event listeners: "+a.sID);a._a._added_events=!1;for(b in A)A.hasOwnProperty(b)&&a._a&&a._a.removeEventListener(b,A[b],!1)};this._onload=function(b){var d,b=!!b;c._wD(d+'"'+a.sID+'"'+(b?" loaded.":" failed to load? - "+a.url),b?1:2);d="SMSound._onload(): ";!b&&!a.isHTML5&&(!0===c.sandbox.noRemote&&c._wD(d+q("noNet"),
1),!0===c.sandbox.noLocal&&c._wD(d+q("noLocal"),1));a.loaded=b;a.readyState=b?3:2;a._onbufferchange(0);a._iO.onload&&a._iO.onload.apply(a,[b]);return!0};this._onbufferchange=function(b){if(0===a.playState||b&&a.isBuffering||!b&&!a.isBuffering)return!1;a.isBuffering=1===b;a._iO.onbufferchange&&(c._wD("SMSound._onbufferchange(): "+b),a._iO.onbufferchange.apply(a));return!0};this._onsuspend=function(){a._iO.onsuspend&&(c._wD("SMSound._onsuspend()"),a._iO.onsuspend.apply(a));return!0};this._onfailure=
function(b,d,e){a.failures++;c._wD('SMSound._onfailure(): "'+a.sID+'" count '+a.failures);if(a._iO.onfailure&&1===a.failures)a._iO.onfailure(a,b,d,e);else c._wD("SMSound._onfailure(): ignoring")};this._onfinish=function(){var b=a._iO.onfinish;a._onbufferchange(0);a._resetOnPosition(0);if(a.instanceCount){a.instanceCount--;if(!a.instanceCount)n(),a.playState=0,a.paused=!1,a.instanceCount=0,a.instanceOptions={},a._iO={},h();if((!a.instanceCount||a._iO.multiShotEvents)&&b)c._wD('SMSound._onfinish(): "'+
a.sID+'"'),b.apply(a)}};this._whileloading=function(b,c,d,e){var f=a._iO;a.bytesLoaded=b;a.bytesTotal=c;a.duration=Math.floor(d);a.bufferLength=e;if(f.isMovieStar)a.durationEstimate=a.duration;else if(a.durationEstimate=f.duration?a.duration>f.duration?a.duration:f.duration:parseInt(a.bytesTotal/a.bytesLoaded*a.duration,10),void 0===a.durationEstimate)a.durationEstimate=a.duration;3!==a.readyState&&f.whileloading&&f.whileloading.apply(a)};this._whileplaying=function(b,c,d,e,f){var g=a._iO;if(isNaN(b)||
null===b)return!1;a.position=b;a._processOnPosition();if(!a.isHTML5&&8<m){if(g.usePeakData&&"undefined"!==typeof c&&c)a.peakData={left:c.leftPeak,right:c.rightPeak};if(g.useWaveformData&&"undefined"!==typeof d&&d)a.waveformData={left:d.split(","),right:e.split(",")};if(g.useEQData&&"undefined"!==typeof f&&f&&f.leftEQ&&(b=f.leftEQ.split(","),a.eqData=b,a.eqData.left=b,"undefined"!==typeof f.rightEQ&&f.rightEQ))a.eqData.right=f.rightEQ.split(",")}1===a.playState&&(!a.isHTML5&&8===m&&!a.position&&a.isBuffering&&
a._onbufferchange(0),g.whileplaying&&g.whileplaying.apply(a));return!0};this._onmetadata=function(b,d){c._wD('SMSound._onmetadata(): "'+this.sID+'" metadata received.');var e={},f,g;for(f=0,g=b.length;f<g;f++)e[b[f]]=d[f];a.metadata=e;a._iO.onmetadata&&a._iO.onmetadata.apply(a)};this._onid3=function(b,d){c._wD('SMSound._onid3(): "'+this.sID+'" ID3 data received.');var e=[],f,g;for(f=0,g=b.length;f<g;f++)e[b[f]]=d[f];a.id3=v(a.id3,e);a._iO.onid3&&a._iO.onid3.apply(a)};this._onconnect=function(b){b=
1===b;c._wD('SMSound._onconnect(): "'+a.sID+'"'+(b?" connected.":" failed to connect? - "+a.url),b?1:2);if(a.connected=b)a.failures=0,s(a.sID)&&(a.getAutoPlay()?a.play(void 0,a.getAutoPlay()):a._iO.autoLoad&&a.load()),a._iO.onconnect&&a._iO.onconnect.apply(a,[b])};this._ondataerror=function(b){0<a.playState&&(c._wD("SMSound._ondataerror(): "+b),a._iO.ondataerror&&a._iO.ondataerror.apply(a))}};ba=function(){return h.body||h._docElement||h.getElementsByTagName("div")[0]};u=function(b){return h.getElementById(b)};
v=function(b,a){var d={},f,e;for(f in b)b.hasOwnProperty(f)&&(d[f]=b[f]);f="undefined"===typeof a?c.defaultOptions:a;for(e in f)f.hasOwnProperty(e)&&"undefined"===typeof d[e]&&(d[e]=f[e]);return d};r=function(){function b(a){var a=Pa.call(a),b=a.length;c?(a[1]="on"+a[1],3<b&&a.pop()):3===b&&a.push(!1);return a}function a(a,b){var g=a.shift(),h=[f[b]];if(c)g[h](a[0],a[1]);else g[h].apply(g,a)}var c=j.attachEvent,f={add:c?"attachEvent":"addEventListener",remove:c?"detachEvent":"removeEventListener"};
return{add:function(){a(b(arguments),"add")},remove:function(){a(b(arguments),"remove")}}}();A={abort:l(function(){c._wD(k+"abort: "+this._t.sID)}),canplay:l(function(){var b=this._t;if(b._html5_canplay)return!0;b._html5_canplay=!0;c._wD(k+"canplay: "+b.sID+", "+b.url);b._onbufferchange(0);var a=!isNaN(b.position)?b.position/1E3:null;if(b.position&&this.currentTime!==a){c._wD(k+"canplay: setting position to "+a);try{this.currentTime=a}catch(d){c._wD(k+"setting position failed: "+d.message,2)}}b._iO._oncanplay&&
b._iO._oncanplay()}),load:l(function(){var b=this._t;b.loaded||(b._onbufferchange(0),b._whileloading(b.bytesTotal,b.bytesTotal,b._get_html5_duration()),b._onload(!0))}),emptied:l(function(){c._wD(k+"emptied: "+this._t.sID)}),ended:l(function(){var b=this._t;c._wD(k+"ended: "+b.sID);b._onfinish()}),error:l(function(){c._wD(k+"error: "+this.error.code);this._t._onload(!1)}),loadeddata:l(function(){var b=this._t,a=b.bytesTotal||1;c._wD(k+"loadeddata: "+this._t.sID);if(!b._loaded&&!V)b.duration=b._get_html5_duration(),
b._whileloading(a,a,b._get_html5_duration()),b._onload(!0)}),loadedmetadata:l(function(){c._wD(k+"loadedmetadata: "+this._t.sID)}),loadstart:l(function(){c._wD(k+"loadstart: "+this._t.sID);this._t._onbufferchange(1)}),play:l(function(){c._wD(k+"play: "+this._t.sID+", "+this._t.url);this._t._onbufferchange(0)}),playing:l(function(){c._wD(k+"playing: "+this._t.sID);this._t._onbufferchange(0)}),progress:l(function(b){var a=this._t;if(a.loaded)return!1;var d,f,e;e=0;var h="progress"===b.type;f=b.target.buffered;
var g=b.loaded||0,i=b.total||1;if(f&&f.length){for(d=f.length;d--;)e=f.end(d)-f.start(d);g=e/b.target.duration;if(h&&1<f.length){e=[];f=f.length;for(d=0;d<f;d++)e.push(b.target.buffered.start(d)+"-"+b.target.buffered.end(d));c._wD(k+"progress: timeRanges: "+e.join(", "))}h&&!isNaN(g)&&c._wD(k+"progress: "+a.sID+": "+Math.floor(100*g)+"% loaded")}isNaN(g)||(a._onbufferchange(0),a._whileloading(g,i,a._get_html5_duration()),g&&i&&g===i&&A.load.call(this,b))}),ratechange:l(function(){c._wD(k+"ratechange: "+
this._t.sID)}),suspend:l(function(b){var a=this._t;c._wD(k+"suspend: "+a.sID);A.progress.call(this,b);a._onsuspend()}),stalled:l(function(){c._wD(k+"stalled: "+this._t.sID)}),timeupdate:l(function(){this._t._onTimer()}),waiting:l(function(){var b=this._t;c._wD(k+"waiting: "+b.sID);b._onbufferchange(1)})};ja=function(b){return!b.serverURL&&(b.type?U({type:b.type}):U({url:b.url})||c.html5Only)};ya=function(b){if(b)b.src=ab?"":"about:blank"};U=function(b){function a(a){return c.preferFlash&&t&&!c.ignoreFlash&&
"undefined"!==typeof c.flash[a]&&c.flash[a]}if(!c.useHTML5Audio||!c.hasHTML5)return!1;var d=b.url||null,b=b.type||null,f=c.audioFormats,e;if(b&&"undefined"!==c.html5[b])return c.html5[b]&&!a(b);if(!C){C=[];for(e in f)f.hasOwnProperty(e)&&(C.push(e),f[e].related&&(C=C.concat(f[e].related)));C=RegExp("\\.("+C.join("|")+")(\\?.*)?$","i")}e=d?d.toLowerCase().match(C):null;if(!e||!e.length)if(b)d=b.indexOf(";"),e=(-1!==d?b.substr(0,d):b).substr(6);else return!1;else e=e[1];if(e&&"undefined"!==typeof c.html5[e])return c.html5[e]&&
!a(e);b="audio/"+e;d=c.html5.canPlayType({type:b});return(c.html5[e]=d)&&c.html5[b]&&!a(b)};Oa=function(){function b(b){var d,e,f=!1;if(!a||"function"!==typeof a.canPlayType)return!1;if(b instanceof Array){for(d=0,e=b.length;d<e&&!f;d++)if(c.html5[b[d]]||a.canPlayType(b[d]).match(c.html5Test))f=!0,c.html5[b[d]]=!0,c.flash[b[d]]=!(!c.preferFlash||!t||!b[d].match(Ua));return f}b=a&&"function"===typeof a.canPlayType?a.canPlayType(b):!1;return!(!b||!b.match(c.html5Test))}if(!c.useHTML5Audio||"undefined"===
typeof Audio)return!1;var a="undefined"!==typeof Audio?db?new Audio(null):new Audio:null,d,f={},e,h;e=c.audioFormats;for(d in e)if(e.hasOwnProperty(d)&&(f[d]=b(e[d].type),f["audio/"+d]=f[d],c.flash[d]=c.preferFlash&&!c.ignoreFlash&&d.match(Ua)?!0:!1,e[d]&&e[d].related))for(h=e[d].related.length;h--;)f["audio/"+e[d].related[h]]=f[d],c.html5[e[d].related[h]]=f[d],c.flash[e[d].related[h]]=f[d];f.canPlayType=a?b:null;c.html5=v(c.html5,f);return!0};$={notReady:"Not loaded yet - wait for soundManager.onload()/onready()",
notOK:"Audio support is not available.",domError:"soundManager::createMovie(): appendChild/innerHTML call failed. DOM not ready or other error.",spcWmode:"soundManager::createMovie(): Removing wmode, preventing known SWF loading issue(s)",swf404:"soundManager: Verify that %s is a valid path.",tryDebug:"Try soundManager.debugFlash = true for more security details (output goes to SWF.)",checkSWF:"See SWF output for more debug info.",localFail:"soundManager: Non-HTTP page ("+h.location.protocol+" URL?) Review Flash player security settings for this special case:\nhttp://www.macromedia.com/support/documentation/en/flashplayer/help/settings_manager04.html\nMay need to add/allow path, eg. c:/sm2/ or /users/me/sm2/",
waitFocus:"soundManager: Special case: Waiting for focus-related event..",waitImpatient:"soundManager: Getting impatient, still waiting for Flash%s...",waitForever:"soundManager: Waiting indefinitely for Flash (will recover if unblocked)...",needFunction:"soundManager: Function object expected for %s",badID:'Warning: Sound ID "%s" should be a string, starting with a non-numeric character',currentObj:"--- soundManager._debug(): Current sound objects ---",waitEI:"soundManager::initMovie(): Waiting for ExternalInterface call from Flash..",
waitOnload:"soundManager: Waiting for window.onload()",docLoaded:"soundManager: Document already loaded",onload:"soundManager::initComplete(): calling soundManager.onload()",onloadOK:"soundManager.onload() complete",init:"soundManager::init()",didInit:"soundManager::init(): Already called?",flashJS:"soundManager: Attempting to call Flash from JS..",secNote:"Flash security note: Network/internet URLs will not load due to security restrictions. Access can be configured via Flash Player Global Security Settings Page: http://www.macromedia.com/support/documentation/en/flashplayer/help/settings_manager04.html",
badRemove:"Warning: Failed to remove flash movie.",noPeak:"Warning: peakData features unsupported for movieStar formats",shutdown:"soundManager.disable(): Shutting down",queue:"soundManager: Queueing %s handler",smFail:"soundManager: Failed to initialise.",smError:"SMSound.load(): Exception: JS-Flash communication failed, or JS error.",fbTimeout:"No flash response, applying .swf_timedout CSS..",fbLoaded:"Flash loaded",fbHandler:"soundManager::flashBlockHandler()",manURL:"SMSound.load(): Using manually-assigned URL",
onURL:"soundManager.load(): current URL already assigned.",badFV:'soundManager.flashVersion must be 8 or 9. "%s" is invalid. Reverting to %s.',as2loop:"Note: Setting stream:false so looping can work (flash 8 limitation)",noNSLoop:"Note: Looping not implemented for MovieStar formats",needfl9:"Note: Switching to flash 9, required for MP4 formats.",mfTimeout:"Setting flashLoadTimeout = 0 (infinite) for off-screen, mobile flash case",mfOn:"mobileFlash::enabling on-screen flash repositioning",policy:"Enabling usePolicyFile for data access"};
q=function(){var b=Pa.call(arguments),a=b.shift(),a=$&&$[a]?$[a]:"",c,f;if(a&&b&&b.length)for(c=0,f=b.length;c<f;c++)a=a.replace("%s",b[c]);return a};ea=function(b){if(8===m&&1<b.loops&&b.stream)o("as2loop"),b.stream=!1;return b};fa=function(b,a){if(b&&!b.usePolicyFile&&(b.onid3||b.usePeakData||b.useWaveformData||b.useEQData))c._wD((a||"")+q("policy")),b.usePolicyFile=!0;return b};wa=function(b){"undefined"!==typeof console&&"undefined"!==typeof console.warn?console.warn(b):c._wD(b)};na=function(){return!1};
Ha=function(b){for(var a in b)b.hasOwnProperty(a)&&"function"===typeof b[a]&&(b[a]=na)};da=function(b){"undefined"===typeof b&&(b=!1);if(y||b)o("smFail",2),c.disable(b)};Ia=function(b){var a=null;if(b)if(b.match(/\.swf(\?.*)?$/i)){if(a=b.substr(b.toLowerCase().lastIndexOf(".swf?")+4))return b}else b.lastIndexOf("/")!==b.length-1&&(b+="/");b=(b&&-1!==b.lastIndexOf("/")?b.substr(0,b.lastIndexOf("/")+1):"./")+c.movieURL;c.noSWFCache&&(b+="?ts="+(new Date).getTime());return b};qa=function(){m=parseInt(c.flashVersion,
10);if(8!==m&&9!==m)c._wD(q("badFV",m,8)),c.flashVersion=m=8;var b=c.debugMode||c.debugFlash?"_debug.swf":".swf";if(c.useHTML5Audio&&!c.html5Only&&c.audioFormats.mp4.required&&9>m)c._wD(q("needfl9")),c.flashVersion=m=9;c.version=c.versionNumber+(c.html5Only?" (HTML5-only mode)":9===m?" (AS3/Flash 9)":" (AS2/Flash 8)");8<m?(c.defaultOptions=v(c.defaultOptions,c.flash9Options),c.features.buffering=!0,c.defaultOptions=v(c.defaultOptions,c.movieStarOptions),c.filePatterns.flash9=RegExp("\\.(mp3|"+Xa.join("|")+
")(\\?.*)?$","i"),c.features.movieStar=!0):c.features.movieStar=!1;c.filePattern=c.filePatterns[8!==m?"flash9":"flash8"];c.movieURL=(8===m?"soundmanager2.swf":"soundmanager2_flash9.swf").replace(".swf",b);c.features.peakData=c.features.waveformData=c.features.eqData=8<m};Ga=function(b,a){if(!i)return!1;i._setPolling(b,a)};ta=function(){if(c.debugURLParam.test(O))c.debugMode=!0;if(u(c.debugID))return!1;var b,a,d,f;if(c.debugMode&&!u(c.debugID)&&(!Sa||!c.useConsole||!c.consoleOnly)){b=h.createElement("div");
b.id=c.debugID+"-toggle";a={position:"fixed",bottom:"0px",right:"0px",width:"1.2em",height:"1.2em",lineHeight:"1.2em",margin:"2px",textAlign:"center",border:"1px solid #999",cursor:"pointer",background:"#fff",color:"#333",zIndex:10001};b.appendChild(h.createTextNode("-"));b.onclick=Ja;b.title="Toggle SM2 debug console";if(p.match(/msie 6/i))b.style.position="absolute",b.style.cursor="hand";for(f in a)a.hasOwnProperty(f)&&(b.style[f]=a[f]);a=h.createElement("div");a.id=c.debugID;a.style.display=c.debugMode?
"block":"none";if(c.debugMode&&!u(b.id)){try{d=ba(),d.appendChild(b)}catch(e){throw Error(q("domError")+" \n"+e.toString());}d.appendChild(a)}}};s=this.getSoundById;o=function(b,a){return b?c._wD(q(b),a):""};if(O.indexOf("sm2-debug=alert")+1&&c.debugMode)c._wD=function(b){G.alert(b)};Ja=function(){var b=u(c.debugID),a=u(c.debugID+"-toggle");if(!b)return!1;oa?(a.innerHTML="+",b.style.display="none"):(a.innerHTML="-",b.style.display="block");oa=!oa};w=function(b,a,c){if("undefined"!==typeof sm2Debugger)try{sm2Debugger.handleEvent(b,
a,c)}catch(f){}return!0};L=function(){var b=[];c.debugMode&&b.push("sm2_debug");c.debugFlash&&b.push("flash_debug");c.useHighPerformance&&b.push("high_performance");return b.join(" ")};va=function(){var b=q("fbHandler"),a=c.getMoviePercent(),d={type:"FLASHBLOCK"};if(c.html5Only)return!1;if(c.ok()){if(c.didFlashBlock&&c._wD(b+": Unblocked"),c.oMC)c.oMC.className=[L(),"movieContainer","swf_loaded"+(c.didFlashBlock?" swf_unblocked":"")].join(" ")}else{if(z)c.oMC.className=L()+" movieContainer "+(null===
a?"swf_timedout":"swf_error"),c._wD(b+": "+q("fbTimeout")+(a?" ("+q("fbLoaded")+")":""));c.didFlashBlock=!0;H({type:"ontimeout",ignoreInit:!0,error:d});K(d)}};pa=function(b,a,c){"undefined"===typeof B[b]&&(B[b]=[]);B[b].push({method:a,scope:c||null,fired:!1})};H=function(b){b||(b={type:"onready"});if(!n&&b&&!b.ignoreInit||"ontimeout"===b.type&&c.ok())return!1;var a={success:b&&b.ignoreInit?c.ok():!y},d=b&&b.type?B[b.type]||[]:[],f=[],e,h=[a],g=z&&c.useFlashBlock&&!c.ok();if(b.error)h[0].error=b.error;
for(a=0,e=d.length;a<e;a++)!0!==d[a].fired&&f.push(d[a]);if(f.length){c._wD("soundManager: Firing "+f.length+" "+b.type+"() item"+(1===f.length?"":"s"));for(a=0,e=f.length;a<e;a++)if(f[a].scope?f[a].method.apply(f[a].scope,h):f[a].method.apply(this,h),!g)f[a].fired=!0}return!0};I=function(){j.setTimeout(function(){c.useFlashBlock&&va();H();c.onload instanceof Function&&(o("onload",1),c.onload.apply(j),o("onloadOK",1));c.waitForWindowLoad&&r.add(j,"load",I)},1)};ka=function(){if(void 0!==t)return t;
var b=!1,a=navigator,c=a.plugins,f,e=j.ActiveXObject;if(c&&c.length)(a=a.mimeTypes)&&a["application/x-shockwave-flash"]&&a["application/x-shockwave-flash"].enabledPlugin&&a["application/x-shockwave-flash"].enabledPlugin.description&&(b=!0);else if("undefined"!==typeof e){try{f=new e("ShockwaveFlash.ShockwaveFlash")}catch(h){}b=!!f}return t=b};Na=function(){var b,a;if(Aa&&p.match(/os (1|2|3_0|3_1)/i)){c.hasHTML5=!1;c.html5Only=!0;if(c.oMC)c.oMC.style.display="none";return!1}if(c.useHTML5Audio){if(!c.html5||
!c.html5.canPlayType)return c._wD("SoundManager: No HTML5 Audio() support detected."),c.hasHTML5=!1,!0;c.hasHTML5=!0;if(Ca&&(c._wD("soundManager::Note: Buggy HTML5 Audio in Safari on this OS X release, see https://bugs.webkit.org/show_bug.cgi?id=32159 - "+(!t?" would use flash fallback for MP3/MP4, but none detected.":"will use flash fallback for MP3/MP4, if available"),1),ka()))return!0}else return!0;for(a in c.audioFormats)if(c.audioFormats.hasOwnProperty(a)&&(c.audioFormats[a].required&&!c.html5.canPlayType(c.audioFormats[a].type)||
c.flash[a]||c.flash[c.audioFormats[a].type]))b=!0;c.ignoreFlash&&(b=!1);c.html5Only=c.hasHTML5&&c.useHTML5Audio&&!b;return!c.html5Only};ia=function(b){var a,d,f=0;if(b instanceof Array){for(a=0,d=b.length;a<d;a++)if(b[a]instanceof Object){if(c.canPlayMIME(b[a].type)){f=a;break}}else if(c.canPlayURL(b[a])){f=a;break}if(b[f].url)b[f]=b[f].url;return b[f]}return b};Ka=function(b){if(!b._hasTimer)b._hasTimer=!0,!Ba&&c.html5PollingInterval&&(null===T&&0===ha&&(T=G.setInterval(Ma,c.html5PollingInterval)),
ha++)};La=function(b){if(b._hasTimer)b._hasTimer=!1,!Ba&&c.html5PollingInterval&&ha--};Ma=function(){var b;if(null!==T&&!ha)return G.clearInterval(T),T=null,!1;for(b=c.soundIDs.length;b--;)c.sounds[c.soundIDs[b]].isHTML5&&c.sounds[c.soundIDs[b]]._hasTimer&&c.sounds[c.soundIDs[b]]._onTimer()};K=function(b){b="undefined"!==typeof b?b:{};c.onerror instanceof Function&&c.onerror.apply(j,[{type:"undefined"!==typeof b.type?b.type:null}]);"undefined"!==typeof b.fatal&&b.fatal&&c.disable()};Qa=function(){if(!Ca||
!ka())return!1;var b=c.audioFormats,a,d;for(d in b)if(b.hasOwnProperty(d)&&("mp3"===d||"mp4"===d))if(c._wD("soundManager: Using flash fallback for "+d+" format"),c.html5[d]=!1,b[d]&&b[d].related)for(a=b[d].related.length;a--;)c.html5[b[d].related[a]]=!1};this._setSandboxType=function(b){var a=c.sandbox;a.type=b;a.description=a.types["undefined"!==typeof a.types[b]?b:"unknown"];c._wD("Flash security sandbox type: "+a.type);if("localWithFile"===a.type)a.noRemote=!0,a.noLocal=!1,o("secNote",2);else if("localWithNetwork"===
a.type)a.noRemote=!1,a.noLocal=!0;else if("localTrusted"===a.type)a.noRemote=!1,a.noLocal=!1};this._externalInterfaceOK=function(b,a){if(c.swfLoaded)return!1;var d,f=(new Date).getTime();c._wD("soundManager::externalInterfaceOK()"+(b?" (~"+(f-b)+" ms)":""));w("swf",!0);w("flashtojs",!0);c.swfLoaded=!0;M=!1;Ca&&Qa();if(!a||a.replace(/\+dev/i,"")!==c.versionNumber.replace(/\+dev/i,""))return d='soundManager: Fatal: JavaScript file build "'+c.versionNumber+'" does not match Flash SWF build "'+a+'" at '+
c.url+". Ensure both are up-to-date.",setTimeout(function(){throw Error(d);},0),!1;D?setTimeout(X,100):X()};ca=function(b,a){function d(){c._wD("-- SoundManager 2 "+c.version+(!c.html5Only&&c.useHTML5Audio?c.hasHTML5?" + HTML5 audio":", no HTML5 audio support":"")+(!c.html5Only?(c.useHighPerformance?", high performance mode, ":", ")+((c.flashPollingInterval?"custom ("+c.flashPollingInterval+"ms)":"normal")+" polling")+(c.wmode?", wmode: "+c.wmode:"")+(c.debugFlash?", flash debug mode":"")+(c.useFlashBlock?
", flashBlock mode":""):"")+" --",1)}function f(a,b){return'<param name="'+a+'" value="'+b+'" />'}if(P&&Q)return!1;if(c.html5Only)return qa(),d(),c.oMC=u(c.movieID),X(),Q=P=!0,!1;var e=a||c.url,i=c.altURL||e,g;g=ba();var j,m,k=L(),l,n=null,n=(n=h.getElementsByTagName("html")[0])&&n.dir&&n.dir.match(/rtl/i),b="undefined"===typeof b?c.id:b;qa();c.url=Ia(N?e:i);a=c.url;c.wmode=!c.wmode&&c.useHighPerformance?"transparent":c.wmode;if(null!==c.wmode&&(p.match(/msie 8/i)||!D&&!c.useHighPerformance)&&navigator.platform.match(/win32|win64/i))o("spcWmode"),
c.wmode=null;g={name:b,id:b,src:a,width:"auto",height:"auto",quality:"high",allowScriptAccess:c.allowScriptAccess,bgcolor:c.bgColor,pluginspage:Va+"www.macromedia.com/go/getflashplayer",title:"JS/Flash audio component (SoundManager 2)",type:"application/x-shockwave-flash",wmode:c.wmode,hasPriority:"true"};if(c.debugFlash)g.FlashVars="debug=1";c.wmode||delete g.wmode;if(D)e=h.createElement("div"),m=['<object id="'+b+'" data="'+a+'" type="'+g.type+'" title="'+g.title+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+
Va+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="'+g.width+'" height="'+g.height+'">',f("movie",a),f("AllowScriptAccess",c.allowScriptAccess),f("quality",g.quality),c.wmode?f("wmode",c.wmode):"",f("bgcolor",c.bgColor),f("hasPriority","true"),c.debugFlash?f("FlashVars",g.FlashVars):"","</object>"].join("");else for(j in e=h.createElement("embed"),g)g.hasOwnProperty(j)&&e.setAttribute(j,g[j]);ta();k=L();if(g=ba())if(c.oMC=u(c.movieID)||h.createElement("div"),
c.oMC.id){l=c.oMC.className;c.oMC.className=(l?l+" ":"movieContainer")+(k?" "+k:"");c.oMC.appendChild(e);if(D)j=c.oMC.appendChild(h.createElement("div")),j.className="sm2-object-box",j.innerHTML=m;Q=!0}else{c.oMC.id=c.movieID;c.oMC.className="movieContainer "+k;j=k=null;if(!c.useFlashBlock)if(c.useHighPerformance)k={position:"fixed",width:"8px",height:"8px",bottom:"0px",left:"0px",overflow:"hidden"};else if(k={position:"absolute",width:"6px",height:"6px",top:"-9999px",left:"-9999px"},n)k.left=Math.abs(parseInt(k.left,
10))+"px";if(cb)c.oMC.style.zIndex=1E4;if(!c.debugFlash)for(l in k)k.hasOwnProperty(l)&&(c.oMC.style[l]=k[l]);try{D||c.oMC.appendChild(e);g.appendChild(c.oMC);if(D)j=c.oMC.appendChild(h.createElement("div")),j.className="sm2-object-box",j.innerHTML=m;Q=!0}catch(r){throw Error(q("domError")+" \n"+r.toString());}}P=!0;d();c._wD("soundManager::createMovie(): Trying to load "+a+(!N&&c.altURL?" (alternate URL)":""),1);return!0};aa=function(){if(c.html5Only)return ca(),!1;if(i)return!1;i=c.getMovie(c.id);
if(!i)S?(D?c.oMC.innerHTML=ua:c.oMC.appendChild(S),S=null,P=!0):ca(c.id,c.url),i=c.getMovie(c.id);i&&o("waitEI");c.oninitmovie instanceof Function&&setTimeout(c.oninitmovie,1);return!0};Z=function(){setTimeout(Fa,1E3)};Fa=function(){if(ga)return!1;ga=!0;r.remove(j,"load",Z);if(M&&!Da)return o("waitFocus"),!1;var b;n||(b=c.getMoviePercent(),c._wD(q("waitImpatient",100===b?" (SWF loaded)":0<b?" (SWF "+b+"% loaded)":"")));setTimeout(function(){b=c.getMoviePercent();n||(c._wD("soundManager: No Flash response within expected time.\nLikely causes: "+
(0===b?"Loading "+c.movieURL+" may have failed (and/or Flash "+m+"+ not present?), ":"")+"Flash blocked or JS-Flash security error."+(c.debugFlash?" "+q("checkSWF"):""),2),!N&&b&&(o("localFail",2),c.debugFlash||o("tryDebug",2)),0===b&&c._wD(q("swf404",c.url)),w("flashtojs",!1,": Timed out"+N?" (Check flash security or flash blockers)":" (No plugin/missing SWF?)"));!n&&Ta&&(null===b?c.useFlashBlock||0===c.flashLoadTimeout?(c.useFlashBlock&&va(),o("waitForever")):da(!0):0===c.flashLoadTimeout?o("waitForever"):
da(!0))},c.flashLoadTimeout)};E=function(){function b(){r.remove(j,"focus",E);r.remove(j,"load",E)}if(Da||!M)return b(),!0;Da=Ta=!0;c._wD("soundManager::handleFocus()");V&&M&&r.remove(j,"mousemove",E);ga=!1;b();return!0};Ra=function(){var b,a=[];if(c.useHTML5Audio&&c.hasHTML5){for(b in c.audioFormats)c.audioFormats.hasOwnProperty(b)&&a.push(b+": "+c.html5[b]+(!c.html5[b]&&t&&c.flash[b]?" (using flash)":c.preferFlash&&c.flash[b]&&t?" (preferring flash)":!c.html5[b]?" ("+(c.audioFormats[b].required?
"required, ":"")+"and no flash support)":""));c._wD("-- SoundManager 2: HTML5 support tests ("+c.html5Test+"): "+a.join(", ")+" --",1)}};R=function(b){if(n)return!1;if(c.html5Only)return c._wD("-- SoundManager 2: loaded --"),n=!0,I(),w("onload",!0),!0;var a;if(!c.useFlashBlock||!c.flashLoadTimeout||c.getMoviePercent())n=!0,y&&(a={type:!t&&z?"NO_FLASH":"INIT_TIMEOUT"});c._wD("-- SoundManager 2 "+(y?"failed to load":"loaded")+" ("+(y?"security/load error":"OK")+") --",1);if(y||b){if(c.useFlashBlock&&
c.oMC)c.oMC.className=L()+" "+(null===c.getMoviePercent()?"swf_timedout":"swf_error");H({type:"ontimeout",error:a});w("onload",!1);K(a);return!1}w("onload",!0);if(c.waitForWindowLoad&&!Y)return o("waitOnload"),r.add(j,"load",I),!1;c.waitForWindowLoad&&Y&&o("docLoaded");I();return!0};X=function(){o("init");if(n)return o("didInit"),!1;if(c.html5Only){if(!n)r.remove(j,"load",c.beginDelayedInit),c.enabled=!0,R();return!0}aa();try{o("flashJS"),i._externalInterfaceTest(!1),Ga(!0,c.flashPollingInterval||
(c.useHighPerformance?10:50)),c.debugMode||i._disableDebug(),c.enabled=!0,w("jstoflash",!0),c.html5Only||r.add(j,"unload",na)}catch(b){return c._wD("js/flash exception: "+b.toString()),w("jstoflash",!1),K({type:"JS_TO_FLASH_EXCEPTION",fatal:!0}),da(!0),R(),!1}R();r.remove(j,"load",c.beginDelayedInit);return!0};J=function(){if(sa)return!1;sa=!0;ta();var b=O.toLowerCase(),a=null,a=null,d="undefined"!==typeof console&&"undefined"!==typeof console.log;if(-1!==b.indexOf("sm2-usehtml5audio="))a="1"===b.charAt(b.indexOf("sm2-usehtml5audio=")+
18),d&&console.log((a?"Enabling ":"Disabling ")+"useHTML5Audio via URL parameter"),c.useHTML5Audio=a;if(-1!==b.indexOf("sm2-preferflash="))a="1"===b.charAt(b.indexOf("sm2-preferflash=")+16),d&&console.log((a?"Enabling ":"Disabling ")+"preferFlash via URL parameter"),c.preferFlash=a;if(!t&&c.hasHTML5)c._wD("SoundManager: No Flash detected"+(!c.useHTML5Audio?", enabling HTML5.":". Trying HTML5-only mode.")),c.useHTML5Audio=!0,c.preferFlash=!1;Oa();c.html5.usingFlash=Na();z=c.html5.usingFlash;Ra();if(!t&&
z)c._wD("SoundManager: Fatal error: Flash is needed to play some required formats, but is not available."),c.flashLoadTimeout=1;h.removeEventListener&&h.removeEventListener("DOMContentLoaded",J,!1);aa();return!0};za=function(){"complete"===h.readyState&&(J(),h.detachEvent("onreadystatechange",za));return!0};ra=function(){Y=!0;r.remove(j,"load",ra)};ka();r.add(j,"focus",E);r.add(j,"load",E);r.add(j,"load",Z);r.add(j,"load",ra);V&&M&&r.add(j,"mousemove",E);h.addEventListener?h.addEventListener("DOMContentLoaded",
J,!1):h.attachEvent?h.attachEvent("onreadystatechange",za):(w("onload",!1),K({type:"NO_DOM2_EVENTS",fatal:!0}));"complete"===h.readyState&&setTimeout(J,100)}var la=null;if("undefined"===typeof SM2_DEFER||!SM2_DEFER)la=new W;G.SoundManager=W;G.soundManager=la})(window);

/* JSON2 */
var JSON;if(!JSON){JSON={}}(function(){function f(n){return n<10?"0"+n:n}if(typeof Date.prototype.toJSON!=="function"){Date.prototype.toJSON=function(key){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z":null};String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(key){return this.valueOf()}}var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;function quote(string){escapable.lastIndex=0;return escapable.test(string)?'"'+string.replace(escapable,function(a){var c=meta[a];return typeof c==="string"?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+string+'"'}function str(key,holder){var i,k,v,length,mind=gap,partial,value=holder[key];if(value&&typeof value==="object"&&typeof value.toJSON==="function"){value=value.toJSON(key)}if(typeof rep==="function"){value=rep.call(holder,key,value)}switch(typeof value){case"string":return quote(value);case"number":return isFinite(value)?String(value):"null";case"boolean":case"null":return String(value);case"object":if(!value){return"null"}gap+=indent;partial=[];if(Object.prototype.toString.apply(value)==="[object Array]"){length=value.length;for(i=0;i<length;i+=1){partial[i]=str(i,value)||"null"}v=partial.length===0?"[]":gap?"[\n"+gap+partial.join(",\n"+gap)+"\n"+mind+"]":"["+partial.join(",")+"]";gap=mind;return v}if(rep&&typeof rep==="object"){length=rep.length;for(i=0;i<length;i+=1){if(typeof rep[i]==="string"){k=rep[i];v=str(k,value);if(v){partial.push(quote(k)+(gap?": ":":")+v)}}}}else{for(k in value){if(Object.prototype.hasOwnProperty.call(value,k)){v=str(k,value);if(v){partial.push(quote(k)+(gap?": ":":")+v)}}}}v=partial.length===0?"{}":gap?"{\n"+gap+partial.join(",\n"+gap)+"\n"+mind+"}":"{"+partial.join(",")+"}";gap=mind;return v}}if(typeof JSON.stringify!=="function"){JSON.stringify=function(value,replacer,space){var i;gap="";indent="";if(typeof space==="number"){for(i=0;i<space;i+=1){indent+=" "}}else{if(typeof space==="string"){indent=space}}rep=replacer;if(replacer&&typeof replacer!=="function"&&(typeof replacer!=="object"||typeof replacer.length!=="number")){throw new Error("JSON.stringify")}return str("",{"":value})}}if(typeof JSON.parse!=="function"){JSON.parse=function(text,reviver){var j;function walk(holder,key){var k,v,value=holder[key];if(value&&typeof value==="object"){for(k in value){if(Object.prototype.hasOwnProperty.call(value,k)){v=walk(value,k);if(v!==undefined){value[k]=v}else{delete value[k]}}}}return reviver.call(holder,key,value)}text=String(text);cx.lastIndex=0;if(cx.test(text)){text=text.replace(cx,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})}if(/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){j=eval("("+text+")");return typeof reviver==="function"?walk({"":j},""):j}throw new SyntaxError("JSON.parse")}}}());

/*	SWFObject v2.2 <http://code.google.com/p/swfobject/>
	is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/
var swfobject=function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();


/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels
*/
if(jQuery){(function(a){a.extend(a.fn,{uploadify:function(b){a(this).each(function(){var f=a.extend({id:a(this).attr("id"),uploader:"uploadify.swf",script:"uploadify.php",expressInstall:null,folder:"",height:30,width:120,cancelImg:"cancel.png",wmode:"opaque",scriptAccess:"sameDomain",fileDataName:"Filedata",method:"POST",queueSizeLimit:999,simUploadLimit:1,queueID:false,displayData:"percentage",removeCompleted:true,onInit:function(){},onSelect:function(){},onSelectOnce:function(){},onQueueFull:function(){},onCheck:function(){},onCancel:function(){},onClearQueue:function(){},onError:function(){},onProgress:function(){},onComplete:function(){},onAllComplete:function(){}},b);a(this).data("settings",f);var e=location.pathname;e=e.split("/");e.pop();e=e.join("/")+"/";var g={};g.uploadifyID=f.id;g.pagepath=e;if(f.buttonImg){g.buttonImg=escape(f.buttonImg)}if(f.buttonText){g.buttonText=escape(f.buttonText)}if(f.rollover){g.rollover=true}g.script=f.script;g.folder=escape(f.folder);if(f.scriptData){var h="";for(var d in f.scriptData){h+="&"+d+"="+f.scriptData[d]}g.scriptData=escape(h.substr(1))}g.width=f.width;g.height=f.height;g.wmode=f.wmode;g.method=f.method;g.queueSizeLimit=f.queueSizeLimit;g.simUploadLimit=f.simUploadLimit;if(f.hideButton){g.hideButton=true}if(f.fileDesc){g.fileDesc=f.fileDesc}if(f.fileExt){g.fileExt=f.fileExt}if(f.multi){g.multi=true}if(f.auto){g.auto=true}if(f.sizeLimit){g.sizeLimit=f.sizeLimit}if(f.checkScript){g.checkScript=f.checkScript}if(f.fileDataName){g.fileDataName=f.fileDataName}if(f.queueID){g.queueID=f.queueID}if(f.onInit()!==false){a(this).css("display","none");a(this).after('<div id="'+a(this).attr("id")+'Uploader"></div>');swfobject.embedSWF(f.uploader,f.id+"Uploader",f.width,f.height,"9.0.24",f.expressInstall,g,{quality:"high",wmode:f.wmode,allowScriptAccess:f.scriptAccess},{},function(i){if(typeof(f.onSWFReady)=="function"&&i.success){f.onSWFReady()}});if(f.queueID==false){a("#"+a(this).attr("id")+"Uploader").after('<div id="'+a(this).attr("id")+'Queue" class="uploadifyQueue"></div>')}else{a("#"+f.queueID).addClass("uploadifyQueue")}}if(typeof(f.onOpen)=="function"){a(this).bind("uploadifyOpen",f.onOpen)}a(this).bind("uploadifySelect",{action:f.onSelect,queueID:f.queueID},function(k,i,j){if(k.data.action(k,i,j)!==false){var l=Math.round(j.size/1024*100)*0.01;var m="KB";if(l>1000){l=Math.round(l*0.001*100)*0.01;m="MB"}var n=l.toString().split(".");if(n.length>1){l=n[0]+"."+n[1].substr(0,2)}else{l=n[0]}if(j.name.length>20){fileName=j.name.substr(0,20)+"..."}else{fileName=j.name}queue="#"+a(this).attr("id")+"Queue";if(k.data.queueID){queue="#"+k.data.queueID}a(queue).append('<div id="'+a(this).attr("id")+i+'" class="uploadifyQueueItem"><div class="cancel"><a href="javascript:jQuery(\'#'+a(this).attr("id")+"').uploadifyCancel('"+i+'\')"><img src="'+f.cancelImg+'" border="0" /></a></div><span class="fileName">'+fileName+" ("+l+m+')</span><span class="percentage"></span><div class="uploadifyProgress"><div id="'+a(this).attr("id")+i+'ProgressBar" class="uploadifyProgressBar"><!--Progress Bar--></div></div></div>')}});a(this).bind("uploadifySelectOnce",{action:f.onSelectOnce},function(i,j){i.data.action(i,j);if(f.auto){if(f.checkScript){a(this).uploadifyUpload(null,false)}else{a(this).uploadifyUpload(null,true)}}});a(this).bind("uploadifyQueueFull",{action:f.onQueueFull},function(i,j){if(i.data.action(i,j)!==false){alert("The queue is full.  The max size is "+j+".")}});a(this).bind("uploadifyCheckExist",{action:f.onCheck},function(n,m,l,k,p){var j=new Object();j=l;j.folder=(k.substr(0,1)=="/")?k:e+k;if(p){for(var i in l){var o=i}}a.post(m,j,function(s){for(var q in s){if(n.data.action(n,s,q)!==false){var r=confirm("Do you want to replace the file "+s[q]+"?");if(!r){document.getElementById(a(n.target).attr("id")+"Uploader").cancelFileUpload(q,true,true)}}}if(p){document.getElementById(a(n.target).attr("id")+"Uploader").startFileUpload(o,true)}else{document.getElementById(a(n.target).attr("id")+"Uploader").startFileUpload(null,true)}},"json")});a(this).bind("uploadifyCancel",{action:f.onCancel},function(n,j,m,o,i,l){if(n.data.action(n,j,m,o,l)!==false){if(i){var k=(l==true)?0:250;a("#"+a(this).attr("id")+j).fadeOut(k,function(){a(this).remove()})}}});a(this).bind("uploadifyClearQueue",{action:f.onClearQueue},function(k,j){var i=(f.queueID)?f.queueID:a(this).attr("id")+"Queue";if(j){a("#"+i).find(".uploadifyQueueItem").remove()}if(k.data.action(k,j)!==false){a("#"+i).find(".uploadifyQueueItem").each(function(){var l=a(".uploadifyQueueItem").index(this);a(this).delay(l*100).fadeOut(250,function(){a(this).remove()})})}});var c=[];a(this).bind("uploadifyError",{action:f.onError},function(m,i,l,k){if(m.data.action(m,i,l,k)!==false){var j=new Array(i,l,k);c.push(j);a("#"+a(this).attr("id")+i).find(".percentage").text(" - "+k.type+" Error");a("#"+a(this).attr("id")+i).find(".uploadifyProgress").hide();a("#"+a(this).attr("id")+i).addClass("uploadifyError")}});if(typeof(f.onUpload)=="function"){a(this).bind("uploadifyUpload",f.onUpload)}a(this).bind("uploadifyProgress",{action:f.onProgress,toDisplay:f.displayData},function(k,i,j,l){if(k.data.action(k,i,j,l)!==false){a("#"+a(this).attr("id")+i+"ProgressBar").animate({width:l.percentage+"%"},250,function(){if(l.percentage==100){a(this).closest(".uploadifyProgress").fadeOut(250,function(){a(this).remove()})}});if(k.data.toDisplay=="percentage"){displayData=""+l.percentage+"%"}if(k.data.toDisplay=="speed"){displayData=" - "+l.speed+"KB/s"}if(k.data.toDisplay==null){displayData=" "}a("#"+a(this).attr("id")+i).find(".percentage").text(displayData)}});a(this).bind("uploadifyComplete",{action:f.onComplete},function(l,i,k,j,m){if(l.data.action(l,i,k,unescape(j),m)!==false){a("#"+a(this).attr("id")+i).find(".percentage").text("Completed");if(f.removeCompleted){a("#"+a(l.target).attr("id")+i).fadeOut(250,function(){a(this).remove()})}a("#"+a(l.target).attr("id")+i).addClass("completed")}});if(typeof(f.onAllComplete)=="function"){a(this).bind("uploadifyAllComplete",{action:f.onAllComplete},function(i,j){if(i.data.action(i,j)!==false){c=[]}})}})},uploadifySettings:function(f,j,c){var g=false;a(this).each(function(){if(f=="scriptData"&&j!=null){if(c){var i=j}else{var i=a.extend(a(this).data("settings").scriptData,j)}var l="";for(var k in i){l+="&"+k+"="+i[k]}j=escape(l.substr(1))}g=document.getElementById(a(this).attr("id")+"Uploader").updateSettings(f,j)});if(j==null){if(f=="scriptData"){var b=unescape(g).split("&");var e=new Object();for(var d=0;d<b.length;d++){var h=b[d].split("=");e[h[0]]=h[1]}g=e}}return g},uploadifyUpload:function(b,c){a(this).each(function(){if(!c){c=false}document.getElementById(a(this).attr("id")+"Uploader").startFileUpload(b,c)})},uploadifyCancel:function(b){a(this).each(function(){document.getElementById(a(this).attr("id")+"Uploader").cancelFileUpload(b,true,true,false)})},uploadifyClearQueue:function(){a(this).each(function(){document.getElementById(a(this).attr("id")+"Uploader").clearFileUploadQueue(false)})}})})(jQuery)};



/**
 * WYSIWYG - jQuery plugin 0.97
 * (0.97.2 - From infinity)
 *
 * Copyright (c) 2008-2009 Juan M Martinez, 2010-2011 Akzhan Abdulin and all contributors
 * https://github.com/akzhan/jwysiwyg
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 */
(function ($) {
	"use strict";
	/* Wysiwyg namespace: private properties and methods */

	var console = window.console ? window.console : {
		log: $.noop,
		error: function (msg) {
			$.error(msg);
		}
	};
	var supportsProp = (('prop' in $.fn) && ('removeProp' in $.fn));

	function Wysiwyg() {
		// - the item is added by this.ui.appendControls and then appendItem
		// - click triggers this.triggerControl
		// cmd or[key] - designMode exec function name
		// tags - activates control for these tags (@see checkTargets)
		// css - activates control if one of css is applied
		this.controls = {
			bold: {
				groupIndex: 0,
				visible: true,
				tags: ["b", "strong"],
				css: {
					fontWeight: "bold"
				},
				tooltip: "Bold",
				hotkey: {"ctrl": 1, "key": 66}
			},

			copy: {
				groupIndex: 8,
				visible: false,
				tooltip: "Copy"
			},

			createLink: {
				groupIndex: 6,
				visible: true,
				exec: function () {
					var self = this;
					if ($.wysiwyg.controls && $.wysiwyg.controls.link) {
						$.wysiwyg.controls.link.init(this);
					} else if ($.wysiwyg.autoload) {
						$.wysiwyg.autoload.control("wysiwyg.link.js", function () {
							self.controls.createLink.exec.apply(self);
						});
					} else {
						console.error("$.wysiwyg.controls.link not defined. You need to include wysiwyg.link.js file");
					}
				},
				tags: ["a"],
				tooltip: "Create link"
			},

			unLink : {
				groupIndex: 6,
				visible: true,
				exec : function() {
					this.editorDoc.execCommand("unlink", false, null);
				},
				tooltip: "Remove link"
			},

			cut: {
				groupIndex: 8,
				visible: false,
				tooltip: "Cut"
			},

			decreaseFontSize: {
				groupIndex: 9,
				visible: false,
				tags: ["small"],
				tooltip: "Decrease font size",
				exec: function () {
					this.decreaseFontSize();
				}
			},

			h1: {
				groupIndex: 7,
				visible: true,
				className: "h1",
				command: ($.browser.msie || $.browser.safari) ? "FormatBlock" : "heading",
				"arguments": ($.browser.msie || $.browser.safari) ? "<h1>" : "h1",
				tags: ["h1"],
				tooltip: "Header 1"
			},

			h2: {
				groupIndex: 7,
				visible: true,
				className: "h2",
				command: ($.browser.msie || $.browser.safari)	? "FormatBlock" : "heading",
				"arguments": ($.browser.msie || $.browser.safari) ? "<h2>" : "h2",
				tags: ["h2"],
				tooltip: "Header 2"
			},

			h3: {
				groupIndex: 7,
				visible: true,
				className: "h3",
				command: ($.browser.msie || $.browser.safari) ? "FormatBlock" : "heading",
				"arguments": ($.browser.msie || $.browser.safari) ? "<h3>" : "h3",
				tags: ["h3"],
				tooltip: "Header 3"
			},

			highlight: {
				tooltip:     "Highlight",
				className:   "highlight",
				groupIndex:  1,
				visible:     false,
				css: {
					backgroundColor: "rgb(255, 255, 102)"
				},
				exec: function () {
					var command, node, selection, args;

					if ($.browser.msie || $.browser.safari) {
						command = "backcolor";
					} else {
						command = "hilitecolor";
					}

					if ($.browser.msie) {
						node = this.getInternalRange().parentElement();
					} else {
						selection = this.getInternalSelection();
						node = selection.extentNode || selection.focusNode;

						while (node.style === undefined) {
							node = node.parentNode;
							if (node.tagName && node.tagName.toLowerCase() === "body") {
								return;
							}
						}
					}

					if (node.style.backgroundColor === "rgb(255, 255, 102)" ||
							node.style.backgroundColor === "#ffff66") {
						args = "#ffffff";
					} else {
						args = "#ffff66";
					}

					this.editorDoc.execCommand(command, false, args);
				}
			},

			html: {
				groupIndex: 10,
				visible: false,
				exec: function () {
					var elementHeight;

					if (this.options.resizeOptions && $.fn.resizable) {
						elementHeight = this.element.height();
					}

					if (this.viewHTML) { //textarea is shown
						this.setContent(this.original.value);

						$(this.original).hide();
						this.editor.show();

						if (this.options.resizeOptions && $.fn.resizable) {
							// if element.height still the same after frame was shown
							if (elementHeight === this.element.height()) {
								this.element.height(elementHeight + this.editor.height());
							}

							this.element.resizable($.extend(true, {
								alsoResize: this.editor
							}, this.options.resizeOptions));
						}

						this.ui.toolbar.find("li").each(function () {
							var li = $(this);

							if (li.hasClass("html")) {
								li.removeClass("active");
							} else {
								li.removeClass('disabled');
							}
						});
					} else { //wysiwyg is shown
						this.saveContent();

						$(this.original).css({
							width:	this.element.outerWidth() - 6,
							height: this.element.height() - this.ui.toolbar.height() - 6,
							resize: "none"
						}).show();
						this.editor.hide();

						if (this.options.resizeOptions && $.fn.resizable) {
							// if element.height still the same after frame was hidden
							if (elementHeight === this.element.height()) {
								this.element.height(this.ui.toolbar.height());
							}

							this.element.resizable("destroy");
						}

						this.ui.toolbar.find("li").each(function () {
							var li = $(this);

							if (li.hasClass("html")) {
								li.addClass("active");
							} else {
								if (false === li.hasClass("fullscreen")) {
									li.removeClass("active").addClass('disabled');
								}
							}
						});
					}

					this.viewHTML = !(this.viewHTML);
				},
				tooltip: "View source code"
			},

			increaseFontSize: {
				groupIndex: 9,
				visible: false,
				tags: ["big"],
				tooltip: "Increase font size",
				exec: function () {
					this.increaseFontSize();
				}
			},

			indent: {
				groupIndex: 2,
				visible: true,
				tooltip: "Indent"
			},

			insertHorizontalRule: {
				groupIndex: 6,
				visible: true,
				tags: ["hr"],
				tooltip: "Insert Horizontal Rule"
			},

			insertImage: {
				groupIndex: 6,
				visible: true,
				exec: function () {
					var self = this;

					if ($.wysiwyg.controls && $.wysiwyg.controls.image) {
						$.wysiwyg.controls.image.init(this);
					} else if ($.wysiwyg.autoload) {
						$.wysiwyg.autoload.control("wysiwyg.image.js", function () {
							self.controls.insertImage.exec.apply(self);
						});
					} else {
						console.error("$.wysiwyg.controls.image not defined. You need to include wysiwyg.image.js file");
					}
				},
				tags: ["img"],
				tooltip: "Insert image"
			},

			insertOrderedList: {
				groupIndex: 5,
				visible: true,
				tags: ["ol"],
				tooltip: "Insert Ordered List"
			},

			insertTable: {
				groupIndex: 6,
				visible: true,
				exec: function () {
					var self = this;

					if ($.wysiwyg.controls && $.wysiwyg.controls.table) {
						$.wysiwyg.controls.table(this);
					} else if ($.wysiwyg.autoload) {
						$.wysiwyg.autoload.control("wysiwyg.table.js", function () {
							self.controls.insertTable.exec.apply(self);
						});
					} else {
						console.error("$.wysiwyg.controls.table not defined. You need to include wysiwyg.table.js file");
					}
				},
				tags: ["table"],
				tooltip: "Insert table"
			},

			insertUnorderedList: {
				groupIndex: 5,
				visible: true,
				tags: ["ul"],
				tooltip: "Insert Unordered List"
			},

			italic: {
				groupIndex: 0,
				visible: true,
				tags: ["i", "em"],
				css: {
					fontStyle: "italic"
				},
				tooltip: "Italic",
				hotkey: {"ctrl": 1, "key": 73}
			},

			justifyCenter: {
				groupIndex: 1,
				visible: true,
				tags: ["center"],
				css: {
					textAlign: "center"
				},
				tooltip: "Justify Center"
			},

			justifyFull: {
				groupIndex: 1,
				visible: true,
				css: {
					textAlign: "justify"
				},
				tooltip: "Justify Full"
			},

			justifyLeft: {
				visible: true,
				groupIndex: 1,
				css: {
					textAlign: "left"
				},
				tooltip: "Justify Left"
			},

			justifyRight: {
				groupIndex: 1,
				visible: true,
				css: {
					textAlign: "right"
				},
				tooltip: "Justify Right"
			},

			ltr: {
				groupIndex: 10,
				visible: false,
				exec: function () {
					var p = this.dom.getElement("p");

					if (!p) {
						return false;
					}

					$(p).attr("dir", "ltr");
					return true;
				},
				tooltip : "Left to Right"
			},

			outdent: {
				groupIndex: 2,
				visible: true,
				tooltip: "Outdent"
			},

			paragraph: {
				groupIndex: 7,
				visible: false,
				className: "paragraph",
				command: "FormatBlock",
				"arguments": ($.browser.msie || $.browser.safari) ? "<p>" : "p",
				tags: ["p"],
				tooltip: "Paragraph"
			},

			paste: {
				groupIndex: 8,
				visible: false,
				tooltip: "Paste"
			},

			redo: {
				groupIndex: 4,
				visible: true,
				tooltip: "Redo"
			},

			removeFormat: {
				groupIndex: 10,
				visible: true,
				exec: function () {
					this.removeFormat();
				},
				tooltip: "Remove formatting"
			},

			rtl: {
				groupIndex: 10,
				visible: false,
				exec: function () {
					var p = this.dom.getElement("p");

					if (!p) {
						return false;
					}

					$(p).attr("dir", "rtl");
					return true;
				},
				tooltip : "Right to Left"
			},

			strikeThrough: {
				groupIndex: 0,
				visible: true,
				tags: ["s", "strike"],
				css: {
					textDecoration: "line-through"
				},
				tooltip: "Strike-through"
			},

			subscript: {
				groupIndex: 3,
				visible: true,
				tags: ["sub"],
				tooltip: "Subscript"
			},

			superscript: {
				groupIndex: 3,
				visible: true,
				tags: ["sup"],
				tooltip: "Superscript"
			},

			underline: {
				groupIndex: 0,
				visible: true,
				tags: ["u"],
				css: {
					textDecoration: "underline"
				},
				tooltip: "Underline",
				hotkey: {"ctrl": 1, "key": 85}
			},

			undo: {
				groupIndex: 4,
				visible: true,
				tooltip: "Undo"
			},

			code: {
				visible : true,
				groupIndex: 6,
				tooltip: "Code snippet",
				exec: function () {
					var range	= this.getInternalRange(),
						common	= $(range.commonAncestorContainer),
						$nodeName = range.commonAncestorContainer.nodeName.toLowerCase();
					if (common.parent("code").length) {
						common.unwrap();
					} else {
						if ($nodeName !== "body") {
							common.wrap("<code/>");
						}
					}
				}
			},

			cssWrap: {
				visible : false,
				groupIndex: 6,
				tooltip: "CSS Wrapper",
				exec: function () {
					$.wysiwyg.controls.cssWrap.init(this);
				}
			}

		};

		this.defaults = {
html: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" style="margin:0"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body style="margin:0;">INITIAL_CONTENT</body></html>',
			debug: false,
			controls: {},
			css: {},
			events: {},
			autoGrow: false,
			autoSave: true,
			brIE: true,					// http://code.google.com/p/jwysiwyg/issues/detail?id=15
			formHeight: 270,
			formWidth: 440,
			iFrameClass: null,
			initialContent: "<p>Initial content</p>",
			maxHeight: 10000,			// see autoGrow
			maxLength: 0,
			messages: {
				nonSelection: "Select the text you wish to link"
			},
			toolbarHtml: '<ul role="menu" class="toolbar"></ul>',
			removeHeadings: false,
			replaceDivWithP: false,
			resizeOptions: false,
			rmUnusedControls: false,	// https://github.com/akzhan/jwysiwyg/issues/52
			rmUnwantedBr: true,			// http://code.google.com/p/jwysiwyg/issues/detail?id=11
			tableFiller: "Lorem ipsum",
			initialMinHeight: null,

			controlImage: {
				forceRelativeUrls: false
			},

			controlLink: {
				forceRelativeUrls: false
			},

			plugins: { // placeholder for plugins settings
				autoload: false,
				i18n: false,
				rmFormat: {
					rmMsWordMarkup: false
				}
			},

			dialog : "default"
		};

		//these properties are set from control hashes
		this.availableControlProperties = [
			"arguments",
			"callback",
			"className",
			"command",
			"css",
			"custom",
			"exec",
			"groupIndex",
			"hotkey",
			"icon",
			"tags",
			"tooltip",
			"visible"
		];

		this.editor			= null;  //jquery iframe holder
		this.editorDoc		= null;
		this.element		= null;
		this.options		= {};
		this.original		= null;
		this.savedRange		= null;
		this.timers			= [];
		this.validKeyCodes	= [8, 9, 13, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46];

		this.isDestroyed	= false;

		this.dom		= { // DOM related properties and methods
			ie:		{
				parent: null // link to dom
			},
			w3c:	{
				parent: null // link to dom
			}
		};
		this.dom.parent		= this;
		this.dom.ie.parent	= this.dom;
		this.dom.w3c.parent	= this.dom;

		this.ui			= {};	// UI related properties and methods
		this.ui.self	= this;
		this.ui.toolbar	= null;
		this.ui.initialHeight = null; // ui.grow

		this.dom.getAncestor = function (element, filterTagName) {
			filterTagName = filterTagName.toLowerCase();

			while (element && typeof element.tagName != "undefined" && "body" !== element.tagName.toLowerCase()) {
				if (filterTagName === element.tagName.toLowerCase()) {
					return element;
				}

				element = element.parentNode;
			}
			if(!element.tagName && (element.previousSibling || element.nextSibling)) {
				if(element.previousSibling) {
					if(element.previousSibling.tagName.toLowerCase() == filterTagName) {
						return element.previousSibling;
					}
				}
				if(element.nextSibling) {
					if(element.nextSibling.tagName.toLowerCase() == filterTagName) {
						return element.nextSibling;
					}
				}
			}

			return null;
		};

		this.dom.getElement = function (filterTagName) {
			var dom = this;

			filterTagName = filterTagName.toLowerCase();

			if (window.getSelection) {
				return dom.w3c.getElement(filterTagName);
			} else {
				return dom.ie.getElement(filterTagName);
			}
		};

		this.dom.ie.getElement = function (filterTagName) {
			var dom			= this.parent,
				selection	= dom.parent.getInternalSelection(),
				range		= selection.createRange(),
				element;

			if ("Control" === selection.type) {
				// control selection
				if (1 === range.length) {
					element = range.item(0);
				} else {
					// multiple control selection
					return null;
				}
			} else {
				element = range.parentElement();
			}

			return dom.getAncestor(element, filterTagName);
		};

		this.dom.w3c.getElement = function (filterTagName) {
			var dom		= this.parent,
				range	= dom.parent.getInternalRange(),
				element;

			if (!range) {
				return null;
			}

			element	= range.commonAncestorContainer;

			if (3 === element.nodeType) {
				element = element.parentNode;
			}

			// if startContainer not Text, Comment, or CDATASection element then
			// startOffset is the number of child nodes between the start of the
			// startContainer and the boundary point of the Range
			if (element === range.startContainer) {
				element = element.childNodes[range.startOffset];
			}

			if(!element.tagName && (element.previousSibling || element.nextSibling)) {
				if(element.previousSibling) {
					if(element.previousSibling.tagName.toLowerCase() == filterTagName) {
						return element.previousSibling;
					}
				}
				if(element.nextSibling) {
					if(element.nextSibling.tagName.toLowerCase() == filterTagName) {
						return element.nextSibling;
					}
				}
			}

			return dom.getAncestor(element, filterTagName);
		};

		this.ui.addHoverClass = function () {
			$(this).addClass("wysiwyg-button-hover");
		};

		this.ui.appendControls = function () {
			var ui = this,
				self = this.self,
				controls = self.parseControls(),
				hasVisibleControls	= true, // to prevent separator before first item
				groups = [],
				controlsByGroup = {},
				i,
				currentGroupIndex, // jslint wants all vars at top of function
				iterateGroup = function (controlName, control) { //called for every group when adding
					if (control.groupIndex && currentGroupIndex !== control.groupIndex) {
						currentGroupIndex = control.groupIndex;
						hasVisibleControls = false;
					}

					if (!control.visible) {
						return;
					}

					if (!hasVisibleControls) {
						ui.appendItemSeparator();
						hasVisibleControls = true;
					}

					if (control.custom) {
						ui.appendItemCustom(controlName, control);
					} else {
						ui.appendItem(controlName, control);
					}
				};

			$.each(controls, function (name, c) { //sort by groupIndex
				var index = "empty";

				if (undefined !== c.groupIndex) {
					if ("" === c.groupIndex) {
						index = "empty";
					} else {
						index = c.groupIndex;
					}
				}

				if (undefined === controlsByGroup[index]) {
					groups.push(index);
					controlsByGroup[index] = {};
				}
				controlsByGroup[index][name] = c;
			});

			groups.sort(function (a, b) { //just sort group indexes by
				if ("number" === typeof (a) && typeof (a) === typeof (b)) {
					return (a - b);
				} else {
					a = a.toString();
					b = b.toString();

					if (a > b) {
						return 1;
					}

					if (a === b) {
						return 0;
					}

					return -1;
				}
			});

			if (0 < groups.length) {
				// set to first index in groups to proper placement of separator
				currentGroupIndex = groups[0];
			}

			for (i = 0; i < groups.length; i += 1) {
				$.each(controlsByGroup[groups[i]], iterateGroup);
			}
		};

		this.ui.appendItem = function (name, control) {
			var self = this.self,
				className = control.className || control.command || name || "empty",
				tooltip = control.tooltip || control.command || name || "";

			return $('<li role="menuitem" unselectable="on">' + (className) + "</li>")
				.addClass(className)
				.attr("title", tooltip)
				.hover(this.addHoverClass, this.removeHoverClass)
				.click(function (event) {
					if ($(this).hasClass("disabled")) {
						return false;
					}

					self.triggerControl.apply(self, [name, control]);

					/**
					* @link https://github.com/akzhan/jwysiwyg/issues/219
					*/
					var $target = $(event.target);
					for (var controlName in self.controls) {
						if ($target.hasClass(controlName)) {
							self.ui.toolbar.find("." + controlName).toggleClass("active");
							self.editorDoc.rememberCommand = true;
							break;
						}
					}

					this.blur();
					self.ui.returnRange();
					self.ui.focus();
					return true;
				})
				.appendTo(self.ui.toolbar);
		};

		this.ui.appendItemCustom = function (name, control) {
			var self = this.self,
				tooltip = control.tooltip || control.command || name || "";

			if (control.callback) {
				$(window).bind("trigger-" + name + ".wysiwyg", control.callback);
			}

			return $('<li role="menuitem" unselectable="on" style="background: url(\'' + control.icon + '\') no-repeat;"></li>')
				.addClass("custom-command-" + name)
				.addClass("wysiwyg-custom-command")
				.addClass(name)
				.attr("title", tooltip)
				.hover(this.addHoverClass, this.removeHoverClass)
				.click(function () {
					if ($(this).hasClass("disabled")) {
						return false;
					}

					self.triggerControl.apply(self, [name, control]);

					this.blur();
					self.ui.returnRange();
					self.ui.focus();

					self.triggerControlCallback(name);
					return true;
				})
				.appendTo(self.ui.toolbar);
		};

		this.ui.appendItemSeparator = function () {
			var self = this.self;
			return $('<li role="separator" class="separator"></li>').appendTo(self.ui.toolbar);
		};

		this.autoSaveFunction = function () {
			this.saveContent();
		};

		//called after click in wysiwyg "textarea"
		this.ui.checkTargets = function (element) {
			var self = this.self;

			//activate controls
			$.each(self.options.controls, function (name, control) {
				var className = control.className || control.command || name || "empty",
					tags,
					elm,
					css,
					el,
					checkActiveStatus = function (cssProperty, cssValue) {
						var handler;

						if ("function" === typeof (cssValue)) {
							handler = cssValue;
							if (handler(el.css(cssProperty).toString().toLowerCase(), self)) {
								self.ui.toolbar.find("." + className).addClass("active");
							}
						} else {
							if (el.css(cssProperty).toString().toLowerCase() === cssValue) {
								self.ui.toolbar.find("." + className).addClass("active");
							}
						}
					};

				if ("fullscreen" !== className) {
					self.ui.toolbar.find("." + className).removeClass("active");
				}

				//activate by allowed tags
				if (control.tags || (control.options && control.options.tags)) {
					tags = control.tags || (control.options && control.options.tags);

					elm = element;
					while (elm) {
						if (elm.nodeType !== 1) {
							break;
						}

						if ($.inArray(elm.tagName.toLowerCase(), tags) !== -1) {
							self.ui.toolbar.find("." + className).addClass("active");
						}

						elm = elm.parentNode;
					}
				}

				//activate by supposed css
				if (control.css || (control.options && control.options.css)) {
					css = control.css || (control.options && control.options.css);
					el = $(element);

					while (el) {
						if (el[0].nodeType !== 1) {
							break;
						}
						$.each(css, checkActiveStatus);

						el = el.parent();
					}
				}
			});
		};

		this.ui.designMode = function () {
			var attempts = 3,
				self = this.self,
				runner;
				runner = function (attempts) {
					if ("on" === self.editorDoc.designMode) {
						if (self.timers.designMode) {
							window.clearTimeout(self.timers.designMode);
						}

						// IE needs to reget the document element (this.editorDoc) after designMode was set
						if (self.innerDocument() !== self.editorDoc) {
							self.ui.initFrame();
						}

						return;
					}

					try {
						self.editorDoc.designMode = "on";
					} catch (e) {
					}

					attempts -= 1;
					if (attempts > 0) {
						self.timers.designMode = window.setTimeout(function () { runner(attempts); }, 100);
					}
				};

			runner(attempts);
		};

		this.destroy = function () {
			this.isDestroyed = true;

			var i, $form = this.element.closest("form");

			for (i = 0; i < this.timers.length; i += 1) {
				window.clearTimeout(this.timers[i]);
			}

			// Remove bindings
			$form.unbind(".wysiwyg");
			this.element.remove();
			$.removeData(this.original, "wysiwyg");
			$(this.original).show();
			return this;
		};

		this.getRangeText = function () {
			var r = this.getInternalRange();

			if (r.toString) {
				r = r.toString();
			} else if (r.text) {	// IE
				r = r.text;
			}

			return r;
		};
		//not used?
		this.execute = function (command, arg) {
			if (typeof (arg) === "undefined") {
				arg = null;
			}
			this.editorDoc.execCommand(command, false, arg);
		};

		this.extendOptions = function (options) {
			var controls = {};

			/**
			 * If the user set custom controls, we catch it, and merge with the
			 * defaults controls later.
			 */
			if ("object" === typeof options.controls) {
				controls = options.controls;
				delete options.controls;
			}

			options = $.extend(true, {}, this.defaults, options);
			options.controls = $.extend(true, {}, controls, this.controls, controls);

			if (options.rmUnusedControls) {
				$.each(options.controls, function (controlName) {
					if (!controls[controlName]) {
						delete options.controls[controlName];
					}
				});
			}

			return options;
		};

		this.ui.focus = function () {
			var self = this.self;

			self.editor.get(0).contentWindow.focus();
			return self;
		};

		this.ui.returnRange = function () {
			var self = this.self, sel;

			if (self.savedRange !== null) {
				if (window.getSelection) { //non IE and there is already a selection
					sel = window.getSelection();
					if (sel.rangeCount > 0) {
						sel.removeAllRanges();
					}
					try {
						sel.addRange(self.savedRange);
					} catch (e) {
						console.error(e);
					}
				} else if (window.document.createRange) { // non IE and no selection
					window.getSelection().addRange(self.savedRange);
				} else if (window.document.selection) { //IE
					self.savedRange.select();
				}

				self.savedRange = null;
			}
		};

		this.increaseFontSize = function () {
			if ($.browser.mozilla || $.browser.opera) {
				this.editorDoc.execCommand("increaseFontSize", false, null);
			} else if ($.browser.safari) {
				var Range = this.getInternalRange(),
					Selection = this.getInternalSelection(),
					newNode = this.editorDoc.createElement("big");

				// If cursor placed on text node
				if (true === Range.collapsed && 3 === Range.commonAncestorContainer.nodeType) {
					var text = Range.commonAncestorContainer.nodeValue.toString(),
						start = text.lastIndexOf(" ", Range.startOffset) + 1,
						end = (-1 === text.indexOf(" ", Range.startOffset)) ? text : text.indexOf(" ", Range.startOffset);

					Range.setStart(Range.commonAncestorContainer, start);
					Range.setEnd(Range.commonAncestorContainer, end);

					Range.surroundContents(newNode);
					Selection.addRange(Range);
				} else {
					Range.surroundContents(newNode);
					Selection.removeAllRanges();
					Selection.addRange(Range);
				}
			} else {
				console.error("Internet Explorer?");
			}
		};

		this.decreaseFontSize = function () {
			if ($.browser.mozilla || $.browser.opera) {
				this.editorDoc.execCommand("decreaseFontSize", false, null);
			} else if ($.browser.safari) {
				var Range = this.getInternalRange(),
					Selection = this.getInternalSelection(),
					newNode = this.editorDoc.createElement("small");

				// If cursor placed on text node
				if (true === Range.collapsed && 3 === Range.commonAncestorContainer.nodeType) {
					var text = Range.commonAncestorContainer.nodeValue.toString(),
						start = text.lastIndexOf(" ", Range.startOffset) + 1,
						end = (-1 === text.indexOf(" ", Range.startOffset)) ? text : text.indexOf(" ", Range.startOffset);

					Range.setStart(Range.commonAncestorContainer, start);
					Range.setEnd(Range.commonAncestorContainer, end);

					Range.surroundContents(newNode);
					Selection.addRange(Range);
				} else {
					Range.surroundContents(newNode);
					Selection.removeAllRanges();
					Selection.addRange(Range);
				}
			} else {
				console.error("Internet Explorer?");
			}
		};

		this.getContent = function () {
			if (this.viewHTML) {
				this.setContent(this.original.value);
			}
			return this.events.filter('getContent', this.editorDoc.body.innerHTML);
		};

		/**
		 * A jWysiwyg specific event system.
		 *
		 * Example:
		 *
		 * $("#editor").getWysiwyg().events.bind("getContent", function (orig) {
		 *     return "<div id='content'>"+orgi+"</div>";
		 * });
		 *
		 * This makes it so that when ever getContent is called, it is wrapped in a div#content.
		 */
		this.events = {
			_events : {},

			/**
			 * Similar to jQuery's bind, but for jWysiwyg only.
			 */
			bind : function (eventName, callback) {
				if (typeof (this._events.eventName) !== "object") {
					this._events[eventName] = [];
				}
				this._events[eventName].push(callback);
			},

			/**
			 * Similar to jQuery's trigger, but for jWysiwyg only.
			 */
			trigger : function (eventName, args) {
				if (typeof (this._events.eventName) === "object") {
					var editor = this.editor;
					$.each(this._events[eventName], function (k, v) {
						if (typeof (v) === "function") {
							v.apply(editor, args);
						}
					});
				}
			},

			/**
			 * This "filters" `originalText` by passing it as the first argument to every callback
			 * with the name `eventName` and taking the return value and passing it to the next function.
			 *
			 * This function returns the result after all the callbacks have been applied to `originalText`.
			 */
			filter : function (eventName, originalText) {
				if (typeof (this._events[eventName]) === "object") {
					var editor = this.editor,
						args = Array.prototype.slice.call(arguments, 1);

					$.each(this._events[eventName], function (k, v) {
						if (typeof (v) === "function") {
							originalText = v.apply(editor, args);
						}
					});
				}
				return originalText;
			}
		};

		this.getElementByAttributeValue = function (tagName, attributeName, attributeValue) {
			var i, value, elements = this.editorDoc.getElementsByTagName(tagName);

			for (i = 0; i < elements.length; i += 1) {
				value = elements[i].getAttribute(attributeName);

				if ($.browser.msie) {
					/** IE add full path, so I check by the last chars. */
					value = value.substr(value.length - attributeValue.length);
				}

				if (value === attributeValue) {
					return elements[i];
				}
			}

			return false;
		};

		this.getInternalRange = function () {
			var selection = this.getInternalSelection();

			if (!selection) {
				return null;
			}

			if (selection.rangeCount && selection.rangeCount > 0) { // w3c
				return selection.getRangeAt(0);
			} else if (selection.createRange) { // ie
				return selection.createRange();
			}

			return null;
		};

		this.getInternalSelection = function () {
			// firefox: document.getSelection is deprecated
			if (this.editor.get(0).contentWindow) {
				if (this.editor.get(0).contentWindow.getSelection) {
					return this.editor.get(0).contentWindow.getSelection();
				}
				if (this.editor.get(0).contentWindow.selection) {
					return this.editor.get(0).contentWindow.selection;
				}
			}
			if (this.editorDoc.getSelection) {
				return this.editorDoc.getSelection();
			}
			if (this.editorDoc.selection) {
				return this.editorDoc.selection;
			}

			return null;
		};

		this.getRange = function () {
			var selection = this.getSelection();

			if (!selection) {
				return null;
			}

			if (selection.rangeCount && selection.rangeCount > 0) { // w3c
				selection.getRangeAt(0);
			} else if (selection.createRange) { // ie
				return selection.createRange();
			}

			return null;
		};

		this.getSelection = function () {
			return (window.getSelection) ? window.getSelection() : window.document.selection;
		};

		// :TODO: you can type long string and letters will be hidden because of overflow
		this.ui.grow = function () {
			var self = this.self,
				innerBody = $(self.editorDoc.body),
				innerHeight = $.browser.msie ? innerBody[0].scrollHeight : innerBody.height() + 2 + 20, // 2 - borders, 20 - to prevent content jumping on grow
				minHeight = self.ui.initialHeight,
				height = Math.max(innerHeight, minHeight);

			height = Math.min(height, self.options.maxHeight);

			self.editor.attr("scrolling", height < self.options.maxHeight ? "no" : "auto"); // hide scrollbar firefox
			innerBody.css("overflow", height < self.options.maxHeight ? "hidden" : ""); // hide scrollbar chrome

			self.editor.get(0).height = height;

			return self;
		};

		this.init = function (element, options) {
			var self = this,
				$form = $(element).closest("form"),
				newX = (element.width || element.clientWidth || 0),
				newY = (element.height || element.clientHeight || 0)
				;

			this.options	= this.extendOptions(options);
			this.original	= element;
			this.ui.toolbar	= $(this.options.toolbarHtml);

			if ($.browser.msie && parseInt($.browser.version, 10) < 8) {
				this.options.autoGrow = false;
			}

			if (newX === 0 && element.cols) {
				newX = (element.cols * 8) + 21;
			}
			if (newY === 0 && element.rows) {
				newY = (element.rows * 16) + 16;
			}

			this.editor = $(window.location.protocol === "https:" ? '<iframe src="javascript:false;"></iframe>' : "<iframe></iframe>").attr("frameborder", "0");

			if (this.options.iFrameClass) {
				this.editor.addClass(this.options.iFrameClass);
			} else {
				this.editor.css({
					minHeight: (newY - 6).toString() + "px",
					// fix for issue 12 ( http://github.com/akzhan/jwysiwyg/issues/issue/12 )
					width: (newX > 50) ? newX.toString() + "px" : ""
				});
				if ($.browser.msie && parseInt($.browser.version, 10) < 7) {
					this.editor.css("height", newY.toString() + "px");
				}
			}
			/**
			 * Automagically add id to iframe if textarea has its own when possible
			 * ( http://github.com/akzhan/jwysiwyg/issues/245 )
			 */
			if (element.id) {
				var proposedId = element.id + '-wysiwyg-iframe';
				if (! document.getElementById(proposedId)) {
					this.editor.attr('id', proposedId);
				}
			}

			/**
			 * http://code.google.com/p/jwysiwyg/issues/detail?id=96
			 */
			this.editor.attr("tabindex", $(element).attr("tabindex"));

			this.element = $("<div/>").addClass("wysiwyg");

			if (!this.options.iFrameClass) {
				this.element.css({
					width: (newX > 0) ? newX.toString() + "px" : "100%"
				});
			}

			$(element).hide().before(this.element);

			this.viewHTML = false;

			/**
			 * @link http://code.google.com/p/jwysiwyg/issues/detail?id=52
			 */
			this.initialContent = $(element).val();
			this.ui.initFrame();

			if (this.options.resizeOptions && $.fn.resizable) {
				this.element.resizable($.extend(true, {
					alsoResize: this.editor
				}, this.options.resizeOptions));
			}

			if (this.options.autoSave) {
				$form.bind("submit.wysiwyg", function () { self.autoSaveFunction(); });
			}

			$form.bind("reset.wysiwyg", function () { self.resetFunction(); });
		};

		this.ui.initFrame = function () {
			var self = this.self,
				stylesheet,
				growHandler,
				saveHandler;

			self.ui.appendControls();
			self.element.append(self.ui.toolbar)
				.append($("<div><!-- --></div>")
					.css({
						clear: "both"
					}))
				.append(self.editor);

			self.editorDoc = self.innerDocument();

			if (self.isDestroyed) {
				return null;
			}

			self.ui.designMode();
			self.editorDoc.open();
			self.editorDoc.write(
				self.options.html
					/**
					 * @link http://code.google.com/p/jwysiwyg/issues/detail?id=144
					 */
					.replace(/INITIAL_CONTENT/, function () { return self.wrapInitialContent(); })
			);
			self.editorDoc.close();

			$.wysiwyg.plugin.bind(self);

			$(self.editorDoc).trigger("initFrame.wysiwyg");

			$(self.editorDoc).bind("click.wysiwyg", function (event) {
				self.ui.checkTargets(event.target ? event.target : event.srcElement);
			});

            /**
             * @link https://github.com/akzhan/jwysiwyg/issues/251
             */
            setInterval(function () {
                var offset = null;

                try {
                    var range = self.getInternalRange();
                    if (range) {
                        offset = {
                            range: range,
                            parent: $.browser.msie ? range.parentElement() : range.endContainer.parentNode,
                            width: ($.browser.msie ? range.boundingWidth : range.startOffset - range.endOffset) || 0
                        };
                    }
                }
                catch (e) { console.error(e); }

                if (offset && offset.width == 0 && !self.editorDoc.rememberCommand) {
                    self.ui.checkTargets(offset.parent);
                }
            }, 400);

			/**
			 * @link http://code.google.com/p/jwysiwyg/issues/detail?id=20
			 * @link https://github.com/akzhan/jwysiwyg/issues/330
			 */
			$(self.original).focus(function () {
				if(self.viewHTML){
					return;
				}
				if ($(this).filter(":visible").length === 0 || $.browser.opera) {
					return;
				}
				self.ui.focus();
			});

			$(self.editorDoc).keydown(function (event) {
				var emptyContentRegex;
				if (event.keyCode === 8) { // backspace
					emptyContentRegex = /^<([\w]+)[^>]*>(<br\/?>)?<\/\1>$/;
					if (emptyContentRegex.test(self.getContent())) { // if content is empty
						event.stopPropagation(); // prevent remove single empty tag
						return false;
					}
				}

                self.editorDoc.rememberCommand = false;
				return true;
			});

			if (!$.browser.msie) {
				$(self.editorDoc).keydown(function (event) {
					var controlName;
                    			var control;

					/* Meta for Macs. tom@punkave.com */
					if (event.ctrlKey || event.metaKey) {
						for (controlName in self.options.controls) {
                            				control = self.options.controls[controlName];
							if (control.hotkey && control.hotkey.ctrl) {
								if (event.keyCode === control.hotkey.key) {
									self.triggerControl.apply(self, [controlName, control]);

									return false;
								}
							}
						}
					}
					return true;
				});
			} else if (self.options.brIE) {
				$(self.editorDoc).keydown(function (event) {
					if (event.keyCode === 13) {
						var rng = self.getRange();
						rng.pasteHTML("<br/>");
						rng.collapse(false);
						rng.select();

						return false;
					}

					return true;
				});
			}

			if (self.options.plugins.rmFormat.rmMsWordMarkup) {
				$(self.editorDoc).bind("keyup.wysiwyg", function (event) {
					if (event.ctrlKey || event.metaKey) {
						// CTRL + V (paste)
						if (86 === event.keyCode) {
							if ($.wysiwyg.rmFormat) {
								if ("object" === typeof (self.options.plugins.rmFormat.rmMsWordMarkup)) {
									$.wysiwyg.rmFormat.run(self, {rules: { msWordMarkup: self.options.plugins.rmFormat.rmMsWordMarkup }});
								} else {
									$.wysiwyg.rmFormat.run(self, {rules: { msWordMarkup: { enabled: true }}});
								}
							}
						}
					}
				});
			}

			if (self.options.autoSave) {
				$(self.editorDoc).keydown(function () { self.autoSaveFunction(); })
					.keyup(function () { self.autoSaveFunction(); })
					.mousedown(function () { self.autoSaveFunction(); })
					.bind($.support.noCloneEvent ? "input.wysiwyg" : "paste.wysiwyg", function () { self.autoSaveFunction(); });
			}

			if (self.options.autoGrow) {
				if (self.options.initialMinHeight !== null) {
					self.ui.initialHeight = self.options.initialMinHeight;
				} else {
					self.ui.initialHeight = $(self.editorDoc).height();
				}
				$(self.editorDoc.body).css("border", "1px solid white"); // cancel margin collapsing

				growHandler = function () {
					self.ui.grow();
				};

				$(self.editorDoc).keyup(growHandler);
				$(self.editorDoc).bind("editorRefresh.wysiwyg", growHandler);

				// fix when content height > textarea height
				self.ui.grow();
			}

			if (self.options.css) {
				if (String === self.options.css.constructor) {
					if ($.browser.msie) {
						stylesheet = self.editorDoc.createStyleSheet(self.options.css);
						$(stylesheet).attr({
							"media":	"all"
						});
					} else {
						stylesheet = $("<link/>").attr({
							"href":		self.options.css,
							"media":	"all",
							"rel":		"stylesheet",
							"type":		"text/css"
						});

						$(self.editorDoc).find("head").append(stylesheet);
					}
				} else {
					self.timers.initFrame_Css = window.setTimeout(function () {
						$(self.editorDoc.body).css(self.options.css);
					}, 0);
				}
			}

			if (self.initialContent.length === 0) {
				if ("function" === typeof (self.options.initialContent)) {
					self.setContent(self.options.initialContent());
				} else {
					self.setContent(self.options.initialContent);
				}
			}

			if (self.options.maxLength > 0) {
				$(self.editorDoc).keydown(function (event) {
					if ($(self.editorDoc).text().length >= self.options.maxLength && $.inArray(event.which, self.validKeyCodes) === -1) {
						event.preventDefault();
					}
				});
			}

			// Support event callbacks
			$.each(self.options.events, function (key, handler) {
				$(self.editorDoc).bind(key + ".wysiwyg", function (event) {
					// Trigger event handler, providing the event and api to
					// support additional functionality.
					handler.apply(self.editorDoc, [event, self]);
				});
			});

			// restores selection properly on focus
			if ($.browser.msie) {
				// Event chain: beforedeactivate => focusout => blur.
				// Focusout & blur fired too late to handle internalRange() in dialogs.
				// When clicked on input boxes both got range = null
				$(self.editorDoc).bind("beforedeactivate.wysiwyg", function () {
					self.savedRange = self.getInternalRange();
				});
			} else {
				$(self.editorDoc).bind("blur.wysiwyg", function () {
					self.savedRange = self.getInternalRange();
				});
			}

			$(self.editorDoc.body).addClass("wysiwyg");
			if (self.options.events && self.options.events.save) {
				saveHandler = self.options.events.save;

				$(self.editorDoc).bind("keyup.wysiwyg", saveHandler);
				$(self.editorDoc).bind("change.wysiwyg", saveHandler);

				if ($.support.noCloneEvent) {
					$(self.editorDoc).bind("input.wysiwyg", saveHandler);
				} else {
					$(self.editorDoc).bind("paste.wysiwyg", saveHandler);
					$(self.editorDoc).bind("cut.wysiwyg", saveHandler);
				}
			}

			/**
			 * XHTML5 {@link https://github.com/akzhan/jwysiwyg/issues/152}
			 */
			if (self.options.xhtml5 && self.options.unicode) {
				var replacements = {ne:8800,le:8804,para:182,xi:958,darr:8595,nu:957,oacute:243,Uacute:218,omega:969,prime:8242,pound:163,igrave:236,thorn:254,forall:8704,emsp:8195,lowast:8727,brvbar:166,alefsym:8501,nbsp:160,delta:948,clubs:9827,lArr:8656,Omega:937,Auml:196,cedil:184,and:8743,plusmn:177,ge:8805,raquo:187,uml:168,equiv:8801,laquo:171,rdquo:8221,Epsilon:917,divide:247,fnof:402,chi:967,Dagger:8225,iacute:237,rceil:8969,sigma:963,Oslash:216,acute:180,frac34:190,lrm:8206,upsih:978,Scaron:352,part:8706,exist:8707,nabla:8711,image:8465,prop:8733,zwj:8205,omicron:959,aacute:225,Yuml:376,Yacute:221,weierp:8472,rsquo:8217,otimes:8855,kappa:954,thetasym:977,harr:8596,Ouml:214,Iota:921,ograve:242,sdot:8901,copy:169,oplus:8853,acirc:226,sup:8835,zeta:950,Iacute:205,Oacute:211,crarr:8629,Nu:925,bdquo:8222,lsquo:8216,apos:39,Beta:914,eacute:233,egrave:232,lceil:8968,Kappa:922,piv:982,Ccedil:199,ldquo:8220,Xi:926,cent:162,uarr:8593,hellip:8230,Aacute:193,ensp:8194,sect:167,Ugrave:217,aelig:230,ordf:170,curren:164,sbquo:8218,macr:175,Phi:934,Eta:919,rho:961,Omicron:927,sup2:178,euro:8364,aring:229,Theta:920,mdash:8212,uuml:252,otilde:245,eta:951,uacute:250,rArr:8658,nsub:8836,agrave:224,notin:8713,ndash:8211,Psi:936,Ocirc:212,sube:8838,szlig:223,micro:181,not:172,sup1:185,middot:183,iota:953,ecirc:234,lsaquo:8249,thinsp:8201,sum:8721,ntilde:241,scaron:353,cap:8745,atilde:227,lang:10216,__replacement:65533,isin:8712,gamma:947,Euml:203,ang:8736,upsilon:965,Ntilde:209,hearts:9829,Alpha:913,Tau:932,spades:9824,dagger:8224,THORN:222,"int":8747,lambda:955,Eacute:201,Uuml:220,infin:8734,rlm:8207,Aring:197,ugrave:249,Egrave:200,Acirc:194,rsaquo:8250,ETH:208,oslash:248,alpha:945,Ograve:210,Prime:8243,mu:956,ni:8715,real:8476,bull:8226,beta:946,icirc:238,eth:240,prod:8719,larr:8592,ordm:186,perp:8869,Gamma:915,reg:174,ucirc:251,Pi:928,psi:968,tilde:732,asymp:8776,zwnj:8204,Agrave:192,deg:176,AElig:198,times:215,Delta:916,sim:8764,Otilde:213,Mu:924,uArr:8657,circ:710,theta:952,Rho:929,sup3:179,diams:9830,tau:964,Chi:935,frac14:188,oelig:339,shy:173,or:8744,dArr:8659,phi:966,iuml:239,Lambda:923,rfloor:8971,iexcl:161,cong:8773,ccedil:231,Icirc:206,frac12:189,loz:9674,rarr:8594,cup:8746,radic:8730,frasl:8260,euml:235,OElig:338,hArr:8660,Atilde:195,Upsilon:933,there4:8756,ouml:246,oline:8254,Ecirc:202,yacute:253,auml:228,permil:8240,sigmaf:962,iquest:191,empty:8709,pi:960,Ucirc:219,supe:8839,Igrave:204,yen:165,rang:10217,trade:8482,lfloor:8970,minus:8722,Zeta:918,sub:8834,epsilon:949,yuml:255,Sigma:931,Iuml:207,ocirc:244};
				self.events.bind("getContent", function (text) {
					return text.replace(/&(?:amp;)?(?!amp|lt|gt|quot)([a-z][a-z0-9]*);/gi, function (str, p1) {
						if (!replacements[p1]) {
							p1 = p1.toLowerCase();
							if (!replacements[p1]) {
								p1 = "__replacement";
							}
						}

						var num = replacements[p1];
						/* Numeric return if ever wanted: return replacements[p1] ? "&#"+num+";" : ""; */
						return String.fromCharCode(num);
					});
				});
			}
			$(self.original).trigger('ready.jwysiwyg', [self.editorDoc, self]);
		};

		this.innerDocument = function () {
			var element = this.editor.get(0);

			if (element.nodeName.toLowerCase() === "iframe") {
				if (element.contentDocument) {				// Gecko
					return element.contentDocument;
				} else if (element.contentWindow) {			// IE
					return element.contentWindow.document;
				}

				if (this.isDestroyed) {
					return null;
				}

				console.error("Unexpected error in innerDocument");

				/*
				 return ( $.browser.msie )
				 ? document.frames[element.id].document
				 : element.contentWindow.document // contentDocument;
				 */
			}

			return element;
		};

		this.insertHtml = function (szHTML) {
			var img, range;

			if (!szHTML || szHTML.length === 0) {
				return this;
			}

			if ($.browser.msie) {
				this.ui.focus();
				this.editorDoc.execCommand("insertImage", false, "#jwysiwyg#");
				img = this.getElementByAttributeValue("img", "src", "#jwysiwyg#");
				if (img) {
					$(img).replaceWith(szHTML);
				}
			} else {
				if ($.browser.mozilla) { // @link https://github.com/akzhan/jwysiwyg/issues/50
					if (1 === $(szHTML).length) {
						range = this.getInternalRange();
						range.deleteContents();
						range.insertNode($(szHTML).get(0));
					} else {
						this.editorDoc.execCommand("insertHTML", false, szHTML);
					}
				} else {
					if (!this.editorDoc.execCommand("insertHTML", false, szHTML)) {
						this.editor.focus();
						/* :TODO: place caret at the end
						if (window.getSelection) {
						} else {
						}
						this.editor.focus();
						*/
						this.editorDoc.execCommand("insertHTML", false, szHTML);
					}
				}
			}

			this.saveContent();

			return this;
		};

		//check allowed properties
		this.parseControls = function () {
			var self = this;

			$.each(this.options.controls, function (controlName, control) {
				$.each(control, function (propertyName) {
					if (-1 === $.inArray(propertyName, self.availableControlProperties)) {
						throw controlName + '["' + propertyName + '"]: property "' + propertyName + '" not exists in Wysiwyg.availableControlProperties';
					}
				});
			});

			if (this.options.parseControls) { //user callback
				return this.options.parseControls.call(this);
			}

			return this.options.controls;
		};

		this.removeFormat = function () {
			if ($.browser.msie) {
				this.ui.focus();
			}

			if (this.options.removeHeadings) {
				this.editorDoc.execCommand("formatBlock", false, "<p>"); // remove headings
			}

			this.editorDoc.execCommand("removeFormat", false, null);
			this.editorDoc.execCommand("unlink", false, null);

			if ($.wysiwyg.rmFormat && $.wysiwyg.rmFormat.enabled) {
				if ("object" === typeof (this.options.plugins.rmFormat.rmMsWordMarkup)) {
					$.wysiwyg.rmFormat.run(this, {rules: { msWordMarkup: this.options.plugins.rmFormat.rmMsWordMarkup }});
				} else {
					$.wysiwyg.rmFormat.run(this, {rules: { msWordMarkup: { enabled: true }}});
				}
			}

			return this;
		};

		this.ui.removeHoverClass = function () {
			$(this).removeClass("wysiwyg-button-hover");
		};

		this.resetFunction = function () {
			this.setContent(this.initialContent);
		};

		this.saveContent = function () {
			if (this.viewHTML)
			{
				return; // no need
			}
			if (this.original) {
				var content, newContent;

				content = this.getContent();

				if (this.options.rmUnwantedBr) {
					content = content.replace(/<br\/?>$/, "");
				}

				if (this.options.replaceDivWithP) {
					newContent = $("<div/>").addClass("temp").append(content);

					newContent.children("div").each(function () {
						var element = $(this), p = element.find("p"), i;

						if (0 === p.length) {
							p = $("<p></p>");

							if (this.attributes.length > 0) {
								for (i = 0; i < this.attributes.length; i += 1) {
									p.attr(this.attributes[i].name, element.attr(this.attributes[i].name));
								}
							}

							p.append(element.html());

							element.replaceWith(p);
						}
					});

					content = newContent.html();
				}

				$(this.original).val(content).change();

				if (this.options.events && this.options.events.save) {
					this.options.events.save.call(this);
				}
			}

			return this;
		};

		this.setContent = function (newContent) {
			this.editorDoc.body.innerHTML = newContent;
			this.saveContent();

			return this;
		};

		this.triggerControl = function (name, control) {
			var cmd = control.command || name,							//command directly for designMode=on iframe (this.editorDoc)
				args = control["arguments"] || [];

			if (control.exec) {
				control.exec.apply(this);  //custom exec function in control, allows DOM changing
			} else {
				this.ui.focus();
				this.ui.withoutCss(); //disable style="" attr inserting in mozzila's designMode
				// when click <Cut>, <Copy> or <Paste> got "Access to XPConnect service denied" code: "1011"
				// in Firefox untrusted JavaScript is not allowed to access the clipboard
				try {
					this.editorDoc.execCommand(cmd, false, args);
				} catch (e) {
					console.error(e);
				}
			}

			if (this.options.autoSave) {
				this.autoSaveFunction();
			}
		};

		this.triggerControlCallback = function (name) {
			$(window).trigger("trigger-" + name + ".wysiwyg", [this]);
		};

		this.ui.withoutCss = function () {
			var self = this.self;

			if ($.browser.mozilla) {
				try {
					self.editorDoc.execCommand("styleWithCSS", false, false);
				} catch (e) {
					try {
						self.editorDoc.execCommand("useCSS", false, true);
					} catch (e2) {
					}
				}
			}

			return self;
		};

		this.wrapInitialContent = function () {
			var content = this.initialContent,
				found = content.match(/<\/?p>/gi);

			if (!found) {
				return "<p>" + content + "</p>";
			} else {
				// :TODO: checking/replacing
			}

			return content;
		};
	}

	/*
	 * Wysiwyg namespace: public properties and methods
	 */
	$.wysiwyg = {
		messages: {
			noObject: "Something goes wrong, check object"
		},

		/**
		 * Custom control support by Alec Gorge ( http://github.com/alecgorge )
		 */
		addControl: function (object, name, settings) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg"),
					customControl = {},
					toolbar;

				if (!oWysiwyg) {
					return this;
				}

				customControl[name] = $.extend(true, {visible: true, custom: true}, settings);
				$.extend(true, oWysiwyg.options.controls, customControl);

				// render new toolbar
				toolbar = $(oWysiwyg.options.toolbarHtml);
				oWysiwyg.ui.toolbar.replaceWith(toolbar);
				oWysiwyg.ui.toolbar = toolbar;
				oWysiwyg.ui.appendControls();
			});
		},

		clear: function (object) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.setContent("");
			});
		},

		console: console, // let our console be available for extensions

		destroy: function (object) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.destroy();
			});
		},

		"document": function (object) {
			// no chains because of return
			var oWysiwyg = object.data("wysiwyg");

			if (!oWysiwyg) {
				return undefined;
			}

			return $(oWysiwyg.editorDoc);
		},

		getContent: function (object) {
			// no chains because of return
			var oWysiwyg = object.data("wysiwyg");

			if (!oWysiwyg) {
				return undefined;
			}

			return oWysiwyg.getContent();
		},

    		getSelection: function (object) {
  			// no chains because of return
			var oWysiwyg = object.data("wysiwyg");

			if (!oWysiwyg) {
				return undefined;
			}

			return oWysiwyg.getRangeText();
		},

		init: function (object, options) {
			return object.each(function () {
				var opts = $.extend(true, {}, options),
					obj;

				// :4fun:
				// remove this textarea validation and change line in this.saveContent function
				// $(this.original).val(content); to $(this.original).html(content);
				// now you can make WYSIWYG editor on h1, p, and many more tags
				if (("textarea" !== this.nodeName.toLowerCase()) || $(this).data("wysiwyg")) {
					return;
				}

				obj = new Wysiwyg();
				obj.init(this, opts);
				$.data(this, "wysiwyg", obj);

				$(obj.editorDoc).trigger("afterInit.wysiwyg");
			});
		},

		insertHtml: function (object, szHTML) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.insertHtml(szHTML);
			});
		},

		plugin: {
			listeners: {},

			bind: function (Wysiwyg) {
				var self = this;

				$.each(this.listeners, function (action, handlers) {
					var i, plugin;

					for (i = 0; i < handlers.length; i += 1) {
						plugin = self.parseName(handlers[i]);

						$(Wysiwyg.editorDoc).bind(action + ".wysiwyg", {plugin: plugin}, function (event) {
							$.wysiwyg[event.data.plugin.name][event.data.plugin.method].apply($.wysiwyg[event.data.plugin.name], [Wysiwyg]);
						});
					}
				});
			},

			exists: function (name) {
				var plugin;

				if ("string" !== typeof (name)) {
					return false;
				}

				plugin = this.parseName(name);

				if (!$.wysiwyg[plugin.name] || !$.wysiwyg[plugin.name][plugin.method]) {
					return false;
				}

				return true;
			},

			listen: function (action, handler) {
				var plugin;

				plugin = this.parseName(handler);

				if (!$.wysiwyg[plugin.name] || !$.wysiwyg[plugin.name][plugin.method]) {
					return false;
				}

				if (!this.listeners[action]) {
					this.listeners[action] = [];
				}

				this.listeners[action].push(handler);

				return true;
			},

			parseName: function (name) {
				var elements;

				if ("string" !== typeof (name)) {
					return false;
				}

				elements = name.split(".");

				if (2 > elements.length) {
					return false;
				}

				return {name: elements[0], method: elements[1]};
			},

			register: function (data) {
				if (!data.name) {
					console.error("Plugin name missing");
				}

				$.each($.wysiwyg, function (pluginName) {
					if (pluginName === data.name) {
						console.error("Plugin with name '" + data.name + "' was already registered");
					}
				});

				$.wysiwyg[data.name] = data;

				return true;
			}
		},

		removeFormat: function (object) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.removeFormat();
			});
		},

		save: function (object) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.saveContent();
			});
		},

		selectAll: function (object) {
			var oWysiwyg = object.data("wysiwyg"), oBody, oRange, selection;

			if (!oWysiwyg) {
				return this;
			}

			oBody = oWysiwyg.editorDoc.body;
			if (window.getSelection) {
				selection = oWysiwyg.getInternalSelection();
				selection.selectAllChildren(oBody);
			} else {
				oRange = oBody.createTextRange();
				oRange.moveToElementText(oBody);
				oRange.select();
			}
		},

		setContent: function (object, newContent) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				oWysiwyg.setContent(newContent);
			});
		},

		triggerControl: function (object, controlName) {
			return object.each(function () {
				var oWysiwyg = $(this).data("wysiwyg");

				if (!oWysiwyg) {
					return this;
				}

				if (!oWysiwyg.controls[controlName]) {
					console.error("Control '" + controlName + "' not exists");
				}

				oWysiwyg.triggerControl.apply(oWysiwyg, [controlName, oWysiwyg.controls[controlName]]);
			});
		},

		support: {
			prop: supportsProp
		},

		utils: {
			extraSafeEntities: [["<", ">", "'", '"', " "], [32]],

			encodeEntities: function (str) {
				var self = this, aStr, aRet = [];

				if (this.extraSafeEntities[1].length === 0) {
					$.each(this.extraSafeEntities[0], function (i, ch) {
						self.extraSafeEntities[1].push(ch.charCodeAt(0));
					});
				}
				aStr = str.split("");
				$.each(aStr, function (i) {
					var iC = aStr[i].charCodeAt(0);
					if ($.inArray(iC, self.extraSafeEntities[1]) && (iC < 65 || iC > 127 || (iC > 90 && iC < 97))) {
						aRet.push('&#' + iC + ';');
					} else {
						aRet.push(aStr[i]);
					}
				});

				return aRet.join('');
			}
		}
	};

	/**
	 * Unifies dialog methods to allow custom implementations
	 *
	 * Events:
	 *     * afterOpen
	 *     * beforeShow
	 *     * afterShow
	 *     * beforeHide
	 *     * afterHide
	 *     * beforeClose
	 *     * afterClose
	 *
	 * Example:
	 * var dialog = new ($.wysiwyg.dialog)($('#idToTextArea').data('wysiwyg'), {"title": "Test", "content": "form data, etc."});
	 *
	 * dialog.bind("afterOpen", function () { alert('you should see a dialog behind this one!'); });
	 *
	 * dialog.open();
	 *
	 *
	 */
	$.wysiwyg.dialog = function (jWysiwyg, opts) {

		var theme	= (jWysiwyg && jWysiwyg.options && jWysiwyg.options.dialog) ? jWysiwyg.options.dialog : (opts.theme ? opts.theme : "default"),
			obj		= new $.wysiwyg.dialog.createDialog(theme),
			that	= this,
			$that	= $(that);

		this.options = {
			"modal": true,
			"draggable": true,
			"title": "Title",
			"content": "Content",
			"width":  "auto",
			"height": "auto",
			"zIndex": 2000,
			"open": false,
			"close": false
		};

		this.isOpen = false;

		$.extend(this.options, opts);

		this.object = obj;

		// Opens a dialog with the specified content
		this.open = function () {
			this.isOpen = true;

			obj.init.apply(that, []);
			var $dialog = obj.show.apply(that, []);

			$that.trigger("afterOpen", [$dialog]);

		};

		this.show = function () {
			this.isOpen = true;

			$that.trigger("beforeShow");

			var $dialog = obj.show.apply(that, []);

			$that.trigger("afterShow");
		};

		this.hide = function () {
			this.isOpen = false;

			$that.trigger("beforeHide");

			var $dialog = obj.hide.apply(that, []);

			$that.trigger("afterHide", [$dialog]);
		};

		// Closes the dialog window.
		this.close = function () {
			this.isOpen = false;

			var $dialog = obj.hide.apply(that, []);

			$that.trigger("beforeClose", [$dialog]);

			obj.destroy.apply(that, []);

			$that.trigger("afterClose", [$dialog]);

			jWysiwyg.ui.focus();
		};

		if (this.options.open) {
			$that.bind("afterOpen", this.options.open);
		}
		if (this.options.close) {
			$that.bind("afterClose", this.options.close);
		}

		return this;
	};

	// "Static" Dialog methods.
	$.extend(true, $.wysiwyg.dialog, {
		_themes : {}, // sample {"Theme Name": object}
		_theme : "", // the current theme

		register : function(name, obj) {
			$.wysiwyg.dialog._themes[name] = obj;
		},

		deregister : function (name) {
			delete $.wysiwyg.dialog._themes[name];
		},

		createDialog : function (name) {
			return new ($.wysiwyg.dialog._themes[name]);
		},

		getDimensions : function () {
			var width  = document.body.scrollWidth,
				height = document.body.scrollHeight;

			if ($.browser.opera) {
				height = Math.max(
					$(document).height(),
					$(window).height(),
					document.documentElement.clientHeight);
			}

			return [width, height];
		}
	});

	$(function () { // need access to jQuery UI stuff.
		if (jQuery.ui) {
			$.wysiwyg.dialog.register("jqueryui", function () {
				var that = this;

				this._$dialog = null;

				this.init = function() {
					var abstractDialog	= this,
						content 		= this.options.content;

					if (typeof content === 'object') {
						if (typeof content.html === 'function') {
							content = content.html();
						} else if(typeof content.toString === 'function') {
							content = content.toString();
						}
					}

					that._$dialog = $('<div></div>').attr('title', this.options.title).html(content);

					var dialogHeight = this.options.height == 'auto' ? 300 : this.options.height,
						dialogWidth = this.options.width == 'auto' ? 450 : this.options.width;

					// console.log(that._$dialog);

					that._$dialog.dialog({
						modal: this.options.modal,
						draggable: this.options.draggable,
						height: dialogHeight,
						width: dialogWidth
					});

					return that._$dialog;
				};

				this.show = function () {
					that._$dialog.dialog("open");
					return that._$dialog;
				};

				this.hide = function () {
					that._$dialog.dialog("close");
					return that._$dialog;
				};

				this.destroy = function() {
					that._$dialog.dialog("destroy");
					return that._$dialog;
				};
			});
		}

		$.wysiwyg.dialog.register("default", function () {
			var that = this;

			this._$dialog = null;

			this.init = function() {
				var abstractDialog	= this,
					content 		= this.options.content;

				if (typeof content === 'object') {
					if(typeof content.html === 'function') {
						content = content.html();
					}
					else if(typeof content.toString === 'function') {
						content = content.toString();
					}
				}

				that._$dialog = $('<div class="wysiwyg-dialog"></div>').css({"z-index": this.options.zIndex});

				var $topbar = $('<div class="wysiwyg-dialog-topbar"><div class="wysiwyg-dialog-close-wrapper"></div><div class="wysiwyg-dialog-title">'+this.options.title+'</div></div>');
				var $link = $('<a href="#" class="wysiwyg-dialog-close-button">X</a>');

				$link.click(function () {
					abstractDialog.close(); // this is important it makes sure that is close from the abstract $.wysiwyg.dialog instace, not just locally
				});

				$topbar.find('.wysiwyg-dialog-close-wrapper').prepend($link);

				var $dcontent = $('<div class="wysiwyg-dialog-content">'+content+'</div>');

				that._$dialog.append($topbar).append($dcontent);

				// Set dialog's height & width, and position it correctly:
				var dialogHeight = this.options.height == 'auto' ? 300 : this.options.height,
					dialogWidth = this.options.width == 'auto' ? 450 : this.options.width;
				that._$dialog.hide().css({
					"width": dialogWidth,
					"height": dialogHeight,
					"left": (($(window).width() - dialogWidth) / 2),
					"top": (($(window).height() - dialogHeight) / 3)
				});

				$("body").append(that._$dialog);

				return that._$dialog;
			};

			this.show = function () {

				// Modal feature:
				if (this.options.modal) {
					var dimensions = $.wysiwyg.dialog.getDimensions(),
						wrapper    = $('<div class="wysiwyg-dialog-modal-div"></div>')
						.css({"width": dimensions[0], "height": dimensions[1]});
					that._$dialog.wrap(wrapper);
				}

				// Draggable feature:
				if (this.options.draggable) {

					var mouseDown = false;

					that._$dialog.find("div.wysiwyg-dialog-topbar").bind("mousedown", function (e) {
						e.preventDefault();
						$(this).css({ "cursor": "move" });
						var $topbar = $(this),
							_dialog = $(this).parents(".wysiwyg-dialog"),
							offsetX = (e.pageX - parseInt(_dialog.css("left"), 10)),
							offsetY = (e.pageY - parseInt(_dialog.css("top"), 10));
						mouseDown = true;
						$(this).css({ "cursor": "move" });

						$(document).bind("mousemove", function (e) {
							e.preventDefault();
							if (mouseDown) {
								_dialog.css({
									"top": (e.pageY - offsetY),
									"left": (e.pageX - offsetX)
								});
							}
						}).bind("mouseup", function (e) {
							e.preventDefault();
							mouseDown = false;
							$topbar.css({ "cursor": "auto" });
							$(document).unbind("mousemove").unbind("mouseup");
						});

					});
				}

				that._$dialog.show();
				return that._$dialog;

			};

			this.hide = function () {
				that._$dialog.hide();
				return that._$dialog;
			};

			this.destroy = function() {

				// Modal feature:
				if (this.options.modal) {
					that._$dialog.unwrap();
				}

				// Draggable feature:
				if (this.options.draggable) {
					that._$dialog.find("div.wysiwyg-dialog-topbar").unbind("mousedown");
				}

				that._$dialog.remove();
				return that._$dialog;
			};
		});
	});
	// end Dialog

	$.fn.wysiwyg = function (method) {
		var args = arguments, plugin;

		if ("undefined" !== typeof $.wysiwyg[method]) {
			// set argument object to undefined
			args = Array.prototype.concat.call([args[0]], [this], Array.prototype.slice.call(args, 1));
			return $.wysiwyg[method].apply($.wysiwyg, Array.prototype.slice.call(args, 1));
		} else if ("object" === typeof method || !method) {
			Array.prototype.unshift.call(args, this);
			return $.wysiwyg.init.apply($.wysiwyg, args);
		} else if ($.wysiwyg.plugin.exists(method)) {
			plugin = $.wysiwyg.plugin.parseName(method);
			args = Array.prototype.concat.call([args[0]], [this], Array.prototype.slice.call(args, 1));
			return $.wysiwyg[plugin.name][plugin.method].apply($.wysiwyg[plugin.name], Array.prototype.slice.call(args, 1));
		} else {
			console.error("Method '" +  method + "' does not exist on jQuery.wysiwyg.\nTry to include some extra controls or plugins");
		}
	};

	$.fn.getWysiwyg = function () {
		return this.data("wysiwyg");
	};
})(jQuery);


/**
 * jWYSIWYG link plugin
 */
(function ($) {
	"use strict";

	if (undefined === $.wysiwyg) {
		throw "wysiwyg.link.js depends on $.wysiwyg";
	}

	if (!$.wysiwyg.controls) {
		$.wysiwyg.controls = {};
	}

	/*
	* Wysiwyg namespace: public properties and methods
	*/
	$.wysiwyg.controls.link = {
		init: function (Wysiwyg) {
			var self = this, elements, dialog, url, a, selection,
				formLinkHtml, dialogReplacements, key, translation, regexp,
				baseUrl, img;

			dialogReplacements = {
				legend: "Insert Link",
				url   : "Link URL",
				title : "Link Title",
				target: "Link Target",
				submit: "Insert Link",
				reset: "Cancel"
			};

			formLinkHtml = '<form class="wysiwyg"><fieldset><legend>{legend}</legend>' +
				'<label>{url}: <input type="text" name="linkhref" value=""/></label>' +
				'<label>{title}: <input type="text" name="linktitle" value=""/></label>' +
				'<label>{target}: <input type="text" name="linktarget" value=""/></label>' +
				'<input type="submit" class="button" value="{submit}"/> ' +
				'<input type="reset" value="{reset}"/></fieldset></form>';

			for (key in dialogReplacements) {
				if ($.wysiwyg.i18n) {
					translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs.link");

					if (translation === dialogReplacements[key]) { // if not translated search in dialogs
						translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs");
					}

					dialogReplacements[key] = translation;
				}

				regexp = new RegExp("{" + key + "}", "g");
				formLinkHtml = formLinkHtml.replace(regexp, dialogReplacements[key]);
			}

			a = {
				self: Wysiwyg.dom.getElement("a"), // link to element node
				href: "http://",
				title: "",
				target: ""
			};

			if (a.self) {
				a.href = a.self.href ? a.self.href : a.href;
				a.title = a.self.title ? a.self.title : "";
				a.target = a.self.target ? a.self.target : "";
			}

			if ($.fn.dialog) {
				elements = $(formLinkHtml);
				elements.find("input[name=linkhref]").val(a.href);
				elements.find("input[name=linktitle]").val(a.title);
				elements.find("input[name=linktarget]").val(a.target);

				if ($.browser.msie) {
					try {
						dialog = elements.appendTo(Wysiwyg.editorDoc.body);
					} catch (err) {
						dialog = elements.appendTo("body");
					}
				} else {
					dialog = elements.appendTo("body");
				}

				dialog.dialog({
					modal: true,
					open: function (ev, ui) {
						$("input:submit", dialog).click(function (e) {
							e.preventDefault();

							var url = $('input[name="linkhref"]', dialog).val(),
								title = $('input[name="linktitle"]', dialog).val(),
								target = $('input[name="linktarget"]', dialog).val(),
								baseUrl,
								img;

							if (Wysiwyg.options.controlLink.forceRelativeUrls) {
								baseUrl = window.location.protocol + "//" + window.location.hostname;
								if (0 === url.indexOf(baseUrl)) {
									url = url.substr(baseUrl.length);
								}
							}

							if (a.self) {
								if ("string" === typeof (url)) {
									if (url.length > 0) {
										// to preserve all link attributes
										$(a.self).attr("href", url).attr("title", title).attr("target", target);
									} else {
										$(a.self).replaceWith(a.self.innerHTML);
									}
								}
							} else {
								if ($.browser.msie) {
									Wysiwyg.ui.returnRange();
								}

								//Do new link element
								selection = Wysiwyg.getRangeText();
								img = Wysiwyg.dom.getElement("img");

								if ((selection && selection.length > 0) || img) {
									if ($.browser.msie) {
										Wysiwyg.ui.focus();
									}

									if ("string" === typeof (url)) {
										if (url.length > 0) {
											Wysiwyg.editorDoc.execCommand("createLink", false, url);
										} else {
											Wysiwyg.editorDoc.execCommand("unlink", false, null);
										}
									}

									a.self = Wysiwyg.dom.getElement("a");

									$(a.self).attr("href", url).attr("title", title);

									/**
									 * @url https://github.com/akzhan/jwysiwyg/issues/16
									 */
									$(a.self).attr("target", target);
								} else if (Wysiwyg.options.messages.nonSelection) {
									window.alert(Wysiwyg.options.messages.nonSelection);
								}
							}

							Wysiwyg.saveContent();

							$(dialog).dialog("close");
						});
						$("input:reset", dialog).click(function (e) {
							e.preventDefault();
							$(dialog).dialog("close");
						});
					},
					close: function (ev, ui) {
						dialog.dialog("destroy");
						dialog.remove();
					}
				});
			} else {
				if (a.self) {
					url = window.prompt("URL", a.href);

					if (Wysiwyg.options.controlLink.forceRelativeUrls) {
						baseUrl = window.location.protocol + "//" + window.location.hostname;
						if (0 === url.indexOf(baseUrl)) {
							url = url.substr(baseUrl.length);
						}
					}

					if ("string" === typeof (url)) {
						if (url.length > 0) {
							$(a.self).attr("href", url);
						} else {
							$(a.self).replaceWith(a.self.innerHTML);
						}
					}
				} else {
					//Do new link element
					selection = Wysiwyg.getRangeText();
					img = Wysiwyg.dom.getElement("img");

					if ((selection && selection.length > 0) || img) {
						if ($.browser.msie) {
							Wysiwyg.ui.focus();
							Wysiwyg.editorDoc.execCommand("createLink", true, null);
						} else {
							url = window.prompt(dialogReplacements.url, a.href);

							if (Wysiwyg.options.controlLink.forceRelativeUrls) {
								baseUrl = window.location.protocol + "//" + window.location.hostname;
								if (0 === url.indexOf(baseUrl)) {
									url = url.substr(baseUrl.length);
								}
							}

							if ("string" === typeof (url)) {
								if (url.length > 0) {
									Wysiwyg.editorDoc.execCommand("createLink", false, url);
								} else {
									Wysiwyg.editorDoc.execCommand("unlink", false, null);
								}
							}
						}
					} else if (Wysiwyg.options.messages.nonSelection) {
						window.alert(Wysiwyg.options.messages.nonSelection);
					}
				}

				Wysiwyg.saveContent();
			}

			$(Wysiwyg.editorDoc).trigger("editorRefresh.wysiwyg");
		}
	};

	$.wysiwyg.createLink = function (object, url) {
		return object.each(function () {
			var oWysiwyg = $(this).data("wysiwyg"),
				selection;

			if (!oWysiwyg) {
				return this;
			}

			if (!url || url.length === 0) {
				return this;
			}

			selection = oWysiwyg.getRangeText();

			if (selection && selection.length > 0) {
				if ($.browser.msie) {
					oWysiwyg.ui.focus();
				}
				oWysiwyg.editorDoc.execCommand("unlink", false, null);
				oWysiwyg.editorDoc.execCommand("createLink", false, url);
			} else if (oWysiwyg.options.messages.nonSelection) {
				window.alert(oWysiwyg.options.messages.nonSelection);
			}
			return this;
		});
	};
})(jQuery);



/**
 * rmFormat plugin
 *
 * Depends on jWYSIWYG
 */
(function ($) {
	if (undefined === $.wysiwyg) {
		throw "wysiwyg.rmFormat.js depends on $.wysiwyg";
	}

	/*
	 * Wysiwyg namespace: public properties and methods
	 */
	var rmFormat = {
		name: "rmFormat",
		version: "",
		defaults: {
			rules: {
				heading: true,
				table: true,
				inlineCSS: true,
				/*
				 * rmAttr       - { "all" | object with names } remove all
				 *                attributes or attributes with following names
				 *
				 * rmWhenEmpty  - if element contains no text or { \s, \n, <br>, <br/> }
				 *                then it will be removed
				 *
				 * rmWhenNoAttr - if element contains no attributes (i.e. <span>Some Text</span>)
				 *                then it will be removed
				 */
				msWordMarkup: {
					enabled: false,
					tags: {
						"a": {
                            rmAttr: "all"
						},

						"b": {
                            rmAttr: "all"
						},

						"div": {
                            rmAttr: "all"
						},

                        "ul": {
                            rmAttr: "all"
                        },

                        "li": {
                            rmAttr: "all"
                        },

						"em": {
                            rmAttr: "all"
						},

						"font": {
                            rmAttr: "all"
						},

						"h1": {
                            rmAttr: "all"
						},
						"h2": {
                            rmAttr: "all"
						},
						"h3": {
                            rmAttr: "all"
						},
						"h4": {
                            rmAttr: "all"
						},
						"h5": {
                            rmAttr: "all"
						},
						"h6": {
                            rmAttr: "all"
						},

						"i": {
                            rmAttr: "all"
						},

						"p": {
                            rmAttr: "all"
						},

                        "pre": {
                            rmAttr: "all"
                        },

                        "form": {
                            rmAttr: "all"
                        },

						"span": {
                            rmAttr: "all"
						},

						"strong": {
                            rmAttr: "all"
						},

						"u": {
                            rmAttr: "all"
						}
					}
				}
			}
		},
		options: {},
		enabled: true,
		debug:	false,

		domRemove: function (node) {
			// replace h1-h6 with p
			if (this.options.rules.heading) {
				if (node.nodeName.toLowerCase().match(/^h[1-6]$/)) {
					// in chromium change this to
					// $(node).replaceWith($('<p/>').html(node.innerHTML));
					// to except DOM error: also try in other browsers
					$(node).replaceWith($('<p/>').html($(node).contents()));

					return true;
				}
			}

			// remove tables not smart enough )
			if (this.options.rules.table) {
				if (node.nodeName.toLowerCase().match(/^(table|t[dhr]|t(body|foot|head))$/)) {
					$(node).replaceWith($(node).contents());

					return true;
				}
			}

			return false;
		},

		removeStyle: function(node) {
		  if (this.options.rules.inlineCSS) {
		    $(node).removeAttr('style');
		  }
		},

		domTraversing: function (el, start, end, canRemove, cnt) {
			if (null === canRemove) {
				canRemove = false;
			}

			var isDomRemoved, p;

			while (el) {
				if (this.debug) { console.log(cnt, "canRemove=", canRemove); }

				this.removeStyle(el);

				if (el.firstElementChild) {

					if (this.debug) { console.log(cnt, "domTraversing", el.firstElementChild); }

					return this.domTraversing(el.firstElementChild, start, end, canRemove, cnt + 1);
				} else {

					if (this.debug) { console.log(cnt, "routine", el); }

					isDomRemoved = false;

					if (start === el) {
						canRemove = true;
					}

					if (canRemove) {
						if (el.previousElementSibling) {
							p = el.previousElementSibling;
						} else {
							p = el.parentNode;
						}

						if (this.debug) { console.log(cnt, el.nodeName, el.previousElementSibling, el.parentNode, p); }

						isDomRemoved = this.domRemove(el);
						if (this.domRemove(el)) {

							if (this.debug) { console.log("p", p); }

							// step back to parent or previousElement to traverse again then element is removed
							el = p;
						}

						if (start !== end && end === el) {
							return true;
						}
					}

					if (false === isDomRemoved) {
						el = el.nextElementSibling;
					}
				}
			}

			return false;
		},

		msWordMarkup: function (text) {
			var tagName, attrName, rules, reg, regAttr, found, attrs;

			// @link https://github.com/akzhan/jwysiwyg/issues/165
			text = text.replace(/&lt;/g, "<").replace(/&gt;/g, ">");

			text = text.replace(/<meta\s[^>]+>/g, "");
			text = text.replace(/<link\s[^>]+>/g, "");
			text = text.replace(/<title>[\s\S]*?<\/title>/g, "");
			text = text.replace(/<style(?:\s[^>]*)?>[\s\S]*?<\/style>/gm, "");
			text = text.replace(/<w:([^\s>]+)(?:\s[^\/]+)?\/>/g, "");
			text = text.replace(/<w:([^\s>]+)(?:\s[^>]+)?>[\s\S]*?<\/w:\1>/gm, "");
			text = text.replace(/<m:([^\s>]+)(?:\s[^\/]+)?\/>/g, "");
			text = text.replace(/<m:([^\s>]+)(?:\s[^>]+)?>[\s\S]*?<\/m:\1>/gm, "");

			// after running the above.. it still needed these
			text = text.replace(/<xml>[\s\S]*?<\/xml>/g, "");
			text = text.replace(/<object(?:\s[^>]*)?>[\s\S]*?<\/object>/g, "");
			text = text.replace(/<o:([^\s>]+)(?:\s[^\/]+)?\/>/g, "");
			text = text.replace(/<o:([^\s>]+)(?:\s[^>]+)?>[\s\S]*?<\/o:\1>/gm, "");
			text = text.replace(/<st1:([^\s>]+)(?:\s[^\/]+)?\/>/g, "");
			text = text.replace(/<st1:([^\s>]+)(?:\s[^>]+)?>[\s\S]*?<\/st1:\1>/gm, "");
			// ----
			text = text.replace(/<!--[^>]+>\s*<[^>]+>/gm, ""); // firefox needed this 1


			text = text.replace(/^[\s\n]+/gm, "");

			if (this.options.rules.msWordMarkup.tags) {
				for (tagName in this.options.rules.msWordMarkup.tags) {
					rules = this.options.rules.msWordMarkup.tags[tagName];

					if ("string" === typeof (rules)) {
						if ("" === rules) {
							reg = new RegExp("<" + tagName + "(?:\\s[^>]+)?/?>", "gmi");
							text = text.replace(reg, "<" + tagName + ">");
						}
					} else if ("object" === typeof (rules)) {
						reg = new RegExp("<" + tagName + "(\\s[^>]+)?/?>", "gmi");
						found = reg.exec(text);
						attrs = "";

						if (found && found[1]) {
							attrs = found[1];
						}

						if (rules.rmAttr) {
							if ("all" === rules.rmAttr) {
								attrs = "";
							} else if ("object" === typeof (rules.rmAttr) && attrs) {
								for (attrName in rules.rmAttr) {
									regAttr = new RegExp(attrName + '="[^"]*"', "mi");
									attrs = attrs.replace(regAttr, "");
								}
							}
						}

						if (attrs) {
							attrs = attrs.replace(/[\s\n]+/gm, " ");

							if (" " === attrs) {
								attrs = "";
							}
						}

						text = text.replace(reg, "<" + tagName + attrs + ">");
					}
				}

				for (tagName in this.options.rules.msWordMarkup.tags) {
					rules = this.options.rules.msWordMarkup.tags[tagName];

					if ("string" === typeof (rules)) {
						//
					} else if ("object" === typeof (rules)) {
						if (rules.rmWhenEmpty) {
							reg = new RegExp("<" + tagName + "(\\s[^>]+)?>(?:[\\s\\n]|<br/?>)*?</" + tagName + ">", "gmi");
							text = text.replace(reg, "");
						}

						if (rules.rmWhenNoAttr) {
							reg = new RegExp("<" + tagName + ">(?!<" + tagName + ">)([\\s\\S]*?)</" + tagName + ">", "mi");
							found = reg.exec(text);
							while (found) {
								text = text.replace(reg, found[1]);

								found = reg.exec(text);
							}
						}
					}
				}
			}

			return text;
		},

		run: function (Wysiwyg, options) {
			options = options || {};
			this.options = $.extend(true, this.defaults, options);

			if (this.options.rules.heading || this.options.rules.table) {
				var r = Wysiwyg.getInternalRange(),
					start,
					end,
					node,
					traversing;

				start = r.startContainer;
				if (start.nodeType === 3) {
					start = start.parentNode;
				}

				end = r.endContainer;
				if (end.nodeType === 3) {
					end = end.parentNode;
				}

				if (this.debug) {
					console.log("start", start, start.nodeType, start.nodeName, start.parentNode);
					console.log("end", end, end.nodeType, end.nodeName, end.parentNode);
				}

				node = r.commonAncestorContainer;
				if (node.nodeType === 3) {
					node = node.parentNode;
				}

				if (this.debug) {
					console.log("node", node, node.nodeType, node.nodeName.toLowerCase(), node.parentNode, node.firstElementChild);
					console.log(start === end);
				}

				traversing = null;
				if (start === end) {
					traversing = this.domTraversing(node, start, end, true, 1);
				} else {
					traversing = this.domTraversing(node.firstElementChild, start, end, null, 1);
				}

				if (this.debug) { console.log("DomTraversing=", traversing); }
			}

			if (this.options.rules.msWordMarkup.enabled) {
				Wysiwyg.setContent(this.msWordMarkup(Wysiwyg.getContent()));
			}
		}
	};

	$.wysiwyg.plugin.register(rmFormat);
})(jQuery);



/**
 * JQuery Tooltip Plugin
 *
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * Written by Shahrier Akram <shahrier.akram@gmail.com>
 *
 * Tooltip is a jQuery plugin implementing unobtrusive javascript interaction that appears
 * near DOM elements, wherever they may be, that require extra information.
 *
 * Visit http://gdakram.github.com/JQuery-Tooltip-Plugin for demo.
 **/
(function($) {

    $.fn.tooltip = function(settings) {
        // Configuration setup
        config = {
            'dialog_content_selector' : 'div.tooltip_description',
            'animation_distance' : 50,
            'opacity' : 0.85,
            'arrow_left_offset' : 70,
            'arrow_top_offset' : 50,
            'arrow_height' : 20,
            'arrow_width' : 20,
            'animation_duration_ms' : 300,
            'event_in':'mouseover',
            'event_out':'mouseout',
            'is_big': false
        };
        var fuckeinTooltip = $(this);
        if (settings) $.extend(config, settings);

        /**
         * Apply interaction to all the matching elements
         **/
        this.each(function() {
            $(this).bind(config.event_in,function(){
                _show(this);
            })
                .bind(config.event_out,function(){
                    _hide(this);
                })
        });

        /**
         * Positions the dialog box based on the target
         * element's location
         **/
        function _show(target_elm) {
            var dialog_content = $(target_elm).find(config.dialog_content_selector);
            var dialog_box = _create(dialog_content);
            var is_top_right = $(target_elm).hasClass("tooltiptopright");
            var is_bottom_right = $(target_elm).hasClass("tooltipbottomright");
            var is_top = $(target_elm).hasClass("tooltiptop");
            var is_bottom = $(target_elm).hasClass("tooltipbottom");
            var has_position = is_top_right || is_bottom_right || is_top || is_bottom;
            var position;

            var target_elm_position = $(target_elm).offset();

            // coming from the top right
            if (is_top_right || !has_position && (target_elm_position.top < $(dialog_box).outerHeight() && target_elm_position.top >= config.arrow_top_offset)) {
                position = {
                    start : {
                        left : target_elm_position.left + $(target_elm).outerWidth() + config.animation_distance,
                        top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) - config.arrow_top_offset
                    },
                    end : {
                        left : target_elm_position.left + $(target_elm).outerWidth(),
                        top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) - config.arrow_top_offset
                    },
                    arrow_class : "div.left_arrow"
                }
            }
            // coming from the bottom right
            else if (is_bottom_right || !has_position && (target_elm_position.left < config.arrow_left_offset + $(target_elm).outerWidth() && target_elm_position.top > $(dialog_box).outerHeight())) {
                position = {
                    start : {
                        left : target_elm_position.left + $(target_elm).outerWidth() + config.animation_distance,
                        top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) + config.arrow_top_offset - $(dialog_box).outerHeight() + config.arrow_height
                    },
                    end : {
                        left : target_elm_position.left + $(target_elm).outerWidth(),
                        top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) + config.arrow_top_offset - $(dialog_box).outerHeight() + config.arrow_height
                    },
                    arrow_class : "div.left_arrow"
                }
                $(dialog_box).find("div.left_arrow").css({ top: $(dialog_box).outerHeight() - (config.arrow_top_offset * 2) + "px" });
            }
            // coming from the top
            else if (is_top || !has_position &&(target_elm_position.top + config.animation_distance > $(dialog_box).outerHeight() && target_elm_position.left >= config.arrow_left_offset)) {
                position = {
                    start : {
                        left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
                        top  : target_elm_position.top - config.animation_distance - $(dialog_box).outerHeight()
                    },
                    end : {
                        left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
                        top  : target_elm_position.top - $(dialog_box).outerHeight() + config.arrow_height
                    },
                    arrow_class : "div.down_arrow"
                }
            }
            // coming from the bottom
            else if (is_bottom || !has_position &&(target_elm_position.top + config.animation_distance < $(dialog_box).outerHeight())) {
                position = {
                    start : {
                        left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
                        top  : target_elm_position.top + $(target_elm).outerHeight() + config.animation_distance
                    },
                    end : {
                        left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
                        top  : target_elm_position.top + $(target_elm).outerHeight()
                    },
                    arrow_class : "div.up_arrow"
                }
            }

            // position and show the box
            $(dialog_box).css({
                top : position.start.top + "px",
                left : position.start.left + "px",
                opacity : config.opacity
            });
            $(dialog_box).find("div.arrow").hide();
            $(dialog_box).find(position.arrow_class).show();

            // begin animation
            $(dialog_box).animate({
                top : position.end.top,
                left: position.end.left,
                opacity : "toggle"
            }, config.animation_duration_ms);

        }; // -- end _show function

        /**
         * Stop the animation (if any) and remove from dialog box from the DOM
         */
        function _hide(target_elm) {
            $("body").find("div.jquery-gdakram-tooltip").stop().remove();
        };

        /**
         * Creates the dialog box element
         * and appends it to the body
         **/
        function _create(content_elm) {
            return $("<div class='jquery-gdakram-tooltip'>\
         <div class='up_arrow arrow'></div>\
         <div class='left_arrow arrow'></div>\
         <div class='content'>" + $(content_elm).html() + "</div>\
         <div style='clear:both'></div>\
         <div class='down_arrow arrow'></div>\
       </div>").appendTo('body').addClass(fuckeinTooltip.hasClass('big-tooltip-inside') ? 'tooltip-large' : '');
        };

        return this;
    };

})(jQuery);


// ikSelect 0.9.1
// Copyright (c) 2012 Igor Kozlov
// i10k.ru

;(function ($, window, document, undefined) {
	var $window = $(window);
	var defaults = {
		syntax: "<div class=\"ik_select_link\"><span class=\"ik_select_link_text\"></span></div><div class=\"ik_select_block\"><div class=\"ik_select_list\"></div></div>",
		autoWidth: true,
		ddFullWidth: true,
		customClass: "",
		ddCustomClass: "",
		ddMaxHeight: 200,
		filter: false,
		skipFirst: false,
		onShow: function () {},
		onHide: function () {},
		onKeyUp: function () {},
		onKeyDown: function () {},
		onHoverMove: function () {}
	};

	var selectOpened = $([]); // currently opened select
	var shownOnPurpose = false; // true if show_dropdown was called using API
	var scrollbarWidth = -1;

	$.browser.mobile = (/iphone|ipad|ipod|android/i.test(navigator.userAgent.toLowerCase()));
	$.browser.operamini = Object.prototype.toString.call(window.operamini) === "[object OperaMini]";

	function IkSelect(element, options) {
		var ikselect = this;

		ikselect.element = element;

		ikselect.options = $.extend({}, defaults, options);

		ikselect._defaults = defaults;

		if (ikselect.element === undefined) {
			return ikselect;
		}

		ikselect.fakeSelect = $("<div class=\"ik_select\">" + ikselect.options.syntax + "</div>"); // fake select object made with passed syntax
		ikselect.select = $(ikselect.element); // original select
		ikselect.link = $(".ik_select_link", ikselect.fakeSelect); // fake select
		ikselect.linkText = $(".ik_select_link_text", ikselect.fakeSelect); // fake select's text
		ikselect.block = $(".ik_select_block", ikselect.fakeSelect); // fake select's dropdown
		ikselect.list = $(".ik_select_list", ikselect.fakeSelect); // fake select's list inside of dropdown
		ikselect.listInner = $("<div class=\"ik_select_list_inner\"/>"); // support block for scroll

		ikselect.filter = $([]); // filter text input
		ikselect.listItemsOriginal = $([]); // contains original list items when filtering
		ikselect.nothingFoundText = $("<div class=\"ik_nothing_found\"/>").html(ikselect.select.data("nothingfoundtext"));

		if (ikselect.options.filter && ! $.browser.mobile) {
			ikselect.filterWrap = $(".ik_select_filter_wrap", ikselect.fakeSelect);

			if (! ikselect.filterWrap.length) {
				ikselect.filterWrap = $("<div class=\"ik_select_filter_wrap\"/>");
			}

			ikselect.filter = $("<input type=\"text\" class=\"ik_select_filter\">");

			ikselect.filterWrap.append(ikselect.filter);
		}

		ikselect.active = $([]);
		ikselect.hover = $([]);
		ikselect.hoverIndex = -1;

		ikselect.listItems = $([]);
		ikselect.listOptgroupItems = $([]);

		ikselect.init();
	}

	$.extend(IkSelect.prototype, {
		init: function () {
			var ikselect = this;

			var fakeSelect = ikselect.fakeSelect;
			var select = ikselect.select;
			var link = ikselect.link;
			var block = ikselect.block;
			var list = ikselect.list;
			var listInner = ikselect.listInner;

			var filter = ikselect.filter;

			list.append(listInner);

			fakeSelect.addClass(ikselect.options.customClass);
			block.addClass(ikselect.options.ddCustomClass);

			//creating fake option list
			ikselect.reset_all();

			if (select.attr("disabled")) {
				ikselect.disable_select();
			}

			// click event for fake select
			link.bind("click.ikSelect", function () {
				if (link.hasClass("ik_select_link_disabled")) {
					return this;
				}
				if (selectOpened.length) {
					var me = selectOpened.is(ikselect.select);
					selectOpened.data("plugin_ikSelect").hide_block();
					if(me){
						return this;
					}
				}
				ikselect.show_block();
				if (ikselect.options.filter) {
					filter.focus();
				} else {
					select.focus();
				}
			});

			// when focus is on original select add "focus" class to the fake one
			select.bind("focus.ikSelect", function () {
				if (link.hasClass("ik_select_link_disabled")) {
					return this;
				}
				link.addClass("ik_select_link_focus");

				// scoll the window so that focused select is visible
				if ((fakeSelect.offset().top + fakeSelect.height() > $window.scrollTop() + $window.height()) || (fakeSelect.offset().top + fakeSelect.height() < $window.scrollTop())) {
					$window.scrollTop(fakeSelect.offset().top - $window.height() / 2);
				}
			});

			// when focus lost remove "focus" class from the fake one
			select.bind("blur.ikSelect", function () {
				if (link.hasClass("ik_select_link_disabled")) {
					return this;
				}
				link.removeClass("ik_select_link_focus");
			});

			// sync fake select on mobile devices and a way to outplay the changing of select on scroll anywhere in IE6
			select.bind("change.ikSelect", function () {
				ikselect._select_fake_option();
			});

			// filtering using filter
			var filterValOld = "";

			filter.bind("keyup.ikSelect", function () {
				listInner.show();

				if (filterValOld === "" && ! ikselect.listItemsOriginal.length) {
					ikselect.listItemsOriginal = ikselect.listItems;
				}

				if (filter.val() !== filterValOld) {
					if (filter.val() === "") {
						ikselect.listItems = ikselect.listItemsOriginal.show();
						ikselect.listOptgroupItems.show();
						ikselect.nothingFoundText.remove();
					} else {
						ikselect.listItems = ikselect.listItemsOriginal.show();
						ikselect.listOptgroupItems.show();

						ikselect.listItems.each(function () {
							if ($(".ik_select_option", this).html().search(new RegExp(filter.val(), "i")) === -1) {
								ikselect.listItems = ikselect.listItems.not(this);
								$(this).hide();
							}
						});

						if (ikselect.listItems.length) {
							ikselect.nothingFoundText.remove();
							ikselect.listOptgroupItems.each(function () {
								var optgroup = $(this);
								if (! $("> ul > li:visible", optgroup).length) {
									optgroup.hide();
								}
							});

							if (! ikselect.listItems.filter(ikselect.hover).length && ikselect.listItems.length) {
								ikselect._move_to(ikselect.listItems.eq(0));
							}

							ikselect.hoverIndex = ikselect.listItems.index(ikselect.hover);
						} else {
							listInner.hide();
							list.append(ikselect.nothingFoundText);
						}
					}

					filterValOld = filter.val();
				}
			});

			// keyboard controls for the fake select and fake dropdown
			select.add(filter).bind("keydown.ikSelect keyup.ikSelect", function (event) {
				var listItems = ikselect.listItems;

				if (ikselect.hoverIndex < 0) {
					ikselect.hoverIndex = listItems.index(ikselect.hover);
				}

				var keycode = event.which;
				var type = event.type;

				switch (keycode) {
				case 40: //down
					if (type === "keydown") {
						event.preventDefault();
						var next;

						if (ikselect.hoverIndex < listItems.length - 1) {
							next = listItems.eq(++ikselect.hoverIndex);

							while (next && next.hasClass("ik_select_option_disabled")) {
								next = listItems.filter(":eq(" + (++ikselect.hoverIndex) + ")");
							}
						}

						if (next) {
							ikselect._move_to(next);
						}
					}
					break;
				case 38: //up
					if (type === "keydown") {
						event.preventDefault();
						var prev;
						if (ikselect.hoverIndex > 0) {
							prev = listItems.eq(--ikselect.hoverIndex);

							while (prev && prev.hasClass("ik_select_option_disabled")) {
								prev = listItems.filter(":eq(" + (--ikselect.hoverIndex) + ")");
							}
						}

						if (prev) {
							ikselect._move_to(prev);
						}
					}
					break;
				case 33: //page up
				case 36: //home
					if (type === "keydown") {
						event.preventDefault();
						ikselect._move_to(listItems.filter(".not(ik_select_option_disabled):first"));
					}
					break;
				case 34: //page down
				case 35: //end
					if (type === "keydown") {
						event.preventDefault();
						ikselect._move_to(listItems.filter(".not(ik_select_option_disabled):last"));
					}
					break;
				case 32: //space
					if (type === "keydown" && $(this).is(select)) {
						event.preventDefault();
						if (! block.is(":visible")) {
							link.click();
						} else {
							ikselect._select_real_option();
						}
					}
					break;
				case 13: //enter
					if (type === "keydown" && block.is(":visible")) {
						event.preventDefault();
						ikselect._select_real_option();
					}
					break;
				case 27: //esc
					if (type === "keydown") {
						event.preventDefault();
						ikselect.hide_block();
					}
					break;
				case 9: //tab
					if (type === "keydown") {
						if ($.browser.webkit && block.is(":visible")) {
							event.preventDefault();
						} else {
							ikselect.hide_block();
						}
					}
					break;
				default:
					if (type === "keyup" && $(this).is(select)) {
						ikselect._select_fake_option();
					}
					break;
				}

				if (type === "keydown") {
					ikselect.options.onKeyDown(ikselect, keycode);
					select.trigger("ikkeydown", [ikselect, keycode]);
				}
				if (type === "keyup") {
					ikselect.options.onKeyUp(ikselect, keycode);
					select.trigger("ikkeyup", [ikselect, keycode]);
				}
			});

			// appending fake select right after the original one
			select.after(fakeSelect);

			// appending filter if needed
			if (ikselect.options.filter && ! $.browser.mobile) {
				list.prepend(ikselect.filterWrap);
			}

			// set correct dimensions
			ikselect.redraw();

			select.appendTo(fakeSelect);
		},

		redraw: function () {
			var ikselect = this;
			var select = ikselect.select;
			var fakeSelect = ikselect.fakeSelect;
			var block = ikselect.block;
			var list = ikselect.list;
			var listInner = ikselect.listInner;

			var autoWidth = ikselect.options.autoWidth; // set select width according to the longest option
			var ddFullWidth = ikselect.options.ddFullWidth; // set dropdown width according to the longest option

			// width calculations for the fake select when "autoWidth" is "true"
			if (autoWidth || ddFullWidth) {
				listInner.width("auto");
				$("ul", listInner).width("auto");
				fakeSelect.width("auto");

				block.show().width(9999);
				listInner.css("float", "left");
				list.css("position", "absolute");
				var maxWidthOuter = list.outerWidth(true);
				var maxWidthInner = list.width();
				list.css("position", "static");
				block.hide().css("width", "100%");
				listInner.css("float", "none");

				if (scrollbarWidth === -1) {
					var calculationContent = $("<div style=\"width:50px; height:50px; overflow:hidden; position:absolute; top:-200px; left:-200px;\"><div style=\"height:100px;\"></div>");
					$("body").append(calculationContent);
					var w1 = $("div", calculationContent).innerWidth();
					calculationContent.css("overflow", "auto");
					var w2 = $("div", calculationContent).innerWidth();
					$(calculationContent).remove();
					scrollbarWidth = w1 - w2;
				}

				var parentWidth = fakeSelect.parent().width();
				if (ddFullWidth) {
					block.width(maxWidthOuter);
					listInner.width(maxWidthInner);
					$("ul", listInner).width(maxWidthInner);
				}
				if (maxWidthOuter > parentWidth) {
					maxWidthOuter = parentWidth;
				}
				if (autoWidth) {
					fakeSelect.width(maxWidthOuter);
				}
			}

			ikselect._fix_height();

			// hide the original select
			select.css({
				position: "absolute",
				margin: 0,
				padding: 0,
				left: -9999,
				top: 0
			});

			// show the original select in mobile browsers
			if ($.browser.mobile) {
				select.css({
					opacity: 0,
					left: 0,
					height: fakeSelect.height()
				});
			}
		},

		// creates or recreates dropdown and sets selected options's text into fake select
		reset_all: function () {
			var ikselect = this;
			var select = ikselect.select;
			var linkText = ikselect.linkText;
			var listInner = ikselect.listInner;

			// init fake select's text
			linkText.html(select.val());

			listInner.empty();

			// creating an ul->li list identical to original dropdown
			var newOptions = "";

			newOptions += "<ul>";
			select.children().each(function (i) {
				if (this.tagName === "OPTGROUP") {
					var optgroup = $(this);
					newOptions += "<li class=\"ik_select_optgroup" + (optgroup.is(":disabled") ? " ik_select_optgroup_disabled" : "") + "\">";

					newOptions += "<div class=\"ik_select_optgroup_label\">" + optgroup.attr("label") + "</div>";

					newOptions += "<ul>";
					$("option", optgroup).each(function () {
						var option = $(this);
						newOptions += "<li" + (option.is(":disabled") ? " class=\"ik_select_option_disabled\"" : "") + "><span class=\"ik_select_option" + (option[0].getAttribute("value") ? "" : " ik_select_option_novalue") + "\" title=\"" + option.val() + "\">" + option.html() + "</span></li>";
					});
					newOptions += "</ul>";

					newOptions += "</li>";
				} else {
					if(ikselect.options.skipFirst && i == 0){
						return;
					}
					var option = $(this),
					style = option.attr('style');
					newOptions += "<li" + (option.is(":disabled") ? " class=\"ik_select_option_disabled\"" : "") + (style?' style="'+style+'"':'') + "><span class=\"ik_select_option" + (option[0].getAttribute("value") ? "" : " ik_select_option_novalue") + "\" title=\"" + option.val() + "\">" + option.html() + "</span></li>";
				}
			});
			newOptions += "</ul>";
			listInner.append(newOptions);
			ikselect._select_fake_option();

			ikselect.listOptgroupItems = $(".ik_select_optgroup", listInner);
			ikselect.listItems = $("li:not(.ik_select_optgroup)", listInner);

			ikselect._attach_list_events(ikselect.listItems);
		},

		// binds click and mouseover events to dropdown's options
		_attach_list_events: function (jqObj) {
			var ikselect = this;
			var select = ikselect.select;
			var link = ikselect.link;
			var linkText = ikselect.linkText;

			var listItemsEnabled = jqObj.not(".ik_select_option_disabled");

			// click events for the fake select's options
			listItemsEnabled.bind("click.ikSelect", function () {
				var option = $(".ik_select_option", this),
						style = $(this).attr('style');
				linkText.html(option.html()).attr('style', style);
				select.val(option.attr("title"));
				ikselect.active.removeClass("ik_select_active");
				ikselect.active = $(this).addClass("ik_select_active");
				ikselect.hide_block();
				if (option.hasClass("ik_select_option_novalue")) {
					link.addClass("ik_select_link_novalue");
				} else {
					link.removeClass("ik_select_link_novalue");
				}
				select.change();
				select.focus();
			});

			// hover event for the fake options
			listItemsEnabled.bind("mouseover.ikSelect", function () {
				ikselect.hoverIndex = -1;
				ikselect.hover.removeClass("ik_select_hover");
				ikselect.hover = $(this).addClass("ik_select_hover");
			});

			listItemsEnabled.addClass("ik_select_has_events");
		},

		// unbinds click and mouseover events from dropdown's options
		_detach_list_events: function (jqObj) {
			jqObj.unbind(".ikSelect");

			jqObj.removeClass("ik_select_has_events");
		},


		// change the defaults for all new instances
		set_defaults: function (settings) {
			$.extend(this._defaults, settings || {});
			return this;
		},

		// hides dropdown
		hide_block: function () {
			var ikselect = this;
			var fakeSelect = ikselect.fakeSelect;
			var block = ikselect.block;
			var select = ikselect.select;

			if (ikselect.options.filter && ! $.browser.mobile) {
				ikselect.filter.val("").keyup();
			}

			if (ikselect.listItemsOriginal.length) {
				ikselect.listOptgroupItems.show();
				ikselect.listItems = ikselect.listItemsOriginal.show();
			}

			block.hide().appendTo(fakeSelect).css({
				"left": "",
				"top": ""
			});
			select.removeClass(".ik_select_opened");

			selectOpened = $([]);

			select.focus();

			ikselect.options.onHide(ikselect);
			select.trigger("ikhide", [ikselect]);
		},

		// shows dropdown
		show_block: function () {
			var ikselect = this;
			var select = ikselect.select;

			if (selectOpened.is(ikselect.select) || ! ikselect.listItems.length) {
				return ikselect;
			} else if (selectOpened.length) {
				selectOpened.data("plugin_ikSelect").hide_block();
			}

			var fakeSelect = ikselect.fakeSelect;
			var block = ikselect.block;
			var list = ikselect.list;
			var listInner = ikselect.listInner;
			var hover = ikselect.hover;
			var active = ikselect.active;
			var listItems = ikselect.listItems;

			block.show();
			select.addClass("ik_select_opened");
			var ind = $("option", select).index($("option:selected", select));
			hover.removeClass("ik_select_hover");
			active.removeClass("ik_select_active");
			var next = listItems.eq(ind);
			next.addClass("ik_select_hover ik_select_active");
			ikselect.hover = next;
			ikselect.active = next;
			ikselect.hoverIndex = ikselect.listItems.index(next);

			// if the dropdown's right border is beyond window's edge then move the dropdown to the left so that it fits
			block.css("left", "");
			if (ikselect.options.ddFullWidth && fakeSelect.offset().left + block.outerWidth(true) > $window.width()) {
				block.css("left", (block.offset().left + block.outerWidth(true) - $window.width()) * (-1));
			}

			// if the dropdown's bottom border is beyond window's edge then move the dropdown to the left so that it fits
			block.css("top", "");
			if (block.offset().top + block.outerHeight(true) > $window.scrollTop() + $window.height()) {
				block.css("top", ((block.offset().top + block.outerHeight(true) - parseInt(block.css("top"), 10)) - ($window.scrollTop() + $window.height())) * (-1));
			}

			var left = block.offset().left;
			if (left < 0) {
				left = 0;
			}
			var top = block.offset().top;
			block.width(block.width());
			block.appendTo("body").css({
				"left": left,
				"top": top
			});

			var scrollTop = $(".ik_select_active", list).position().top - list.height() / 2;
			list.data("ik_select_scrollTop", scrollTop);
			listInner.scrollTop(scrollTop);

			selectOpened = select;

			ikselect.options.onShow(ikselect);
			select.trigger("ikshow", [ikselect]);
		},

		// add options to the list
		add_options: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var listInner = ikselect.listInner;

			var fakeSelectHtml = "", selectHtml = "";

			$.each(args, function (index, value) {
				if (typeof value === "string") {
					fakeSelectHtml += "<li><span class=\"ik_select_option\" title=\"" + index + "\">" + value + "</span></li>";
					selectHtml += "<option value=\"" + index + "\">" + value + "</option>";
				} else if (typeof value === "object") {
					var ul = $("> ul > li.ik_select_optgroup:eq(" + index + ") > ul", listInner); // 'index' - optgroup index

					var optgroup = $("optgroup:eq(" + index + ")", select);
					var newOptions = value; // 'value' - new option objects

					$.each(newOptions, function (index, value) {
						fakeSelectHtml += "<li><span class=\"ik_select_option\" title=\"" + index + "\">" + value + "</span></li>";
						selectHtml += "<option value=\"" + index + "\">" + value + "</option>";
					});

					ul.append(fakeSelectHtml);
					optgroup.append(selectHtml);
					fakeSelectHtml = "";
					selectHtml = "";
				}
			});

			if (selectHtml !== "") {
				$(":first", listInner).append(fakeSelectHtml);
				select.append(selectHtml);
			}

			ikselect._fix_height();

			ikselect.listItems = $("li:not(.ik_select_optgroup)", listInner);

			ikselect._attach_list_events(ikselect.listItems);
		},

		// remove options from the list
		remove_options: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var listItems = ikselect.listItems;
			var removeList = $([]);

			$.each(args, function (index, value) {
				$("option", select).each(function (index) {
					if ($(this).val() === value) {
						removeList = removeList.add($(this)).add(listItems.eq(index));
					}
				});
			});

			ikselect.listItems = listItems.not(removeList);
			removeList.remove();
			ikselect._select_fake_option();

			ikselect._fix_height();
		},

		// sync selected option in the fake select with the original one
		_select_real_option: function () {
			var hover = this.hover;
			var active = this.active;

			active.removeClass("ik_select_active");
			hover.addClass("ik_select_active").click();
		},

		// sync selected option in the original select with the fake one
		_select_fake_option: function () {
			var ikselect = this;
			var select = ikselect.select;
			var link = ikselect.link;
			var linkText = ikselect.linkText;
			var listItems = ikselect.listItems;

			var selected = $(":selected", select);
			var ind = $("option", select).index(selected);
			linkText.html(selected.html()).attr('style', selected.attr('style'));

			if (selected.length && selected[0].getAttribute("value")) {
				link.removeClass("ik_select_link_novalue");
			} else {
				link.addClass("ik_select_link_novalue");
			}

			ikselect.hover = listItems.removeClass("ik_select_hover ik_select_active").eq(ind).addClass("ik_select_hover ik_select_active");
			ikselect.active = ikselect.hover;
		},

		// disables select
		disable_select: function () {
			var select = this.select;
			var link = this.link;

			select.attr("disabled", "disabled");
			link.addClass("ik_select_link_disabled");
		},

		// enables select
		enable_select: function () {
			var select = this.select;
			var link = this.link;

			select.removeAttr("disabled");
			link.removeClass("ik_select_link_disabled");
		},

		// toggles select
		toggle_select: function () {
			var ikselect = this;
			var link = this.link;

			if (link.hasClass("ik_select_link_disabled")) {
				ikselect.enable_select();
			} else {
				ikselect.disable_select();
			}
		},

		// make option selected by value
		make_selection: function (args) {
			var ikselect = this;
			var select = ikselect.select;

			select.val(args);
			ikselect._select_fake_option();
		},

		// disables optgroups
		disable_optgroups: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var list = ikselect.list;

			$.each(args, function (index, value) {
				var optgroup = $("optgroup:eq(" + value + ")", select);
				optgroup.attr("disabled", "disabled");
				$(".ik_select_optgroup:eq(" + value + ")", list).addClass("ik_select_optgroup_disabled");

				ikselect.disable_options($("option", optgroup));
			});

			ikselect._select_fake_option();
		},

		// enables optgroups
		enable_optgroups: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var list = ikselect.list;

			$.each(args, function (index, value) {
				var optgroup = $("optgroup:eq(" + value + ")", select);
				optgroup.removeAttr("disabled");
				$(".ik_select_optgroup:eq(" + value + ")", list).removeClass("ik_select_optgroup_disabled");

				ikselect.enable_options($("option", optgroup));
			});

			ikselect._select_fake_option();
		},

		// disables options
		disable_options: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var listItems = ikselect.listItems;

			var optionSet = $("option", select);

			$.each(args, function (index, value) {
				if (typeof value === "object") {
					$(this).attr("disabled", "disabled");
					var option_index = optionSet.index(this);
					var fakeOption = listItems.eq(ikselect.options.skipFirst?option_index-1:option_index).addClass("ik_select_option_disabled");
					ikselect._detach_list_events(fakeOption);
				} else {
					optionSet.each(function (index) {
						if ($(this).val() === value) {
							$(this).attr("disabled", "disabled");
							var fakeOption = listItems.eq(ikselect.options.skipFirst?index-1:index).addClass("ik_select_option_disabled");
							ikselect._detach_list_events(fakeOption);
							return this;
						}
					});
				}
			});

			ikselect._select_fake_option();
		},

		// disables options
		enable_options: function (args) {
			var ikselect = this;
			var select = ikselect.select;
			var listItems = ikselect.listItems;

			var optionSet = $("option", select);

			$.each(args, function (index, value) {
				if (typeof value === "object") {
					$(this).removeAttr("disabled");
					var option_index = optionSet.index(this);
					var fakeOption = listItems.eq(option_index).removeClass("ik_select_option_disabled");
					ikselect._attach_list_events(fakeOption);
				} else {
					optionSet.each(function (index) {
						if ($(this).val() === value) {
							$(this).removeAttr("disabled");
							var fakeOption = listItems.eq(index).removeClass("ik_select_option_disabled");
							ikselect._attach_list_events(fakeOption);
							return this;
						}
					});
				}
			});

			ikselect._select_fake_option();
		},

		// detaching plugin from the orignal select
		detach_plugin: function () {
			var ikselect = this;
			var select = ikselect.select;
			var fakeSelect = ikselect.fakeSelect;

			select.unbind(".ikSelect").css({
				"width": "",
				"height": "",
				"left": "",
				"top": "",
				"position": "",
				"margin": "",
				"padding": ""
			});

			fakeSelect.before(select);
			fakeSelect.remove();
		},

		// controls class changes for options (hover/active states)
		_move_to: function (jqObj) {
			var ikselect = this;
			var select = ikselect.select;
			var linkText = ikselect.linkText;
			var block = ikselect.block;
			var list = ikselect.list;
			var listInner = ikselect.listInner;

			if (! block.is(":visible") && $.browser.webkit) {
				ikselect.show_block();
				return this;
			}

			ikselect.hover.removeClass("ik_select_hover");
			jqObj.addClass("ik_select_hover");
			ikselect.hover = jqObj;
			if (! $.browser.webkit) {
				ikselect.active.removeClass("ik_select_active");
				jqObj.addClass("ik_select_active");
				ikselect.active = jqObj;
			}
			if (! block.is(":visible") || $.browser.mozilla) {
				if (! $.browser.mozilla) {
					select.val($(".ik_select_option", jqObj).attr("title"));
					select.change();
				}
				linkText.html($(".ik_select_option", jqObj).html());
			}

			var jqObjTopLine = jqObj.offset().top - list.offset().top - parseInt(list.css("paddingTop"), 10);
			var jqObjBottomLine = jqObjTopLine + jqObj.outerHeight();
			if (jqObjBottomLine > list.height()) {
				listInner.scrollTop(listInner.scrollTop() + jqObjBottomLine - list.height());
			} else if (jqObjTopLine < 0) {
				listInner.scrollTop(listInner.scrollTop() + jqObjTopLine);
			}

			ikselect.options.onHoverMove(jqObj, ikselect);
			select.trigger("ikhovermove", [jqObj, ikselect]);
		},

		// sets fixed height to dropdown if it's bigger than ddMaxHeight
		_fix_height: function () {
			var ikselect = this;
			var block = ikselect.block;
			var listInner = ikselect.listInner;
			var ddMaxHeight = ikselect.options.ddMaxHeight;
			var ddFullWidth = ikselect.options.ddFullWidth;

			block.show();
			listInner.css("height", "auto");
			if (listInner.height() > ddMaxHeight) {
				listInner.css({
					overflow: "auto",
					height: ddMaxHeight,
					position: "relative"
				});

				if (! $.data(listInner, "ik_select_hasScrollbar")) {
					if (ddFullWidth) {
						block.width(block.width() + scrollbarWidth);
						listInner.width(listInner.width() + scrollbarWidth);
					}
				}

				$.data(listInner, "ik_select_hasScrollbar", true);
			} else {
				if ($.data(listInner, "ik_select_hasScrollbar")) {
					listInner.css({
						overflow: "",
						height: "auto"
					});
					listInner.width(listInner.width() - scrollbarWidth);
					block.width(block.width() - scrollbarWidth);
				}
			}
			block.hide();
		}
	});

	$.fn.ikSelect = function (options) {
		//do nothing if opera mini
		if ($.browser.operamini) {
			return this;
		}

		var args = Array.prototype.slice.call(arguments);

		return this.each(function () {
			if (!$.data(this, "plugin_ikSelect")) {
				$.data(this, "plugin_ikSelect", new IkSelect(this, options));
			} else if (typeof options === "string") {
				var ikselect = $.data(this, "plugin_ikSelect");
				switch (options) {
				case "reset":
					ikselect.reset_all();
					break;
				case "hide_dropdown":
					ikselect.hide_block();
					break;
				case "show_dropdown":
					shownOnPurpose = true;
					ikselect.select.focus();
					ikselect.show_block();
					break;
				case "add_options":
					ikselect.add_options(args[1]);
					break;
				case "remove_options":
					ikselect.remove_options(args[1]);
					break;
				case "enable":
					ikselect.enable_select();
					break;
				case "disable":
					ikselect.disable_select();
					break;
				case "toggle":
					ikselect.toggle_select();
					break;
				case "select":
					ikselect.make_selection(args[1]);
					break;
				case "set_defaults":
					ikselect.set_defaults(args[1]);
					break;
				case "redraw":
					ikselect.redraw();
					break;
				case "disable_options":
					ikselect.disable_options(args[1]);
					break;
				case "enable_options":
					ikselect.enable_options(args[1]);
					break;
				case "disable_optgroups":
					ikselect.disable_optgroups(args[1]);
					break;
				case "enable_optgroups":
					ikselect.enable_optgroups(args[1]);
					break;
				case "detach":
					ikselect.detach_plugin();
					break;
				}
			}
		});
	};

	// singleton instance
	$.ikSelect = new IkSelect();

	// hide fake select list when clicking outside of it
	$(document).bind("click.ikSelect", function (event) {
		if (! shownOnPurpose && selectOpened.length && ! $(event.target).closest(".ik_select").length && ! $(event.target).closest(".ik_select_block").length) {
			selectOpened.ikSelect("hide_dropdown");
			selectOpened = $([]);
		}
		if (shownOnPurpose) {
			shownOnPurpose = false;
		}
	});
})(jQuery, window, document);
/* 
	http://jamesflorentino.com/jquery.nanoscroller/
*/
(function(d,f,e){var g,h;h=function(){var c,a,b;a=e.createElement("div");a.style.position="absolute";a.style.width="100px";a.style.height="100px";a.style.overflow="scroll";e.body.appendChild(a);c=a.offsetWidth;b=a.scrollWidth;e.body.removeChild(a);return c-b};g=function(){function c(a){this.el=a;this.generate();this.createEvents();this.addEvents();this.reset()}c.prototype.createEvents=function(){var a=this;this.events={down:function(b){a.isDrag=!0;a.offsetY=b.clientY-a.slider.offset().top;a.pane.addClass("active");
d(e).bind("mousemove",a.events.drag);d(e).bind("mouseup",a.events.up);return!1},drag:function(b){a.sliderY=b.clientY-a.el.offset().top-a.offsetY;a.scroll();return!1},up:function(){a.isDrag=!1;a.pane.removeClass("active");d(e).unbind("mousemove",a.events.drag);d(e).unbind("mouseup",a.events.up);return!1},resize:function(){a.reset()},panedown:function(b){a.sliderY=b.clientY-a.el.offset().top-0.5*a.sliderH;a.scroll();a.events.down(b)},scroll:function(){var b;!0!==a.isDrag&&(b=a.content[0],a.slider.css({top:b.scrollTop/
(b.scrollHeight-b.clientHeight)*(a.paneH-a.sliderH)+"px"}))},wheel:function(b){a.sliderY+=-b.wheelDeltaY||-b.delta;a.scroll();return!1}}};c.prototype.addEvents=function(){var a,b;a=this.events;b=this.pane;d(f).bind("resize",a.resize);this.slider.bind("mousedown",a.down).bind("click",function(e){e.stopPropagation()});b.bind("mousedown",a.panedown);this.content.bind("scroll",a.scroll);f.addEventListener&&(b=b[0],b.addEventListener("mousewheel",a.wheel,!1),b.addEventListener("DOMMouseScroll",a.wheel,
!1))};c.prototype.removeEvents=function(){var a,b;a=this.events;b=this.pane;d(f).unbind("resize",a.resize);this.slider.unbind("mousedown",a.down);b.unbind("mousedown",a.panedown);this.content.unbind("scroll",a.scroll);f.addEventListener&&(b=b[0],b.removeEventListener("mousewheel",a.wheel,!1),b.removeEventListener("DOMMouseScroll",a.wheel,!1))};c.prototype.generate=function(){this.el.append('<div class="pane"><div class="slider"></div></div>');this.content=d(this.el.children(".content")[0]);this.slider=
this.el.find(".slider");this.pane=this.el.find(".pane");this.scrollW=h();0===this.scrollbarWidth&&(this.scrollW=0);this.content.css({right:-this.scrollW+"px"})};c.prototype.reset=function(){var a;0===this.el.find(".pane").length&&(this.generate(),this.stop());!0===this.isDead&&(this.isDead=!1,this.pane.show(),this.addEvents());a=this.content[0];this.contentH=a.scrollHeight+this.scrollW;this.paneH=this.pane.outerHeight();this.sliderH=this.paneH/this.contentH*this.paneH;this.sliderH=Math.round(this.sliderH);
this.scrollH=this.paneH-this.sliderH;this.slider.height(this.sliderH);this.diffH=a.scrollHeight-a.clientHeight;this.pane.show();this.paneH>=this.content[0].scrollHeight&&this.pane.hide()};c.prototype.scroll=function(){var a;this.sliderY=Math.max(0,this.sliderY);this.sliderY=Math.min(this.scrollH,this.sliderY);a=this.paneH-this.contentH+this.scrollW;a=a*this.sliderY/this.scrollH;this.content.scrollTop(-a);return this.slider.css({top:this.sliderY})};c.prototype.scrollBottom=function(a){var b,c;b=this.diffH;
c=this.content[0].scrollTop;this.reset();c<b&&0!==c||this.content.scrollTop(this.contentH-this.content.height()-a)};c.prototype.scrollTop=function(a){this.reset();this.content.scrollTop(+a)};c.prototype.stop=function(){this.isDead=!0;this.removeEvents();this.pane.hide()};return c}();d.fn.nanoScroller=function(c){c||(c={});d.browser.msie&&8>parseInt(d.browser.version,10)||this.each(function(){var a,b;a=d(this);b=a.data("scrollbar");void 0===b&&(b=new g(a),a.data("scrollbar",b));return c.scrollBottom?
b.scrollBottom(c.scrollBottom):c.scrollTop?b.scrollTop(c.scrollTop):"bottom"===c.scroll?b.scrollBottom(0):"top"===c.scroll?b.scrollTop(0):c.stop?b.stop():b.reset()})}})(jQuery,window,document);

/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.position.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(a,b){a.ui=a.ui||{};var c=/left|center|right/,d=/top|center|bottom/,e="center",f={},g=a.fn.position,h=a.fn.offset;a.fn.position=function(b){if(!b||!b.of)return g.apply(this,arguments);b=a.extend({},b);var h=a(b.of),i=h[0],j=(b.collision||"flip").split(" "),k=b.offset?b.offset.split(" "):[0,0],l,m,n;return i.nodeType===9?(l=h.width(),m=h.height(),n={top:0,left:0}):i.setTimeout?(l=h.width(),m=h.height(),n={top:h.scrollTop(),left:h.scrollLeft()}):i.preventDefault?(b.at="left top",l=m=0,n={top:b.of.pageY,left:b.of.pageX}):(l=h.outerWidth(),m=h.outerHeight(),n=h.offset()),a.each(["my","at"],function(){var a=(b[this]||"").split(" ");a.length===1&&(a=c.test(a[0])?a.concat([e]):d.test(a[0])?[e].concat(a):[e,e]),a[0]=c.test(a[0])?a[0]:e,a[1]=d.test(a[1])?a[1]:e,b[this]=a}),j.length===1&&(j[1]=j[0]),k[0]=parseInt(k[0],10)||0,k.length===1&&(k[1]=k[0]),k[1]=parseInt(k[1],10)||0,b.at[0]==="right"?n.left+=l:b.at[0]===e&&(n.left+=l/2),b.at[1]==="bottom"?n.top+=m:b.at[1]===e&&(n.top+=m/2),n.left+=k[0],n.top+=k[1],this.each(function(){var c=a(this),d=c.outerWidth(),g=c.outerHeight(),h=parseInt(a.curCSS(this,"marginLeft",!0))||0,i=parseInt(a.curCSS(this,"marginTop",!0))||0,o=d+h+(parseInt(a.curCSS(this,"marginRight",!0))||0),p=g+i+(parseInt(a.curCSS(this,"marginBottom",!0))||0),q=a.extend({},n),r;b.my[0]==="right"?q.left-=d:b.my[0]===e&&(q.left-=d/2),b.my[1]==="bottom"?q.top-=g:b.my[1]===e&&(q.top-=g/2),f.fractions||(q.left=Math.round(q.left),q.top=Math.round(q.top)),r={left:q.left-h,top:q.top-i},a.each(["left","top"],function(c,e){a.ui.position[j[c]]&&a.ui.position[j[c]][e](q,{targetWidth:l,targetHeight:m,elemWidth:d,elemHeight:g,collisionPosition:r,collisionWidth:o,collisionHeight:p,offset:k,my:b.my,at:b.at})}),a.fn.bgiframe&&c.bgiframe(),c.offset(a.extend(q,{using:b.using}))})},a.ui.position={fit:{left:function(b,c){var d=a(window),e=c.collisionPosition.left+c.collisionWidth-d.width()-d.scrollLeft();b.left=e>0?b.left-e:Math.max(b.left-c.collisionPosition.left,b.left)},top:function(b,c){var d=a(window),e=c.collisionPosition.top+c.collisionHeight-d.height()-d.scrollTop();b.top=e>0?b.top-e:Math.max(b.top-c.collisionPosition.top,b.top)}},flip:{left:function(b,c){if(c.at[0]===e)return;var d=a(window),f=c.collisionPosition.left+c.collisionWidth-d.width()-d.scrollLeft(),g=c.my[0]==="left"?-c.elemWidth:c.my[0]==="right"?c.elemWidth:0,h=c.at[0]==="left"?c.targetWidth:-c.targetWidth,i=-2*c.offset[0];b.left+=c.collisionPosition.left<0?g+h+i:f>0?g+h+i:0},top:function(b,c){if(c.at[1]===e)return;var d=a(window),f=c.collisionPosition.top+c.collisionHeight-d.height()-d.scrollTop(),g=c.my[1]==="top"?-c.elemHeight:c.my[1]==="bottom"?c.elemHeight:0,h=c.at[1]==="top"?c.targetHeight:-c.targetHeight,i=-2*c.offset[1];b.top+=c.collisionPosition.top<0?g+h+i:f>0?g+h+i:0}}},a.offset.setOffset||(a.offset.setOffset=function(b,c){/static/.test(a.curCSS(b,"position"))&&(b.style.position="relative");var d=a(b),e=d.offset(),f=parseInt(a.curCSS(b,"top",!0),10)||0,g=parseInt(a.curCSS(b,"left",!0),10)||0,h={top:c.top-e.top+f,left:c.left-e.left+g};"using"in c?c.using.call(b,h):d.css(h)},a.fn.offset=function(b){var c=this[0];return!c||!c.ownerDocument?null:b?a.isFunction(b)?this.each(function(c){a(this).offset(b.call(this,c,a(this).offset()))}):this.each(function(){a.offset.setOffset(this,b)}):h.call(this)}),a.curCSS||(a.curCSS=a.css),function(){var b=document.getElementsByTagName("body")[0],c=document.createElement("div"),d,e,g,h,i;d=document.createElement(b?"div":"body"),g={visibility:"hidden",width:0,height:0,border:0,margin:0,background:"none"},b&&a.extend(g,{position:"absolute",left:"-1000px",top:"-1000px"});for(var j in g)d.style[j]=g[j];d.appendChild(c),e=b||document.documentElement,e.insertBefore(d,e.firstChild),c.style.cssText="position: absolute; left: 10.7432222px; top: 10.432325px; height: 30px; width: 201px;",h=a(c).offset(function(a,b){return b}).offset(),d.innerHTML="",e.removeChild(d),i=h.top+h.left+(b?2e3:0),f.fractions=i>21&&i<22}()})(jQuery);

/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.autocomplete.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(a,b){var c=0;a.widget("ui.autocomplete",{options:{appendTo:"body",autoFocus:!1,delay:300,minLength:1,position:{my:"left top",at:"left bottom",collision:"none"},source:null},pending:0,_create:function(){var b=this,c=this.element[0].ownerDocument,d;this.isMultiLine=this.element.is("textarea"),this.element.addClass("ui-autocomplete-input").attr("autocomplete","off").attr({role:"textbox","aria-autocomplete":"list","aria-haspopup":"true"}).bind("keydown.autocomplete",function(c){if(b.options.disabled||b.element.propAttr("readOnly"))return;d=!1;var e=a.ui.keyCode;switch(c.keyCode){case e.PAGE_UP:b._move("previousPage",c);break;case e.PAGE_DOWN:b._move("nextPage",c);break;case e.UP:b._keyEvent("previous",c);break;case e.DOWN:b._keyEvent("next",c);break;case e.ENTER:case e.NUMPAD_ENTER:b.menu.active&&(d=!0,c.preventDefault());case e.TAB:if(!b.menu.active)return;b.menu.select(c);break;case e.ESCAPE:b.element.val(b.term),b.close(c);break;default:clearTimeout(b.searching),b.searching=setTimeout(function(){b.term!=b.element.val()&&(b.selectedItem=null,b.search(null,c))},b.options.delay)}}).bind("keypress.autocomplete",function(a){d&&(d=!1,a.preventDefault())}).bind("focus.autocomplete",function(){if(b.options.disabled)return;b.selectedItem=null,b.previous=b.element.val()}).bind("blur.autocomplete",function(a){if(b.options.disabled)return;clearTimeout(b.searching),b.closing=setTimeout(function(){b.close(a),b._change(a)},150)}),this._initSource(),this.menu=a("<ul></ul>").addClass("ui-autocomplete").appendTo(a(this.options.appendTo||"body",c)[0]).mousedown(function(c){var d=b.menu.element[0];a(c.target).closest(".ui-menu-item").length||setTimeout(function(){a(document).one("mousedown",function(c){c.target!==b.element[0]&&c.target!==d&&!a.ui.contains(d,c.target)&&b.close()})},1),setTimeout(function(){clearTimeout(b.closing)},13)}).menu({focus:function(a,c){var d=c.item.data("item.autocomplete");!1!==b._trigger("focus",a,{item:d})&&/^key/.test(a.originalEvent.type)&&b.element.val(d.value)},selected:function(a,d){var e=d.item.data("item.autocomplete"),f=b.previous;b.element[0]!==c.activeElement&&(b.element.focus(),b.previous=f,setTimeout(function(){b.previous=f,b.selectedItem=e},1)),!1!==b._trigger("select",a,{item:e})&&b.element.val(e.value),b.term=b.element.val(),b.close(a),b.selectedItem=e},blur:function(a,c){b.menu.element.is(":visible")&&b.element.val()!==b.term&&b.element.val(b.term)}}).zIndex(this.element.zIndex()+1).css({top:0,left:0}).hide().data("menu"),a.fn.bgiframe&&this.menu.element.bgiframe(),b.beforeunloadHandler=function(){b.element.removeAttr("autocomplete")},a(window).bind("beforeunload",b.beforeunloadHandler)},destroy:function(){this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete").removeAttr("role").removeAttr("aria-autocomplete").removeAttr("aria-haspopup"),this.menu.element.remove(),a(window).unbind("beforeunload",this.beforeunloadHandler),a.Widget.prototype.destroy.call(this)},_setOption:function(b,c){a.Widget.prototype._setOption.apply(this,arguments),b==="source"&&this._initSource(),b==="appendTo"&&this.menu.element.appendTo(a(c||"body",this.element[0].ownerDocument)[0]),b==="disabled"&&c&&this.xhr&&this.xhr.abort()},_initSource:function(){var b=this,c,d;a.isArray(this.options.source)?(c=this.options.source,this.source=function(b,d){d(a.ui.autocomplete.filter(c,b.term))}):typeof this.options.source=="string"?(d=this.options.source,this.source=function(c,e){b.xhr&&b.xhr.abort(),b.xhr=a.ajax({url:d,data:c,dataType:"json",success:function(a,b){e(a)},error:function(){e([])}})}):this.source=this.options.source},search:function(a,b){a=a!=null?a:this.element.val(),this.term=this.element.val();if(a.length<this.options.minLength)return this.close(b);clearTimeout(this.closing);if(this._trigger("search",b)===!1)return;return this._search(a)},_search:function(a){this.pending++,this.element.addClass("ui-autocomplete-loading"),this.source({term:a},this._response())},_response:function(){var a=this,b=++c;return function(d){b===c&&a.__response(d),a.pending--,a.pending||a.element.removeClass("ui-autocomplete-loading")}},__response:function(a){!this.options.disabled&&a&&a.length?(a=this._normalize(a),this._suggest(a),this._trigger("open")):this.close()},close:function(a){clearTimeout(this.closing),this.menu.element.is(":visible")&&(this.menu.element.hide(),this.menu.deactivate(),this._trigger("close",a))},_change:function(a){this.previous!==this.element.val()&&this._trigger("change",a,{item:this.selectedItem})},_normalize:function(b){return b.length&&b[0].label&&b[0].value?b:a.map(b,function(b){return typeof b=="string"?{label:b,value:b}:a.extend({label:b.label||b.value,value:b.value||b.label},b)})},_suggest:function(b){var c=this.menu.element.empty().zIndex(this.element.zIndex()+1);this._renderMenu(c,b),this.menu.deactivate(),this.menu.refresh(),c.show(),this._resizeMenu(),c.position(a.extend({of:this.element},this.options.position)),this.options.autoFocus&&this.menu.next(new a.Event("mouseover"))},_resizeMenu:function(){var a=this.menu.element;a.outerWidth(Math.max(a.width("").outerWidth()+1,this.element.outerWidth()))},_renderMenu:function(b,c){var d=this;a.each(c,function(a,c){d._renderItem(b,c)})},_renderItem:function(b,c){return a("<li></li>").data("item.autocomplete",c).append(a("<a></a>").text(c.label)).appendTo(b)},_move:function(a,b){if(!this.menu.element.is(":visible")){this.search(null,b);return}if(this.menu.first()&&/^previous/.test(a)||this.menu.last()&&/^next/.test(a)){this.element.val(this.term),this.menu.deactivate();return}this.menu[a](b)},widget:function(){return this.menu.element},_keyEvent:function(a,b){if(!this.isMultiLine||this.menu.element.is(":visible"))this._move(a,b),b.preventDefault()}}),a.extend(a.ui.autocomplete,{escapeRegex:function(a){return a.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")},filter:function(b,c){var d=new RegExp(a.ui.autocomplete.escapeRegex(c),"i");return a.grep(b,function(a){return d.test(a.label||a.value||a)})}})})(jQuery),function(a){a.widget("ui.menu",{_create:function(){var b=this;this.element.addClass("ui-menu ui-widget ui-widget-content ui-corner-all").attr({role:"listbox","aria-activedescendant":"ui-active-menuitem"}).click(function(c){if(!a(c.target).closest(".ui-menu-item a").length)return;c.preventDefault(),b.select(c)}),this.refresh()},refresh:function(){var b=this,c=this.element.children("li:not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role","menuitem");c.children("a").addClass("ui-corner-all").attr("tabindex",-1).mouseenter(function(c){b.activate(c,a(this).parent())}).mouseleave(function(){b.deactivate()})},activate:function(a,b){this.deactivate();if(this.hasScroll()){var c=b.offset().top-this.element.offset().top,d=this.element.scrollTop(),e=this.element.height();c<0?this.element.scrollTop(d+c):c>=e&&this.element.scrollTop(d+c-e+b.height())}this.active=b.eq(0).children("a").addClass("ui-state-hover").attr("id","ui-active-menuitem").end(),this._trigger("focus",a,{item:b})},deactivate:function(){if(!this.active)return;this.active.children("a").removeClass("ui-state-hover").removeAttr("id"),this._trigger("blur"),this.active=null},next:function(a){this.move("next",".ui-menu-item:first",a)},previous:function(a){this.move("prev",".ui-menu-item:last",a)},first:function(){return this.active&&!this.active.prevAll(".ui-menu-item").length},last:function(){return this.active&&!this.active.nextAll(".ui-menu-item").length},move:function(a,b,c){if(!this.active){this.activate(c,this.element.children(b));return}var d=this.active[a+"All"](".ui-menu-item").eq(0);d.length?this.activate(c,d):this.activate(c,this.element.children(b))},nextPage:function(b){if(this.hasScroll()){if(!this.active||this.last()){this.activate(b,this.element.children(".ui-menu-item:first"));return}var c=this.active.offset().top,d=this.element.height(),e=this.element.children(".ui-menu-item").filter(function(){var b=a(this).offset().top-c-d+a(this).height();return b<10&&b>-10});e.length||(e=this.element.children(".ui-menu-item:last")),this.activate(b,e)}else this.activate(b,this.element.children(".ui-menu-item").filter(!this.active||this.last()?":first":":last"))},previousPage:function(b){if(this.hasScroll()){if(!this.active||this.first()){this.activate(b,this.element.children(".ui-menu-item:last"));return}var c=this.active.offset().top,d=this.element.height(),e=this.element.children(".ui-menu-item").filter(function(){var b=a(this).offset().top-c+d-a(this).height();return b<10&&b>-10});e.length||(e=this.element.children(".ui-menu-item:first")),this.activate(b,e)}else this.activate(b,this.element.children(".ui-menu-item").filter(!this.active||this.first()?":last":":first"))},hasScroll:function(){return this.element.height()<this.element[a.fn.prop?"prop":"attr"]("scrollHeight")},select:function(a){this._trigger("selected",a,{item:this.active})}})}(jQuery);

<head>
<title>Info Artikel</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-site-verification" content=""/>
<meta name="description" content="Info Artikel" />
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index,nofollow"/> 
<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/font-awesome.css');?>">
<link href="<?php echo base_url();?>assets/theme/v1/css/responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/manage/js/autoCom/jquery.autocomplete.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-3.1.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-1.10.2.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/manage/js/autoCom/jquery.autocomplete.js')?>"></script>
<!-- Facebook Pixel Code --> 
<script>
//<![CDATA[
shortcut={all_shortcuts:{},add:function(a,b,c){var d={type:"keydown",propagate:!1,disable_in_input:!1,target:document,keycode:!1};if(c)for(var e in d)"undefined"==typeof c[e]&&(c[e]=d[e]);else c=d;d=c.target,"string"==typeof c.target&&(d=document.getElementById(c.target)),a=a.toLowerCase(),e=function(d){d=d||window.event;if(c.disable_in_input){var e;d.target?e=d.target:d.srcElement&&(e=d.srcElement),3==e.nodeType&&(e=e.parentNode);if("INPUT"==e.tagName||"TEXTAREA"==e.tagName)return}d.keyCode?code=d.keyCode:d.which&&(code=d.which),e=String.fromCharCode(code).toLowerCase(),188==code&&(e=","),190==code&&(e=".");var f=a.split("+"),g=0,h={"`":"~",1:"!",2:"@",3:"#",4:"$",5:"%",6:"^",7:"&",8:"*",9:"(",0:")","-":"_","=":"+",";":":","'":'"',",":"<",".":">","/":"?","\\":"|"},i={esc:27,escape:27,tab:9,space:32,"return":13,enter:13,backspace:8,scrolllock:145,scroll_lock:145,scroll:145,capslock:20,caps_lock:20,caps:20,numlock:144,num_lock:144,num:144,pause:19,"break":19,insert:45,home:36,"delete":46,end:35,pageup:33,page_up:33,pu:33,pagedown:34,page_down:34,pd:34,left:37,up:38,right:39,down:40,f1:112,f2:113,f3:114,f4:115,f5:116,f6:117,f7:118,f8:119,f9:120,f10:121,f11:122,f12:123},j=!1,l=!1,m=!1,n=!1,o=!1,p=!1,q=!1,r=!1;d.ctrlKey&&(n=!0),d.shiftKey&&(l=!0),d.altKey&&(p=!0),d.metaKey&&(r=!0);for(var s=0;k=f[s],s<f.length;s++)"ctrl"==k||"control"==k?(g++,m=!0):"shift"==k?(g++,j=!0):"alt"==k?(g++,o=!0):"meta"==k?(g++,q=!0):1<k.length?i[k]==code&&g++:c.keycode?c.keycode==code&&g++:e==k?g++:h[e]&&d.shiftKey&&(e=h[e],e==k&&g++);if(g==f.length&&n==m&&l==j&&p==o&&r==q&&(b(d),!c.propagate))return d.cancelBubble=!0,d.returnValue=!1,d.stopPropagation&&(d.stopPropagation(),d.preventDefault()),!1},this.all_shortcuts[a]={callback:e,target:d,event:c.type},d.addEventListener?d.addEventListener(c.type,e,!1):d.attachEvent?d.attachEvent("on"+c.type,e):d["on"+c.type]=e},remove:function(a){var a=a.toLowerCase(),b=this.all_shortcuts[a];delete this.all_shortcuts[a];if(b){var a=b.event,c=b.target,b=b.callback;c.detachEvent?c.detachEvent("on"+a,b):c.removeEventListener?c.removeEventListener(a,b,!1):c["on"+a]=!1}}},shortcut.add("Ctrl+U",function(){top.location.href="<?php echo base_url();?>"});
//]]>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1472453182816875');
  fbq('track', 'PageView');

//<![CDATA[
function redirectKK(e) {
  if (e.which == 3) {
   return false;
  }
}
document.oncontextmenu = redirectKK;
//]]>
$(function(){
    // POTONG window.location.pathname.split SAAT UPLOAD DI SERVER window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/'
    var baseURL = window.location.origin + '/';
      $('.seacrhart').autocomplete({
          serviceUrl: baseURL + 'searchartinfo',
          onSelect: function (res) {
              $('#artikel').val(''+res.artikel); 
          }
      });
  });
function cekStokbyrims(){
    var baseURL = window.location.origin + '/';
    var k = $("#art").val();
    var csrf = Cookies.get('mfh83ujd7oo');
    if(k == ""){
        alert("Isi Kode Artikel Terlebih Dahulu");
    }else{
        $(".menuss").slideUp('fast');
        $("#table_produkx").slideUp('fast');
        $(".resultcekstok").slideDown();
        $.ajax({
            type: 'POST',
            url: baseURL + 'cekartbyrims',
            data:'&getinvdata='+k+'&fscurepro21=' + csrf,
            beforeSend: function () {
                $(".resultcekstok").html('Sedang memuat data. silahkan tunggu.');
            },
            success: function (html) {
                $(".resultcekstok").html(html);
            }
        });
    }
}
function closecekStok(){
	$(".resultcekstok").html('');
	$(".resultcekstok").slideUp();
}
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<style type="text/css">
	.label.label-default {
	    background: #fff;
	    border: 1px solid #e5e5e5;
	    color: #333;
	}
	.input-group{
		position: relative;
	    display: table;
	    border-collapse: separate;
	}
	.input-group-addon, .input-group-btn, .input-group .form-control {
    	display: table-cell;
	}
	.input-group .form-control {
	    position: relative;
	    z-index: 2;
	    float: left;
	    width: 100%;
	    margin-bottom: 0;
	}
	.input-group-btn > .btn {
	    position: relative;
	}
	.input-group-btn {
	    position: relative;
	    font-size: 0;
	    white-space: nowrap;
	    width: 1%;
    	white-space: nowrap;
    	vertical-align: middle;
	}
	.hj {
	    padding-top: 8px !important;
	    padding-bottom: 10px !important;
	}
	.alignbtn{
		text-align:center;
	}
	@media (min-width: 100px) and (max-width: 991px) {
		.alignbtn{
			text-align:left;
		}
	}
	.alignbtn a:hover{
		border:inherit;
	}
</style>
</head>
<body style="background-color: #f5f5f5;">
<div class="bg-parallax-1" style="background-color: #f5f5f5;">
	<div class="container product-content text-center" style="margin-bottom:20px;margin-top: 25px;">
		<div class="col-md-3 col-xs-12"></div>
		<div class="col-md-6 col-xs-12">
			<a href="<?php echo base_url();?>">
			<?php $get_data_setting = for_header_front_end();?>
				<?php foreach($get_data_setting as $data):?>
				<div class="text-center">
					<img class="lazy" src="<?php echo base_url('assets/images/');?><?php echo $data->konten;?>" style="width:150px;display: initial;">
				</div>
			<?php endforeach;?>
			</a>
			<h5 style="margin-bottom: 30px;">Cek Info Artikel</h5>			
			<div class="input-group">
				<input class="" type="hidden" name="sess_mail" id="session_token" value="<?php $a=$this->encrypt->encode('lh743hG82#19'); $b=base64_encode($a); echo $b?>">
		        <input type="text" name="artprocess" class="form-control list-form seacrhart arthd" id="art"  placeholder="Kode Artikel" required>
            	<span class="input-group-btn">
            		<button class="btn btn-danger mail_sb hj cek_stok" style="border:1px solid black;color:black;" onclick="cekStokbyrims();">Cek Artikel</button>
            	</span>
            </div>
			<div class="col-md-12 col-xs-12 info-success"><?php echo $this->session->flashdata('berhasil');?></div>
			<div class="col-md-12 col-xs-12 info-error"><?php echo $this->session->flashdata('error');?></div>
		</div>
		<div class="col-md-3 col-xs-12"></div>
		<div class="col-md-12 col-xs-12">
	      	<div class="resultcekstok" style="display: none;text-align:center;background-color:white;padding: 15px;margin-top: 20px;margin-bottom: 20px;"></div>
	    	</div>
	</div>
</div>
<script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/JQuery.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/js.cookie.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/')?>s497sd_09.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/global/autoCom/jquery.autocomplete.js')?>"></script>
</body>
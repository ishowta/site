<?php
// DB
require_once('lib/utils.php');
$dbh = openDB();

// ログ
include('log.php');

// スマホ判定
function _ua(){
	$ua=$_SERVER['HTTP_USER_AGENT'];
	if((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false)) {
		return true;
	}
	return false;
}

/**
* App class
*/
class App
{
	public $name;
	public $title;
	public $data;
	public $width;
	public $height;
	public $priority;
	function __construct($name, $title, $data, $width = 1, $height = 1, $priority = 999)
	{
		$this->data = $data;
		$this->title = $title;
		$this->width = $width;
		$this->height = $height;
		$this->name = $name;
		$this->priority = $priority;
	}
}

function cmpApp($lhs, $rhs){
	return $lhs->priority > $rhs->priority;
}


// アプリの登録
$app_list = array();
$app_root_dir = 'apps';
$dh = opendir($app_root_dir);
while(($pathname = readdir($dh)) !== false){
	if( $pathname !== '.' &&
		$pathname !== '..' &&
		is_dir($app_root_dir.'/'.$pathname)
	){
		$ini_path = "$app_root_dir/$pathname/metadata.ini";
		$data_path = "$app_root_dir/$pathname/$pathname.php";
		$metadata = parse_ini_file($ini_path);
		$app_list[] = new App(
			$metadata['name'],
			$metadata['title'],
			$data_path,
			$metadata['width'],
			$metadata['height'],
			$metadata['priority']
		);
	}
}
usort($app_list,"cmpApp");

// Get
$mode = 'normal';
$mode_selected_app_name = '';
$mode_app_id = -1;

if(isset($_GET['app'])){
	$mode = 'app';
	$mode_selected_app_name = htmlspecialchars($_GET['app']);
	// ファイルがあれば飛ぶ
	if(file_exists("apps/$mode_selected_app_name/index.php")){
		header("Location:apps/$mode_selected_app_name/");
		exit();
	}
	for ($i=0; $i < count($app_list); $i++)
		if($app_list[$i]->name !== $mode_selected_app_name) $mode_app_id = $i;
	if($mode_app_id === -1) exit();
}
if(isset($_GET['pickup'])){
	$mode = 'pickup';
	$mode_selected_app_name = htmlspecialchars($_GET['pickup']);
	for ($i=0; $i < count($app_list); $i++)
		if($app_list[$i]->name === $mode_selected_app_name) $mode_app_id = $i;
	if($mode_app_id === -1) exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="http://8oti.com">
<meta name="twitter:text:description" content="8oti">
<meta property="og:title" content="<?php
	echo $mode == 'app' || $mode == 'pickup' ?
		$mode_selected_app_name : '8oti';
?>" />
<meta name="twitter:image" content="<?php
	$server_name = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER['HTTP_HOST'];
	$default_fn = $server_name.'/default_thumbnail.png';
	if($mode == 'app' || $mode == 'pickup'){
		$local_fn = 'apps/'.$mode_selected_app_name.'/thumbnail.png';
		$fn = $server_name.'/'.$local_fn;
		echo file_exists($local_fn)? $fn : $default_fn;
	}else echo $default_fn;

?>">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.6.0/socket.io.min.js"></script>
		<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<title>8oti</title>
		<script>
			var _ua = (function(u){
				return {
				Tablet:(u.indexOf("windows") != -1 && u.indexOf("touch") != -1 && u.indexOf("tablet pc") == -1)
					|| u.indexOf("ipad") != -1
					|| (u.indexOf("android") != -1 && u.indexOf("mobile") == -1)
					|| (u.indexOf("firefox") != -1 && u.indexOf("tablet") != -1)
					|| u.indexOf("kindle") != -1
					|| u.indexOf("silk") != -1
					|| u.indexOf("playbook") != -1,
				Mobile:(u.indexOf("windows") != -1 && u.indexOf("phone") != -1)
					|| u.indexOf("iphone") != -1
					|| u.indexOf("ipod") != -1
					|| (u.indexOf("android") != -1 && u.indexOf("mobile") != -1)
					|| (u.indexOf("firefox") != -1 && u.indexOf("mobile") != -1)
					|| u.indexOf("blackberry") != -1
				}
			})(window.navigator.userAgent.toLowerCase());

			// Appを前面表示するpickup関数
			var pickup = function(app_number){
				if($('.app'+app_number).css('position') == 'absolute'){
					// pickupする
					// スクショ
					html2canvas($('.app'+app_number), { onrendered: function(canvas) {
						var imgData = canvas.toDataURL();
						// Appのスクショの座標合わせ
						$('#pickup-backscreen').css('left', $('.app'+app_number).css('left'));
						$('#pickup-backscreen').css('top', $('.app'+app_number).css('top'));
						$('#pickup-backscreen').css('margin', $('.app'+app_number).css('margin'));
						// スクショを貼り付ける
						$('#pickup-backscreen-img')[0].src = imgData;
						// バックグラウンドを表示
						$('.pickup-area-bg').css('display', 'block');
						var left = ($(window).width()/2) - $('.app'+app_number).css('width').replace('px','')/2 - 5;
						var top = ($(window).height()/2) - $('.app'+app_number).css('height').replace('px','')/2 - 5;
						if(top < 5) top = 5;
						if(left < 5) left = 5;
						$('.pickup-area').css('left', left);
						$('.pickup-area').css('top', top);
						if(_ua.Mobile){
							$('.pickup-area').css('position', 'absolute');
						}
						// ピックアップしたAppの座標合わせ
						$('.app'+app_number).css('left', '0px');
						$('.app'+app_number).css('top', '0px');
						$('.app'+app_number).css('position', 'relative');
						// appをpickup-areaの中に移動
						$('.app'+app_number).appendTo('.pickup-area');
					}});
				}else{
					// pickupを元に戻す
					// appを移動
					$('.pickup-area .app').appendTo('.body');
					// Appの座標復元
					$('.app'+app_number).css('left', $('#pickup-backscreen').css('left'));
					$('.app'+app_number).css('top', $('#pickup-backscreen').css('top'));
					$('.app'+app_number).css('position', 'absolute');
					$('.app'+app_number).css('z-index', 'auto');
					// バックグラウンドを非表示
					$('.pickup-area-bg').css('display', 'none');
					// スクショを消す
					$('#pickup-backscreen-img')[0].src = '';
				}
			};
		</script>
	</head>
	<body>
		<div id="loader-bg" style="z-index: 100">
			<div id="loader">
				<div class="sk-folding-cube">
					<div class="sk-cube1 sk-cube"></div>
					<div class="sk-cube2 sk-cube"></div>
					<div class="sk-cube4 sk-cube"></div>
					<div class="sk-cube3 sk-cube"></div>
				</div>
			</div>
		</div>
		<div class="header">
			<p class="header_title">
				<a href="/">8oti</a>
				<button id="logout_button" onclick="location.href='logout.php'">logout</button>
			</p>
		</div>
		<a href="forkmeongithub.php"><img style="position: absolute; top: 0; left: 0; border: 0; z-index: 2;" src="https://camo.githubusercontent.com/82b228a3648bf44fc1163ef44c62fcc60081495e/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f6c6566745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_left_red_aa0000.png"></a>
		<div class="body">
			<?php
			for ($i=0; $i < count($app_list); $i++) {
				if($mode === 'app'){
					if($app_list[$i]->name !== $mode_selected_app_name) continue;
					else $mode_app_id = $i;
				}
			?>
				<div class="app app<?php echo $i;?>">
					<div class=app_header>
						<div class="app_header_maximize">
							<button class="app_header_maximizebutton" onclick="window.open(<?php echo '\'./?app='.$app_list[$i]->name.'\'';?>)">
								<div class="fa fa-window-maximize" aria-hidden="true"></div>
							</button>
						</div>
						<div class="app_header_pickup">
							<button class="app_header_pickupbutton" onclick="pickup(<?php echo $i;?>)">
								<div class="fa fa-window-restore" aria-hidden="true"></div>
							</button>
						</div>
						<div class=app_header_title>
							<?php echo $app_list[$i]->title; ?>
						</div>
					</div>
					<div class="app_body <?php if($mode === 'app') echo 'app-own'; ?>" id="app-<?php echo $app_list[$i]->name;?>">
						<?php include($app_list[$i]->data); ?>
					</div>
				</div>
			<?php } ?>
			<div class="shadow-body"></div>
			<div id="pickup-backscreen">
				<img id="pickup-backscreen-img">
			</div>
			<div class="pickup-area-bg">
				<div class="pickup-area">
				</div>
			</div>
		</div>
		<div class="footer">
		</div>
	</body>
	<script type="text/javascript">
		// アプリの位置決定
		$(function(){
			var header_height = 50;

			//PHPのapp_listをコピー
			var app_list = [];
			<?php
			for ($i=0; $i < count($app_list); $i++) {
				echo "app_list[$i] = new Object();";
				foreach ($app_list[$i] as $key => $value) {
					echo "app_list[$i].$key = \"".$value."\";";
				}
			}
			?>

			// pickupと最大化ボタンの位置を調整する
			$('.app').each(function(app_cnt){
				if(app_list[app_cnt].width == 1){
					$(this).find('.app_header_pickup').css('width','93%');
					$(this).find('.app_header_maximize').css('width','98%');
				}
			});

			if(<?php echo $mode === 'app' ? 'true' : 'false';?> == true){
				// ヘッダとフッタのmarginを消す
				$('.header').css('margin-bottom','0px');
				$('.footer').css('margin-top','0px');
				// Appを中央に配置
				$('.app').css('position','relative');
			}else{
				// Appを配置していく
				var app_columns = Math.floor($(window).width() / 475);
				var appmap = new Array(app_columns+3); //ji座標がAppで埋められているか(縦は可変)
				for(i=0;i<app_columns+3;i++){
					appmap[i] = new Array(0);
				}
				$('.app').each(function(app_cnt){
					// x,yを決める
					var x = 0;
					var y = 0;
					(function(){
						var canPlaceApp = function(st_x, st_y){
							for(var dy=0;dy<app_list[app_cnt].height;dy++){
								// 新しい行なら新しい行を生成する
								if(st_y+dy == appmap[0].length){
									for(var dx=0;dx<app_columns+3;dx++) appmap[dx][st_y+dy] = false;
								}
								for(var dx=0;dx<app_list[app_cnt].width;dx++){
									if(st_x+dx >= app_columns || appmap[st_x+dx][st_y+dy] == true){
										if(app_columns == 1 && dx == 1) return true;
										return false;
									}
								}
							}
							return true;
						};
						for(var dy=0;;dy++){
							for(var dx=0;dx<app_columns;dx++){
								if(canPlaceApp(dx, dy)){
									x = dx;
									y = dy;
									return;
								}
							}
						}
					})();
					// 大きさ分appmapを埋める
					for(dy=0;dy<app_list[app_cnt].height;dy++){
						/*if(y+dy == appmap[0].length){
							for(dx=0;dx<app_columns;dx++) appmap[dx][y+dy] = false;
						}*/
						for(dx=0;dx<app_list[app_cnt].width;dx++){
							appmap[x+dx][y+dy] = true;
						}
					}
					// 実際に配置する
					$(this).css('left', (0+x*475)+'px');
					$(this).css('top', (header_height+y*340)+'px');
					$(this).css('width', ((app_list[app_cnt].width-1)*475+460)+'px');
					$(this).css('height', ((app_list[app_cnt].height-1)*340+320)+'px');
					$(this).find('.app_body').css('height', ((app_list[app_cnt].height-1)*340+320-25)+'px');
				});

				// アプリ分のbodyを確保
				$('.shadow-body').css('width','100%');
				$('.shadow-body').css('height',(appmap[0].length)*340);
			}
			if(<?php echo $mode === 'pickup' ? 'true' : 'false';?> == true){
				pickup(<?php echo $mode_app_id; ?>);
			}
		});
	</script>
	<script>
		$('#loader-bg').delay(0).fadeOut(0);
		$('#loader').delay(0).fadeOut(0);
	</script>
	<script>
		// color-picker

		// 名前、背景、Appの背景、Appのヘッダ
		var color_set_list = [
		['red-dark',	'#1d1d1d','#353535','#c74545'],
		['blue-white',	'#1d1d1d','#ffffff','#45a3c7'],
		['simple',		'#ffffff','#ffffff','#12303e'],
		['','#FEFAEC','#625772','#A9EEE6']
		];

		function switchColor(color_set){
			$(document.body).css('background-color', color_set[1]);
			$('.app').css('background-color', color_set[2]);
			$('.app_header').css('background-color', color_set[3]);
		}

		switchColor(color_set_list[2]);
	</script>
</html>

<div>
	<script type="text/javascript" src="apps/anisonradio/jwplayer.js"></script>
	<a href="" class="song-title" target="_blank">Loading the server...</a>
	<div class="song-jacket-wrapper">
		<img src="" alt="Loading the server..." class="song-jacket">
		<?php if(_ua()){?>
			<button id="anisonradio-playbutton">
				<img src="/apps/anisonradio/play.png">
			</button>
		<?php } ?>
	</div>
	<a href="https://www.animenfo.com/radio" target="_blank" class="detail"> https://www.animenfo.com/radio </a>
	<div id="anisonradio-mediaplayer"></div>
	<?php if(_ua()){ ?>
		<audio id="anisonradio-audio" title="" src="http://itori.animenfo.com:443/;"></audio>
	<?php } ?>
	<div class="container" ></div>
	<script>
		jwplayer('anisonradio-mediaplayer').setup({
			'flashplayer': 'apps/anisonradio/player.swf',
			'streamer' :'rtmp://rtmp1.surfmusik.de/shoutcast',
			'file': 'http://itori.animenfo.com:443/;',
			'controlbar': 'top',
			'width' : '460',
			'height' : '24',
		});
		// 自動再生
		//jwplayer("mediaplayer").play();
		$(window).on('load',function(){
			// 再生ボタン
			$('#anisonradio-playbutton').on('click',function(){
				$('#anisonradio-playbutton').css('display','none');
				$('#anisonradio-audio')[0].play();
			});
			var challenge = function(){
				$.ajax({
					url: 'apps/anisonradio/gettitle.php',
					type: 'GET',
					success: function(data) {
						if($('#app-anisonradio').find('.song-title').text() != data){
							// 曲が変わったのでジャケットを更新
							$.ajax({
								url: 'apps/anisonradio/getjacket.php',
								type: 'GET',
								success: function(data) {
									$('#app-anisonradio').find('.song-jacket').attr('src',data);
								}
							});
							// タイトルを変更
							var title = data;
							var url_title = title.replace(/ \(.*\)$/, '');
							$('#app-anisonradio').find('.song-title').attr('href','https://www.google.co.jp/search?q='+url_title);
							$('#app-anisonradio').find('.song-title').text(title);
							<?php if(_ua()) echo '
							$(\'#anisonradio-audio\').attr(\'title\',title);
							$(\'#anisonradio-audio\')[0].pause();
							$(\'#anisonradio-audio\')[0].play();
							'; ?>
						}
					}
				});
			};
			// 5秒ごとにタイトルをリロードする
			setInterval(function(){
				if(<?php if(_ua()) echo '!$(\'#anisonradio-audio\')[0].paused || '; ?>jwplayer('anisonradio-mediaplayer').getState() == 'PLAYING'){
					challenge();
				}
			},5000);
			challenge();
	});
	</script>
	<style>
		#app-anisonradio {
			overflow: hidden;
		}
		#app-anisonradio .song-jacket {
			width: <?php echo _ua()? '265': '242'; ?>px;
			height: <?php echo _ua()? '265': '242'; ?>px;
		}
		#app-anisonradio .song-jacket-wrapper {
			background-color: #eee;
			position: relative;
			text-align: center;
			width: <?php echo _ua()? '265': '242'; ?>px;
			height: <?php echo _ua()? '265': '242'; ?>px;
			margin: auto;
		}
		#anisonradio-playbutton{
		    border: 0;
		    background-color: rgba(0,0,0,0);
		    position: absolute;
		    left: 0;
		    right: 0;
		    top: 0;
		    bottom: 0;
		    margin: auto;
		}
		#app-anisonradio .song-title {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
			text-align: center;
			display: block;
		}
		#app-anisonradio .detail {
			font-size: 3px;
			text-align: center;
			display: block;
		}
	</style>
</div>

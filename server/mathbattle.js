//'use strict';

var problems = {
'数列と級数':
{
'0101011001':'数列の極限 (等比数列)',
'0101011006':'数列の極限 (等比数列と n^a)',
'0101011011':'数列の極限 (等比数列と階乗)',
'0101011016':'数列の極限 (等比/階乗の和の比)',
'0101011021':'数列の極限 (n^n)',
'0101011031':'数列の極限 (はさみうち)',
'0101011041':'数列の極限 (ネピアの定数)',
'0101011046':'数列の極限 (ネピアの定数-2)',
'0101011051':'数列の極限 (ネピアの定数-3)',
'0101011081':'数列の極限 (漸化式)',
'0101011086':'数列の極限 (漸化式-2)',
'0101021001':'級数の和 (部分分数)',
'0101021011':'級数の和 (多項式x等比数列)',
'0101021021':'級数の和 (無理式)',
'0101021031':'級数の和 (階差型)',
'0101021041':'級数の収束・発散 (比較判定法)',
'0101021051':'級数の収束・発散 (比較判定法-2)',
'0101021061':'級数の収束・発散 (極限による判定法)',
'0101021071':'級数の収束・発散 (極限による判定法-2)',
},
'関数と極限':
{
'0101031001':'逆三角関数関数の定義と値',
'0101031006':'逆三角関数の値と加法定理',
'0101031011':'その他の関数の値',
'0101031016':'関数の極限 (基礎編)',
'0101031021':'関数の極限 (はさみうちの原理)',
'0101031026':'関数の極限 (指数対数・∞での挙動)',
'0101031031':'関数の極限 (指数対数・0での挙動)',
'0101031036':'関数の極限 (指数対数・総合)',
'0101031041':'関数の極限 (指数対数・1/x乗)',
'0101031046':'関数の極限 (ネピアの定数)',
'0101031051':'関数の極限 (三角関数・0での挙動)',
'0101031056':'関数の極限 ((e^x-1)/x の極限)',
'0101031061':'関数の極限 (逆三角関数)',
'0101031066':'関数の極限 (双曲線関数)',
'0101031071':'ランダウの記号 (1)',
'0101031076':'ランダウの記号 (2)',
'0101031081':'無限小・無限大の位数 (x-&gt;0)',
'0101031086':'無限小・無限大の位数 (x-&gt;0) (2)',
'0101031091':'無限小・無限大の位数 (x-&gt;0) (3)',
'0101031096':'無限小・無限大の位数 (x-&gt;∞)',
},
'微分':
{
'0101041001':'関数の連続性',
'0101041021':'関数の微分可能性',
'0101051001':'微分法 (基礎編)',
'0101051011':'微分法 (合成関数)',
'0101051021':'逆関数の微分法',
'0101051031':'対数微分法',
'0101051041':'パラメータ表示された関数の微分',
'0101051061':'高階導関数',
'0101061011':'マクローリンの定理 (1)',
'0101061016':'マクローリンの定理 (2)',
'0101061021':'近似計算(1)',
'0101061026':'近似計算(2)',
'0101061031':'不定形の極限 (ロピタルの定理)',
'0101061036':'不定形の極限 (ロピタルの定理-2)',
'0101061041':'不定形の極限 (ロピタルの定理への帰着)',
'0101061046':'不定形の極限 (位数でまとめる)',
'0101061051':'不定形の極限 (f(x)^g(x)型)',
'0101061061':'不定形の極限 (マクローリンの定理の利用)',
'0101061071':'収束半径 基礎編 (1)',
'0101061076':'収束半径 基礎編 (2)',
'0101061081':'収束半径 応用編'
},
'積分':
{
'0101071006':'リーマン和と極限',
'0101071011':'リーマン和と極限 (2)',
'0101071016':'不定積分 (初等関数)',
'0101071021':'不定積分 (部分積分)',
'0101071026':'不定積分 (置換積分)',
'0101071031':'不定積分 (有理関数)',
'0101071036':'不定積分 (有理関数-2)',
'0101071041':'不定積分 (有理関数-3)',
'0101071046':'不定積分 (有理関数-4)',
'0101071051':'不定積分 (有理関数-5)',
'0101071056':'不定積分 (有理関数-6)',
'0101071061':'不定積分 (三角関数)',
'0101071066':'不定積分 (三角関数-2)',
'0101071071':'不定積分 (三角関数-3)',
'0101071076':'不定積分 (無理関数)',
'0101071078':'不定積分 (無理関数-2)',
'0101071081':'定積分 (三角関数)',
'0101071086':'定積分 (三角関数-2)',
'0101071091':'定積分 (三角関数-3)',
'0101071096':'定積分 (無理関数)',
'0101081001':'広義積分 (定義と計算)',
'0101081006':'広義積分 (定義と計算-2)',
'0101081041':'広義積分の収束発散',
'0101081051':'広義積分の収束発散 (2)',
'0102051011':'二重積分 (1)',
'0102051021':'二重積分 (2)',
'0102061020':'三重積分(1)',
'0102061030':'三重積分(2)',
'0102081001':'重積分を用いた体積・表面積の計算',
},
'偏微分':
{
'0102011001':'2変数の関数の極限 (1)',
'0102011006':'2変数の関数の極限 (2)',
'0102011031':'2変数の関数の連続性 (1)',
'0102011036':'2変数の関数の連続性 (2)',
'0102021011':'2変数関数の偏微分 (1)',
'0102021016':'2変数関数の偏微分 (2)',
'0102021031':'3変数関数の偏微分 (1)',
'0102021036':'3変数関数の偏微分 (2)',
'0102021111':'2変数関数の偏導関数 (1)',
'0102021116':'2変数関数の偏導関数 (2)',
'0102021131':'3変数関数の偏導関数 (1)',
'0102021151':'2変数関数の全微分',
'0102021171':'2変数関数の方向微分',
'0102021191':'2変数関数の高階偏導関数',
'0102021211':'2変数の合成関数の微分 (1)',
'0102021221':'2変数の合成関数の微分 (2)',
'0102021251':'変数変換とヤコビアン(1)',
'0102021261':'変数変換とヤコビアン(2)',
'0102031011':'テイラーの定理',
'0102031030':'陰関数の微分(2)',
'0102031040':'陰関数の微分(3)',
},
'ベクトルの基礎と一次変換':
{
'0203051001':'ベクトルの内積(1)',
'0203051006':'ベクトルの内積(2)',
'0203051011':'ベクトルの内積(3)',
'0203051016':'ベクトルの長さ(1)',
'0203051021':'ベクトルの長さ(2)',
'0203051026':'ベクトルの長さ(3)',
'0203051031':'ベクトルの直交性(1)',
'0203051036':'ベクトルの直交性(2)',
'0203051041':'ベクトルの直交性(3)',
'0203051046':'シュミットの直交化法(1)',
'0203051051':'シュミットの直交化法(2)',
'0203051056':'直交補空間(1)',
'0203051061':'直交補空間(2)',
'0201011041':'空間ベクトルの内積',
'0201011001':'直線の方程式(1)',
'0201011046':'空間ベクトルの長さ',
'0201011051':'空間ベクトルの直交性',
'0201011006':'平面のベクトル方程式',
'0201011031':'平面の方程式とパラメータ表示(2)',
'0201011036':'２平面の交線',
'0201011011':'平面の方程式(1)',
'0201011016':'平面の方程式(2)',
'0201011021':'平面の方程式(3)',
'0201011026':'平面の方程式とパラメータ表示(1)',
'0201021001':'１次変換を表す行列',
'0201021006':'正射影',
'0201021011':'対称変換',
'0201021016':'回転変換',
'0201021021':'１次変換の像',
'0201031001':'１次変換を表す行列',
'0201031006':'直線への正射影',
'0201031011':'平面への正射影',
'0201031016':'直線に関する対称変換',
'0201031021':'平面に関する対称変換',
'0201031026':'１次変換の像',
},
'行列':
{
'0202011001':'行列の積(1)',
'0202011003':'行列の積(2)',
'0202011004':'行列の積(3)',
'0202011006':'行列の積(4)',
'0202011011':'行列のべき乗',
'0202021001':'行に関する基本変形',
'0202021006':'列に関する基本変形',
'0202021011':'基本変形と基本行列(1)',
'0202021016':'基本変形と基本行列(2)',
'0202021021':'列に関する掃き出し',
'0202021026':'行に関する掃き出し',
'0202021031':'行に関する階段行列',
'0202021036':'列に関する階段行列',
'0202021041':'行列の階数',
'0202021051':'逆行列',
'0202021056':'被約階段行列',
'0202031001':'連立１次方程式(初歩)',
'0202031006':'連立１次方程式(3元)',
'0202031011':'連立１次方程式(4元)',
'0202031016':'連立１次方程式(5元)',
'0202031021':'斉次連立１次方程式(3元)',
'0202031026':'斉次連立１次方程式(4元)',
'0202041001':'行列式(初歩)',
'0202041006':'行列式(3次)',
'0202041011':'行列式(4次)',
'0202041016':'行列式(5次)',
'0202041021':'行列式の展開(1)',
'0202041025':'行列式の展開(2)',
'0202041031':'行列式(文字入)',
'0202041036':'行列式(関数成分)',
'0203061001':'固有多項式(1)',
'0203061006':'固有多項式(2)',
'0203061011':'固有値と固有空間(1)',
'0203061016':'固有値と固有空間(2)',
'0203061021':'行列の対角化(1)',
'0203061026':'行列の対角化(2)',
'0203061031':'行列の対角化(3)',
'0203061036':'実対称行列の対角化(1)',
'0203061041':'実対称行列の対角化(2)',
},
'ベクトル空間':
{
'0203011001':'部分空間の定義(1)',
'0203011006':'部分空間の定義(2)',
'0203021001':'数ベクトルの１次独立性(1)',
'0203021006':'数ベクトルの１次独立性(2)',
'0203021011':'数ベクトルの１次独立性(3)',
'0203021016':'多項式空間での１次独立性',
'0203031001':'空間内の平面の基底',
'0203031006':'生成される部分空間の次元と基底(1)',
'0203031011':'生成される部分空間の次元と基底(2)',
'0203031016':'生成される部分空間の次元と基底(3)',
'0203031021':'生成される部分空間の次元と基底(4)',
'0203031026':'解空間の次元と基底(1)',
'0203031031':'解空間の次元と基底(2)',
'0203031036':'部分空間の和(1)',
'0203031041':'部分空間の和(2)',
'0203031051':'部分空間の共通部分(1)',
'0203031056':'部分空間の共通部分(2)',
'0203031061':'部分空間の共通部分(3)',
'0203041006':'１次写像の像(1)',
'0203041011':'１次写像の像(2)',
'0203041016':'１次写像の核(1)',
'0203041021':'１次写像の核(2)',
'0203041026':'表現行列(1)',
'0203041031':'表現行列(2)',
'0203041036':'表現行列(3)',
'0203041041':'基底に関する座標(1)',
'0203041046':'基底に関する座標 (2)',
'0203041053':'基底に関する座標(3)',
'0203041068':'基底に関する座標(4)',
}
};

var http = require( 'http' ); // HTTPモジュール読み込み
var io = require( '/usr/local/lib/node_modules/socket.io' )(3002); // Socket.IOモジュール読み込み
var fs = require( 'fs' ); // ファイル入出力モジュール読み込み
var co = require( '/usr/local/lib/node_modules/co');
var cheer = require( '/usr/local/lib/node_modules/cheerio-httpcli');
var request = require('/usr/local/lib/node_modules/request');

var rooms_states = [{},{},{},{}];

io.sockets.on( 'connection', function( socket ) {
	socket.name = 'no name';
	socket.isleave = false;
	socket.isPlaying = false;
	var room = null;
	notifyUpdateRoom();

	function getEnemy(socket){
		var ids = Object.keys(io.sockets.adapter.rooms[room].sockets);
		return socket.id == ids[0] ? io.sockets.connected[ids[1]] : io.sockets.connected[ids[0]];
	}

	// 名前の登録が来た時
	socket.on( 'set_name', function(name){
		socket.name = name;
	});

	// 入室リクエストが来た時
	socket.on( 'challenge_enterRoom', function( req, fn ) {
		if(room != null){
			// (どこかの)部屋に入室済み
			fn({status:'already'});
			return;
		}else if(req.room_number < 0 || 3 < req.room_number){
			// 不正
			fn({status:'error'});
			return;
		}else if(io.sockets.adapter.rooms[req.room_number] && io.sockets.adapter.rooms[req.room_number].length == 2){
			// 満員
			fn({status:'full'});
			return;
		}
		// 入室成功
		room = req.room_number;
		socket.join(req.room_number);
		fn({ status : 'ok'});
		var player_count = io.sockets.adapter.rooms[req.room_number].length;
		if(player_count==2){
			//揃ったので二人に通知
			var enemy = getEnemy(socket);
			socket.emit('notify_startGame',{enemy:enemy.name});
			enemy.emit('notify_startGame',{enemy:socket.name});
			//初期化
			socket.point = 0;
			enemy.point = 0;
			/**************/
			/***ゲーム開始***/
			/**************/
			socket.isPlaying = true;
			enemy.isPlaying = true;
			startGame(socket, enemy);
		}
		notifyUpdateRoom();
	});

	// すべての部屋の状況を全員に通知
	function notifyUpdateRoom(){
		var room_status_list = [];
		for (var room_num = 0; room_num < 4; room_num++) {
			var status = {count:0,player1:'',player2:''};
			var room_member_list = io.sockets.adapter.rooms[room_num];
			if(room_member_list){
				status.count = room_member_list.length;
				if(room_member_list.length >= 1){
					status.player1 = io.sockets.connected[Object.keys(room_member_list.sockets)[0]].name;
				}
				if(room_member_list.length == 2){
					status.player2 = io.sockets.connected[Object.keys(room_member_list.sockets)[1]].name;
				}
			}else{
				status.count = 0;
			}
			room_status_list.push(status);
		}
		io.sockets.emit('notify_updateRoom', room_status_list);
	}

	/* ゲーム開始 */
	function startGame(player1, player2){
		rooms_states[room] = {}; // 初期化
		rooms_states[room]['count'] = 0;
		rooms_states[room]['player1'] = player1;
		rooms_states[room]['player2'] = player2;
		rooms_states[room]['play_genre_list'] = {};
		rooms_states[room]['progress_text'] = '';
		rooms_states[room]['problem_history'] = [];
		rooms_states[room]['state'] = 'play';

		function sleep(ms) {
			return function (cb) {
				setTimeout(cb, ms);
			};
		}

		co(function *() {

			// ゲーム開始を通知する
			var html = player1.name+' vs '+player2.name+'<br>'+'10秒後に開始します。';
			io.sockets.to(room).emit('s2c_popup',{'html':html});

			// 5秒待つ
			yield sleep(5000);
			// 一問目開始
			startProblem(true);

		});
	}

	/* 問題開始 */
	function startProblem(_isFirst,_genre=null){

		// init
		socket.hint = false;
		getEnemy(socket).hint = false;

		// 問題選択
		var problem;
		if(_isFirst){
			problem = selectProblem();
		}else{
			problem = selectProblem(false, _genre);
		}

		// 同じジャンルを回避するため、問題を登録
		rooms_states[room]['play_genre_list'][problem.genre] = true;

		function sleep(ms) {
			return function (cb) {
				setTimeout(cb, ms);
			};
		}

		co(function *() {
			// 試合履歴に書き込み
			rooms_states[room]['problem_history'].push(problem);
			if(rooms_states[room]['progress_text'] == ''){
				rooms_states[room]['progress_text'] = problem.genre + '<br>';
			}else{
				rooms_states[room]['progress_text'] += '↓<br>'+problem.genre + '<br>';
			}
			io.sockets.to(room).emit('s2c_setProgress',rooms_states[room]['progress_text']);

			if(!_isFirst){
				// 問題の情報を先に通知
				var html = '「'+problem.genre+'」<br>が選択されました。';
				io.sockets.to(room).emit('s2c_popup',{'html':html});

				// 5秒待つ
				yield sleep(5000);
			}

			// 問題の情報を先に通知
			var html = '問題'+(rooms_states[room]['count']+1)+'<br>'+problem.genre+'<br>'+problem.sub_genre;
			io.sockets.to(room).emit('s2c_popup',{'html':html});

			// 5秒待つ
			yield sleep(5000);

			// 問題を送る
			throwProblem(problem.id, problem.sub_id);
		});
	}

	/* 問題をサーバーから取得して送る */
	function throwProblem(problemID,problemSubID){
		cheer.fetch('http://webmath.las.osakafu-u.ac.jp/top/std/stdmon03.jsp', {'MCD':problemID, 'SMNO':problemSubID}, function (err, $, _res) {
			$('.q_back').html('');
			var q = $('#con_box').html();
			// url置き換え
			q = q.replace(/\/webmath\//g,'http://webmath.las.osakafu-u.ac.jp/webmath/');
			q = q.replace(/images\//g,'http://webmath.las.osakafu-u.ac.jp/top/std/images/');
			// 解答ボタン削除
			q = q.replace('<input type="button" name="btnSubmit" value="チェック" tabindex="1" onclick="javascript:checkInputAll()&&submit();">','');
			// 解答の中身を消す
			q = q.replace(/value=".+" size=/g,'value="" size=');
			// 送信
			io.sockets.to(room).emit('s2c_problem',{'html':q});
		});
	}

	/* 問題を選ぶ */
	function selectProblem(_random=true,_genre=null){

		// ジャンル選択
		var genre = '';
		if(_random){
			var genre_list = [];
			for(var key in problems){
				// やったことのない問題ならリストに追加
				if(!(key in rooms_states[room]['play_genre_list'])){
					genre_list.push(key);
				}
			}
			genre = genre_list[Math.floor(Math.random()*genre_list.length)];
		}else{
			genre = _genre;
		}

		// 問題選択
		var id_list = []
		for(var key in problems[genre]){
			id_list.push(key);
		}
		var id = id_list[Math.floor(Math.random()*id_list.length)];
		var sub_genre = problems[genre][id];
		var sub_id = Math.floor(Math.random()*5)+1;

		//debug
		//id = '0203051001';
		//sub_id = '1';

		return {'genre':genre,'id':id,'sub_genre':sub_genre,'sub_id':sub_id};
	}

	// 問題の選択が送られてきた時
	socket.on('set_genre', function(genre){
		startProblem(false,genre);
	});

	// 解答が送られてきた時
	socket.on( 'challenge_answer', function(answer) {
		// 解答をサーバーに送って合否を確認
		var url = 'http://webmath.las.osakafu-u.ac.jp/top/std/stdmon03.jsp'
		var req = request.defaults();
		var callback = function(answer){
			return function(err, rss, body){
				if(body.match(/<p class="good">/)){
					// 正解
					socket.point += 1;
					rooms_states[room]['problem_history'][rooms_states[room]['count']]['winner'] = socket.id;
					// 得点の変化を通知
					var enemy = getEnemy(socket);
					socket.emit('update_point',{me:socket.point,op:enemy.point});
					enemy.emit('update_point',{me:enemy.point,op:socket.point});
					// 3本先取なので3本とったら勝ち
					var isFinish = socket.point == 3 ? true : false;
					if(isFinish){
						// 結果を通知
						socket.emit('alert',{message:'正解しました。'});
						enemy.emit('alert',{message:'相手プレイヤーが正解しました。'});
						enemy.emit('s2c_setAnswer',{answer:answer});
						// 結果表示テキストを送信
						var result_html = generateResultHtml(socket, enemy);
						socket.emit('s2c_popup',{'html':result_html.winner});
						enemy.emit('s2c_popup',{'html':result_html.loser});

						rooms_states[room]['state'] = 'result';
					}else{
						// 結果を通知
						socket.emit('alert',{message:'正解しました。15秒後に次の問題へ進みます。'});
						enemy.emit('alert',{message:'相手プレイヤーが正解しました。15秒後に次の問題へ進みます。'});
						enemy.emit('s2c_setAnswer',{answer:answer});
						function sleep(ms) {
							return function (cb) {
								setTimeout(cb, ms);
							};
						}
						co(function *() {
							// 次の問題へ
							rooms_states[room]['count'] += 1;

							// 15秒待つ
							yield sleep(15000);

							// ジャンル選択画面を生成
							var genre_select_html = generateGenreSelectHtml();

							// 勝者に選択画面、敗者にポップアップを表示
							socket.emit('s2c_popup',{'html':genre_select_html});
							enemy.emit('s2c_popup',{'html':'相手が問題を選んでいます…'});
						});
					}
				}else{
					// 不正解なので間違えた人にメッセージ
					var fail_messages = body.match(/<p class="failed">(.*)<\/p>/);
					
					var message;
					if(fail_messages == null){
						message = 'まだ問題が開始されていません。';
					}else{
						message = fail_messages[1];
					}
					socket.emit('alert',{message:message});
				}
			}
		}
		req.post({
			url: url,
			form: answer,
			headers: {}
		}, callback(answer));
	});

	// ヒントリクエストが送られてきた時
	socket.on( 'c2s_requestHint', function() {
		socket.hint = true;
		if(getEnemy(socket).hint){
			// ヒント表示
			var message = '<a target="_blank" href="http://webmath.las.osakafu-u.ac.jp/top/std/help/help'+rooms_states[room]['problem_history'][rooms_states[room]['count']].id+'.pdf">ヒント(別画面で表示)</a>';
			io.sockets.to(room).emit('s2c_message',{value:message});
			io.sockets.to(room).emit('alert',{message:'ヒントをチャット画面に送信しました。'});
		}else{
			// ヒント待機メッセージ
			socket.emit('alert',{message:'相手もヒントを選択した場合、ヒントを表示します。'});
			getEnemy(socket).emit('alert',{message:'相手がヒントを選択しました。こちらもヒントを選択すると、ヒントを表示します。'});
		}
	});

	// チャットメッセージが送られてきた時
	socket.on( 'c2s_message', function( data ) {
		// 同じルーム内に送る
		io.sockets.to(room).emit( 's2c_message', { value : data.value } );
	});

	// 接続が切れた時
	socket.on('disconnect',function() {
		if(socket.isleave == true){
			// 何もしない
		}else if(room == null){
			// 何もしない
		}else if(socket.isPlaying == false){
			// 何もしない
		} else if(rooms_states[room]['state'] == 'play'){
			// 相手も接続を切る
			getEnemy(socket).isleave = true;
			getEnemy(socket).emit('reload',{});
			socket.leave(room);
			getEnemy(socket).leave(room);
			notifyUpdateRoom();
		}else if(rooms_states[room]['state'] == 'result'){
			// 相手に通知して二人をルームから出して終わり
			getEnemy(socket).isleave = true;
			getEnemy(socket).emit('enemy_leave',{});
			socket.leave(room);
			getEnemy(socket).leave(room);
			notifyUpdateRoom();
		}
	});

	// 結果表示を生成
	function generateResultHtml(socket, enemy){
		var win_text = '';
		var los_text = '';
		// ・結果
		win_text += '<p class="result-wl">勝利</p>';
		los_text += '<p class="result-wl">敗北</p>';
		// ・点数
		win_text += '<p class="result-point">'+socket.name+' '+socket.point + ' - ' + enemy.point + ' ' + enemy.name + '</p>';
		los_text += '<p class="result-point">'+enemy.name+' '+enemy.point + ' - ' + socket.point + ' '+ socket.name +  '</p>';
		// ・各問題の勝ち負けとリンク
		win_text += '<table id="result-history">';
		los_text += '<table id="result-history">';
		rooms_states[room]['problem_history'].forEach(function(problem, cnt, ar){
			if(cnt % 2 == 0){
				win_text += '<tr>';
				los_text += '<tr>';
			}
			var hist_link_text = '<a target="_blank" href="http://webmath.las.osakafu-u.ac.jp/top/std/stdmon03.jsp?MCD='+problem.id+'&SMNO='+problem.sub_id+'">'+problem.genre+'</a>';
			var hist_win_text = '<td><font color="red">◯</font><td>'+hist_link_text;
			var hist_los_text = '<td><font color="blue">×</font><td>'+hist_link_text;
			if(socket.id == problem.winner){
				win_text += hist_win_text;
				los_text += hist_los_text;
			}else{
				win_text += hist_los_text;
				los_text += hist_win_text;
			}
			if(cnt % 2 == 1){
				win_text += '</tr>';
				los_text += '</tr>';
			}
		});
		win_text += '</table>';
		los_text += '</table>';
		// ・閉じるボタン
		win_text += '<button class="result-close" onClick="closePopup();">閉じる</button>';
		los_text += '<button class="result-close" onClick="closePopup();">閉じる</button>';
		return {winner:win_text,loser:los_text};
	}

	// ジャンル選択画面を生成
	function generateGenreSelectHtml(){
		var select_genre_page = 'ジャンルを選択してください。<br><table id="mtbt-battle-select_genre_table">';
		var add_genre_cnt=0;
		for(var key in problems){
			// やったことのない問題なら追加
			if(!(key in rooms_states[room]['play_genre_list'])){
				if(add_genre_cnt % 2 == 0){
					select_genre_page += '<tr>';
				}
				select_genre_page += '<td><button class="mtbt-battle-select_genre_button" onClick="emitGenre(\''+key+'\');">'+key+'</button><td>';
				if(add_genre_cnt % 2 == 1){
					select_genre_page += '</tr>';
				}
				add_genre_cnt += 1;
			}
		}
		select_genre_page += '</table>';
		return select_genre_page;
	}
});

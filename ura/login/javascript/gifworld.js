/**
 * Gif World
 */
var world;
var canvas;
function GifWorld(){
	canvas = document.getElementById("gif-world");

	// 縦横を画面サイズに合わせる
	var w = $('.gif-world-wrapper').width();
	var h = $('.gif-world-wrapper').height();
	$('#gif-world').attr('width', w);
	$('#gif-world').attr('height', h);

	// ワールド生成
	world = new createjs.Stage(canvas);
	createjs.Ticker.addEventListener("tick", update);
}

function getWorldWidth(){
	return $('.gif-world-wrapper').width();
}

function getWorldHeight(){
	return $('.gif-world-wrapper').height();
}

class WaveAnimation{
	constructor(wave){
		this.wave = wave;
		this.counter = 0;
	}
	update(){
		this.counter ++;
		//30回を超えたらアニメーション終了
		if(this.counter > 30){
			return false;
		}
		return true;
	}
}

var gondoras = [];
var waves = [];
var counter = 0;
function update(eventObject) {
	// 時々波を発生させる
	if(getRandomInt(0,19) == 0){
		var wave_anime = new WaveAnimation(createWave());
		waves.push(wave_anime);
	}

	// 一周+32tick毎にゴンドラを流す
	if(counter % ((getWorldWidth()+32)+32) == 0){
		gondoras.push(createGondora());
	}

	// 位置修正
	for(var i=0;i<gondoras.length;i++){
		gondoras[i].y = getWorldHeight() - 372;
	}
	for(var i=0;i<waves.length;i++){
		waves[i].wave.y = getWorldHeight() - 372;
	}

	// ゴンドラを進ませる
	for(var i=0;i<gondoras.length;i++){
		gondoras[i].x--;
	}

	// ゴンドラが範囲外に出ていたら削除
	for(var i=gondoras.length-1;i>=0;i--){
		if(gondoras[i].x < -32){
			gondoras.splice(i, 1);
		}
	}

	// 波のアニメーションが終了したら削除
	for(var i=waves.length-1;i>=0;i--){
		if(!waves[i].update()){
			world.removeChild(waves[i].wave);
			waves.splice(i, 1);
		}
	}

	// 更新
	world.update();
	counter++;
}

function createWave(){
	// 波生成
	wave_sprite = createWaveSprite("/login/image/wave_spritesheet.png");
	world.addChild(wave_sprite);

	wave_sprite.x = getRandomInt(0, getWorldWidth()-1);
	wave_sprite.gotoAndPlay("waving");
	return wave_sprite;
}

function createGondora(){
	// ゴンドラ生成
	gondora_sprite = createGondoraSprite("/login/image/gondora.png");
	world.addChild(gondora_sprite);

	gondora_sprite.x = getWorldWidth();
	gondora_sprite.gotoAndPlay("sprash");
	return gondora_sprite;
}

function getRandomInt(min, max) {
	return Math.floor( Math.random() * (max - min + 1) ) + min;
}


function createWaveSprite(file) {
	var data = {};
	data.images = [file];
	data.frames = {width:32, height:16, regX:16, regY:8};
	data.animations = {waving: {
			frames: [0, 1, 2, 3, 4, 5,5, 6,6, 7,7, 8,8, 9,9],
			speed: 0.5,
			next: false
		}
	};
	var mySpriteSheet = new createjs.SpriteSheet(data);
	var mySprite = new createjs.Sprite(mySpriteSheet);
	return mySprite;
}

function createGondoraSprite(file) {
	var data = {};
	data.images = [file];
	data.frames = {width:32, height:16, regX:0, regY:8};
	data.animations = {sprash: {
			frames: [0, 1, 2],
			speed: 0.4
		}
	};
	var mySpriteSheet = new createjs.SpriteSheet(data);
	var mySprite = new createjs.Sprite(mySpriteSheet);
	return mySprite;
}


GifWorld();

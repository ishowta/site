<?php
$dbh = openDB();
$stmt = $dbh->query('SELECT * FROM calender');
$events_str = '';
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	$result['title'] = htmlspecialchars($result['title']);
	$result['start'] = htmlspecialchars($result['start']);
	$result['color'] = '#'.htmlspecialchars($result['color']);
	$result['end'] = htmlspecialchars($result['end']);
	$events_str .= json_encode($result).',';
}
?>
	<form id="calender-addform" action="apps/calender/add.php" method="POST" accept-charset="utf-8">
		イベント名<input id="calender-title" name="title" type="text">
		日付<input id="calender-datepicker" name="start" type="text">
		〜まで<input id="calender-datepicker2" name="pre_end" type="text" placeholder="(option)">
		<input id="calender-end" type="hidden" name="end">
		色<select id="calender-color" name="color">
		<option value="3a87ad">青</option>
		<option value="ff9800">オレンジ</option>
		</select>
		<button id="calender-submit" type="submit">追加</button>
	</form>
<div>
	<script src="apps/calender/jquery-ui.min.js"></script>
	<script src="apps/calender/datepicker-ja.js"></script>
	<link rel="stylesheet" href="apps/calender/jquery-ui.min.css">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/ja.js'></script>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' rel='stylesheet' />
	<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script>
		$(function(){
			$("#calender-datepicker").datepicker({'dateFormat':'yy-mm-dd'});
			$("#calender-datepicker2").datepicker({'dateFormat':'yy-mm-dd'});
		});
		$(document).ready(function() {
			$('.calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				},
				navLinks: true, // can click day/week names to navigate views
				editable: false,
				eventLimit: true, // allow "more" link when too many events
				allDayDefault: true,
				height: 600,
				events: [<?=$events_str?>]
			});
		});
		$('#calender-addform').submit(function(){
			if(!$('#calender-datepicker').val().match(/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/)){
				alert('日付が入力されてないです。');
				return false;
			}
			if(!$('#calender-title').val().match(/^.+$/)){
				alert('タイトルが入力されてないです。');
				return false;
			}
			// カレンダーの仕様に合わせて一日ずらす
			var endDay = new Date($('#calender-datepicker2').val());
			endDay.setDate(endDay.getDate() + 1);
			endDay = endDay.toISOString();
			$('#calender-end').val(endDay);
			// カレンダーに追加
			$('.calendar').fullCalendar('renderEvent',{'title':$('#calender-title').val(),'start':$('#calender-datepicker').val(),'end':endDay,'color':'#'+$('#calender-color').val()});
			// キャンセル
			event.preventDefault();
			// ajaxで送信
			$.ajax({
				url: 'apps/calender/add.php',
				type: 'POST',
				data: $('#calender-addform').serialize(),
				timeout: 10000,
				beforeSend: function(xhr, settings) {
					// ボタンを無効化し、二重送信を防止
					$('#calender-submit').attr('disabled', true);
				}
			})
			.always(function(xhr, textStatus) {
					// ボタンを有効化し、再送信を許可
					$('#calender-submit').attr('disabled', false);
			})
			.done(function(result, textStatus, xhr) {
					// 入力値を初期化
					$('#calender-title').val('');
					$('#calender-datepicker').val('');
					$('#calender-datepicker2').val('');
			})
			.fail(function(xhr, textStatus, error) {
					alert('送信に失敗しました。');
			});
		});
	</script>
	<style>
		body {
			font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
			font-size: 14px;
		}

		.calendar {
			max-width: 900px;
			margin: 0 auto;
			padding-top: 4px;
		}
		#calender-addform{
			text-align: center;
		}
	</style>
	<div class='calendar'></div>
</div>

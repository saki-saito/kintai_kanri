jQuery(function($) {
	jQuery.extend({
		clock_ymd : function clock_ymd(target){
			var dayOfTheWeek = new Array("日","月","火","水","木","金","土");
			var now  = new Date();
			var year = now.getFullYear();
			var month = now.getMonth()+1;
			var date = now.getDate();
			var day = now.getDay();
			var hour = now.getHours();
			var min = now.getMinutes();
			var sec = now.getSeconds();
			if(month < 10) {
				month = "0" + month;
			}
			if(date < 10) {
				date = "0" + date;
			}
			if(hour < 10) {
				hour = "0" + hour;
			}
			if(min < 10) {
				min = "0" + min;
			}
			if(sec < 10) {
				sec = "0" + sec;
			}
			var ymd_str = year + "年" + month + "月" + date + "日" + "（" + dayOfTheWeek[day] + "）" ;
			
			// htmlの内容を更新
			target.text(ymd_str);
			//target.html(ymd_str);
			
			// 1000ミリ秒（1秒）毎に更新
			setTimeout(function(){
				clock_ymd(target)
			},1000);
		}
	});
	
	jQuery.extend({
		clock_time : function clock_time(target){
			var dayOfTheWeek = new Array("日","月","火","水","木","金","土");
			var now  = new Date();
			var year = now.getFullYear();
			var month = now.getMonth()+1;
			var date = now.getDate();
			var day = now.getDay();
			var hour = now.getHours();
			var min = now.getMinutes();
			var sec = now.getSeconds();
			if(month < 10) {
				month = "0" + month;
			}
			if(date < 10) {
				date = "0" + date;
			}
			if(hour < 10) {
				hour = "0" + hour;
			}
			if(min < 10) {
				min = "0" + min;
			}
			if(sec < 10) {
				sec = "0" + sec;
			}
			var time_str = hour + "：" + min + "：" + sec;
			
			// htmlの内容を更新
			target.text(time_str);
			//target.html(time_str);
			
			// 1000ミリ秒（1秒）毎に更新
			setTimeout(function(){
				clock_time(target)
			},1000);
		}
	});
	
	// 現在日時を表示します。
	jQuery.clock_ymd(jQuery("#degitalClockYmd"));
	jQuery.clock_time(jQuery("#degitalClockTime"));
});
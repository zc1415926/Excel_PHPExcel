<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<form id="params" action="index.php" method="post">
  	<label>表头有几行？</label><br>
  	<input class="rowsOfHead" type="text" name="rowsOfHead" value="1" /><br>
  	<label>提取几行？</label><br>
  	<input class="rowsOfContent" type="text" name="rowsOfContent" value="1" /><br>
  	<lable>最后一列的列号</lable><br>
  	<input class="nameOfLastCol" type="text" name="nameOfLastCol" value="BT" /><br>
  	<!-- 不使用传统的type="submit"将表单提交给一个php,而是使用一个普通type="button"调用Ajax -->
  	<button class="combineExcel" type="button">开始合并</button>
</form>
<p class="interval"></p>
<p class="resultP"></p>

<script type="text/javascript">

var timer;
$(document).ready(function(){
	
	$("button.combineExcel").click(function(){
		var rowsOfHead = $("input.rowsOfHead").val();
		var rowsOfContent = $("input.rowsOfContent").val();
		var nameOfLastCol = $("input.nameOfLastCol").val();
		
		//点击开始合并时，首先要把进度归0
		$.ajax({
			"type":"POST", 
			"url":"clearLog.php", 
			"data":{
			},
			"success":function(data){ 
			} 
		});

		//把表格信息传递给index.php并输出结果
		$.ajax({
			"type":"POST", 
			"url":"index.php", 
			"data":{
				rowsOfHead : rowsOfHead,
				rowsOfContent : rowsOfContent,
				nameOfLastCol : nameOfLastCol,
			},
			"success":function(data){ 
				$("p.resultP").html(data);
			} 
		});
		//启动定时器，获取处理进度
		timer = setInterval("$.getProgress()",500);
	});
	
	$.extend({
		//定时器调用的函数，调用getLog.php获取进度并输出，当进度为100时清除定时器
		getProgress:function(){
			$.ajax({ 
				"type":"POST", 
				"url":"getLog.php", 
				"data":{
				},
				"success":function(data){ 
					$("p.interval").append(data + "<br>");
					if(data == 100)
					{
						clearInterval(timer);
					}
				} 
			});
		}
	});
});
</script>
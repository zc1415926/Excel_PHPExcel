<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<form id="params" action="index.php" method="post">
  	<label>表头有几行？</label><br>
  	<input class="rowsOfHead" type="text" name="rowsOfHead" value="1" /><br>
  	<label>提取几行？</label><br>
  	<input class="rowsOfContent" type="text" name="rowsOfContent" value="1" /><br>
  	<lable>最后一列的列号</lable><br>
  	<input class="nameOfLastCol" type="text" name="nameOfLastCol" value="BT" /><br>
  	<!--  <button type="submit">开始合并</button>-->
  	<button class="combineExcel" type="button">开始合并</button>
</form>
<p class="interval"></p>
<p class="resultP"></p>
<script type="text/javascript">
/*$.ajax({ 
	"type":"POST", 
	"url":"ajax.php", 
	"data":"var1=val1&var2=val2", 
	"success":function(data){ 
	$("#bar") 
	.css("background","yellow") 
	.html(data); 
	} 
	});*/
var timer;
$(document).ready(function(){

	$("button.combineExcel").click(function(){
		var rowsOfHead = $("input.rowsOfHead").val();
		var rowsOfContent = $("input.rowsOfContent").val();
		var nameOfLastCol = $("input.nameOfLastCol").val();

		$.ajax({
			"type":"POST", 
			"url":"clearLog.php", 
			"data":{

			},
			"success":function(data){ 
				//alert(data);
				//$("p.resultP").html(data);
			} 
		});
		
		$.ajax({
			"type":"POST", 
			"url":"index.php", 
			"data":{
				rowsOfHead : rowsOfHead,
				rowsOfContent : rowsOfContent,
				nameOfLastCol : nameOfLastCol,
			},
			"success":function(data){ 
				//alert(data);
				$("p.resultP").html(data);
			} 
		});

		timer = setInterval("$.getProgress()",500);
	});
	
	  $("button.postBtn").click(function(){
		  var rowsOfHead = $("input.rowsOfHead").val();
		  var rowsOfContent = $("input.rowsOfContent").val();
		  var nameOfLastCol = $("input.nameOfLastCol").val();

		  $.ajax({ 
				"type":"POST", 
				"url":"http://ajaxphp.bliand.com/post.php", 
				"data":{
					rowsOfHead : rowsOfHead,
					rowsOfContent : rowsOfContent,
					nameOfLastCol : nameOfLastCol,


					    },
				"success":function(data){ 
				//$("#bar") 
				//.css("background","yellow") 
				//.html(data); 
					//$("p.post").text(data);
					alert(data);
				} 
				});
	  });
	  
	  $.extend({
		  show:function(){
			  $("p").append("3 seconds out.<br>");
		  },
		  getProgress:function(){
			  $.ajax({ 
					"type":"POST", 
					"url":"getLog.php", 
					"data":{
					//	rowsOfHead : rowsOfHead,
					//	rowsOfContent : rowsOfContent,
					//	nameOfLastCol : nameOfLastCol,

		
					},
					"success":function(data){ 
						$("p.interval").append(data + "<br>");
						if(data == 100)
						{
							clearInterval(timer);
						}
						//alert(data);
					} 
					});
			  
		  }
		});
		//setInterval("$.show()",3000);



	});
</script>
<button class="postBtn">向页面发送 HTTP POST 请求，并获得返回的结果</button>
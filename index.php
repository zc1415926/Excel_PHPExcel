<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>人和街小学Excel云中心 &middot; Excel合并云</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body {
	padding-top: 20px;
	padding-bottom: 60px;
}

/* Custom container */
.container {
	margin: 0 auto;
	max-width: 1000px;
}

.container>hr {
	margin: 60px 0;
}

/* Main marketing message and sign up button */
.jumbotron {
	margin: 80px 0 0 0;
	/*text-align: center;*/
}

.jumbotron h1 {
	font-size: 100px;
	line-height: 1;
}

.jumbotron .lead {
	font-size: 24px;
	line-height: 1.25;
}

.jumbotron .btn {
	font-size: 21px;
	padding: 14px 24px;
}

/* Supporting marketing content */
.marketing {
	margin: 60px 0;
}

.marketing p+h4 {
	margin-top: 28px;
}

/* Customize the navbar links to be fill the entire space of the .navbar */
.navbar .navbar-inner {
	padding: 0;
}

.navbar .nav {
	margin: 0;
	display: table;
	width: 100%;
}

.navbar .nav li {
	display: table-cell;
	width: 1%;
	float: none;
}

.navbar .nav li a {
	font-weight: bold;
	text-align: center;
	border-left: 1px solid rgba(255, 255, 255, .75);
	border-right: 1px solid rgba(0, 0, 0, .1);
}

.navbar .nav li:first-child a {
	border-left: 0;
	border-radius: 3px 0 0 3px;
	font-family: "黑体", "宋体";
	font-size: large;
}

.navbar .nav li:last-child a {
	border-right: 0;
	border-radius: 0 3px 3px 0;
}

p {

line-height: 25px;
}

#combineProgress {
margin-top: 15px;
}
</style>


<link rel="stylesheet" type="text/css" href="css/uploadify.css">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144"
	href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="../assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="../assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed"
	href="../assets/ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="../assets/ico/favicon.png">


</head>

<body>

	<div class="container">

		<div class="masthead">
			<h3 class="muted">人和街小学Excel云中心</h3>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="active"><a href="#">Excel合并云</a></li>
							<li><a href="#"></a></li>
							<li><a href="#"></a></li>
							<li><a href="#"></a></li>
							<li><a href="#"></a></li>
							<li><a href="#"></a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.navbar -->
		</div>

		<!-- Jumbotron -->
		<div class="jumbotron">
			<h1>Excel合并云</h1>
			表单的检查，提示、帮助
			<p class="lead">无需复制粘贴，无需安装软件，无需费心竭力，“Excel合并云”帮你轻松搞定！</p>
			<!--<a class="btn btn-large btn-success " href="#">上传文件，开始合并</a>-->

			<div class="row-fluid">

				<div class="span4">

					<!-- <form>-->

					<input class="btn btn-large btn-success" id="file_upload"
						name="file_upload" type="file" multiple="true">
					<div id="queue" width="230"></div>
					<!-- </form>-->

					<button class=" btn btn-large btn-info" id="upload_finish"
						type="submit" style="display: none; margin-bottom: 0.7em">上传完成，填写参数</button>

						
						<button id="combineExcel" class="btn btn-large  btn-primary"
							type="button" style="display: none;margin-bottom: 0.7em"" >填写完毕，开始合并</button>
						
					<!-- <p class="interval"></p>
					<p class="resultP"></p>-->
					<a id="downloadBtn" class="btn btn-large btn-danger"
						href="./result/result.xls" style="display: none" margin-bottom: 0.7em">合并完成，点击下载</a>

						
						
						
				</div>
				<div class="span4">
					<form id="params" action="index.php" method="post"
						style="display: none">
						<label>表头有几行？</label> <input class="rowsOfHead" type="text"
							name="rowsOfHead" value="1" /><br> <label>提取几行？</label> <input
							class="rowsOfContent" type="text" name="rowsOfContent" value="1" /><br>
						<label>最后一列的列号</label> <input class="nameOfLastCol" type="text"
							name="nameOfLastCol" value="BT" /><br>
						<!-- 不使用传统的type="submit"将表单提交给一个php,而是使用一个普通type="button"调用Ajax 
			  	TODO: 开始合并后，下边的按钮要改为不可用状态，或“正在。。”-->
						
					</form>
				</div>
				<div class="span4"></div>

			</div>
			
			<div id="combineProgress" class="progress" style="display: none">
			
				<div id="combineProgressionBar" class="bar" style="width: 0%;"></div>
			</div>
		</div>
		<hr>

		<!-- Example row of columns -->
		<div class="row-fluid">
			<div class="span4">
				<h2>云计算</h2>
				<p>使用SaaS（软件即服务）的云计算形式，为您提供大量相似Excel合并云服务。
				您只需上传要合并的表格，输入相关参数，轻轻一点，再喝杯清茶，Excel合并云就会将合并结果返回给您。
				从此，您不再需要机械地复制粘贴海量表格，不再需要头痛地下载安装繁杂软件，
				更不再需要每天费心竭力头晕眼花。</p>
				<!--<p>
					<a class="btn" href="#">View details &raquo;</a>
				</p>-->
			</div>
			<div class="span4">
				<h2>现代前端技术</h2>
				<p>“人和街小学Excel云中心 &middot; Excel合并云”使用了Bootstrap、jQuery、Ajax等多项现代Web前端技术开发。
				为您提供简洁、直观、优雅、兼容多浏览器的人机交互界面，您不必频繁地穿梭在多个页面之间寻找想要的功能，
				也不必反复地跳转刷新页面查看Excel合并结果。一切就是这样轻松！
			</div>
			<div class="span4">
				<h2>高扩展性</h2>
				<p>“人和街小学Excel云中心 &middot; Excel合并云”为"人和街小学 &middot; 信息中心"自主研发，
				可根据人和师生的需求及使用反馈进行快速地扩展、更改，使您摆脱“功能不顺心，使用不顺手”苦恼，做“真正懂你”的云计算。
			</div>
		</div>

		<hr>

		<div class="footer">
			<p>&copy; 人和街小学&middot;信息中心 2014</p>
		</div>

	</div>
	<!-- /container -->



	<!-- Le javascript
    ==================================================
    Placed at the end of the document so the pages load faster  -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script type="text/javascript">


	
	<?php $timestamp = time();?>
	$(function() {
		$('#file_upload').uploadify({
			'formData'     : {
				'timestamp' : '<?php echo $timestamp;?>',
				'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
			},
			'removeTimeout' : 0,
			'width'   : 240,
			'height'   : 50,
			'swf'      : 'uploadify/uploadify.swf',
			'uploader' : 'uploadify/uploadify.php',
			'fileTypeDesc':'Excel 2003 文件',
			 //允许上传的文件后缀
			'fileTypeExts':'*.xls;',
			'buttonText' : '上传文件，开始合并',
			//'buttonImage' : 'browse-btn.png'
			'onQueueComplete' : function(file, data, response) {
				$("#upload_finish").slideDown("slow");
			},
		});
	});

	var timer;
	$(document).ready(function(){

		$("#upload_finish").click(function(){
			$("#params").slideDown("slow");
			$("#combineExcel").slideDown("slow");
			$("#combineProgress").slideDown("slow");

		});
			
		$("#combineExcel").click(function(){

			$("#combineExcel").attr("disabled","disabled");
			$("#combineExcel").text("正在合并表格...........");
			
			var rowsOfHead = $(".rowsOfHead").val();
			var rowsOfContent = $(".rowsOfContent").val();
			var nameOfLastCol = $(".nameOfLastCol").val();
			
			//点击开始合并时，首先要把进度归0
			$.ajax({
				"type":"POST", 
				"url":"clearLog.php", 
				"data":{
				},
				"success":function(data){ 
					//alert(data);
				},
			});

			//把表格信息传递给processCombination.php并输出结果
			$.ajax({
				"type":"POST", 
				"url":"processCombination.php", 
				"data":{
					rowsOfHead : rowsOfHead,
					rowsOfContent : rowsOfContent,
					nameOfLastCol : nameOfLastCol,
				},
				"success":function(data){ 
					//$("p.resultP").html(data);
					$("#combineExcel").removeAttr("disabled");
					$("#combineExcel").text("填写完毕，开始合并");

					
						//alert(data);
				
				},
				"complete":function(data){
					//alert(data);
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
						
						//var p =String(Number(data) + "%");
						//$("p.interval").append(p + "<br>");
						$("#combineProgressionBar").css("width",(Number(data) + "%"));
					
						if(data >= 100)
						{
							//$("p.interval").html("<a class='btn btn-large btn-danger' href='./result/result.xls'>合并完成，点击下载<a>");
							$("#downloadBtn").slideDown("slow");
							clearInterval(timer);
						}
					} 
				});
			}
		});
	});
	</script>
	<!--  <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>-->

</body>
</html>
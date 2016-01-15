<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>扫雷</title>
</head>
<body>
<input id="user" type="hidden" value="<?php echo ($user); ?>">
<h1 style="text-align:center">扫雷游戏</h1>
<script language="JavaScript">
/* 常量 */
var game="扫雷";
var msgDilei="<IMG SRC='/Public/img/2.jpg' WIDTH=50 HEIGHT=40 BORDER=0 alt='雷' title='雷'>";//地雷
var msgMark="<FONT SIZE=4 COLOR=#FF0099><b>?</b></FONT>";  //可疑标记
var msgGameOver="<b>!GAME OVER！</b>what a pity!。。。";
var msgSendScore="厉害！点击发送成绩，加入扫雷英雄榜！";
//********************//
/* 全局变量*/
var num=0;  //雷数
var isend="no";  //游戏是否已结束
var AA=new Array(); //格子是否有雷的标记(0无1有)
var BB=new Array(); //无雷格子显示的数字,即周围8格雷数
var bj=new Array();  //是否已做可疑标记
var tc=new Array();  //是否已探测
	for (x=0;x<=11 ; x++)  //初始化，随机产生雷
	{  	
		AA[x]=new Array();
		bj[x]=new Array();
		tc[x]=new Array();
		for (y=0;y<=11 ;y++ )
		{
			if (x==00||y==0||x==11||y==11)
			{
				AA[x][y]=0;
			}
			else
			{
				AA[x][y]=Math.random();
				AA[x][y]=Math.round(AA[x][y]);
				if (AA[x][y]==1){num++;}
			}
			bj[x][y]=0;
			tc[x][y]=0;
		}
	}
	for (m=1;m<=10 ;m++ ) //控制雷数在25左右
	{
		for (n=1; n<=10; n++)
		{
			if (AA[m][n]==1)
			{
				var s;
				s=Math.random();
				s=Math.round(s);
				if (s==1)
				{ 
					AA[m][n]=0;
				}
			}
		}
	}
	num=0;
	for (i=1;i<=10 ; i++)  //计算无雷格子显示的数字
	{ 	
		BB[i]=new Array();
		for (j=1; j<=10; j++)
		{ BB[i][j]=0;
		if (AA[i][j]==0)
		{
		BB[i][j]=AA[i-1][j-1]+AA[i-1][j]+AA[i-1][j+1]+AA[i][j-1]+AA[i][j+1]+AA[i+1][j-1]+AA[i+1][j]+AA[i+1][j+1];
		}
		else{ num++;BB[i][j]=9;}
		}
	}
	//秒表
	var ms=0;//秒数
	function piaomiao()
	{
		if (isend=="no")
		{
			ms++;
			document.getElementById("miaobiao").innerHTML=ms;
		}
	}
	var jishi=0;out=0; //jishi=记时标记; out=已探索格数
	function islei() // 点击鼠标踩雷  程序主要部分
	{
		if (jishi==0)  //开始记时
		{
			jishi=1;startjishi=setInterval("piaomiao()",1000);
		} 
		var a,b;
		a=islei.arguments[0];
		b=islei.arguments[1];
		tc[a][b]=1;
		if (bj[a][b]==1)
		{
			document.getElementById("d"+a+"_"+b).innerHTML="";
			bj[a][b]=0;
		}
		else 
		{
			if (AA[a][b]==1&&isend=="no")   // 踩中雷了!!
			{
				document.getElementById("d"+a+"_"+b).innerHTML=msgDilei;
				document.getElementById("show").innerHTML=msgGameOver;
				clearInterval(startjishi);
				showall();
				isend="yes";
				$("#cj").val ="失败"+(100-out-num);
				//player=prompt("扫雷成功!\t\t您用时："+document.getElementById("miaobiao").innerHTML+"\n留名：","匿名玩家");
				cost_time = $('#miaobiao').html();
				name = $('#user').val();
				mine_num = $('#leishu').val();
				$.ajax({
					type: "post",
					url: 'createRecord',
					data: {
						name:name,
						cost_time:cost_time,
						mine_num:mine_num,
					},
					dataType: "json",
					success: function(result) {
						if (result.code === 1) {
							alert(result.msg);
						} else if (result.code === 0) {
							alert(result.error_msg);
						}
					},
					error:function(){
						alert("服务器出错！");
					}
				});
			}
			else  if (AA[a][b]==1&&isend=="yes")
			{
				document.getElementById("d"+a+"_"+b).innerHTML=msgDilei;
				clearInterval(startjishi); 
			}
			else // 安全,没踩中
			{           
				document.getElementById("d"+a+"_"+b).innerHTML=BB[a][b];
				if (document.getElementById("d"+a+"_"+b).style.backgroundColor!=""&&isend=="no")
				{
					out++;
				}
				document.getElementById("yu").innerHTML="还有<FONT SIZE=4 COLOR=red>"+(100-out-num)+"</FONT>处无雷区等待探测";
				if ((100-out-num)==0&&isend=="no")  //成功！
				{
					window.alert("恭喜！");
					isend="yes";
					showall();
					clearInterval(startjishi);
					document.getElementById('show').innerHTML=msgSendScore;
					player=prompt("扫雷成功!\t\t您用时："+document.getElementById("miaobiao").innerHTML+"\n留名：","匿名玩家");
					window.frames[0].location.href="http://www.uptoday.cn/fun/record.asp?game=扫雷&player="+player+"&score="+document.getElementById("miaobiao").innerHTML+"";
					document.getElementById("cj").value=document.getElementById("miaobiao").innerHTML;
				}
				if (BB[a][b]==0)  
				{
					safe(a,b);
				}
			}
			document.getElementById("d"+a+"_"+b).style.backgroundColor="";
		}
	}   //主要部分End
	//--- start
	function safe(a,b) //为0时翻转周围格子
	{
		if (a!=0&&a!=11&&b!=0&&b!=11)
		{
			if (BB[a][b]==0)
			{
				ifo(a-1,b-1);ifo(a-1,b);ifo(a-1,b+1);ifo(a,b-1);ifo(a,b+1);ifo(a+1,b-1);ifo(a+1,b);ifo(a+1,b+1);
			}
		}
	}
	function ifo(m,n)
	{
		if ((m!=0&&m!=11)&&(n!=0&&n!=11)&&tc[m][n]==0)
		{
			document.getElementById("d"+m+"_"+n).style.backgroundColor="";
			document.getElementById("d"+m+"_"+n).innerHTML=BB[m][n];
			if (tc[m][n]==0&&isend=="no") 
			{
				out++;
			}
			tc[m][n]=1;
			document.getElementById("yu").innerHTML="还有<FONT SIZE=4 COLOR=red>"+(100-out-num)+"</FONT>处无雷区等待探测";
			if (BB[m][n]==0)
			{
				safe(m,n);
			} //
		}
	}
	//--- end
	function showall()  //踩中雷后显示全部格子
	{	
		out=100-num;
		isend="yes";
		for (i=1;i<=10 ;i++ )
		{
			for (j=1;j<=10 ;j++ )
			{
				document.getElementById("d"+i+"_"+j).style.backgroundColor="";
				if (AA[i][j]==0) 
				{
					document.getElementById("d"+i+"_"+j).innerHTML=BB[i][j];
				}
				else 
				{
					document.getElementById("d"+i+"_"+j).innerHTML=msgDilei;
				}
			}
		}
	}
	function biaoji(i,j) //鼠标右键标记雷
	{
		if (event.button==2&&tc[i][j]==0) 
		{
			if (bj[i][j]==0)
			{
				document.getElementById("d"+i+"_"+j).innerHTML=msgMark;
				bj[i][j]=1;
			}
			else
			{
				document.getElementById("d"+i+"_"+j).innerHTML="&nbsp;";
				bj[i][j]=0;
			}
		}
	}
	function check()  //游戏未结束不能发送成绩
	{
		if ((100-out-num)>1)
		{
			window.alert("还没玩完呢，不能发送！");
			event.returnValue=false;
		}
	}
	function safestart() //安全开局
	{
		var ss=0;
		for (i=1; i<=10&&ss==0;i++ )
		{
			for (j=1; j<=10&&ss==0;j++ )
			{
				if (BB[i][j]==0)
				{
					islei(i,j);
					ss=1;
					break;
				}
			}
		}
	}
	//-->
</SCRIPT>
<BODY onload="document.getElementById('show').innerHTML='小心，此处有地雷'+num+'个';document.getElementById('leishu').value=num;">
<SCRIPT LANGUAGE="JavaScript">
	document.write(" <TABLE border=1 bordercolor=#66CCCC width=800 height=400  cellpadding=0 cellspacing=0 align=center>");
	for(i=1;i<=10;i++)
	{  
		document.write("<TR>");
		for(j=1;j<=10;j++)
		{
		document.write("<TD id=\"d"+i+"_"+j+"\" onclick=\"islei("+i+","+j+")\" onmousedown=\"biaoji("+i+","+j+")\" align=\"center\" valign=\"center\" width=\"60\" height=\"40\" style=\"background:#DBDBDB;cursor:hand;\" >&nbsp;</TD> ");
		}
		document.write("</TR>");
	}
	document.write("</TABLE>");
</SCRIPT>
	<div id="show" align="center">&nbsp;</div><br>
	<div id="yu" align="center"><button onclick="safestart();">安全开局</button></div><br>
	<div  align="center">已用时:&nbsp;<span id="miaobiao">0</span>&nbsp;秒</div>
	<TABLE align="center">
		<TR>
			<TD><button onclick="window.location.reload();">重来</button></TD>
			<TD><a href="rank?user=<?php echo ($user); ?>"><button type="button">查看排行榜</button></a></TD>
			<FORM METHOD=POST A
			CTION="saolei_cj.asp" target=_parent>
			<TD>
				<INPUT id="leishu" TYPE="hidden" NAME="leishu" value="">
				<INPUT TYPE="hidden" NAME="cj" value="失败">
			</TD>
			</FORM>
		</TR>
	</TABLE>
<SCRIPT LANGUAGE="JavaScript">
	for(i=0;i<=11;i++)
	{
		document.write("<div id=\"d0_"+i+"\" style=\"display:none\"></div>");
	}
	for(i=0;i<=11;i++)
	{
		document.write("<div id=\"d11_"+i+"\" style=\"display:none\"></div>");
	}
	for(i=1;i<=10;i++)
	{
		document.write("<div id=\"d"+i+"_0\" style=\"display:none\"></div>");
	}
	for(i=1;i<=10;i++)
	{
		document.write("<div id=\"d"+i+"_11\" style=\"display:none\"></div>");
	}
</script>
<script type="text/javascript" src="/Public/jquery-2.1.4.min.js"></script>
</body>
</html>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<title>�絤����ʪ������ƻ륷���ƥ�ʤ���ޤᷯ�˥ۡ���ڡ���</title>
<link rel="stylesheet" media="all" href="Styles.css" type="text/css">
<script language="javascript" src="JScript1.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
<!--
function ChangePG(){
		//�����Υ����å�
	Time=CheckTime2(Form1);
	if(Time==false){
		return false;
	}
	else{
		self.Map_iframe.location="http://sora.taiki.go.jp/loghourfig/"+Time+".html";
	}
}
function ReLoadWin(){
	if(document.Form1.ListPref.value==0){
		this.location="DataJokyo.php";
	}else{
		Pref=document.Form1.ListPref.value;			
		self.Map_iframe.location ="MstItiranFrame.php?Pref="+Pref;
	}
}
//************************************************************//
//MouseOver//
//************************************************************//
function MouseOver(TargetImage,ImageName){
	document.images[TargetImage].src=ImageName;
	document.images[TargetImage].style.cursor='hand';
}
//************************************************************//
//MouseOut//
//************************************************************//
function MouseOut(TargetImage,ImageName){
	document.images[TargetImage].src=ImageName;
	document.images[TargetImage].style.cursor='default';
}

-->
</script>
</head>
<body class="bodyInfo">
<div align="center">
<form name="Form1" action="">
<input type="hidden" name="Saisin" value="2015031516">
<table class="Border" width="1000" style="position:absolute; left:0;top:0;" cellpadding="0" cellspacing="0"><tr><td>
<table border="0" cellSpacing="0" cellPadding="0" class="BgImg" width="1000">
	<tr>
		<td colspan="2">
			<table border="0" width="1000">
				<tr>
					<td>
						<img src="Title/soramamekun.gif" alt="soramame">
						<img src="Title/title3.gif" alt="title">
					</td>
					<td align="right">
						<a href="Index.php"><img src="Logo/top.gif" name="top" onMouseOver="MouseOver('top','Logo/top2.gif');" onMouseOut="MouseOut('top','Logo/top.gif');" border="0" alt="�ȥå�"></a><a href="Help.html"><img src="Logo/help.gif" name="help" 
						onMouseOver="MouseOver('help','Logo/help2.gif');" onMouseOut="MouseOut('help','Logo/help.gif');" border="0"alt="�������"></a><a href="kouji.php"><img src="Logo/kouji_menu.gif"
						alt="��������" name="koji" width="102" height="25" border="0" onMouseOver="MouseOver('koji','Logo/kouji_menu2.gif');" onMouseOut="MouseOut('koji','Logo/kouji_menu.gif');"></a><a href="index/index2.html"><img src="Logo/setumei_menu.gif" 
						alt="�����Υڡ���" name="setumei" width="121" height="25" border="0" onMouseOver="MouseOver('setumei','Logo/setumei_menu2.gif');" onMouseOut="MouseOut('setumei','Logo/setumei_menu.gif');"></a><a href="http://sora.taiki.go.jp/"><img src="Logo/keitai_menu.gif"
						alt="���ӥ�����" name="keitai" width="107" height="25" border="0" onMouseOver="MouseOver('keitai','Logo/keitai_menu2.gif');" onMouseOut="MouseOut('keitai','Logo/keitai_menu.gif');"></a><a href="link.html"><img src="Logo/rink.gif"
						alt="���" name="rink" width="76" height="25" border="0" onMouseOver="MouseOver('rink','Logo/rink2.gif');" onMouseOut="MouseOut('rink','Logo/rink.gif');"></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="tab/left.gif" style="vertical-align:bottom;" alt="left"><img src="tab/jihouti_n.gif"
			alt="������" name="jihouti" onMouseOver="MouseOver('jihouti','tab/jihouti_o.gif');" onMouseOut="MouseOut('jihouti','tab/jihouti_n.gif');" border="0" onClick="ChangeTab(1)" style="vertical-align:bottom;"><img src="tab/ox_n.gif" name="ox" onMouseOver="MouseOver('ox','tab/ox_o.gif');" onMouseOut="MouseOut('ox','tab/ox_n.gif');" border="0" 
			alt="�����إ���������ȷ��������" onClick="ChangeTab(2)" style="vertical-align:bottom;"><img src="tab/itiran.gif" name="itiran" border="0" 
			alt="¬��ɰ���" style="vertical-align:bottom;"><img src="tab/haitizu_n.gif" name="haitizu" onMouseOver="MouseOver('haitizu','tab/haitizu_o.gif');" onMouseOut="MouseOut('haitizu','tab/haitizu_n.gif');" border="0" 
			alt="¬������ֿ�" onClick="ChangeTab(4)" style="vertical-align:bottom;"><img src="tab/kensaku_n.gif" name="kensaku" onMouseOver="MouseOver('kensaku','tab/kensaku_o.gif');" onMouseOut="MouseOut('kensaku','tab/kensaku_n.gif');" border="0" 
			alt="¬��ɸ���" onClick="ChangeTab(5)" style="vertical-align:bottom;"><img src="tab/syusyu_n.gif" name="syusyu" onMouseOver="MouseOver('syusyu','tab/syusyu_o.gif');" onMouseOut="MouseOut('syusyu','tab/syusyu_n.gif');" border="0" 
			alt="�ǡ�����������" onClick="ChangeTab(6)" style="vertical-align:bottom;"><img src="tab/kokusetu_n.gif" name="kokusetu" onMouseOver="MouseOver('kokusetu','tab/kokusetu_o.gif');" onMouseOut="MouseOut('kokusetu','tab/kokusetu_n.gif');" border="0"
			alt="���߶�" onClick="ChangeTab(9)" style="vertical-align:bottom;"><img src="tab/toiawase_n.gif" name="toiawase" onMouseOver="MouseOver('toiawase','tab/toiawase_o.gif');" onMouseOut="MouseOut('toiawase','tab/toiawase_n.gif');" border="0"
			alt="���䤤��碌" onClick="ChangeTab(7)" style="vertical-align:bottom;"><img src="tab/right.gif" height="33" width="45" alt="right" style="vertical-align:bottom;">
		</td>
	</tr>
	<tr class="tab_back">
		<td valign="top">
		<br>
			<table border="0" width="100%">
				<tr>
					<!--��˥塼-->
					<td valign="top">
						<table border="0">
							<tr>
								<td valign="top" colspan="2">
									<table class="DataKoumoku">
										<tr>
											<td class="DatakoumokuItem">��ƻ�ܸ�</td>
											<td align="center">
												<select name="ListPref" onChange="ReLoadWin()">
												<option value="0" selected>---��ƻ�ܸ�����---</option>
													<option value="01">�̳�ƻ</option><option value="02">�Ŀ���</option><option value="03">��긩</option><option value="04">�ܾ븩</option><option value="05">���ĸ�</option><option value="06">������</option><option value="07">ʡ�縩</option><option value="08">��븩</option><option value="09">���ڸ�</option><option value="10">���ϸ�</option><option value="11">��̸�</option><option value="12">���ո�</option><option value="13">�����</option><option value="14">�����</option><option value="15">���㸩</option><option value="16">�ٻ���</option><option value="17">���</option><option value="18">ʡ�温</option><option value="19">������</option><option value="20">Ĺ�</option><option value="21">���츩</option><option value="22">�Ų���</option><option value="23">���θ�</option><option value="24">���Ÿ�</option><option value="25">���츩</option><option value="26">������</option><option value="27">�����</option><option value="28">ʼ�˸�</option><option value="29">���ɸ�</option><option value="30">�²λ���</option><option value="31">Ļ�踩</option><option value="32">�纬��</option><option value="33">������</option><option value="34">���縩</option><option value="35">������</option><option value="36">���縩</option><option value="37">���</option><option value="38">��ɲ��</option><option value="39">���θ�</option><option value="40">ʡ����</option><option value="41">���츩</option><option value="42">Ĺ�긩</option><option value="43">���ܸ�</option><option value="44">��ʬ��</option><option value="45">�ܺ긩</option><option value="46">�����縩</option><option value="47">���츩</option>												</select>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class="HyouMapArea">
									<iframe src="MstItiranFrame.php" name="Map_iframe" width="990" height="450" frameborder="0" scrolling="AUTO"></iframe>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td></tr></table>
</form>
</div>
</body>
</html>

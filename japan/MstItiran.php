<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<title>大気汚染物質広域監視システム（そらまめ君）ホームページ</title>
<link rel="stylesheet" media="all" href="Styles.css" type="text/css">
<script language="javascript" src="JScript1.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
<!--
function ChangePG(){
		//日時のチェック
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
						<a href="Index.php"><img src="Logo/top.gif" name="top" onMouseOver="MouseOver('top','Logo/top2.gif');" onMouseOut="MouseOut('top','Logo/top.gif');" border="0" alt="トップ"></a><a href="Help.html"><img src="Logo/help.gif" name="help" 
						onMouseOver="MouseOver('help','Logo/help2.gif');" onMouseOut="MouseOut('help','Logo/help.gif');" border="0"alt="操作説明"></a><a href="kouji.php"><img src="Logo/kouji_menu.gif"
						alt="工事情報" name="koji" width="102" height="25" border="0" onMouseOver="MouseOver('koji','Logo/kouji_menu2.gif');" onMouseOut="MouseOut('koji','Logo/kouji_menu.gif');"></a><a href="index/index2.html"><img src="Logo/setumei_menu.gif" 
						alt="説明のページ" name="setumei" width="121" height="25" border="0" onMouseOver="MouseOver('setumei','Logo/setumei_menu2.gif');" onMouseOut="MouseOut('setumei','Logo/setumei_menu.gif');"></a><a href="http://sora.taiki.go.jp/"><img src="Logo/keitai_menu.gif"
						alt="携帯サイト" name="keitai" width="107" height="25" border="0" onMouseOver="MouseOver('keitai','Logo/keitai_menu2.gif');" onMouseOut="MouseOut('keitai','Logo/keitai_menu.gif');"></a><a href="link.html"><img src="Logo/rink.gif"
						alt="リンク" name="rink" width="76" height="25" border="0" onMouseOver="MouseOver('rink','Logo/rink2.gif');" onMouseOut="MouseOut('rink','Logo/rink.gif');"></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="tab/left.gif" style="vertical-align:bottom;" alt="left"><img src="tab/jihouti_n.gif"
			alt="時報値" name="jihouti" onMouseOver="MouseOver('jihouti','tab/jihouti_o.gif');" onMouseOut="MouseOut('jihouti','tab/jihouti_n.gif');" border="0" onClick="ChangeTab(1)" style="vertical-align:bottom;"><img src="tab/ox_n.gif" name="ox" onMouseOver="MouseOver('ox','tab/ox_o.gif');" onMouseOut="MouseOut('ox','tab/ox_n.gif');" border="0" 
			alt="光化学オキシダント警報・注意報" onClick="ChangeTab(2)" style="vertical-align:bottom;"><img src="tab/itiran.gif" name="itiran" border="0" 
			alt="測定局一覧" style="vertical-align:bottom;"><img src="tab/haitizu_n.gif" name="haitizu" onMouseOver="MouseOver('haitizu','tab/haitizu_o.gif');" onMouseOut="MouseOut('haitizu','tab/haitizu_n.gif');" border="0" 
			alt="測定局配置図" onClick="ChangeTab(4)" style="vertical-align:bottom;"><img src="tab/kensaku_n.gif" name="kensaku" onMouseOver="MouseOver('kensaku','tab/kensaku_o.gif');" onMouseOut="MouseOut('kensaku','tab/kensaku_n.gif');" border="0" 
			alt="測定局検索" onClick="ChangeTab(5)" style="vertical-align:bottom;"><img src="tab/syusyu_n.gif" name="syusyu" onMouseOver="MouseOver('syusyu','tab/syusyu_o.gif');" onMouseOut="MouseOut('syusyu','tab/syusyu_n.gif');" border="0" 
			alt="データ収集状況" onClick="ChangeTab(6)" style="vertical-align:bottom;"><img src="tab/kokusetu_n.gif" name="kokusetu" onMouseOver="MouseOver('kokusetu','tab/kokusetu_o.gif');" onMouseOut="MouseOut('kokusetu','tab/kokusetu_n.gif');" border="0"
			alt="国設局" onClick="ChangeTab(9)" style="vertical-align:bottom;"><img src="tab/toiawase_n.gif" name="toiawase" onMouseOver="MouseOver('toiawase','tab/toiawase_o.gif');" onMouseOut="MouseOut('toiawase','tab/toiawase_n.gif');" border="0"
			alt="お問い合わせ" onClick="ChangeTab(7)" style="vertical-align:bottom;"><img src="tab/right.gif" height="33" width="45" alt="right" style="vertical-align:bottom;">
		</td>
	</tr>
	<tr class="tab_back">
		<td valign="top">
		<br>
			<table border="0" width="100%">
				<tr>
					<!--メニュー-->
					<td valign="top">
						<table border="0">
							<tr>
								<td valign="top" colspan="2">
									<table class="DataKoumoku">
										<tr>
											<td class="DatakoumokuItem">都道府県</td>
											<td align="center">
												<select name="ListPref" onChange="ReLoadWin()">
												<option value="0" selected>---都道府県選択---</option>
													<option value="01">北海道</option><option value="02">青森県</option><option value="03">岩手県</option><option value="04">宮城県</option><option value="05">秋田県</option><option value="06">山形県</option><option value="07">福島県</option><option value="08">茨城県</option><option value="09">栃木県</option><option value="10">群馬県</option><option value="11">埼玉県</option><option value="12">千葉県</option><option value="13">東京都</option><option value="14">神奈川県</option><option value="15">新潟県</option><option value="16">富山県</option><option value="17">石川県</option><option value="18">福井県</option><option value="19">山梨県</option><option value="20">長野県</option><option value="21">岐阜県</option><option value="22">静岡県</option><option value="23">愛知県</option><option value="24">三重県</option><option value="25">滋賀県</option><option value="26">京都府</option><option value="27">大阪府</option><option value="28">兵庫県</option><option value="29">奈良県</option><option value="30">和歌山県</option><option value="31">鳥取県</option><option value="32">島根県</option><option value="33">岡山県</option><option value="34">広島県</option><option value="35">山口県</option><option value="36">徳島県</option><option value="37">香川県</option><option value="38">愛媛県</option><option value="39">高知県</option><option value="40">福岡県</option><option value="41">佐賀県</option><option value="42">長崎県</option><option value="43">熊本県</option><option value="44">大分県</option><option value="45">宮崎県</option><option value="46">鹿児島県</option><option value="47">沖縄県</option>												</select>
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

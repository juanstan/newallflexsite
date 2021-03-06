<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
	<tr>
		<td>
			{!! HTML::image('/images/SureSense-logo2.png', 'SureSense') !!}
		</td>
	</tr>
	<tr>
		<td>
			{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'30px', 'style'=>'border:0;border-style: none;')) !!}
		</td>
	</tr>
	<tr>
		<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
				<tr>
					<td align="center">
						<span style="color:#7c95a1;font-family:Helvetica, Arial,sans-serif;font-size:18px;">Password reset</span>
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#7c95a1;font-family:Helvetica, Arial,sans-serif;font-size:14px;">Click the link below and follow the instructions on screen</span>
					</td>
				</tr>
				<tr>
					<td>
						{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'5px', 'style'=>'border:0;border-style: none;')) !!}
					</td>
				</tr>
				<tr>
					<td align="center">
						<!--[if mso]>
						<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{!! URL::to('user/password/reset', array($token)) !!}" style="height:36px;v-text-anchor:middle;width:150px;" arcsize="10%" strokecolor="#3fc6c4" fillcolor="#3fc6c4">
							<w:anchorlock/>
							<center style="color:#ffffff;font-family:Helvetica, Arial,sans-serif;font-size:16px;">Reset password</center>
						</v:roundrect>
						<![endif]-->
						<a href="{!! URL::to('user/password/reset', array($token)) !!}" style="background-color:#3fc6c4;border:1px solid #3fc6c4;border-radius:5px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;mso-hide:all;">Reset password</a>
					</td>
				</tr>
				<tr>
					<td>
						{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'2px', 'style'=>'border:0;border-style: none;')) !!}
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#8a8a8a;font-family:Helvetica, Arial,sans-serif;font-size:12px;">or copy and paste this URL into our browser</span>
					</td>
				</tr>
				<tr>
					<td  align="center">
						<a style="color:#61cecd;font-family:Helvetica, Arial,sans-serif;font-size:14px;" href="{!! URL::to('user/password/reset', array($token)) !!}">{!! URL::to('user/password/reset', array($token)) !!}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
				<tr>
					<td>
						{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'50px', 'style'=>'border:0;border-style: none;')) !!}
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#a9b8c0;font-family:Helvetica, Arial,sans-serif;font-size:14px;">Over and Meeowt,</span>
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#a9b8c0;font-family:Helvetica, Arial,sans-serif;font-size:14px;">The SureFlap team.</span>
					</td>
				</tr>
				<tr>
					<td>
						{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'15px', 'style'=>'border:0;border-style: none;')) !!}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<div style="width:100%;max-height:0;height:0;border-top:1px solid #cbd5d9">&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
				<tr>
					<td>
						{!! HTML::image('/images/transparent.png', '', array('width'=>1, 'height'=>'5px', 'style'=>'border:0;border-style: none;')) !!}
					</td>
				</tr>
				<tr>
					<td align="center">
						<a style="color:#61cecd;font-family:Helvetica, Arial,sans-serif;font-size:14px;" href="javascript:mailto('support@sureflap.com')">support@sureflap.com</a>
						<span style="color:#637e90">.08000124511</span>
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#a9b8c0;font-family:Helvetica, Arial,sans-serif;font-size:12px;">SureFlap Limited, 7 The Irwin Center, Scotland Road,</span>
					</td>
				</tr>
				<tr>
					<td align="center">
						<span style="color:#a9b8c0;font-family:Helvetica, Arial,sans-serif;font-size:12px;">Dry Drayton, Cambridge CB23 8AR, United Kingdom</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
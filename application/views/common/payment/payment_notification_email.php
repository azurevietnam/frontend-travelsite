<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Thank you - Best Price Vietnam</title>
<style type="text/css">
/* Based on The MailChimp Reset INLINE: Yes. */
/* Client-specific Styles */
#outlook a {
	padding: 0;
} /* Force Outlook to provide a "view in browser" menu link. */
body {
	width: 100% !important;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
	margin: 0;
	padding: 0;
	font-family: Arial;
	font-size: 12px;
	background-color: #F5F5F5
}
/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/
.ExternalClass {
	width: 100%;
} /* Force Hotmail to display emails at full width */
.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div
	{
	line-height: 100%;
}
/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
#backgroundTable {
	margin: 0 auto;
	padding: 0;
	width: 680px !important;
	line-height: 100% !important;
}
/* End reset */

/* Some sensible defaults for images
		Bring inline: Yes. */
img {
	outline: none;
	text-decoration: none;
	-ms-interpolation-mode: bicubic;
}

a img {
	border: none;
}

.image_fix {
	display: block;
}

/* Yahoo paragraph fix
		Bring inline: Yes. */
p {
	margin: 1em 0;
}

/* Hotmail header color reset
		Bring inline: Yes. */
h1,h2,h3,h4,h5,h6 {
	color: black !important;
}

h1 a,h2 a,h3 a,h4 a,h5 a,h6 a {
	color: blue !important;
}

h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active
	{
	color: red !important;
	/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
}

h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited
	{
	color: purple !important;
	/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
}

/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
table td {
	border-collapse: collapse;
}

/* Remove spacing around Outlook 07, 10 tables
		Bring inline: Yes */
table {
	border-collapse: collapse;
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
}

a {
	text-decoration: none;
	color: #3385D6;
}
</style>

</head>
<body>
	<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="font: normal 13px Arial;">
		<tr>
			<td valign="top">
				
				<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
						style="border-spacing: 0px; border-collapse: collapse; margin: 20px 0 0 0">
					<tbody>
						<tr>
							<td align="left" style="line-height: 15px; padding: 20px 25px 22px 25px; color: #333">
								Dear Sale,
							</td>
						</tr>
						<tr>
							<td align="left" style="line-height: 15px; padding: 0px 25px 10px 25px">
								Your customer paid invoice successfully. To see details, please log in to your account at <a href="http://onepay.vn/invoice2">Onepay</a>
							</td>
						</tr>
						<tr>
							<td align="left" style="line-height: 15px; padding: 0px 25px 10px 25px">
								Invoice Reference: <?=$invoice['invoice_reference']?><br>
								Customer Name: <?=$invoice['customer']['full_name']?><br>
								Email: <?=$invoice['customer']['email']?>
							</td>
						</tr>
						<tr>
							<td align="left" style="line-height: 15px; padding: 0px 25px 10px 25px">
								Amount: USD<?=$invoice['amount']?><br>
								Card: <?=$response['card_num']?><br>
								Card Type: <?=$response['card_type']?><br>
								Invoice link: <?=site_url().'payment/invoice.html?ref='.$invoice['invoice_reference']?><br>
							</td>
						</tr>
						<tr>
							<td align="left" style="padding: 20px 25px 20px 25px; line-height: 18px">
								<label style="font-weight: bold; color: #333">Best Price Vietnam., JSC</label><br>
								<p>
								Head Office: 12A, Ba Trieu Alley, Ba Trieu Street, Hai Ba Trung District, Hanoi, Vietnam.<br>
								Email: <a target="_blank" href="mailto:sales@bestpricevn.com">sales@bestpricevn.com</a><br>	
								Phone: +84 436-249-007 or +84 904-699-428<br>
								Website: <a href="<?=site_url()?>">http://www.<?=strtolower(SITE_NAME)?></a><br>
								</p>
							</td>
						</tr>
					</tbody>
				</table>

			</td>
		</tr>
	</table>
	<!-- End of wrapper table -->
</body>
</html>
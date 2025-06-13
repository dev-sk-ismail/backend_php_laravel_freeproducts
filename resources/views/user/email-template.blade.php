	<!DOCTYPE html>
	<html>

	<head>
		<title>The Last Coat - Free Product Promotion</title>
	</head>

	<body style="margin:0; padding: 0;">
		<table style="width:600px; border-collapse: collapse;border:none;outline:0;text-align:center; margin:0 auto;" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td style="width: 100%; background-color: rgba(0, 0, 0, 0.68); padding: 20px 0 20px 30px; text-align: center;" colspan="3">
						<a href="#" target="_blank"><img src="https://www.getfreetlc.com/images/logo.png" alt=""></a>
					</td>
				</tr>
			</thead>
			<tbody style="width: 100%; background:#f6f6f6;">
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px; width:30%;"><strong>Name </strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width:60%;line-height: 28px;">{{$userData["name"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width: 30%;"><strong>Address Line 1</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width:60%;line-height: 28px;">{{$userData["address"]}}</td>

				</tr>


				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width: 30%;"><strong>Email</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width: 60%;line-height: 28px;">{{ $userData["email"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width: 30%;"><strong>Phone</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width:60%;line-height: 28px;">{{$userData["phone"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width:30%;"><strong>City</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width: 60%;line-height: 28px;">{{$userData["city"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width: 30%;"><strong>State Or Region</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width:60%;line-height: 28px;">{{ $userData["state"] }}</td>

				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 0 30px;width: 30%;"><strong>Country Code</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 0 30px;width:60%;line-height: 28px;">{{ $userData["country"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 20px 30px;width:30%;"><strong>Zip Code</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 20px 30px;width:60%;line-height: 28px;">{{ $userData["zip_code"]}}</td>
				</tr>
				<tr style="font-family: Arial,Times New Roman,serif;text-align: left; font-size:18px; color: #000;">
					<td style="padding: 20px 10px 20px 30px;width:30%;"><strong>Amazon Order ID</strong></td>
					<td style="padding: 20px 10px 0 30px;width:5%">:</td>
					<td style="padding: 20px 10px 20px 30px;width:60%;line-height: 28px;">{{Session::get('amazon_order_id')}}</td>
				</tr>
				<tr>
					<td style="width: 100%; background-color: rgba(0, 0, 0, 0.68); padding:7px 0; text-align: center;font-family: Arial,Times,Times New Roman,serif;" colspan="3">
						<p style="margin: 0;text-align: center;color: #fff;font-size: 14px;">Copyright 2019 - The Last Coat - All Rights Reserved.</p>
					</td>
				</tr>
			</tbody>
		</table>
	</body>

	</html>
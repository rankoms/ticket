<table>
	<tr>
		<td colspan="4" style="text-align: center;background-color: yellow">Laporan Scanner Event ({{ $event }})</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center; background-color: red">Ticket Not Valid</td>
		<td colspan="2" style="text-align: center; background-color: red">{{ $ticket_not_valid }}</td>
	</tr>
</table>
<table>
	<tr>
		<th></th>
		<th>Pending</th>
		<th>Checkin</th>
		<th>Checkout</th>
	</tr>
	<tr>
		<td style="background-color: #C4D79B">TOTAL</td>
		<td style="background-color: #C4D79B">{{ $jumlah_pending }}</td>
		<td style="background-color: #C4D79B">{{ $jumlah_checkin }}</td>
		<td style="background-color: #C4D79B">{{ $jumlah_checkout }}</td>
	</tr>
</table>

<table>
	<thead>

		<tr>
			<th style="background-color: #BFBFBF">Category</th>
			<th style="background-color: #BFBFBF">Pending</th>
			<th style="background-color: #BFBFBF">Checkin</th>
			<th style="background-color: #BFBFBF">Checkout</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($kategory_aset as $key => $value)
			<tr>
				<th>{{ $key }}</th>
				<th>{{ isset($value['pending']) ? $value['pending'] : 0 }}</th>
				<th>{{ isset($value['checkin']) ? $value['checkin'] : 0 }}</th>
				<th>{{ isset($value['checkout']) ? $value['checkout'] : 0 }}</th>
			</tr>
		@endforeach
	</tbody>
</table>

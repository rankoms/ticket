<table>
	<tr>
		<td colspan="4" style="text-align: center;background-color: yellow">Laporan Redeem Voucher</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center; background-color: red">Redeem Not Valid</td>
		<td colspan="2" style="text-align: center; background-color: red">{{ $redeem_not_valid }}</td>
	</tr>
</table>
<table>
	<tr>
		<th></th>
		<th>Redeem</th>
		<th>Pending</th>
	</tr>
	<tr>
		<td style="background-color: #C4D79B">TOTAL</td>
		<td style="background-color: #C4D79B">{{ $jumlah_sudah }}</td>
		<td style="background-color: #C4D79B">{{ $jumlah_belum }}</td>
	</tr>
</table>

<table>
	<thead>

		<tr>
			<th style="background-color: #BFBFBF">Category</th>
			<th style="background-color: #BFBFBF">Redeem</th>
			<th style="background-color: #BFBFBF">Pending</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($kategory_aset as $key => $value)
			<tr>
				<th>{{ $key }}</th>
				<th>{{ isset($value['sudah']) ? $value['sudah'] : 0 }}</th>
				<th>{{ isset($value['belum']) ? $value['belum'] : 0 }}</th>
			</tr>
		@endforeach
	</tbody>
</table>

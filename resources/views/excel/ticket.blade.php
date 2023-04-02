<table>
	<thead>

		<tr>
			<th>Kategory</th>
			<th>Pending</th>
			<th>Checkin</th>
			<th>Checkout</th>
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

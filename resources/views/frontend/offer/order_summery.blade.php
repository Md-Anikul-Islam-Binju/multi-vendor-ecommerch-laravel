<thead>
	<tr>
		<th class="text-left name" colspan="2">Offer Name</th>
		<th class="text-right">Price</th>
	</tr>
</thead>
<tbody>
	<?php $total = $offer->discount; ?>
    
	<tr id='offerItem{{$offer->id}}'>
		<td class="text-left name"  colspan="2"> <a href="{{route('offer.details', $offer->slug)}}"><img width="50" src="{{asset('upload/images/offer/thumbnail/'.$offer->thumbnail)}}" class="img-thumbnail"> {{Str::limit($offer->title, 50)}}</a> </td>

		<td class="text-right">{{Config::get('siteSetting.currency_symble')}}<span class="amount">{{$total}}</span></td>
	</tr>
	
</tbody>
<tfoot>
		
		<tr>
		<td colspan="2" class="text-right"><strong>Total:</strong></td>
		<td class="text-right">{{Config::get('siteSetting.currency_symble')}}<span>{{ $total }}</td>
		</tr>
</tfoot>
